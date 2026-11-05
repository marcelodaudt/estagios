<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Estagio;

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
            'tipoestagio' => ['required', 'max:255', Rule::in((new Estagio)->tipoestagioOptions())],
            'valorbolsa' => ['nullable', 'required_if:tipoestagio,Obrigatório Remunerado,Não Obrigatório Remunerado', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'tipobolsa' => 'required_if:tipoestagio,Obrigatório Remunerado,Não Obrigatório Remunerado',
            'modalidade_trabalho' => ['required', Rule::in((new Estagio)->modalidadeTrabalhoOptions())],
            'data_inicial' => 'required|data',
            'data_final' => 'required|data',
            // A carga horária (semanal e diária) é calculada a partir da grade de horários
            // por dia da semana (campo "horarios"), conferida manualmente no controller.
            'horario' => 'nullable',
            'auxiliotransporte' => ['required', 'max:255', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'especifiquevt' => 'required|max:255',
            'seguradora' => 'required|max:255',
            'numseguro' => 'required|max:255',
            'departamento' => 'required|max:255',
            'atividades' => 'required',

            //empresa
            'cnpj' => 'required|max:255|exists:empresas,cnpj',
            'nome_de_contato' => 'required|max:255',
            'email_de_contato' => 'required|email|max:255',
            'telefone_de_contato' => 'required|max:255',
            'nome_do_supervisor_estagio' => 'required|max:255',
            'cargo_do_supervisor_estagio' => 'required|max:255',
            'telefone_do_supervisor_estagio' => 'required|max:255',
            'email_do_supervisor_estagio' => 'required|email|max:255',
        ];

        // Forma de preenchimento da carga horária (obrigatória): horário padrão ou por dia
        $rules['tipo_horario'] = ['required', Rule::in([
            \App\Models\EstagioHorario::TIPO_HORARIO_PADRAO,
            \App\Models\EstagioHorario::TIPO_HORARIO_POR_DIA,
        ])];

        // Horário padrão (mesmo horário de segunda a sexta)
        $rules['horario_padrao.entrada'] = 'nullable|required_if:tipo_horario,padrao|date_format:H:i';
        $rules['horario_padrao.saida'] = 'nullable|required_if:tipo_horario,padrao|date_format:H:i';
        $rules['horario_padrao.intervalo'] = 'nullable|date_format:H:i';

        // Grade de horários por dia da semana: entrada, saída e tempo de intervalo
        foreach (array_keys((new \App\Models\Estagio)->diasSemanaOptions()) as $dia) {
            $rules["horarios.{$dia}.entrada"] = 'nullable|date_format:H:i';
            $rules["horarios.{$dia}.saida"] = 'nullable|date_format:H:i';
            $rules["horarios.{$dia}.intervalo"] = 'nullable|date_format:H:i';
        }

        return $rules;
    }

    /**
     * Antecedência mínima, em dias, entre a data de hoje e a data de início do estágio.
     */
    const ANTECEDENCIA_MINIMA_DIAS = 7;

    public static function dataInicialMinima()
    {
        return Carbon::today()->addDays(self::ANTECEDENCIA_MINIMA_DIAS);
    }

    /**
     * A data de início deve ser, no mínimo, hoje + 7 dias (sem datas retroativas).
     * Em estágios já cadastrados, a regra só é aplicada se a data de início for alterada,
     * para não impedir a edição de estágios que já começaram.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->has('data_inicial')) {
                return;
            }

            $dataInformada = $this->input('data_inicial');
            $estagio = $this->route('estagio');
            if ($estagio instanceof Estagio && $estagio->exists && $estagio->data_inicial === $dataInformada) {
                return;
            }

            try {
                $data = Carbon::createFromFormat('!d/m/Y', $dataInformada);
            } catch (\Exception $e) {
                return; // formato inválido já é tratado pela regra 'data'
            }

            $minima = self::dataInicialMinima();
            if ($data->lt($minima)) {
                $validator->errors()->add('data_inicial',
                    'A data de início do estágio deve ser a partir de ' . $minima->format('d/m/Y') .
                    ' (no mínimo ' . self::ANTECEDENCIA_MINIMA_DIAS . ' dias após a data de hoje). Não são aceitas datas retroativas.');
            }
        });
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
            'tipoestagio.in' => 'Selecione uma modalidade de estágio válida.',
            'modalidade_trabalho.required' => 'Selecione a modalidade de trabalho (Presencial, Home-office ou Híbrido).',
            'modalidade_trabalho.in' => 'Selecione uma modalidade de trabalho válida.',
            'tipo_horario.required' => 'Escolha uma das formas de preenchimento da carga horária: mesmo horário todos os dias ou horário detalhado por dia.',
            'horario_padrao.entrada.required_if' => 'Informe a entrada do horário padrão (mesmo horário todos os dias).',
            'horario_padrao.saida.required_if' => 'Informe a saída do horário padrão (mesmo horário todos os dias).',
            'valorbolsa.regex' => 'Informe o valor da bolsa no formato 0.000,00.',
            'auxiliotransporte.regex' => 'Informe o valor do auxílio transporte no formato 0.000,00.',
        ];
    }
}
