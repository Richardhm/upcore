@extends('adminlte::page')
@section('title', 'Contrato PESSOA jurídica')
@section('plugins.Datatables', true)
@section('content_header')
    <h4 class="text-white">GERENCIAMENTO CONTRATO PESSOA jurídica</h4>  
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

@if (session('cliente_id'))
    
    <input type="hidden" name="cliente_id" id="cliente_id" value="{{session('cliente_id')}}">


@endif




<section class="d-flex justify-content-between" style="flex-wrap: wrap;">



        <!--COLUNA LEFT-->
        <div class="d-flex flex-column text-white ml-1" style="flex-basis:13%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
           

        <div style="margin:0 0 20px 0;padding:0;background-color:rgba(0,0,0,0.5);border-radius:5px;">
                <h5 class="text-center d-flex align-items-center justify-content-center py-2 border-bottom">Pedentes</h5>
                <ul style="margin:0;padding:0;list-style:none;" id="listar">
                    <li style="padding:9px 5px;display:flex;justify-content:space-between;" id="aguardando_boleto_coletivo">
                        <span>Boleto Coletivo</span>

                        @if($qtdAguardandoBoletoColetivo >= 1)
                            <span class="badge badge-info">{{$qtdAguardandoBoletoColetivo}}</span>
                        @else
                            <span class="badge badge-danger">{{$qtdAguardandoBoletoColetivo}}</span>
                        @endif
                        
                    </li>
                    <li style="padding:9px 5px;display:flex;justify-content:space-between;" id="aguardando_pagamento_adesao_coletivo">
                        <span>Pag. Adesão Coletivo</span>

                        @if($qtdAguardandoPagAdesaoColetivo >= 1)
                            <span class="badge badge-info">{{$qtdAguardandoPagAdesaoColetivo}}</span>
                        @else
                            <span class="badge badge-danger">{{$qtdAguardandoPagAdesaoColetivo}}</span>
                        @endif



                      
                    </li>
                    <li style="padding:9px 5px;display:flex;justify-content:space-between;" id="aguardando_pagamento_plano_individual">
                        <span>Pag. Individual</span>

                        @if($qtdAguardandoPagPlanoIndividual >= 1)
                            <span class="badge badge-info">{{$qtdAguardandoPagPlanoIndividual}}</span>
                        @else
                            <span class="badge badge-danger">{{$qtdAguardandoPagPlanoIndividual}}</span>
                        @endif


                    </li>
                    <li style="padding:9px 5px;display:flex;justify-content:space-between;" id="aguardando_pagamento_vigencia">
                        <span>Pag. Vigencia</span>

                        @if($qtdPagVigencia >= 1)
                            <span class="badge badge-info">{{$qtdPagVigencia}}</span>
                        @else
                            <span class="badge badge-danger">{{$qtdPagVigencia}}</span>
                        @endif



                        
                    </li>
                    <li style="padding:9px 5px;display:flex;justify-content:space-between;" id="aguardando_pagamento_empresarial">
                        <span>Pag. Empresarial</span>

                        @if($qtdAguardandoPagEmpresarial >= 1)
                            <span class="badge badge-info">{{$qtdAguardandoPagEmpresarial}}</span>
                        @else
                            <span class="badge badge-danger">{{$qtdAguardandoPagEmpresarial}}</span>
                        @endif

                       
                    </li>
                   
                </ul>
            </div> 
            
           
            <div style="margin:0;padding:0;background-color:rgba(0,0,0,0.5);border-radius:5px;">
                <h5 class="text-center d-flex align-items-center justify-content-center py-2 border-bottom">Contratos</h5>
                <ul style="margin:0;padding:0;list-style:none;" id="listar">
                   
                    <li style="padding:9px 5px;display:flex;justify-content:space-between;" id="comissoes">
                        <span>Comissões</span>

                        @if($qtdComissoes >= 1)
                            <span class="badge badge-info">{{$qtdComissoes}}</span>
                        @else
                            <span class="badge badge-danger">{{$qtdComissoes}}</span>
                        @endif    


                        
                    </li>
                    <li style="padding:9px 5px;display:flex;justify-content:space-between;" id="finalizado">
                        <span>Finalizado</span>

                        @if($qtdFinalizado >= 1)
                            <span class="badge badge-info">{{$qtdFinalizado}}</span>
                        @else
                            <span class="badge badge-danger">{{$qtdFinalizado}}</span>
                        @endif   


                       
                    </li>
                </ul>
            </div>
















        </div>    





        <!--FIM COLUNA LEFT-->

        <!--COLUNA CENTRO-->
        <div class="text-white p-1 mx-auto" style="flex-basis:53%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
            <div id="table" class="py-2">
                <table id="tabela" class="table listarcontratos">
                    <thead>
                        <tr>
                            <th>Data</th>
                            
                            <th>Cliente</th>
                            <th>Administradora</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>   
            </div> 
        </div>  
        <!--FIM COLUNA CENTRO-->
        
        <!--COLUNA RIGHT-->
        <div class="mr-1 coluna-right">
            
           <section class="p-1">

                <div class="d-flex mb-2">

                    <div style="flex-basis:32%;">
                        <span class="text-white" style="font-size:0.8em;">Cliente:</span>
                        <input type="text" name="cliente" id="cliente" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;margin:0 2%;">
                        <span class="text-white" style="font-size:0.8em;">Cidade:</span> 
                        <input type="text" name="cidade" id="cidade" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;" id="status">
                        <span class="text-white" style="font-size:0.8em;">Status:</span>
                        <select name="estagio_contrato" id="estagio_contrato" class="form-control-sm" readonly>
                            <option value="">--Estagio do Contrato--</option>
                            <option value="1">Pagamento Adesão</option>
                            <option value="2">Pagamento Vigência</option>
                            <option value="3">Pagamento Comissão</option>
                            <option value="4">Pagamento Premiação</option>
                            <option value="5">Finalizado</option>

                        </select>
                    </div>    



                    

                   

                </div>

                <div class="d-flex mb-2">

                    <div style="flex-basis:28%;">
                        <span class="text-white" style="font-size:0.8em;">Telefone:</span>
                        <input type="text" name="telefone" id="telefone" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:42%;margin:0 2%;">
                        <span class="text-white" style="font-size:0.8em;">Email:</span>
                        <input type="text" name="email" id="email" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:28%;">
                        <span class="text-white" style="font-size:0.8em;">Data Nascimento:</span>
                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control form-control-sm" readonly>
                    </div>




                </div>    

                <div class="d-flex mb-2">

                    <div style="flex-basis:32%;">
                        <span class="text-white" style="font-size:0.8em;">CPF:</span>
                        <input type="text" name="cpf" id="cpf" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;margin:0 2%;">
                        <span class="text-white" style="font-size:0.8em;">Responsavel Financeiro:</span>
                        <input type="text" name="responsavel_financeiro" id="responsavel_financeiro" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;">
                        <span class="text-white" style="font-size:0.8em;">CPF Financeiro:</span>
                        <input type="text" name="cpf_financeiro" id="cpf_financeiro" class="form-control  form-control-sm" readonly>
                    </div>    

                </div>

                <div class="d-flex mb-2">

                    <div style="flex-basis:32%;">
                        <span class="text-white" style="font-size:0.8em;">Endereço:</span>
                        <input type="text" name="endereco" id="endereco" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;margin:0 2%;">
                        <span class="text-white" style="font-size:0.8em;">Administradora:</span>
                        <input type="text" name="administradora" id="administradora" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;">
                        <span class="text-white" style="font-size:0.8em;">Codigo Externo:</span>
                        <input type="text" name="codigo_externo" id="codigo_externo" class="form-control  form-control-sm" readonly>
                    </div>    

                </div>

                
                <div class="d-flex mb-2">

                    <div style="flex-basis:19%;">
                        <span class="text-white" style="font-size:0.8em">Data Contrato:</span>
                        <input type="text" name="data_contrato" id="data_contrato" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:19%;margin:0 2%;">
                        <span class="text-white" style="font-size:0.8em">Valor Contrato:</span>
                        <input type="text" name="valor_contrato" id="valor_contrato" class="form-control  form-control-sm" readonly>
                    </div>

                     <div style="flex-basis:19%;">
                        <span class="text-white" style="font-size:0.8em;">Data Vigência:</span>
                        <input type="text" name="data_vigencia" id="data_vigencia" class="form-control  form-control-sm" readonly>
                    </div>
                    
                     <div style="flex-basis:19%;margin:0 2%;">
                        <span class="text-white" style="font-size:0.8em;">Data Boleto:</span>
                        <input type="text" name="data_boleto" id="data_boleto" class="form-control  form-control-sm" readonly>
                    </div>

                     <div style="flex-basis:19%;">
                        <span class="text-white" style="font-size:0.8em;">Valor Adesão:</span>
                        <input type="text" name="valor_adesao" id="valor_adesao" class="form-control  form-control-sm" readonly>
                    </div>

                </div>

                

                


               

                <div class="d-flex">

                    <div style="flex-basis:38%">    
                        <span class="text-white" style="font-size:0.8em;">Tipo Plano</span>
                        <input type="text" name="tipo_plano" id="tipo_plano" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:24%;margin:1% 1% 0 1%;">
                        <div class="form-group d-flex justify-content-center flex-column" id="coparticipacao">
                            <span class="text-white" style="font-size:0.8em;">Coparticipação:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-light" id="coparticipacao_sim" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="coparticipacao" id="coparticipacao_radio_sim"  value="sim"> Sim
                                </label>
                                <label class="btn btn-outline-light" id="coparticipacao_nao" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="coparticipacao" id="coparticipacao_radio_nao" value="nao"> Não
                                </label>
                                
                            </div>
                            
                        </div>
                    </div>    
                    <div style="flex-basis:24%;margin:1% 1% 0 0;">
                        <div class="form-group  d-flex justify-content-center flex-column" id="odonto">
                            <span class="text-white" style="font-size:0.8em;">Odonto:</span>
                            
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-light" id="odonto_sim" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="odonto" id="odonto_radio_sim" value="sim"> Sim
                                </label>
                                <label class="btn btn-outline-light" id="odonto_nao" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="odonto" id="odonto_radio_nao" value="nao"> Não
                                </label>
                                
                            </div>
                            
                        </div>
                    </div> 

                    <div style="flex-basis:11%">    
                        <span class="text-white" style="font-size:0.8em;">Vidas</span>
                        <input type="text" name="quantidade_vidas" id="quantidade_vidas" class="form-control  form-control-sm" readonly>
                    </div>
                    

                </div>    




            </section>


            <div  class="border-top mt-1">
                <h4 class="mt-2 text-white text-center">Comissões/Premiações</h4>   
                <div class="comissoes">

                </div>
            </div>





        </div>
        <!--FIM Coluna RIGHT-->
