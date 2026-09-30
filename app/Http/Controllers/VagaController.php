<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VagaRequest;
use App\Models\Vaga;
use App\Models\EstagioHorario;
use Auth;
use Illuminate\Support\Facades\Gate;

class VagaController extends Controller
{
    public function index(Request $request){
        $this->authorize('logado');
        if ( Gate::allows('admin') ) {
            $vagas = Vaga::where('status','Em análise')
                ->orWhere('status','Reprovada')
                ->orderBy('status', 'desc')->paginate(10);
        } else {
            $vagas = Vaga::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('vagas.index')->with([
            'vagas' => $vagas,
        ]);
    }

    public function show(Vaga $vaga){
        return view('vagas.show')->with('vaga', $vaga);
    }

    public function create(){
        $this->authorize('logado');
        return view('vagas.create')->with('vaga',new Vaga);
    }

    public function store(VagaRequest $request){
        $this->authorize('logado');
        $validated = $request->validated();

        $erro = $this->validarESetarCargaHoraria($request, $validated);
        if ($erro) {
            request()->session()->flash('alert-danger', $erro);
            return redirect("vagas/create")->withInput();
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = 'Em análise';
        $vaga = Vaga::create($validated);
        return redirect ("vagas/{$vaga->id}");
    }

    public function edit(Vaga $vaga) {
        $this->authorize('owner',$vaga);
        return view('/vagas.edit')-> with('vaga', $vaga);
    }

    public function update(VagaRequest $request, Vaga $vaga){
        $this->authorize('owner',$vaga);
        $validated = $request->validated();

        $erro = $this->validarESetarCargaHoraria($request, $validated);
        if ($erro) {
            request()->session()->flash('alert-danger', $erro);
            return redirect("vagas/{$vaga->id}/edit")->withInput();
        }

        # quando houver edição, volta para análise
        $validated['status'] = 'Em análise';
        $vaga->update($validated);
        return redirect("/vagas/{$vaga->id}");
    }

    /**
     * Valida o horário (entrada/saída/tempo de intervalo) informado e, se válido,
     * calcula e grava a carga horária semanal (expediente) em $validated.
     *
     * Assume-se semana padrão de 5 dias úteis (segunda a sexta) para o cálculo semanal,
     * já que a vaga não detalha o horário por dia da semana.
     *
     * @return string|null mensagem de erro, ou null se válido
     */
    private function validarESetarCargaHoraria(Request $request, array &$validated)
    {
        // Verificação de vagas do curso de Educomunicação - 8h diárias / 40 horas semanais
        $limiteDiarioMinutos = ($request->curso == 'Curso de Educomunicação') ? 8 * 60 : 6 * 60;
        $limiteSemanalMinutos = ($request->curso == 'Curso de Educomunicação') ? 40 * 60 : 30 * 60;

        $totalDiarioMinutos = EstagioHorario::calcularTotalMinutos($request->hora_entrada, $request->hora_saida, $request->tempo_intervalo);

        if ($totalDiarioMinutos === null || $totalDiarioMinutos <= 0) {
            return 'Verifique o horário do estágio: a saída, descontado o tempo de intervalo, deve ser maior que a entrada.';
        }

        if ($totalDiarioMinutos > $limiteDiarioMinutos) {
            $limiteHoras = intdiv($limiteDiarioMinutos, 60);
            return "Carga Horária do Estágio não pode ser maior que {$limiteHoras} horas diárias!";
        }

        $totalSemanalMinutos = $totalDiarioMinutos * 5;
        if ($totalSemanalMinutos > $limiteSemanalMinutos) {
            $limiteHoras = intdiv($limiteSemanalMinutos, 60);
            return "Carga Horária do Estágio não pode ser maior que {$limiteHoras} horas semanais!";
        }

        $validated['expediente'] = rtrim(rtrim(number_format($totalSemanalMinutos / 60, 2, '.', ''), '0'), '.');

        return null;
    }

    public function destroy(Vaga $vaga){
        # PRECISAMOS ARRUMAR
        if ( Gate::allows('empresa',$vaga->cnpj) | Gate::allows('admin') ) {
            $vaga->delete();
            return redirect('/');
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
    }

    public function status(Request $request, Vaga $vaga){
        $this->authorize('admin');

        if($request->status == 'Aprovada') {
            $vaga->status = 'Aprovada';
            $vaga->justificativa = null;
        }

        if($request->status == 'Reprovada') {
            $request->validate([
                'justificativa' => 'required|string',
            ], [
                'justificativa.required' => 'É necessário informar a justificativa da reprovação.',
            ]);
            $vaga->status = 'Reprovada';
            $vaga->justificativa = $request->justificativa;
        }

        $vaga->save();
        return redirect()->route('vagas.show', [$vaga]);
    }
}