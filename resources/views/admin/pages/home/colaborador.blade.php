@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard - Corretor</h1>
@stop
@section('content_top_nav_right')

    <li class="nav-item"><a href="{{route('home.relatorio')}}" class="nav-link"><i class="fas fa-file-excel"></i>  </a></li> <!--Relatorio-->
    <li class="nav-item"><a href="{{route('admin.home.search')}}" class="nav-link"><i class="fas fa-search"></i></a></li> <!--Consulta Rapida-->

@stop
@section('content')
<section class="content">


    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 col-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>20</h3>
                        <p>Tarefas Hoje</p>                        
                    </div>
                    
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>8</h3>
                        <p>Tarefas Atrasadas</p>
                       
                    </div>
                    
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3 class="text-white">6</h3>
                        <p class="text-white">Tarefa(s) para os proximos 03 dias</p>
                       
                    </div>
                    
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 class="text-white">10</h3>
                        <p class="text-white">Sem Tarefas</p>
                       
                    </div>
                    
                </div>
            </div>



        </div>
    </div>
</section> 

<div class="row">
    
    <div class="col-md-2 col-sm-6 col-12">
        <div class="info-box bg-navy">
            
            <div class="info-box-content">
                <span class="info-box-number">000</span>
                <span class="info-box-text">Leads</span>
                
            </div>
        </div>
    </div>

    <div class="col-md-2 col-sm-6 col-12">
        <div class="info-box bg-lightblue">
            
            <div class="info-box-content">
                <span class="info-box-number">000</span>
                <span class="info-box-text">Atendimento Em Aberto</span>
               
               
            </div>
        </div>
    </div>

    <div class="col-md-2 col-sm-6 col-12">
        <div class="info-box bg-olive">
            
            <div class="info-box-content">
                <span class="info-box-number">000</span>
                <span class="info-box-text">Interessado</span>
                
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-gray-dark">
            
            <div class="info-box-content">
                <span class="info-box-number">000</span>
                <span class="info-box-text">Aguardando Pagamento</span>
                
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-gray">
            
            <div class="info-box-content">
                <span class="info-box-number">000</span>
                <span class="info-box-text">Aguardando Pagamento Vigência</span>    
            </div>
        </div>
    </div>
    
</div>

<div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center mb-3">
    <h3 class="align-self-center">Clientes</h3>
</div>

<div class="container-fluid">
        <div class="row">

            <div class="col-md-2 col-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>17</h3>
                        <p>Total Clientes</p>                        
                        <p>Vidas 25</p>                        
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>8</h3>
                        <p>Negociados</p>                        
                        <p>Vidas 12</p>                        
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>9</h3>
                        <p>Em Negociação</p>                        
                        <p>Vidas 11</p>                        
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>9</h3>
                        <p>Cadastrado no Mês</p>                        
                        <p>Vidas 11</p>                        
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>5</h3>
                        <p>Perdidos</p>                        
                        <p>Vidas 11</p>                        
                    </div>
                </div>
            </div>


        </div>
    </div>


    <div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center mb-3">
        <h3 class="align-self-center">Referente ao mês de Julho/2022</h3>
    </div>

    <section class="referente_mes">
        <div class="bloco bg-dark rounded">
            <h4>Total Vendido</h4>
            <p>20 Vidas R$ 5.000,00</p>
            <p>6 Individual R$ 1000,00</p>
            <p>14 Coletivo Adesão R$ 4.000,00</p>
            <p>0 Empresarial R$ 0,00</p>
        </div>
        <div class="bloco bg-danger rounded">
            <h4>Comissões a Receber</h4>
            <p>R$ 800,00 Total</p>
            <p>R$ 200,00 Individual</p>
            <p>R$ 600,00 Coletivo</p>
            <p>R$ 0,00 Empresarial</p>
        </div>
        <div class="bloco bg-success rounded">
            <h4>Premiação a receber</h4>
            <p>R$ 1.500,00 Total</p>
            <p>R$ 0,00 Individual</p>
            <p>R$ 1.500,00 Coletivo</p>
            <p>R$ 0,00 Empresarial</p>
        </div>
        <div class="bloco bg-warning rounded">
            <h4>Total a Receber</h4>
            <p>R$ 2.300,00 Total</p>
            <p>R$ 200,00 Individual</p>
            <p>R$ 2.000,00 Coletivo</p>
            <p>R$ 0,00 Empresarial</p>
        </div>
    </section>

    <div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center my-3">
        <h3 class="align-self-center">Restante A Receber</h3>
    </div>

    <section class="referente_mes mb-3">
        <div class="bloco bg-dark rounded">
            <h4>Total Vendido</h4>
            <p>20 Vidas R$ 5.000,00</p>
            <p>6 Individual R$ 1000,00</p>
            <p>14 Coletivo Adesão R$ 4.000,00</p>
            <p>0 Empresarial R$ 0,00</p>
        </div>
        <div class="bloco bg-danger rounded">
            <h4>Comissões a Receber</h4>
            <p>R$ 800,00 Total</p>
            <p>R$ 200,00 Individual</p>
            <p>R$ 600,00 Coletivo</p>
            <p>R$ 0,00 Empresarial</p>
        </div>
        <div class="bloco bg-success rounded">
            <h4>Premiação a receber</h4>
            <p>R$ 1.500,00 Total</p>
            <p>R$ 0,00 Individual</p>
            <p>R$ 1.500,00 Coletivo</p>
            <p>R$ 0,00 Empresarial</p>
        </div>
        <div class="bloco bg-warning rounded">
            <h4>Total a Receber</h4>
            <p>R$ 2.300,00 Total</p>
            <p>R$ 200,00 Individual</p>
            <p>R$ 2.000,00 Coletivo</p>
            <p>R$ 0,00 Empresarial</p>
        </div>
    </section>

@stop

@section('js')
    <script>
         $(document).ready(function(){
           


         });
    </script>
@stop   

@section('css')
    <style>     
        .referente_mes {
            display:flex;
        }     
        .bloco {
            flex-basis: 24%;
            margin-right:10px;
        }
    </style>
@stop