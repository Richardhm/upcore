@extends('adminlte::page')

@section('title', 'Listar Cidades')

@section('content_header')
    <h1>Cadastrar Cidade <a href="{{route('cidades.cadastrar')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{route('cidades.pesquisar')}}" method="post" class="form-inline">
                @csrf
                <input type="text" name="search" id="search" class="form-control" placeholder="Cidade/Administradora">
                <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="card-body">
            @if(count($cidades) >= 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cidades as $c)
                            
                        <form id="form_{{$c->id}}" action="{{route('cidades.destroy',$c->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                        <tr>
                            <td>{{$c->nome}}</td>
                            <td>
                                <a href="{{route('cidades.vincular',$c->id)}}" class="btn btn-info btn-sm"><i class="fab fa-superpowers"></i></a>
                                <a href="#" onclick="document.getElementById('form_{{$c->id}}').submit()" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="{{$cidades->previousPageUrl()}}"><<</a></li>
                        @for($i=1;$i<=$cidades->lastPage();$i++)
                            <li class="page-item {{$i == $cidades->currentPage() ? 'active' : ''}}">
                                <a class="page-link" href="{{isset($filtro) && count($filtro) >= 1 ? $cidades->appends($filtro)->url($i) : $cidades->url($i)}}">{{$i}}</a>
                            </li>
                        @endfor
                        <li class="page-item"><a class="page-link" href="{{$cidades->nextPageUrl()}}">>></a></li>
                    </ul>
                </nav>    




            @else
                <h3 class="text-center py-3">Nenhum cidade cadastrada ainda</h3>
            @endif
        </div>
    </div>
@stop
