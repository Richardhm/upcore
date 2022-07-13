@extends('adminlte::page')
@section('title', 'Listar Comissoes')
@section('content_header')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('comissao.corretores.index',$id)}}">Voltar Para Listagem</a></li>
</ol>    
@stop
@section('content')
    <div class="card">
        @if(count($comissao) >= 1)

            <div class="card-header">
                Listagem de Comissões do Corretor 
            </div>
            <div class="card-body">
               <table class="table">
                    <thead>
                        <tr>
                            <th>Parcela</th>
                            <th>Porcentagem</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comissao as $p)
                        <tr>
                            <td>Parcela {{$p->parcela}}</td>
                            <td>{{$p->valor}}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th class="text-center">Comissão do plano <u><b>{{$plano}}</b></u> do(a) <u>{{$admin}}</u> para o corretor <span style="text-transform:uppercase">{{$user}}</span></th>
                    </tfoot>
               </table>
            </div>


        @else 
            <h5 class="py-3 text-center">Este Corretor Não possui comissões cadastradas!</h5>
        @endif
    
    
                    
        
    </div>
@stop