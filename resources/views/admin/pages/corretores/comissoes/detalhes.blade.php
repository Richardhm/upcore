@extends('adminlte::page')
@section('title', 'Listar Comissoes')
@section('content_header')   
    <h3>Detalhes da Comissão</h3><small>Caso queira editar alguma parcela, clique sobre a mesma.</small>
@stop
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('comissao.corretores.index',$id)}}">Voltar Para Listagem</a></li>
        <li class="breadcrumb-item">Detalhes da Comissão</li>
    </ol>
    <div class="card">
        @if(count($comissao) >= 1)

            <div class="card-body">
               <table class="table">
                    <thead>
                        <tr>
                            <th>Parcela</th>
                            <th>Porcentagem</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comissao as $p)
                        <form id="form_{{$p->id}}" action="{{route('comissao.corretores.deletar.parcela',[$p->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        <tr>
                            <td>Parcela {{$p->parcela}}</td>
                            <td><span data-toggle="modal" data-target="#alterarModal" data-id="{{$p->id}}" data-valor="{{$p->valor}}">{{$p->valor}}%</span></td>
                            <td><a onclick="document.getElementById('form_{{$p->id}}').submit()" href="#">
                                    <i class="fas fa-trash text-danger"></i>
                                </a></td>
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
                <form action="{{route('comissao.corretores.editar.parcela')}}" method="POST" name="alterar_valor" id="alterar_valor">
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