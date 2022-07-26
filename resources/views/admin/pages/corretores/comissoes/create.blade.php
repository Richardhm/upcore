@extends('adminlte::page')

@section('title', 'Cadastrar Comissão')

@section('content_header')
    <h1>Cadastrar Comissão Para o Corretor <u>{{$corretor->name}}</u></h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('comissao.corretores.index',$corretor->id)}}">Listar Comissões</a></li>
    <li class="breadcrumb-item">Cadastrar</li>
</ol>
<div class="card">
        <div class="card-header">
          
        </div>
        <div class="card-body">
           
        @if (session('errorjatem'))
            <div class="alert alert-danger text-center">
                {{ session('errorjatem') }}. <a href="{{route('comissao.corretores.detalhes',[$corretor->id,old('plano_id'),old('administradora_id')])}}">Editar Aqui</a>
            </div>
        @endif

        
        
        
        
            <form action="{{route('comissao.corretores.store')}}" method="post" enctype="multipart/form-data" class="invoice-repeater">
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

            <h3>Comissões:</h3>
            @if($errors->has('parcelas.*.parcelas'))
                        <p class="alert alert-danger">{{$errors->first('parcelas.*.parcelas')}}</p>
                    @endif
            <div data-repeater-list="parcelas">
                
                <div data-repeater-item>
                    <div class="row my-3">
                        <div class="col-10">
                        <input type="text" id="parcelas" class="form-control" name="parcelas" placeholder="%" />
                        </div>
                        <div class="col-2">
                        <button data-repeater-delete type="button" value="Delete" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    
                   
                </div>
                
            </div>
            <button data-repeater-create type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>

           
            <button class="btn btn-primary btn-block mt-5" type="submit">Cadastrar Comissão</button>
           </form>
@stop

@section('css')
   
@stop




@section('js')
<script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('js/form-repeater-create.js') }}"></script>

 
@endsection