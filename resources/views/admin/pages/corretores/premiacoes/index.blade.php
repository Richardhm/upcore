@extends('adminlte::page')
@section('title', 'Listar Premiações')
@section('content_header')
    <h1>Cadastrar Premiações: <a href="{{route('premiacao.corretores.cadastrar',$corretor->id)}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1><small>Caso queira editar alguma premiação, clique sobre o valor para editar.</small>
@stop
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('corretores.index')}}">Voltar Listagem de Colaboradores</a></li>
        <li class="breadcrumb-item">Listagem de Premiações do Corretor <b>{{$corretor->name}}</b></li>
    </ol>        


    <div class="card">
        @if(count($premiacoes) >= 1)

            <div class="card-header">
                Listagem de Premiações do Corretor {{$corretor->name}}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Administradora</th>
                            <th>Plano</th>
                            <th>Valor</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($premiacoes as $c)
                            <form id="form_{{$c->id}}" action="{{route('premiacao.corretores.deletar',$c->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        <tr>
                            <td>{{$c->administradora}}</td>
                            <td>{{$c->plano}}</td>
                            <td><span data-toggle="modal" data-target="#alterarModal" data-id="{{$c->id}}" data-valor="{{$c->valor}}">{{$c->valor}}</span></td>
                            <td><a onclick="document.getElementById('form_{{$c->id}}').submit()" href="#">
                                    <i class="fas fa-trash text-danger"></i>
                                </a></td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>


        @else 
            <h5 class="py-3 text-center">Este Corretor Não possui premiações cadastradas!</h5>
        @endif
    
    
                    
        
    </div>

    <!-- Modal editar Valor -->
    <div class="modal fade" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alterarModalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('premiacao.corretores.editar')}}" method="POST" name="alterar_valor" id="alterar_valor">
                    @csrf    
                    <input type="hidden" name="id" id="id">
                    
                    <div class="form-group">
                        <label for="valor">Valor:</label>
                        <input type="text" name="valor" id="valor" class="form-control">
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Alterar Dados</button>
            </div>
            </form>
            </div>
        </div>
    </div>   

@stop

@section('js')
<script src="{{asset('js/jquery.mask.min.js')}}"></script> 
    <script>
            $('#valor').mask("#.##0,00", {reverse: true});
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#alterarModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var valor = button.data('valor');
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-body input[name="valor"]').val(valor);
                modal.find('.modal-body input[name="id"]').val(id);
            });
            
            $('form[name="alterar_valor"]').on('submit',function(e){
                $.ajax({
                    url:$(this).attr('action'),
                    data:$(this).serialize(),
                    method:"POST",
                    success(res) {
                        if(res == "alterado") {
                            window.location.reload();
                        }
                    }
                });
                return false;
            });    
    </script>
@stop




