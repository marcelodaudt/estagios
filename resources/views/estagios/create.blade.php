@extends('main') 

@section('content')

<form method="POST" action="{{ $app_url }}/estagios">
@csrf
<div style="text-align: center;"><b>Aviso Importante:</b> O termo deve ser entregue assinado para a instituição no mínimo 10 dias úteis antes do início do estágio no email estagioseca@usp.br</div>
@include ('estagios.form')

<div class="form-group">
    <button type="submit" class="btn btn-success">Enviar</button>
</div>

</form>

@endsection('content')
