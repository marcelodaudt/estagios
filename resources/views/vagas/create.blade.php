@extends('main') 

@section('javascripts_head')
  <script src="{{asset('/js/vagas.js')}}"></script>
@endsection('javascript_head')

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('/css/vagas.css')}}">
@endsection('styles')

@section('content')
@include('flash')
 
<form method="POST" action="{{ $app_url }}/vagas">
@csrf
@include('vagas.form')
</form>

@endsection('content')