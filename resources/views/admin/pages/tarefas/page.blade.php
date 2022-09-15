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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    
    body, html {background:rgb(0,84,183);}
    .c1 {height: 5vh;background-color:rgb(86,135,220);border-bottom:2px solid #FFF;}
    .c1 a {
        color:#FFF;
    }
    .c2 {height:95vh;border-right: 2px solid #FFF;}
    .c3 {height:95vh;position: relative;z-index: 1;overflow-y:auto;}
    .c3::before {content: "";position: absolute;top: 0;left: 0;width: 100%;height: 100%;opacity: .1;z-index: -1;background-image: url('/storage/logo-hapvida.png');background-position: center center;background-size: cover;}
    ::-webkit-scrollbar {width: 12px;}
    ::-webkit-scrollbar-track {background: orange;}
    ::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;}    
    .c4 {height:95vh;border-left: 2px solid #FFF;}
    ul {list-style:none;display:flex;flex-direction:column;flex-basis:100%;padding:0px;margin:0px;}
    ul li {display:flex;cursor: pointer;border-bottom:2px solid #FFF;}
    ul li:hover {background-color: #FFF;color:#000;}
    ul li a {color:rgb(253,183,19);font-weight: bold;display:flex;flex-basis: 100%;}
    ul li a:hover {color:#000;}

    .tarefa {margin:0 0 0 30px;padding:10px 0;color:#FFF;}
    

    .personalizadas {margin:0 0 0 30px;padding:10px 0;color:#FFF;}

    
    .alvo p {padding:5px 0;margin:0px;color:#FFF;font-weight:bold;border-bottom:2px solid #FFF;text-align:center;}
    .alvo:hover {cursor:pointer;background-color:#FFF;}
    .alvo:hover p {color:#000 !important;}
    
    .alvos {font-weight: bold;border-bottom:2px solid #FFF;}
    .alvos p {padding:0px;margin:0px;color:#FFF;}
    .alvos:hover {cursor: pointer;}
    .alvos:hover p {color:#000;}

    .bg-white {color:#000 !important; text-decoration: underline;}


    .c41 {height:60%;background-color: rgb(86,135,220);} 
    .c42 {height:40%;background-color: rgb(86,135,220);}
    .ds-none {display:none !important;}
    .icone {position:relative;top:15px;left:20px;color:#FFF;}
    ul li:hover .icone {color:#000;}
    .btn_adicionar {border:2px solid #FFF;background-color:#333;color:#FFF;}
    .btn_adicionar:hover {background-color: #FFF;color:#000;border:2px solid #000;}
    .nova_atividade {
        border:2px solid #FFF;
        background-color:#333;
        color:#FFF;
        margin-bottom: 10px;
    
    }
  </style>
</head>
<body>
    <section class="d-flex c1">
        <h4 style="color:#FFF;" class="ml-3">Gerenciamento de Tarefas</h4>
        <a href="{{route('admin.home')}}" class="ml-auto align-self-center mr-4 bold">Dashboard</a>
    </section>
    <section class="d-flex">
        <div style="flex-basis:15%;background-color:rgb(86,135,220);" class="flex-column c2">
            <div>
                <ul id="lista_tarefas">
                    <li>
                        <i class="fas fa-exclamation icone"></i>
                        <a href="#" class="tarefa" data-tarefa="atraso">Atraso</a>
                    </li>
                    <li>
                        <i class="fas fa-calendar-week icone"></i>
                        <a href="#" class="tarefa" data-tarefa="hoje">Hoje</a>
                    </li>
                    <li>
                        <i class="fas fa-calendar-alt icone"></i>
                        <a href="#" class="tarefa" data-tarefa="semana">Semana</a>
                    </li>
                    <li>
                        <i class="fas fa-align-justify icone"></i>
                        <a href="#" class="tarefa" data-tarefa="mes">Mês</a>
                    </li>
                    <li>
                        <i class="fas fa-search icone"></i>    
                        <a href="#" class="personalizadas">Personalizado</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-center align-items-end" style="height:494px;">
                <button class="mt-3 w-75 btn_adicionar d-flex justify-content-center align-self-end mb-3" type="button" data-toggle="modal" data-target="#exampleModal">Adicionar Tarefa</button>
            </div>
        </div>
        <div style="flex-basis:35%;background-color:rgb(86,135,220);" class="c3">
            
        </div>
        <div style="flex-basis:50%;background-color:rgb(86,135,220);" class="border-right c4 flex-column">
            
            <div class="c41 d-flex flex-column">
                
                <div class="w-75 justify-content-center ds-none mt-1" style="margin:0 auto;">
                    <input type="hidden" name="cliente_id_oculto" id="cliente_id_oculto" />
                    <div class="form-group" style="margin-bottom:0px;">
                        <div class="form-row">
                            <div class="col">
                                <label for="titulo_tarefa" style="margin-bottom:0;color:#FFF">Titulo Tarefa:</label>
                                <input type="text" class="form-control" name="titulo_tarefa" id="titulo_tarefa">
                            </div>
                            <div class="col">
                                <label for="nome_cliente" style="margin-bottom:0;color:#FFF">Cliente:</label>
                                <input type="text" class="form-control" name="nome_cliente" id="nome_cliente">
                            </div>
                        </div>            
                    </div>
                    <div class="form-group" style="margin-bottom:0px;">
                        <div class="form-row">
                            <div class="col">
                                <label for="telefone_cliente" style="margin-bottom:0;color:#FFF">Telefone:</label>
                                <input type="text" class="form-control" name="telefone_cliente" id="telefone_cliente">
                            </div>
                            <div class="col">
                                <label for="email_cliente" style="margin-bottom:0;color:#FFF">Email:</label>
                                <input type="text" class="form-control" name="email_cliente" id="email_cliente">
                            </div>
                        </div>                
                    </div>
                    <div class="form-group" style="margin-bottom:0px;">
                        <div class="form-row">
                            <div class="col">
                                <label for="data_cadastro" style="margin-bottom:0;color:#FFF;">Data Cadastro:</label>
                                <input type="text" name="data_cadastro" id="data_cadastro" class="form-control">
                            </div>
                            <div class="col">
                                <label for="data_ultimo_contato" style="margin-bottom:0;color:#FFF;">Data Ulitmo Contato:</label>
                                <input type="text" name="data_ultimo_contato" id="data_ultimo_contato" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0px;">
                        <label for="descricao_tarefa" style="margin-bottom:0;color:#FFF;">Descrição:</label><br />
                        <textarea name="descricao_tarefa" id="descricao_tarefa" name="descricao_tarefa" cols="76" rows="5"></textarea>
                    </div>
                </div>
                <div style="background-color:rgb(86,135,220);" class="w-100 d-flex flex-column ds-none mt-4" style="clear:both;">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="nova_atividade" data-toggle="modal" data-target="#cadastrarClienteClienteEspecifico">Nova Atividade</button>
                    </div>
                    <div class="d-flex justify-content-center" style="border-bottom:2px solid #FFF;">
                        <a href="" class="orcamento_cliente" style="border-top:2px solid #FFF;border-right:2px solid #FFF;border-left:2px solid #FFF;color:#FFF;padding:0 10px;margin:0 25px 0 0;">Orçamento</a>
                        <a href="" class="contrato_cliente" style="border-top:2px solid #FFF;border-right:2px solid #FFF;border-left:2px solid #FFF;color:#FFF;padding:0 10px;margin:0 25px 0 0;">Contrato</a>
                        <a href="" class="perda_contato" style="border-top:2px solid #FFFF;border-right:2px solid #FFF;border-left:2px solid #FFF;color:#FFF;padding:0 10px;margin:0 25px 0 0;">Perda</a>
                    </div>    
                </div>
            </div>
            <div class="c42 ds-none">
                <h4 class="text-center py-2" style="color:#FFF;border-bottom:2px solid #FFF;padding:0px;margin:0px;font-weight:bold;">Historico do Cliente</h4>
                <div class="c421"></div>
            </div>
        </div>
    </section>

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
                        <input type="text" name="title" id="title" class="form-control">
                        @if($errors->has('title'))
                            <p class="alert alert-danger">{{$errors->first('title')}}</p>
                        @endif
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


    <!--Modal de cadastro listando os cliente CRIAR TAREFA-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color:rgba(0,0,0,0.5);">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:#FFF;">Criar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color:#FFF;">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form action="" method="post" name="criar_tarefa">
                        @csrf
                        <div class="form-group">
                            <label for="title" style="color:#FFF;">Titulo:</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Digitar o título">
                            <div id="error_titulo"></div>
                        </div>
                        <div class="form-group">
                            <label for="title" style="color:#FFF;">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control">
                                <option value="">--Listar Clientes--</option>
                                @foreach($clientes as $cc)
                                <option value="{{$cc->id}}">{{$cc->nome}}</option>
                                @endforeach
                            </select>
                            <div id="error_cliente_id"></div>
                        </div>
                        <div class="form-group">
                            <label for="data" style="color:#FFF;">Data</label>
                            <input type="date" name="data" id="data" class="form-control">
                            <div id="error_data"></div>
                        </div>
                        <div class="form-group">
                            <label for="descricao" style="color:#FFF;">Descrição:</label>
                            <textarea name="descricao" id="descricao" class="form-control" rows="5" placeholder="Digitar a descrição"></textarea>
                            <div id="error_descricao"></div>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="Agendas Tarefa">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!--Fim listagem de cliente id CRIAR TAREFA-->

    
    <div class="modal fade" id="motivoDaParda" tabindex="-1" aria-labelledby="motivoDaPerdaLabel" aria-hidden="true">
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
                        <input type="hidden" name="motivo_perda_tarefa_id" id="motivo_perda_tarefa_id">
                        @csrf
                        <div class="form-row">
                            @foreach($motivos as $k => $v)
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="radio" id="motivo_preco" name="motivo" value="{{$v->id}}" />
                                        <label for="motivo_preco" class="text-white">{{$v->descricao}}</label>
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


    <!---Data Personalizadas---------->
    <div class="modal fade" id="dataPersonalizadas" tabindex="-1" aria-labelledby="dataPersonalizadasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:rgba(0,0,0,0.5)">
            <div class="modal-header">
                <h5 class="modal-title" id="dataPersonalizadasLabel" style="color:#FFF;">Datas Personalizadas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color:#FFF;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" name="tarefas_personalizadas">
                    <div class="form-group">
                        <label for="" style="color:#FFF;">Data Inicial:</label>
                        <input type="date" name="data_inicial" id="data_inicial" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" style="color:#FFF;">Data Final:</label>
                        <input type="date" name="data_final" id="data_final" class="form-control">
                    </div>
                    <input type="submit" value="Pesquisar" class="btn btn-info btn-block" />   
                </form>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </div>
        </div>
    </div>
    <!---Fim de Datas Personalizadas-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#lista_tarefas .tarefa").on('click',function(){
            let alvo = $(this).attr('data-tarefa');
            $.ajax({
                data:"alvo="+alvo,
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        console.log("Nada");
                    }
                }
            });
            return false;
        });
        $("#lista_tarefas .personalizadas").on('click',function(){
            $("#dataPersonalizadas").modal('show'); 
        });
        $("form[name='tarefas_personalizadas']").on('submit',function(){
            $.ajax({
                url:"{{route('tarefas.personalizadas')}}",
                method:"POST",
                data:$(this).serialize(),
                success:function(res) {
                    if(res != "nada") {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("<p>Sem Resultado para esse intervalo de datas</p>");
                    }
                    $("#dataPersonalizadas").modal('hide');
                }
            });
            return false;
        });
        $("body").on("submit","form[name='criar_tarefa']",function(){
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
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        console.log("Nada");
                    }
                    $("#exampleModal").modal('hide');
                    form.find('#title').val('');
                    form.find('#cliente_id').val('');
                    form.find('#data').val('');
                    form.find('#descricao').val('');
                    let id_tarefa = $("body").find("#tarefa_cadastrada_id").val();            
                    clicarCard(id_tarefa)
                }
            });    
            return false;
        });
        $("body").on('submit',"form[name='motivo_perda_tarefa']",function(){
            $.ajax({
                url:"{{route('tarefas.motivoPerdaTarefa')}}",
                method:"POST",
                data:$(this).serialize(),
                success:function(res) {
                    if(res == "sucesso") {
                        $("#motivoDaParda").modal('hide');
                        $('input[name="motivo"]').prop('checked', false);
                        $("#descricao_motivo").val('');
                        $("#motivo_textarea").html("");
                    } else {

                    }
                }
            })
            return false; 
        });
        $("body").on("submit","form[name='nova_atividade']",function(){
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
                    
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        console.log("Nada");
                    }
                    $("#cadastrarClienteClienteEspecifico").modal('hide');
                    form.find('#title').val('');
                    form.find('#cliente_id').val('');
                    form.find('#data').val('');
                    form.find('#descricao').val('');
                    let id_tarefa = $("body").find("#tarefa_cadastrada_id").val();            
                    clicarCard(id_tarefa)
                }
            });    
            return false;
        });
        $("body").on('click','.alvo',function(){
            let id_tarefa = $(this).attr('data-id');
            clicarCard(id_tarefa);
        });
        $(".perda_contato").on('click',function(){
            $("#motivoDaParda").modal('show');
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
        function clicarCard(id) {
            
            $(".alvo p").removeClass('bg-white');   
            // $(".alvo p").addClass('alvo');

            $(".alvo[data-id="+id+"] p").addClass('bg-white');
            //$(".alvo[data-id="+id+"]").removeClass('alvo');


            $.ajax({
                data:"id_tarefa="+id,
                url:"{{route('tarefa.listarTarefaPorId')}}",
                method:"POST",
                success:function(res) {
                    let data_cadastro = res.cliente.created_at.split("T")[0].split("-").reverse().join("/");
                    let data_ultimo_contato = res.cliente.ultimo_contato.split("-").reverse().join("/");
                    $("div").removeClass("ds-none");
                    $("#titulo_tarefa").val(res.title);
                    $("#nome_cliente").val(res.cliente.nome);
                    $("#telefone_cliente").val(res.cliente.telefone);
                    $("#email_cliente").val(res.cliente.email);
                    $("#data_cadastro").val(data_cadastro);
                    $("#data_ultimo_contato").val(data_ultimo_contato);
                    $("#descricao_tarefa").val(res.descricao);
                    $("#cliente_id_oculto").val(res.cliente.id);
                    $(".orcamento_cliente").attr("href","/admin/cotacao/orcamento/"+res.cliente.id);
                    $(".contrato_cliente").attr("href","/admin/cotacao/contrato/"+res.cliente.id);
                    $("#cliente_id_cadastrado_aqui").val(res.cliente.id);
                    $("#motivo_perda_tarefa_id").val(res.id);
                    pegarHistorico(res.cliente.id)
                }
            });
        }
        function pegarHistorico(id) {
            $.ajax({
                url:"{{route('tarefa.pegarHisticoDoCliente')}}",
                data:"id="+id,
                method:"POST",
                success:function(res) {
                    $(".c421").html(res);
                }
            });
        }
    });
</script>
</body>
</html>