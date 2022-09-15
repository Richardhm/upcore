@extends('adminlte::page')
@section('title', 'Cadastrar Juridica')

@section('content_header')
    <h1>Cadastrar Juridico</h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
    <li class="breadcrumb-item">Cadastro</li>
</ol>
    <div class="card">
       
        <div class="card-body">
            <form action="{{route('financeiro.storeJuridico')}}" method="POST">
                @csrf
                <div class="form-row mt-3">
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="nome">Operadora:</label>
                            <select name="administradora_id" id="administradora_id" class="form-control">
                                <option value="">--Escolher a Operadora--</option>
                                @foreach($administradoras as $ad)
                                    <option value="{{$ad->id}}" {{$ad->id == old('administradora_id') ? 'selected' : ''}}>{{$ad->nome}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('administradora_id'))
                                <p class="alert alert-danger">{{$errors->first('administradora_id')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="cnpj">CNPJ:</label>
                            <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ" value="{{old('cnpj')}}">
                            @if($errors->has('cnpj'))
                                <p class="alert alert-danger">{{$errors->first('cnpj')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-group">
                            <label for="nome_empresa">Razão Social:</label>
                            <input type="text" name="nome_empresa" id="nome_empresa" class="form-control" placeholder="Razão Social" value="{{old('nome_empresa')}}">
                            @if($errors->has('nome_empresa'))
                                <p class="alert alert-danger">{{$errors->first('nome_empresa')}}</p>
                            @endif
                        </div>
                    </div>
                </div>  
                <div class="form-row mt-3">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="nome">Proprietaria:</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Proprietario" value="{{old('nome')}}">
                            @if($errors->has('nome'))
                                <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="contato">Contato:</label>
                            <input type="text" name="contato" id="contato" class="form-control" placeholder="Contato" value="{{old('contato')}}">
                            @if($errors->has('contato'))
                                <p class="alert alert-danger">{{$errors->first('contato')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="celular">Telefone:</label>
                            <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular" value="{{old('celular')}}">
                            @if($errors->has('celular'))
                                <p class="alert alert-danger">{{$errors->first('celular')}}</p>
                            @endif
                        </div>
                    </div>
                </div>    
                <div class="form-row mt-3">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{old('email')}}">
                            @if($errors->has('email'))
                                <p class="alert alert-danger">{{$errors->first('email')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="quantidade_vidas">Quantidade de Vidas</label>
                            <input type="number" name="quantidade_vidas" id="quantidade_vidas" class="form-control" placeholder="Quantidade de Vidas" value="{{old('quantidade_vidas')}}">
                            @if($errors->has('quantidade_vidas'))
                                <p class="alert alert-danger">{{$errors->first('quantidade_vidas')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor" value="{{old('valor')}}">
                            @if($errors->has('valor'))
                                <p class="alert alert-danger">{{$errors->first('valor')}}</p>
                            @endif
                        </div>
                    </div>
                </div>    

                <div class="form-row mt-3">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="user_id">Usuarios:</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">--Escolher usuarios--</option>
                                @foreach($users as $u)
                                    <option value="{{$u->id}}" {{$u->id == old('user_id') ? 'selected' : ''}}>{{$u->name}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user_id'))
                                <p class="alert alert-danger">{{$errors->first('user_id')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="nome">Cidade:</label>
                            <select name="cidade_id" id="cidade_id" class="form-control">
                                <option value="">--Escolher cidade--</option>
                                @foreach($cidades as $c)
                                    <option value="{{$c->id}}" {{$c->id == old('cidade_id') ? 'selected' : ''}}>{{$c->nome}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('cidade_id'))
                                <p class="alert alert-danger">{{$errors->first('cidade_id')}}</p>
                            @endif
                        </div>
                    </div>    
                </div>    

                <button type="submit" class="btn btn-block btn-primary">Cadastrar</button>
            </form>
        </div>    
    </div>
@stop


@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){
            $('#cnpj').mask('00.000.000/000-00');
            $('#celular').mask('(00) 0 00000-0000');
            $('#contato').mask('(00) 0 00000-0000');
            $('#valor').mask("#.##0,00", {reverse: true});
           
            
           

    
        });
    </script>
@stop