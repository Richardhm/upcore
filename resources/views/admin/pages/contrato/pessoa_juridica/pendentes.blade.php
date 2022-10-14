<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciamento Contratos</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
  
  <link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" />  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/toastr/toastr.min.css')}}">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body, html {background-image:url('/storage/fundo.png');}
    * {padding:0;margin:0;list-style: none;box-sizing: border-box;}
    .table-cell-edit{background-color: rgba(0,0,0,0.5);color:#FFF;cursor: pointer;}
    .alvo {cursor:pointer;}
    ::-webkit-scrollbar {width: 12px;}
    ::-webkit-scrollbar-track {background: orange;}
    ::-webkit-scrollbar-thumb {background-color: blue;border-radius: 20px;border: 3px solid orange;}  
    textarea {resize: none;}   
  </style>
</head>
<body>
    
    <section class="d-flex justify-content-between" style="flex-wrap: wrap;">

        <!--TOPO-->
        <div class="d-flex text-white align-items-center justify-content-between" style="flex-basis:100%;height:5vh">
            <span style="margin-left:8px;">GERENCIAMENTO CONTRATOS</span>
            <a href="{{route('admin.home')}}" class="text-white mr-2 border-bottom">Dashboard</a>
        </div>
        <!--Fim TOPO-->


        <!--COLUNA LEFT-->
        
        <!--FIM COLUNA LEFT-->

        <!--COLUNA CENTRO-->
        <div class="text-white p-2 align-self-start mx-auto" style="flex-basis:55%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
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
        <div class="mr-1 mx-auto py-1 px-3" style="flex-basis:40%;flex-wrap: wrap;background-color:rgba(0,0,0,0.5);border-radius:5px;">
            
            <div class="d-flex mb-2">

                <div style="flex-basis:32%;">
                    <span class="text-white">Data:</span>
                    <input type="text" name="data" id="data" class="form-control">
                </div>

                <div style="flex-basis:32%;margin:0 2%;">
                    <span class="text-white">Codigo Externo:</span>
                    <input type="text" name="codigo_externo" id="codigo_externo" class="form-control">
                </div>

                <div style="flex-basis:32%;">
                    <span class="text-white">Status Contrato:</span>
                    <input type="text" name="status_contrato" id="status_contrato" class="form-control">
                </div>    


            </div>

            <div class="d-flex mb-2">

                <div style="flex-basis:49%">
                    <span class="text-white">Administradora:</span>
                    <input type="text" name="administradora" id="administradora" class="form-control">
                </div>

                <div style="flex-basis:49%;margin:0 0 0 5%;">
                    <span class="text-white">CPF:</span>
                    <input type="text" name="cpf" id="cpf" class="form-control">
                </div>    


            </div>    

            <div class="d-flex mb-2">

                <div style="flex-basis:49%">
                    <span class="text-white">Data Nascimento:</span>
                    <input type="text" name="data_nascimento" id="data_nascimento" class="form-control">
                </div>

                <div style="flex-basis:49%;margin:0 0 0 5%;">
                    <span class="text-white">Email:</span>
                    <input type="text" name="email" id="email" class="form-control">
                </div>    


            </div>

            <div class="d-flex mb-2">

                <div style="flex-basis:49%">
                    <span class="text-white">Responsavel Financeiro:</span>
                    <input type="text" name="responsavel_financeiro" id="responsavel_financeiro" class="form-control">
                </div>

                <div style="flex-basis:49%;margin:0 0 0 5%;">
                    <span class="text-white">CPF Financeiro:</span>
                    <input type="text" name="cpf_financeiro" id="cpf_financeiro" class="form-control">
                </div>    


            </div>

            <div class="d-block mb-2">
                <span  class="text-white">Endereço:</span><br />
                <input type="text" name="endereco" id="endereco" class="form-control">
                
            </div>

            <div class="d-flex">
                <div class="d-flex align-items-center" style="flex-basis:35%;flex-wrap:wrap;">
                    <div>
                        <span class="text-white">Cidade:</span> 
                        <input type="text" name="cidade" id="cidade" class="form-control">
                    </div>
                </div>
                
                <div class="d-flex flex-column justify-content-end" style="flex-basis:65%;">
                    <div class="d-flex justify-content-end">
                        <span class="d-flex align-items-center justify-content-end" style="flex-basis:25%;color:#FFF;">Data Vigencia:</span>
                        <input type="text" name="data_vigencia" id="data_vigencia" class="form-control" style="flex-basis:70%;">
                    </div>
                    <div class="d-flex justify-content-end my-3">
                        <span class="d-flex align-items-center justify-content-end" style="flex-basis:25%;color:#FFF;">Data Boleto:</span>
                        <input type="text" name="data_boleto" id="data_boleto" class="form-control" style="flex-basis:70%;">
                    </div>
                    <div class="d-flex justify-content-end">
                        <span class="d-flex align-items-center justify-content-end" style="flex-basis:25%;color:#FFF;">Valor Adesão:</span>
                        <input type="text" name="valor_adesao" id="valor_adesao" class="form-control" style="flex-basis:70%;">
                    </div>
                </div>
            </div>


            <div class="d-flex mt-3 mb-2">
                <div style="flex-basis:32%;">
                    <span class="text-white">Faixas Etarias</span>
                    <input type="text" name="faixas_etarias" id="faixas_etarias" class="form-control">
                </div>

                <div style="flex-basis:32%;margin:0 2%;">
                    <span class="text-white">Plano Com Coparticipação</span>
                    <input type="text" name="plano_com_coparticipacao" id="plano_com_coparticipacao" class="form-control">
                </div>

                <div style="flex-basis:32%;">
                    <span class="text-white">Plano Com Odonto</span>
                    <input type="text" name="plano_com_odonto" id="plano_com_odonto" class="form-control">
                </div>
            </div>

            <div class="d-flex">

                <div style="flex-basis:49%">    
                    <span class="text-white">Tipo Plano</span>
                    <input type="text" name="tipo_plano" id="tipo_plano" class="form-control">
                </div>

                <div style="flex-basis:49%;margin:0 0 0 5%;">
                    <span class="text-white">Valor Contrato</span>
                    <input type="text" name="valor_contrato" id="valor_contrato" class="form-control">
                </div>
                
            </div>    


            <div class="d-flex border-top mt-3">
                <h2>Comissões/Premiações</h2>

            </div>





        </div>
        <!--FIM Coluna RIGHT-->
</section>

<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->

<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('vendor/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>

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
            let criacao = data.created_at.split("T")[0].split("-").reverse().join("/");
            let nascimento = data.clientes.data_nascimento.split("T")[0].split("-").reverse().join("/");
            let data_vigencia = data.clientes.data_vigente.split("T")[0].split("-").reverse().join("/");
            let data_boleto = data.clientes.data_boleto.split("T")[0].split("-").reverse().join("/");
            let coparticipacao = data.coparticipacao == 1 ? "sim" : "nao";
            let odonto = data.odonto == 1 ? "sim" : "nao";
            let valor_contrato = Number(data.valor).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            let valor_adesao = Number(data.clientes.valor_adesao).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

            console.log(data);

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

            // let quantidade_vidas = 0;
            // if(data.cotacao && !!data.cotacao) {
            //     //quantidade_vidas = data.cotacao.somarCotacaoFaixaEtaria.soma;
            //     quantidade_vidas = data.cotacao.somar_cotacao_faixa_etaria[0].soma;
            // }
            
            // let data_criacao = data.created_at.split("T")[0].split("-").reverse().join("/");
            // let ultimo_contato = data.ultimo_contato.split("-").reverse().join("/");
            // let criacao = new Date(data.created_at.split("T")[0]);
            
            // const now = new Date(Date.now());
            // const hoje = new Date(now.toISOString().split("T")[0]);
            // const diferenca   = new Date(hoje) - new Date(criacao)
            // const diferencaEmDias = diferenca / (1000 * 60 * 60 * 24);
            
            // $("input[name='nome']").val(data.nome);
            // $("input[name='email']").val(data.email);
            // $("input[name='cidade']").val(data.cidade.nome);
            // $("input[name='telefone']").val(data.telefone);
            // $("input[name='data_cadastro']").val(data_criacao);
            // $("input[name='ultimo_contato']").val(ultimo_contato);
            // $("input[name='status']").val(data.etiqueta.nome);
            // //$("textarea[name='descricao']").val();
            // $("input[name='dias_cadastro']").val(diferencaEmDias);
            // $("input[name='quantidade_vidas']").val(quantidade_vidas);
            // //console.log(row[1]);   //EmployeeId
            // $("textarea[name='descricao_tarefa']").val(data.tarefas[0].descricao);
            // $("#cliente_id_cadastrado_aqui").val(data.id)
            
            // $("a[data-orcamento]").attr("href","/admin/cotacao/orcamento/"+data.id);
            // $("a[data-contrato]").attr("href","/admin/cotacao/contrato/"+data.id);
            
            // historicoCliente(data.id);

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
</body>
</html>