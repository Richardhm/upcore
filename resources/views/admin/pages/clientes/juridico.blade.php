@extends('adminlte::page')
@section('title', 'Leads Pessoa Juridica')
@section('plugins.Datatables', true)
@section('plugins.Toastr', true)
@section('content_header')
    <div class="d-flex align-items-center">
        <h4 class="text-white">Leads Pessoa Juridica</h4>     
        <i class="fas fa-user-plus text-white ml-3 cad" data-toggle="modal" data-target="#cadastrarPessoaJuridica"></i> 
    </div>
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

<input type="hidden" name="pessoa_juridica_cadastrada" id="pessoa_juridica_cadastrada" />

<input type="hidden" name="cliente_clicado" id="cliente_clicado">

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

        <div class="d-flex py-2 justify-content-between links sem_contato" id="menu_4">
            <a href="" class="text-white  ml-1">Sem Contato</a>
            
            @if($qtdSemContato == 0)
                <span class="badge badge-danger  mr-1" id="qtdSemContato">{{$qtdSemContato}}</span>
            @else
                <span class="badge badge-info  mr-1" id="qtdSemContato">{{$qtdSemContato}}</span>
            @endif
        </div>
                                
    </div>


    <div class="py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;">
            <ul style="margin:0px;padding:0px;">
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 atrasada">
                    <span class="ml-2">Atrasadas</span>
                    @if($qtdAtrasado >= 1)
                        <span class="mr-2 badge badge-info" id="quantidade_atrasadas">{{$qtdAtrasado}}</span>
                    @else
                        <span class="mr-2 badge badge-danger" id="quantidade_atrasadas">{{$qtdAtrasado}}</span>
                    @endif


                    
                </a>
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 hoje">
                    <span class="ml-2">Hoje</span>
                    @if($qtdHoje >= 1) 
                        <span class="mr-2 badge badge-info" id="quantidade_hoje">{{$qtdHoje}}</span>
                    @else
                        <span class="mr-2 badge badge-info" id="quantidade_hoje">{{$qtdHoje}}</span>
                    @endif

                    
                </a>    
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 semana">
                    <span class="ml-2">Semana</span>
                    @if($qtdSemana >= 1)
                        <span class="mr-2 badge badge-info" id="quantidade_semana">{{$qtdSemana}}</span>
                    @else
                        <span class="mr-2 badge badge-danger" id="quantidade_semana">{{$qtdSemana}}</span>
                    @endif
                    
                </a>
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 mes">
                    <span class="ml-2">Mês</span>
                    @if($qtdMes >= 1)
                        <span class="mr-2 badge badge-info" id="quantidade_mes">{{$qtdMes}}</span>
                    @else
                        <span class="mr-2 badge badge-danger" id="quantidade_mes">{{$qtdMes}}</span>
                    @endif
                    
                </a>
            </li>
            <li class="links">
                <a href="" class="d-flex justify-content-between text-white py-1 todos">
                    <span class="ml-2">Total Leads</span>
                    @if($qtdTotal >= 1)
                        <span class="mr-2 badge badge-info" id="quantidade_total">{{$qtdTotal}}</span>
                    @else
                        <span class="mr-2 badge badge-danger" id="quantidade_total">{{$qtdTotal}}</span>
                    @endif
                    
                </a>
            </li>
        </ul>
    </div>

    


</div>
<!--FIM COLUNA LEFT-->

<!--COLUNA CENTRO-->
<div class="text-white p-2 align-self-start" style="flex-basis:76%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
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
<div class="mr-1" style="flex-basis:8%;flex-wrap: wrap;background-color:rgba(0,0,0,0.5);border-radius:5px;">
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
        <!-- <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white" style="background-color:rgba(0,0,0,0.4);">
            <i class="fas fa-exchange-alt fa-lg"></i>
            Transferir
        </a>           
        <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="py-2 d-flex flex-column mx-auto text-center my-3 border border-white w-75 text-white exportar" style="background-color:rgba(0,0,0,0.4);">
            <i class="fas fa-file-csv fa-lg"></i>
            Exportar
        </a>     -->
        
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



