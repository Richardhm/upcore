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
    
    body, html {background-image:url('/storage/fundo.png');}
    .c1 {min-height: 5vh;border-bottom:2px solid #FFF;}
    .c1 a {
        color:#FFF;
    }
    .c2 {min-height:95vh;border-right: 2px solid #FFF;}
    .c3 {min-height:95vh;position: relative;z-index: 1;overflow-y:auto;}
    .c3::before {content: "";position: absolute;top: 0;left: 0;width: 100%;height: 100%;opacity: .1;z-index: -1;}
    ::-webkit-scrollbar {width: 12px;}
    ::-webkit-scrollbar-track {background: orange;}
    ::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;}    
    .c4 {min-height:95vh;border-left: 2px solid #FFF;}
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
    .c41 {height:40%;} 
    .c42 {height:60%;border-top:1px solid #FFF;}
    .ds-none {display:none !important;}
    .icone {position:relative;top:15px;left:20px;color:#FFF;}
    ul li:hover .icone {color:#000;}
    .btn_adicionar_tarefa {border:2px solid #FFF;background-color:#333;color:#FFF;}
    .btn_adicionar_tarefa:hover {background-color: #FFF;color:#000;border:2px solid #000;}
    .btn_adicionar_cliente {border:2px solid #FFF;background-color:#333;color:#FFF;}
    .btn_adicionar_cliente:hover {background-color: #FFF;color:#000;border:2px solid #000;}
    .nova_atividade {border:2px solid #FFF;background-color:#333;color:#FFF;margin-bottom: 10px;}
    .link_redirecionamento {
        border:2px solid #FFF;background-color:#333;color:#FFF;margin-bottom: 10px;text-align: center;
    }
    textarea {resize: none;}
  </style>
</head>
<body>
    <input type="hidden" name="parametro" id="parametro">
    <section class="d-flex c1">
        <h4 style="color:#FFF;" class="ml-3">Gerenciamento de Tarefas</h4>
        <a href="{{route('admin.home')}}" class="ml-auto align-self-center mr-4 bold">Dashboard</a>
    </section>
    <section class="d-flex">
        <div style="flex-basis:15%;" class="flex-column c2">
            <div>
                <ul id="lista_tarefas">
                    <li>
                        <i class="fas fa-user icone"></i>
                        <a href="#" class="tarefa" id="cliente" data-tarefa="cliente">Clientes</a>
                    </li>
                    <li>
                        <i class="fas fa-exclamation icone"></i>
                        <a href="#" class="tarefa" id="atraso" data-tarefa="atraso">Atraso</a>
                    </li>
                    <li>
                        <i class="fas fa-calendar-week icone"></i>
                        <a href="#" class="tarefa" id="hoje" data-tarefa="hoje">Hoje</a>
                    </li>
                    <li>
                        <i class="fas fa-calendar-alt icone"></i>
                        <a href="#" class="tarefa" id="semana" data-tarefa="semana">Semana</a>
                    </li>
                    <li>
                        <i class="fas fa-align-justify icone"></i>
                        <a href="#" class="tarefa" id="mes" data-tarefa="mes">Mês</a>
                    </li>
                    <li>
                        <i class="fas fa-search icone"></i>    
                        <a href="#" class="personalizadas">Personalizado</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-end" style="min-height:494px;">
                <div class="d-flex flex-column justify-content-center text-center w-100">
                    <button class="w-75 btn_adicionar_cliente mb-2 mx-auto" type="button" data-toggle="modal" data-target="#criarCliente">Adicionar Cliente</button>
                    <button class="w-75 btn_adicionar_tarefa mb-1 mx-auto" type="button" data-toggle="modal" data-target="#exampleModal">Adicionar Tarefa</button>
                </div>
                
            </div>
        </div>
        <div style="flex-basis:45%;" class="c3">
           <h4 class="text-white text-center" style="padding:8px;">Clientes</h4>
           <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-white">Nome</th>
                            <th class="text-white">Tarefa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cc)
                            <a href="">
                                <tr>
                                    <td class="text-white">{{$cc->nome}}</td>
                                    <td class="text-white">Primeiro Contato</td>
                                </tr>
                            </a>
                        @endforeach 
                    </tbody>    

                </table>
           </div>
          
        </div>
        <div style="flex-basis:40%;" class="border-right c4 flex-column">
            
            <div class="c41 d-flex">
                
                <div class="w-75 ds-none mt-1 ml-1">
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
                        <textarea name="descricao_tarefa" id="descricao_tarefa" name="descricao_tarefa" cols="50" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                <div class="w-25 ds-none ml-1 mt-1 d-flex justify-content-center">
                    <div class="d-flex flex-column mt-4" style="flex-basis:90%;">
                        <a type="button" class="nova_atividade w-100 text-center" data-toggle="modal" data-target="#cadastrarClienteClienteEspecifico">Nova Atividade</a>
                        <a href="" class="nova_atividade w-100 text-white orcamento_cliente text-center">Orçamento</a>
                        <a href="" class="nova_atividade w-100 text-white contrato_cliente text-center">Contrato</a>
                        <a href="" class="nova_atividade w-100 text-white perda_contato text-center">Perda</a>
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
                            <label for="titulo_id" style="color:#FFF;">Titulo:</label>
                            <select name="titulo_id" id="titulo_id" class="form-control">
                                <option value="">--Titulo Da Tarefa--</option>
                                @foreach($titulos as $t)
                                    <option value="{{$t->id}}">{{$t->titulo}}</option>
                                @endforeach
                            </select>
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
                        <div id="error_data_inicial"></div>
                    </div>
                    <div class="form-group">
                        <label for="" style="color:#FFF;">Data Final:</label>
                        <input type="date" name="data_final" id="data_final" class="form-control">
                        <div id="error_data_final"></div>
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

    <!---Criar Cliente --->
    <div class="modal fade" id="criarCliente" tabindex="-1" aria-labelledby="criarClienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:rgba(0,0,0,0.5)">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="criarClienteLabel">Cadastrar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="criar_cliente" id="criar_cliente">
                        @csrf    

                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nome" class="text-white">Nome:</label>
                                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome Cliente">    
                                    <div class="errornome"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cidade_id" class="text-white">Cidade:</label>
                                    <select name="cidade_id" id="cidade_id" class="form-control">
                                        <option value="">-- Escolher Cidade --</option>
                                        @foreach($cidades as $c)
                                        <option value="{{$c->id}}">{{$c->nome}}</option>    
                                        @endforeach
                                        
                                    </select>
                                    <div class="errorcidade"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="telefone" class="text-white">Celular:</label>
                                    <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone">  
                                    <div class="errortelefone"></div>  
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email" class="text-white">Email:</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email">  
                                    <div class="erroremail"></div>  
                                </div>
                            </div>

                        </div>    
                       <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                    </form>    
                </div>
                
            </div>
        </div>
    </div>




    <!---Fim Criar Cliente --->









<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert2/sweetalert2.js')}}"></script>
<script>
    $(function(){
        $('#telefone').mask('(00) 0 0000-0000');  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        




        $("#telefone").on('change',function(){
                let alvo = $(this);
                let telefone = $(this).val();
                $.ajax({
                    method:"POST",
                    data:"telefone="+telefone,
                    url:"{{route('cliente.verificartelefone')}}",
                    success:function(res) {
                        if(res != "nada" && res != "indisponivel") {
                            $("input[type='submit']").attr('disabled',true);
                            $('#email').val(res.email);
                            $('#nome').val(res.nome);
                            $("#cidade_id").val(res.cidade_id);
                            Swal.fire({
                                title: '<h4>Cliente '+res.nome+' já esta cadastrado!</h4>',
                                icon: 'info',
                                type: 'info',
                                showCloseButton: true,
                                html:
                                    '<hr />'+
                                    '<p>Cliente Cadastrado em '+res.data_criacao+'</p><p>Seu status atual é <b>'+res.etiqueta.nome+'</b></p><p>Cidade: <b>'+res.cidade.nome+'</b></p>'+
                                    '<p>O que deseja fazer?</p><hr />'+
                                    "<a class='btn btn-primary btn-sm mr-5' href='/admin/cotacao/orcamento/"+res.id+"'>Orçamento</a> <a class='btn btn-info btn-sm mr-5' href='/admin/cotacao/contrato/"+res.id+"'>Contrato</a><a class='btn btn-secondary btn-sm mr-5' href='{{route('clientes.index')}}'>Listar Clientes</a></div>",
                                showCancelButton: false,
                                showConfirmButton: false                            
                            });
                        }

                        if(res == "indisponivel") {
                            
                            alvo.closest('form').find("button[type='submit']").attr('disabled',true).text("Esse Telefone já esta cadastrado, tente outro");
                            
                            //$(this).closest('form').find("button[type='submit']").attr('disabled',true);
                            Swal.fire({
                                icon: 'error',
                                type:'error',
                                title: 'Oops...',
                                showCloseButton: true,
                                html:
                                    '<hr />'+
                                    '<h3>Esse Número de Telefone já esta cadastrado</h3>'
                            });
                            
                            
                        }
                        if(res == "nada") {
                            alvo.closest('form').find("button[type='submit']").attr('disabled',false).text("Enviar");
                        }
                    }
                });
        });

        $("#lista_tarefas #atraso").on('click',function(){
            var uri = window.location.href.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
            
            $.ajax({
                data:"alvo=atraso",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("Sem tarefa para atrasadas");
                    }
                }
            }); 
            return false;
        });

        $("#lista_tarefas #hoje").on('click',function(){
            var uri = window.location.href.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
            $.ajax({
                data:"alvo=hoje",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("<h3 class='text-center text-white mt-3'>Sem tarefa para hoje</h3>");
                    }
                }
            });
            return false;
        });

        $("#lista_tarefas #mes").on('click',function(){
            var uri = window.location.href.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
            $.ajax({
                data:"alvo=mes",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("<h3 class='text-center text-white mt-3'>Sem tarefa para hoje</h3>");
                    }
                }
            });
            return false;
        });

        $("#lista_tarefas #semana").on('click',function(){
            var uri = window.location.href.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
            $.ajax({
                data:"alvo=semana",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("<h3 class='text-center text-white mt-3'>Sem tarefa para hoje</h3>");
                    }
                }
            });
            return false;
        });

        $("#lista_tarefas .personalizadas").on('click',function(){
            var uri = window.location.href.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
            $("#dataPersonalizadas").modal('show'); 
            return false;
        });

        $("form[name='tarefas_personalizadas']").on('submit',function(){
            let form = $(this);
            $.ajax({
                url:"{{route('tarefas.personalizadas')}}",
                method:"POST",
                data:$(this).serialize(),
                beforeSend:function() {
                    if(form.find("#data_inicial").val() == "") {
                        $("#error_data_inicial").html("<p class='alert alert-danger'>Título e campo obrigatório</p>")
                        $("#dataPersonalizadas").modal('show');
                        return false;
                    } else {
                        $("#error_data_inicial").html("");
                    }
                     
                    if(form.find("#data_final").val() == "") {
                        $("#error_data_final").html("<p class='alert alert-danger'>Cliente e campo obrigatório</p>")
                        $("#dataPersonalizadas").modal('show');
                        return false;
                    } else {
                        $("#error_data_final").html("");
                    }
                    return true;
                },
                success:function(res) {
                    if(res != "nada") {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("<p>Sem Resultado para esse intervalo de datas</p>");
                    }
                    $("#dataPersonalizadas").modal('hide');
                    form.find("#data_inicial").val('');
                    form.find("#data_final").val('');
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
                    if(form.find("#titulo_id").val() == "") {
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
            let form = $(this);
            $.ajax({
                url:"{{route('tarefas.motivoPerdaTarefa')}}",
                method:"POST",
                data:$(this).serialize(),
                beforeSend:function() {
                    
                    if ($('input[name="motivo"]:checked').length == 0) {
                        $("#motivo_perda_error").html("<p class='alert alert-danger text-center'>Marque o motivo pelo menos 1 motivo</p>");
                        $("#motivoDaParda").modal('show');
                        return false;
                    } else {
                        $("#motivo_preco_error").html("");
                    }

                    if($('input[name="motivo"]:checked').val() == 4) {
                        if($('#descricao_motivo').val() == "") {
                            $("#motivoDaParda").modal('show');
                            $("#motivo_textarea").append("<p class='alert alert-danger text-center'>Explique o motivo do cliente estar sem interesse</p>")
                            return false;
                        }
                    }
                    return true;                   
                },

                success:function(res) {
                    if(res != "error") {
                        $("#motivoDaParda").modal('hide');
                        $('input[name="motivo"]').prop('checked', false);
                        $("#descricao_motivo").val('');
                        $("#motivo_textarea").html("");
                        $("body").find("div[data-cliente='"+res+"']").css("display","none");
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

        $("form[name='criar_cliente']").on('submit',function(){
                $.ajax({
                    method:"POST",
                    url:"{{route('clientes.store')}}",
                    data:$(this).serialize(),
                    success:function(res) {
                        if(res == "errornome") {
                            $('.errornome').html('<p class="alert alert-danger">Nome campo e obrigatório</p>')
                            return false;
                        } else {
                            $(".errornome").html('');
                        }

                        if(res == "errorcidade") {
                            $('.errorcidade').html('<p class="alert alert-danger">Cidade campo e obrigatório</p>')     
                            return false;
                        } else {
                            $(".errorcidade").html('');
                        }

                        if(res == "erroremail") {
                            $('.erroremail').html('<p class="alert alert-danger">Email campo e obrigatório</p>')     
                            return false;
                        } else {
                            $('.erroremail').html('');
                        }

                        if(res == "erroremailjacadastrado") {
                            $('.erroremail').html('<p class="alert alert-danger">Email já cadastrado</p>')     
                            return false;
                        } else {
                            $('.erroremail').html('');
                        }

                        if(res == "errortelefone") {
                            $('.errortelefone').html('<p class="alert alert-danger">Celular campo e obrigatório</p>')   
                            return false;  
                        } else {
                            $('.errortelefone').html('');  
                        }

                        if(res == "errortelefonejacadastrado") {
                            $('.errortelefone').html('<p class="alert alert-danger">Celular já cadastrado</p>')   
                            return false;  
                        } else {
                            $('.errortelefone').html('');  
                        }
                      
                        if(res == "clienteexiste") {
                            $.ajax({
                                url:"{{route('cliente.existe')}}",
                                method:"POST",
                                data:"nome="+$('input[name="nome"]').val()+"&email="+$('input[name="email"]').val()+"&telefone="+$('input[name="telefone"]').val()
                            }).done(function(data){
                                Swal.fire({
                                    title: '<h4>Cliente '+data.nome+' já esta cadastrado!</h4>',
                                    icon: 'info',
                                    type: 'info',
                                    showCloseButton: true,
                                    html:
                                        '<hr />'+
                                        '<p>Cadastrado em '+data.cadastrado+' pelo corretor '+data.user+'</p><p>Seu status atual é <b>'+data.etiqueta+'</b> </p>'+
                                        '<p>O que deseja fazer?</p><hr />'+
                                        "<a class='btn btn-primary btn-sm mr-5' href='/admin/cotacao/orcamento/"+data.id+"'>Orçamento</a> <a class='btn btn-info btn-sm mr-5' href='/admin/cotacao/contrato/"+data.id+"'>Contrato</a><a class='btn btn-secondary btn-sm mr-5' href='{{route('clientes.index')}}'>Listar Clientes</a></div>",
                                    showCancelButton: false,
                                    showConfirmButton: false                            
                                });
                            });
                            return false;   
                        }

                        
                        $("input[name='nome']").val('');
                        $("input[name='email']").val('');
                        $("input[name='telefone']").val('');
                        $("select[name='cidade_id']").val('');
                        $('#criarCliente').modal('hide');   
                        mostrarTodosOsClientes(res.id);
                    }
                });    
            return false;
        });

        function mostrarTodosOsClientes(id) {
            $.ajax({
                url:"{{route('tarefas.listarClientesFull')}}",
                method:"POST",
                data:"id="+id,
                success:function(res) {
                    console.log(res);
                    $(".c3").html(res);
                }
            });
        }





        window.$_GET = new URLSearchParams(location.search);
        let value = $_GET.get('ac');
        if(value && value == "atraso") {
            $.ajax({
                data:"alvo=atraso",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("Sem tarefa para atrasadas");
                    }
                }
            });
            return false;
        }     
        
        if(value && value == "hoje") {
            $.ajax({
                data:"alvo=hoje",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    console.log(res);
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("<h3 class='text-center text-white mt-3'>Sem tarefa para hoje</h3>");
                    }
                }
            });
            return false;
        }

        if(value && value == "semana") {
            $.ajax({
                data:"alvo=semana",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("Sem tarefa para essa semana");
                    }
                }
            });
            return false;
        }

        if(value && value == "mes") {
            $.ajax({
                data:"alvo=mes",
                url:"{{route('clientes.listarTarefasEspecifica')}}",
                method:"POST",
                success:function(res) {
                    
                    if(res && res.length >= 1) {
                        $(".c3").html(res);
                    } else {
                        $(".c3").html("Sem tarefa para esse mês");
                    }
                }
            });
            return false;
        }

        

        
        






        
    });
</script>
</body>
</html>