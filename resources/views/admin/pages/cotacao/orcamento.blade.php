@extends('adminlte::page')
@section('title', 'Orçamento')
@section('plugins.Toastr', true)
@section('content_header')
    <h3 class="text-white">Orçamento</h3>
@stop
@section('content')

@if(Session::has('message'))
    <div class="alert alert-success text-center">
        Email Enviado com sucesso
    </div>
@endif



<div class="modal" tabindex="-1" id="teste-download">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Operações</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Deseja Realizar outra operação?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Sim</button>
        <a type="button" class="btn btn-primary redirecionar" href="">Não</a>
      </div>
    </div>
  </div>
</div>





    <section>

        <!------------------------------CARD FORMULARIO ---------------------------------------------->    

        <div class="card shadow" style="background-color:rgba(0,0,0,0.5);color:#FFF;">

            

            <div class="card-body" style="box-shadow:rgba(0,0,0,0.8) 0.6em 0.7em 5px;">

            <form action="" method="post" class="px-3">
                @csrf 
                
            <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}">
            <input type="hidden" name="tipo" id="tipo" value="{{$tipo}}">
            
           
                <!-- <div class="form-group">
                    <label for="">Pessoa Fisica/Pessoa Juridica</label>
                    <select name="modelo" id="modelo" class="form-control">
                        <option value="">-- Escolher PF/PJ --</option>
                        <option value="pf" {{$cliente->pessoa_fisica == 1 ? 'selected' : ''}}>Pessoa Fisica</option> 
                        <option value="pj" {{$cliente->pessoa_juridica == 1 ? 'selected' : ''}}>Pessoa Juridica</option> 
                    </select> 
                    <div class="errormodelo"></div>
                </div>
                 -->
                <div class="form-row mt-3">
                    <div class="col-3">
                        <div class="form-group">
                            <p>Nome:</p>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" value="{{$cliente->nome}}">
                            <div class="errornome"></div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <p>Cidade:</p>
                            <select name="cidades" id="cidades" class="form-control">
                                <option value="">--Escolher a cidade--</option>
                                @foreach($cidades as $c)
                                    <option value="{{$c->id}}" {{$c->id == $cliente->cidade_id ? 'selected' : ''}}>{{$c->nome}}</option>
                                @endforeach
                            </select>
                            <div class="errorcidade"></div>    
                        </div>
                    </div>    

                    <div class="col-3">
                        <div class="form-group">
                            <p>Celular:</p>
                            <input type="text" name="celular" id="celular" class="form-control" placeholder="(DD) X XXXXX-XXXX" value="{{$cliente->telefone}}">
                            <div class="errortelefone"></div>
                            <div class="errortelefoneinvalido"></div>
                        </div>
                    </div> 
                    
                    <div class="col-3">
                        <div class="form-group">
                            <p>Email:</p>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{$cliente->email}}">
                            <div class="erroremail"></div>
                            <div class="erroremailinvalido"></div>
                        </div>    
                    </div>    




                </div>
                
                <section>
                    <p>Faixas Etarias</p>
                    <div class="errorfaixas"></div>
                    <!--COMEÇO Faixa Etaria-->
                    <div class="d-flex">

                        <div  style="flex-basis:10%;">
                            <span for="">0-18</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="d-flex justify-content-center minus" id="faixa-0-18" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_0_18" name="faixas_etarias[1]" value="{{isset($colunas) && in_array(1,$colunas) ? $faixas[array_search(1, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-0-18" class="text-center font-weight-bold flex-fill faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="d-flex justify-content-center plus" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      


                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">19-23</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="d-flex justify-content-center minus" id="faixa-19-23" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_19_23" name="faixas_etarias[2]" value="{{isset($colunas) && in_array(2,$colunas) ? $faixas[array_search(2, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-19-23" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="d-flex justify-content-center plus" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;">
                            <span for="">24-28</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="d-flex justify-content-center minus" id="faixa-24-28" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_24_28" name="faixas_etarias[3]" value="{{isset($colunas) && in_array(3,$colunas) ? $faixas[array_search(3, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-24-28" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">29-33</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-29-33" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_29_33" name="faixas_etarias[4]" value="{{isset($colunas) && in_array(4,$colunas) ? $faixas[array_search(4, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-29-33" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="plus  d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;">
                            <span for="">34-38</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-34-38" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[5]" data-change="change_faixa_34_38" value="{{isset($colunas) && in_array(5,$colunas) ? $faixas[array_search(5, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-34-38" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div> 
                        
                        
                
                    

                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">39-43</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-39-43" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[6]" data-change="change_faixa_39_43" value="{{isset($colunas) && in_array(6,$colunas) ? $faixas[array_search(6, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-39-43" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      


                        <div  style="flex-basis:10%;">
                            <span for="">44-48</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-44-48" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[7]" data-change="change_faixa_44_48" value="{{isset($colunas) && in_array(7,$colunas) ? $faixas[array_search(7, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-44-48" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">49-53</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-49-53" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[8]" data-change="change_faixa_49_53" value="{{isset($colunas) && in_array(8,$colunas) ? $faixas[array_search(8, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-49-53" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div style="flex-basis:10%;margin:0 10px 0 0;">
                            <span for="">54-58</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-54-58" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[9]" data-change="change_faixa_54_58" value="{{isset($colunas) && in_array(9,$colunas) ? $faixas[array_search(9, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-54-58"  class="text-center font-weight-bold faixas_etarias d-flex" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div style="flex-basis:10%;">
                            <span for="">59+</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">

                                    <button type="button" class="minus d-flex justify-content-center"  id="faixa-59" style="border:none;background:#FF0000;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    
                                    <input type="tel" data-change="change_faixa_59" name="faixas_etarias[10]" value="{{isset($colunas) && in_array(10,$colunas) ? $faixas[array_search(10, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-59" class="text-center font-weight-bold faixas_etarias d-flex" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:#00FF00;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <!--Fim Faixa Etaria-->                      
                </section>              
             <hr />
                <input type="submit" class="btn btn-block btn-light my-3" value="Ver Planos" name="verPlanos" />
            </form>
            </div>

        </div>
        <!------------------------------FIM CARD FORMULARIO ------------------------------------------>    

        @if(Session::has('download-completo'))
            
        @endif



        <!------------------------------CARD PLANOS-------------------------------------------------->
        <!-- <div class="container-fluid"> -->
            
        <!-- </div> -->


        <!------------------------------FIM CARD PLANOS-------------------------------------------------->

    </section>


    <div id="aquiPlano"></div>

@stop   
@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    
    <script>
        $(function(){
            $('body').on('click','.pdf',function(){
                let cliente_id = $('#cliente_id').val();
                let tipo = $("#tipo").val();
                if(tipo == 'pf') {
                    $(".redirecionar").attr('href','/admin/clientes/pf?id='+cliente_id);     
                } else {
                    $(".redirecionar").attr('href','/admin/clientes/pj?id='+cliente_id);
                }
                setTimeout(function(){
                    $('#teste-download').modal('show');
                },3000);
            });
           
            $("body").on('click','.cards',function(){
                $('.cards').css({"box-shadow":"none"});
                $(this).css({"box-shadow":"10px 5px 5px orange"});
                
                let administradora_id = $(this).find('input[name="administradora_id"]').val();
                let odonto = $(this).find('input[name="odonto"]').val();
                let plano_id = $(this).find('input[name="plano_id"]').val();
                let cotacao = $("#cotacao_id").val();
                let cliente = $("#cliente_id").val();
                let telefone = $("#celular").val().replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","");
                var alvo = $(document).height() - $(window).height() - $(window).scrollTop();
                let email = $('input[name="email"]').val();
                let cidade = $('select[name="cidades"]').val();



                // $('body,html').animate({
                //     scrollTop:"3000px"
                // },1500);
                
                // $(".alvos").html("");
                // $(".alvos").remove();
                // // $("#aquiPlano").after('<div class="alvos" style="display:flex;flex-basis:100%;justify-content:center;align-items:center;padding:10px 0;background-color:red;"><a style="color:black;margin-right:10px;" href="https://api.whatsapp.com/send?phone=55"><i class="fab fa-whatsapp fa-2x"></i></a><a style="color:black;margin-right:10px;"><i class="fas fa-envelope fa-2x"></i></a><a style="color:black;margin-right:10px;" data-orcamento="" data-cidade="" data-plano="" data-coparticipacao="" data-odonto="" data-operadora="" data-administradora="" href="#"><i class="fas fa-file-pdf fa-2x"></i></a><a style="color:black;margin-right:10px;" href=""><i class="fas fa-file-contract fa-2x"></i></a></div>');
                // $("#aquiPlano").append('<div class="d-flex justify-content-center" style="padding:10px 0;"><a style="margin-right:15px;background-color:#34af23;color:#FFF;" class="border p-1 border-dark rounded" href="https://api.whatsapp.com/send?phone=55'+telefone+'"><i class="fab fa-whatsapp fa-2x"></i></a><a style="margin-right:15px;background-color:rgb(17,117,185);color:#FFF;" class="border p-1 border-dark rounded" href="/admin/email/'+cotacao+'/'+administradora_id+'/'+plano_id+'/'+odonto+'/'+cliente+'/'+cidade+'"><i class="fas fa-envelope fa-2x"></i></a><a style="margin-right:15px;color:#FFF;" class="border p-1 border-dark rounded enviar_mensagem bg-danger" href="/admin/criar/pdf/'+cotacao+'/'+administradora_id+'/'+plano_id+'/'+odonto+'/'+cliente+'/'+cidade+'"><i class="fas fa-file-pdf fa-2x"></i></a></div>');    
                // $(".icones-link").html('<div class="d-flex justify-content-end" style="padding:10px 0;"><a style="margin-right:15px;background-color:#34af23;color:#FFF;" class="border p-1 border-dark rounded" href="https://api.whatsapp.com/send?phone=55'+telefone+'"><i class="fab fa-whatsapp fa-2x"></i></a><a style="margin-right:15px;background-color:rgb(17,117,185);color:#FFF;" class="border p-1 border-dark rounded" href="/admin/email/'+cotacao+'/'+administradora_id+'/'+plano_id+'/'+odonto+'/'+cliente+'/'+cidade+'"><i class="fas fa-envelope fa-2x"></i></a><a style="margin-right:15px;color:#FFF;" class="border p-1 border-dark rounded enviar_mensagem bg-danger" href="/admin/criar/pdf/'+cotacao+'/'+administradora_id+'/'+plano_id+'/'+odonto+'/'+cliente+'/'+cidade+'"><i class="fas fa-file-pdf fa-2x"></i></a></div>');    
            });
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
                let cliente = $('input[name="cliente_id"]').val();
                let cnpj = $('input[name="cnpj"]').val();
                let nome_empresa = $('input[name="nome_empresa"]').val();
                let validar = /^\([1-9]{2}\) [0-9]{1} [0-9]{4}-[0-9]{4}$/;
                let validarEmail = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})$/
                let modelo = "pf";
                $.ajax({
                    url:"{{route('cotacao.montarPlanos')}}",
                    method:"POST",
                    data:{
                        "cidade" : cidade,
                        "nome" : nome,
                        "telefone" : telefone,
                        "modelo":modelo,
                        "email":email,
                        "cnpj":cnpj,
                        "cliente_id":cliente,
                        "nome_empresa":nome_empresa,
                        "faixas" : [{
                            '1' : $('#faixa-input-0-18').val(),
                            '2' : $('#faixa-input-19-23').val(),
                            '3' : $('#faixa-input-24-28').val(),
                            '4' : $('#faixa-input-29-33').val(),
                            '5' : $('#faixa-input-34-38').val(),
                            '6' : $('#faixa-input-39-43').val(),
                            '7' : $('#faixa-input-44-48').val(),
                            '8' : $('#faixa-input-49-53').val(),
                            '9' : $('#faixa-input-54-58').val(),
                            '10' : $('#faixa-input-59').val()
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

            $("body").on('click','.card_plano:not(".cards_destaque_links")',function(){
                $(".cards_destaque_links").remove();
                let administradora_id = $(this).find('input[name="administradora_id"]').val();
                let odonto = $(this).find('input[name="odonto"]').val();
                let plano_id = $(this).find('input[name="plano_id"]').val();
                let cotacao = $("#cotacao_id").val();
                let cliente = $("#cliente_id").val();
                let telefone = $("#celular").val().replace(" ","").replace("(","").replace(")","").replace("  ","").replace(" ","").replace("-","");
                //var alvo = $(document).height() - $(window).height() - $(window).scrollTop();
                let email = $('input[name="email"]').val();
                let cidade = $('select[name="cidades"]').val();

                var element = $('<div></div>');
                element.html('<a style="margin-right:15px;background-color:rgb(17,117,185);color:#FFF;" class="border p-1 border-dark rounded" href="/admin/email/'+cotacao+'/'+administradora_id+'/'+plano_id+'/'+odonto+'/'+cliente+'/'+cidade+'"><i class="fas fa-envelope fa-2x"></i></a><a style="margin-right:15px;color:#FFF;" class="border p-1 border-dark rounded enviar_mensagem bg-danger pdf" href="/admin/criar/pdf/'+cotacao+'/'+administradora_id+'/'+plano_id+'/'+odonto+'/'+cliente+'/'+cidade+'"><i class="fas fa-file-pdf fa-2x"></i></a>');
                element.addClass("cards_destaque_links")
                element.hide();


                $(this).find('table').after(element);
                element.fadeIn();


            });


        });

    </script>
@stop
@section('css')
<style>
        .cards_destaque_links {background-color:rgba(0,0,0,0.5);text-align:center;display:flex;align-items: center;justify-content: center;min-height:50px;}
        .cards {cursor: pointer;}
        div p {margin-bottom:0px !important;}
		* {margin:0;padding:0;box-sizing:border-box;}       
        .container_planos_section {display:flex;flex-wrap:wrap;justify-content: space-between;}
        .planos {margin-bottom:15px;border:2px solid black;border-radius: 10px;display:flex;flex-wrap:wrap;flex-basis: 49%;box-shadow: 5px 5px 5px 5px black;}
        .logo {display:flex;flex-basis:100%;justify-content: center;}
        .coparticipacao_odonto {display:flex;margin:0 auto;flex-basis:90%;font-size:1em;margin-right:10px;align-items: center;justify-content: center;}
        .coparticipacao_odonto p {font-weight:bold;font-size:1.1em;text-decoration: underline;}
        .faixas_etarias_container {margin-left:8px;}
        .faixas_etarias_title {background-color:rgb(49,134,155);padding:16px 0;color:#FFF;border-right: 1px solid black;}
        .faixas_etarias_nome {border:1px solid black;padding:5px;box-sizing:border-box;}
        .faixas_total_plano {background-color:rgb(49,134,155);color:#FFF;padding:10px 5px;border-right:1px solid black;}
        div.apartamento,div.enfermaria,div.ambulatorial {display: flex;flex-direction: column;flex-basis: 25%;}
        div.apartamento .plano_container_header,div.enfermaria .plano_container_header {border-right:1px solid black;} 
       .plano_container_header_acomodacao {display: block;text-align: center;color:#FFF;}
        .plano_container_header {background-color:rgb(49,134,155);padding:5px;}
        .plano_total {border:1px solid black;padding:5px;box-sizing:border-box;text-align: center;}
        .total_somado {background-color:rgb(49,134,155);font-weight: bold;text-align: center;color:#FFF;padding:10px 5px;}
        div.apartamento .total_somado,div.enfermaria .total_somado {border-right:1px solid black;}
        .plano_container_header_title {font-size: 0.9em;text-align: center;display: block;color:#FFF;}
        .planos:hover {box-shadow: inset 0 0 1em black, 0 0 1em #808080;cursor:pointer;}
        .imagem-operadora a {margin-left:10px;}
        .imagem-operadora a:hover img {box-shadow: 5px 5px 5px 5px black;padding:10px;}
        .card_plano {flex-basis:31.5%;margin:0 1.8% 2% 0;background-color:rgba(0,0,0,0.5);color:#FFF;}
        .card_plano:hover {cursor: pointer;}
        table {border: 1px solid #FFF;width: 100%;border-collapse: collapse;}
        td {padding: 3.5px;}



    </style>        
@stop

