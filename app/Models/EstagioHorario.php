<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estagio;

class EstagioHorario extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function estagio()
    {
        return $this->belongsTo(Estagio::class);
    }

    /* Total trabalhado no dia (saída - entrada - intervalo), em minutos. */
    public static function calcularTotalMinutos($entrada, $saida, $intervalo = null)
    {
        if (empty($entrada) || empty($saida)) {
            return null;
        }

        $paraMinutos = function ($hora) {
            [$h, $m] = explode(':', $hora);
            return ((int) $h) * 60 + (int) $m;
        };

        $total = $paraMinutos($saida) - $paraMinutos($entrada);
        if (!empty($intervalo)) {
            $total -= $paraMinutos($intervalo);
        }

        return $total;
    }

    public function getTotalMinutosAttribute()
    {
        return self::calcularTotalMinutos($this->hora_entrada, $this->hora_saida, $this->tempo_intervalo);
    }

    public function getTotalAttribute()
    {
        $minutos = $this->total_minutos;
        if ($minutos === null) {
            return null;
        }
        return sprintf('%02d:%02d', intdiv($minutos, 60), $minutos % 60);
    }

    // Limites legais de carga horária do estágio, válidos para todos os cursos/departamentos
    const LIMITE_DIARIO_MINUTOS = 6 * 60;
    const LIMITE_SEMANAL_MINUTOS = 30 * 60;

    // Formas de preenchimento da carga horária no formulário do estágio
    const TIPO_HORARIO_PADRAO = 'padrao';   // mesmo horário todos os dias (segunda a sexta)
    const TIPO_HORARIO_POR_DIA = 'por_dia'; // horário detalhado por dia da semana

    // Dias aos quais o horário padrão (mesmo horário todos os dias) se aplica
    const DIAS_HORARIO_PADRAO = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];

    /**
     * Processa a carga horária enviada pelo formulário do estágio, em qualquer uma das
     * duas formas de preenchimento (horário padrão ou detalhado por dia).
     *
     * Remove de $validated os campos auxiliares (tipo_horario, horario_padrao, horarios) e,
     * se válido, grava em $validated a carga horária semanal e diária calculada.
     *
     * @return array{erro: ?string, linhas?: array} linhas a serem gravadas em estagio_horarios
     */
    public static function processarFormulario(array &$validated)
    {
        $tipo = $validated['tipo_horario'] ?? null;
        $padrao = $validated['horario_padrao'] ?? [];
        $porDia = $validated['horarios'] ?? [];
        unset($validated['tipo_horario'], $validated['horario_padrao'], $validated['horarios']);

        if ($tipo === self::TIPO_HORARIO_PADRAO) {
            if (empty($padrao['entrada']) || empty($padrao['saida'])) {
                return ['erro' => 'Informe a entrada e a saída do horário padrão (mesmo horário todos os dias).'];
            }
            $totalDia = self::calcularTotalMinutos($padrao['entrada'], $padrao['saida'], $padrao['intervalo'] ?? null);
            if ($totalDia <= 0) {
                return ['erro' => 'Verifique o horário padrão: a saída, descontado o intervalo, deve ser maior que a entrada.'];
            }
            if ($totalDia > self::LIMITE_DIARIO_MINUTOS) {
                return ['erro' => 'A carga horária diária do horário padrão não pode ser maior que 6 horas!'];
            }
            $horarios = [];
            foreach (self::DIAS_HORARIO_PADRAO as $dia) {
                $horarios[$dia] = [
                    'entrada' => $padrao['entrada'],
                    'saida' => $padrao['saida'],
                    'intervalo' => $padrao['intervalo'] ?? null,
                ];
            }
        } elseif ($tipo === self::TIPO_HORARIO_POR_DIA) {
            $horarios = $porDia;
        } else {
            return ['erro' => 'Escolha uma das formas de preenchimento da carga horária: mesmo horário todos os dias ou horário detalhado por dia.'];
        }

        $resultado = self::processarGrade($horarios);
        if ($resultado['erro']) {
            return $resultado;
        }

        $validated['cargahoras'] = intdiv($resultado['totalSemanalMinutos'], 60);
        $validated['cargaminutos'] = $resultado['totalSemanalMinutos'] % 60;
        $validated['cargahorasdiaria'] = intdiv($resultado['maiorDiaMinutos'], 60);
        $validated['cargaminutosdiaria'] = $resultado['maiorDiaMinutos'] % 60;

        return ['erro' => null, 'linhas' => $resultado['linhas']];
    }

    /**
     * Valida e totaliza a grade de horários por dia da semana submetida no formulário.
     * Não depende de sessão/HTTP, para poder ser testado isoladamente.
     *
     * @param array $horarios   ex.: ['segunda' => ['entrada'=>'08:00','saida'=>'17:00','intervalo'=>'01:00'], ...]
     * @return array{erro: ?string, linhas?: array, totalSemanalMinutos?: int, maiorDiaMinutos?: int}
     */
    public static function processarGrade(array $horarios)
    {
        $totalSemanalMinutos = 0;
        $maiorDiaMinutos = 0;
        $linhas = [];

        foreach ((new Estagio)->diasSemanaOptions() as $dia => $label) {
            $diaHorarios = $horarios[$dia] ?? [];
            $entrada = $diaHorarios['entrada'] ?? null;
            $saida = $diaHorarios['saida'] ?? null;
            $intervalo = $diaHorarios['intervalo'] ?? null;

            if (empty($entrada) && empty($saida)) {
                continue;
            }
            if (empty($entrada) || empty($saida)) {
                return ['erro' => "Informe a entrada e a saída de {$label}."];
            }

            $totalDiaMinutos = self::calcularTotalMinutos($entrada, $saida, $intervalo);

            if ($totalDiaMinutos <= 0) {
                return ['erro' => "Verifique os horários de {$label}: a saída, descontado o intervalo, deve ser maior que a entrada."];
            }

            if ($totalDiaMinutos > self::LIMITE_DIARIO_MINUTOS) {
                return ['erro' => "A carga horária de {$label} não pode ser maior que 6 horas!"];
            }

            $totalSemanalMinutos += $totalDiaMinutos;
            $maiorDiaMinutos = max($maiorDiaMinutos, $totalDiaMinutos);
            $linhas[] = [
                'dia_semana' => $dia,
                'hora_entrada' => $entrada,
                'hora_saida' => $saida,
                'tempo_intervalo' => $intervalo ?: null,
            ];
        }

        if (empty($linhas)) {
            return ['erro' => 'Informe o horário do estágio em pelo menos um dia da semana.'];
        }

        if ($totalSemanalMinutos > self::LIMITE_SEMANAL_MINUTOS) {
            $limiteHoras = intdiv(self::LIMITE_SEMANAL_MINUTOS, 60);
            return ['erro' => "Carga Horária do Estágio não pode ser maior que {$limiteHoras} horas!"];
        }

        return [
            'erro' => null,
            'linhas' => $linhas,
            'totalSemanalMinutos' => $totalSemanalMinutos,
            'maiorDiaMinutos' => $maiorDiaMinutos,
        ];
    }
}
