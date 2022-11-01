@extends('adminlte::page')
@section('title', 'Cliente Pessoa Juridica')
@section('plugins.Datatables', true)
@section('plugins.Stars', true)
@section('content_header')
    <h4 class="text-white">CLIENTES PESSOA JURÌDICA</h4>  
@stop

@section('content_top_nav_right')

<li class="nav-item">
        <a href="{{route('home.calculadora')}}" class="nav-link text-white">
            <i class="fas fa-calculator"></i>
            Calculadora
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('home.calendario')}}" class="nav-link text-white">
            <i class="fas fa-calendar-alt"></i>
            Calendario
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('home.lembretes')}}" class="nav-link text-white">
            <i class="fas fa-sticky-note"></i>
            Lembretes
        </a>
    </li>
    <li class="nav-item">
        <!-- <div class="d-flex align-items-center bg-danger"> -->
            
            <a href="{{route('admin.home.search')}}" class="nav-link text-white">
                <i class="fas fa-money-check-alt"></i>
                Tabela de Preços
            </a>
        <!-- </div> -->
        
    </li>

@stop












@section('content')

<section class="d-flex justify-content-between" style="flex-wrap: wrap;">

        

        <!--COLUNA LEFT-->
        <div class="d-flex flex-column text-white ml-1" style="flex-basis:15%;height:95vh;">

            <div class="py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;">
                <h5 class="text-center d-flex align-items-center justify-content-center border-bottom py-2">Tarefas</h5>
                <ul style="margin:0px;padding:0px;">
                <li class="links_tarefas">
                <a href="" class="d-flex justify-content-between text-white py-1 atrasada">
                    <span class="ml-2">Atrasadas</span>
                    <span class="mr-2">{{$tarefas->atrasada}}</span>
                </a>
            </li>
            <li class="links_tarefas">
                <a href="" class="d-flex justify-content-between text-white py-1 hoje">
                    <span class="ml-2">Hoje</span>
                    <span class="mr-2">{{$tarefas->hoje}}</span>
                </a>    
            </li>
            <li class="links_tarefas">
                <a href="" class="d-flex justify-content-between text-white py-1 semana">
                    <span class="ml-2">Semana</span>
                    <span class="mr-2">{{$tarefas->semana}}</span>
                </a>
            </li>
            <li class="links_tarefas">
                <a href="" class="d-flex justify-content-between text-white py-1 mes">
                    <span class="ml-2">Mês</span>
                    <span class="mr-2">{{$tarefas->mes}}</span>
                </a>
            </li>
            <li class="links_tarefas">
                <a href="" class="d-flex justify-content-between text-white py-1 todos">
                    <span class="ml-2">Todos</span>
                    <span class="mr-2">{{$tarefas->todas}}</span>
                </a>
            </li>
                </ul>
            </div>

            <div class="d-flex flex-column mt-2 py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;">
                <h5 class="text-center d-flex align-items-center justify-content-center border-bottom py-2">Clientes</h5>
                <ul style="margin:0px;padding:0px;">
                    <li class="d-flex justify-content-between text-white py-1 link_page total_geral">
                        <span class="ml-2">Total Geral</span>
                        <span class="mr-2">{{$clientes_total}}</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1 link_page interessado_frio">
                        <div>
                            <span class="ml-2">Interessado</span>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                        </div>
                        <span class="mr-2">0</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1 link_page interessado_morno">
                        <div>
                            <span class="ml-2">Interessado</span>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                        </div>
                        <span class="mr-2">0</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1 link_page interessado_quente">
                        <div>
                            <span class="ml-2">Interessado</span>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                        </div>
                        <span class="mr-2">0</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1 link_page">
                        <span class="ml-2">Aguard. Documentação</span>
                        <span class="mr-2">0</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1 link_page">
                        <span class="ml-2">Interesse Futuro</span>
                        <span class="mr-2">0</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1 link_page">
                        <span class="ml-2">Sem Interesse</span>
                        <span class="mr-2">0</span>
                    </li>
                    <li class="d-flex justify-content-between text-white py-1 link_page">
                        <span class="ml-2">Sem Interesse no Mês</span>
                        <span class="mr-2">0</span>
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
            <div class="py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;height:225px;">
                <form action="">

                <div class="form-row" style="margin-right: 0;margin-left:0;">
                <div class="col">
                    <span class="text-white">Cliente:</span>
                    <input type="text" name="nome" id="nome" class="form-control form-control-sm" readonly>
                </div>
                <div class="col">
                    <span class="text-white">Cidade:</span>
                    <input type="text" name="cidade" id="cidade" class="form-control form-control-sm" readonly>
                </div>
                <div class="col">
                    <span class="text-white">Status:</span>
                    <input type="text" name="status" id="status" class="form-control form-control-sm" readonly>
                </div>
            </div>

            <div class="form-row" style="margin-right: 0;margin-left:0;">
                <div class="col">
                    <span class="text-white">Telefone:</span>
                    <input type="text" name="telefone" id="telefone" class="form-control form-control-sm" readonly>
                </div>
                <div class="col">
                    <span class="text-white">Email:</span>
                    <input type="text" name="email" id="email" class="form-control form-control-sm" readonly>
                </div>
                <div class="col">
                    <span class="text-white">Quantidade de Vidas:</span>
                    <input type="text" name="quantidade_vidas" id="quantidade_vidas" class="form-control form-control-sm" readonly>
                </div>
            </div>

            <div style="display: flex;">
                <div style="flex-basis:22%;margin-right:2%;margin-left:5px;">
                    <span class="text-white">Data Cadastro:</span>
                    <input type="text" name="data_cadastro" id="data_cadastro" class="form-control form-control-sm" readonly>
                </div>
                <div style="flex-basis:10%;margin-right:2%;">
                    <span class="text-white">Dias:</span>
                    <input type="text" name="dias_cadastro" id="dias_cadastro" class="form-control form-control-sm" readonly>
                </div>
                <div style="flex-basis:22%;margin-right:2%;">
                    <span class="text-white">Ultimo Contato:</span>
                    <input type="text" name="ultimo_contato" id="ultimo_contato" class="form-control form-control-sm" readonly>
                </div>
                <div style="flex-basis:10%;margin-right:2%;">
                    <span class="text-white">Dias:</span>
                    <input type="text" name="dias_contato" id="dias_contato" class="form-control form-control-sm" readonly>
                </div>
                <div style="flex-basis:29%;margin-right:4px;">
                    <span class="text-white">Origem Leads:</span>
                    <input type="text" name="origem_leads" id="origem_leads" class="form-control form-control-sm" readonly>    
                </div>    
            </div>

            <div class="grupo-botoes">
                <a href="#" data-tarefa class="ml-1">Nova Tarefa</a>
                <a href="#" data-ligar class="mx-2">Ligar</a>
                <a href="#" data-whatsapp>Whatsapp</a>
                <a href="#" data-email class="mx-2">Email</a>
                <a href="#" data-orcamento class="mr-2">Orçamento</a>
                <a href="#" data-contrato>Contrato</a>
                
               
            </div>

                    

                </form>
            </div>
            <!---FIM FORM--->

            <!--TIMELINE--->
            <div class="timelines" id="historico">
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

                    <input type="hidden" name="star" id="star">
                    <div class="d-flex justify-content-center mb-3">
                        <div id="rateYo"></div>
                    </div>
                    <div id="error_star"></div>

                    <div class="text-center mx-auto text-center mb-3" style="width:95%;border-radius:10px;">
                        <div class="d-flex flex-column">
                            <small class="d-flex">
                                <div id="frio"></div><span class="text-white">Frio</span>
                            </small>
                            <small class="d-flex">
                                <div id="normo"></div><span class="text-white">Morno</span>
                            </small>
                            <small class="d-flex">
                                <div id="quente"></div><span class="text-white">Quente</span>
                            </small>
                        </div>
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
    <!------Fim Modal Perda Cliente---------->








