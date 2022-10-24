@extends('adminlte::page')
@section('title', 'Leads')
@section('plugins.Datatables', true)
@section('plugins.Toastr', true)
@section('content_header')
    <div class="d-flex align-items-center">
        <h4 class="text-white">Leads Pessoa Física</h4>     
        <i class="fas fa-user-plus text-white ml-3 cad" data-toggle="modal" data-target="#cadastrarPessoaFisica"></i> 
    </div>
    
@stop
@section('content')

<section class="d-flex justify-content-between" style="flex-wrap: wrap;">

<!--COLUNA LEFT-->
<div class="d-flex flex-column text-white ml-1" style="flex-basis:15%;height:95vh;">

    <!-- <div class="py-1 d-flex flex-column" style="background-color:rgba(0,0,0,0.5);border-radius:5px;margin-bottom:10px;">
        <a href="" data-toggle="modal" data-target="#cadastrarPessoaFisica" class="mx-auto text-center mb-2 w-100 text-white" style="background-color:rgba(0,0,0,0.4);">Cadastrar PF</a>           
        <a href="" data-toggle="modal" data-target="#cadastrarPessoaJuridica" class="mx-auto text-center w-100 text-white" style="background-color:rgba(0,0,0,0.4);">Cadastrar PJ</a>           
    </div> -->

    <div class="py-1 d-flex flex-column" style="background-color:rgba(0,0,0,0.5);border-radius:5px;margin-bottom:10px;">
        
        <div class="d-flex py-2 justify-content-between links plantao_vendas">
            <a href="" class="text-white ml-1">Plantão de Vendas</a> 
            @if($qtdVendas == 0) 
                <span class="badge badge-danger mr-1" id="qtdVendas">
                    {{$qtdVendas}}
                </span>
            @else
                <span class="badge badge-info mr-1" id="qtdVendas">
                    {{$qtdVendas}}
                </span>
            @endif
            
        </div>
        
        <div class="d-flex justify-content-between py-2 links prospeccao">
            <a href="" class="text-white  ml-1">Prospecção</a>
            @if($qtdProps == 0)
                <span class="badge badge-danger  mr-1" id="prospeccao">{{$qtdProps}}</span>
            @else
                <span class="badge badge-info  mr-1" id="prospeccao">{{$qtdProps}}</span>
            @endif
            
        </div>
        
        <div class="d-flex py-2 justify-content-between links atendimento_inciado">
            <a href="" class="text-white  ml-1">Atendimento Iniciado</a>
            @if($qtdAtendimento == 0)
                <span class="badge badge-danger  mr-1" id="qtdAtendimento">{{$qtdAtendimento}}</span>
            @else
                <span class="badge badge-info  mr-1" id="qtdAtendimento">{{$qtdAtendimento}}</span>
            @endif
            
        </div>
                                
    </div>


    <div class="py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;">
            <ul style="margin:0px;padding:0px;">
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 atrasada">
                    <span class="ml-2">Atrasadas</span>                     
                    @if($qtdAtrasado == 0)
                        <span class="badge badge-danger  mr-1" id="quantidade_atrasadas">{{$qtdAtrasado}}</span>
                    @else
                        <span class="badge badge-info  mr-1" id="quantidade_atrasadas">{{$qtdAtrasado}}</span>
                    @endif
                </a>
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 hoje">
                    <span class="ml-2">Hoje</span>
                    @if($qtdHoje == 0)
                        <span class="badge badge-danger  mr-1" id="quantidade_hoje">{{$qtdHoje}}</span>
                    @else
                        <span class="badge badge-info  mr-1" id="quantidade_hoje">{{$qtdHoje}}</span>
                    @endif
                </a>    
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 semana">
                    <span class="ml-2">Semana</span>
                    @if($qtdSemana == 0)
                        <span class="badge badge-danger  mr-1" id="quantidade_hoje">{{$qtdSemana}}</span>
                    @else
                        <span class="badge badge-info  mr-1" id="quantidade_hoje">{{$qtdSemana}}</span>
                    @endif
                </a>
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 mes">
                    <span class="ml-2">Mês</span>

                    @if($qtdMes == 0)
                        <span class="badge badge-danger  mr-1" id="quantidade_hoje">{{$qtdMes}}</span>
                    @else
                        <span class="badge badge-info  mr-1" id="quantidade_hoje">{{$qtdMes}}</span>
                    @endif



                   
                </a>
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 todos">
                    <span class="ml-2">Total Leads</span>

                    @if($qtdTotal == 0)
                        <span class="badge badge-danger  mr-1" id="quantidade_hoje">{{$qtdTotal}}</span>
                    @else
                        <span class="badge badge-info  mr-1" id="quantidade_hoje">{{$qtdTotal}}</span>
                    @endif




                    
                </a>
            </li>
        </ul>
    </div>

    


