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
    .c1 a {color:#FFF;}
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
    .c41 {height:60%;} 
    .c42 {height:40%;}
    .ds-none {display:none !important;}
    .icone {position:relative;top:15px;left:20px;color:#FFF;}
    ul li:hover .icone {color:#000;}
    .btn_adicionar_tarefa {border:2px solid #FFF;background-color:#333;color:#FFF;}
    .btn_adicionar_tarefa:hover {background-color: #FFF;color:#000;border:2px solid #000;}

    .btn_adicionar_cliente {border:2px solid #FFF;background-color:#333;color:#FFF;}
    .btn_adicionar_cliente:hover {background-color: #FFF;color:#000;border:2px solid #000;}

    .nova_atividade {
        border:2px solid #FFF;
        background-color:#333;
        color:#FFF;
        margin-bottom: 10px;
    
    }
  </style>
  <link rel="stylesheet" href="{{asset('vendor/toastr/toastr.css')}}" />
</head>
<body>
    <input type="hidden" name="parametro" id="parametro">
    <section class="d-flex c1">
        <h4 style="color:#FFF;" class="ml-3">Gerenciamento de Tarefas - Administrador</h4>
        <a href="{{route('admin.home')}}" class="ml-auto align-self-center mr-4 bold">Dashboard</a>
    </section>
    <section class="d-flex">
        <div style="flex-basis:15%;" class="flex-column c2">
            <div>
                <ul id="lista_tarefas">
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
                    <button class="w-100 btn_adicionar_cliente " type="button" data-toggle="modal" data-target="#criarTitulo">Adicionar Titulos Para Tarefas</button>
                    
                </div>
                
            </div>
        </div>
        <div style="flex-basis:35%;" class="c3">
            
        </div>
        <div style="flex-basis:50%;" class="border-right c4 flex-column">
            
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
                <div class="w-100 d-flex flex-column ds-none mt-4" style="clear:both;">
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
 
    <div class="modal fade" id="criarTitulo" tabindex="-1" aria-labelledby="criarTituloLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:rgba(0,0,0,0.5)">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="motivoDaPerdaLabel">Criar Titulo Tarefas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" name="criar_titulo" id="criar_titulo">
                        @csrf
                        <div class="form-group">
                            <label for="" class="text-white">Titulo:</label>
                            <input type="text" name='titulo' id='titulo' class="form-control">
                            <div class="errortitulo"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar Titulo</button>
                    </form>    
                </div>
                
            </div>
        </div>
    </div>
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>
<script>
   $(function(){
        $('form[name="criar_titulo"]').on('submit',function(){
            $.ajax({
                url:"{{route('tarefas.cadastrarTitulo')}}",
                method:"POST",
                data:$(this).serialize(),
                  
                success:function(res) {
                    if(res == "errortitulo") {
                        $(".errortitulo").html("<p class='alert alert-danger text-center'>Campo titulo é obrigatório</p>");
                    } else {
                        $(".errortitulo").html("");
                        toastr.success("Titulo Cadastrado com sucesso","",{"closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "preventDuplicates": false,
                            "showDuration": "1000",
                            "hideDuration": "2000",
                            "timeOut": "1000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"});
                        $("#criarTitulo").modal('hide');
                        $("#titulo").val("")
                    }    
                }
            });
            return false;
        });
   })   
</script>
</body>
</html>