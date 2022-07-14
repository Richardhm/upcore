@extends('adminlte::page')

@section('title', 'Cadastrar Premiações')

@section('content_header')
    <h1>Cadastrar Premiações Para o Corretor <u>{{$corretor->name}}</u></h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('premiacao.corretores.index',$corretor->id)}}">Listar Premiações</a></li>
    <li class="breadcrumb-item">Cadastrar</li>
</ol>
<div class="card">
        <div class="card-header">
          
        </div>
        <div class="card-body">
           
           
        
        
            <form action="{{route('premiacao.corretores.store')}}" method="post" enctype="multipart/form-data" class="invoice-repeater">
            @csrf
            
            <input type="hidden" name="user_id" id="user_id" value="{{$corretor->id}}">

            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="name">Administradora</label>
                    <select name="administradora_id" id="administradora_id" class="form-control">
                        <option value="">--Escolha Uma Administradora--</option>
                        @foreach($administradoras as $a)
                        <option value="{{$a->id}}" {{old('administradora_id') == $a->id ? 'selected' : ''}}>{{$a->nome}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('administradora_id'))
                        <p class="alert alert-danger">{{$errors->first('administradora_id')}}</p>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cpf">Plano:</label>
                    <select name="plano_id" id="plano_id" class="form-control">
                        <option value="">--Escolha Um Plano--</option>
                        @foreach($planos as $p)
                        <option value="{{$p->id}}" {{old('plano_id') == $p->id ? 'selected' : ''}}>{{$p->nome}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('plano_id'))
                        <p class="alert alert-danger">{{$errors->first('plano_id')}}</p>
                    @endif
                </div>
            </div>

            <h3>Premiação:</h3>
            <div class="form-group">
                <label for="">Valor:</label>    
                <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor da Premiação">
                @if($errors->has('valor'))
                    <p class="alert alert-danger">{{$errors->first('valor')}}</p>
                @endif
            </div>

           
            <button class="btn btn-primary btn-block mt-5" type="submit">Cadastrar Premiação</button>
           </form>
@stop

@section('js')
<script src="{{asset('js/jquery.mask.min.js')}}"></script>  
<script>
        $(function(){
            $("#valor").mask("#.##0,00", {reverse: true});
        });
    </script>
 
@endsection