<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstagioRequest extends FormRequest
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
            'numero_usp' => 'required|numeric|codpes|graduacao',
            'tipoestagio' => 'required|max:255',
            'valorbolsa' => 'required_if:tipoestagio,==,Obrigatório Remunerado,Não-obrigatório Remunerado',
            'tipobolsa' => 'required_if:tipoestagio,==,Obrigatório Remunerado,Não-obrigatório Remunerado',
            'data_inicial' => 'required|data',
            'data_final' => 'required|data',
            // A carga horária (semanal e diária) é calculada a partir da grade de horários
            // por dia da semana (campo "horarios"), conferida manualmente no controller.
            'horario' => 'nullable',
            'auxiliotransporte' => 'required|max:255',
            'especifiquevt' => 'required|max:255',
            'seguradora' => 'required|max:255',
            'numseguro' => 'required|max:255',
            'departamento' => 'required|max:255',
            'atividades' => 'required',

            //campos opcionais
            'justificativa' => 'nullable',

            //empresa
            'cnpj' => 'required|max:255|exists:empresas,cnpj',
            'nome_de_contato' => 'required|max:255',
            'email_de_contato' => 'required|email|max:255',
            'telefone_de_contato' => 'required|max:255',
            'nome_do_supervisor_estagio' => 'required|max:255',
            'cargo_do_supervisor_estagio' => 'required|max:255',
            'telefone_do_supervisor_estagio' => 'required|max:255',
            'email_do_supervisor_estagio' => 'required|email|max:255',

            //
            'horariocompativel' => 'nullable',
        ];

        // Grade de horários por dia da semana: entrada, saída e tempo de intervalo
        foreach (array_keys((new \App\Models\Estagio)->diasSemanaOptions()) as $dia) {
            $rules["horarios.{$dia}.entrada"] = 'nullable|date_format:H:i';
            $rules["horarios.{$dia}.saida"] = 'nullable|date_format:H:i';
            $rules["horarios.{$dia}.intervalo"] = 'nullable|date_format:H:i';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cnpj' => auth()->user()->cnpj,
        ]);
    }

    public function messages()
    {
        return [
            'cnpj.required' => 'Atualize o cadastro da empresa antes de executar essa ação',
            'cnpj.exists' => 'Atualize o cadastro da empresa antes de executar essa ação',
        ];
    }
}
