@extends('adminlte::page')

@section('title', 'Editar Corredor')

@section('content_header')
    <h1>Editar Corretor</h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('corretores.index')}}">Listar Corretores</a></li>
    <li class="breadcrumb-item">Editar</li>
</ol>
<div class="card">
    <div class="card-header">
        <div class="my-3">
           
            @if($corretor->image)
                @php
                    $t = new \App\Support\Thumb();
                @endphp
                <img src="{{\Illuminate\Support\Facades\Storage::url($t->makes($corretor->image,200,200))}}" alt="Logo" class="img-fluid">
            @endif
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('corretores.update',$corretor->id)}}" method="POST" enctype="multipart/form-data">
            @csrf    
            @method('PUT')
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="name">Nome*</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{ $corretor->name ?? old('nome')}}">
                    @if($errors->has('name'))
                        <p class="alert alert-danger">{{$errors->first('name')}}</p>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" value="{{$corretor->cpf ?? old('cpf')}}">
                    @if($errors->has('cpf'))
                        <p class="alert alert-danger">{{$errors->first('cpf')}}</p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="image">Foto:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-row">
                <div class="col-md-9 mb-3">
                    <label for="endereco">Endereco:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereco" value="{{$corretor->endereco ?? old('endereco')}}">
                    @if($errors->has('endereco'))
                        <p class="alert alert-danger">{{$errors->first('endereco')}}</p>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <label for="numero">Numero:</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Numero" value="{{$corretor->numero ?? old('numero')}}">
                    @if($errors->has('numero'))
                        <p class="alert alert-danger">{{$errors->first('numero')}}</p>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="cidade">Cidade:</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{$corretor->cidade ?? old('cidade')}}">
                    @if($errors->has('cidade'))
                        <p class="alert alert-danger">{{$errors->first('cidade')}}</p>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <label for="estado" class="control-label">Estado:</label>
                    <select id="estado" name="estado" class="form-control select2-single">
                        <option value="">Escolha o estado</option>
                        <option value="AC" {{(old('estado') == "AC" ? 'selected' : ($corretor->estado == "AC" ? 'selected' : ''))}}>Acre</option>
                        <option value="AL" {{(old('estado') == "AL" ? 'selected' : ($corretor->estado == "AL" ? 'selected' : ''))}}>Alagoas</option>
                        <option value="AP" {{(old('estado') == "AP" ? 'selected' : ($corretor->estado == "AP" ? 'selected' : ''))}}>Amapá</option>
                        <option value="AM" {{(old('estado') == "AM" ? 'selected' : ($corretor->estado == "AM" ? 'selected' : ''))}}>Amazonas</option>
                        <option value="BA" {{(old('estado') == "BA" ? 'selected' : ($corretor->estado == "BA" ? 'selected' : ''))}}>Bahia</option>
                        <option value="CE" {{(old('estado') == "CE" ? 'selected' : ($corretor->estado == "CE" ? 'selected' : ''))}}>Ceará</option>
                        <option value="DF" {{(old('estado') == "DF" ? 'selected' : ($corretor->estado == "DF" ? 'selected' : ''))}}>Distrito Federal</option>
                        <option value="ES" {{(old('estado') == "ES" ? 'selected' : ($corretor->estado == "ES" ? 'selected' : ''))}}>Espírito Santo</option>
                        <option value="GO" {{(old('estado') == "GO" ? 'selected' : ($corretor->estado == "GO" ? 'selected' : ''))}}>Goiás</option>
                        <option value="MA" {{(old('estado') == "MA" ? 'selected' : ($corretor->estado == "MA" ? 'selected' : ''))}}>Maranhão</option>
                        <option value="MT" {{(old('estado') == "MT" ? 'selected' : ($corretor->estado == "MT" ? 'selected' : ''))}}>Mato Grosso</option>
                        <option value="MS" {{(old('estado') == "MS" ? 'selected' : ($corretor->estado == "MS" ? 'selected' : ''))}}>Mato Grosso do Sul</option>
                        <option value="MG" {{(old('estado') == "MG" ? 'selected' : ($corretor->estado == "MG" ? 'selected' : ''))}}>Minas Gerais</option>
                        <option value="PA" {{(old('estado') == "PA" ? 'selected' : ($corretor->estado == "PA" ? 'selected' : ''))}}>Pará</option>
                        <option value="PB" {{(old('estado') == "PB" ? 'selected' : ($corretor->estado == "PB" ? 'selected' : ''))}}>Paraíba</option>
                        <option value="PR" {{(old('estado') == "PR" ? 'selected' : ($corretor->estado == "PR" ? 'selected' : ''))}}>Paraná</option>
                        <option value="PE" {{(old('estado') == "PE" ? 'selected' : ($corretor->estado == "PE" ? 'selected' : ''))}}>Pernambuco</option>
                        <option value="PI" {{(old('estado') == "PI" ? 'selected' : ($corretor->estado == "PI" ? 'selected' : ''))}}>Piauí</option>
                        <option value="RJ" {{(old('estado') == "RJ" ? 'selected' : ($corretor->estado == "RJ" ? 'selected' : ''))}}>Rio de Janeiro</option>
                        <option value="RN" {{(old('estado') == "RN" ? 'selected' : ($corretor->estado == "RN" ? 'selected' : ''))}}>Rio Grande do Norte</option>
                        <option value="RS" {{(old('estado') == "RS" ? 'selected' : ($corretor->estado == "RS" ? 'selected' : ''))}}>Rio Grande do Sul</option>
                        <option value="RO" {{(old('estado') == "RO" ? 'selected' : ($corretor->estado == "RO" ? 'selected' : ''))}}>Rondônia</option>
                        <option value="RR" {{(old('estado') == "RR" ? 'selected' : ($corretor->estado == "RR" ? 'selected' : ''))}}>Roraima</option>
                        <option value="SC" {{(old('estado') == "SC" ? 'selected' : ($corretor->estado == "SC" ? 'selected' : ''))}}>Santa Catarina</option>
                        <option value="SP" {{(old('estado') == "SP" ? 'selected' : ($corretor->estado == "SP" ? 'selected' : ''))}}>São Paulo</option>
                        <option value="SE" {{(old('estado') == "SE" ? 'selected' : ($corretor->estado == "SE" ? 'selected' : ''))}}>Sergipe</option>
                        <option value="TO" {{(old('estado') == "TO" ? 'selected' : ($corretor->estado == "TO" ? 'selected' : ''))}}>Tocantins</option>
                    </select>    
                </div>
                <div class="col-md-4 mb-3">
                    <label for="celular">Celular:</label>
                    <input type="text" class="form-control" id="celular" name="celular" placeholder="(XXX) XXXXX-XXXX" value="{{$corretor->celular ?? old('celular')}}">
                    @if($errors->has('celular'))
                        <p class="alert alert-danger">{{$errors->first('celular')}}</p>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="password">Senha:(Preencher apenas se quiser modificar a senha do corretor)</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha" value="{{old('password')}}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email:*</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$corretor->email ?? old('email')}}">
                    @if($errors->has('email'))
                        <p class="alert alert-danger">{{$errors->first('email')}}</p>
                    @endif
                </div>        
            </div>
            <div class="form-group">
                <a class="btn btn-warning btn-sm mb-3" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                    <i class="fas fa-lock"></i>
                </a>    
                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                            <div class="card card-body">
                                @foreach($permissions as $p)    
                                    <p><input type="checkbox" name="permission[]" id="permission" value="{{$p->id}}" {{in_array($p->id,$permissionUser) ? 'checked' : ''}}>{{$p->name}}</p>
                                @endforeach    
                            </div>
                        </div>
                    </div>
                </div>
                @if($errors->has('permission'))
                    <p class="alert alert-danger">{{$errors->first('permission')}}</p>
                @endif
            </div>    
            <button class="btn btn-primary btn-block" type="submit">Editar Colaborador</button>
        </form>
    </div>   
</div>    
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor/select2/css/select2.min.css')}}" />    
    <link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.css')}}" />    
@stop


@section('js')
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('vendor/select2/js/select2.min.js')}}"></script>
<script>
        $(function(){
            $('#cpf').mask('000.000.000-00', {reverse: true});
            $('#celular').mask('(000) 00000-0000');
            $('#estado').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endsection




