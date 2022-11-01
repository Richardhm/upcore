@extends('adminlte::page')
@section('title', 'Contrato Pessoa Juridica')
@section('plugins.Datatables', true)
@section('content_header')
    <h4 class="text-white">GERENCIAMENTO CONTRATO PESSOA JURIDICA</h4>  
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

    <div style="flex-basis:32%;">
        <span class="text-white">Cliente:</span>
        <input type="text" name="cliente" id="cliente" class="form-control form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;margin:0 2%;">
        <span class="text-white">Cidade:</span> 
        <input type="text" name="cidade" id="cidade" class="form-control  form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;" id="status">
        <span class="text-white">Status:</span>
        <select name="estagio_contrato" id="estagio_contrato" class="form-control-sm">
            <option value="">--Estagio do Contrato--</option>
            <option value="">Pagamento Adesão</option>
            <option value="">Pagamento Vigência</option>
            <option value="">Pagamento Comissão</option>
            <option value="">Pagamento Premiação</option>
        </select>
    </div>    



    

   

</div>

<div class="d-flex mb-2">

    <div style="flex-basis:32%;">
        <span class="text-white">Telefone:</span>
        <input type="text" name="telefone" id="telefone" class="form-control form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;margin:0 2%;">
        <span class="text-white">Email:</span>
        <input type="text" name="email" id="email" class="form-control form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;">
        <span class="text-white">Data Nascimento:</span>
        <input type="text" name="data" id="data" class="form-control form-control-sm" readonly>
    </div>




</div>    

<div class="d-flex mb-2">

    <div style="flex-basis:32%;">
        <span class="text-white">CPF:</span>
        <input type="text" name="cpf" id="cpf" class="form-control form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;margin:0 2%;">
        <span class="text-white">Responsavel Financeiro:</span>
        <input type="text" name="responsavel_financeiro" id="responsavel_financeiro" class="form-control  form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;">
        <span class="text-white">CPF Financeiro:</span>
        <input type="text" name="cpf_financeiro" id="cpf_financeiro" class="form-control  form-control-sm" readonly>
    </div>    

</div>

<div class="d-flex mb-2">

    <div style="flex-basis:32%;">
        <span class="text-white">Endereço:</span>
        <input type="text" name="endereco" id="endereco" class="form-control form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;margin:0 2%;">
        <span class="text-white">Administradora:</span>
        <input type="text" name="administradora" id="administradora" class="form-control  form-control-sm" readonly>
    </div>

    <div style="flex-basis:32%;">
        <span class="text-white">Codigo Externo:</span>
        <input type="text" name="codigo_externo" id="codigo_externo" class="form-control  form-control-sm" readonly>
    </div>    

</div>


<div class="d-flex mb-2">

    <div style="flex-basis:19%;">
        <span class="text-white">Data Contrato:</span>
        <input type="text" name="data_contrato" id="data_contrato" class="form-control form-control-sm" readonly>
    </div>

    <div style="flex-basis:19%;margin:0 2%;">
        <span class="text-white">Valor Contrato:</span>
        <input type="text" name="valor_contrato" id="valor_contrato" class="form-control  form-control-sm" readonly>
    </div>

     <div style="flex-basis:19%;">
        <span class="text-white">Data Vigência:</span>
        <input type="text" name="data_vigencia" id="data_vigencia" class="form-control  form-control-sm" readonly>
    </div>
    
     <div style="flex-basis:19%;margin:0 2%;">
        <span class="text-white">Data Boleto:</span>
        <input type="text" name="data_boleto" id="data_boleto" class="form-control  form-control-sm" readonly>
    </div>

     <div style="flex-basis:19%;">
        <span class="text-white">Valor Adesão:</span>
        <input type="text" name="valor_adesao" id="valor_adesao" class="form-control  form-control-sm" readonly>
    </div>

</div>








<div class="d-flex">

    <div style="flex-basis:24%">    
        <span class="text-white">Tipo Plano</span>
        <input type="text" name="tipo_plano" id="tipo_plano" class="form-control  form-control-sm" readonly>
    </div>

    <div style="flex-basis:24%;margin:0 2%;">
        <div class="form-group d-flex justify-content-center flex-column" id="coparticipacao">
            <span class="text-white">Coparticipação:</span>
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
    <div style="flex-basis:24%;margin-right:1%;">
        <div class="form-group  d-flex justify-content-center flex-column" id="odonto">
            <span class="text-white">Odonto:</span>
            
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

    <div style="flex-basis:24%">    
        <span class="text-white">Vidas</span>
        <input type="text" name="quantidade_vidas" id="quantidade_vidas" class="form-control  form-control-sm" readonly>
    </div>
    

</div>    




</section>


     

   

    

    

   


    

   


    <div class="d-flex border-top mt-3">
        <h4 class="mt-2 text-white text-center">Comissões/Premiações</h4>

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
                "url":"{{ route('contratos.pj.listarpendentes') }}",
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
            // //let coparticipacao = data.coparticipacao == 1 ? "sim" : "nao";
            // //let odonto = data.odonto == 1 ? "sim" : "nao";
            let valor_contrato = Number(data.valor).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            let valor_adesao = Number(data.clientes.valor_adesao).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});           
            let vidas = data.somar_cotacao_faixa_etaria[0].soma;

              

            $("#cliente").val(data.clientes.nome);
            $("#cidade").val(data.cidade.nome);
            //$("#status_contrato").val(data.financeiro.nome);

            $("#telefone").val(data.clientes.telefone);
            $("#email").val(data.clientes.email);
            $("#data").val(nascimento);

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
                        $('#cadastrarPessoaFisica').modal('hide');
                        form.find("#nome").val('');
                        form.find("#email").val('');
                        form.find("#telefone").val('');
                        form.find("#cidade_id").val('');
                        form.find("#origem_id").val('');
                    } else {

                    }
                }
            });
            return false;
        });

        $("form[name='cadastrar_pessoa_jurica']").on('submit',function(){
            $.ajax({
                url:"{{route('leads.prospeccao.store.pj')}}",
                method:"POST",
                data:$(this).serialize(),
                success:function(res) {
                    console.log(res);
                }
            });
            return false;
        });


        

        $("body").on('change','input[name="marcar_cliente"]',function(){
            let id = $(this).attr('data-id');
            $('input[name="marcar_cliente"]').not('[data-id='+id+']').prop('checked',false);
            $('.orcamento').attr('style','cursor:pointer').attr("href","/admin/cotacao/orcamento/"+id);
        });


       
    });
    </script>
@stop

@section('css')
    <style>
        th { font-size: 0.875em;}
        table.dataTable td {
            font-size: 0.875em;
        }
         .table-cell-edit{background-color: rgba(0,0,0,0.5);color:#FFF;cursor: pointer;}
    .alvo {cursor:pointer;}
     

    .coluna-right {
        overflow-y:scroll;flex-basis:45%;flex-wrap: wrap;background-color:rgba(0,0,0,0.5);border-radius:5px;height:720px;
    }

    .coluna-right::-webkit-scrollbar {width: 12px;}
    .coluna-right::-webkit-scrollbar-track {background: orange;}
    .coluna-right::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;} 

    textarea {resize: none;}   
    </style>
@stop