</section>
@stop

@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){
                 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var ta = $(".listarcontratos").DataTable({
                dom: '<"d-flex justify-content-between"<"#title">ft><t><"d-flex justify-content-between"lp>',
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('contratos.pj.listarpendentes') }}",
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
                    
                    {data:"created_at",name:"data"},
                    // {data:"codigo_externo",name:"codigo_externo"},
                    {data:"clientes.nome",name:"cliente"},
                    {data:"administradora.nome",name:"administradora"},
                    {data:"financeiro.nome",name:"administradora"},
                ],
                "columnDefs": [ 
                        {
                            /** Data*/
                            "targets": 0,
                            "createdCell": function (td, cellData, rowData, row, col) {
                                let datas = cellData.split("T")[0]
                                let alvo = datas.split("-").reverse().join("/")
                                $(td).html(alvo)    
                            },
                            "width":"4%"
                        },
                        {
                            /** Cliente */
                            "targets": 1,
                            "width":"38%"
                        },
                        {
                            /** Administradora */
                            "targets": 2,
                            "width":"4%"
                        },
                        {
                            /** Status */
                            "targets": 3,
                            "width":"50%"
                        }
                ],
                rowCallback: function (row, data) {
                    let alvo_id = $("#cliente_id").val();
                    if ( $(row).hasClass('odd') ) {
                        $(row).addClass('table-cell-edit');
                    } else {
                        $(row).addClass('alvo');
                    }
                    if(alvo_id != null && data.cliente_id == alvo_id) {

                        let criacao = data.created_at.split("T")[0].split("-").reverse().join("/");
                        let nascimento = data.clientes.data_nascimento.split("T")[0].split("-").reverse().join("/");
                        let data_vigencia = data.clientes.data_vigente.split("T")[0].split("-").reverse().join("/");
                        let data_boleto = data.clientes.data_boleto.split("T")[0].split("-").reverse().join("/");
                        let valor_contrato = Number(data.valor).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                        let valor_adesao = Number(data.clientes.valor_adesao).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});           
                        let vidas = data.somar_cotacao_faixa_etaria[0].soma;

                        $('select option[value="1"]').prop('selected',true)


                        $("#cliente").val(data.clientes.nome);
                        $("#cidade").val(data.cidade.nome);
                        $("#telefone").val(data.clientes.telefone);
                        $("#email").val(data.clientes.email);
                        $("#data_nascimento").val(nascimento);
                        $("#cpf").val(data.clientes.cpf);
                        $("#responsavel_financeiro").val(data.clientes.responsavel_financeiro);
                        $("#cpf_financeiro").val(data.clientes.cpf_financeiro);
                        $("#endereco").val(data.clientes.endereco);
                        $("#administradora").val(data.administradora.nome);
                        $("#codigo_externo").val(data.clientes.codigo_externo);
                        $("#data_contrato").val(criacao);
                        $("#valor_contrato").val(valor_contrato);
                        $("#data_vigencia").val(data_vigencia);
                        $("#data_boleto").val(data_boleto);
                        $("#valor_adesao").val(valor_adesao);
                        $("#tipo_plano").val(data.plano.nome);
                        $("#quantidade_vidas").val(vidas);

                        if(data.coparticipacao) {       
                            $("#coparticipacao_sim").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                        } else {
                            $("#coparticipacao_nao").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                        }
                        if(data.odonto) {
                            $("#odonto_sim").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                        } else {
                            $("#odonto_nao").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                        }


                        $(row).addClass('textoforte');
                    }
                    


                },
                
                drawCallback: function () {
                    $('.page-link').addClass('btn-sm border-0');
                    // $('.form-control').addClass('bg-dark');
                },
                "initComplete": function( settings, json ) {
                    $('#title').html("<h4>Contratos Pessoa Juridica</h4>");
                },
            });

            $("#aguardando_boleto_coletivo").on('click',function(){
                ta.ajax.url("{{ route('contratos.pj.aguadandoBoletoColetivo') }}").load();

                $("#cliente").val('');
                $("#cidade").val('');
                $("#telefone").val('');
                $("#email").val('');
                $("#data_nascimento").val('');
                $("#cpf").val('');
                $("#endereco").val('');
                $("#administradora").val('');
                $("#codigo_externo").val('');
                $("#data_contrato").val('');
                $("#valor_contrato").val('');
                $("#data_vigencia").val('');
                $("#data_boleto").val('');
                $("#valor_adesao").val('');
                $("#tipo_plano").val('');
                $("#quantidade_vidas").val('');
             
                $("#coparticipacao_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#coparticipacao_nao").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_nao").attr('style','padding:0.21rem 0.75rem;');

                $("#estagio_contrato").val('');
                $(".comissoes").html('')

            });

            $("#aguardando_pagamento_adesao_coletivo").on('click',function(){
                ta.ajax.url("{{ route('contratos.pj.aguardandoPagamentoAdesaoColetivo') }}").load();

                $("#cliente").val('');
                $("#cidade").val('');
                $("#telefone").val('');
                $("#email").val('');
                $("#data_nascimento").val('');
                $("#cpf").val('');
                $("#endereco").val('');
                $("#administradora").val('');
                $("#codigo_externo").val('');
                $("#data_contrato").val('');
                $("#valor_contrato").val('');
                $("#data_vigencia").val('');
                $("#data_boleto").val('');
                $("#valor_adesao").val('');
                $("#tipo_plano").val('');
                $("#quantidade_vidas").val('');
             
                $("#coparticipacao_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#coparticipacao_nao").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_nao").attr('style','padding:0.21rem 0.75rem;');


                $("#estagio_contrato").val('');
                $(".comissoes").html('')

            });

            $("#aguardando_pagamento_plano_individual").on('click',function(){
                ta.ajax.url("{{ route('contratos.pj.aguadandoPagamentoPlanoIndividual') }}").load();

                $("#cliente").val('');
                $("#cidade").val('');
                $("#telefone").val('');
                $("#email").val('');
                $("#data_nascimento").val('');
                $("#cpf").val('');
                $("#endereco").val('');
                $("#administradora").val('');
                $("#codigo_externo").val('');
                $("#data_contrato").val('');
                $("#valor_contrato").val('');
                $("#data_vigencia").val('');
                $("#data_boleto").val('');
                $("#valor_adesao").val('');
                $("#tipo_plano").val('');
                $("#quantidade_vidas").val('');
             
                $("#coparticipacao_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#coparticipacao_nao").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_nao").attr('style','padding:0.21rem 0.75rem;');


                $("#estagio_contrato").val('');
                $(".comissoes").html('')
            });

            $("#aguardando_pagamento_vigencia").on('click',function(){
                ta.ajax.url("{{ route('contratos.pj.aguadandoPagamentoVigencia') }}").load();

                $("#cliente").val('');
                $("#cidade").val('');
                $("#telefone").val('');
                $("#email").val('');
                $("#data_nascimento").val('');
                $("#cpf").val('');
                $("#endereco").val('');
                $("#administradora").val('');
                $("#codigo_externo").val('');
                $("#data_contrato").val('');
                $("#valor_contrato").val('');
                $("#data_vigencia").val('');
                $("#data_boleto").val('');
                $("#valor_adesao").val('');
                $("#tipo_plano").val('');
                $("#quantidade_vidas").val('');
             
                $("#coparticipacao_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#coparticipacao_nao").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_nao").attr('style','padding:0.21rem 0.75rem;');

                $("#estagio_contrato").val('');
                $(".comissoes").html('')

            });

            $("#aguardando_pagamento_empresarial").on('click',function(){
                ta.ajax.url("{{ route('contratos.pj.aguadandoPagamentoEmpresarial') }}").load();

                $("#cliente").val('');
                $("#cidade").val('');
                $("#telefone").val('');
                $("#email").val('');
                $("#data_nascimento").val('');
                $("#cpf").val('');
                $("#endereco").val('');
                $("#administradora").val('');
                $("#codigo_externo").val('');
                $("#data_contrato").val('');
                $("#valor_contrato").val('');
                $("#data_vigencia").val('');
                $("#data_boleto").val('');
                $("#valor_adesao").val('');
                $("#tipo_plano").val('');
                $("#quantidade_vidas").val('');
             
                $("#coparticipacao_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#coparticipacao_nao").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_nao").attr('style','padding:0.21rem 0.75rem;');

                $("#estagio_contrato").val('');
                $(".comissoes").html('')


            });

            $("#comissoes").on('click',function(){
                ta.ajax.url("{{ route('contratos.pj.listarComissoes') }}").load();

                $("#cliente").val('');
                $("#cidade").val('');
                $("#telefone").val('');
                $("#email").val('');
                $("#data_nascimento").val('');
                $("#cpf").val('');
                $("#endereco").val('');
                $("#administradora").val('');
                $("#codigo_externo").val('');
                $("#data_contrato").val('');
                $("#valor_contrato").val('');
                $("#data_vigencia").val('');
                $("#data_boleto").val('');
                $("#valor_adesao").val('');
                $("#tipo_plano").val('');
                $("#quantidade_vidas").val('');
             
                $("#coparticipacao_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#coparticipacao_nao").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_nao").attr('style','padding:0.21rem 0.75rem;');

                $("#estagio_contrato").val('');
                $(".comissoes").html('')

            });

            $("#finalizado").on('click',function(){
                ta.ajax.url("{{ route('contratos.pj.listarFinalizado') }}").load();

                $("#cliente").val('');
                $("#cidade").val('');
                $("#telefone").val('');
                $("#email").val('');
                $("#data_nascimento").val('');
                $("#cpf").val('');
                $("#endereco").val('');
                $("#administradora").val('');
                $("#codigo_externo").val('');
                $("#data_contrato").val('');
                $("#valor_contrato").val('');
                $("#data_vigencia").val('');
                $("#data_boleto").val('');
                $("#valor_adesao").val('');
                $("#tipo_plano").val('');
                $("#quantidade_vidas").val('');
             
                $("#coparticipacao_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#coparticipacao_nao").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_sim").attr('style','padding:0.21rem 0.75rem;');
                $("#odonto_nao").attr('style','padding:0.21rem 0.75rem;');

                $("#estagio_contrato").val('');
                $(".comissoes").html('')

            }); 

            var table = $('#tabela').DataTable();
            $('table').on('click', 'tbody tr', function () {
                ta.$('tr').removeClass('textoforte');
                $(this).closest('tr').addClass('textoforte');
                let data = table.row(this).data();
                
                if(data.financeiro_id == 1 || data.financeiro_id == 2) {
                    $('select option[value="1"]').prop('selected',true)
                } else if(data.financeiro_id == 4) {
                    $('select option[value="2"]').prop('selected',true)    
                } else if(data.financeiro_id == 6) {

                    let comissao = false;
                    $( data.comissao.comissao_lancadas ).each(function( index,value ) {
                        if(value.status == 0) {
                            comissao = true
                        } else {
                            comissao = false
                        }
                    });

                    let premiacao = false;
                    $( data.comissao.premiacao_lancadas ).each(function( index,value ) {
                        if(value.status == 0) {
                            premiacao = true
                        } else {
                            premiacao = false
                        }
                    });
                    if(comissao && premiacao) {
                        
                        $('select option[value="3"]').prop('selected',true)
                    } else if(comissao && !premiacao) {
                        $('select option[value="3"]').prop('selected',true)
                        
                    } else if(!comissao && premiacao) {
                        $('select option[value="4"]').prop('selected',true)
                    } else {
                        
                        $('select option[value="3"]').prop('selected',true)
                    } 

                } else if(data.financeiro_id == 7) {
                    $('select option[value="5"]').prop('selected',true)
                } else {
                    $('select option[value=""]').prop('selected',true)
                }


                let criacao = data.created_at.split("T")[0].split("-").reverse().join("/");
                let nascimento = data.clientes.data_nascimento.split("T")[0].split("-").reverse().join("/");
                console.log(nascimento);
                let data_vigencia = data.clientes.data_vigente.split("T")[0].split("-").reverse().join("/");
                let data_boleto = data.clientes.data_boleto.split("T")[0].split("-").reverse().join("/");
                let valor_contrato = Number(data.valor).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                let valor_adesao = Number(data.clientes.valor_adesao).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});           
                let vidas = data.somar_cotacao_faixa_etaria[0].soma;
                $("#cliente").val(data.clientes.nome);
                $("#cidade").val(data.cidade.nome);
                $("#status_contrato").val(data.financeiro.nome);
                $("#telefone").val(data.clientes.telefone);
                $("#email").val(data.clientes.email);
                $("#data_nascimento").val(nascimento);
                $("#cpf").val(data.clientes.cpf);
                $("#endereco").val(data.clientes.endereco)
                $("#administradora").val(data.administradora.nome);
                $("#codigo_externo").val(data.codigo_externo);              
                $("#data_contrato").val(criacao);
                $("#valor_contrato").val(valor_contrato);
                $("#data_vigencia").val(data_vigencia);
                $("#data_boleto").val(data_boleto);
                $("#valor_adesao").val(valor_adesao);
                $("#coparticipacao_sim").attr("style","padding:0.21rem 0.75rem;");
                $("#coparticipacao_nao").attr("style","padding:0.21rem 0.75rem;");
                $("#odonto_sim").attr("style","padding:0.21rem 0.75rem;");
                $("#odonto_nao").attr("style","padding:0.21rem 0.75rem;");
                if(data.coparticipacao) {       
                    $("#coparticipacao_sim").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                } else {
                    $("#coparticipacao_nao").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                }
                if(data.odonto) {
                    $("#odonto_sim").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                } else {
                    $("#odonto_nao").attr("style","padding:0.21rem 0.75rem;background-color:white;color:black;").attr("disabled",true);
                }
                $("#quantidade_vidas").val(vidas);
                $("#tipo_plano").val(data.plano.nome);               
                comissoes_premiacoes(data.id,data.financeiro_id)
            });

            function comissoes_premiacoes(id,financeiro) {
                if(financeiro == 6 || financeiro == 7) {
                    $.ajax({
                        url:"{{route('comissoes.cliente.detalhes')}}",
                        method:"POST",
                        data:"cotacao="+id,
                        success:function(res) {
                            $(".comissoes").html(res)
                        }
                    });
                } else {
                    $(".comissoes").html('')
                }
            }
       
    });
    </script>
@stop

@section('css')
    <style>
        th { font-size: 0.875em;}
        /* table.dataTable td {font-size: 0.875em;} */
        .table-cell-edit{background-color: rgba(0,0,0,0.5);color:#FFF;cursor: pointer;}
        .alvo {cursor:pointer;}
        textarea {resize: none;}   
        .coluna-right {overflow-y:scroll;flex-basis:33%;flex-wrap: wrap;background-color:rgba(0,0,0,0.5);border-radius:5px;height:720px;}
        .coluna-right::-webkit-scrollbar {width: 12px;}
        .coluna-right::-webkit-scrollbar-track {background: orange;}
        .coluna-right::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;} 
        select[readonly] {background: #eee;pointer-events: none;touch-action: none;}
        /* table.dataTable td {font-size: 0.830em;} */
        #listar li:hover {cursor:pointer;background-color:rgba(0,0,0,0.8);}
        .textoforte {background-color:rgba(255,255,255,0.5);color:black;}
    </style>
@stop