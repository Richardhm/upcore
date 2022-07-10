@extends('adminlte::page')
@section('title', 'Orçamento')
@section('content_header')
    <h3>Realizar Orçamento</h3>
@stop
@section('content')

<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <h5>Orçamento</h5>
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse" collapsing="100000"  aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        
      <form action="" method="post" class="px-3">
                @csrf 
                @if($cliente->pessoa_juridica) 
                    <input type="hidden" name="cpnj_selecionado" id="cnpj_selecionado" value="{{$cliente->cnpj}}">
                    <input type="hidden" name="nome_empresa_selecionado" id="nome_empresa_selecionado" value="{{$cliente->nome_empresa}}">
                @endif
                
                <h4 style="color:brown;"> - Dados</h4>
                <hr />    
                <div class="form-group">
                    <label for="">Pessoa Fisica/Pessoa Juridica</label>
                    <select name="modelo" id="modelo" class="form-control">
                        <option value="">-- Escolher PF/PJ --</option>
                        <option value="pf" {{$cliente->pessoa_fisica == 1 ? 'selected' : ''}}>Pessoa Fisica</option> 
                        <option value="pj" {{$cliente->pessoa_juridica == 1 ? 'selected' : ''}}>Pessoa Juridica</option> 
                    </select> 
                    <div class="errormodelo"></div>
                </div>
                
                <div class="form-row mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" value="{{$cliente->nome}}">
                            <div class="errornome"></div>
                            
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="cidade">Cidade:</label>
                            <select name="cidades" id="cidades" class="form-control">
                                <option value="">--Escolher a cidade--</option>
                                @foreach($cidades as $c)
                                    <option value="{{$c->id}}" {{$c->id == $cliente->cidade_id ? 'selected' : ''}}>{{$c->nome}}</option>
                                @endforeach
                            </select>
                            <div class="errorcidade"></div>    
                        </div>
                    </div>    

                    <div class="col-4">
                        <div class="form-group">
                            <label for="celular">Celular:</label>
                            <input type="text" name="celular" id="celular" class="form-control" placeholder="(DD) X XXXXX-XXXX" value="{{$cliente->telefone}}">
                            <div class="errortelefone"></div>
                            <div class="errortelefoneinvalido"></div>
                        </div>
                    </div>    
                </div>
                
                
                
                <div class="form-group empresa_dados"></div>
                
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{$cliente->email}}">
                    <div class="erroremail"></div>
                    <div class="erroremailinvalido"></div>
                </div>    

                <h4 style="color:brown;"> - Faixas Etarias</h4>
                <hr />  

                <div class="errorfaixa"></div> 

                <section>
                    

                    <div class="form-row mb-4">

                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">0-18</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[1]" id="faixa-0-18" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      


                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">19-23</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[2]" id="faixa-19-23" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">24-28</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[3]" id="faixa-24-28" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">29-33</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[4]" id="faixa-29-33" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">34-38</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[5]" id="faixa-34-38" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div> 
                        
                    </div>    
                
                    <div class="form-row mb-4">    

                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">39-43</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[6]" id="faixa-39-43" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      


                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">44-48</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[7]" id="faixa-44-48" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">49-53</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[8]" id="faixa-49-53" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div class="col-6 col-sm-4 col-md-2">
                            <span for="">54-58</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[9]" id="faixa-54-58" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div class="col-6 col-sm-4 col-md-2">
                            <span for="">59+</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" name="faixas_etarias[10]" id="faixa-59" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>   
                    
                        

                    </div>   
            </section> 
             <hr />
              
                <input type="submit" class="btn btn-block btn-primary my-3" value="Ver Planos" name="verPlanos" />
            </form>
      </div>
    </div>
  </div>

    

  <div id="aquiPlano"></div>


  
