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
            <span style="margin-left:8px;">GERENCIAMENTO DE LEADS</span>
            <a href="{{route('admin.home')}}" class="text-white mr-2 border-bottom">Dashboard</a>
        </div>
        <!--Fim TOPO-->


        <!--COLUNA LEFT-->
        <div class="d-flex flex-column text-white ml-1" style="flex-basis:15%;height:95vh;">

            <div class="py-1" style="background-color:rgba(0,0,0,0.5);border-radius:5px;">
                    <ul class="d-flex flex-column" style="margin-bottom:0px;">
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 atrasada">
                            <span class="ml-2" style="font-weight: bold;">Atrasadas</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtdAtrasado}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 hoje">
                            <span class="ml-2" style="font-weight: bold;">Hoje</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtdHoje}}</span>
                        </a>    
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 semana">
                            <span class="ml-2" style="font-weight: bold;">Semana</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtdSemana}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 mes">
                            <span class="ml-2" style="font-weight: bold;">Mês</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtdMes}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-flex justify-content-between text-white py-1 todos">
                            <span class="ml-2" style="font-weight: bold;">Total Leads</span>
                            <span class="mr-2" style="font-weight: bold;">{{$qtdTotal}}</span>
                        </a>
                    </li>
                </ul>
            </div>

            


        </div>
        <!--FIM COLUNA LEFT-->

        <!--COLUNA CENTRO-->
        <div class="text-white p-2 align-self-start" style="flex-basis:64%;background-color:rgba(0,0,0,0.5);border-radius:5px;">
            <div id="table" class="py-3">
                <table id="tabela" class="table listarclientes">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Data</th>
                            <th>Origem</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>   
            </div> 
        </div>  
        <!--FIM COLUNA CENTRO-->
        
        <!--COLUNA RIGHT-->
        <div class="mr-1" style="flex-basis:20%;flex-wrap: wrap;background-color:rgba(0,0,0,0.5);border-radius:5px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="mx-auto text-center mt-4 mb-3 border border-white w-50 text-white orcamento">Orçamento</a>           
                <a href="" class="mx-auto text-center my-3 border border-white w-50 text-white" style="background-color:rgba(0,0,0,0.4);">Ligar</a>           
                <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="mx-auto text-center my-3 border border-white w-50 text-white whatsapp" style="background-color:rgba(0,0,0,0.4);">Whatsapp</a>           
                <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="mx-auto text-center my-3 border border-white w-50 text-white email" style="background-color:rgba(0,0,0,0.4);">Email</a>           
                <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="mx-auto text-center my-3 border border-white w-50 text-white" style="background-color:rgba(0,0,0,0.4);">SMS</a>           
                <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="mx-auto text-center my-3 border border-white w-50 text-white" style="background-color:rgba(0,0,0,0.4);">Transferir</a>           
                <a href="" style="pointer-events: none; display: inline-block;background-color:rgba(0,0,0,0.4);" class="mx-auto text-center my-3 border border-white w-50 text-white exportar" style="background-color:rgba(0,0,0,0.4);">Exportar</a>           
                <a href="" data-toggle="modal" data-target="#cadastrarPessoaFisica" class="mx-auto text-center my-3 border border-white w-50 text-white" style="background-color:rgba(0,0,0,0.4);">Cadastrar PF</a>           
                <a href="" data-toggle="modal" data-target="#cadastrarPessoaJuridica" class="mx-auto text-center my-3 border border-white w-50 text-white" style="background-color:rgba(0,0,0,0.4);">Cadastrar PJ</a>           
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
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                "url":"{{ route('leads.prospeccao.ler') }}",
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
                {data:"id",name:"check"},
                {data:"created_at",name:"data"},
                {data:"origem.nome",name:"origem"},
                {data:"nome",name:"nome"},
                {data:"telefone",name:"telefone"},
                {data:"email",name:"email"},
            ],
            "columnDefs": [ {
                    "targets": 0,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        
                        $(td).html('<input type="checkbox" name="marcar_cliente" class="marcar_cliente" data-id="'+cellData+'" />');
                    }},
                    {
                    "targets": 1,
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

        $(".hoje").on('click',function(){
            ta.ajax.url("{{ route('cliente.getClientesParaHojeProspeccao') }}").load();
            return false;
        });

        $(".atrasada").on('click',function(){
            ta.ajax.url("{{ route('cliente.getClienteAtrasadasAjaxProspeccao') }}").load();
            return false;
        });

        $(".semana").on('click',function(){
            ta.ajax.url("{{ route('cliente.listarClientesSemanaAjaxProspeccao') }}").load();
            return false;
        });

        $(".mes").on('click',function(){
            ta.ajax.url("{{ route('cliente.listarClienteMesAjaxProspeccao') }}").load();
            return false;
        });

        $(".todos").on('click',function(){
            ta.ajax.url("{{ route('leads.prospeccao.ler') }}").load();
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
        

        $("body").on('change','input[name="marcar_cliente"]',function(){
           
            let marcados = $('input[type=checkbox]:checked').length;
            if(marcados == 1) {
                let id = $('input[type=checkbox]:checked').attr('data-id');
                let data = $('input[type=checkbox]:checked');
                let telefone = data.closest('tr').find("td:eq(4)").text().replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","");
                
                let email = data.closest('tr').find("td:eq(5)").text();
                $(".orcamento").attr('style','cursor:pointer').attr("href","/admin/cotacao/orcamento/"+id);
                $(".whatsapp").attr('style','cursor:pointer').attr("href","https://api.whatsapp.com/send?phone=55"+telefone).attr('target',"_blank");
                $(".email").attr('style','cursor:pointer').attr("href","mailto:"+email);
                //$(".orcamento").attr('style','cursor:pointer').attr("href","http://google.com.br");
            } else {
                $(".orcamento").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".whatsapp").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
                $(".email").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);').attr("href","#");
            }            

            if(marcados >= 1) {
                $(".exportar").attr('style','cursor:pointer');
            } else {
                $(".exportar").attr('style','cursor:default;background-color:rgba(0,0,0,0.4);');    
            }


            


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
                        //console.log(res)
                        //window.open(res, '_blank');
                        }
                    }    
                });
                return false;
            });


       
    });
</script>
</body>
</html>