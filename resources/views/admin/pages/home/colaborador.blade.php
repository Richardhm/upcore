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
            <div class="tabela">
                <table class="bg-white w-100">
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
                <div>
                    <span>Tarefas</span>
                    <span>6</span>
                    <span>Hoje</span>
                </div>

                <div>
                    <span>Tarefas</span>
                    <span>5</span>
                    <span>Atrasadas</span>
                </div>

                <div>
                    <span>Plantão Vendas</span>
                    <span>0</span>
                    <span>Hoje</span>
                </div>

                <div>
                    <span>Plantão Vendas</span>
                    <span>32</span>
                    <span>Atrasadas</span>
                </div>
            </article>
            <!-----FIM LINHA 01------>

            <!-----LINHA 02------>
            <article class="linha_02">
                <div>
                    <span>ATENDIMENTO INICIADO</span>
                    <span>5</span>
                    <span>HOJE</span>
                </div>

                <div>
                    <span>ATENDIMENTO INICIADO</span>
                    <span>3</span>
                    <span>ATRASADAS</span>
                </div>

                <div>
                    <span>PROSPECÇÃO</span>
                    <span>2</span>
                    <span>HOJE</span>
                </div>

                <div>
                    <span>PROSPECÇÃO</span>
                    <span>24</span>
                    <span>ATRASADAS</span>
                </div>
            </article>
            <!-----FIM LINHA 02------>

             <!-----LINHA 03------>
             <main class="linha_03">
                <div>
                    <span>INTERESSADO *</span>
                    <span>1</span>
                </div>

                <div>
                    <span>INTERESSADO **</span>
                    <span>2</span>
                </div>

                <div>
                    <span>INTERESSADO ***</span>
                    <span>3</span>
                </div>

                <div>
                    <span>AGUARD. DOCUMENTAÇÃO</span>
                    <span>1</span>
                </div>
            </main>
            <!-----FIM LINHA 03------>

            <!-----LINHA 04------>    
            <div class="linha_04">
                <section>
                    <div>
                        <span>5</span>
                        <span>R$ 500,00</span>
                    </div>
                    <span class="title">AGUARDANDO BOLETO</span>
                    <span>VIDAS 5</span>
                </section>

                <section>
                    <div>
                        <span>5</span>
                        <span>R$ 500,00</span>
                    </div>
                    <span class="title">PAGAMENTO ADESÃO</span>
                    <span>VIDAS 5</span>
                </section>

                <section>
                    <div>
                        <span>5</span>
                        <span>R$ 500,00</span>
                    </div>
                    <span class="title">PAGAMENTO VIGÊNCIA</span>
                    <span>VIDAS 5</span>
                </section>

                <section>
                    <div>
                        <span>5</span>
                        <span>R$ 500,00</span>
                    </div>
                    <span class="title">PAGAMENTO INDIVIDUAL</span>
                    <span>VIDAS 5</span>
                </section>
            </div>
            <!-----FIM LINHA 04------>

            <!-----LINHA 05------>
            <article class="linha_05">
                <div>
                    <span>CONTRATOS FINALIZADOS</span>
                    <span>14</span>
                    <span>MÊS</span>
                </div>

                <div>
                    <span>CONTRATOS PENDENTES</span>
                    <span>20</span>
                    <span>MÊS</span>
                </div>

                <div>
                    <span>LEADS SEM CONTATO</span>
                    <span>25</span>
                    <span>MÊS</span>
                </div>

                <div>
                    <span>CLIENTES PERDIDOS</span>
                    <span>10</span>
                    <span>MÊS</span>
                </div>
            </article>
            <!-----FIM LINHA 05------>
        </section>
        <!---------------FIM LEMBRETES---------------------->    


        <!---------------------DETALHES----------------------------->
        <section class="detalhes">

             <div class="cards-detalhes">
                <h6>LEADS NO MÊS</h6>
                <div class="detalhes-grafico">
                    <canvas id="leads_mes" width="330" height="200" data-chart-background-color="{{$coresHexadecimais}}"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    @foreach($leads_grafico as $ll)
                        <div class="d-flex justify-content-between">
                            <p class="bg-danger" style="flex-basis:30%">{{$ll->nome}}</p> 
                            <p>{{$ll->quantidade}}</p> 
                            <p>+55%</p> 
                        </div>
                    @endforeach
                    

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6>CONTRATOS NO MÊS</h6>
                <div class="detalhes-grafico">
                    <canvas id="contratos_mes" width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    @foreach($leads_grafico as $ll)
                        <div class="d-flex justify-content-between">
                            <p class="bg-danger" style="flex-basis:30%">{{$ll->nome}}</p> 
                            <p>{{$ll->quantidade}}</p> 
                            <p>+55%</p> 
                        </div>
                    @endforeach

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6>VENDA POR PLANO VIDAS</h6>
                <div class="detalhes-grafico">
                    <canvas id="vendas_por_planos_vidas" width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    <div>
                        <p>Individual</p> 
                        <p>25</p> 
                        <p>+55%</p> 
                    </div>
                    <div>
                        <p>Coletivo Por Adesão</p> 
                        <p>18</p> 
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
                <h6>VENDA POR PLANO VALOR</h6>
                <div class="detalhes-grafico">
                    <canvas id="vendas_por_planos_valor" width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    <div>
                        <p>Individual</p> 
                        <p>R$ 1800,00</p> 
                        <p>+55%</p> 
                    </div>
                    <div>
                        <p>Coletivo Por Adesão</p> 
                        <p>R$ 1800,00</p> 
                        <p>+25%</p> 
                    </div>
                    <div>
                        <p>Empresarial</p> 
                        <p>R$ 1800,00</p> 
                        <p>+15%</p> 
                    </div>

                </div>
             </div>   



        </section>    
        



        <!---------------------FIM DETALHES------------------------->    


        <section class="detalhes">

             <div class="cards-detalhes">
                <h6>VENDA COLETIVO POR ADMINISTRADORA</h6>
                <div class="detalhes-grafico">
                    <canvas id="vendas_coletivo_por_administradora" width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    <div>
                        <p>Qualicorp</p> 
                        <p>25</p> 
                        <p>+55%</p> 
                    </div>
                    <div>
                        <p>Alter</p> 
                        <p>18</p> 
                        <p>+25%</p> 
                    </div>
                    <div>
                        <p>Allcare</p> 
                        <p>10</p> 
                        <p>+15%</p> 
                    </div>    
                    

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6>TICKET MÈDIO MÊS</h6>
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
                <h6>VENDA POR FAIXA ETÁRIA MÊS</h6>
                <div class="detalhes-grafico">
                    <canvas id="venda_por_faixa_etaria_mes" width="330" height="200"></canvas>
                </div>
                <div class="detalhes-porcentagem">
                    <div>
                        <p>0-18</p> 
                        <p>5</p> 
                        <p>10%</p> 
                    </div>
                    <div>
                        <p>19-23</p> 
                        <p>8</p> 
                        <p>35%</p> 
                    </div>
                    <div>
                        <p>24-29</p> 
                        <p>23</p> 
                        <p>+15%</p> 
                    </div>    
                    

                </div>
             </div>   

             <div class="cards-detalhes">
                <h6>TAXA CONVERSÃO</h6>
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
    

        <section class="grafico_anual" style="width:100%;height:400px;margin-bottom:20px;">
            <h3>VENDA ANUAL</h3>
            <canvas id="anual" width="1400" height="350"></canvas>
        </section>

    

    </section>