</div>
@stop   
@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    
    <script>
        $(function(){
            $('#celular').mask('(00) 0 0000-0000');       
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            let plus = $(".plus");
            let minus = $(".minus");
            $(plus).on('click',function(e){
                let alvo = e.target;
                let pai = alvo.closest('.content');
                let input = $(pai).find('input');
                
                if(input.val() == "") {
                    input.val(0);
                }
                
                let newValue = parseInt(input.val()) + 1;
                if(newValue >= 0) {
                    input.val(newValue);
                }
                
            });

            $(minus).on('click',function(e){
                let alvo = e.target;
                let pai = alvo.closest('.content');
                let input = $(pai).find('input');
                let newValue = parseInt(input.val()) - 1;
                
                if(newValue >= 0) {
                    input.val(newValue);
                }
            });

            
            if($('select[name="modelo"] option:selected').val() == "pj") {
                $('.empresa_dados').html(
                        "<div class='form-row my-3'>"+
                            "<div class='col'>"+
                                "<label for='cnpj'>CNPJ:</label>"+
                                "<input type='text' name='cnpj' id='cnpj' class='form-control' placeholder='XX.XXX.XXX/XXXX-XX' />"+
                            "</div>"+
                            "<div class='col'>"+
                                "<label for='nome_empresa'>Nome Empresa:</label>"+
                                "<input type='text' name='nome_empresa' id='nome_empresa' class='form-control' placeholder='Nome Empresa' />"+
                            "</div>"+
                        "</div>"
                    );
                    $('#cnpj').mask('00.000.000/0000-00');
                    $('#cnpj').val($('input[name="cpnj_selecionado"]').val());
                    $('#nome_empresa').val($('input[name="nome_empresa_selecionado"]').val());
            } 
           

            $('body').on('click','input[name="verPlanos"]',function(e){
                e.preventDefault();
                
                let cidade = $('select[name="cidades"]').val();
           
                let nome = $('input[name="nome"]').val();
                let telefone = $('input[name="celular"]').val();
                
                let email = $('input[name="email"]').val();
                let cnpj = $('input[name="cnpj"]').val();
                let nome_empresa = $('input[name="nome_empresa"]').val();
                let validar = /^\([1-9]{2}\) [0-9]{1} [0-9]{4}-[0-9]{4}$/;
                let validarEmail = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})$/
                let modelo = $('select[name="modelo"] option:selected').val();

                $.ajax({
                    url:"{{route('orcamento.planos')}}",
                    method:"POST",
                    data:{
                        "cidade" : cidade,
                        "nome" : nome,
                        "telefone" : telefone,
                        "modelo":modelo,
                        "email":email,
                        "cnpj":cnpj,
                        "nome_empresa":nome_empresa,
                        "faixas" : [{
                            '1' : $('#faixa-0-18').val(),
                            '2' : $('#faixa-19-23').val(),
                            '3' : $('#faixa-24-28').val(),
                            '4' : $('#faixa-29-33').val(),
                            '5' : $('#faixa-34-38').val(),
                            '6' : $('#faixa-39-43').val(),
                            '7' : $('#faixa-44-48').val(),
                            '8' : $('#faixa-49-53').val(),
                            '9' : $('#faixa-54-58').val(),
                            '10' : $('#faixa-59').val()
                        }]
                    },
                    beforeSend:function() {
                        if(nome == "") {
                            $(".errornome").html("<p class='alert alert-danger'>O campo nome e campo obrigatorio</p>");
                            $('#collapseOne').collapse('show');
                        }
                        if(cidade == "") {
                            $(".errorcidade").html("<p class='alert alert-danger'>O campo cidade e campo obrigatorio</p>");
                            $('#collapseOne').collapse('show');
                        }
                        if(telefone == "") {
                            $(".errortelefone").html("<p class='alert alert-danger'>O campo telefone e campo obrigatorio</p>");
                            $('#collapseOne').collapse('show');
                        }
                        if(!validar.exec(telefone)) {
                            $(".errortelefoneinvalido").html("<p class='alert alert-danger'>Número Inválido</p>");
                            $('#collapseOne').collapse('show');
                        }
                        if(email == "") {
                            $(".erroremail").html("<p class='alert alert-danger'>O campo email e campo obrigatorio</p>");
                            $('#collapseOne').collapse('show');
                        }
                        if(!validarEmail.exec(email)) {
                            $(".erroremailinvalido").html("<p class='alert alert-danger'>Email Inválido</p>");
                            $('#collapseOne').collapse('show');
                        }
                        
                        if($("#faixa-0-18").val() == "" && $('#faixa-19-23').val() == "" && $('#faixa-24-28').val() == "" &&  $('#faixa-29-33').val() == "" && $('#faixa-34-38').val() == "" && $('#faixa-39-43').val() == "" && $('#faixa-44-48').val() == "" && $('#faixa-49-53').val() == "" && $('#faixa-54-58').val() == "" && $('#faixa-59').val() == "") {
                            $(".errorfaixa").html("<p class='alert alert-danger'>Alguma faixa etaria deve ter preenchida</p>");
                            $('#collapseOne').collapse('show');
                        }
                        
                        
                    },
                    success(res) {
                        
                        if(res == "error") {
                            $('#collapseOne').collapse('show');
                        } else {
                            $('.errornome').html('');
                            $('.errortelefone').html('');
                            $(".errortelefoneinvalido").html('');
                            $('.erroremail').html('');
                            $('.errorcidade').html('');
                            $(".erroremailinvalido").html('');
                            $('.errorcoparticipacao').html('');
                            $('.errorodonto').html('');
                            $('.errorfaixa').html('');
                            $(".errorpessoa").html('');
                            $('#collapseOne').collapse('hide');
                            $('#aquiPlano').html(res)
                        }
                    }
                });
                return false;
            });
            $('#collapseOne').on('hidden.bs.collapse', function () {
                $("#collapseTwo").collapse('show');
                
            });


            $("#collapseOne").collapse({toggle: true});



        });

    </script>
