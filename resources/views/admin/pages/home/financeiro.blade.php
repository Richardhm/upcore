@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard - Financeiro</h1>
@stop

@section('content')

<section class="content">
    
    <section class="financeiro_topo">
        <div class="financeiro_mes_atual bg-dark">
            <div>
                <p>Periodo Total Vidas</p>
                
            </div>

            <div>
                <p>Julho/2022 220</p>
                
            </div>
        </div>
        <div class="financeiro_search_mes bg-warning">
            <select name="" id="">
                <option value="">---Escolha o Mês---</option>
                <option value="">Julho</option>
            </select>
            <select name="" id="">
                <option value="">---Escolha o Ano---</option>
                <option value="">2022</option>
            </select>
        </div>
        <div class="financeiro_resumo_mes bg-secondary">
            <div>
                <p>Individual 100 R$ 100,00</p>
                
            </div>

            <div>
                <p>Coletivo 120 R$ 2000,00</p>
                
            </div>
            <div>
                <p>- Alter 80 R$ 1000,00</p>
                
            </div>
            <div>
                <p>- Allcare 20 R$ 500,00</p>
                
            </div>
            <div>
                <p>- Qualicorp 20 R$ 500,00</p>
               
            </div>
            <div>
                <p>- Empresarial 0 R$ 0,00</p>
                
            </div>
        </div>
    </section>

</section>    


<section class="financeiro_aguardando_pagamento">
    <div>
        <p class="financeiro_aguardando_pagamento_total"><span>8</span> <span>R$ 1000,00</span></p>
        <p>Aguardando Boleto Coletivo</p>
        <p class="financeiro_aguardando_pagamento_vidas">Vidas 9</p>
    </div>
    
    <div>
        <p class="financeiro_aguardando_pagamento_total"><span>9</span> <span>R$ 2000,00</span></p>
        <p>Aguardando Pag. Adesão Coletivo</p>
        <p class="financeiro_aguardando_pagamento_vidas">Vidas 22</p>
    </div>

    <div>
        <p class="financeiro_aguardando_pagamento_total"><span>10</span> <span>R$ 800,00</span></p>
        <p>Aguardando Pag. Plano Individual</p>
        <p class="financeiro_aguardando_pagamento_vidas">Vidas 22</p>
    </div>

    <div>
        <p class="financeiro_aguardando_pagamento_total"><span>10</span> <span>R$ 800,00</span></p>
        <p>Aguardando Pagamento Vigencia</p>
        <p class="financeiro_aguardando_pagamento_vidas">Vidas 22</p>
    </div>

    <div>
        <p class="financeiro_aguardando_pagamento_total"><span>1</span> <span>R$ 300,00</span></p>
        <p>Aguardando Pagamento</p>
        <p class="financeiro_aguardando_pagamento_vidas">Vidas 10</p>
    </div>
 
</section>

<section class="financeiro_container_financeiro">
    <div class="financeiro_container_financeiro_user">
        <div class="financeiro_container_financeiro_user_image">
            <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="50" height="50" alt="User Image">
            <p>João</p>
            
        </div>
        <div class="financeiro_container_financeiro_user_vidas">
            <p><span>Vidas</span><span>35</span> <span>R$ 2000,00</span></p>
        </div>
    </div>
    <div class="financeiro_container_financeiro_resumo">
        <p>Individual 10 R$ 1500,00</p>
        <p>Coletivo 25 R$ 1500,00</p>
        <p>Empresarial 0 R$ 1500,00</p>
    </div>
</section>





@stop

@section('js')
    
@stop        

@section('css')
    <style>
        .financeiro_topo {
            display:flex;
            justify-content: space-between
        }
        .financeiro_mes_atual {
            display: flex;
            flex-direction: column;
            flex-basis: 33%;
        }
        .financeiro_mes_atual div {
            display:flex;
            justify-content: space-between;
        }
        .financeiro_search_mes {
            display: flex;
            flex-direction: column;
            flex-basis: 33%;
        }
        .financeiro_resumo_mes {
            display:flex;
            flex-direction: column;
            flex-basis: 33%;
        }
        .financeiro_resumo_mes div {
            display:flex;
        }
        .financeiro_aguardando_pagamento {
            display:flex;
            margin:10px 0;
            
        }
        .financeiro_aguardando_pagamento div {
            display:flex;
            flex-basis: 20%;
            margin-right:1px;
            flex-direction: column;
            background-color: #666;
        }
        .financeiro_aguardando_pagamento_total {
            display: flex;
            justify-content: space-between;
        }
        .financeiro_aguardando_pagamento_vidas {
            display: flex;
            justify-content: flex-end;
        }
        .financeiro_container_financeiro {
            display: flex;
            flex-direction: column;
            flex-basis: 20%;
            background-color: red;
        }
        .financeiro_container_financeiro_user_vidas p{
            display: flex;
            flex-direction: column;
        }
        .financeiro_container_financeiro_user {
            display: flex;
            justify-content: space-between;
        }
    </style>
@stop

