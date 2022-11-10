@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Chartjs', true)
@section('content_header')
    <h1 class="text-white">Dashboard</h1>
@stop
@section('content_top_nav_right')

<!-- https://www.chartjs.org/docs/2.7.3/ -->


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

    <section class="content">

        <!----------HEADER DASHBOARD----------->
        <section class="header">
            <!-----TABLE----->
            <div class="tabela" style="margin:0;padding:0;">
                <table class="table table-sm w-100" style="background-color:rgba(0,0,0,0.5);color:white;">
                    <thead>
                        <tr class="text-center">
                            <th colspan="5">Novembro / 2022</th>
                        </tr>
                        <tr>
                            <th>Plano</th>
                            <th>Meta</th>
                            <th>CAD.</th>
                            <th>Real.</th>
                            <th>Prev.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Individual</th>
                            <td>10</td>
                            <td>20</td>
                            <td>30</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <th>Coletivo</th>
                            <td>10</td>
                            <td>20</td>
                            <td>30</td>
                            <td>40</td>
                        </tr>    
                        <tr>
                            <th>Empresarial</th>
                            <td>10</td>
                            <td>20</td>
                            <td>30</td>
                            <td>40</td>
                        </tr>    
                        <tr>
                            <th>Total</th>
                            <td>10</td>
                            <td>20</td>
                            <td>30</td>
                            <td>40</td>
                        </tr>    
                            
                        
                    </tbody>
                </table>
            </div>    
            <!-----FIM TABLE----->

            <!-----GRAFICOS--------->
            <div class="graficos bg-white">
                
            </div>
            <!-----FIM GRAFICOS----->

            <!-----CARDS--------->
            <div class="cards">

                <div class="vendas_mes">

                </div>
                
                <div class="cancelados_mes">
                        
                </div>

            </div>
            <!-----CARDS--------->


        </section>
        <!----------FIM HEADER DASHBOARD----------->


        <!---------------LEMBRETES-------------------------->
        <section class="lembretes">
            <!-----LINHA 01------>
            <article class="linha_01">
                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>Tarefas</span>
                    <span>{{$qtdHoje}}</span>
                    <span>Hoje</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>Tarefas</span>
                    <span>{{$qtdAtrasado}}</span>
                    <span>Atrasadas</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>Plantão Vendas</span>
                    <span>0</span>
                    <span>Hoje</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>Plantão Vendas</span>
                    <span>0</span>
                    <span>Atrasadas</span>
                </div>
            </article>
            <!-----FIM LINHA 01------>

            <!-----LINHA 02------>
            <article class="linha_02">
                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>ATENDIMENTO INICIADO</span>
                    <span>{{$qtdAtendimentoIniciadoHoje}}</span>
                    <span>HOJE</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>ATENDIMENTO INICIADO</span>
                    <span>{{$qtdAtendimentoIniciadoAtrasada}}</span>
                    <span>ATRASADAS</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>PROSPECÇÃO</span>
                    <span>{{$qtdProspeccaoHoje}}</span>
                    <span>HOJE</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>PROSPECÇÃO</span>
                    <span>{{$qtdProspeccaoAtrasada}}</span>
                    <span>ATRASADAS</span>
                </div>
            </article>
            <!-----FIM LINHA 02------>

             <!-----LINHA 03------>
             <main class="linha_03">
                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>INTERESSADO *</span>
                    <span>{{$qtdClienteInteressadoFrio}}</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>INTERESSADO **</span>
                    <span>{{$qtdClienteInteressadoMorna}}</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>INTERESSADO ***</span>
                    <span>{{$qtdClienteInteressadoQuente}}</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>AGUARD. DOCUMENTAÇÃO</span>
                    <span>{{$qtdAguardandoDocumentacao}}</span>
                </div>
            </main>
            <!-----FIM LINHA 03------>

            <!-----LINHA 04------>    
            <div class="linha_04">
                <section class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <div>
                        <span>{{$qtdAguardandoBoleto->qtd}}</span>
                        <span>R$ {{number_format($qtdAguardandoBoleto->soma,2,",",".")}}</span>
                    </div>
                    <span class="title">AGUARDANDO BOLETO</span>
                    <span>VIDAS {{$qtdAguardandoBoleto->vidas}}</span>
                </section>

                <section class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <div>
                        <span>{{$qtdPagamentoAdesao->qtd}}</span>
                        <span>R$ {{number_format($qtdPagamentoAdesao->soma,2,",",".")}}</span>
                    </div>
                    <span class="title">PAGAMENTO ADESÃO</span>
                    <span>VIDAS {{$qtdPagamentoAdesao->vidas}}</span>
                </section>

                <section class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <div>
                        <span>{{$qtdPagamentoVigencia->qtd}}</span>
                        <span>R$ {{number_format($qtdPagamentoVigencia->soma,2,",",".")}}</span>
                    </div>
                    <span class="title">PAGAMENTO VIGÊNCIA</span>
                    <span>VIDAS {{$qtdPagamentoVigencia->vidas}}</span>
                </section>

                <section class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <div>
                        <span>{{$qtdPagamentoIndividual->qtd}}</span>
                        <span>R$ {{number_format($qtdPagamentoIndividual->soma,2,",",".")}}</span>
                    </div>
                    <span class="title">PAGAMENTO INDIVIDUAL</span>
                    <span>VIDAS {{$qtdPagamentoIndividual->vidas}}</span>
                </section>
            </div>
            <!-----FIM LINHA 04------>

            <!-----LINHA 05------>
            <article class="linha_05">
                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>CONTRATOS FINALIZADOS</span>
                    <span>{{$contratosFinalizados->quantidade}}</span>
                    <span>MÊS</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>CONTRATOS PENDENTES</span>
                    <span>{{$contratosPendentes->quantidade}}</span>
                    <span>MÊS</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>LEADS SEM CONTATO</span>
                    <span>25</span>
                    <span>MÊS</span>
                </div>

                <div class="small-box" style="margin-bottom:5px;background-color:rgba(0,0,0,0.4);color:#FFF;border:1px solid white;">
                    <span>CLIENTES PERDIDOS</span>
                    <span>{{$clientePerdidos}}</span>
                    <span>MÊS</span>
                </div>
            </article>
            <!-----FIM LINHA 05------>
        </section>
        <!---------------FIM LEMBRETES---------------------->    


        <!---------------------DETALHES----------------------------->
        <section class="detalhes">

             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">LEADS NO MÊS</h6>
                <div class="detalhes-grafico">
                    <canvas id="leads_mes" width="330" height="200" 
                        data-chart-background-color="{{$coresHexadecimais}}" 
                        data-chart-quantidade-valores="{{$leads_grafico_quantidade}}"
                        data-chart-label-leads="{{$leads_grafico_label}}"
                    ></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    @foreach($leads_grafico as $ll)
                        <div class="d-flex justify-content-between">
                            <p style="flex-basis:30%" class="ml-1">{{$ll->nome}}</p> 
                            <p>{{$ll->quantidade}}</p> 
                            <p class="mr-1">+55%</p> 
                        </div>
                    @endforeach
                </div>
             </div>   

             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">CONTRATOS NO MÊS</h6>
                <div class="detalhes-grafico">
                    <canvas id="contratos_mes" width="330" height="200"
                        data-chart-background-color="{{$coresHexadecimais}}" 
                        data-contratos-mes="{{$contratos_mes_quantidade}}"
                        data-contratos-label="{{$contratos_mes_label}}"
                    ></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    @foreach($contratos_mes as $cc)
                        <div class="d-flex justify-content-between">
                            <p style="flex-basis:30%" class="ml-1">{{$cc->nome}}</p> 
                            <p>{{$cc->quantidade}}</p> 
                            <p class="mr-1">+55%</p> 
                        </div>
                    @endforeach

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">VENDA POR PLANO VIDAS</h6>
                <div class="detalhes-grafico">
                    <canvas id="vendas_por_planos_vidas" 
                    data-vendas-por-planos-vidas-quantidade="{{$vendas_por_planos_vidas_quantidade}}"
                    data-vendas-por-planos-vidas-label="{{$vendas_por_planos_vidas_label}}"
                    width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    @foreach($vendas_por_planos_vidas as $vv)
                        <div class="d-flex justify-content-between">
                            <p style="flex-basis:40%;font-size:1em;" class="ml-1">{{$vv->plano}}</p> 
                            <p>{{$vv->quantidade}}</p> 
                            <p class="mr-1">+55%</p> 
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between">
                        <p style="flex-basis:40%;font-size:1em;" class="ml-1">Empresarial</p> 
                        <p>0</p> 
                        <p class="mr-1">00%</p> 
                    </div>    
                    

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">VENDA POR PLANO VALOR</h6>
                <div class="detalhes-grafico">
                    <canvas id="vendas_por_planos_valor" width="330" height="200"
                    data-vendas-por-planos-valor-quantidade="{{$vendas_por_planos_vidas_valor_quantidade}}"
                    data-vendas-por-planos-valor-label="{{$vendas_por_planos_vidas_valor_label}}"
                    
                    ></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    @foreach($vendas_por_planos_vidas_valor as $pv)
                        <div class="d-flex justify-content-between">
                            <p style="flex-basis:40%;font-size:1em;" class="ml-1">{{$pv->plano}}</p> 
                            <p>R$ {{number_format($pv->valor,2,",",".")}}</p> 
                            <p class="mr-1">+55%</p> 
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between">
                        <p style="flex-basis:40%;font-size:1em;" class="ml-1">Empresarial</p> 
                        <p>R$ 00</p> 
                        <p class="mr-1">0%</p> 
                    </div>
                </div>
             </div>   
        </section>    
        <!---------------------FIM DETALHES------------------------->    
        <section class="detalhes">
             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">VENDA COLETIVO POR ADMINISTRADORA</h6>
                <div class="detalhes-grafico">
                



                    <canvas id="vendas_coletivo_por_administradora" width="330" height="200"
                        data-vendas-por-administradoras-quantidade="{{$vendas_por_administradoras_quantidade}}"
                        data-vendas-por-administradoras-label="{{$vendas_por_administradoras_label}}"
                    ></canvas>
                </div>
                <div class="detalhes-porcentagem">
                   @foreach($vendas_por_administradoras as $aa)
                        <div class="d-flex justify-content-between">
                            <p style="flex-basis:40%;font-size:1em;" class="ml-1">{{$aa->nome}}</p> 
                            <p>{{$aa->quantidade}}</p> 
                            <p class="mr-1">+55%</p> 
                        </div>
                   @endforeach
                </div>
             </div>   
             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">TICKET MÈDIO MÊS</h6>
                <div class="detalhes-grafico">
                    <canvas id="ticket_medio_mes" width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    <div>
                        <p>Individual</p> 
                        <p>15</p> 
                        <p>+55%</p> 
                    </div>
                    <div>
                        <p>Coletivo Por Adesão</p> 
                        <p>15</p> 
                        <p>+25%</p> 
                    </div>
                    <div>
                        <p>Empresarial</p> 
                        <p>23</p> 
                        <p>+15%</p> 
                    </div>    
                    

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">VENDA POR FAIXA ETÁRIA MÊS</h6>
                <div class="detalhes-grafico">
                    <canvas id="venda_por_faixa_etaria_mes" width="330" height="200"
                        data-vendas-por-faixa-etaria-label="{{$vendas_por_faixa_etaria_label}}"
                        data-vendas-por-faixa-etaria-quantidade="{{$vendas_por_faixa_etaria_quantidade}}"
                    ></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    @foreach($vendas_por_faixa_etaria as $vf)
                        <div class="d-flex justify-content-between">
                            <p style="flex-basis:40%;font-size:1em;" class="ml-1">{{$vf->faixa}}</p> 
                            <p>{{$vf->quantidade}}</p> 
                            <p class="mr-1">+55%</p> 
                        </div>
                    @endforeach

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6 class="text-center py-1 border-bottom">TAXA CONVERSÃO</h6>
                <div class="detalhes-grafico">
                    <canvas id="taxa_conversao" width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    <div>
                        <p>Facebook</p> 
                        <p>15</p> 
                        <p>+55%</p> 
                    </div>
                    <div>
                        <p>Instagram</p> 
                        <p>15</p> 
                        <p>+25%</p> 
                    </div>
                    <div>
                        <p>Indicação</p> 
                        <p>23</p> 
                        <p>+15%</p> 
                    </div>    
                    <div>
                        <p>Google</p> 
                        <p>14</p> 
                        <p>+5%</p> 
                    </div>

                </div>
             </div>   
        </section>    
    

        <section class="grafico_anual" style="width:100%;height:400px;margin-bottom:20px;background-color:rgba(0,0,0,0.5);">
            <h3 class="text-center text-white">VENDA ANUAL</h3>
            <canvas id="anual" width="1400" height="350"></canvas>
        </section>

    

    </section>

