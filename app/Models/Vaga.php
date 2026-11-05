<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\User;
use App\Models\EstagioHorario;

class Vaga extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'curso' => 'array',
    ];

    /* Cursos selecionados, separados por vírgula, para exibição */
    public function getCursosTextoAttribute() {
        return implode(', ', (array) $this->curso);
    }

    /* Valor da bolsa chega com máscara monetária (ex.: 1.500,00) e é salvo como decimal (ex.: 1500.00) */
    public function setSalarioAttribute($value) {
        $value = trim((string) $value);
        if (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', str_replace('.', '', $value));
        }
        $this->attributes['salario'] = is_numeric($value) ? number_format((float) $value, 2, '.', '') : $value;
    }

    /* Valor da bolsa formatado em reais (ex.: 1.500,00) */
    public function getSalarioFormatadoAttribute() {
        $valor = $this->salario;
        if ($valor === null || $valor === '') {
            return '';
        }
        return is_numeric($valor) ? number_format((float) $valor, 2, ',', '.') : $valor;
    }

    /* Carga horária diária (Saída - Entrada - Tempo de Intervalo), em minutos.
       Reaproveita o mesmo cálculo usado na grade de horários do Estágio. */
    public function getCargaHorariaDiariaMinutosAttribute() {
        return EstagioHorario::calcularTotalMinutos($this->hora_entrada, $this->hora_saida, $this->tempo_intervalo);
    }

    public function getCargaHorariaDiariaAttribute() {
        $minutos = $this->carga_horaria_diaria_minutos;
        if ($minutos === null) {
            return null;
        }
        return sprintf('%02d:%02d', intdiv($minutos, 60), $minutos % 60);
    }

    public function getDivulgarAteAttribute($value) {
        /* No banco está YYYY-MM-DD, mas vamos retornar DD/MM/YYYY */
        return implode('/',array_reverse(explode('-',$value)));
    }

    public function setDivulgarAteAttribute($value) {
        /* Chega no formato DD/MM/YYYY e vamos salvar como YYYY-MM-DD */
       $this->attributes['divulgar_ate'] = implode('-',array_reverse(explode('/',$value)));
    }

    public function statusOptions(){
        return [
            'Aprovada',
            'Reprovada',
            'Em análise'
        ];
    }

    public function cursoOptions(){
        return [
            'Curso de Artes Cênicas',
            'Curso de Artes Visuais',
            'Curso de Audiovisual',
            'Curso de Biblioteconomia',
            'Curso de Editoração',
            'Curso de Educomunicação',
            'Curso de Jornalismo',
            'Curso de Música',
            'Curso de Publicidade e Propaganda',
            'Curso de Relações Públicas',
            'Curso de Turismo'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
