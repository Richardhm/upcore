@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Clientes')

@section('content_header')
    <div class="row">
        
        <div class="col">
           
            <h2>Clientes 
                @can('clientes_dos_corretores')
                    <a href="{{route('clientes.corretores')}}" class="text-warning"><i class="fas fa-users"></i></a>
                @endcan     
            </h2>
            
            
            
        </div>
        <div class="col">
            <p style='display:flex;justify-content: flex-end;'><span style="font-weight: bolder;font-size: 1.1em;">*</span> &nbsp; Sem Status Definido</p>
        </div>
    </div>
    
@stop

@section('content')
    
    
    <div class="card">
        @if(count($clientes) >= 1)
        
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>         
                <tbody>
                    @foreach($clientes as $c)
                    <tr>
                        <td>{!! empty($c->status) ? "<span style='font-weight: bolder;font-size: 1.1em;'>*</span>" : "" !!}   {{date('d/m/Y',strtotime($c->created_at))}}</td>
                        <td>{{$c->nome}}</td>
                        <td>{{$c->telefone}}</td>
                        <td>{{$c->email}}</td>
                        @if($c->status)
                        <td><span class="status" data-toggle="modal" data-target="#alterarModal" data-id="{{$c->status}}" data-cliente="{{$c->id}}" style="display:block;margin-left:15px;width:20px;height:20px;border-radius:50%;background-color:{{$c->cor}}"></span></td> 
                        @else
                        <td width="240px;" id="coluna_{{$c->id}}">
                            <select name="definir_status" data-id="{{$c->id}}" class="form-control">
                                <option value="">--Definir Status--</option>
                                @foreach($etiquetas as $et)
                                    <option value="{{$et->id}}">{{$et->nome}}</option>
                                @endforeach                        
                            </select>
                        </td>
                        @endif
                        
                    </tr>
                    @endforeach
                </tbody>   
            </table>
        @else
            <h3 class="text-center py-3">Sem Clientes Cadastrados</h3>
        @endif    
        </div>
        

       



    </div>
    
    <div>
    @if(count($clientes) >= 1)
        STATUS:&nbsp;
        <br><br>
        @foreach($etiquetas as $et)
            <p style="display:flex;padding-right:10px;align-items:center;font-weight:bold;border-bottom:1px solid black;width:25%;justify-content:space-between;">{{$et->nome}} <span style="display:block;margin-left:15px;width:20px;height:20px;border-radius:50%;background-color:{{$et->cor}}"></span></p>
        @endforeach
    @endif    
    </div>

    <div class="modal fade" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alterarModalLabel">Mudar Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('clientes.mudarStatus')}}" method="POST" name="alterar_valor" id="alterar_valor">
                                @csrf    
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="cliente" id="cliente">
                                @foreach($etiquetas as $etique)
                                    <div class="d-flex align-items-center justify-content-between mb-2 border-bottom" style="width: 60%;">
                                        <div><input type="radio" value="{{$etique->id}}" name="status" id="status_{{$etique->id}}">{{$etique->nome}}</input></div>
                                        <div style="display:block;align-self:end;margin-left:15px;width:20px;height:20px;border-radius:50%;background-color:{{$etique->cor}}"></div>
                                    </div>
                                @endforeach
                                <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Alterar Dados</button>
                    </div>                    
                        </form>
                    </div>
                        
                </div>
            </div>
        </div>    
@stop
@section('js')
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#alterarModal').on('show.bs.modal', function (event) {
                var alvo = $('input[name="id"]').val();
                $('input[type="radio"]').attr('checked',false);
                $('input[id="status_'+alvo+'"]').attr('checked',true);
            });
            $('.status').click(function(){
                let id = $(this).attr('data-id');
                let cliente = $(this).attr('data-cliente');
                $('input[name="id"]').val(id);
                $('input[name="cliente"]').val(cliente);
            });
            $("select[name='definir_status']").on('change',function(){
                let id_cliente = $(this).attr('data-id');
                let id_etiqueta = $(this).val();
                $.ajax({
                    url:"{{route('clientes.definirStatus')}}",
                    method:"POST",
                    data:"cliente="+id_cliente+"&etiqueta="+id_etiqueta,
                    success(res) {
                        window.location.reload();
                        //console.log(res);
                        //$('td[id="coluna_'+id_cliente+'"]').html(res);                   
                    }
                });
            });
            $('form[name="alterar_valor"]').on('submit',function(e){
                let action = $(this).attr('action');
               
                $.ajax({
                    url:action,
                    data:$(this).serialize(),
                    method:"POST",
                    success:function(res) {
                        window.location.reload();
                    }
                });
                
                return false;
            });

        });
    </script>  



@stop