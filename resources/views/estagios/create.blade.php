@extends('main') 

@section('content')

<form method="POST" action="{{ $app_url }}/estagios">
@csrf
<div style="text-align: center;"><b>Aviso Importante:</b> Envie a documentação com pelo menos <b>10 dias de antecedência</b>. A tramitação leva de 5 a 15 dias úteis, desde que não haja pendências. <b>Não serão aceitas datas retroativas</b>.</div>
@include ('estagios.form')

<div class="form-group">
    <button type="submit" class="btn btn-success">Enviar</button>
</div>

</form>

@endsection('content')
