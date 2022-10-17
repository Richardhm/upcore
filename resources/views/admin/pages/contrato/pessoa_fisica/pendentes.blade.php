@extends('adminlte::page')
@section('title', 'Contrato')
@section('plugins.Datatables', true)
@section('content_header')
    <h4 class="text-white">GERENCIAMENTO CONTRATO PESSOA FISICA</h4>  
@stop
@section('content')
<section class="d-flex justify-content-between" style="flex-wrap: wrap;">

       


        <!--COLUNA LEFT-->
        
        <!--FIM COLUNA LEFT-->

        <!--COLUNA CENTRO-->
        <div class="text-white p-2 align-self-start mx-auto" style="flex-basis:50%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
            <div id="table" class="py-3">
                <table id="tabela" class="table listarcontratos">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Codigo Externo</th>
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
        <div class="mr-1 mx-auto py-1 px-3 coluna-right">
            
           <section>

                <div class="d-flex mb-2">

                    <div style="flex-basis:18%;">
                        <span class="text-white">Data:</span>
                        <input type="text" name="data" id="data" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;margin:0 2%;">
                        <span class="text-white">Codigo Externo:</span>
                        <input type="text" name="codigo_externo" id="codigo_externo" class="form-control form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:49%;">
                        <span class="text-white">Status Contrato:</span>
                        <input type="text" name="status_contrato" id="status_contrato" class="form-control  form-control-sm" readonly>
                    </div>    


                </div>

                <div class="d-flex mb-2">

                    <div style="flex-basis:49%">
                        <span class="text-white">Administradora:</span>
                        <input type="text" name="administradora" id="administradora" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:49%;margin:0 0 0 5%;">
                        <span class="text-white">CPF:</span>
                        <input type="text" name="cpf" id="cpf" class="form-control  form-control-sm" readonly>
                    </div>    


                </div>    

                <div class="d-flex mb-2">

                    <div style="flex-basis:49%">
                        <span class="text-white">Data Nascimento:</span>
                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:49%;margin:0 0 0 5%;">
                        <span class="text-white">Email:</span>
                        <input type="text" name="email" id="email" class="form-control  form-control-sm" readonly>
                    </div>    


                </div>

                <div class="d-flex mb-2">

                    <div style="flex-basis:49%">
                        <span class="text-white">Responsavel Financeiro:</span>
                        <input type="text" name="responsavel_financeiro" id="responsavel_financeiro" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:49%;margin:0 0 0 5%;">
                        <span class="text-white">CPF Financeiro:</span>
                        <input type="text" name="cpf_financeiro" id="cpf_financeiro" class="form-control  form-control-sm" readonly>
                    </div>    


                </div>

                <div class="d-block mb-2">
                    <span  class="text-white">Endereço:</span><br />
                    <input type="text" name="endereco" id="endereco" class="form-control  form-control-sm" readonly>
                </div>

                <div class="d-flex">

                    <div class="d-flex align-items-center" style="flex-basis:30%;flex-wrap:wrap;">
                        <div>
                            <span class="text-white">Cidade:</span> 
                            <input type="text" name="cidade" id="cidade" class="form-control  form-control-sm" readonly>
                        </div>
                    </div>

                    <div class="d-flex flex-column justify-content-end" style="flex-basis:70%;">
                        <div class="d-flex justify-content-end">
                            <span class="d-flex align-items-center justify-content-end" style="flex-basis:25%;color:#FFF;">Data Vigencia:</span>
                            <input type="text" name="data_vigencia" id="data_vigencia" class="form-control  form-control-sm" style="flex-basis:70%;" readonly>
                        </div>
                        <div class="d-flex justify-content-end my-3">
                            <span class="d-flex align-items-center justify-content-end" style="flex-basis:25%;color:#FFF;">Data Boleto:</span>
                            <input type="text" name="data_boleto" id="data_boleto" class="form-control  form-control-sm" style="flex-basis:70%;" readonly>
                        </div>
                        <div class="d-flex justify-content-end">
                            <span class="d-flex align-items-center justify-content-end" style="flex-basis:25%;color:#FFF;">Valor Adesão:</span>
                            <input type="text" name="valor_adesao" id="valor_adesao" class="form-control  form-control-sm" style="flex-basis:70%;" readonly>
                        </div>
                    </div>

                </div>


                <div class="d-flex mt-3 mb-2">
                    <div style="flex-basis:32%;">
                        <span class="text-white">Faixas Etarias</span>
                        <input type="text" name="faixas_etarias" id="faixas_etarias" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;margin:0 2%;">
                        <span class="text-white">Plano Com Coparticipação</span>
                        <input type="text" name="plano_com_coparticipacao" id="plano_com_coparticipacao" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:32%;">
                        <span class="text-white">Plano Com Odonto</span>
                        <input type="text" name="plano_com_odonto" id="plano_com_odonto" class="form-control  form-control-sm" readonly>
                    </div>
                </div>

                <div class="d-flex">

                    <div style="flex-basis:49%">    
                        <span class="text-white">Tipo Plano</span>
                        <input type="text" name="tipo_plano" id="tipo_plano" class="form-control  form-control-sm" readonly>
                    </div>

                    <div style="flex-basis:49%;margin:0 0 0 5%;">
                        <span class="text-white">Valor Contrato</span>
                        <input type="text" name="valor_contrato" id="valor_contrato" class="form-control  form-control-sm" readonly>
                    </div>

                </div>    




            </section>


            <div  class="border-top mt-3">
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
        // $('#telefone').mask('(00) 0 0000-0000');

        // $(".fa-bars").on('click',function(){
        //         if($('body').hasClass('sidebar-collapse')) {
        //             $('body').removeClass('sidebar-mini');
        //             $('body').addClass('sidebar-hidden')
        //         } else {
        //             $('body').removeClass('sidebar-hidden');
        //             $('body').addClass('sidebar-mini')
        //         }
        //     });



        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var ta = $(".listarcontratos").DataTable({
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                "url":"{{ route('contratos.pf.listarpendentes') }}",
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
                
                {data:"created_at",name:"data"},
                //{data:"origem.nome",name:"origem"},
                {data:"codigo_externo",name:"codigo_externo"},
                {data:"clientes.nome",name:"cliente"},
                {data:"administradora.nome",name:"administradora"},
                {data:"financeiro.nome",name:"administradora"},
            ],
            "columnDefs": [ {
                    "targets": 0,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        let datas = cellData.split("T")[0]
                        let alvo = datas.split("-").reverse().join("/")
                        $(td).html(alvo)    
                    }
                }],
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
            }
        });

        var table = $('#tabela').DataTable();
        $('table').on('click', 'tbody tr', function () {
            let data = table.row(this).data();
            console.log(data);
            let criacao = data.created_at.split("T")[0].split("-").reverse().join("/");
            let nascimento = data.clientes.data_nascimento.split("T")[0].split("-").reverse().join("/");
            let data_vigencia = data.clientes.data_vigente.split("T")[0].split("-").reverse().join("/");
            let data_boleto = data.clientes.data_boleto.split("T")[0].split("-").reverse().join("/");
            let coparticipacao = data.coparticipacao == 1 ? "sim" : "nao";
            let odonto = data.odonto == 1 ? "sim" : "nao";
            let valor_contrato = Number(data.valor).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            let valor_adesao = Number(data.clientes.valor_adesao).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

            $("#data").val(criacao);
            $("#codigo_externo").val(data.codigo_externo);
            $("#status_contrato").val(data.financeiro.nome);
            $("#administradora").val(data.administradora.nome);
            $("#cpf").val(data.clientes.cpf);
            $("#data_nascimento").val(nascimento);
            $("#email").val(data.clientes.email);
            $("#endereco").val(data.clientes.endereco)
            $("#cidade").val(data.cidade.nome);
            $("#data_vigencia").val(data_vigencia);
            $("#data_boleto").val(data_boleto);
            $("#valor_adesao").val(valor_adesao);
            $("#plano_com_coparticipacao").val(coparticipacao);
            $("#plano_com_odonto").val(odonto);
            $("#valor_contrato").val(valor_contrato);
            $("#tipo_plano").val(data.acomodacao.nome);

            comissoes_premiacoes(data.id,data.financeiro_id)

        });




        function comissoes_premiacoes(id,financeiro) {
            if(financeiro == 6) {
                $.ajax({
                    url:"{{route('comissoes.cliente.detalhes')}}",
                    method:"POST",
                    data:"cotacao="+id,
                    success:function(res) {
                        $(".comissoes").html(res)
                    }
                });
            }
        }


       


       
    });
    </script>
@stop

@section('css')
    <style>
         .table-cell-edit{background-color: rgba(0,0,0,0.5);color:#FFF;cursor: pointer;}
    .alvo {cursor:pointer;}

    textarea {resize: none;}   

    .coluna-right {
        overflow-y:scroll;flex-basis:45%;flex-wrap: wrap;background-color:rgba(0,0,0,0.5);border-radius:5px;height:720px;
    }

    .coluna-right::-webkit-scrollbar {width: 12px;}
    .coluna-right::-webkit-scrollbar-track {background: orange;}
    .coluna-right::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;} 
    </style>
@stop