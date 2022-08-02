@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard - Financeiro</h1>
@stop

@section('content')

<h1>Dashboard</h1>  

<section class="container-fluid">
    <section class="d-flex">
        <div class="bg-dark d-flex rounded mr-auto flex-column w-25">
            <p class="d-flex mb-auto justify-content-between"><span>Periodo</span><span>Total Vidas</span></p>
            <p  class="d-flex justify-content-between"><span>Julho/2022</span><span>220</span></p>                
        </div>
        <div class="bg-warning d-flex flex-column align-self-start">
            <select name="" id="">
                <option value="">---Escolha o Mês---</option>
                <option value="">Julho</option>
            </select>
            <select name="" id="">
                <option value="">---Escolha o Ano---</option>
                <option value="">2022</option>
            </select>
        </div>
        <div class="bg-secondary d-flex flex-column w-25 rounded px-2">
                <span class="d-flex justify-content-between"><span>Individual</span><span>100</span><span>R$ 100,00</span></span>
                <span class="d-flex justify-content-between"><span>Coletivo</span><span>120</span><span>R$ 2000,00</span></span>
                <span class="d-flex justify-content-around"><span>- Alter</span><span>80</span><span>R$ 1000,00</span></span>
                <span class="d-flex justify-content-around"><span>- Allcare</span><span>20</span><span>R$ 500,00</span></span>
                <span class="d-flex justify-content-around"><span>- Qualicorp</span><span>20</span><span>R$ 500,00</span></span>
                <span class="d-flex justify-content-around"><span>- Empresarial</span><span>0</span><span>R$ 0,00</span></span>
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
                    Vidas: &nbsp; <b>{{$aguardando_boleto_coletivo_vidas ?? 0}}</b>
                </div>
            </div>
             
            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between">
                    <h3 class="ml-2">{{$quantidade_aguardando_pagamento_adesao_coletivo}}</h3>
                    <p class="align-self-center mr-2">R$ {{number_format($aguardando_pagamento_boleto_coletivo_total,2,",",".")}}</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;"><a href="{{route('financeiro.aguardandoPagamentoboletocoletivo')}}" class="text-dark">Aguardando Pag. Adesão Coletivo</a></h6>
                <div class="d-flex justify-content-end mr-2">
                    Vidas: &nbsp; <b>{{$aguardando_pagamento_boleto_coletivo_vidas ?? 0}}</b>
                </div>
            </div>

            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between">
                    <h3>{{$quantidade_aguardando_pagamento_plano_individual}}</h3>
                    <p class="align-self-center mr-2">R$ 1000,00</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;">Aguardando Pag. Plano individual</h6>
                <div class="d-flex justify-content-end mr-2">
                    Vidas: &nbsp; <b>12</b>
                </div>
            </div>    

            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between border-bottom">
                    <h3>{{$quantidade_pagamento_vigencia}}</h3>
                    <p class="align-self-center mr-2">R$ {{number_format($aguardando_pagamento_vigencia_total,2,",",".")}}</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;"><a href="{{route('financeiro.aguardandoPagamentoVigencia')}}" class="text-dark">Aguardando Pag. Vigencia</a></h6>
                <div class="d-flex justify-content-end mr-2">
                    Vidas: &nbsp; <b>{{$aguardando_pagamento_vigencia_vidas}}</b>
                </div>
            </div>    

            <div class="small-box flex-fill mr-2 shadow" style="border:3px solid black;">
                <div class="d-flex justify-content-between">
                    <h3>{{$quantidade_pagamento_empresarial}}</h3>
                    <p class="align-self-center mr-2">R$ 1000,00</p>                        
                </div>
                <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;">Aguardando Pag. Empresarial</h6>
                <div class="d-flex justify-content-end mr-2">
                    Vidas: &nbsp; <b>10</b>
                </div>
            </div>    

    </div>    
</section>

