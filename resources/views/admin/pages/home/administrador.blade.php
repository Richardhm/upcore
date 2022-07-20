@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashbord</h1>
@stop

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        
                        <h3>---</h3>
                        <p class="d-flex"><span class="mr-auto">Orçamentos Realizados</span> <span style="font-size:0.8em;font-weight:bold;">Hoje: 0</span></p>
                        
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>---</h3>
                        <p class="d-flex"><span class="mr-auto">Contratos Realizados</span> <span style="font-size:0.8em;font-weight:bold;">Hoje: 0</span></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{count($corretores)}}</h3>
                        <p>Nossos Corretores</p>
                    </div>
                    <div class="icon">
                     
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$cidades}}</h3>
                        <p>Cidades onde estamos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <a href="" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>    












@stop
@section('js')
    <script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>   
    <script>
        $(document).ready(function(){

           



        });
    </script>
    <script src="{{asset('js/dashboard.js')}}"></script>  
@stop