@stop





@section('js')
    <script>
        $(function(){
            let anual = $("#anual") 
            new Chart(anual, {
                type: 'bar',
                data: {
                    labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun","Jul","Ago","Set","Out","Nov","Dez"],
                    datasets: [{
                        label: 'Vendas',
                        data: [12, 19, 3, 5, 10, 3,25,30,7,9,4,15],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(80, 255, 0, 0.2)',
                            'rgba(0, 255, 40, 0.2)',
                            'rgba(255, 225, 95, 0.2)',
                            'rgba(75, 80, 70, 0.2)',
                            'rgba(152, 125, 50, 0.2)',
                            'rgba(80, 200, 30, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(80, 255, 0, 1)',
                            'rgba(0, 255, 40, 1)',
                            'rgba(255, 225, 95, 1)',
                            'rgba(75, 80, 70, 1)',
                            'rgba(152, 125, 50, 1)',
                            'rgba(80, 200, 30, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false
                }
            });

            let leads_mes = $("#leads_mes");
            new Chart(
                leads_mes,
                {   
                    "type":"doughnut",
                    "data":{
                        "labels":leads_mes.data('chart-label-leads').split("|"),
                        "datasets":[{
                            "label":"Leads do Mês",
                            "data":leads_mes.data('chart-quantidade-valores').split("|"),
                            "backgroundColor":leads_mes.data('chart-background-color').split("|")
                        }]
                    },
                    options: {
                        responsive: false
                    }
                }
            )

            
            let contratos_mes = $("#contratos_mes");
            new Chart(
                contratos_mes,
                {   
                    "type":"doughnut",
                    
                    "data":{
                        "labels":contratos_mes.data('contratos-label').split("|"),
                        "datasets":[{
                            "label":"Contratos do Mês",
                            "data":contratos_mes.data('contratos-mes').split("|"),
                            "backgroundColor":contratos_mes.data('chart-background-color').split("|")
                        }]
                    },
                    options: {
                        responsive: false
                    }
                }
            )

           
            let vendas_por_planos = $("#vendas_por_planos_vidas");
            new Chart(
                vendas_por_planos,
                {   
                    "type":"doughnut",
                    "data":{
                        "labels":vendas_por_planos.data('vendas-por-planos-vidas-label').split("|"),
                        "datasets":[{
                            "label":"Vendas Por Planos",
                            "data":vendas_por_planos.data('vendas-por-planos-vidas-quantidade').split("|"),
                            "backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)"]}
                        ]
                    },
                    options: {
                        responsive: false
                    }
                }
            )

            

            let vendas_por_plano_valor = $("#vendas_por_planos_valor");    
            new Chart(
                vendas_por_plano_valor,
                {   
                    "type":"doughnut",
                    "data":{
                        "labels":vendas_por_plano_valor.data('vendas-por-planos-valor-label').split("|"),
                        "datasets":[{
                            "label":"Vendas Por Planos Valores",
                            "data":vendas_por_plano_valor.data('vendas-por-planos-valor-quantidade').split("|"),
                            "backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)"]}
                        ]
                    },
                    options: {
                        responsive: false
                    }
                }
            )
            
            let vendas_coletivo_por_administradora = $("#vendas_coletivo_por_administradora");
            new Chart(
                vendas_coletivo_por_administradora,
                {   
                    "type":"doughnut",
                    "data":{
                        "labels":vendas_coletivo_por_administradora.data('vendas-por-administradoras-label').split("|"),
                        "datasets":[{
                            "label":"Vendas Coletivas Por Administradora",
                            "data":vendas_coletivo_por_administradora.data('vendas-por-administradoras-quantidade').split("|"),
                            "backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)"]}
                        ]
                    },
                    options: {
                        responsive: false
                    }
                }
            )
            
            
            new Chart(
                document.getElementById("ticket_medio_mes"),
                {   
                    "type":"doughnut",
                    "data":{
                        "datasets":[{
                            "label":"My First Dataset",
                            "data":[300,50,100],
                            "backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)"]}
                        ]
                    },
                    options: {
                        responsive: false
                    }
                }
            )
            
            let vendas_por_faixa_etaria = $("#venda_por_faixa_etaria_mes")
            new Chart(
                vendas_por_faixa_etaria,
                {   
                    "type":"doughnut",
                    "data":{
                        "labels":vendas_por_faixa_etaria.data('vendas-por-faixa-etaria-label').split("|"),
                        "datasets":[{
                            "label":"Vendas Por Faixa Etaria",
                            "data":vendas_por_faixa_etaria.data('vendas-por-faixa-etaria-quantidade').split("|"),
                            "backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)","rgb(255, 255, 86)","rgb(85, 105, 95)","rgb(5, 125, 95)"]}
                        ]
                    },
                    options: {
                        responsive: false
                    }
                }
            )
            
            new Chart(
                document.getElementById("taxa_conversao"),
                {   
                    "type":"doughnut",
                    "data":{
                        "datasets":[{
                            "label":"My First Dataset",
                            "data":[300,50,100],
                            "backgroundColor":["rgb(255, 99, 132)","rgb(54, 162, 235)","rgb(255, 205, 86)"]}
                        ]
                    },
                    options: {
                        responsive: false
                    }
                }
            )




    });         

    </script>