</div>
<!--FIM COLUNA LEFT-->

<!--COLUNA CENTRO-->
<div class="text-white p-2 align-self-start" style="flex-basis:74%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
    <div id="table" class="py-3">
        <table id="tabela" class="table listarclientes">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkbox-pai"></th>
                    <th>Tempo</th>
                    <th>Data</th>
                    <th>Origem</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>   
    </div> 
</div>  
<!--FIM COLUNA CENTRO-->

<!--COLUNA RIGHT-->
<div class="mr-1" style="flex-basis:10%;flex-wrap: wrap;background-color:rgba(0,0,0,0.5);border-radius:5px;">
    <div class="d-flex flex-column align-items-center justify-content-center">
        <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column justify-content-center mx-auto text-center mt-4 mb-3 border border-white w-75 text-white orcamento">
            <i class="fas fa-money-check-alt fa-lg"></i>
            <span style="font-size:0.875em;">Orçamentos</span>
        </a>           
        <a href="" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white" style="background-color:rgba(0,0,0,0.4);pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);">
            <i class="fas fa-phone fa-lg"></i>
            <span style="font-size:0.875em;">Ligar</span>
        </a>           
        <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white whatsapp" style="background-color:rgba(0,0,0,0.4);">
            <i class="fab fa-whatsapp fa-lg"></i>
            <span style="font-size:0.875em;">Whatsapp</span>
        </a>           
        <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white email" style="background-color:rgba(0,0,0,0.4);">
            <i class="far fa-envelope fa-lg"></i>    
            <span style="font-size:0.875em;">Email</span>
        </a>           
        <!-- <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white" style="background-color:rgba(0,0,0,0.4);">
            <i class="fas fa-sms fa-lg"></i>
            SMS
        </a>-->
        <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white" style="background-color:rgba(0,0,0,0.4);">
            <i class="fas fa-exchange-alt fa-lg"></i>
            Transferir
        </a>           
        <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white exportar" style="background-color:rgba(0,0,0,0.4);">
            <i class="fas fa-file-csv fa-lg"></i>
            Exportar
        </a>       
        
        <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white editar" style="background-color:rgba(0,0,0,0.4);">
            <i class="far fa-edit"></i>
            Editar
        </a>       
        
    </div>
    

</div>
<!--FIM Coluna RIGHT-->

