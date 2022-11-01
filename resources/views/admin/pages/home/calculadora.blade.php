@extends('adminlte::page')
@section('title', 'Calculadora')

@section('content_top_nav_right')

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

   <div class="calculadora">
        <input type="text" name="tela" id="display-da-tela">
        <div class="buttons-container">
            <button class="button" onclick="adicionar_parametros('(')">(</button>
            <button class="button" onclick="adicionar_parametros(')')">)</button>
            <button class="button" onclick="porcentagem()">%</button>
            <button class="button" onclick="limpar()">AC</button>

            <button class="button" onclick="adicionar_parametros(7)">7</button>
            <button class="button" onclick="adicionar_parametros(8)">8</button>
            <button class="button" onclick="adicionar_parametros(9)">9</button>
            <button class="button" onclick="adicionar_parametros('/')">/</button>

            <button class="button" onclick="adicionar_parametros(4)">4</button>
            <button class="button" onclick="adicionar_parametros(5)">5</button>
            <button class="button" onclick="adicionar_parametros(6)">6</button>
            <button class="button" onclick="adicionar_parametros('*')">*</button>

            <button class="button" onclick="adicionar_parametros(1)">1</button>
            <button class="button" onclick="adicionar_parametros(2)">2</button>
            <button class="button" onclick="adicionar_parametros(3)">3</button>
            <button class="button" onclick="adicionar_parametros('-')">-</button>

            <button class="button" onclick="adicionar_parametros(0)">0</button>
            <button class="button" onclick="adicionar_parametros('.')">.</button>
            <button class="button" onclick="calcular()">=</button>
            <button class="button" onclick="adicionar_parametros('+')">+</button>
        </div>
   </div> 

   

@stop

@section('css')
    <style>
       .calculadora {background-color: rgba(0,0,0,0.6);height:630px;width:412px;position:absolute;top:20px;bottom:0;left:0;right:0;margin: auto;}
       #display-da-tela {height:100px;width:100%;margin:2px 0;text-align:right;font-size:50px;}
       .button {height:100px;width:100px;padding:0;background-color:rgba(255,255,255,0.25);color:white;border:solid white 1px;margin:2px 0px;font-size:50px;}
       .button:hover {background-color:rgba(255,255,255,0.5);}
    </style>
@stop

@section('js')
    <script>
        function adicionar_parametros(parametro) {
            document.querySelector("[name='tela']").value += parametro;
        }
        function calcular() {
            conta = document.querySelector("[name='tela']").value;
            document.querySelector("[name='tela']").value = eval(conta);
        }

        function porcentagem() {
            conta = document.querySelector("[name='tela']").value + "/ 100";
            document.querySelector("[name='tela']").value = eval(conta);

        }

        function limpar() {
            document.querySelector("[name='tela']").value = '';
        }
    </script>
@stop        