@stop
@section('css')
<style>
        div p {
            margin-bottom:0px !important;
        }
		* {
			margin:0;
			padding:0;
			box-sizing:border-box;
		}       
        .container_planos_section {
            display:flex;
            flex-wrap:wrap;
            justify-content: space-between;
        }
        .planos {
            margin-bottom:15px;
            border:2px solid black;
            border-radius: 10px;
            display:flex;
            
            flex-wrap:wrap;
            flex-basis: 49%;
            box-shadow: 5px 5px 5px 5px black;
        }
        .logo {
            display:flex;
            flex-basis:100%;
            justify-content: center;
            /* margin:10px 0; */
            
        }

        .coparticipacao_odonto {
            display:flex;
            margin:0 auto;
            flex-basis:90%;
            font-size:1em;
            margin-right:10px;
            align-items: center;
            justify-content: center;
        }

        .coparticipacao_odonto p {
            font-weight:bold;
            font-size:1.1em;
            text-decoration: underline;
        }

        .faixas_etarias_container {
            margin-left:8px;
        }

        .faixas_etarias_title {
            background-color:rgb(49,134,155);
            padding:16px 0;
            color:#FFF;
            border-right: 1px solid black;
        }

        .faixas_etarias_nome {
            border:1px solid black;
            padding:5px;
            box-sizing:border-box;
        }

        .faixas_total_plano {
            background-color:rgb(49,134,155);
            color:#FFF;
            padding:10px 5px;
            border-right:1px solid black;
        }


        div.apartamento,
        div.enfermaria,
        div.ambulatorial {
            display: flex;
            flex-direction: column;
            flex-basis: 25%;
        }

        
       div.apartamento .plano_container_header,div.enfermaria .plano_container_header {
        border-right:1px solid black;
       } 

       .plano_container_header_acomodacao {
            display: block;
            text-align: center;
            color:#FFF;
       }


        .plano_container_header {
            background-color:rgb(49,134,155);
            padding:5px;

        }


        .plano_total {
            border:1px solid black;
            padding:5px;
            box-sizing:border-box;
            
            text-align: center;

        }

        .total_somado {
            background-color:rgb(49,134,155);
            font-weight: bold;
            
            text-align: center;
            color:#FFF;
            padding:10px 5px;

        }

        div.apartamento .total_somado,div.enfermaria .total_somado {
            border-right:1px solid black;
        }

        .plano_container_header_title {
            font-size: 0.9em;
            text-align: center;
            display: block;
            color:#FFF;
        }

        .planos:hover {
            box-shadow: inset 0 0 1em black, 0 0 1em #808080;
            cursor:pointer;
            
        }
        .imagem-operadora a {
            margin-left:10px;
        }

        .imagem-operadora a:hover img {
            box-shadow: 5px 5px 5px 5px black;
            padding:10px;
        }


    </style>        
@stop
