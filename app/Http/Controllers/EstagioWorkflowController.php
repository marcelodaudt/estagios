<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EstagioRequest;

use App\Estagio;
use Illuminate\Support\Facades\Gate;
use App\User;
use Uspdev\Replicado\Pessoa;
use Auth;
use App\Mail\enviar_para_analise_tecnica_mail;
use Illuminate\Support\Facades\Mail;

class EstagioWorkflowController extends Controller
{

    #Funções Análise Técnica

    public function enviar_para_analise_tecnica(EstagioRequest $request, Estagio $estagio){

        if ( Gate::allows('empresa',$estagio->cnpj) | Gate::allows('admin') ) {
            $validated = $request->validated();
            $estagio->update($validated);

            if($request->enviar_para_analise_tecnica=="enviar_para_analise_tecnica"){
                $workflow = $estagio->workflow_get();
                $workflow->apply($estagio,'enviar_para_analise_tecnica');
                $estagio->save();

                // Envio de email
                Mail::send(new enviar_para_analise_tecnica_mail($estagio));
            }
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }

        return redirect("/estagios/{$estagio->id}");
    }

    public function analise_tecnica(Request $request, Estagio $estagio){

        if (Gate::allows('admin')) {
            /* Quando indeferir, tornar obrigatório o campo analise_tecnica */
            if($request->analise_tecnica_action == 'indeferimento_analise_tecnica'){
                $request->validate([
                    'analise_tecnica' => 'required',
                ]);
            }

            $estagio->analise_tecnica = $request->analise_tecnica;
            $estagio->analise_tecnica_user_id = Auth::user()->numero_usp;
            $estagio->save();
            $workflow = $estagio->workflow_get();
            $workflow->apply($estagio,$request->analise_tecnica_action);
            $estagio->save();
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
        return redirect("/estagios/{$estagio->id}");
    }

    #Funções Análise Acadêmica

    public function analise_academica(Request $request, Estagio $estagio){

        if (Gate::allows('parecerista')) {

            $request->validate([
                'atividadespertinentes' => 'required',
                'desempenhoacademico' => 'required',
                'horariocompativel' => 'required',
                'mediaponderada' => 'required',
                'atividadesjustificativa'=> 'required',
                'analise_academica'=> 'required',
                'tipodeferimento'=> 'required',
                'condicaodeferimento'=> 'required_if:tipodeferimento,==,Deferido com Restrição'
            ]);
            $estagio->analise_academica = $request->analise_academica;
            $estagio->mediaponderada = $request->mediaponderada;
            $estagio->horariocompativel = $request->horariocompativel;
            $estagio->desempenhoacademico = $request->desempenhoacademico;
            $estagio->atividadespertinentes = $request->atividadespertinentes;
            $estagio->atividadesjustificativa = $request->atividadesjustificativa;
            $estagio->tipodeferimento = $request->tipodeferimento;
            $estagio->condicaodeferimento = $request->condicaodeferimento;
            $estagio->analise_academica_user_id = Auth::user()->id;
            $estagio->save();            
            $estagio->numparecerista = User::find($estagio->analise_academica_user_id)->codpes;
            $estagio->save();
            $workflow = $estagio->workflow_get();
            $workflow->apply($estagio,$request->analise_academica_action);
            $estagio->save();

        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
        return redirect("/estagios/{$estagio->id}");
    }

    public function editar_analise_academica(Request $request, Estagio $estagio){

        if (Gate::allows('parecerista')) {
                $workflow = $estagio->workflow_get();
                $workflow->apply($estagio,'editar_analise_academica');
                $estagio->save();
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }

        return redirect("/estagios/{$estagio->id}");
    }

    #Funções Concluido

    public function renovacao(Request $request, Estagio $estagio) {

        if ( Gate::allows('empresa',$estagio->cnpj) | Gate::allows('admin')) {

            $renovacao = $estagio->replicate();
            $renovacao->push();

            if(empty($estagio->renovacao_parent_id)){
                $renovacao->renovacao_parent_id = $estagio->id;
            }
            $estagio->analise_tecnica = null;
            $estagio->analise_academica = null;
            $estagio->analise_alteracao = null;
            $estagio->save();
            $workflow = $renovacao->workflow_get();
            $workflow->apply($renovacao,'renovacao');
            $renovacao->save();
            $estagio->save();
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
        return redirect("estagios/{$renovacao->id}");
    }

    public function rescisao(Request $request, Estagio $estagio){

        if ( Gate::allows('empresa',$estagio->cnpj) | Gate::allows('admin')) {

            $estagio->rescisao_motivo = $request->rescisao_motivo;
            $estagio->save();
            $workflow = $estagio->workflow_get();
            $workflow->apply($estagio,'rescisao_do_estagio');
            $estagio->save();
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
        return redirect("/estagios/{$estagio->id}");
    }

    public function iniciar_alteracao(Estagio $estagio) {

        if (Gate::allows('empresa',$estagio->cnpj)) {
            $workflow = $estagio->workflow_get();
            $workflow->apply($estagio,'iniciar_alteracao');
            $estagio->save();
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
        return redirect("estagios/{$estagio->id}");

    }

    #Funções Alteração

    public function enviar_alteracao(EstagioRequest $request, Estagio $estagio){

        if (Gate::allows('empresa',$estagio->cnpj)) {
            $validated = $request->validated();
            $estagio->update($validated);
            $estagio->alteracao = $request->alteracao;
            $estagio->save();

            if($request->enviar_analise_tecnica_alteracao == 'enviar_analise_tecnica_alteracao'){
                $estagio->alteracao = $request->alteracao;
                $estagio->save();
                $workflow = $estagio->workflow_get();
                $workflow->apply($estagio,'enviar_analise_tecnica_alteracao');
                $estagio->save();
            }
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
        return redirect("/estagios/{$estagio->id}");
    }

    #Funções Análise da Alteração

    public function analise_tecnica_alteracao(Request $request, Estagio $estagio){

        if (Gate::allows('admin')) {
            if($request->analise_tecnica_alteracao_action == 'indeferimento_analise_tecnica_alteracao'){
                $request->validate([
                    'analise_alteracao' => 'required',
                ]);
            }
            $estagio->analise_alteracao = $request->analise_alteracao;
            $estagio->analise_alteracao_user_id = Auth::user()->id;
            $estagio->save();
            $workflow = $estagio->workflow_get();
            $workflow->apply($estagio,$request->analise_tecnica_alteracao_action);
            $estagio->save();
        } else {
            request()->session()->flash('alert-danger', 'Sem permissão para executar ação');
        }
        return redirect("/estagios/{$estagio->id}");
    }

}
