@extends('adminlte::page')

@section('title', 'Cadastrar Cidades')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('cidades.index')}}">Listar Cidades</a></li>
        <li class="breadcrumb-item">Cadastrar</li>
    </ol>    
@stop

@section('content')
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="{{route('cidades.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="uf">Escolha Um Estado:</label>
                    <select id="uf" name="uf" class="form-control">
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome">Escolha Uma Cidade:</label>
                    <select id="nome" name="nome" class="form-control">
                    </select>
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div>
		            


                <!-- <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Cidade" value="{{old('nome')}}">
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div> -->
                <input type="submit" value="Cadastrar" class="btn btn-primary btn-block">
            </form>   
        </div>
    </div>




@stop

@section('js')
    <script>
        $(document).ready(function () {
		
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