@stop





@section('js')
    <script>
        $(function(){
            new Chart($("#anual"), {
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
                        "datasets":[{
                            "label":"My First Dataset",
                            "data":[300,50,100],
                            "backgroundColor":leads_mes.data('chart-background-color').split("|")
                        }
                        ]
                    },
                    options: {
                        responsive: false
                    }
                }
            )

                    
            
            new Chart(
                document.getElementById("contratos_mes"),
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

            new Chart(
                document.getElementById("vendas_por_planos_vidas"),
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

            
            new Chart(
                document.getElementById("vendas_por_planos_valor"),
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

            
            new Chart(
                document.getElementById("vendas_coletivo_por_administradora"),
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

            
            new Chart(
                document.getElementById("venda_por_faixa_etaria_mes"),
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
        .tabela {flex-basis:30%;}
        .tabela table {flex-basis:100%;background-color: green;}
        .graficos {border:1px solid black;margin:0 2%;flex-basis:30%;}
        .cards {flex-basis:30%;border:1px solid black;display: flex;justify-content: space-between;}

        .vendas_mes {background-color: white;flex-basis:45%;display: flex;}
        .cancelados_mes {background-color: white;flex-basis: 45%;display: flex;}

        .lembretes {margin-top: 10px;display:flex;justify-content: space-between;flex-direction: column;}
        .lembretes article {margin-top: 5px;flex-basis: 100%;display: flex;}
        .lembretes article div {display: flex;flex-direction: column;flex-basis: 25%;background-color: white;}
        .lembretes article div:nth-child(2) {margin:0 1%;}
        .lembretes article div:nth-child(3) {margin:0 1% 0 0;}
        .lembretes div span:nth-of-type(1){display: flex;font-size:1.1em;}
        .lembretes div span:nth-of-type(2){display: flex;justify-content: center;font-size:1.1em;}
        .lembretes div span:nth-of-type(3){display: flex;justify-content: end;font-size:1.1em;}  
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

        .detalhes {display: flex;flex-basis: 100%;margin-top: 5px;}
        .detalhes .cards-detalhes {background-color: #FFF;flex-basis: 25%;}
        .detalhes .detalhes-grafico {height:220px;}
        .detalhes .cards-detalhes:nth-child(2) {margin:0 1%;}
        .detalhes .cards-detalhes:nth-child(3) {margin:0 1% 0 0;}
        .detalhes .detalhes-porcentagem {display:flex;flex-direction: column;}
        .detalhes-porcentagem div {display: flex;justify-content: space-between;}


        .grafico_anual {height:300px;background-color: #FFF;margin-top: 5px;}
    
    </style>
@stop
