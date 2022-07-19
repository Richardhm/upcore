@extends('adminlte::page')

@section('title', 'Listar Planos')

@section('content_header')
    <h1>Cadastrar Plano <a href="{{route('plano.create')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            @if(count($planos) >= 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plano</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($planos as $c)
                            
                        <form id="form_{{$c->id}}" action="{{route('plano.delete',$c->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                        <tr>
                            <td>{{$c->nome}}</td>
                            <td>
                                <a href="{{route('plano.vincular',$c->id)}}" class="btn btn-info btn-sm"><i class="fab fa-superpowers"></i></a>
                                <a href="#" onclick="document.getElementById('form_{{$c->id}}').submit()" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="{{$planos->previousPageUrl()}}"><<</a></li>
                        @for($i=1;$i<=$planos->lastPage();$i++)
                            <li class="page-item {{$i == $planos->currentPage() ? 'active' : ''}}">
                                <a class="page-link" href="{{isset($filtro) && count($filtro) >= 1 ? $planos->appends($filtro)->url($i) : $planos->url($i)}}">{{$i}}</a>
                            </li>
                        @endfor
                        <li class="page-item"><a class="page-link" href="{{$planos->nextPageUrl()}}">>></a></li>
                    </ul>
                </nav>    




            @else
                <h3 class="text-center py-3">Nenhum plano cadastrada ainda</h3>
            @endif
        </div>
    </div>
@stop
