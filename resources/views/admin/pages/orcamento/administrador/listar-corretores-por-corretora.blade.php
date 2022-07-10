@extends('adminlte::page')
@section('title', 'Corretores')
@section('content_header')
    <h3>Corretores</h3>
@stop
@section('content')
    <div class="card">
        @if(count($corretores) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Corretor</th>
                        <th>Orçamentos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($corretores as $c)
                        <tr>
                            <td>{{$c->name}}</td>
                            <td>
                                <a href="{{route('orcamento.por.corretor',$c->id)}}" class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h5 class="py-3 text-center">Não a orçamentos cadastrados!</h5>
        @endif
        
    </div>
@stop