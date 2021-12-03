@extends('main') 

@section('content')
@include('flash')

<form method="POST" action="{{ $app_url }}/pareceristas">
@csrf
  @include('pareceristas.form')
</form>

@endsection('content')
