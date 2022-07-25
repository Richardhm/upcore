@extends('adminlte::page')

@section('title', 'Cadastrar Administradora')

@section('content_header')
    <h1>Cadastrar Administradora</h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('administradora.index')}}">Listar Administradoras</a></li>
    <li class="breadcrumb-item">Cadastrar</li>
</ol>
<div class="card">
        <div class="card-header">
            <strong>*</strong> <small>Campo Obrigatorio</small>             
        </div>
        <div class="card-body">
           <form enctype="multipart/form-data" action="{{route('administradora.store')}}" method="post" class="invoice-repeater">
            @csrf
            <div class="form-group">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{old('nome')}}">
                @if($errors->has('nome'))
                    <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                @endif
            </div>
            
            <div class="form-group">
                <div class="col-md-12 mb-3">
                    <label for="logo">Logo: *</label>
                    <input type="file" class="form-control" id="logo" name="logo">
                </div>
                @if($errors->has('logo'))
                    <p class="alert alert-danger">{{$errors->first('logo')}}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="premiacao_corretora">Premiação Corretora: *</label>
                <input type="text" class="form-control" id="premiacao_corretora" value="{{old('premiacao_corretora')}}" name="premiacao_corretora" placeholder="Premiação Corretora">
                @if($errors->has('premiacao_corretora'))
                    <p class="alert alert-danger">{{$errors->first('premiacao_corretora')}}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="comissao">Comissão Corretora:<small>(%) *</small></label>
                
            </div>


            @if($errors->has('parcelas.*.parcelas'))
                <p class="alert alert-danger">{{$errors->first('parcelas.*.parcelas')}}</p>
            @endif
            <div data-repeater-list="parcelas">               
                <div data-repeater-item>
                    <input type="text" id="parcelas" name="parcelas" placeholder="%" />
                    <button data-repeater-delete type="button" value="Delete" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                </div> 
            </div>
            <button data-repeater-create type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
            
   
            <button class="btn btn-primary btn-block mt-5" type="submit">Cadastrar Administradora</button>
           </form>

@stop

@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('js/form-repeater-create.js') }}"></script>
    <script>
        $(function(){
            $('#premiacao_corretora').mask("#.##0,00", {reverse: true});
            $('#premiacao_corretor').mask("#.##0,00", {reverse: true});
            $("#vitalicio_status").change(function(){
                if($(this).prop('checked')) {
                    $("#area_vitalicio").append("<input placeholder='%' type='text' name='vitalicio' id='vitalicio' class='form-control' />");
                } else {
                    $('#area_vitalicio').html('');
                }
            });
        });    
        
    
        
    </script>
    
@stop




