@extends('adminlte::page')
@section('title', 'Vendas')
@section('content_header')
    <h1>Cadastrar Tabela de Preço</h1>
@stop
@section('content')
    <form action="" method="POST">
        @csrf
        <div class="form-row mb-3">
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" class="form-control">
        </div>
        <div class="form-row mb-3">
            <label for="grupos">Grupos:</label>
            <input type="text" name="grupos" id="grupos" class="form-control">
        </div>
        <div class="form-row mb-3">
            <label for="acomodacao">Acomodação:</label>
            <input type="text" name="acomodacao" id="acomodacao" class="form-control">
        </div>
        <div class="form-group mb-3">
            @foreach($faixas as $k => $f)    
                <div>
                    @if($loop->first)
                        <label for="faixa_etaria_id">Faixas Etarias:</label><br /> 
                    @endif
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" readonly class="form-control" name="faixa_etaria_id[{{$k}}]" id="faixa_etaria_id" value="{{$f}}" />
                        </div>
                        <div class="col">
                            <input type="text" class="form-control valor" placeholder="valor" name="valor[]" id="valor" value="{{ old('valor.'.$k)}}" />
                            @if($errors->has('valor'))
                                <div class="py-1 alert alert-danger alert-dismissible fade show" role="alert">
                                    <p class="text-center">{{$errors->first('valor')}}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if($errors->any('valor'.$k) && !empty($errors->get('valor.'.$k)[0]))
                                <div class="py-1 alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>O valor da faixa etaria {{ $f }} e campo obrigatorio</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>                            
                            @endif                        
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
    </form>
@stop
@section('js')
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('js/form-repeater.js') }}"></script>
    <script>
        $(function(){
            $("#tipo").change(function(){
                
            });
        });
    </script>
@stop