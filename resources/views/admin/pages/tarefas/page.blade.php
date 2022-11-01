@extends('adminlte::page')
@section('title', 'Clientes Pessoa FÍSICA')
@section('plugins.Datatables', true)
@section('plugins.Stars', true)
@section('content_header')
    <h4 class="text-white">CLIENTES PESSOA FÍSICA</h4>  
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
        <ul style="margin:0px;padding:0px;" id="estagios">
            <li class="d-flex justify-content-between text-white py-1 total_geral">
                <span class="ml-2">Total Geral</span>
                <span class="mr-2">{{$clientes_total}}</span>
            </li>

            @foreach($estagios as $e)

                @if($e->nome == "Interessado Frio")
                    
                    <li class="d-flex justify-content-between text-white py-1 link_page" data-id="{{$e->id}}">
                        <span class="ml-2 title">
                            Interessado   
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>     
                        </span>
                        <span class="mr-2 quantidade">{{$e->quantidade}}</span>
                    </li>

                @elseif($e->nome == "Interessado Morno")
                    <li class="d-flex justify-content-between text-white py-1 link_page" data-id="{{$e->id}}">
                        <span class="ml-2 title">
                            Interessado  
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>      
                        </span>
                        <span class="mr-2 quantidade">{{$e->quantidade}}</span>
                    </li>
                
                @elseif($e->nome == "Interessado Quente")
                    <li class="d-flex justify-content-between text-white py-1 link_page" data-id="{{$e->id}}">
                        <span class="ml-2 title">
                            Interessado
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                            <i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>
                        </span>
                        <span class="mr-2 quantidade">{{$e->quantidade}}</span>
                    </li>
                @elseif($e->nome == "Sem Interesse")
                    <li class="d-flex justify-content-between text-white py-1">
                        <span class="ml-2 title">
                            Sem Interessado
                            
                        </span>
                        <span class="mr-2 quantidade">{{$e->quantidade}}</span>
                    </li>
                @else

                    <li class="d-flex justify-content-between text-white py-1 link_page" data-id="{{$e->id}}">
                        <span class="ml-2 title">
                            {{$e->nome}}        
                        </span>
                        <span class="mr-2 quantidade">{{$e->quantidade}}</span>
                    </li>

                @endif

                  





                    
                
            @endforeach



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
                    <select name="estagios-clientes" id="estagios-clientes" class="form-control-sm estagios-clientes" readonly="readonly"> 
                        <option value="">--Escolher Status--</option>
                        @foreach($estagios as $e) 
                            @if($e->nome == "Interessado Frio")
                                <option value="{{$e->id}}">Interessado<span style="background-color:red;">&#9733;</span></option>
                            @elseif($e->nome == "Interessado Morno")
                                <option value="{{$e->id}}">Interessado<span style="background-color:red;">&#9733;&#9733;</span></option>
                            @elseif($e->nome == "Interessado Quente")
                                <option value="{{$e->id}}">Interessado<span style="background-color:red;">&#9733;&#9733;&#9733;</span></option>
                            @else
                                <option value="{{$e->id}}">{{$e->nome}}</option>
                            @endif
                        @endforeach
                    </select>
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

            <!-- <div class="d-flex">
                <div style="flex-basis:98%;margin-left:5px;">
                    <span class="text-white">Descrição:</span>
                    <textarea name="descricao_tarefa" id="descricao_tarefa" name="descricao_tarefa" class="form-control form-control-sm" readonly></textarea>
                </div>
            </div> -->


            <!-- <div style="display:flex;margin:5px 0 0 0;" class="d-flex justify-content-center">
                <a href="#" data-tarefa data-toggle="modal" data-target="#cadastrarClienteClienteEspecifico" style="pointer-events: none;background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;">Nova Tarefa</a>
                <a href="#" data-orcamento style="background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;pointer-events: none;">Orçamento</a>
                <a href="#" data-contrato style="background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;pointer-events: none;">Contrato</a>
                <a href="#" data-perda data-toggle="modal" data-target="#motivoDaPerda" style="background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;pointer-events: none;">Perda</a>
            </div> -->

            

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
                   
                    @foreach($estagios as $e)
                       <option value="{{$e->id}}">{{$e->nome}}</option>
                    @endforeach
                    
                </select>
                <div id="error_titulo"></div>
            </div>
            <input type="hidden" name="cliente_id" id="cliente_id_cadastrado_aqui" />
            <div class="form-group">
                <label for="" style="color:#FFF;">Data</label>
                <input type="date" name="data" id="data" class="form-control">
                <div id="error_data"></div>    
            </div>
            <div class="form-group">
                <label for="descricao" style="color:#FFF;">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="5"></textarea>
                <div id="error_descricao"></div>  
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
                    <label for="" class="text-white">Motivo Da Perda:</label>
                    <select name="perda_cliente" id="perda_cliente" class="form-control">
                        <option value="">--Escolha o Motivo--</option>
                        @foreach($motivos as $k => $v)
                            <option value="{{$v->id}}" name="motivo_perda_cliente">{{$v->descricao}}</option>
                        @endforeach    
                    </select>
                    
                </div>    
                <div id="motivo_textarea">
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-2">Enviar</button>
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

