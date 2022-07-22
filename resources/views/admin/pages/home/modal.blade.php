@extends('adminlte::page')
@section('content')
<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Perido entre: <b>{{date("d/m/Y",strtotime($data_inicial))}}</b> até <b>{{date("d/m/Y",strtotime($data_final))}}</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Parcela</th>
                        <th>Administradora</th>
                        <th>Plano</th>
                        <th>Valor</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach($comissoes as $c)
                        @php
                            $total += $c->valor;
                        @endphp
                        <tr>
                            <td>{{date('d/m/Y',strtotime($c->data))}}</td>
                            <td>{{$c->comissao->cliente->nome}}</td>
                            <td>{{$c->parcela}}</td>
                            <td>{{$c->comissao->cotacao->administradora->nome}}</td>
                            <td>{{$c->comissao->cotacao->plano->nome}}</td>
                            <td>{{number_format($c->valor,2,",",".")}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-dark text-center">
                    <td colspan="6">Total de : {{number_format($total,2,",",".")}}</td>
                    </tr>
                </tfoot>
            </table>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            
        </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
         $('#myModal').modal('show');
         $('#myModal').on('hidden.bs.modal', function (event) {
            window.history.back()
        })  
    </script>

@endsection