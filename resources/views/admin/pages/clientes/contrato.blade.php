@extends('adminlte::page')
@section('title', 'Contrato')
@section('content_header')
    <h3>Contrato</h3>
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
            
            <form action="{{route('contrato.cadastrarPFSemOrcamento')}}" method="post" class="px-3">
                @csrf 
               
                <hr />    
                <div class="errorpessoa"></div>             
               
                <input type="hidden" name="ambulatorial" value="">
                <input type="hidden" name="apartamento" value="">
                <input type="hidden" name="enfermaria" value="">

                <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}">

                
                <div class="form-row mt-3">
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="nome">Cliente:</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" value="{{$cliente->nome}}">
                            <div class="errorcliente"></div>
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="cpf">CPF:</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" placeholder="XXX.XXXX.XXX-XX">
                            <div class="errorcpf"></div>
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="data_nascimento">Data Nascimento:</label>
                            <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" placeholder="DD/MM/AAAA">
                            <div class="errordatanascimento"></div>
                        </div>
                    </div>

                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="{{$cliente->email}}">
                            <div class="erroremail"></div>
                        </div>
                    </div>    



                </div>    
                <div class="form-row mt-3">
                    
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="cidade">Cidade:</label>
                            <select name="cidade" id="cidade" class="form-control">
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
                            <select name="operadora" id="operadora" class="form-control">
                                <option value="">--Escolher a Operadora--</option>
                                @foreach($operadoras as $o)
                                <option value="{{$o->id}}">{{$o->nome}}</option>
                                @endforeach
                            </select>
                            <div class="erroroperadora"></div>
                        </div>
                    </div>  
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="administradora">Administradora:</label>
                            <select name="administradora" id="administradora" class="form-control">
                                <option value="">--Escolher a Administradora--</option>
                                @foreach($administradoras as $admin)
                                    <option value="{{$admin->id}}">{{$admin->nome}}</option>
                                @endforeach
                            </select>    
                            <div class="erroradministradora"></div>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="codigo_externo">Codigo Externo:</label>
                            <input type="text" name="codigo_externo" id="codigo_externo" class="form-control" placeholder="COD.">
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
                                    <input type="tel" name="faixas_etarias[1]" value="{{isset($colunas) && in_array(1,$colunas) ? $faixas[array_search(1, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-0-18" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[2]" value="{{isset($colunas) && in_array(2,$colunas) ? $faixas[array_search(2, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-19-23" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[3]" value="{{isset($colunas) && in_array(3,$colunas) ? $faixas[array_search(3, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-24-28" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[4]" value="{{isset($colunas) && in_array(4,$colunas) ? $faixas[array_search(4, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-29-33" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[5]" value="{{isset($colunas) && in_array(5,$colunas) ? $faixas[array_search(5, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-34-38" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[6]" value="{{isset($colunas) && in_array(6,$colunas) ? $faixas[array_search(6, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-39-43" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[7]" value="{{isset($colunas) && in_array(7,$colunas) ? $faixas[array_search(7, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-44-48" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[8]" value="{{isset($colunas) && in_array(8,$colunas) ? $faixas[array_search(8, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-49-53" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <input type="tel" name="faixas_etarias[9]" value="{{isset($colunas) && in_array(9,$colunas) ? $faixas[array_search(9, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-54-58"  class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
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
                                    <button type="button" class="flex-fill minus" id="faixa-59" style="border:none;background:transparent;" aria-label="−" tabindex="0">
                                        <span class="text-dark font-weight-bold">－</span>
                                    </button>
                                    <input type="tel" name="faixas_etarias[10]" value="{{isset($colunas) && in_array(10,$colunas) ? $faixas[array_search(10, array_column($faixas, 'faixa_etaria_id'))]['faixa_quantidade'] : ''}}" id="faixa-input-59" class="text-center font-weight-bold flex-fill w-25 faixas_etarias" style="border:none;" value="" step="1" min="0" class="text-center" />
                                    <button type="button" class="flex-fill plus" style="border:none;background:transparent;" aria-label="+" tabindex="0">
                                        <span class="text-dark font-weight-bold">＋</span>
                                    </button>
                                </div>
                            </div>  
                        </div>   
                    
                        

                    </div>   
            </section>      







                
                <div class="form-row mt-3">
                    
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="operadora">Coparticipação:</label>
                            <select name="coparticipacao" id="coparticipacao" class="form-control">
                                <option value="">--Coparticipação--</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                            </select>
                            <div class='errorcoparticipacao'></div>
                        </div>
                    </div>    




                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="odonto">Odonto:</label>
                            <select name="odonto" id="odonto" class="form-control">
                                <option value="">--Odonto--</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                            </select>
                            <div class='errorodonto'></div>
                        </div>
                    </div> 
                    
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="plano">Plano:</label>
                            <select name="plano" id="plano" class="form-control">
                                <option value="">--Escolher o Plano--</option>
                                @foreach($planos as $p)
                                    <option value="{{$p->id}}">{{$p->nome}}</option>
                                @endforeach
                            </select>    
                            <div class='errorplano'></div>
                        </div>  
                    </div>         




                    <div class="col col-md-3">
                        <div class="form-group">
                            <label for="acomodacao">Acomodação:</label>
                            <select name="acomodacao" id="acomodacao" class="form-control">
                                <option value="">--Escolha a Acomodação--</option>
                                <option value="1">Apartamento</option>
                                <option value="2">Enfermaria</option>
                                <option value="3">Ambulatorial</option>
                            </select>
                            <div class='erroracomodacao'></div>
                        </div>
                    </div>  
                    
                    
                </div>


                <div class="form-group valores">
                    
                </div>    

               



               

                <button type="submit" class="btn btn-block btn-primary enviar_contrato_pf" disabled>Enviar Contrato</button>
                <hr />
                
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
            $('#data_nascimento').mask('00/00/0000');       
            // $('body').on('#cnpj').mask('00.000.000/0000-00');
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

            function mascaraValor(valor) {
                    valor = valor.toString().replace(/\D/g,"");
                    valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
                    valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
                    valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");
                    return "R$ "+valor                    
            }

            $('select[name="acomodacao"]').on('change',function(){
                if($("#nome").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html("<p class='alert alert-danger'>Cliente e campo obrigatório<p>");
                    return false;
                }   
                
                if($("#cpf").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html("<p class='alert alert-danger'>CPF e campo obrigatório<p>");
                    return false;
                }    

                if($("#data_nascimento").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html("<p class='alert alert-danger'>Data e campo obrigatório<p>");
                    return false;
                }

                if($("#email").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html("<p class='alert alert-danger'>Email e campo obrigatório</p>")
                    return false;
                }


                   
                if($("#cidade").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html("<p class='alert alert-danger'>Cidade e campo obrigatório<p>");
                    return false;
                } 

                if($("#operadora").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html('');
                    $('.erroroperadora').html("<p class='alert alert-danger'>Operadora e campo obrigatório<p>");
                    return false;
                }

                if($("#administradora").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html('');
                    $('.erroroperadora').html('');
                    $('.erroradministradora').html("<p class='alert alert-danger'>Administradora e campo obrigatório<p>");
                    return false;
                }

                if($("#codigo_externo").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html('');
                    $('.erroroperadora').html('');
                    $('.erroradministradora').html('');
                    $('.errorcodigo').html("<p class='alert alert-danger'>Código e campo obrigatório<p>");
                    return false;
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
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html('');
                    $('.erroroperadora').html('');
                    $('.erroradministradora').html('');
                    $('.errorcodigo').html("");
                    $('.errorfaixas').html("<p class='alert alert-danger'>Pelo Menos 1 faixa etária deve ser preenchida</p>")
                    return false;
                }

                if($("#coparticipacao").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html('');
                    $('.erroroperadora').html('');
                    $('.erroradministradora').html('');
                    $('.errorcodigo').html("");
                    $('.errorfaixas').html("");
                    $('.errorcoparticipacao').html("<p class='alert alert-danger'>Coparticipacao e campo obrigatorio</p>");
                    return false;
                }

                if($("#odonto").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html('');
                    $('.erroroperadora').html('');
                    $('.erroradministradora').html('');
                    $('.errorcodigo').html("");
                    $('.errorfaixas').html("");
                    $('.errorcoparticipacao').html("");
                    $('.errorodonto').html("<p class='alert alert-danger'>Odonto e campo obrigatorio</p>");
                    return false;
                }

                if($("#plano").val() == "") {
                    $(this).val('');
                    $('.errorcliente').html('');
                    $('.errorcpf').html('');
                    $('.errordatanascimento').html('');
                    $('.erroremail').html('');
                    $('.errorcidade').html('');
                    $('.erroroperadora').html('');
                    $('.erroradministradora').html('');
                    $('.errorcodigo').html("");
                    $('.errorfaixas').html("");
                    $('.errorcoparticipacao').html("");
                    $('.errorodonto').html("");
                    $('.errorplano').html("<p class='alert alert-danger'>Plano e campo obrigatorio</p>");
                    return false;
                }
           



                $.ajax({
                    method:"POST",
                    data: {
                       cidade:$("#cidade").val(),
                       operadora: $("#operadora").val(),
                       administradora: $("#administradora").val(),
                       coparticipacao: $("#coparticipacao").val(),
                       odonto: $('#odonto').val(),
                       acomodacao: $(this).val(),
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
                        '10': $("#faixa-input-59").val() 
                       }
                    },
                    url:"{{route('contrato.montarContratoSemOrcamento')}}",
                    success:function(res) {
                        
                        if(res == "nada") {
                            // $(this).val('');
                            $('#acomodacao').val('');
                            $('.valores').empty().slideDown('fast',function(){
                                $(this).html('<p class="alert alert-danger text-center">Com esses parametros,não planos cadastrados, tente outros</p>')
                            });
                        } else {
                            
                            $('.valores').html('');
                            $('.valores').html("<label for='valor'>Valor:</label><input type='text' name='valor' id='valor' class='form-control' value="+res+">")
                            $('.enviar_contrato_pf').removeAttr('disabled');
                        }
                        
                    }
                });  
            });
           
           



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
