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
            //'valorbolsa' => 'required|max:255',
            //'tipobolsa' => 'required|max:255',
            'data_inicial' => 'required|data',
            'data_final' => 'required|data',
            'cargahoras' => 'required|max:255',
            'cargaminutos' => 'required|max:255',
            'horario' => 'required',
            'auxiliotransporte' => 'required|max:255',
            'especifiquevt' => 'required|max:255',
            //'seguradora' => 'required|max:255',
            //'numseguro' => 'required|max:255',
            'tipoestagio' => 'required|max:255',

            //campos opcionais
            'controlehorario' => 'nullable',
            'supervisao' => 'nullable',
            'interacao' => 'nullable',
            'enderecoedias' => 'nullable',
            'justificativa' => 'nullable',
            'atividades' => 'nullable',
            'valorbolsa' => 'nullable',
            'tipobolsa' => 'nullable',
            'seguradora' => 'nullable',
            'numseguro' => 'nullable',

            //pandemia
            'pandemiahomeoffice' => 'required|max:255',
            'pandemiamedidas' => 'required_if:pandemiahomeoffice,==,Não',

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

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cnpj'   => empty(auth()->user()->cnpj) ? $this->vaga->cnpj : auth()->user()->cnpj,
        ]);
    }

    public function messages()
    {
        return [
            'cnpj.exists' => 'Atualize o cadastro da empresa antes de executar essa ação',
        ];
    }
}
