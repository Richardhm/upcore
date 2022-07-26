@extends('adminlte::page')

@section('title', 'Cadastrar Cidades')

@section('content_header')
   <h4>Cadastrar Cidade</h4> 
@stop

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('cidades.index')}}">Listar Cidades</a></li>
        <li class="breadcrumb-item">Cadastrar</li>
    </ol>    
    <div class="card">
        
        <div class="card-body">
            <form action="{{route('cidades.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="uf">Escolha Um Estado:</label>
                    <select id="uf" name="uf" class="form-control select2-single">
                        <option value=""></option>
                    </select>
                    @if($errors->has('uf'))
                        <p class="alert alert-danger">{{$errors->first('uf')}}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="nome">Escolha Uma Cidade:</label>
                    <select id="nome" name="nome" class="form-control select2-single">
                    </select>
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div>
		        
                <input type="submit" value="Cadastrar" class="btn btn-primary btn-block">
            </form>   
        </div>
    </div>




@stop

@section('js')
<script src="{{asset('vendor/select2/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function () {
		
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#uf').select2({
                theme: 'bootstrap4',
            });   

            $('#nome').select2({
                theme: 'bootstrap4',
            });   


        $.getJSON("{{asset('js/estados_cidades.json')}}", function (data) {
            var items = [];
            var options = '<option value="">Escolha um Estado</option>';	
            $.each(data, function (key, val) {
                options += '<option value="' + val.nome + '">' + val.nome + '</option>';
            });					
            $("#uf").html(options);				           
            $("#uf").change(function () {				
                var options_cidades = '';
                var str = "";					
                $("#uf option:selected").each(function () {
                    str += $(this).text();
                });
                $.each(data, function (key, val) {
                    if(val.nome == str) {							
                        $.each(val.cidades, function (key_city, val_city) {
                            options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                        });							
                    }
                });
                $("#nome").html(options_cidades);
            }).change();		
        });
    
    });
    </script>
@endsection


@section('css')
<link rel="stylesheet" href="{{asset('vendor/select2/css/select2.min.css')}}" />    
<link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.css')}}" />
@endsection
