@extends('adminlte::page')
@section('title', 'Contrato')
@section('plugins.jqueryUi', true)
@section('content_header')
    <h3>Contratos</h3>
@stop
@section('content')
<div class="card card-primary card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="pt-2 px-3"><h3 class="card-title">Realizar Contratos <i class="fas fa-hand-point-right"></i></h3></li>
            <li class="nav-item">
                <a class="nav-link {{($cliente->pessoa_fisica == 1 && $cliente->pessoa_juridica == 0) ? 'active' : ''}}" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="{{($cliente->pessoa_fisica == 1 && $cliente->pessoa_juridica == 0) ? true : false}}">Pessoa Fisica <i class="fas fa-user-alt"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{($cliente->pessoa_fisica == 0 && $cliente->pessoa_juridica == 1)  ? 'active' : ''}}" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="{{($cliente->pessoa_fisica == 0 && $cliente->pessoa_juridica == 1) ? true : false}}">Pessoa Juridica <i class="fas fa-balance-scale"></i></a>
            </li>
            
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade {{($cliente->pessoa_fisica == 1 && $cliente->pessoa_juridica == 0) ? 'show active' : ''}}" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
            
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
                <div class="form-row mt-3">
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="nome">Titular:</label>
                            <input type="text" name="nome" id="nome" required class="form-control" placeholder="Nome" value="{{$cliente->nome}}">
                            <div class="errorcliente"></div>
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="cpf">CPF:</label>
                            <input type="text" name="cpf" id="cpf" required class="form-control" value="{{old('cpf')}}" placeholder="XXX.XXXX.XXX-XX">
                            <div class="errorcpf"></div>
                            @if($errors->has('cpf'))
                                <p class="alert alert-danger">{{$errors->first('cpf')}}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="data_nascimento">Data Nascimento:</label>
                            <input type="date" name="data_nascimento" value="{{old('data_nascimento')}}" required id="data_nascimento" class="form-control">
                            <div class="errordatanascimento"></div>
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" required placeholder="Email" class="form-control" value="{{$cliente->email}}">
                            <div class="erroremail"></div>
                        </div>
                    </div>    
                </div>    
                
                <div class="form-row mt-3">
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label for="responsavel_financeiro">Responsavel Financeiro:<small style='font-size:0.7em;color:#666;'>(Preencher apenas se o cliente for de menor)</small></label>
                            <input type="text" name="responsavel_financeiro" id="responsavel_financeiro" placeholder="Responsavel Financeiro" class="form-control" value="">
                            <div class="errorresponsavelfinanceiro"></div>
                        </div>
                    </div>    

                    <div class="col col-md-4">
                        <div class="form-group">
                            <label for="cpf_financeiro">CPF Financeiro:<small style='font-size:0.7em;color:#666;'>(Preencher apenas se o cliente for de menor)</small></label>
                            <input type="text" name="cpf_financeiro" id="cpf_financeiro" placeholder="XXX.XXXX.XXX-XX" class="form-control" value="">
                            <div class="errorcpfresponsavelfinanceiro"></div>
                           
                        </div>
                    </div>

                    <div class="col col-md-4">
                        <div class="form-group">
                            <label for="endereco_financeiro">Endereço Completo:</label>
                            <input type="text" name="endereco_financeiro" required id="endereco_financeiro" value="{{old('endereco_financeiro')}}" placeholder="Endereço Completo" class="form-control" value="">
                            <div class="errorenderefinanceiro"></div>
                        </div>
                    </div>

                </div>
                                
                
                <div class="form-row mt-3">
                    
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="cidade">Cidade:</label>
                            <select name="cidade" required id="cidade" class="form-control change_valores">
                                <option value="">--Escolher a cidade--</option>
                                
                                @foreach($cidades as $c)
                                    <option value="{{$c->id}}" {{$cliente->cidade_id == $c->id ? 'selected' : ''}}>{{$c->nome}}</option>
                                @endforeach
                            </select>   
                           <div class="errorcidade"></div>
                        </div>
                    </div>    
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="operadora">Operadora:</label>
                            <select name="operadora" required id="operadora" class="form-control">
                                <option value="">--Escolher a Operadora--</option>
                                @foreach($operadoras as $o)
                                <option value="{{$o->id}}" {{old('operadora') == $o->id ? 'selected' : ''}}>{{$o->nome}}</option>
                                @endforeach
                            </select>
                            <div class="erroroperadora"></div>
                        </div>
                    </div>  
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="administradora">Administradora:</label>
                            <select name="administradora" required id="administradora" class="form-control">
                                <option value="">--Escolher a Administradora--</option>
                                @foreach($administradoras as $admin)
                                    <option value="{{$admin->id}}" {{old('administradora') == $admin->id ? 'selected' : ''}}>{{$admin->nome}}</option>
                                @endforeach
                            </select>    
                            <div class="erroradministradora"></div>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="codigo_externo">Codigo Externo:</label>
                            <input type="text" name="codigo_externo" required id="codigo_externo" value="{{old('codigo_externo')}}" class="form-control" placeholder="COD.">
                            <div class="errorcodigo"></div>
                        </div>
                    </div>        
                </div>
               <section>
                    <h4 class="">Faixas Etarias</h4>
                    <div class="errorfaixas"></div>
                    <div class="form-row mb-4">

                        <div class="col-6 col-md-2 col-sm-4">
                            <span for="">0-18</span>
                            <div class="border border-secondary rounded p-1">
                                <div class="d-flex content">
                                    <button type="button" class="flex-fill minus" id="faixa-0-18" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_0_18" name="faixas_etarias[1]" value="{{isset($colunas) && in_array(1,$colunas) ? $faixas[array_search(1, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-0-18" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-19-23" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_19_23" name="faixas_etarias[2]" value="{{isset($colunas) && in_array(2,$colunas) ? $faixas[array_search(2, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-19-23" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-24-28" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_24_28" name="faixas_etarias[3]" value="{{isset($colunas) && in_array(3,$colunas) ? $faixas[array_search(3, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-24-28" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-29-33" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_29_33" name="faixas_etarias[4]" value="{{isset($colunas) && in_array(4,$colunas) ? $faixas[array_search(4, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-29-33" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-34-38" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[5]" data-change="change_faixa_34_38" value="{{isset($colunas) && in_array(5,$colunas) ? $faixas[array_search(5, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-34-38" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-39-43" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[6]" data-change="change_faixa_39_43" value="{{isset($colunas) && in_array(6,$colunas) ? $faixas[array_search(6, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-39-43" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-44-48" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[7]" data-change="change_faixa_44_48" value="{{isset($colunas) && in_array(7,$colunas) ? $faixas[array_search(7, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-44-48" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-49-53" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[8]" data-change="change_faixa_49_53" value="{{isset($colunas) && in_array(8,$colunas) ? $faixas[array_search(8, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-49-53" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-54-58" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[9]" data-change="change_faixa_54_58" value="{{isset($colunas) && in_array(9,$colunas) ? $faixas[array_search(9, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-54-58"  class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus"  id="faixa-59" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" data-change="change_faixa_59" name="faixas_etarias[10]" value="{{isset($colunas) && in_array(10,$colunas) ? $faixas[array_search(10, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-59" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>   
                    </div>   
            </section> 

             <div class="form-row mt-3">
                    
                    <div class="col-3 col-md-3">
                        <div class="form-group">
                            <label for="coparticipacao">Coparticipação:</label><br />
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-secondary btn-lg" id="coparticipacao_sim">
                                    <input type="radio" name="coparticipacao" id="coparticipacao_radio_sim" value="sim" {{old('coparticipacao') == "sim" ? 'checked' : ''}}> Sim
                                </label>
                                <label class="btn btn-outline-secondary btn-lg" id="coparticipacao_nao">
                                    <input type="radio" name="coparticipacao" id="coparticipacao_radio_nao" value="nao" {{old('coparticipacao') == "nao" ? 'checked' : ''}}> Não
                                </label>
                                
                            </div>
                            <div class='errorcoparticipacao'></div>
                        </div>
                    </div>    
                    <div class="col-3 col-md-3">
                        <div class="form-group">
                            <label for="odonto">Odonto:</label><br />
                            
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-secondary btn-lg" id="odonto_sim">
                                    <input type="radio" name="odonto" id="odonto_radio_sim" value="sim" {{old('odonto') == "sim" ? 'checked' : ''}}> Sim
                                </label>
                                <label class="btn btn-outline-secondary btn-lg" id="odonto_nao">
                                    <input type="radio" name="odonto" id="odonto_radio_nao" value="nao" {{old('odonto') == "nao" ? 'checked' : ''}}> Não
                                </label>
                                
                            </div>
                            <div class='errorodonto'></div>
                        </div>
                    </div> 
                    
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label for="odonto">Plano:</label><br />
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach($planos as $p)
                                <label class="btn btn-outline-secondary btn-lg">
                                    <input type="radio" class="planos_aqui" name="plano" id="plano" value="{{$p->id}}">{{$p->nome}}
                                </label>
                                @endforeach
                            </div>    
                        </div>
                        <div class='errorplano'></div>  
                    </div>         
                </div>
                <div id="resultado">

                </div>               
            </form>
            </div>
            <div class="tab-pane fade {{($cliente->pessoa_fisica == 0 && $cliente->pessoa_juridica == 1) ? 'show active' : ''}}" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                <form action="">
                    <div class="form-row mt-3">
                        <div class="col-6 col-md-4">
                            <div class="form-group">
                                <label for="nome">Operadora:</label>
                                <select name="" id="" class="form-control">
                                    <option value="">--Escolher a Operadora--</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="form-group">
                                <label for="cpf">CNPJ:</label>
                                <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ" value="{{$cliente->cnpj}}">
                                <div class="errorcnpj"></div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="form-group">
                                <label for="cpf">Razão Social:</label>
                                <input type="text" name="razao_social" id="razao_social" class="form-control" placeholder="Razão Social">
                                <div class="errornome"></div>
                            </div>
                        </div>

                        
                    </div>  
                    
                    <div class="form-row mt-3">

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="proprietaria">Proprietaria</label>
                                <input type="text" name="proprietaria" id="proprietaria" class="form-control" placeholder="Proprietario">
                                <div class="errornome"></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="contato">Contato</label>
                                <input type="text" name="contato" id="proprietaria" class="form-control" placeholder="Contato">
                                <div class="errornome"></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="celular">Telefone</label>
                                <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular">
                                <div class="errornome"></div>
                            </div>
                        </div>

                    </div>    

                    <div class="form-row mt-3">

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="proprietaria" id="proprietaria" class="form-control" placeholder="Proprietario">
                                <div class="errornome"></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="contato">Quantidade de Vidas</label>
                                <input type="text" name="contato" id="proprietaria" class="form-control" placeholder="Contato">
                                <div class="errornome"></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="celular">Valor</label>
                                <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular">
                                <div class="errornome"></div>
                            </div>
                        </div>

                    </div>    
                    
                    <button type="submit" class="btn btn-block btn-primary">Cadastrar</button>
                </form>
            </div>
            
        </div>
    </div>
</div>    
  
</div>
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



            
           $("body").on("click","input[name='plano']",function(){
                
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
                    cidade:$("#cidade").val(),operadora: $("#operadora").val(),administradora: $("#administradora").val(),coparticipacao: $("input:radio[name=coparticipacao]:checked").val(),odonto: $('input:radio[name=odonto]:checked').val(), plano:$(this).val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                montarValores(data);
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
                    cidade:$("#cidade").val(),operadora: $("#operadora").val(),administradora: $("#administradora").val(),coparticipacao: $("input[name='change_coparticipacao']").val(),odonto: $("input[name='change_odonto']").val(), plano:$("input[name='change_plano']").val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                montarValores(data);
            });

            $('body').on('change','.change_plano',function(){
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),operadora: $("#operadora").val(),administradora: $("#administradora").val(),coparticipacao: $("input[name='change_coparticipacao']").val(),odonto: $("input[name='change_odonto']").val(), plano:$("input[name='change_plano']").val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                montarValores(data);
            });

            $('body').on('change','.mudar_coparticipacao',function(){
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),operadora: $("#operadora").val(),administradora: $("#administradora").val(),coparticipacao: $("input[name='change_coparticipacao']").val(),odonto: $("input[name='change_odonto']").val(), plano:$("input[name='change_plano']").val(),
                    faixas: {'1': $("#faixa-input-0-18").val(), '2': $("#faixa-input-19-23").val(),'3': $("#faixa-input-24-28").val(),'4': $("#faixa-input-29-33").val(),'5': $("#faixa-input-34-38").val(),'6': $("#faixa-input-39-43").val(),'7': $("#faixa-input-44-48").val(),'8': $("#faixa-input-49-53").val(),'9': $("#faixa-input-54-58").val(),'10': $("#faixa-input-59").val()}
                };
                montarValores(data);             
            });

            $('body').on('change','.mudar_odonto',function(){
                let data = {
                    cliente_id:$("#cliente_id").val(),
                    data_boleto:$("#data_boleto").val(),
                    data_vigencia:$("#data_vigente").val(),
                    cidade:$("#cidade").val(),operadora: $("#operadora").val(),administradora: $("#administradora").val(),coparticipacao: $("input[name='change_coparticipacao']").val(),odonto: $("input[name='change_odonto']").val(), plano:$("input[name='change_plano']").val(),
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
                    cidade:$("#cidade").val(),operadora: $("#operadora").val(),administradora: $("#administradora").val(),coparticipacao: $("input[name='change_coparticipacao']").val(),odonto: $("input[name='change_odonto']").val(), plano:$("input[name='change_plano']").val(),
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
@section('css')
  

<style>
    .flex{display:-webkit-box;display:flex}
    .vtex-product-quantity-1-x-quantitySelectorContainer .vtex-numeric-stepper-container {
        display: flex;
        
    }

    .vtex-product-quantity-1-x-quantitySelectorContainer {
	    margin-bottom:0;
	    border-radius:8px;
	    border:1px solid #80c343
    }
    .vtex-product-quantity-1-x-quantitySelectorContainer .vtex-numeric-stepper__minus-button,.vtex-product-quantity-1-x-quantitySelectorContainer .vtex-numeric-stepper__plus-button {
	    background:transparent;
	    border:none;
	    width:auto!important
    }
    .vtex-product-quantity-1-x-quantitySelectorContainer .vtex-numeric-stepper__input {
	    background:transparent;
	    border:none;
	    line-height:1.5rem;
	    font-weight:400;
	    font-size:1.25rem;
	    text-align:center;
	    outline:0
    }
   
</style>
     
@stop
