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

    const LIMITE_DIARIO_MINUTOS = 6 * 60;

    /**
     * Valida e totaliza a grade de horários por dia da semana submetida no formulário.
     * Não depende de sessão/HTTP, para poder ser testado isoladamente.
     *
     * @param array $horarios   ex.: ['segunda' => ['entrada'=>'08:00','saida'=>'17:00','intervalo'=>'01:00'], ...]
     * @param int   $limiteSemanalMinutos
     * @return array{erro: ?string, linhas?: array, totalSemanalMinutos?: int, maiorDiaMinutos?: int}
     */
    public static function processarGrade(array $horarios, int $limiteSemanalMinutos)
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

        if ($totalSemanalMinutos > $limiteSemanalMinutos) {
            $limiteHoras = intdiv($limiteSemanalMinutos, 60);
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