<!--Modal de cadastro com cliente especifico Cadastrar Nova Atividade-->
<div class="modal fade" id="cadastrarPessoaFisica" tabindex="-1" role="dialog" aria-labelledby="cadastrarPessoaFisicaLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color:rgba(0,0,0,0.5);">
    <div class="modal-header">
        <h5 class="modal-title" id="cadastrarPessoaFisicaLabel" style="color:#FFF;">Cadastrar PF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    <form action="" method="post" name="cadastrar_pessoa_fisica">
            @csrf
            <div class="form-row mb-2">
                <div class="col-6">
                    <span class="text-white">Nome:</span>
                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome Cliente">    
                    <div class="errornome"></div>
                </div>
                <div class="col-6">
                    <span class="text-white">Cidade:</span>
                    <select name="cidade_id" id="cidade_id" class="form-control">
                        <option value="">-- Escolher Cidade --</option>
                        @foreach($cidades as $c) 
                            <option value="{{$c->id}}">{{$c->nome}}</option>
                        @endforeach
                    </select>
                    <div class="errorcidade"></div>
                </div>    
            </div>

            <div class="form-row mb-2">
                <div class="col-6">
                    <span class="text-white">Celular:</span>
                    <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone">  
                    <div class="errortelefone"></div>  
                    
                </div>

                <div class="col-6">
                    <span class="text-white">Email:</span>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email">    
                    <div class="erroremail"></div>  
                </div>
            </div>

            <div class="form-group">
                <span class="text-white">Origem:</span>
                
                <select name="origem_id" id="origem_id" class="form-control">
                    <option value="">-- Escolher a Origem --</option>
                    @foreach($origem as $o) 
                        <option value="{{$o->id}}">{{$o->nome}}</option>
                    @endforeach
                    
                </select>
                <div class="errororigem"></div>
            </div>    
            

            
            <input type="submit" class="btn btn-primary btn-block mt-3" value="Cadastrar">
    </form>
 
    </div>
    
    </div>
</div>
</div>
<!--Fim Modal de cadastro com cliente especifico Cadastrar Nova Atividade-->


<!--Modal de cadastro Pessoa Juridica-->
<div class="modal fade" id="cadastrarPessoaJuridica" tabindex="-1" role="dialog" aria-labelledby="cadastrarPessoaJuridicaLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color:rgba(0,0,0,0.5);">
    <div class="modal-header">
        <h5 class="modal-title" id="cadastrarPessoaJuridicaLabel" style="color:#FFF;">Cadastrar PJ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    <form action="" method="post" name="cadastrar_pessoa_jurica">
            @csrf
            <div class="form-row mb-2">
                <div class="col-6">
                    <span class="text-white">CNPJ:</span>
                    <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ">    
                    <div class="errorcnpj"></div>
                </div>

                <div class="col-6">
                    <span class="text-white">Nome Empresa:</span>
                    <input type="text" name="nome_empresa" id="nome_empresa" class="form-control" placeholder="Empresa">    
                    <div class="errornomeempresa"></div>
                </div>
            </div>

            <div class="form-row">

                <div class="col-6">
                    <span class="text-white">Contato(Responsavel):</span>
                    <input type="text" name="nome" id="nome_responsavel" class="form-control" placeholder="Nome do Responsavel">    
                    <div class="errornomeresponsavel"></div>
                </div>

                <div class="col-6">
                    <span class="text-white">Cidade:</span>
                    <select name="cidade_id" id="cidade_id_empresa" class="form-control">
                        <option value="">-- Escolher Cidade --</option>
                        @foreach($cidades as $c) 
                            <option value="{{$c->id}}">{{$c->nome}}</option>
                        @endforeach
                    </select>
                    <div class="errorcidadeempresa"></div>
                </div>    
            </div>

            <div class="form-row mb-2">
                <div class="col-4">
                    <span class="text-white">Celular:</span>
                    <input type="text" name="telefone" id="celular_empresa" class="form-control" placeholder="Telefone">  
                    <div class="errorcelularempresa"></div>  
                </div>

                <div class="col-4">
                    <span class="text-white">Telefone(Opicional):</span>
                    <input type="text" name="telefone_empresa" id="telefone_empresa" class="form-control" placeholder="Telefone Empresa">  
                    <div class="errortelefoneempresa"></div>  
                </div>

                <div class="col-4">
                    <span class="text-white">Email:</span>
                    <input type="text" name="email" id="email_empresa" class="form-control" placeholder="Email">    
                    <div class="erroremailempresa"></div>  
                </div>
            </div>

            <input type="submit" class="btn btn-primary btn-block mt-3" value="Cadastrar Pessoa Jurídico">
        </form>
 
    </div>
    
    </div>
</div>
</div>
<!--Fim Modal de cadastro Pessoa Juridica-->



<!-- <a href="mailto:email@email.com?subject=Envio de pedido&body=Por favor atentar aos ítens">Enviar</a> -->



</section>
@stop