@section('css')
    <style>        
        select[readonly] {background: #eee;pointer-events: none;touch-action: none;}
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
        .fundo {background: rgba(255,255,255,0.5);}
        .total_geral{cursor: pointer;}
        .total_geral:hover{
            background: rgba(255,255,255,0.5);
        }
    </style>
@stop



@section('js')
    <script>
        $(function(){

            

            $('.estagios-clientes').on('change',function(){
                let id = $(this).val();
               
                let cliente = $("#cliente_id_cadastrado_aqui").val();
                if(id != 6) {
                    $.ajax({
                        url:"{{route('clientes.mudarestagiocliente')}}",
                        method:"POST",
                        data:"id="+id+"&cliente="+cliente,
                        success:function(res) {
                            $("#estagios").find('li:eq(1)').find('.quantidade').text(res.qtd_frio);   
                            $("#estagios").find('li:eq(2)').find('.quantidade').text(res.qtd_morno);   
                            $("#estagios").find('li:eq(3)').find('.quantidade').text(res.qtd_quente);   
                            $("#estagios").find('li:eq(4)').find('.quantidade').text(res.qtd_aguardando_doc);   
                            $("#estagios").find('li:eq(5)').find('.quantidade').text(res.qtd_aguardando_inte_futuro);   
                            $("#estagios").find('li:eq(6)').find('.quantidade').text(res.qtd_aguardando_sem_interesse);   
                        }
                    })
                } else {
                    $("#motivoDaPerda").modal('show');
                }
            });    


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
                "url":"{{ route('cliente.getTarefasAtrasadasAjax') }}",
                "dataSrc": ""
            },
            "lengthMenu": [50,100,150,200,300,500],
            "ordering": false,
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
            drawCallback: function () {
                $('.page-link').addClass('btn-sm border-0');
                // $('.form-control').addClass('bg-dark');
            },
            "initComplete": function( settings, json ) {
                $('#title').html("<h4>Atrasadas</h4>");
            }
        });
        
        var table = $("#tabela").DataTable();

        /** Realizar o search de todos os leeads não so do cliente logado */

        // table.on( 'search.dt', function () {
        //     console.log(table.search());
        //     //$('#filterInfo').html( 'Currently applied global search: '+table.search() );
        // });



        // var table = $("body").find("#tabela").DataTable();
        $('table').on('click', 'tbody tr', function () {
            let data = table.row(this).data();
            
            $('select[name="estagios-clientes"]').removeAttr('readonly');
            if(data.estagio_id) {
                $('option[value="'+data.estagio_id+'"]').prop('selected',true);
            } else {
                $('option[value=""]').prop('selected',true);
            }
            

            if(data.estagio_id) {
                
                if(data.estagio_id == 1) {
                    $("#rateYo").rateYo('rating', 1);
                } else if(data.estagio_id == 2) {
                    $("#rateYo").rateYo('rating', 2);
                } else if(data.estagio_id == 3) {
                    $("#rateYo").rateYo('rating', 3);
                } else {
                    $("#rateYo").rateYo('rating', 0);
                }
            } 
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
            
            //$("a[data-orcamento]").attr('style','background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;cursor:pointer').attr("href","/admin/cotacao/orcamento/"+data.id);
            $("a[data-orcamento]").attr("href","/admin/cotacao/orcamento/"+data.id);
            $("a[data-contrato]").attr("href","/admin/cotacao/contrato/"+data.id);
            $("a[data-email]").attr("href","mailto:"+data.email);
            $("a[data-whatsapp]").attr("href","https://api.whatsapp.com/send?phone=55"+data.telefone.replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","")).attr('target',"_blank");
            $("a[data-tarefa]").attr('data-toggle','modal').attr('data-target','#cadastrarClienteClienteEspecifico');
            //$("a[data-perda]").attr('style','background-color:rgba(0,0,0,0.4);width:22%;border:2px solid #FFF;border-radius:10px;text-align:center;color:#FFF;margin:0 0 0 5px;cursor:pointer');
            
            
            historicoCliente(data.id);

        });

        //$("select").find("option:eq(1)").html('<i class="fas fa-star fa-xs" style="color:rgb(255,165,0);"></i>');

        $('.total_geral').on('click',function(){
            $('#title').html("<h4>Total Geral</h4>");
            ta.ajax.url("{{route('cliente.pegartodososclientespf')}}").load();
            $("#estagios").find(".link_page").removeClass('fundo');
            $(this).addClass('fundo');
        });





        $('.link_page').on('click',function(){
            //$('.total_geral').removeClass('fundo');
            //$("#estagios").find("li:not(.total_geral)").removeClass('fundo');
            
            if($(this).attr('data-id')) {
                $('.total_geral').removeClass('fundo');
                $("#estagios").find('li').removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                let titulo = $(this).find('.title').html();
                let id = $(this).attr('data-id');
                let url = "/admin/clientes/ajaxclientesporid?";
                url += "&id="+id;
                $('#title').html("<h4>"+titulo+"</h4>");
                ta.ajax.url(url).load();
                
                $(this).addClass('fundo');
                
            }
            
        });

        $(".atrasada").on('click',function(){
            $(this).addClass('fundo');
            $('.total_geral').removeClass('fundo');
            $('.link_page').removeClass('fundo');
            $('.hoje').removeClass('fundo');
            $('.semana').removeClass('fundo');
            $('.mes').removeClass('fundo');
            $('.todos').removeClass('fundo');
            $("#title").html("<h4>Atrasadas</h4>");
            ta.ajax.url("{{ route('cliente.getTarefasAtrasadasAjax') }}").load();
            return false;
        });

        $(".hoje").on('click',function(){
            $(this).addClass('fundo');
            $('.total_geral').removeClass('fundo');
            $('.link_page').removeClass('fundo');
            $('.atrasada').removeClass('fundo');
            $('.semana').removeClass('fundo');
            $('.mes').removeClass('fundo');
            $('.todos').removeClass('fundo');
            $("#title").html("<h4>Hoje</h4>");
            ta.ajax.url("{{ route('cliente.getTarefasParaHoje') }}").load();
            return false;
        });

        $(".semana").on('click',function(){
            $(this).addClass('fundo');
            $('.total_geral').removeClass('fundo');
            $('.link_page').removeClass('fundo');
            $('.atrasada').removeClass('fundo');
            $('.hoje').removeClass('fundo');
            $('.mes').removeClass('fundo');
            $('.todos').removeClass('fundo');
            $("#title").html("<h4>Semana</h4>");
            ta.ajax.url("{{ route('cliente.listarClientesSemanaAjax') }}").load();
            return false;
        });

        $(".mes").on('click',function(){
            $(this).addClass('fundo');
            $('.total_geral').removeClass('fundo');
            $('.link_page').removeClass('fundo');
            $('.atrasada').removeClass('fundo');
            $('.semana').removeClass('fundo');
            $('.hoje').removeClass('fundo');
            $('.todos').removeClass('fundo');
            $("#title").html("<h4>Mês</h4>");    
            ta.ajax.url("{{ route('cliente.listarClienteMesAjax') }}").load();
            return false;
        });

        $(".todos").on('click',function(){
            $(this).addClass('fundo');
            $('.total_geral').removeClass('fundo');
            $('.link_page').removeClass('fundo');
            $('.atrasada').removeClass('fundo');
            $('.semana').removeClass('fundo');
            $('.mes').removeClass('fundo');
            $('.hoje').removeClass('fundo');
            $("#title").html("<h4>Todos</h4>");
            ta.ajax.url("{{ route('clientes.ajaxclienteslistapf') }}").load();
            return false;
        }); 

       

        $(".nova_tarefa").on('click',function(){
            let id = $().val();
            $('#cliente_id_cadastrado_aqui').val();
            return false;
        });  

        $("body").on('change','select[name="perda_cliente"]',function(){
            let valor = $(this).val();
            if(valor == 4) {
                $("#motivo_textarea").html("<label for='descricao_motivo' class='text-white'>Porque Sem interesse?</label><textarea name='descricao_motivo' class='form-control' id='descricao_motivo' rows='4' cols='60'></textarea>")
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
                    if($("#perda_cliente :selected").val() == "") {
                        
                        $("#motivo_perda_error").html("<p class='alert alert-danger text-center'>Marque pelo menos 1 motivo para a perda</p>");
                        $("#motivoDaPerda").modal('show');
                        return false;
                    } else {
                       
                        $("#motivo_preco_error").html("");
                    }
                    

                    if($("#perda_cliente :selected").val() == 4) {
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
                        $("input[name='nome']").val('');
                        $("input[name='cidade']").val('');
                        $("select[name='estagios-clientes']").val('').prop('readonly',true);
                        $("input[name='telefone']").val('');
                        $("input[name='email']").val('');
                        $("input[name='quantidade_vidas']").val('');
                        $("input[name='data_cadastro']").val('');
                        $("input[name='dias_contato']").val('');
                        $("input[name='origem_leads']").val('');
                        $("input[name='ultimo_contato']").val('');
                        $("input[name='dias_cadastro']").val('');
                        $('input[name="motivo"]').prop('checked', false);
                        $("#descricao_motivo").val('');
                        $("#motivo_textarea").html("");

                        $("a[data-orcamento]").attr("href","#");
                        $("a[data-contrato]").attr("href","#");
                        $("a[data-email]").attr("href","#");
                        $("a[data-whatsapp]").attr("href","#");
                        $("a[data-tarefa]").removeAttr('data-toggle','modal').removeAttr('data-target','#cadastrarClienteClienteEspecifico');


                        location.reload();

                        $("#historico").html("");
                        
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
                    if(form.find("#titulo_id").val() == "") {
                        $("#error_titulo").html("<p class='alert alert-danger'>Título e campo obrigatório</p>")
                    } else {
                        $("#error_titulo").html("");
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

                    if(form.find("#star").val() == "") {
                        $("#error_star").html("<p class='alert alert-danger'>Escolha um nivel de interesse desse cliente</p>")
                    } else {
                        $("#error_star").html("");
                    }
                },
                success:function(res) {
                    // console.log(res);
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
        
        //$.fn.dataTable.ext.classes.sPageButton = 'paginate_button page-item btn-sm';    

    });
    $('.pagination').addClass('pagination-sm')
    
    
    
    
    
    
    
    //$('.dataTables_filter').addClass('btn btn-sm btn-dark');
    //$('.dataTables_paginate').addClass('btn btn-sm btn-dark');
    // $.fn.dataTable.ext.classes.sPageButton = 'btn-sm';
    //$.fn.dataTable.ext.classes.sPageButton = 'paginate_button page-item btn-sm'; 
    </script>
@stop




