@section('javascripts_head')
  <script src="{{asset('/js/estagios.js')}}"></script>
@endsection('javascript_head')

@extends('laravel-usp-theme::master')

@section('content')
@include('flash')

  <div class="card">
    <div class="card-header"><b>Status do Estágio</b></div>
      <div class="card-body">
        @include('estagios.etapas')
      </div>  
    </div>

<br>

  @can('empresa',$estagio->cnpj)
    @if($estagio->status == 'assinatura' | $estagio->status == 'concluido')
      <div class="card">
        <div class="card-header"><b>Gerar Documentos</b></div>
          <div class="card-body">
              @if(is_null($estagio->renovacao_parent_id))
                  <a href="{{ $app_url }}/pdfs/termo/{{$estagio->id}}.pdf" type="application/pdf" target="pdf-frame">
                  <i class="fas fa-file-pdf"></i> </a>
                  Gerar PDF do Termo de Ciência 
              @else
                  <a href="{{ $app_url }}/pdfs/renovacao/{{$estagio->id}}" target="_blank" >
                  <i class="fas fa-file-pdf"></i> </a>
                  Gerar PDF do Termo de Ciência para Renovação
              @endif

              @if(($estagio->aditivos)->isNotEmpty())
                  <br>
                  <a href="{{ $app_url }}/pdfs/aditivo/{{$estagio->id}}" target="_blank" >
                  <i class="fas fa-file-pdf"></i> </a>
                  Gerar PDF do Parecer de Alteração
              @endif
          </div>  
        </div>
      <br>
    @endif
  @endcan('empresa')

    <div class="card">
    <div class="card-header"><b>Documentos do Estágio</b></div>
      <div class="card-body">
        @include('files.partials.form')
      </div>  
    </div>

<br>

<div class="card">

      <div class="card-header"><b>Informações Gerais</b></div>
        <div class="card-body">
            <b>Número USP:</b> {{$estagio->numero_usp}}<br>
            <b>Nome do(a) aluno(a):</b> {{ $estagio->nome }}<br>
            <b>Curso:</b> {{ $estagio->curso }}<br>
            <b>Média ponderada:</b> {{ $estagio->media_ponderada }}<br>
            <b>Periodo de Matrícula</b>: {{ $estagio->periodo }}<br>
            <b>Modalidade do Estágio</b>: {{ $estagio->tipoestagio }}<br>
            <b>Departamento</b>: {{ $estagio->departamento }}<br>
            <b>Valor da bolsa:</b> {{$estagio->valorbolsa}}<br>
            <b>Tipo de bolsa:</b> {{$estagio->tipobolsa}}<br>
            <b>Justificativa:</b> {{$estagio->justificativa}}<br>
            <b>Atividades a serem desenvolvidas:</b> {{$estagio->atividades}}<br>
            <b>O horário é compatível com o curso?:</b> {{$estagio->horariocompativel}}<br>
            <b>As ativídades são pertinentes ao curso?:</b> {{$estagio->atividadespertinentes}}<br> 
            <b>Justificativa da pertinencia:</b> {{$estagio->atividadesjustificativa}}<br>         
            <b>Desempenho acadêmico:</b> {{$estagio->desempenhoacademico}}<br>
            <b>Análise Acadêmica:</b> {{$estagio->analise_academica}}<br>
            <b>Situação do deferimento do parecer de mérito:</b> {{$estagio->tipodeferimento}}<br>
            @if(($estagio->condicaodeferimento)!=null)
                <b>O estágio foi reduzido para seis meses?:</b> {{$estagio->condicaodeferimento}}<br>
            @endif   
        </div>

    <br>

      <div class="card-header"><b>Informações Sobre a Empresa</b></div>
        <div class="card-body">
            <b>Nome da empresa:</b> {{ $estagio->empresa->nome }}<br>
            <b>CNPJ da empresa:</b> {{ $estagio->empresa->cnpj }}<br>
            <b>Área de Atuação:</b> {{ $estagio->empresa->area_de_atuacao }}<br>
            <b>Nome do supervisor do estágio:</b> {{$estagio->nome_do_supervisor_estagio}}<br>
            <b>Cargo do supervisor do estágio:</b> {{$estagio->cargo_do_supervisor_estagio}}<br>
            <b>Telefone do supervisor do estágio:</b> {{$estagio->telefone_do_supervisor_estagio}}<br>
            <b>E-mail do supervisor do estágio:</b> {{$estagio->email_do_supervisor_estagio}}<br>
            <b>Nome de contato da empresa:</b> {{$estagio->nome_de_contato}}<br>
            <b>Telefone de contato da empresa:</b> {{$estagio->telefone_de_contato}}<br>
            <b>E-mail de contato da empresa:</b> {{$estagio->email_de_contato}}
        </div>      

    <br>

      <div class="card-header"><b>Período do Estágio</b></div>
        <div class="card-body">
            <b>Duração do estágio:</b> {{$estagio->duracao}}<br>
            <b>Data de início:</b> {{ $estagio->data_inicial }}<br>
            <b>Data de término:</b> {{ $estagio->data_final }}<br>
        </div>      

    <br>

      <div class="card-header"><b>Carga Horária</b></div>
        <div class="card-body">
            <b>Carga horária semanal (máximo 30 horas):</b> {{$estagio->cargahoras}} horas e {{$estagio->cargaminutos}} minutos.<br>
            <b>Carga horária diária (máximo 6 horas):</b> {{$estagio->cargahorasdiaria}} horas e {{$estagio->cargaminutosdiaria}} minutos.<br>
            <b>Horário por dia da semana:</b><br>
            @foreach ($estagio->diasSemanaOptions() as $dia => $label)
                @if ($estagio->horarios_por_dia[$dia]['entrada'])
                    &nbsp;&nbsp;{{ $label }}: Entrada {{ $estagio->horarios_por_dia[$dia]['entrada'] }},
                    Saída {{ $estagio->horarios_por_dia[$dia]['saida'] }}
                    @if ($estagio->horarios_por_dia[$dia]['intervalo'])
                        , Intervalo {{ $estagio->horarios_por_dia[$dia]['intervalo'] }}
                    @endif
                    - Total: {{ $estagio->horarios_por_dia[$dia]['total'] }}
                    <br>
                @endif
            @endforeach
            @if($estagio->horario)
                <b>Observações sobre o horário:</b> {{$estagio->horario}}<br>
            @endif
        </div>

    <br>

      <div class="card-header"><b>Auxílio Transporte</b></div>
        <div class="card-body">
            <b>Valor do auxílio transporte:</b> {{$estagio->auxiliotransporte}}<br>
            <b>Tipo de auxílio:</b> {{$estagio->especifiquevt}}<br>
        </div>              

    <br>

      <div class="card-header"><b>Informações sobre seguro</b></div>
        <div class="card-body">
            <b>Seguradora:</b> {{$estagio->seguradora}}<br>
            <b>Número da apólice:</b> {{$estagio->numseguro}}<br>
        </div>

</div>



@if($estagio->status == 'em_elaboracao' | $estagio->status == 'em_analise_tecnica' | $estagio->status == 'em_analise_academica' | $estagio->status == 'assinatura')

    @can('admin_ou_empresa',$estagio->cnpj)
    <br>
    <a class="btn btn-danger" onClick="return confirm('Tem certeza que deseja cancelar o estágio?')" href="{{ $app_url }}/cancelar_estagio/{{$estagio->id}}">
        Cancelar Estágio </a>

    @endcan

@endif

@endsection('content')

