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
