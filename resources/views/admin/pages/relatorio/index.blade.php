@extends('adminlte::page')

@section('title', 'Relarorios')

@section('content_header')
    <h1>Relatorios</h1>
    <form action="">
        <div class="form-row">
            <div class="col-6">
                <label for="">Data Inicial:</label>
                <input type="date" name="data_inicial" id="data_inicial" class="form-control">
            </div>
            <div class="col-6">
                <label for="">Data Final:</label>
                <input type="date" name="data_final" id="data_final" class="form-control">
            </div>
        </div>
    </form>



@stop

@section('content')
    
    


@stop
@section('js')
@stop