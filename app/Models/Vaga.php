<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\User;

class Vaga extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

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
