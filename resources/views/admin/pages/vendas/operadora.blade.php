@extends('adminlte::page')
@section('title', 'Vendas')
@section('content_header')
    <h1>Vendas Operadora</h1>
@stop
@section('content')
    <form action="{{route('vendas.operadora.store')}}" method="POST">
        @csrf
        <input type="hidden" name="status" value="administradora">    
        <div class="form-group">
            <label for="operadora">Operadora:</label>
            <select name="operadora_id" id="operadora_id" class="form-control form-control-lg">
                <option value="">--Escolha a Operadora--</option>
                @foreach($operadoras as $op)
                    <option value="{{$op->id}}">{{$op->nome}}</option>
                @endforeach   
            </select>
        </div>
        <div class="form-group">
            <label for="tipo_id">Tipo:</label>
            <select name="tipo_id" id="tipo_id" class="form-control form-control-lg">
                <option value="">--Escolha o Tipo--</option>
                @foreach($tipos as $t)
                    <option value="{{$t->id}}">{{$t->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group vidas">
        </div>
        <div class="form-group">
            <label for="participacao_id">Participação:</label>
            <select name="participacao_id" id="participacao_id" class="form-control form-control-lg">
                <option value="">--Escolha a Participação--</option>
                @foreach($participacao as $p)
                    <option value="{{$p->id}}">{{$p->nome}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <select name="modelo_id" id="modelo_id" class="form-control form-control-lg">
                <option value="">--Escolha o Modelo--</option>
                @foreach($modelo as $m)
                    <option value="{{$m->id}}">{{$m->nome}}</option>
                @endforeach
            </select>
        </div>
        @if(auth()->user()->admin)
            <div class="form-group">
                <label for="colaborador_id">Colaborador:</label>
                <select name="colaborador_id" id="colaborador_id" class="form-control form-control-lg">
                    <option value="colaborador_id">--Escolha o Colaborador--</option>
                    @foreach($colaboradores as $c)    
                        <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" name="valor" id="valor" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Enviar</button>
    </form>   
@stop

@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){
            $('#valor').mask("#.##0,00", {reverse: true});
            $('select[name="tipo_id"]').change(function(){
                let valor = $(this).val();
                if(valor == 3) {
                    $('.vidas')
                        .prepend("<label for='grupo_id'>Vidas:</label>")
                        .append("<select name='grupo_id' id='grupo_id' class='form-control form-control-lg'><option value=''>--Escolha a quantidade de vidas--</option><option value='1'>2 a 29 vidas</option><option value='2'>30 a 99 vidas</option></select>")
                } else {
                    $('.vidas').html('');
                }
            });           
        });
    </script>
@stop