<section class="d-flex">

    <div class="financeiro_container_financeiro_user flex-fill bg-olive mr-1 rounded">
        <div class="d-flex justify-content-around  text-center mt-3">
            <div class="financeiro_container_financeiro_user_image">
                <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="50" height="50" alt="User Image">
                <p>João</p>
            </div>
            <div class="financeiro_container_financeiro_user_vidas d-flex flex-column">
                <span>Vidas</span>
                <span>35</span> 
                <span>R$ 2000,00</span>
            </div>
        </div>
         
        <div class="financeiro_container_financeiro_resumo">
            <p class="d-flex justify-content-around"><span>Individual</span><span>10</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Coletivo</span><span>25</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Empresarial</span><span>0</span><span>R$ 1500,00</span></p>
        </div>
    </div>


    <div class="financeiro_container_financeiro_user flex-fill bg-olive mr-1 rounded">
        <div class="d-flex justify-content-around  text-center mt-3">
            <div class="financeiro_container_financeiro_user_image">
                <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="50" height="50" alt="User Image">
                <p>João</p>
            </div>
            <div class="financeiro_container_financeiro_user_vidas d-flex flex-column">
                <span>Vidas</span>
                <span>35</span> 
                <span>R$ 2000,00</span>
            </div>
        </div>
         
        <div class="financeiro_container_financeiro_resumo">
            <p class="d-flex justify-content-around"><span>Individual</span><span>10</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Coletivo</span><span>25</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Empresarial</span><span>0</span><span>R$ 1500,00</span></p>
        </div>
    </div>

    <div class="financeiro_container_financeiro_user flex-fill bg-olive mr-1 rounded">
        <div class="d-flex justify-content-around  text-center mt-3">
            <div class="financeiro_container_financeiro_user_image">
                <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="50" height="50" alt="User Image">
                <p>João</p>
            </div>
            <div class="financeiro_container_financeiro_user_vidas d-flex flex-column">
                <span>Vidas</span>
                <span>35</span> 
                <span>R$ 2000,00</span>
            </div>
        </div>
         
        <div class="financeiro_container_financeiro_resumo">
            <p class="d-flex justify-content-around"><span>Individual</span><span>10</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Coletivo</span><span>25</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Empresarial</span><span>0</span><span>R$ 1500,00</span></p>
        </div>
    </div>


    <div class="financeiro_container_financeiro_user flex-fill bg-olive mr-1 rounded">
        <div class="d-flex justify-content-around  text-center mt-3">
            <div class="financeiro_container_financeiro_user_image">
                <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="50" height="50" alt="User Image">
                <p>João</p>
            </div>
            <div class="financeiro_container_financeiro_user_vidas d-flex flex-column">
                <span>Vidas</span>
                <span>35</span> 
                <span>R$ 2000,00</span>
            </div>
        </div>
         
        <div class="financeiro_container_financeiro_resumo">
            <p class="d-flex justify-content-around"><span>Individual</span><span>10</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Coletivo</span><span>25</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Empresarial</span><span>0</span><span>R$ 1500,00</span></p>
        </div>
    </div>


    <div class="financeiro_container_financeiro_user flex-fill bg-olive mr-1 rounded">
        <div class="d-flex justify-content-around  text-center mt-3">
            <div class="financeiro_container_financeiro_user_image">
                <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="50" height="50" alt="User Image">
                <p>João</p>
            </div>
            <div class="financeiro_container_financeiro_user_vidas d-flex flex-column">
                <span>Vidas</span>
                <span>35</span> 
                <span>R$ 2000,00</span>
            </div>
        </div>
         
        <div class="financeiro_container_financeiro_resumo">
            <p class="d-flex justify-content-around"><span>Individual</span><span>10</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Coletivo</span><span>25</span><span>R$ 1500,00</span></p>
            <p class="d-flex justify-content-around"><span>Empresarial</span><span>0</span><span>R$ 1500,00</span></p>
        </div>
    </div>
</section>
<section class="mt-3">
    <h3 class="text-center border-top border-bottom border-dark">Ranking Vendas</h3>
</section>
@stop

@section('js')
    
@stop        

@section('css')
    
@stop

