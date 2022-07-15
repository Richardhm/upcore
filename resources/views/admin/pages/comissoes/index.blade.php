@extends('adminlte::page')
@section('title', 'Comissões')
@section('content_header')
    <h3>Comissões/Premiações</h3>
@stop
@section('content')
    <div class="card">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Corretor</th>
                        <th>Plano</th>
                        <th>Administradora</th>
                        <th>Quantidade de Parcelas</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comissoes as $c)
                    <tr>
                        <td>{{date('d/m/Y',strtotime($c->created_at))}}</td>
                        <td>{{$c->cliente}}</td>
                        <td>{{$c->corretor}}</td>
                        <td>{{$c->plano}}</td>
                        <td>{{$c->administradora}}</td>
                        <td align="center" style="width:200px;">{{$c->quantidade_pagas}}/{{$c->quantidade_parcelas}}</td>
                        <td align="center" style="width:100px;"><a href="{{route('comissoes.detalhes',$c->id)}}"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>




@stop   
@section('js')
   
@stop
@section('css')

     
@stop