@section('css')
    <style>
        ul {list-style: none;}
        .links:hover {cursor:pointer;background-color: rgba(255,255,255,0.5);}
        .cad:hover {cursor:pointer;}
        .fundo {background-color: rgba(255,255,255,0.5);}
        .red-color {color:red;}
        .green-color {color:green;}    
        .header {background-color:red;}
        #title {width:400px;height:20px;color:#FFF;display:block;}
        .textoforte {background-color:rgba(255,255,255,0.5);color:black;}
    </style>
@stop


@section('js')

<script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        
        $(function(){

            $("#checkbox-pai").on('change',function(){
                if($(this).is(":checked")) {
                    $("#marcar_cliente").prop('checked', true); 
                    $(".marcar_cliente").prop('checked', true); 
                    $('input[type="checkbox"]').prop("checked",true);
                    $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    $(".exportar").attr('style','cursor:pointer');
                    $('tr').addClass('textoforte');
                } else {
                    $('.marcar_cliente').removeAttr("checked");
                    $("#marcar_cliente").prop('checked', false); 
                    $(".marcar_cliente").prop('checked', false); 
                    $('input[type="checkbox"]').prop("checked",false);
                    $('#marcar_cliente').removeAttr("checked",false);
                    $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                    $('tr').removeClass('textoforte'); 
                }
            });


            const ids = [];
            $('#telefone').mask('(00) 0 0000-0000');
            $('#telefone_empresa').mask('(00) 0 0000-0000');
            $('#celular_empresa').mask('(00) 0 0000-0000');
            $('#cnpj').mask('00.000.000/0000-00');
        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var ta = $(".listarclientes").DataTable({
                dom: '<"d-flex justify-content-between"<"#title">ft><t><"d-flex justify-content-between"lp>',
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('leads.prospeccao.leadPlantaoVendasPF') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [10,20,30,40,100],
                "ordering": false,
                "paging": true,
                "searching": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,

                columns: [
                    {data:"id",name:"check"},
                    {data:"tempo",name:"tempo"},
                    {data:"created_at",name:"data"},
                    {data:"origem.nome",name:"origem"},
                    {data:"nome",name:"nome"},
                    {data:"telefone",name:"telefone"},
                    {data:"email",name:"email"},
                    {data:"created_at",name:"status"},
                ],
                "columnDefs": [ 
                        {
                            "targets": 0,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                $(td).html('<input type="checkbox" name="marcar_cliente" class="marcar_cliente" data-id="'+cellData+'" />');
                            }    
                        },
                        {
                            "targets": 2,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                //console.log(row);
                                let datas = cellData.split("T")[0]
                                let alvo = datas.split("-").reverse().join("/")
                                $(td).html(alvo);
                            }    
                        },
                        {
                            "targets": 7,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                //console.log(cellData);
                                const now = new Date(Date.now()).toISOString().split("T")[0];    
                                let criacao = new Date(cellData.split("T")[0]).toISOString().split("T")[0];
                                if(criacao == now) {
                                    $(td).html('<span class="badge badge-success" style="width:90%;">Hoje</span>')
                                    
                                } else {
                                    $(td).html('<span class="badge badge-danger" style="width:90%;">Atrasado</span>')
                                }

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
                // "createdRow":function(row, data, dataIndex) {
                //     const now = new Date(Date.now()).toISOString().split("T")[0];    
                //     let criacao = new Date(data.created_at.split("T")[0]).toISOString().split("T")[0];
                //     if(criacao == now) {
                //         $(row).addClass('green-color');
                //     } else if(criacao < now) {
                //         $(row).addClass('red-color');
                //     } else {

                //     }
                // },
                "initComplete": function( settings, json ) {
                    $('#title').html("<h4>Plantão de Vendas</h4>");
                }
            });

            $('table').on('click', 'tbody tr', function (e) {
                if(!$(e.target).hasClass('marcar_cliente')) {
                    let id = $(this).closest('tr').find('.marcar_cliente').attr('data-id');
                    let telefone = $(this).closest('tr').find("td:eq(5)").text().replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","");
                    let email = $(this).closest('tr').find("td:eq(6)").text();
                    let marcados = $(this).closest("table").find("input[type=checkbox]:checked");
                    if($(this).closest('tr').find('.marcar_cliente').prop('checked')) {
                        $(this).closest('tr').find('.marcar_cliente').prop('checked',false);
                        $(this).closest('tr').removeClass('textoforte');
                        ta.$('tr').removeClass('textoforte');
                        ta.$('tr').find('.marcar_cliente').prop('checked',false);                   
                        $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                        $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                        $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    } else {
                        ta.$('tr').removeClass('textoforte');
                        ta.$('tr').find('.marcar_cliente').prop('checked',false);
                        $(this).closest('tr').find('.marcar_cliente').prop('checked',true);
                        $(this).closest('tr').addClass('textoforte');
                        $(".orcamento").attr('style','cursor:pointer').attr("href","/admin/cotacao/orcamento/"+id);
                        $(".whatsapp").attr('style','cursor:pointer').attr('data-id',id).attr("href","https://api.whatsapp.com/send?phone=55"+telefone).attr('target',"_blank");
                        $(".email").attr('style','cursor:pointer').attr('data-id',id).attr("href","mailto:"+email);                
                    }
                }
            });

            $(".atrasada").on('click',function(){
                $("div").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Atrasado</h4>");
                ta.ajax.url("{{ route('cliente.getClienteAtrasadasAjaxProspeccao') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $(".hoje").on('click',function(){
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Hoje</h4>");
                ta.ajax.url("{{ route('cliente.getClientesParaHojeProspeccao') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $(".semana").on('click',function(){
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Semana</h4>");
                ta.ajax.url("{{ route('cliente.listarClientesSemanaAjaxProspeccao') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $(".mes").on('click',function(){
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Mês</h4>");
                ta.ajax.url("{{ route('cliente.listarClienteMesAjaxProspeccao') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $(".todos").on('click',function(){
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Todos</h4>");
                ta.ajax.url("{{ route('cliente.listarClienteMesAjaxProspeccao') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $("form[name='cadastrar_pessoa_fisica']").on('submit',function(){
                let form = $(this);
                $.ajax({
                    url:"{{route('leads.prospeccao.store')}}",
                    data:$(this).serialize(),
                    method:"POST",
                    beforeSend:function() {
                        if(form.find("#nome").val() == "") {
                            $(".errornome").html("<p class='alert alert-danger'>Nome é obrigatório</p>")
                            return false;
                        } else {
                            $(".errornome").html("")
                        }
                        if(form.find("#cidade_id").val() == "") {
                            $(".errorcidade").html("<p class='alert alert-danger'>Cidade é obrigatório</p>")
                            return false;
                        } else {
                            $(".errorcidade").html("")
                        }
                        if(form.find("#telefone").val() == "") {
                            $(".errortelefone").html("<p class='alert alert-danger'>Telefone é obrigatório</p>")
                            return false;
                        } else {
                            $(".errortelefone").html("")
                        }
                        if(form.find("#email").val() == "") {
                            $(".erroremail").html("<p class='alert alert-danger'>Email é obrigatório</p>")
                            return false;
                        } else {
                            $(".erroremail").html("")
                        }
                        if(form.find("#origem_id").val() == "") {
                            $(".errororigem").html("<p class='alert alert-danger'>Escolha uma Origem</p>")
                            return false;
                        } else {
                            $(".errororigem").html("")
                        }             
                    },  
                    success:function(res) {
                        if(res != "error") {
                            ta.ajax.reload();
                            toastr["success"](res.nome + " cadastrado com sucesso")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            $('#cadastrarPessoaFisica').modal('hide');
                            form.find("#nome").val('');
                            form.find("#email").val('');
                            form.find("#telefone").val('');
                            form.find("#cidade_id").val('');
                            form.find("#origem_id").val('');
                            $('div[class*="atendimento_inciado"]').removeClass('fundo');
                            $('div[class*="plantao_vendas"]').removeClass('fundo');
                            $('div[class*="prospeccao"]').addClass('fundo');
                            ta.ajax.url("{{ route('leads.prospeccao.leadProspeccaoPF') }}").load();
                            $("#qtdVendas").html(res.quantidade_plantao_vendas);
                            $("#prospeccao").html(res.quantidade_prospeccao);
                            $("#qtdAtendimento").html(res.quantidade_atendimento_iniciado);
                            $("#quantidade_atrasadas").html(res.atrasada);
                            $("#quantidade_hoje").html(res.hoje);
                            $("#quantidade_semana").html(res.semana);
                            $("#quantidade_mes").html(res.mes);
                            $("#quantidade_total").html(res.mes);
                        } else {
                            
                        }
                    }
                });
                return false;
            });

            $(".prospeccao").on('click',function(){
                $('div[class*="atendimento_inciado"]').removeClass('fundo');
                $('div[class*="plantao_vendas"]').removeClass('fundo');
                $('div[class*="prospeccao"]').addClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $("#title").html("<h4>Prospecção</h4>");
                ta.ajax.url("{{ route('leads.prospeccao.leadProspeccaoPF') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $(".plantao_vendas").on('click',function(){
                $('div[class*="prospeccao"]').removeClass('fundo');
                $('div[class*="atendimento_inciado"]').removeClass('fundo');
                $('div[class*="plantao_vendas"]').addClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                ta.ajax.url("{{ route('leads.prospeccao.leadPlantaoVendasPF') }}").load();
                $("#title").html("<h4>Plantão de Vendas</h4>");
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $( ".plantao_vendas" ).trigger( "click");

            $(".atendimento_inciado").on('click',function(){
                $('div[class*="prospeccao"]').removeClass('fundo');
                $('div[class*="plantao_vendas"]').removeClass('fundo');
                $('div[class*="atendimento_inciado"]').addClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                ta.ajax.url("{{ route('leads.prospeccao.leadAtendimentoPF') }}").load();
                $("#title").html("<h4>Atendimento Iniciado</h4>");
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                return false;
            });

            $("form[name='cadastrar_pessoa_jurica']").on('submit',function(){
                let form = $(this);
                $.ajax({
                    url:"{{route('leads.prospeccao.store.pj')}}",
                    method:"POST",
                    data:$(this).serialize(),
                    beforeSend:function() {
                        if(form.find("#cnpj").val() == "") {
                            $(".errorcnpj").html("<p class='alert alert-danger'>CNPJ é obrigatório</p>")
                            return false;
                        } else {
                            $(".errorcnpj").html("")
                        }
                        if(form.find("#nome_empresa").val() == "") {
                            $(".errornomeempresa").html("<p class='alert alert-danger'>Nome da Empresa é obrigatório</p>");
                            return false;
                        } else {
                            $(".errornomeempresa").html("");
                        }
                        if(form.find("#nome_responsavel").val() == "") {
                            $(".errornomeresponsavel").html("<p class='alert alert-danger'>Nome Responsavel é obrigatório</p>");
                            return false;
                        } else {
                            $(".errornomeresponsavel").html("");
                        }
                        if(form.find("#cidade_id_empresa").val() == "") {
                            $(".errorcidadeempresa").html("<p class='alert alert-danger'>Cidade é obrigatório</p>")
                            return false;
                        } else {
                            $(".errorcidadeempresa").html("")
                        }
                        if(form.find("#celular_empresa").val() == "") {
                            $(".errorcelularempresa").html("<p class='alert alert-danger'>Celular é obrigatório</p>")
                            return false;
                        } else {
                            $(".errorcelularempresa").html("")
                        }
                        if(form.find("#email_empresa").val() == "") {
                            $(".erroremailempresa").html("<p class='alert alert-danger'>Email é obrigatório</p>")
                            return false;
                        } else {
                            $(".erroremailempresa").html("")
                        }
                    },  
                    success:function(res) {
                        if(res != "error") {
                            ta.ajax.reload();
                            toastr["success"](res + " cadastrado com sucesso")
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            $("#cnpj").val('');
                            $("#nome_empresa").val('');
                            $("#nome_responsavel").val('');
                            $("#cidade_id_empresa").val('');
                            $("#celular_empresa").val('');
                            $("#telefone_empresa").val('');
                            $("#email_empresa").val('');
                            $('#cadastrarPessoaJuridica').modal('hide');
                        }
                    }
                });
                return false;
            });

            function cbx1(){
                var arr = [];
                var itens = $('input[type=checkbox]:checked');
                $.each(itens,function(e,i){
                    arr.push($(i).attr('data-id'));
                });
                return arr
            }       
            
            // function selecionados() {
            //     var itens = $('input[type=checkbox]:checked');
            //     $.each(itens,function(e,i){
                    
            //         $(i).addClass('textoforte');
            //         console.log(i)
            //     });
            // }    

            $("body").on('change','input[name="marcar_cliente"]',function(){
                let marcados = $('input[type=checkbox]:checked').length;
                if(marcados == 1) {
                    let id = $('input[type=checkbox]:checked').attr('data-id');
                    let data = $('input[type=checkbox]:checked');
                    let telefone = data.closest('tr').find("td:eq(5)").text().replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","");
                    let email = data.closest('tr').find("td:eq(6)").text();
                    $(".orcamento").attr('style','cursor:pointer').attr("href","/admin/cotacao/orcamento/"+id);
                    $(".whatsapp").attr('style','cursor:pointer').attr('data-id',id).attr("href","https://api.whatsapp.com/send?phone=55"+telefone).attr('target',"_blank");
                    $(".email").attr('style','cursor:pointer').attr('data-id',id).attr("href","mailto:"+email);
                    $(".editar").attr('style','cursor:pointer').attr("data-id",id);                 
                } else {
                    $('tr').removeClass('textoforte'); 
                    $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").attr('data-id',"");
                }            
                if(marcados >= 1) {
                    $(".exportar").attr('style','cursor:pointer');
                } else {
                    $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);');    
                }

                // selecionados();

            });

            $('.exportar').on('click',function(){
                let ids = cbx1();
                $.ajax({
                    url:"{{route('leads.prospeccao.exportar')}}",
                    method:"POST",
                    data:"ids="+ids,
                    xhrFields: {
                        responseType: 'blob' 
                    },
                    success:function(blob,status,xhr) {
                        var filename = "";
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                        }
                        if (typeof window.navigator.msSaveBlob !== 'undefined') {
                            window.navigator.msSaveBlob(blob, filename);
                        } else {
                            var URL = window.URL || window.webkitURL;
                            var downloadUrl = URL.createObjectURL(blob);
                            if (filename) {
                                var a = document.createElement("a");
                                if (typeof a.download === 'undefined') {
                                    window.location.href = downloadUrl;
                                } else {
                                    a.href = downloadUrl;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.click();
                                }
                            } else {
                                window.location.href = downloadUrl;
                            }
                            setTimeout(function () { URL.revokeObjectURL(downloadUrl); }, 100);
                        }
                    }    
                });
                return false;
            });

            $('.whatsapp').on('click',function(){
                let id = $(this).attr('data-id');
                mudarStatus(id)
            });

            $('.email').on('click',function(){
                let id = $(this).attr('data-id');
                mudarStatus(id)
            });

            
       




            function mudarStatus(id) {
                $.ajax({
                    url:"{{route('leads.prospeccao.mudarStatus')}}",
                    method:"POST",
                    data:"id="+id,
                    success:function(res) {
                        
                        $("#qtdVendas").html(res.plantao_vendas);
                        $("#prospeccao").html(res.prospeccao);
                        $("#qtdAtendimento").html(res.atedimento);
                        $('div[class*="prospeccao"]').removeClass('fundo');
                        $('div[class*="plantao_vendas"]').removeClass('fundo');    
                        $('div[class*="atendimento_inciado"]').addClass('fundo');
                        ta.ajax.url("{{ route('leads.prospeccao.leadAtendimentoPF') }}").load();
                    }
                }); 
            }

            // $('body').find('.title').append("<p>OLaaaaaaaaaaaaaa</p>");
       
    });
    </script>
@stop