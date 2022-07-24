@extends('adminlte::page')

@section('title', 'Funcionario')

@section('content_header')
@stop

@section('content')
    <h1>{{$user->name}} - {{$cargo}}</h1>

    <section class="row">

        <div class="col-6">

            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-warning">
                    <div class="widget-user-image">
                        @if(!empty($c->image)) 
                            <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url($t->makes($c->image,100,100))}}" alt="User Image">
                        @else
                            <img class="img-circle elevation-2" src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="100" height="100" alt="User Image">
                        @endif    
                        
                    </div>

                    <h3 class="widget-user-username">Nadia Carmichael</h3>
                    <h5 class="widget-user-desc">Lead Developer</h5>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Commissões a Receber<span class="float-right badge bg-primary">31</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Premiações a Receber <span class="float-right badge bg-info">5</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Vidas Deste Mês <span class="float-right badge bg-success">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Tarefas para os proximo 03 dias <span class="float-right badge bg-danger">842</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Tarefas atrasadas <span class="float-right badge bg-danger">842</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Clientes Atendimento em Aberto <span class="float-right badge bg-danger">842</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Clientes Interessados <span class="float-right badge bg-danger">842</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Clientes Sem Interesse <span class="float-right badge bg-danger">842</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-6">

            <div class="card">
                <div class="card-header bg-dark">
                    <h3>Informações</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p><b>Funcionario(a) deste :</b> ...................................................................................</p>
                        <p>10/10/2018</p>
                    </div> 
                    <hr>   
                    <div class="d-flex justify-content-between">
                        <p><b>Contato(a) :</b> .............................................................................................</p>
                        <p>(62) 9 858978555</p>
                    </div>
                    <hr>    
                    <div class="d-flex justify-content-between">
                        <p><b>Total de Vidas :</b> .............................................................................................................</p>
                        <p>10</p>
                    </div>
                    <hr>    
                    <div class="d-flex justify-content-between">
                        <p><b>Total de Comissões :</b> ........................................................................................</p>
                        <p>R$ 200,50</p>
                    </div>
                    <hr>    
                    <div class="d-flex justify-content-between">
                        <p><b>Total de Premiações :</b> ..............................................................................................</p>
                        <p>R$ 800</p>
                    </div>
                </div>
                
            </div>


        </div>

    </section>

    <section>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Historico</h3>
            </div>
            <div class="card-body">
                
            </div>
            <div class="card-footer">
            <ul class="pagination pagination-month justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Jan</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">
                            <p class="page-month">Feb</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Mar</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Apr</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">May</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Jun</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Jul</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Aug</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Sep</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Oct</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Nov</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <p class="page-month">Dec</p>
                            <p class="page-year">2021</p>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </div>
        </div>
    </section>




    
   
@stop
@section('js')
@stop