<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VagaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'titulo' => 'required',
            'curso' => 'required',
            'contato' => '',
            'contato_email' => '',
            'contato_site' => '',
            'contato_telefone' => '',
            'descricao' => 'required',
            'requisitos' => 'required',
            // Carga horária semanal (expediente) é calculada automaticamente a partir de
            // hora_entrada/hora_saida/tempo_intervalo, conferida manualmente no controller.
            'expediente' => 'nullable',
            'salario' => 'required',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_saida' => 'required|date_format:H:i',
            'tempo_intervalo' => 'required|date_format:H:i',
            'beneficios' => 'required',
            'divulgar_ate' => 'required|data',
            'status' => ''
        ];
        return $rules;
    }
}
