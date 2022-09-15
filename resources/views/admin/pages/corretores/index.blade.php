@extends('adminlte::page')
@section('title', 'Listar Corretores')
@section('content_header')
    <h1>Cadastrar Colaborador: <a href="{{route('corretores.create')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop
@section('content')
    <div class="card">
        @if(count($corretores) >= 1)

            <div class="card-header"><h4>Corretor</h4></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Comissões/Premiações</th>
                            

                            <th>Editar/Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($corretores as $c)
                            <form id="form_{{$c->id}}" action="{{route('corretores.destroy',$c->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>    
                            <tr>
                                <td>{{$c->name}}</td>
                                <td align="center" width="100px;"><a href="{{route('comissao.corretores.index',$c->id)}}" style="color:black;"><i class="fas fa-money-check-alt fa-lg"></i></a></td>
                                <!-- <td align="center" width="100px;"><a href="{{route('premiacao.corretores.index',$c->id)}}" style="color:black;"><i class="fas fa-award fa-lg"></i></a></td> -->
                                <td>
                                    <a href="{{route('corretores.edit',$c->id)}}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="document.getElementById('form_{{$c->id}}').submit()" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        @else 
            <h5 class="py-3 text-center">Sem Corretores cadastrado ainda!</h5>
        @endif
    
    
                    
        
    </div>

    <div class="card">
        @if(count($financeiro) >= 1)

            <div class="card-header"><h4>Financeiro</h4></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            
                            <th>Editar/Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($financeiro as $c)
                            <form id="form_{{$c->id}}" action="{{route('corretores.destroy',$c->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>    
                            <tr>
                                <td>{{$c->name}}</td>
                                
                                <td>
                                    <a href="{{route('corretores.edit',$c->id)}}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="document.getElementById('form_{{$c->id}}').submit()" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        @else 
            <h5 class="py-3 text-center">Sem Colaboradores financeiros cadastrado ainda!</h5>
        @endif
    
    
                    
        
    </div>




@stop