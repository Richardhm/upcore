@extends('adminlte::page')
@section('title', 'Listar Comissoes')
@section('content_header')
    <h1>Cadastrar Comissoes: <a href="{{route('comissao.corretores.cadastrar',$corretor->id)}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop
@section('content')
    <div class="card">
        @if(count($comissoes) >= 1)

            <div class="card-header">
                Listagem de Comissões do Corretor {{$corretor->name}}
            </div>
            <div class="card-body">
               <table>
                    <tr></tr>
               </table>
            </div>


        @else 
            <h5 class="py-3 text-center">Este Corretor Não possui comissões cadastradas!</h5>
        @endif
    
    
                    
        
    </div>
@stop