<!----------------------MODAL EDITAR-------------------------->
<div class="modal fade" id="editarLead" tabindex="-1" role="dialog" aria-labelledby="editarLeadLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color:rgba(0,0,0,0.5);">
    <div class="modal-header">
        <h5 class="modal-title" id="editarLeadLabel" style="color:#FFF;">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color:#FFF;">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    <form action="" method="post" name="editar_lead">
        @csrf
        <input type="hidden" name="editar_cliente_id" id="editar_cliente_id">
        <div class="form-row mb-2">
                <div class="col-6">
                    <span class="text-white">CNPJ:</span>
                    <input type="text" name="editar_cnpj" id="editar_cnpj" class="form-control" placeholder="CNPJ">    
                    <div class="errorcnpj"></div>
                </div>

                <div class="col-6">
                    <span class="text-white">Nome Empresa:</span>
                    <input type="text" name="editar_nome_empresa" id="editar_nome_empresa" class="form-control" placeholder="Empresa">    
                    <div class="errornomeempresa"></div>
                </div>
            </div>

            <div class="form-row">

                <div class="col-6">
                    <span class="text-white">Contato(Responsavel):</span>
                    <input type="text" name="edotar_nome_responsavel" id="editar_nome_responsavel" class="form-control" placeholder="Nome do Responsavel">    
                    <div class="errornomeresponsavel"></div>
                </div>

                <div class="col-6">
                    <span class="text-white">Cidade:</span>
                    <select name="editar_cidade_id" id="editar_cidade_id" class="form-control">
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
                    <input type="text" name="telefone" id="editar_celular_empresa" class="form-control" placeholder="Telefone">  
                    <div class="errorcelularempresa"></div>  
                </div>

                <div class="col-4">
                    <span class="text-white">Telefone(Opicional):</span>
                    <input type="text" name="editar_telefone_empresa" id="editar_telefone_empresa" class="form-control" placeholder="Telefone Empresa">  
                    <div class="errortelefoneempresa"></div>  
                </div>

                <div class="col-4">
                    <span class="text-white">Email:</span>
                    <input type="text" name="email" id="editar_email_empresa" class="form-control" placeholder="Email">    
                    <div class="erroremailempresa"></div>  
                </div>
            </div>

            <input type="submit" class="btn btn-primary btn-block mt-3" value="Editar Pessoa Jurídico">
           
    </form>
 
    </div>
    
    </div>
</div>
</div>



