@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('title', 'Clientes')

@section('content_header')
@can('clientes_dos_corretores')
                    <a href="{{route('clientes.corretores')}}" class="text-info"><i class="fas fa-users"></i></a>
                @endcan     
    <div class="row">
        <h1>Clientes <a href="{{route('clientes.cadastrar')}}" class="btn btn-warning"><i class="fas fa-plus"></i></a></h1>    
        
        
       
        
        <div class="ml-auto">
            
            <div class="ml-auto">
                <select id="search" name="search" class="form-control select2-single">
                    <option value="">Escolha um cliente</option>
                    @foreach($clientesAll as $c)
                    <option value="{{$c->id}}">{{$c->nome}}</option>
                    @endforeach
                </select>    
            </div>
        

            <!-- Filtrar Tarefas -->
            <div class="btn-group-vertical dropleft menu-tarefas">
                <button type="button" class="btn btn-default dropdown-toggle ml-auto" data-toggle="dropdown" aria-expanded="false">Filtrar Tarefas</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item cliente_semtarefa" href="#">Clientes Sem Tarefa</a></li>
                    <li><a class="dropdown-item cliente_atrasado" href="#">Tarefas Atrasadas</a></li>
                    <li><a class="dropdown-item tarefas_realizadas" href="#">Tarefas Realizadas</a></li>
                    <li><a class="dropdown-item proximosdias" href="#">Tarefas Proximos 03 dias</a></li>
                    <li><a class="dropdown-item tarefashoje" href="#">Tarefas Hoje</a></li>
                    <div class="dropdown-divider"></div>
                    <li class="text-center">
                        <a class="dropdown-item listar_todos_tarefas" href="#" style="color:black;">Listar Todas Tarefas</a>
                    </li>
                </ul>    
            </div>
            <!-- Fim Filtrar Tarefas -->


            <!-- Filtrar Cliente -->
            <div class="btn-group-vertical dropleft menu-clientes">
                <button type="button" class="btn btn-default dropdown-toggle ml-auto" data-toggle="dropdown" aria-expanded="false">Filtrar Clientes</button>
                <ul class="dropdown-menu">
                    @if(count($etiquetas) >= 1)
                        @foreach($etiquetas as $et)
                            <li>
                                <a class="dropdown-item etiquetas" href="#" data-etiqueta="{{$et->id}}">
                                    <div style="display:flex;align-items: center;">
                                        <div style="width:20px;height:20px;border-radius:50%;background-color:{{$et->cor}}"></div> 
                                        &nbsp;{{$et->nome}}
                                    </div>    
                                </a>
                            </li>
                        
                        @endforeach
                    @endif
                    <div class="dropdown-divider"></div>
                    <li class="text-center">
                        <a class="dropdown-item listar-todos" href="#" style="color:black;">Listar Todos</a>
                    </li>
                </ul>    
            </div>
            <!-- Fim Filtrar Cliente -->
        </div>
    </div>    
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if(count($clientes) >= 1)
                @foreach($clientes as $c)
                    <div style="border:1px solid black;display:flex;margin-bottom:5px;justify-content:space-between;padding:5px 0;box-sizing: border-box;align-items: center;">
                        <div style="flex-basis:3%;justify-content: flex-end;margin-left:5px;">
                            <div class="status" data-toggle="modal" data-target="#alterarModal" data-id="{{$c->etiqueta_id}}" data-cliente="{{$c->id}}" style="width:20px;height:20px;border-radius:50%;background-color:{{$c->cor}}"></div>
                        </div>
                        <div style="flex-basis:25%;">
                            <div><b>{{$c->nome}}</b> | {{isset($c->user) && !empty($c->user) ? $c->user : ""}}</div>
                            <div>{{$c->email}}</div>
                            <div style="display:flex;">
                                <span>{{date('d/m/Y',strtotime($c->created_at))}}</span>
                                <span style="margin-left:50px;">{{date('d/m/Y',strtotime($c->ultimo_contato))}}</span>
                            </div>
                        </div>
                        <div style="flex-basis:25%;margin-right:2px;">
                            <div>{{$c->cidade}}</div>
                            <div>{{$c->telefone}}</div>
                            <div>
                                @if($c->tarefas_quantidade >= 1) 
                                    <span>Com Tarefa</span>
                                @else
                                    <span>Sem Tarefa</span>
                                @endif
                            </div>
                        </div>
                        <div style="flex-basis:15%;">
                            <div>Vidas {{$c->quantidade}}</div>
                            <div>{{$c->pessoa_fisica == 1 ? "Pessoa Física" : "Pessoa Jurídico"}}</div>
                            <div>{{$c->nome_etiqueta}}</div>
                        </div>
                        <div style="flex-basis:20%;justify-content: space-between;display:flex;flex-direction: column;">
                            <div style="display:flex;justify-content: space-between;">
                                <a class="" href="{{route('cotacao.orcamento',$c->id)}}" style="background-color:green;color:white;width:80%;border-radius:10px;text-align: center;background-color:rgb(43,128,0);">Orçamento</a>
                                <span style="padding:3px;" class="bg-info"><i class="fas fa-phone"></i></span>
                            </div>
                            <div style="display:flex;justify-content: space-between;margin:2px 0">
                                <a class="" href="{{route('cotacao.contrato',$c->id)}}" style="background-color:blue;color:white;width:80%;border-radius:10px;text-align: center;background-color:rgb(0,39,251);">Contrato</a>
                                <span class="bg-success" style="padding:4px;"><i class="fab fa-whatsapp"></i></span>
                            </div>
                            <div style="display:flex;justify-content: space-between;">
                                <a href="{{route('clientes.agendarTarefa',$c->id)}}" style="color:white;width:80%;border-radius:10px;text-align: center;background-color:rgb(249,3,110);">
                                    Tarefa
                                </a>  
                                <span class="bg-danger" style="padding:3px;"><i class="fas fa-envelope"></i></span>  
                            </div>
                        </div>
                    
                    </div>
                    <hr />
                @endforeach
            @else
                <h4 class="text-center">Sem Clientes há serem listados</h4>
            @endif
            <nav aria-label="">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="{{$clientes->previousPageUrl()}}"><<</a></li>
                @for($i=1;$i<=$clientes->lastPage();$i++)
                    <li class="page-item {{$i == $clientes->currentPage() ? 'active' : ''}}">
                        <a class="page-link" href="{{isset($filtro) && count($filtro) >= 1 ? $clientes->appends($filtro)->url($i) : $clientes->url($i)}}">{{$i}}</a>
                    </li>
                @endfor
                <li class="page-item"><a class="page-link" href="{{$clientes->nextPageUrl()}}">>></a></li>
            </ul>
        </nav>       
        </div>
        
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