@stop        




@section('css')
    <style>   
        .header {display:flex;justify-content: space-between;}
        .tabela {flex-basis:30%;margin-bottom: 0 !important;}
        .tabela table {flex-basis:100%;}
        .graficos {border:1px solid black;margin:0 2%;flex-basis:30%;}
        .cards {flex-basis:30%;border:1px solid black;display: flex;justify-content: space-between;}

        .vendas_mes {background-color: white;flex-basis:45%;display: flex;}
        .cancelados_mes {background-color: white;flex-basis: 45%;display: flex;}

        .lembretes {margin-top: 10px;display:flex;justify-content: space-between;flex-direction: column;}
        .lembretes article {margin-top: 5px;flex-basis: 100%;display: flex;justify-content: space-between;}
        .lembretes article div {display: flex;flex-direction: column;flex-basis: 24%;background-color: white;}

        .lembretes div span:nth-of-type(1){display: flex;font-size:1.1em;}
        .lembretes div span:nth-of-type(2){display: flex;justify-content: center;font-size:1.1em;}
        .lembretes div span:nth-of-type(3){display: flex;justify-content: end;font-size:1.1em;}  



        /* .lembretes article div:nth-child(2) {margin:0 1%;} */
        /* 
        .lembretes article div:nth-child(3) {margin:0 1% 0 0;}
         */
        .lembretes main {display: flex;margin-top: 5px;}
        .lembretes main div {display: flex;background-color: white;flex-basis: 25%;justify-content: space-between;padding:10px 0;}
        .lembretes main div:nth-child(2) {margin:0 1%;}
        .lembretes main div:nth-child(3) {margin:0 1% 0 0;}

        .linha_04 {display: flex;margin-top:5px;}
        .linha_04 section {display: flex;background-color:#FFF;flex-basis: 25%;flex-direction: column;}
        .linha_04 section div {display: flex;justify-content: space-between;} 
        .linha_04 section .title {display: flex;justify-content: center;}

        .linha_04 section span:nth-child(3) {display: flex;justify-content: end;}
        .linha_04 section:nth-child(2) {margin:0 1%;}
        .linha_04 section:nth-child(3) {margin:0 1% 0 0;}

        .detalhes {display: flex;flex-basis: 100%;margin-top: 5px;align-items: stretch;justify-content: space-between;}
        .detalhes .cards-detalhes {margin-bottom:8px;border-radius:5px;border:1px solid white;flex-basis: 24%;background-color:rgba(0,0,0,0.5);color:#FFF;box-shadow:rgba(0,0,0,0.8) 0.6em 0.7em 5px;}
        /* .detalhes .detalhes-grafico {height:220px;} */
        /* .detalhes .cards-detalhes:nth-child(2) {margin:0 1%;}
        .detalhes .cards-detalhes:nth-child(3) {margin:0 1% 0 0;} */
        .detalhes .detalhes-porcentagem {display:flex;flex-direction: column;}
        .detalhes-porcentagem div {display: flex;justify-content: space-between;}


        .grafico_anual {height:300px;background-color: #FFF;margin-top: 5px;}
    
    </style>
@stop
