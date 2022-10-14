@extends('adminlte::page')
@section('title', 'Contrato')
@section('plugins.jqueryUi', true)
@section('plugins.Toastr', true)
@section('content_header')
    <h3 class="text-white">Realizar Contratos</h3>
@stop
@section('content')

    <div class="card shadow" style="background-color:rgba(0,0,0,0.5);color:#FFF;">
        <div class="card-body" style="box-shadow:rgba(0,0,0,0.8) 0.6em 0.7em 5px;">
        <form action="{{route('contrato.store')}}" method="post" class="px-3" name="cadastrar_pessoa_fisca_formulario">
            @csrf              

            <input type="hidden" name="change_cidade" id="change_cidade" value="{{$cliente->cidade->nome ?? ''}}">
            <input type="hidden" name="change_operadora" id="change_operadora" value="">
            <input type="hidden" name="change_administradora" id="change_administradora" value="">
            <input type="hidden" name="change_coparticipacao" id="change_coparticipacao" value="">
            <input type="hidden" name="change_odonto" id="change_odonto" value="">
            <input type="hidden" name="change_plano" id="change_plano" value="">


            <input type="hidden" name="change_faixa_0_18" id="change_faixa_0_18" value="">
            <input type="hidden" name="change_faixa_19_23" id="change_faixa_19_23" value="">
            <input type="hidden" name="change_faixa_24_28" id="change_faixa_24_28" value="">
            <input type="hidden" name="change_faixa_29_33" id="change_faixa_29_33" value="">
            <input type="hidden" name="change_faixa_34_38" id="change_faixa_34_38" value="">
            <input type="hidden" name="change_faixa_39_43" id="change_faixa_39_43" value="">
            <input type="hidden" name="change_faixa_44_48" id="change_faixa_44_48" value="">
            <input type="hidden" name="change_faixa_49_53" id="change_faixa_49_53" value="">
            <input type="hidden" name="change_faixa_54_58" id="change_faixa_54_58" value="">
            <input type="hidden" name="change_faixa_59" id="change_faixa_59" value="">

            <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}">
                <div class="form-row mt-1">
                    <div class="col-2">
                        <div class="form-group">
                            <span for="nome">Titular:</span>
                            <input type="text" name="nome" id="nome" required class="form-control" placeholder="Nome" value="{{$cliente->nome}}">
                            <div class="errorcliente"></div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <span for="cpf">CPF:</span>
                            <input type="text" name="cpf" id="cpf" required class="form-control" value="{{old('cpf')}}" placeholder="XXX.XXXX.XXX-XX">
                            <div class="errorcpf"></div>
                            @if($errors->has('cpf'))
                                <p class="alert alert-danger">{{$errors->first('cpf')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <span for="data_nascimento">Data Nascimento:</span>
                            <input type="date" name="data_nascimento" value="{{old('data_nascimento')}}" required id="data_nascimento" class="form-control">
                            <div class="errordatanascimento"></div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <span for="email">Email:</span>
                            <input type="email" name="email" id="email" required placeholder="Email" class="form-control" value="{{$cliente->email}}">
                            <div class="erroremail"></div>
                        </div>
                    </div>    
                    <div class="col-3">
                        <div class="form-group">
                            <span style="font-size:0.947em;">Responsavel Financeiro: <small style='font-size:0.675em;color:#FFF;'>(Preencher se o cliente é menor de idade)</small></span>
                            <input type="text" name="responsavel_financeiro" id="responsavel_financeiro" placeholder="Responsavel Financeiro" class="form-control" value="">
                            <div class="errorresponsavelfinanceiro"></div>
                        </div>
                    </div>
                </div>    
                
                <div class="d-flex">
                        

                    <div class="flex-basis:20%;">
                        <div class="form-group">
                            <span for="cpf_financeiro">CPF Financeiro: <small style='font-size:0.675em;color:#FFF;'>(Preencher se o cliente é menor de idade)</small></span>
                            <input type="text" name="cpf_financeiro" id="cpf_financeiro" placeholder="XXX.XXXX.XXX-XX" class="form-control" value="">
                            <div class="errorcpfresponsavelfinanceiro"></div>
                           
                        </div>
                    </div>

                    <div style="flex-basis:19%;margin:0 1%;">
                        <div class="form-group">
                            <span for="endereco_financeiro">Endereço Completo:</span>
                            <input type="text" name="endereco_financeiro" required id="endereco_financeiro" value="{{old('endereco_financeiro')}}" placeholder="Endereço Completo" class="form-control" value="">
                            <div class="errorenderefinanceiro"></div>
                        </div>
                    </div>

                    <div style="flex-basis:19%;">
                        <div class="form-group">
                            <span for="cidade">Cidade:</span>
                            <select name="cidade" required id="cidade" class="form-control change_valores">
                                <option value="">--Escolher a cidade--</option>
                                @foreach($cidades as $c)
                                    <option value="{{$c->id}}" {{$cliente->cidade_id == $c->id ? 'selected' : ''}}>{{$c->nome}}</option>
                                @endforeach
                            </select>   
                           <div class="errorcidade"></div>
                        </div>
                    </div>

                    <div style="flex-basis:18%;margin:0 1%;">
                        <div class="form-group">
                            <span for="operadora">Operadora:</span>
                            <select name="operadora" required id="operadora" class="form-control">
                                <option value="">--Escolher a Operadora--</option>
                                @foreach($operadoras as $o)
                                <option value="{{$o->id}}" {{old('operadora') == $o->id ? 'selected' : ''}}>{{$o->nome}}</option>
                                @endforeach
                            </select>
                            <div class="erroroperadora"></div>
                        </div>
                    </div>

                    <div style="flex-basis:18%;">
                        <div class="form-group">
                            <span for="administradora">Administradora:</span>
                            <select name="administradora" required id="administradora" class="form-control">
                                <option value="">--Escolher Administradora--</option>
                                @foreach($administradoras->administradoras as $admin)
                                    <option value="{{$admin->id}}" {{old('administradora') == $admin->id ? 'selected' : ''}}>{{$admin->nome}}</option>
                                @endforeach
                            </select>    
                            <div class="erroradministradora"></div>
                        </div>
                    </div>


                </div>
                
                <div class="form-row mt-1">
                    
                    <div class="col-3">
                        <div class="form-group">
                            <span for="Plano">Planos:</span>
                            <!-- <input type="text" id="plano" name="plano"> -->
                            <select name="plano" id="plano" class="form-control">
                                <option value="">--Escolher um Plano--</option>
                                
                            </select>    
                            <div class="errorplano"></div>
                        </div>
                    </div>    



                    <div class="col-3">
                        <div class="form-group">
                            <span for="codigo_externo">Codigo Externo:</span>
                            <input type="text" name="codigo_externo" required id="codigo_externo" value="{{old('codigo_externo')}}" class="form-control" placeholder="COD.">
                            <div class="errorcodigo"></div>
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="form-group d-flex justify-content-center flex-column">
                            <span>Coparticipação:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-light" id="coparticipacao_sim">
                                    <input type="radio" name="coparticipacao" id="coparticipacao_radio_sim"  value="sim" {{old('coparticipacao') == "sim" ? 'checked' : ''}}> Sim
                                </label>
                                <label class="btn btn-outline-light" id="coparticipacao_nao">
                                    <input type="radio" name="coparticipacao" id="coparticipacao_radio_nao" value="nao" {{old('coparticipacao') == "nao" ? 'checked' : ''}}> Não
                                </label>
                                
                            </div>
                            <div class='errorcoparticipacao'></div>
                        </div>
                    </div>    
                    <div class="col-3">
                        <div class="form-group  d-flex justify-content-center flex-column">
                            <span for="odonto">Odonto:</span>
                            
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-light" id="odonto_sim">
                                    <input type="radio" name="odonto" id="odonto_radio_sim" value="sim" {{old('odonto') == "sim" ? 'checked' : ''}}> Sim
                                </label>
                                <label class="btn btn-outline-light" id="odonto_nao">
                                    <input type="radio" name="odonto" id="odonto_radio_nao" value="nao" {{old('odonto') == "nao" ? 'checked' : ''}}> Não
                                </label>
                                
                            </div>
                            <div class='errorodonto'></div>
                        </div>
                    </div> 
    





                </div>
               <section>
                    <h4>Faixas Etarias</h4>
                    <div class="errorfaixas"></div>
                    <!--COMEÇO Faixa Etaria-->
                    <div class="d-flex">

                        <div  style="flex-basis:10%;">
                            <span for="">0-18</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="d-flex justify-content-center minus" id="faixa-0-18" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_0_18" name="faixas_etarias[1]" value="{{isset($colunas) && in_array(1,$colunas) ? $faixas[array_search(1, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-0-18" class="text-center font-weight-bold flex-fill faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="d-flex justify-content-center plus" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      


                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">19-23</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="d-flex justify-content-center minus" id="faixa-19-23" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_19_23" name="faixas_etarias[2]" value="{{isset($colunas) && in_array(2,$colunas) ? $faixas[array_search(2, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-19-23" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="d-flex justify-content-center plus" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;">
                            <span for="">24-28</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="d-flex justify-content-center minus" id="faixa-24-28" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_24_28" name="faixas_etarias[3]" value="{{isset($colunas) && in_array(3,$colunas) ? $faixas[array_search(3, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-24-28" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">29-33</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-29-33" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_29_33" name="faixas_etarias[4]" value="{{isset($colunas) && in_array(4,$colunas) ? $faixas[array_search(4, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-29-33" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="plus  d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;">
                            <span for="">34-38</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-34-38" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[5]" data-change="change_faixa_34_38" value="{{isset($colunas) && in_array(5,$colunas) ? $faixas[array_search(5, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-34-38" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div> 
                        
                        
                
                    

                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">39-43</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-39-43" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[6]" data-change="change_faixa_39_43" value="{{isset($colunas) && in_array(6,$colunas) ? $faixas[array_search(6, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-39-43" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      


                        <div  style="flex-basis:10%;">
                            <span for="">44-48</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-44-48" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[7]" data-change="change_faixa_44_48" value="{{isset($colunas) && in_array(7,$colunas) ? $faixas[array_search(7, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-44-48" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div  style="flex-basis:10%;margin:0 10px;">
                            <span for="">49-53</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-49-53" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[8]" data-change="change_faixa_49_53" value="{{isset($colunas) && in_array(8,$colunas) ? $faixas[array_search(8, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-49-53" class="text-center font-weight-bold faixas_etarias" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div style="flex-basis:10%;margin:0 10px 0 0;">
                            <span for="">54-58</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">
                                    <button type="button" class="minus d-flex justify-content-center" id="faixa-54-58" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[9]" data-change="change_faixa_54_58" value="{{isset($colunas) && in_array(9,$colunas) ? $faixas[array_search(9, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-54-58"  class="text-center font-weight-bold faixas_etarias d-flex" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>      

                        <div style="flex-basis:10%;">
                            <span for="">59+</span>
                            <div class="border border-white rounded">
                                <div class="d-flex content">

                                    <button type="button" class="minus d-flex justify-content-center"  id="faixa-59" style="border:none;background:transparent;width:30%;" aria-label="−" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">－</span>
                                    </button>
                                    
                                    <input type="tel" data-change="change_faixa_59" name="faixas_etarias[10]" value="{{isset($colunas) && in_array(10,$colunas) ? $faixas[array_search(10, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-59" class="text-center font-weight-bold faixas_etarias d-flex" style="border:none;width:40%;font-size:1.2em;" value="" step="1" min="0" />
                                    
                                    <button type="button" class="plus d-flex justify-content-center" style="border:none;background:transparent;width:30%;" aria-label="+" tabindex="0">
                                        <span class="text-white font-weight-bold" style="font-size:1.5em;">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <!--Fim Faixa Etaria-->                      
                </section> 
             <div class="form-row mt-3">
                    <div class="col-12 d-flex rounded">
                        <button class="botao d-flex rounded-lg align-self-center w-100 text-center justify-content-center py-2 text-navy" style="text-decoration:underline;font-weight:bold;font-size:1.8em;background-color:rgb(133,255,199);border:3px solid #FFF;">Mostrar Planos</button>
                    </div>
                </div>
                <div id="resultado">
                </div>    
        </div>
    </div>
    
    </form>             
@stop  

@section('css')
    <style>
        .botao:hover {
            background-color: rgba(0,0,0,0.5) !important;
            color:#FFF !important;
        }

        .valores-acomodacao {
            background-color:rgba(0,0,0,0.5);
            color:#FFF;
            width:32%;
            box-shadow:rgba(0,0,0,0.8) 0.6em 0.7em 5px;
            
        }


        .valores-acomodacao:hover {
            cursor:pointer;
            box-shadow: none;
        }

        .table thead tr {
            background-color:rgb(36,125,157);
            
        }

        .table tbody tr:nth-child(odd) {
            background-color: rgba(0,0,0,0.5);
        }
        .table tbody tr:nth-child(even) {
            background-color:rgb(36,125,157);
        }

        .destaque {
            border:4px solid rgba(36,125,157);
        }


    </style>
@stop










@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>   
   
    <script>
        $(function(){
            $('#cpf').mask('000.000.000-00');       
            $('#cpf_financeiro').mask('000.000.000-00');       
            //$('#valor_adesao').mask("#.##0,00", {reverse: true});
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });    
            

            $('body').on('click','.valores-acomodacao',function(e){
                let valor_plano = $(this).find('.valor_plano').text().replace("R$ ","");
                let tipo = $(this).find('.tipo').text();
                $("#valor").val(valor_plano);
                $("#acomodacao").val(tipo);

                if(!$(this).hasClass('destaque')) {
                    $('#data_vigencia').val('')
                    $('#data_boleto').val('');
                    $('#valor_adesao').val('');
                }


                $(".valores-acomodacao").removeClass('destaque');
                $(this).addClass('destaque');

                $('body,html').animate({
                    scrollTop:$(window).scrollTop() + $(window).height(),
                },1500);
                $("#btn_submit").html("<button type='submit' class='btn btn-block btn-light my-4 salvar_contrato'>Salvar Contrato</button>")
                
                
               
                $('.valores-acomodacao').not('.destaque').each(function(i,e){
                    $(e).find('.vigente').val('')
                    $(e).find('.boleto').val('')
                    $(e).find('.valor_adesao').val('')
                    
                });

                if($(e.target).is('.form-control')) {
                    return;
                } 

                // $(this).find(".vigente").change(function(){
                //     if($(this).find("#boleto").val() != "" && $(this).find("#adesao") != "") {
                //         $('body,html').animate({
                //             scrollTop:$(window).scrollTop() + $(window).height(),
                //         },1500);
                //         $("#btn_submit").html("<button type='submit' class='btn btn-block btn-light my-4 salvar_contrato'>Salvar Contrato</button>")
                //     } 
                // });

                // $(this).find(".boleto").change(function(){
                //     if($(this).find("#adesao").val() != "" && $(this).find("#vigente") != "") {
                //         $('body,html').animate({
                //             scrollTop:$(window).scrollTop() + $(window).height(),
                //         },1500);
                //         $("#btn_submit").html("<button type='submit' class='btn btn-block btn-light my-4 salvar_contrato'>Salvar Contrato</button>")
                //     }
                // });

                // $(this).find(".adesao").change(function(){
                //     if($(this).find("#boleto").val() != "" && $(this).find("#vigente") != "") {
                        
                //     }
                // });



                // if($("#data_vigencia").val() != "" && $("#data_boleto").val() != "" && $("#valor_adesao").val() != "") {
                //     console.log("Entreiiiiiiiiii");
                //     // $('body,html').animate({
                //     //         scrollTop:$(window).scrollTop() + $(window).height(),
                //     //     },1500);
                //     // $("#btn_submit").html("<button type='submit' class='btn btn-block btn-light my-4 salvar_contrato'>Salvar Contrato</button>")
                // }


                // $("#vigente").change(function(){
                //     console.log("Mudei");
                    // if($("#boleto").val() != "") {
                    //     console.log("Boleto Tem");
                    // } else {
                    //     console.log("Boleto Nao");
                    // }
                // });

                

            });

            $("form[name='cadastrar_pessoa_fisca_formulario']").on('submit',function(e){
                 if($("#data_vigencia").val() == "") {
                        toastr["error"]("Data Vigencia e campo obrigatorio")
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
                        return false;
                }

                if($("#data_boleto").val() == "") {
                    
                    toastr["error"]("Data Boleto e campo obrigatorio")
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
                    return false;    
                }

                if($("#valor_adesao").val() == "") {
                    toastr["error"]("Valor Adesão e campo obrigatorio")
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
                    return false;
                    // atual.find('input[name="adesao"]').keyup(function(){
                    //     console.log($(this).val().length);
                    // });
                }
                return true;
            });




            $("#administradora").on('change',function(){
               let id = $(this).val();
               
               $.ajax({
                    url:"{{route('contratos.pegarPlanosPorAdministradoras')}}",
                    data:"administradora="+id,
                    method:"POST",
                    success:function(res) {
                        if(res.planos.length >= 1) {
                            let selecionado = null;
                            if($("#plano").val()) {
                                selecionado = $("#plano").val();
                            } 
                            console.log(selecionado)
                            $("#plano").html("");
                            $("#plano").prepend("<option value=''>--Escolher um Plano--</option>");
                            $(res.planos).each(function(index,value){
                                $("#plano").append($(`<option ${value.id == selecionado ? 'selected' : ''}>`).val(value.id).text(value.nome));
                            });
                        } else {
                            $("#plano").html("");
                            $("#plano").append('<option value="">--Esta administradora não possui planos cadastradas--</option>');
                        }
                    }    
               });
            });

              



            

            function TestaCPF(cpf) {
                cpf = cpf.replace(/[^\d]+/g,'');	
	            if(cpf == '') return false;	
	            // Elimina CPFs invalidos conhecidos	
	            if (cpf.length != 11 ||  cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" ||  cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999") return false;		
	            // Valida 1o digito	
	            add = 0;	
	            for (i=0; i < 9; i ++)		
		            add += parseInt(cpf.charAt(i)) * (10 - i);	
		            rev = 11 - (add % 11);	
		            if (rev == 10 || rev == 11)		
			            rev = 0;	
		            if (rev != parseInt(cpf.charAt(9)))		
			            return false;		
	                // Valida 2o digito	
	                add = 0;	
	                for (i = 0; i < 10; i ++)		
		                add += parseInt(cpf.charAt(i)) * (11 - i);	
	                    rev = 11 - (add % 11);	
	                    if (rev == 10 || rev == 11)	
		                    rev = 0;	
	                    if (rev != parseInt(cpf.charAt(10)))
		                return false;		
	                    return true;   
            }           
                       
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

            
            $('body').on('click','#coparticipacao_sim > #coparticipacao_radio_sim',function(){
                $("#change_coparticipacao").val($(this).val()).trigger('change');
            });

            $('body').on('click','#coparticipacao_nao > #coparticipacao_radio_nao',function(){
                $("#change_coparticipacao").val($(this).val()).trigger('change');
            });

            $('body').on('click','#odonto_sim > #odonto_radio_sim',function(){
                $("#change_odonto").val($(this).val()).trigger('change');
            });

            $('body').on('click','#odonto_nao > #odonto_radio_nao',function(){
                $("#change_odonto").val($(this).val()).trigger('change');
            });    
            
            // $("#data_nascimento").on('focusout',function(){
            //     let dados = parseInt($(this).val());
            //     const dataAtual = new Date();
            //     const anoAtual = dataAtual.getFullYear();
            //     if(dados >= anoAtual) {
            //         console.log("Maior");
            //     } else {
            //         console.log("Menor");
            //     }
                
            // });  



            
           $("body").on("click",".botao",function(){
                $("#change_plano").val($(this).val());

                if($("#nome").val() == "") {
                    $("#change_plano").val($(this).val())
                    $('.errorcliente').html("<p class='alert alert-danger'>Cliente e campo obrigatório<p>");
                    return false;
                } else {
                    $('.errorcliente').html("");
                }
                
                if($("#cpf").val() == "") {
                    $("#change_plano").val($(this).val())
                    $('.errorcpf').html("<p class='alert alert-danger'>CPF e campo obrigatório<p>");
                    return false;
                } else {
                    $('.errorcpf').html("");
                }             
                
                // if(!TestaCPF($("#cpf").val())) {
                //     $("#change_plano").val($(this).val())
                //     $('.errorcpf').html("<p class='alert alert-danger'>CPF Invalido<p>");
                //     return false;
                // } else {
                //     $('.errorcpf').html("");            
                // }

                if($("#data_nascimento").val() == "") {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.errordatanascimento').html("<p class='alert alert-danger'>Data e campo obrigatório<p>");
                    return false;
                } else {
                    $('.errordatanascimento').html("");
                }

                if($("#email").val() == "") {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.erroremail').html("<p class='alert alert-danger'>Email e campo obrigatório</p>")
                    return false;
                } else {
                    $(".erroremail").html("");
                }

                // if($("#responsavel_financeiro").val() == "") {
                //     $("#change_plano").val($(this).val())
                //     //$(this).val('');
                //     $('.errorresponsavelfinanceiro').html("<p class='alert alert-danger'>Este e campo obrigatório</p>")
                //     return false;
                // } else {
                //     $(".errorresponsavelfinanceiro").html("");
                // }

                // if($("#cpf_financeiro").val() == "") {
                //     $("#change_plano").val($(this).val())
                //     //$(this).val('');
                //     $('.errorcpfresponsavelfinanceiro').html("<p class='alert alert-danger'>Este e campo obrigatório</p>")
                //     return false;
                // } else {
                //     $(".errorcpfresponsavelfinanceiro").html("");
                // }

                if($("#endereco_financeiro").val() == "") {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.errorenderefinanceiro').html("<p class='alert alert-danger'>Este e campo obrigatório</p>")
                    return false;
                } else {
                    $(".errorenderefinanceiro").html("");
                }

                if($("#cidade").val() == "") {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.errorcidade').html("<p class='alert alert-danger'>Cidade e campo obrigatório<p>");
                    return false;
                } else {
                    $('.change_cidade').val($("#cidade").val());
                    $(".errorcidade").html("");
                }

                if($("#operadora").val() == "") {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.erroroperadora').html("<p class='alert alert-danger'>Operadora e campo obrigatório<p>");
                    return false;
                } else {
                    $('#change_operadora').val($("#operadora").val());
                    $(".erroroperadora").html("");
                }

                if($("#administradora").val() == "") {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.erroradministradora').html("<p class='alert alert-danger'>Administradora e campo obrigatório<p>");
                    return false;
                } else {
                    $('#change_administradora').val($("#administradora").val());
                    $('.erroradministradora').html("");
                }

                if($("#codigo_externo").val() == "") {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.errorcodigo').html("<p class='alert alert-danger'>Código e campo obrigatório<p>");
                    return false;
                } else {
                    $('.errorcodigo').html('');
                }

                if(
                    $("#faixa-input-0-18").val() == "" && 
                    $("#faixa-input-19-23").val() == "" && 
                    $("#faixa-input-24-28").val() == "" && 
                    $("#faixa-input-29-33").val() == "" && 
                    $("#faixa-input-34-38").val() == "" && 
                    $("#faixa-input-39-43").val() == "" && 
                    $("#faixa-input-44-48").val() == "" && 
                    $("#faixa-input-49-53").val() == "" && 
                    $("#faixa-input-54-58").val() == "" && 
                    $("#faixa-input-59").val() == ""
                ) {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.errorfaixas').html("<p class='alert alert-danger'>Pelo Menos 1 faixa etária deve ser preenchida</p>")
                    return false;
                } else {
                    $("#change_faixa_0_18").val($("#faixa-input-0-18").val())    
                    $("#change_faixa_19_23").val($("#faixa-input-19-23").val())    
                    $("#change_faixa_24_28").val($("#faixa-input-24-28").val())    
                    $("#change_faixa_29_33").val($("#faixa-input-29-33").val())    
                    $("#change_faixa_34_38").val($("#faixa-input-34-38").val())    
                    $("#change_faixa_39_43").val($("#faixa-input-39-43").val())    
                    $("#change_faixa_44_48").val($("#faixa-input-44-48").val())    
                    $("#change_faixa_49_53").val($("#faixa-input-49-53").val())    
                    $("#change_faixa_54_58").val($("#faixa-input-54-58").val())    
                    $("#change_faixa_59").val($("#faixa-input-59").val())    
                    $('.errorfaixas').html("");
                }


                if(!$('input:radio[name=coparticipacao]').is(':checked')) {
                    $("#change_plano").val($(this).val())
                    //$(this).val('');
                    $('.errorcoparticipacao').html("<p class='alert alert-danger'>Marque Sim/Não Coparticipaão</p>")
                    return false;
                } else {                    
                    $('.errorcoparticipacao').html("");
                }

                if(!$('input:radio[name=odonto]').is(':checked')) {
                    $("#change_plano").val($(this).val())
                    $('.errorodonto').html("<p class='alert alert-danger'>Marque Sim/Não Odonto</p>");
                    return false;
                } else {
                    $('.errorodonto').html("");
                }

                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),
                    operadora: $("#operadora").val(),
                    administradora: $("#administradora").val(),
                    coparticipacao: $("input:radio[name=coparticipacao]:checked").val(),
                    odonto: $('input:radio[name=odonto]:checked').val(), 
                    plano:$("#plano").val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                //console.log(data);
                montarValores(data);
                return false;
            });


            $("body").on('change','#acomodacao',function(){
                let valor = $(this).attr('data-valor');
                let atual = $(this);                
                if(atual.closest('.valores-acomodacao').find('#vigente').val() == "") {
                    $("#change_plano").val($(this).val())
                    atual.closest('.valores-acomodacao').find('.errordatavigente').html("<p class='alert alert-danger' style='font-size:0.79em;'>Este e campo obrigatório</p>");
                    atual.prop('checked', false);
                    return false;
                } else {
                    atual.closest('.valores-acomodacao').find(".errordatavigente").html("");
                }

                if(atual.closest('.valores-acomodacao').find('#boleto').val() == "") {
                    $("#change_plano").val($(this).val())
                    atual.closest('.valores-acomodacao').find('.errordataboleto').html("<p class='alert alert-danger' style='font-size:0.79em;'>Este e campo obrigatório</p>");
                    atual.prop('checked', false);
                    return false;
                } else {
                    atual.closest('.valores-acomodacao').find('.errordataboleto').html("");
                }

                if(atual.closest('.valores-acomodacao').find("#adesao").val() == "") {
                    $("#change_plano").val($(this).val())
                    atual.closest('.valores-acomodacao').find('.errorvaloradesao').html("<p class='alert alert-danger'>Este e campo obrigatório</p>");
                    atual.prop('checked', false);
                    return false;
                } else {
                    atual.closest('.valores-acomodacao').find(".errorvaloradesao").html("");
                }


                $("#valor").val(valor);
                $('body,html').animate({
                    scrollTop:"900px"
                },1000);
                $('.valores-acomodacao').css({"box-shadow":"none"});
                $(this).closest('.valores-acomodacao').css({"box-shadow": "10px 5px 5px black"})
                $("#btn_submit").html("<button type='submit' class='btn btn-block btn-outline-secondary my-4 salvar_contrato'>Salvar Contrato</button>")
            });  

            $("body").on('change','#vigente',function(){
                let data_vigencia = $(this).val();
                $("#data_vigencia").val(data_vigencia);
            });

            $("body").on('change','#boleto',function(){
                let data_boleto = $(this).val();
                $("#data_boleto").val(data_boleto);
            });

            $("body").on('change','#adesao',function(){
                let valor_adesao = $(this).val();
                $("#valor_adesao").val(valor_adesao);
            });


            $('body').on('change','.change_valores',function(){
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),
                    operadora: $("#operadora").val(),
                    administradora: $("#administradora").val(),
                    coparticipacao: $("input[name='change_coparticipacao']").val(),
                    odonto: $("input[name='change_odonto']").val(), 
                    plano:$("#plano").val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                montarValores(data);
            });

            $('body').on('change','.change_plano',function(){
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),
                    operadora: $("#operadora").val(),
                    administradora: $("#administradora").val(),
                    coparticipacao: $("input[name='change_coparticipacao']").val(),
                    odonto: $("input[name='change_odonto']").val(), 
                    plano:$("#plano").val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                montarValores(data);
            });

            $('body').on('change','.mudar_coparticipacao',function(){
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),
                    operadora: $("#operadora").val(),
                    administradora: $("#administradora").val(),
                    coparticipacao: $("input[name='change_coparticipacao']").val(),
                    odonto: $("input[name='change_odonto']").val(), 
                    plano:$("#plano").val(),
                    faixas: {
                        '1': $("#faixa-input-0-18").val(), 
                        '2': $("#faixa-input-19-23").val(),
                        '3': $("#faixa-input-24-28").val(),
                        '4': $("#faixa-input-29-33").val(),
                        '5': $("#faixa-input-34-38").val(),
                        '6': $("#faixa-input-39-43").val(),
                        '7': $("#faixa-input-44-48").val(),
                        '8': $("#faixa-input-49-53").val(),
                        '9': $("#faixa-input-54-58").val(),
                        '10': $("#faixa-input-59").val()}
                };
                montarValores(data);             
            });

            $('body').on('change','.mudar_odonto',function(){
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),
                    operadora: $("#operadora").val(),
                    administradora: $("#administradora").val(),
                    coparticipacao: $("input[name='change_coparticipacao']").val(),
                    odonto: $("input[name='change_odonto']").val(), 
                    plano:$("#plano").val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                montarValores(data);             
            });

            /*********************************************************** */
            $('body').on('click','.change_valores_faixas',function(){
                let campo = $(this).closest(".content").find('input[type="tel"]').attr('data-change');
                let valor = $(this).closest(".content").find('input[type="tel"]').val();
                if(valor>0) {
                    $('input[name="'+campo+'"]').val(valor);
                } else {
                    $('input[name="'+campo+'"]').val('');
                }
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),
                    operadora: $("#operadora").val(),
                    administradora: $("#administradora").val(),
                    coparticipacao: $("input[name='change_coparticipacao']").val(),
                    odonto: $("input[name='change_odonto']").val(), 
                    plano:$("#plano").val(),
                    faixas: {'1': $("#change_faixa_0_18").val(), '2': $("#change_faixa_19_23").val(),'3': $("#change_faixa_24_28").val(),'4': $("#change_faixa_29_33").val(),'5': $("#change_faixa_34_38").val(),'6': $("#change_faixa_39_43").val(),'7': $("#change_faixa_44_48").val(),'8': $("#change_faixa_49_53").val(),'9': $("#change_faixa_54_58").val(),'10': $("#change_faixa_59").val()}
                };
                montarValores(data);      
            });

            function montarValores(data) {
                $.ajax({
                    url:"{{route('contrato.montarValoresFormularioAcomodacao')}}",
                    method:"POST",
                    data: data,
                    success(res) {
                        $("#cidade").addClass('change_valores');
                        $("#operadora").addClass('change_valores');
                        $("#administradora").addClass('change_valores');
                        $("#change_coparticipacao").addClass('mudar_coparticipacao');
                        $("#change_odonto").addClass('mudar_odonto');
                        $("#change_plano").addClass('change_plano');
                        $("form[name='cadastrar_pessoa_fisca_formulario']").find('button[type="button"]').addClass('change_valores_faixas');
                        $("#resultado").slideUp().html(res).delay(100).slideToggle(100,function(){
                            $('body,html').animate({
                                scrollTop:$(window).scrollTop() + $(window).height(),
                            },1500);
                        });                        
                    }
                });
                return false;
            }
        });
    </script>
@stop
