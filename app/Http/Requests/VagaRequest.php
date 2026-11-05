<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Vaga;

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
            'curso' => 'required|array|min:1',
            'curso.*' => ['required', Rule::in((new Vaga)->cursoOptions())],
            'contato' => '',
            'contato_nome' => 'nullable|string|max:255',
            'contato_email' => '',
            'contato_site' => '',
            'contato_telefone' => '',
            'descricao' => 'required',
            'requisitos' => 'required',
            // Carga horária semanal (expediente) é calculada automaticamente a partir de
            // hora_entrada/hora_saida/tempo_intervalo, conferida manualmente no controller.
            'expediente' => 'nullable',
            'salario' => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'hora_entrada' => 'required|date_format:H:i',
            'hora_saida' => 'required|date_format:H:i',
            'tempo_intervalo' => 'required|date_format:H:i',
            'beneficios' => 'required',
            'divulgar_ate' => 'required|data',
            'status' => ''
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'curso.required' => 'Selecione ao menos um curso.',
            'curso.min' => 'Selecione ao menos um curso.',
            'salario.regex' => 'Informe o valor mensal da bolsa no formato 0.000,00.',
        ];
    }
}
