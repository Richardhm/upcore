@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard - Financeiro</h1>
@stop

@section('content_top_nav_right')
    <li class="nav-item"><a href="{{route('financeiro.cadastrarJuridico')}}" class="nav-link">Cadastrar Pessoa Juridica</a></li>
@stop



@section('content')

@if(session('message'))
    <div class="alert alert-success text-center">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="text-white font-weight-bold">&times;</span>
        </button>
    </div>
@endif


<main class="principal">

    <section class="container-fluid">
        <section class="d-flex">
            <div class="bg-teal d-flex rounded mr-auto flex-column w-25" style="border:3px solid black;">
                <p class="d-flex mb-auto justify-content-between border-bottom"><span class="ml-3 mt-3">Periodo</span><span class="mr-3 mt-3">Total Vidas</span></p>
                <p  class="d-flex justify-content-between border-top"><span class="ml-3">{{$mes}}/2022</span><span class="mr-5" style="color:black;font-size:1.1em;"><b><u><i>{{$totalGeralVidas}}</i></u></b></span></p>                
            </div>
            <div class="bg-warning d-flex flex-column align-self-start">
                <select name="escolher_mes" id="escolher_mes" class="form-control">
                    <option value="">---Escolha o Mês---</option>
                    <option value="01">Janeiro</option>
                    <option value="02">Fevereiro</option>
                    <option value="03">Março</option>
                    <option value="04">Abril</option>
                    <option value="05">Maio</option>
                    <option value="06">Junho</option>
                    <option value="07">Julho</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
                <select name="escolher_ano" id="escolher_ano" class="form-control">
                    <option value="">---Escolha o Ano---</option>
                    <option value="2022">2022</option>
                </select>
                <input type="button" value="Pesquisar" class="bg-success rounded" name="pesquisar" id="pesquisar">
            </div>
            <div class="bg-olive d-flex flex-column w-25 rounded px-2">
                    <span class="d-flex justify-content-between"><span>Individual</span><span>{{$totalVidasIndividual}}</span><span>R$ {{number_format($totalIndividual,2,",",".")}}</span></span>
                    <span class="d-flex justify-content-between"><span>Coletivo</span><span>{{$totalVidasColetivo}}</span><span>R$ {{number_format($totalColetivo,2,",",".")}}</span></span>  
                    @foreach($administradorasVidaTotal as $add)
                        <span class="d-flex justify-content-around"><span>- {{$add->nome}}</span><span>{{$add->qte}}</span><span>R$ {{number_format($add->valores,2,",",".")}}</span></span>
                    @endforeach
            </div>
        </section>
    </section>    


    <section class="container-fluid mt-3">
        <div class="d-flex">                 
            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between">
                    <h3 class="ml-2">{{$quantidade_aguardando_boleto_coletivo}}</h3>
                    <p class="align-self-center mr-2">R$ {{number_format($aguardando_boleto_coletivo_total,2,",",".")}}</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;"><a href="{{route('financeiro.aguardandoboletocoletivo')}}" class="text-dark">Aguardando Boleto Coletivo</a></h6>
                <div class="d-flex justify-content-end mr-2">
                    <span>Vidas: &nbsp; <b>{{$aguardando_boleto_coletivo_vidas ?? 0}}</b></span>
                </div>
            </div>
            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between">
                    <h3 class="ml-2">{{$quantidade_aguardando_pagamento_adesao_coletivo}}</h3>
                    <p class="align-self-center mr-2">R$ {{number_format($aguardando_pagamento_boleto_coletivo_total,2,",",".")}}</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;"><a href="{{route('financeiro.aguardandoPagamentoboletocoletivo')}}" class="text-dark">Aguardando Pag. Adesão Coletivo</a></h6>
                <div class="d-flex justify-content-between justify-content-end mr-2">
                    @if($atrasadoAguardandoPagAdesaoColetivo >= 1)
                        <span class="badge badge-danger ml-1">Atrasado: {{$atrasadoAguardandoPagAdesaoColetivo}}</span>    
                    @endif
                    <span class="ml-auto">Vidas: &nbsp; <b>{{$aguardando_pagamento_boleto_coletivo_vidas ?? 0}}</b></span>
                </div>
            </div>
            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between border-bottom">
                    <h3>{{$quantidade_pagamento_vigencia}}</h3>
                    <p class="align-self-center mr-2">R$ {{number_format($aguardando_pagamento_vigencia_total,2,",",".")}}</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;"><a href="{{route('financeiro.aguardandoPagamentoVigencia')}}" class="text-dark">Aguardando Pag. Vigencia</a></h6>
                <div class="d-flex justify-content-between mr-2">
                    @if($atrasadoAguardandoPagVigenciaColetivo >= 1)
                    <span class="badge badge-danger ml-1">Atrasado: {{$atrasadoAguardandoPagVigenciaColetivo}}</span>
                    @endif
                    <span class="ml-auto">Vidas: &nbsp; <b>{{$aguardando_pagamento_vigencia_vidas ?? 0}}</b></span>
                </div>
            </div>    
            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between">
                    <h3>{{$quantidade_aguardando_pagamento_plano_individual}}</h3>
                    <p class="align-self-center mr-2">R$ {{number_format($aguardando_individual_total,2,",",".")}}</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;"><a href="{{route('financeiro.planoindividual')}}" class="text-dark">Aguardando Pag. Plano individual</a></h6>
                <div class="d-flex justify-content-between mr-2">
                    @if($atrasadoPlanoIndividual >= 1)
                        <span class="badge badge-danger ml-1">Atrasado: {{$atrasadoPlanoIndividual}}</span>
                    @endif
                    <span class="ml-auto">Vidas: &nbsp; <b>{{$aguardando_individual_vidas ?? 0}}</b></span>
                </div>
            </div>    
            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between">
                    <h3>{{$quantidade_pagamento_empresarial}}</h3>
                    <p class="align-self-center mr-2">R$ {{number_format($valor_aguardando_pagamento_empresarial,2,",",".")}}</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;"><a href="{{route('financeiro.empresarial')}}" style="color:black;">Aguardando Pag. Empresarial</a></h6>
                <div class="d-flex">
                    <span class="ml-auto mr-1">Vidas: &nbsp; <b>{{$qtd_vidas_aguardando_pagamento_empresarial ?? 0}}</b></span>
                </div>
            </div>    
        </div>    
    </section>

    <section class="d-flex">
        @foreach($primeiros as $k => $pp)
            <div class="financeiro_container_financeiro_user flex-fill bg-navy mr-1 rounded">
                <div class="d-flex justify-content-around  text-center mt-3  border-bottom">
                    <div>
                        <span style="font-size:1.5em;background-color:white;color:black;">{{$k+1}}º</span>
                    </div>
                    <div class="financeiro_container_financeiro_user_image">
                        <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="50" height="50" alt="User Image">
                        <p>{{$pp->vendedor}}</p>
                    </div>
                    <div class="financeiro_container_financeiro_user_vidas d-flex flex-column">
                        <span>Vidas</span>
                        <span>{{$pp->total_vidas}}</span> 
                        <span>R$ {{number_format($pp->total_valor,2,",",".")}}</span>
                    </div>
                </div>
                <div class="financeiro_container_financeiro_resumo">
                    <p class="d-flex justify-content-around"><span>Individual</span><span>{{$pp->vidas_individual}}</span><span>R$ {{$pp->valor_individual}}</span></p>
                    <p class="d-flex justify-content-around"><span>Coletivo</span><span>{{$pp->vidas_coletivo}}</span><span>R$ {{$pp->valor_coletivo}}</span></p>
                    <p class="d-flex justify-content-around"><span>Empresarial</span><span>0</span><span>R$ 1500,00</span></p>
                </div>
            </div>
        @endforeach   
    </section>

    <section class="mt-3">
        <h3 class="text-center" style="border:3px solid black;">Ranking Vendas</h3>
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th class="text-center">Vendedor</th>
                    <th class="text-center">Individual</th>
                    <th class="text-center">Allcare</th>
                    <th class="text-center">Qualicorp</th>
                    <th class="text-center">Alter</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i=0;
                @endphp
                @foreach($ranking as $r)
                    @php
                        $i++
                    @endphp
                    <tr>
                        <td><b>{{$i}}</b></td>
                        <td>{{$r->usuarios}}</td>
                        <td>{{$r->quantidade_hapvida}} | R$ {{number_format($r->hapvida,2,",",".")}}</td>
                        <td>{{$r->quantidade_allcare}} | R$ {{number_format($r->allcare,2,",",".")}}</td>
                        <td>{{$r->quantidade_qualicorp}} | R$ {{number_format($r->qualicorp,2,",",".")}}</td>
                        <td>{{$r->quantidade_alter}} | R$ {{number_format($r->alters,2,",",".")}}</td>
                        <td>R$ {{number_format($r->total,2,",",".")}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>


</main>    
   
<main id="resposta">
    
</main>    



@stop

@section('js')
    <script>
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $("body").on('click',"input[name='pesquisar']",function(){
            let mes = $('body').find("select[name='escolher_mes']").val();
            let ano = $('body').find("select[name='escolher_ano']").val();
            console.log(mes);
            console.log(ano);
            $.ajax({
                url:"{{route('financeiro.mesChange')}}",
                method:"POST",
                data:"mes="+mes+"&ano="+ano+"&change=true",
                success:function(res) {
                    $('.principal').slideUp(800,function(){
                        $(this).remove();
                        $("#resposta").html(res).delay(500).slideDown('300')
                    });
                }
            });
        });

        
    </script>    
@stop        

@section('css')
   <style>
        #resposta {
            display: none;
        }
   </style> 
@stop

