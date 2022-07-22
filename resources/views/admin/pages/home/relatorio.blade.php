@extends('adminlte::page')

@section('title', 'Relarorios')

@section('content_header')
@stop

@section('content')

    <div class="card">
        <div class="card-header"><h1>Relatorios</h1></div>
        <div class="card-body">
            <form action="{{route('home.relatorio.post')}}" method="POST">
                @csrf
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
                <div class="form-group mt-3">
                    <div class="card card-primary collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Mais Opções</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none;">
                            <div class="form-row">
                            <div class="col-6">
                                <label for="administradora">Administradora:</label>
                                <select name="administradora" id="administradora" class="form-control">
                                    <option value="">--Escolher a Administradora--</option>
                                    @foreach($administradoras as $aa)
                                        <option value="{{$aa->id}}">{{$aa->nome}}</option>
                                    @endforeach
                                </select>                               
                            </div>
                            <div class="col-6">
                                <label for="plano">Planos:</label>
                                <select name="plano" id="plano" class="form-control">
                                    <option value="">--Escolher o Planos--</option>
                                    @foreach($planos as $pp)
                                        <option value="{{$pp->id}}">{{$pp->nome}}</option>
                                    @endforeach
                                </select>                              
                            </div>
                           </div>    
                        </div>

                    </div>
                </div>
                <input type="submit" class="btn btn-info btn-block" value="Relatorio">
            </form>
        </div>
    </div>

   @if(session('error'))
    <p class="alert alert-danger">{{session('error')}}</p>

   @endif
@stop
@section('js')
@stop