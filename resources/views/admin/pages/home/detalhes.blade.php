@extends('adminlte::page')

@section('title', 'Funcionario')

@section('content_header')
@stop

@section('content')
    <h1>{{$user->name}} - {{$cargo}}</h1>

   
@stop
@section('js')
@stop