<!----------------------FIM MODAL EDITAR-------------------------->




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
            $('#editar_celular_empresa').mask('(00) 0 0000-0000');
            $('#editar_telefone_empresa').mask('(00) 0 0000-0000');
            $('#cnpj').mask('00.000.000/0000-00');      
            $('#editar_cnpj').mask('00.000.000/0000-00');      
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
                    "url":"{{ route('leads.prospeccao.leadPlantaoVendasPJ') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [50,100,150,200,300,500],
                "ordering": false,
                "paging": true,
                "searching": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
                "deferRender": true,
                columns: [
                    {data:"id",name:"check"},
                    {data:"tempo",name:"tempo"},
                    {data:"created_at",name:"data"},
                    {data:"origem.nome",name:"origem"},
                    {data:"nome",name:"nome"},
                    {data:"telefone",name:"telefone"},
                    {data:"email",name:"email"},
                    {data:"created_at",name:"status"}
                ],
                "columnDefs": [ 
                        {
                            "targets": 0,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                $(td).html('<input type="checkbox" name="marcar_cliente" class="marcar_cliente" data-id="'+cellData+'" />');
                            },
                            "width":"1%" 
                        },
                        {
                            "targets":1,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                
                                if(cellData.indexOf("dias") === -1) {
                                    $(td).html(cellData.substr(0,5));
                                } 
                                //$(td).html('<input type="checkbox" name="marcar_cliente" class="marcar_cliente" data-id="'+cellData+'" />');
                            },
                            "width":"3%"    
                        },
                        {
                            "targets": 2,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                let datas = cellData.split("T")[0]
                                let alvo = datas.split("-").reverse().join("/")
                                $(td).html(alvo);
                            },
                            "width":"5%" 
                        },
                        {
                            "taregets":3,
                            "width":"7%"
                        },
                        {
                            "taregets":4,
                            "width":"40%"
                        },
                        {
                            "taregets":5,
                            "width":"8%"
                        },
                        {
                            "targets":6,
                            "width":"28%"
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

                            },
                            "width":"8%"
                        }    
                ],
                rowCallback: function (row, data,displayNum,displayIndex,dataIndex) {
                    let alvo_id = $("#pessoa_juridica_cadastrada").val();
                    if($(row).hasClass('odd')) {
                        $(row).addClass('table-cell-edit').attr("id",data.id);
                    } else {
                        $(row).addClass('alvo').attr("id",data.id)
                    }
                    if(data.id == alvo_id) {
                        //console.log(row);
                        let telefone = data.telefone.replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","")
                        $(row).find("input[type='checkbox']").prop('checked',true)
                        $(row).addClass('textoforte');

                        $(".orcamento").attr('style','cursor:pointer').attr("href","/admin/cotacao/orcamento/"+data.id);
                        $(".whatsapp").attr('style','cursor:pointer').attr('data-id',data.id).attr("href","https://api.whatsapp.com/send?phone=55"+telefone).attr('target',"_blank");
                        $(".email").attr('style','cursor:pointer').attr('data-id',data.id).attr("href","mailto:"+data.email);  
                        $(".editar").attr('style','cursor:pointer').attr('data-id',data.id);                            
                    }
                    
                },
                "initComplete": function( settings, json ) {
                    $('#title').html("<h4>Plantão de Vendas</h4>");
                    
                }
            });
            var table = $("#tabela").DataTable();
            $('table').on('click', 'tbody tr', function (e) {                
                let data = table.row(this).data();
                $("#cliente_clidado").val(data.id);
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
                        $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                        $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                        $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                        $("#editar_cliente_id").val('');
                        $("#editar_cidade_id").val('');
                        $("#editar_origem_id").val('');
                    } else {
                        ta.$('tr').removeClass('textoforte');
                        ta.$('tr').find('.marcar_cliente').prop('checked',false);
                        $(this).closest('tr').find('.marcar_cliente').prop('checked',true);
                        $(this).closest('tr').addClass('textoforte');
                        $(".orcamento").attr('style','cursor:pointer').attr("href","/admin/cotacao/orcamento/"+id);
                        $(".whatsapp").attr('style','cursor:pointer').attr('data-id',id).attr("href","https://api.whatsapp.com/send?phone=55"+telefone).attr('target',"_blank");
                        $(".email").attr('style','cursor:pointer').attr('data-id',id).attr("href","mailto:"+email);  
                        $(".editar").attr('style','cursor:pointer').attr('data-id',id);                            
                    }
                }
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
                        //console.log(res);
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
                            $("#cnpj").val('');
                            $("#nome_empresa").val('');
                            $("#nome_responsavel").val('');
                            $("#cidade_id_empresa").val('');
                            $("#celular_empresa").val('');
                            $("#telefone_empresa").val('');
                            $("#email_empresa").val('');
                            $('#cadastrarPessoaJuridica').modal('hide');
                            $('div[class*="atendimento_inciado"]').removeClass('fundo');
                            $('div[class*="plantao_vendas"]').removeClass('fundo');
                            $('div[class*="prospeccao"]').addClass('fundo');
                            $("#pessoa_juridica_cadastrada").val(res.id);
                            $("#qtdVendas").html(res.quantidade_vendas);
                            $("#prospeccao").html(res.quantidade_prospeccao);
                            $("#qtdAtendimento").html(res.quantidade_atendimento);
                            $("#quantidade_atrasadas").html(res.quantidade_atrasado);
                            $("#quantidade_hoje").html(res.quantidade_hoje);
                            $("#quantidade_semana").html(res.quantidade_semana);
                            $("#quantidade_mes").html(res.quantidade_mes);
                            $("#quantidade_total").html(res.quantidade_total);
                            ta.ajax.url("{{ route('leads.prospeccao.leadProspeccaoPJ') }}").load();
                            $("#title").html("<h4>Prospecção</h4>");
                        }
                    }
                });
                return false;
            });


            $('form[name="editar_lead"]').on('submit',function(){
                let menu = $("#menu_clicado").val();
                $.ajax({
                    url:"{{route('cliente.editarajax.juridico')}}",
                    method:"POST",
                    data:$(this).serialize(),
                    success:function(res) {
                        
                        $("#editar_cnpj").val('');
                        $("#editar_nome_empresa").val('');
                        $("#editar_nome_responsavel").val('');
                        $("#editar_cidade_id").val('');
                        $("#editar_celular_empresa").val('');
                        $("#editar_telefone_empresa").val('');
                        $("#editar_email_empresa").val('');
                        $("#editarLead").modal('hide');
                        ta.ajax.reload();
                        $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                        $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                        $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                        $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                        $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                        
                    }
                });
                return false;
            });

            $(".editar").on('click',function(){
                let id = $(this).attr('data-id');
                $("#editar_cliente_id").val(id);
               
                $.ajax({
                    url:"{{route('clientes.ajaxclienteslistaporidpost')}}",
                    method:"POST",
                    data:"id="+id,
                    success:function(res) {
                        
                        $("#editar_cnpj").val(res.cnpj);
                        $("#editar_nome_empresa").val(res.nome_empresa);
                        $("#editar_nome_responsavel").val(res.nome);
                        $("#editar_celular_empresa").val(res.telefone);
                        $("#editar_telefone_empresa").val(res.telefone_empresa);
                        $("#editar_email_empresa").val(res.email);
                        $('#editar_cidade_id option[value="'+res.cidade_id+'"]').prop('selected',true);
                       
                    }
                });
                $('#editarLead').modal('show');
                return false;
            });



            $(".atrasada").on('click',function(){
                $("#checkbox-pai").prop('checked',false);
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                $('tr').removeClass('textoforte');
                $("div").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Atrasado</h4>");
                ta.ajax.url("{{ route('cliente.getClienteAtrasadasAjaxProspeccaoPJ') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                
                return false;
            });

            $(".hoje").on('click',function(){
                $("#checkbox-pai").prop('checked',false);
                $('tr').removeClass('textoforte');
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Hoje</h4>");
                ta.ajax.url("{{ route('cliente.getClientesParaHojeProspeccaoPJ') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                return false;
            });

            $(".semana").on('click',function(){
                $("#checkbox-pai").prop('checked',false);
                $('tr').removeClass('textoforte');
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Semana</h4>");
                ta.ajax.url("{{ route('cliente.listarClientesSemanaAjaxProspeccaoPJ') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                return false;
            });

            $(".mes").on('click',function(){
                $("#checkbox-pai").prop('checked',false);
                $('tr').removeClass('textoforte');
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Mês</h4>");
                ta.ajax.url("{{ route('cliente.listarClienteMesAjaxProspeccaoPJ') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                return false;
            });

            $(".todos").on('click',function(){
                $("#checkbox-pai").prop('checked',false);
                $('tr').removeClass('textoforte');
                $("div").removeClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(this).addClass('fundo');
                $("#title").html("<h4>Todos</h4>");
                ta.ajax.url("{{ route('cliente.listarClienteMesAjaxProspeccaoPJ') }}").load();
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                return false;
            });


            
            $(".prospeccao").on('click',function(){
                $("#checkbox-pai").prop('checked',false);
                $('tr').removeClass('textoforte');
                $('div[class*="atendimento_inciado"]').removeClass('fundo');
                $('div[class*="plantao_vendas"]').removeClass('fundo');
                $('div[class*="prospeccao"]').addClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                $("#title").html("<h4>Prospecção</h4>");
                ta.ajax.url("{{ route('leads.prospeccao.leadProspeccaoPJ') }}").load(null,2);
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                return false;
            });

            $(".plantao_vendas").on('click',function(){
                $("#checkbox-pai").prop('checked',false);
                $('tr').removeClass('textoforte');
                $('div[class*="prospeccao"]').removeClass('fundo');
                $('div[class*="atendimento_inciado"]').removeClass('fundo');
                $('div[class*="plantao_vendas"]').addClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                ta.ajax.url("{{ route('leads.prospeccao.leadPlantaoVendasPJ') }}").load();
                $("#title").html("<h4>Plantão de Vendas</h4>");
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                return false;
            });

            $( ".plantao_vendas" ).trigger( "click");

            $(".atendimento_inciado").on('click',function(){
                $("#checkbox-pai").prop('checked',false).removeClass();
                $('tr').removeClass('textoforte');
                $('div[class*="prospeccao"]').removeClass('fundo');
                $('div[class*="plantao_vendas"]').removeClass('fundo');
                $('div[class*="atendimento_inciado"]').addClass('fundo');
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                ta.ajax.url("{{ route('leads.prospeccao.leadAtendimentoPJ') }}").load();
                $("#title").html("<h4>Atendimento Iniciado</h4>");
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id');
                $("#editar_cliente_id").val('');
                $("#editar_cidade_id").val('');
                $("#editar_origem_id").val('');
                return false;
            });

            $('.sem_contato').on('click',function(){
                $('div[class*="prospeccao"]').removeClass('fundo');
                $('div[class*="plantao_vendas"]').removeClass('fundo');
                $('div[class*="atendimento_inciado"]').removeClass('fundo');
                $('div[class*="sem_contato"]').addClass('fundo');
                // $('#menu_clicado').val("menu_3");
                $(".atrasada").removeClass('fundo');
                $(".hoje").removeClass('fundo');
                $(".semana").removeClass('fundo');
                $(".mes").removeClass('fundo');
                $(".todos").removeClass('fundo');
                ta.ajax.url("{{ route('leads.prospeccao.semContatoPJ') }}").load();
                $("#title").html("<h4>Sem Contato</h4>");
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr('href','#');
                $(".editar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $("#checkbox-pai").prop('checked',false);
                $('tr').removeClass('textoforte');
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
                } else {
                    $('tr').removeClass('textoforte'); 
                    $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                    $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id').removeAttr('target');
                    $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#").removeAttr('data-id')
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
                if(id) {
                    mudarStatus(id)
                }
                
            });

            $('.email').on('click',function(){
                let id = $(this).attr('data-id');
                if(id) {
                    mudarStatus(id)
                }
                
            });

            function mudarStatus(id) {
                $.ajax({
                    url:"{{route('leads.prospeccao.mudarStatusPJ')}}",
                    method:"POST",
                    data:"id="+id,
                    success:function(res) {
                        
                        $("#qtdVendas").html(res.plantao_vendas);
                        $("#prospeccao").html(res.prospeccao);
                        $("#qtdAtendimento").html(res.atedimento);
                        $('div[class*="prospeccao"]').removeClass('fundo');
                        $('div[class*="plantao_vendas"]').removeClass('fundo');    
                        $('div[class*="atendimento_inciado"]').addClass('fundo');
                        ta.ajax.url("{{ route('leads.prospeccao.leadAtendimentoPJ') }}").load();
                    }
                }); 
            }

            // $('body').find('.title').append("<p>OLaaaaaaaaaaaaaa</p>");
       
    });
    </script>
@stop