</section>

@stop

@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){

            $("#frio").rateYo({rating:1,readOnly: true,spacing: "10px",starWidth: "20px",numStars: 3,minValue: 0,maxValue: 3,ratedFill: 'orange',fullStar: true,});
            $("#normo").rateYo({rating:2,readOnly: true,spacing: "10px",starWidth: "20px",numStars: 3,minValue: 0,maxValue: 3,ratedFill: 'orange',fullStar: true,});
            $("#quente").rateYo({rating:3,readOnly: true,spacing: "10px",starWidth: "20px",numStars: 3,minValue: 0,maxValue: 3,ratedFill: 'orange',fullStar: true,});

            $("#rateYo").rateYo({spacing: "10px",starWidth: "20px",numStars: 3,minValue: 0,maxValue: 3,normalFill: 'white',ratedFill: 'orange',fullStar: true,onSet: function (rating, rateYoInstance) {$("input[name='star']").val(rating);}});




            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        let ta = $(".listarclientes").DataTable({
            dom: '<"d-flex justify-content-between"<"#title">ft><t><"d-flex justify-content-between"lp>',
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                // "url":"{{ route('clientes.ajaxclienteslistapj') }}",
                "url":"{{ route('cliente.getTarefasAtrasadasAjaxPJ') }}",
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
            },
            "initComplete": function( settings, json ) {
                $('#title').html("<h4>Atrasadas</h4>");
            }
        });
        
        var table = $('#tabela').DataTable();
        $('table').on('click', 'tbody tr', function () {
            
            let data = table.row(this).data();
            console.log(data);
            
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
            //$("textarea[name='descricao']").val();
            $("input[name='dias_cadastro']").val(diferencaEmDias);
            $("input[name='quantidade_vidas']").val(quantidade_vidas);
            //console.log(row[1]);   //EmployeeId
            $("textarea[name='descricao_tarefa']").val(data.tarefas[0].descricao);
            $("#cliente_id_cadastrado_aqui").val(data.id)

            $("#dias_contato").val(ultimoEmDias);
            $("#origem_leads").val("-")
            
            $("a[data-orcamento]").attr("href","/admin/cotacao/orcamento/"+data.id);
            $("a[data-contrato]").attr("href","/admin/cotacao/contrato/"+data.id);
            $("a[data-email]").attr("href","mailto:"+data.email);
            $("a[data-whatsapp]").attr("href","https://api.whatsapp.com/send?phone=55"+data.telefone.replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","")).attr('target',"_blank");
            $("a[data-tarefa]").attr('data-toggle','modal').attr('data-target','#cadastrarClienteClienteEspecifico');
            
            historicoCliente(data.id);

        });

        $(".atrasada").on('click',function(){
            $("div").removeClass('fundo');
            $(".hoje").removeClass('fundo');
            $(".semana").removeClass('fundo');
            $(".mes").removeClass('fundo');
            $(".todos").removeClass('fundo');
            $(this).addClass('fundo');
            $("#title").html("<h4>Atrasadas</h4>");
            ta.ajax.url("{{ route('cliente.getTarefasAtrasadasAjaxPJ') }}").load();
            return false;
        });

        $(".hoje").on('click',function(){
            $("div").removeClass('fundo');
            $(".atrasada").removeClass('fundo');
            $(".semana").removeClass('fundo');
            $(".mes").removeClass('fundo');
            $(".todos").removeClass('fundo');
            $(this).addClass('fundo');
            $("#title").html("<h4>Hoje</h4>");
            ta.ajax.url("{{ route('cliente.getTarefasParaHojePJ') }}").load();
            return false;
        });

        $(".semana").on('click',function(){
            $("div").removeClass('fundo');
            $(".hoje").removeClass('fundo');
            $(".atrasada").removeClass('fundo');
            $(".mes").removeClass('fundo');
            $(".todos").removeClass('fundo');
            $(this).addClass('fundo');
            $("#title").html("<h4>Semana</h4>");
            ta.ajax.url("{{ route('cliente.listarClientesSemanaAjaxPJ') }}").load();
            return false;
        });

        $(".mes").on('click',function(){
            $("div").removeClass('fundo');
            $(".hoje").removeClass('fundo');
            $(".semana").removeClass('fundo');
            $(".atrasada").removeClass('fundo');
            $(".todos").removeClass('fundo');
            $(this).addClass('fundo');
            $("#title").html("<h4>Mês</h4>");
            ta.ajax.url("{{ route('cliente.listarClienteMesAjaxPJ') }}").load();
            return false;
        });

        $(".todos").on('click',function(){
            $("div").removeClass('fundo');
            $(".hoje").removeClass('fundo');
            $(".semana").removeClass('fundo');
            $(".atrasada").removeClass('fundo');
            $(".mes").removeClass('fundo');
            $(this).addClass('fundo');
            $("#title").html("<h4>Todos</h4>");
            ta.ajax.url("{{ route('cliente.listarClienteMesAjaxPJ') }}").load();
            return false;
        });

        $(".total_geral").on('click',function(){
            $("#title").html("<h4>Todos</h4>");
            return false;
        });

        $(".interessado_frio").on('click',function(){
            $("#title").html("<h4>Interesse <i class='fas fa-star fa-xs' style='color:rgb(255,165,0);width:10px;'></i></h4>");
            
            return false;
        });

        $(".interessado_morno").on('click',function(){
            $("#title").html("<h4>Interesse <i class='fas fa-star fa-xs' style='color:rgb(255,165,0);width:10px;'></i><i class='fas fa-star fa-xs' style='color:rgb(255,165,0);width:10px;margin-left:12px;'></i></h4>");
            
            return false;
        });

        $(".interessado_quente").on('click',function(){
            $("#title").html("<h4>Interesse <i class='fas fa-star fa-xs' style='color:rgb(255,165,0);width:10px;'></i><i class='fas fa-star fa-xs' style='color:rgb(255,165,0);width:10px;margin-left:12px;'></i><i class='fas fa-star fa-xs' style='color:rgb(255,165,0);width:10px;margin-left:12px;'></i></h4>");
            
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
@stop

@section('css')
    <style>
         ul {list-style: none;}
        .table-cell-edit{background-color: rgba(0,0,0,0.5);color:#FFF;cursor: pointer;}
        .alvo {cursor:pointer;}        
        textarea {resize: none;}   
        .timelines {overflow-y:scroll;background-color:rgba(0,0,0,0.5);border-radius:5px;height:calc(100% - 230px);flex-basis:100%;}
        .timelines::-webkit-scrollbar {width: 12px;}
        .timelines::-webkit-scrollbar-track {background: orange;}
        .timelines::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;}  
        .grupo-botoes {margin-top: 10px;display: flex;}
        .grupo-botoes > a {font-size:0.875em;width:15%;padding:5px 0;background-color:rgba(0,0,0,0.4);border:2px solid #FFF;text-align:center;color:#FFF;}
        .grupo-botoes > a:hover {background-color:rgba(255,255,255,0.5) !important;cursor:pointer !important;}
        .link_page:hover {background: rgba(255,255,255,0.5);cursor: pointer;}
        .links_tarefas:hover {background: rgba(255,255,255,0.5);cursor: pointer;}
        .textoforte {background-color:rgba(255,255,255,0.5);color:black;}
        .fundo {background-color: rgba(255,255,255,0.5);}
    </style>
@stop