@extends('main') 

@section('content')

<form method="POST" action="{{ $app_url }}/estagios">
@csrf
<div style="text-align: center;"><b>Atenção!</b> Os dados informados a seguir constarão no Termo de Compromisso e no Plano de Estágio.<br> O preenchimento e o encaminhamento devem ser realizados com antecedência mínima de 10 dias úteis, para que haja tempo hábil para a tramitação e as assinaturas antes da data de início do estágio.</div>
@include ('estagios.form')

<div class="form-group">
    <button type="submit" class="btn btn-success">Enviar</button>
</div>

</form>

@endsection('content')