@section('css')
<link rel="stylesheet" href="{{asset('vendor/select2/css/select2.min.css')}}" />    
<link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.css')}}" />
@endsection



@section('js')
<script src="{{asset('vendor/select2/js/select2.min.js')}}"></script>
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".menu-tarefas a").on('click',function(){
                $(".menu-tarefas > .dropdown-menu").dropdown('hide')
            });

            $(".menu-clientes a.etiquetas").on('click',function(){
                //$(this).closest('.dropdown-menu').dropdown('hide');
                $(".menu-clientes > .dropdown-menu").dropdown('hide')
            });

            


            $('#search').select2({
                theme: 'bootstrap4',
            });
            $('#alterarModal').on('show.bs.modal', function (event) {
                var alvo = $('input[name="id"]').val();
                
                
                $('input[type="radio"]').attr('checked',false);
                $('input[id="status_'+alvo+'"]').attr('checked',true);
                console.log(alvo);
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

            $('.etiquetas').on('click',function(){
                
                let etiqueta = $(this).attr("data-etiqueta");
                $.ajax({
                    url:"{{route('cliente.listarPorEtiqueta')}}",
                    method:"POST",
                    data:"id="+etiqueta,
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                    
                });
                return false;
            });

            $('.listar-todos').on('click',function(){
                $.ajax({
                    url:"{{route('cliente.listarPorEtiquetaAll')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                        $(".menu-clientes > .dropdown-menu").dropdown('hide')
                    }
                });
                return false;
            });


            $('.cliente_semtarefa').on('click',function(){
                $.ajax({
                    url:"{{route('cliente.semtarefasajax')}}",
                    method:"POST",
                    success:function(res) {
                        //console.log(res);
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                });
                return false;
            });

            $('.proximosdias').on('click',function(){
                $.ajax({
                    url:"{{route('cliente.tarefasProximas')}}",
                    method:"POST",
                    success:function(res) {
                        //console.log(res);
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                });
                return false;
            });

            window.$_GET = new URLSearchParams(location.search);
            let value = $_GET.get('ac');
            if(value && value == "atrasado") {
                
                    $.ajax({
                        url:"{{route('cliente.tarefasatrasadasajax')}}",
                        method:"POST",
                        success:function(res) {
                            $('.card-body').slideUp('fast',function(){
                                $(this).html(res).slideDown('slow');
                            });
                        }
                    });
                    return false;
                
            }

            if(value && value == "semtarefa") {
                $.ajax({
                    url:"{{route('cliente.semtarefasajax')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                });
                return false;
            }

            if(value && value == "proximas") {
                $.ajax({
                    url:"{{route('cliente.tarefasProximas')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                });
                return false;
            }

            if(value && value == "hoje") {
                $.ajax({
                    url:"{{route('cliente.tarefasParaHoje')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });             
                    }
                });
            }

            if(value && value == "etiquetas") {
                let id = $_GET.get('id');
                
                $.ajax({
                    url:"{{route('cliente.listarPorEtiqueta')}}",
                    method:"POST",
                    data:"id="+id,
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                    
                });
                return false;
                
            }

            $("body").on('change','input[name="mudarStatus"]',function(){
                if($(this).is(":checked")) {
                    let id = $(this).attr('data-id');
                    
                    $(this).closest("tr").fadeOut('slow');
                    $.ajax({
                        method:"POST",
                        url:"{{route('cliente.mudarStatusTarefaAjax')}}",
                        data:"id="+id,
                        success:function(res) {
                            if(res) {
                                $('.card-body').slideUp('fast',function(){
                                    $(this).html(res).slideDown('slow');
                                }); 
                            }
                        }
                    })
                } 
            });

            $("#search").on('change',function(){
                $.ajax({
                    url:"{{route('cliente.searchclienteAjax')}}",
                    method:"POST",
                    data:"id="+$(this).val(),
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
               });
               return false;  
            });

            $('.cliente_atrasado').on('click',function(){
                $.ajax({
                    url:"{{route('cliente.tarefasatrasadasajax')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                });
                return false;
            });

            $('.listar_todos_tarefas').on('click',function(){
                $.ajax({
                    url:"{{route('tarefas.listarTodasAsTarefasAjax')}}",
                    method:"POST",
                    data:"id="+$(this).val(),
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                });
                return false;
            });

            $(".tarefas_realizadas").on('click',function(){
               $.ajax({
                    url:"{{route('tarefa.tarefasRealizadas')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
               });
               return false;  
            });

            $('.tarefashoje').on('click',function(){
                $.ajax({
                    url:"{{route('cliente.tarefasParaHoje')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });             
                    }
                });
            });


            $("body").on('change','input[name="status_tarefas"]',function(){
                let id = $(this).attr("data-id");
                $.ajax({
                    url:"{{route('tarefas.marcarTarefasRealizarAjax')}}",
                    method:"POST",
                    data:"id="+id
                });
            });

            

            

           

        });
    </script>  



@stop