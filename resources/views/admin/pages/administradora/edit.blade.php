@extends('adminlte::page')

@section('title', 'Editar Administradora')

@section('content_header')
    <h1>Editar Administradora {{$administradora->nome}}</h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('administradora.index')}}">Listar Administradoras</a></li>
    <li class="breadcrumb-item">Edição</li>
</ol>
<div class="card">
        <div class="card-header">
        <div class="my-3">
            @if($administradora->logo)
                <img src="{{\Illuminate\Support\Facades\Storage::url($administradora->logo)}}" alt="Logo" width="80" height="80" class="img-fluid">
            @endif
        </div>
        </div>
        <div class="card-body">
           <form action="{{route('administradora.update',$administradora->id)}}" method="post" enctype="multipart/form-data" class="invoice-repeater">
                @method('PUT')
                @csrf
            <div class="form-group">
                <label for="nome">Nome:*</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$administradora->nome ?? old('nome')}}">
                @if($errors->has('nome'))
                    <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                @endif
            </div>
            
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="logo">Logo: <small>(Preencher apenas se quiser mudar imagem)</small></label>
                    <input type="file" class="form-control" id="logo" name="logo">
                </div>
            </div>

           
            <label for="comissao">Comissão<small>(%)</small></label>
            <div class="unique_parcela">
                @foreach($administradora->parcelas as $k => $v)
                        <div id="{{$v->id}}">
                            <input type="text" value="{{$v->valor}}" name="parcelas_bd[]" id="parcelas_bd">
                            <button type="button" data-id="{{$v->id}}" class="btn btn-danger btn-sm excluir">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                @endforeach
                    <div>
            <div data-repeater-list="parcelas">
           
                <div data-repeater-item>
               
                    <input type="text" id="parcelas_new" name="parcelas_new" placeholder="Parcela" />
                    <button data-repeater-delete type="button" value="Delete" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                </div>
                
            </div>
            <button data-repeater-create type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>


                
               
            

            <div class="form-group">
                <label for="vitalicio">Vitalicio:</label>
                <input type="checkbox" id="vitalicio_status" {{$administradora->vitalicio ? 'checked' : ''}}>
                <div id="area_vitalicio">
                    <input placeholder='%' type='text' name='vitalicio' id='vitalicio' class='form-control' value="{{$administradora->vitalicio}}" />
                </div>
            </div>

            <div class="form-group">
                <label for="premiacao_corretora">Premiação Corretora:</label>
                <input type="text" class="form-control" id="premiacao_corretora" name="premiacao_corretora" placeholder="Premiação Corretora" value="{{($administradora->premiacao_corretora != null ? $administradora->premiacao_corretora : null) ?? old('premiacao_corretora')}}">
            </div>

            <div class="form-group">
                <label for="premiacao_corretor">Premiação Corretor:</label>
                <input type="text" class="form-control" id="premiacao_corretor" name="premiacao_corretor" placeholder="Premiação Corretor" value="{{($administradora->premiacao_corretor != null ? $administradora->premiacao_corretor : null)   ?? old('premiacao_corretor')}}">
            </div>

            
            <button class="btn btn-primary btn-primary btn-block" type="submit">Editar Administradora</button>
        </form>

@stop

@section('css')
    <style>
        .area_vitalicio {
            display: none;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('js/form-repeater-edit.js') }}"></script>    
    <script>
        $(function(){
            $("#vitalicio_status").change(function(){
                if($(this).prop('checked')) {
                    $("#area_vitalicio").css('display','block');
                    $('#area_vitalicio').html('');
                    $("#area_vitalicio").append("<input placeholder='%' type='text' name='vitalicio' id='vitalicio' class='form-control' />");
                } else {
                    $('#area_vitalicio').html('');
                }
            });

            if($("#vitalicio_status").prop('checked')) {
                $("#area_vitalicio").css('display','block');
            } else {
                $("#area_vitalicio").css('display','none');
            }
            $("body").on('click','.excluir',function(){
                let id = $(this).attr("data-id");
                $(this).closest('.unique_parcela').find('div[id="'+id+'"]').slideUp('fast',function(){
                    $(this).remove();
                });
                //$(this).parent(".unique_parcela").slideUp('fast')
            });



        });            
    </script>
    
@stop








