<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciamento de Tarefas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
  
  <link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" />  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body, html {background-image:url('/storage/fundo.png');}
    * {padding:0;margin:0;list-style: none;box-sizing: border-box;}
    .table-cell-edit{background-color: rgba(0,0,0,0.5);color:#FFF;cursor: pointer;}
    .alvo {cursor:pointer;}
    ::-webkit-scrollbar {width: 12px;}
    ::-webkit-scrollbar-track {background: orange;}
    ::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;}  
    textarea {resize: none;}   
  </style>
</head>
<body>
    
    <section class="d-flex justify-content-between" style="flex-wrap: wrap;">

        <!--TOPO-->
        <div class="d-flex text-white align-items-center justify-content-between" style="flex-basis:100%;height:5vh">
            <span style="margin-left:8px;">GERENCIAMENTO CLIENTES PESSOA FÍSICAS</span>
            <a href="{{route('admin.home')}}" class="text-white mr-2 border-bottom">Dashboard</a>
        </div>
        <!--Fim TOPO-->


        <!--COLUNA LEFT-->
        <div class="d-flex flex-column text-white ml-1" style="flex-basis:15%;height:95vh;">

            <div class="py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;">
                <h5 class="text-center d-flex align-items-center justify-content-center border-bottom py-2">Tarefas</h5>
                <ul class="d-flex flex-column" style="margin-bottom:0px;">
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 atrasada">
                            <span class="ml-2" style="font-weight: bold;">Atrasadas</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtd_atrasada}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 hoje">
                            <span class="ml-2" style="font-weight: bold;">Hoje</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtd_hoje}}</span>
                        </a>    
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 semana">
                            <span class="ml-2" style="font-weight: bold;">Semana</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtd_semana}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 mes">
                            <span class="ml-2" style="font-weight: bold;">Mês</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtd_mes}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 todos">
                            <span class="ml-2" style="font-weight: bold;">Todos</span>
                            <span class="mr-2" style="font-weight: bold;">{{$clientes_total}}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex flex-column mt-2 py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;">
                <h5 class="text-center d-flex align-items-center justify-content-center border-bottom py-2">Clientes</h5>
                <ul class="d-flex flex-column" style="margin-bottom:0px;">
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Total Geral</span>
                        <span class="mr-2" style="font-weight: bold;">{{$clientes_total}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Em Negociação</span>
                        <span class="mr-2" style="font-weight: bold;">{{$negociacao}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Finalizados</span>
                        <span class="mr-2" style="font-weight: bold;">{{$finalizados}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Cadastrados no Mês</span>
                        <span class="mr-2" style="font-weight: bold;">{{$cadastrado_mes}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Perdidos</span>
                        <span class="mr-2" style="font-weight: bold;">{{$perdidos}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Perdidos no Mês</span>
                        <span class="mr-2" style="font-weight: bold;">{{$perdidos_mes}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Finalizados no Mês</span>
                        <span class="mr-2" style="font-weight: bold;">{{$finalizados_mes}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2" style="font-weight: bold;">Em Negociação no Mês</span>
                        <span class="mr-2" style="font-weight: bold;">{{$negociacao_mes}}</span>
                    </li>
                </ul>
            </div>


        </div>
        <!--FIM COLUNA LEFT-->

        <!--COLUNA CENTRO-->
        <div class="text-white p-2 align-self-start" style="flex-basis:45%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
            <div id="table" class="py-3">
                <table id="tabela" class="table listarclientes">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Tarefa</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>   
            </div> 
        </div>  
        <!--FIM COLUNA CENTRO-->
        
        <!--COLUNA RIGHT-->
        <div class="d-flex mr-1" style="flex-basis:39%;flex-wrap: wrap;height:95vh;">
            <!---FORM--->
            <div class="py-2" style="background-color:rgba(0,0,0,0.5);border-radius:5px;height:380px;">
                <form action="">

                    <div class="form-row" style="margin-right: 0;margin-left:0;">
                        <div class="col">
                            <span class="text-white">Cliente:</span>
                            <input type="text" name="nome" id="nome" class="form-control">
                        </div>
                        <div class="col">
                            <span class="text-white">Cidade:</span>
                            <input type="text" name="cidade" id="cidade" class="form-control">
                        </div>
                    </div>

                    <div class="form-row" style="margin-right: 0;margin-left:0;">
                        <div class="col">
                            <span class="text-white">Telefone:</span>
                            <input type="text" name="telefone" id="telefone" class="form-control">
                        </div>
                        <div class="col">
                            <span class="text-white">Email:</span>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>
                    </div>

                    <div style="display: flex;">
                        <div style="flex-basis:22%;margin-right:2%;margin-left:5px;">
                            <span class="text-white">Data Cadastro:</span>
                            <input type="text" name="data_cadastro" id="data_cadastro" class="form-control">
                        </div>
                        <div style="flex-basis:10%;margin-right:2%;">
                            <span class="text-white">Dias:</span>
                            <input type="text" name="dias_cadastro" id="dias_cadastro" class="form-control">
                        </div>
                        <div style="flex-basis:22%;margin-right:2%;">
                            <span class="text-white">Ultimo Contato:</span>
                            <input type="text" name="ultimo_contato" id="ultimo_contato" class="form-control">
                        </div>
                        <div style="flex-basis:10%;margin-right:2%;">
                            <span class="text-white">Dias:</span>
                            <input type="text" name="dias_contato" id="dias_contato" class="form-control">
                        </div>
                        <div style="flex-basis:29%;margin-right:4px;">
                            <span class="text-white">Origem Leads:</span>
                            <input type="text" name="origem_leads" id="origem_leads" class="form-control">    
                        </div>    
                    </div>

                    <div style="display:flex;flex-basis:100%;">
                        <div style="flex-basis:48%;margin-right:2%;margin-left:5px;">
                            <span class="text-white">Quantidade de Vidas:</span>
                            <input type="text" name="quantidade_vidas" id="quantidade_vidas" class="form-control">
                        </div>
                        <div style="flex-basis:48%;">
                            <span class="text-white">Status:</span>
                            <input type="text" name="status" id="status" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex">
                        <div style="flex-basis:98%;margin-left:5px;">
                            <span class="text-white">Descrição:</span>
                            <textarea name="descricao_tarefa" id="descricao_tarefa" name="descricao_tarefa" class="form-control"></textarea>
                        </div>
                    </div>


                    <div style="display:flex;margin:5px 0 0 0;" class="d-flex justify-content-center">
                        <a href="#" data-tarefa data-toggle="modal" data-target="#cadastrarClienteClienteEspecifico" style="pointer-events: none;background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;">Nova Tarefa</a>
                        <a href="#" data-orcamento style="background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;pointer-events: none;">Orçamento</a>
                        <a href="#" data-contrato style="background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;pointer-events: none;">Contrato</a>
                        <a href="#" data-perda data-toggle="modal" data-target="#motivoDaPerda" style="background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;pointer-events: none;">Perda</a>
                    </div>

                    

                </form>
            </div>
            <!---FIM FORM--->

            <!--TIMELINE--->
            <div style="overflow-y:scroll;background-color:rgba(0,0,0,0.5);border-radius:5px;height:calc(100% - 385px);flex-basis:100%;" id="historico">
                
                
                
            </div>


            <!--FIM TIMELINE--->

            
           

        </div>
        <!--FIM Coluna RIGHT-->


        <!--Modal de cadastro com cliente especifico Cadastrar Nova Atividade-->
    <div class="modal fade" id="cadastrarClienteClienteEspecifico" tabindex="-1" role="dialog" aria-labelledby="cadastrarClienteClienteEspecificoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color:rgba(0,0,0,0.5);">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:#FFF;">Cadastrar Nova Atividade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color:#FFF;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" name="nova_atividade">
                    @csrf                    
                    <div class="form-group">
                        <label for="title" style="color:#FFF;">Titulo:</label>
                        <select name="titulo_id" id="titulo_id" class="form-control">
                            <option value="">--Titulo Da Tarefa--</option>
                            @foreach($titulos as $t)
                                <option value="{{$t->id}}">{{$t->titulo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="cliente_id" id="cliente_id_cadastrado_aqui" />
                    <div class="form-group">
                        <label for="" style="color:#FFF;">Data</label>
                        <input type="date" name="data" id="data" class="form-control">
                        @if($errors->has('data'))
                            <p class="alert alert-danger">{{$errors->first('data')}}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="descricao" style="color:#FFF;">Descrição:</label>
                        <textarea name="descricao" id="descricao" class="form-control" rows="5"></textarea>
                        @if($errors->has('descricao'))
                            <p class="alert alert-danger">{{$errors->first('descricao')}}</p>
                        @endif
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" value="Agendas Tarefa">
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
                
            </div>
            </div>
        </div>
    </div>
    <!--Fim Modal de cadastro com cliente especifico Cadastrar Nova Atividade-->

    <!------Modal Perda Cliente---------->
    <div class="modal fade" id="motivoDaPerda" tabindex="-1" aria-labelledby="motivoDaPerdaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:rgba(0,0,0,0.5)">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="motivoDaPerdaLabel">Motivo Da Perda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="motivo_perda_tarefa" id="motivo_perda_tarefa">
                        <input type="hidden" name="motivo_cliente_id" id="motivo_cliente_id">
                        <input type="hidden" name="tarefa_id_cadastrado_aqui" id="tarefa_id_cadastrado_aqui">
                        @csrf
                        <div id="motivo_perda_error"></div>
                        <div class="form-row">
                            @foreach($motivos as $k => $v)
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="radio" id="motivo_perda" name="motivo" value="{{$v->id}}" />
                                        <label for="motivo_perda" class="text-white">{{$v->descricao}}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>    
                        <div id="motivo_textarea">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                    </form>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!------Fim Modal Perda Cliente---------->





</section>

<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(function(){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let ta = $(".listarclientes").DataTable({
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                "url":"{{ route('clientes.ajaxclienteslistapf') }}",
                "dataSrc": ""
            },
            "lengthMenu": [10,20,30,40,100],
            "ordering": true,
            "paging": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            columns: [
                {data:"nome",name:"nome"},
                {data:"telefone",name:"telefone"},
                {data:"tarefas[0].titulo.titulo",name:"tarefa"},
                {data:"tarefas[0].data",name:"data",width:'15%'},
                
            ],
            "columnDefs": [
                    {
                        "targets": 3,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            let datas = cellData.split("T")[0]
                            let alvo = datas.split("-").reverse().join("/")
                            $(td).html(alvo)    
                        }
                    }    
                ],
            rowCallback: function (row, data) {
                if ( $(row).hasClass('odd') ) {
                    $(row).addClass('table-cell-edit');
                } else {
                    $(row).addClass('alvo');
                }
            }
        });
        
        var table = $("#tabela").DataTable();
        // var table = $("body").find("#tabela").DataTable();
        $('table').on('click', 'tbody tr', function () {
            let data = table.row(this).data();
            console.log(data);
            let quantidade_vidas = 0;
            if(data.cotacao && !!data.cotacao) {
                //quantidade_vidas = data.cotacao.somarCotacaoFaixaEtaria.soma;
                quantidade_vidas = data.cotacao.somar_cotacao_faixa_etaria[0].soma;
            }
            
            let data_criacao = data.created_at.split("T")[0].split("-").reverse().join("/");
            let ultimo_contato = data.ultimo_contato.split("-").reverse().join("/");
            let criacao = new Date(data.created_at.split("T")[0]);
            

            
            const now = new Date(Date.now());
            const hoje = new Date(now.toISOString().split("T")[0]);
            const diferenca   = new Date(hoje) - new Date(criacao)
            const diferencaUltimo   = new Date(hoje) - new Date(data.ultimo_contato);
            const diferencaEmDias = diferenca / (1000 * 60 * 60 * 24);
            const ultimoEmDias = diferencaUltimo / (1000 * 60 * 60 * 24);


            $("input[name='nome']").val(data.nome);
            $("input[name='email']").val(data.email);
            $("input[name='cidade']").val(data.cidade.nome);
            $("input[name='telefone']").val(data.telefone);
            $("input[name='data_cadastro']").val(data_criacao);
            $("input[name='ultimo_contato']").val(ultimo_contato);
            $("input[name='status']").val(data.etiqueta.nome);
            $("input[name='dias_cadastro']").val(diferencaEmDias);
            $("input[name='quantidade_vidas']").val(quantidade_vidas);
            $("textarea[name='descricao_tarefa']").val(data.tarefas[0].descricao);
            $("#cliente_id_cadastrado_aqui").val(data.id);
            $("#tarefa_id_cadastrado_aqui").val(data.tarefas[0].id);
            $("#motivo_cliente_id").val(data.id);

            //$(".total_tarefa").text(count(data.tarefas));

            $("#dias_contato").val(ultimoEmDias);
            $("#origem_leads").val(data.origem.nome);
            
            $("a[data-orcamento]").attr('style','background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;cursor:pointer').attr("href","/admin/cotacao/orcamento/"+data.id);
            $("a[data-contrato]").attr('style','background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;cursor:pointer').attr("href","/admin/cotacao/contrato/"+data.id);
            $("a[data-tarefa]").attr('style','background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;cursor:pointer');
            $("a[data-perda]").attr('style','background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;cursor:pointer');
            
            historicoCliente(data.id);

        });

        $(".hoje").on('click',function(){
            ta.ajax.url("{{ route('cliente.getTarefasParaHoje') }}").load();
            return false;
        });

        $(".atrasada").on('click',function(){
            ta.ajax.url("{{ route('cliente.getTarefasAtrasadasAjax') }}").load();
            return false;
        });

        $(".semana").on('click',function(){
            ta.ajax.url("{{ route('cliente.listarClientesSemanaAjax') }}").load();
            return false;
        });

        $(".mes").on('click',function(){
            ta.ajax.url("{{ route('cliente.listarClienteMesAjax') }}").load();
            return false;
        });

        $(".todos").on('click',function(){
            ta.ajax.url("{{ route('clientes.ajaxclienteslistapf') }}").load();
            return false;
        }); 

        $(".nova_tarefa").on('click',function(){
            let id = $().val();
            $('#cliente_id_cadastrado_aqui').val();
            return false;
        });  

        $("body").on('change','input[name="motivo"]',function(){
            let valor = $(this).val();
            if(valor == 4) {
                $("#motivo_textarea").html("<label for='descricao_motivo' class='text-white'>Porque Sem interesse?</label><textarea name='descricao_motivo' id='descricao_motivo' rows='4' cols='60'></textarea>")
            } else {
                $("#motivo_textarea").html("");
            }
        });

        $("body").on('submit',"form[name='motivo_perda_tarefa']",function(){
            let form = $(this);
            $.ajax({
                url:"{{route('tarefas.motivoPerdaTarefa')}}",
                method:"POST",
                data:$(this).serialize(),
                beforeSend:function() {
                    
                    if ($('input[name="motivo"]:checked').length == 0) {
                        $("#motivo_perda_error").html("<p class='alert alert-danger text-center'>Marque o motivo pelo menos 1 motivo</p>");
                        $("#motivoDaPerda").modal('show');
                        return false;
                    } else {
                        $("#motivo_preco_error").html("");
                    }

                    if($('input[name="motivo"]:checked').val() == 4) {
                        if($('#descricao_motivo').val() == "") {
                            $("#motivoDaPerda").modal('show');
                            $("#motivo_textarea").append("<p class='alert alert-danger text-center'>Explique o motivo do cliente estar sem interesse</p>")
                            return false;
                        }
                    }
                    return true;                   
                },

                success:function(res) {
                    
                    if(res != "error") {
                        $("#motivoDaPerda").modal('hide');
                        $('input[name="motivo"]').prop('checked', false);
                        $("#descricao_motivo").val('');
                        $("#motivo_textarea").html("");
                        
                        ta.ajax.url("{{ route('clientes.ajaxclienteslistapf') }}").load();
                    } else {

                    }
                }
            })
            return false; 
        });










        $("form[name='nova_atividade']").on('submit',function(e){
            var form = $(this);
            $.ajax({
                url:"{{route('tarefas.cadastrarTarefasAjax')}}",
                method:"POST",
                data:$(this).serialize(),
                beforeSend:function() {
                    if(form.find("#title").val() == "") {
                        $("#error_titulo").html("<p class='alert alert-danger'>Título e campo obrigatório</p>")
                    } else {
                        $("#error_titulo").html("");
                    }
                     
                    if(form.find("#cliente_id").val() == "") {
                        $("#error_cliente_id").html("<p class='alert alert-danger'>Cliente e campo obrigatório</p>")
                    } else {
                        $("#error_cliente_id").html("");
                    }

                    if(form.find("#data").val() == "") {
                        $("#error_data").html("<p class='alert alert-danger'>Data e campo obrigatório</p>")
                    } else {
                        $("#error_data").html("");
                    }

                    if(form.find("#descricao").val() == "") {
                        $("#error_descricao").html("<p class='alert alert-danger'>Descrição e campo obrigatório</p>")
                    } else {
                        $("#error_descricao").html("");
                    }
                },
                success:function(res) {
                    $("#cadastrarClienteClienteEspecifico").modal('hide');
                    ta.ajax.reload();
                    form.find('#title').val('');
                    form.find('#cliente_id').val('');
                    form.find('#data').val('');
                    form.find('#descricao').val('');
                    historicoCliente(res)

                }
            });    
            
            return false;
        });

        function historicoCliente(id) {
            $.ajax({
                url:"{{route('cliente.historicoCliente')}}",
                data:"id="+id,
                method:"POST",
                success:function(res) {
                    $("#historico").html(res);
                }
            })
        }

    });
</script>
</body>
</html>