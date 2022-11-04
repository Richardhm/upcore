@extends('adminlte::page')
@section('title', 'Pesquisar')
@section('content_header')
    <!-- <h1>Resultado pesquisa</h1> -->
    
        <div class="btns mx-auto">
            <button class="btn-search"><i class="fas fa-search"></i></button>
        </div>
    
@stop

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
    <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Sua Dashboard</a></li>
        <li class="breadcrumb-item">Pesquisa</li>
    </ol> -->

    <!-----CARD SEARCH------->
    
    



    <div class="card form-search">
        <div class="card-body">
            <form action="" method="POST" name="pesquisar_modal">
                @csrf
                <input type="hidden" name="city" id="city" value="{{$cidade_id ?? old('cidade_search')}}">
                <input type="hidden" name="plans" id="plans" value="{{$plano_id ?? old('planos_search')}}">
                <input type="hidden" name="old_operadora" id="old_operadora">
                
                <div class="d-flex">

                    <div style="flex-basis:18%;">
                        <span class="text-bold">Operadora:</span>
                        <select name="operadora_search" id="operadora_search" class="form-control">
                            <option value="">--Escolher a Operadora--</option>
                            @foreach($operadoras as $oo)
                                <option value="{{$oo->id}}" {{old('operadora_search') == $oo->id ? 'selected' :  (!empty($operadora_id) && $operadora_id == $oo->id ? 'selected' : '')}} >{{$oo->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('operadora_search'))
                            <p class="alert alert-danger">{{$errors->first('operadora_search')}}</p>
                        @endif
                    </div>

                    <div style="flex-basis:18%;margin:0 1%;">
                        <span class="text-bold">Administradora:</span>
                        
                        <select name="administradora_search" id="administradora_search" class="form-control">
                            <option value="">--Escolher a Administradora--</option>
                            @foreach($administradoras as $aa)
                                <option value="{{$aa->id}}" {{$aa->id == old('administradora_search') ? 'selected' : (!empty($administradora_id) && $administradora_id == $aa->id ? 'selected' : '')}}>{{$aa->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('administradora_search'))
                            <p class="alert alert-danger">{{$errors->first('administradora_search')}}</p>
                        @endif
                    </div>

                    <div style="flex-basis:18%;">
                        <span class="text-bold">Planos:</span>
                        
                        <select name="planos_search" id="planos_search" class="form-control">
                            <option value="">--Escolher o Plano--</option>
                            <option value="">--Antes escolher a administradora--</option>
                        </select>
                        @if($errors->has('planos_search'))
                            <p class="alert alert-danger">{{$errors->first('planos_search')}}</p>
                        @endif
                    </div>
                    
                    <div style="flex-basis:18%;margin:0 1%;">
                        <span class="text-bold">Cidade:</span>
                        <select name="cidade_search" id="cidade_search" class="form-control">
                            <option value="">--Escolher a Cidade--</option>
                        </select>  
                        @if($errors->has('cidade_search'))
                            <p class="alert alert-danger">{{$errors->first('cidade_search')}}</p>
                        @endif 
                    </div>    

                    <div style="flex-basis:10%;margin:0 1% 0 0;">
                        <div class="form-group">
                            <span class="text-bold">Coparticipação:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-secondary btn-lg" id="coparticipacao_sim" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="coparticipacao_search" id="coparticipacao_radio_sim" value="sim" {{old('coparticipacao_search') == "sim" ? 'checked' : (isset($coparticipacao) && !empty($coparticipacao) == 1 ? 'checked' : '')}}> Sim
                                </label>
                                <label class="btn btn-outline-secondary btn-lg" id="coparticipacao_nao" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="coparticipacao_search" id="coparticipacao_radio_nao" value="nao" {{old('coparticipacao_search') == "nao" ? 'checked' : (isset($coparticipacao) && !empty($coparticipacao) == 0 ? 'checked' : '')}}> Não
                                </label>
                                
                            </div>
                            @if($errors->has('coparticipacao_search'))
                                <p class="alert alert-danger">{{$errors->first('coparticipacao_search')}}</p>
                            @endif
                        </div>
                    </div> 
                    
                    <div style="flex-basis:10%;">
                        <div class="form-group">
                            <span class="text-bold">Odonto:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-secondary btn-lg" id="odonto_sim" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="odonto_search" id="odonto_radio_sim" value="sim" {{old('odonto_search') == "sim" ? 'checked' : (isset($odonto) && !empty($odonto) == 1 ? 'checked' : '')}}> Sim
                                </label>
                                <label class="btn btn-outline-secondary btn-lg" id="odonto_nao" style="padding:0.21rem 0.75rem;">
                                    <input type="radio" name="odonto_search" id="odonto_radio_nao" value="nao" {{old('odonto_search') == "nao" ? 'checked' : (isset($odonto) && !empty($odonto) == 0 ? 'checked' : '')}}> Não
                                </label>
                            </div>
                            @if($errors->has('odonto_search'))
                                <p class="alert alert-danger">{{$errors->first('odonto_search')}}</p>
                            @endif
                        </div>
                    </div>                   


                </div>
                
                <input type="submit" name="Enviar" value="Pesquisar" class="btn btn-block btn-primary mt-1">
            </div>                                     
        </form>
   </div>
   <!-----FIM CARD SEARCH------->

    @php
        $inicial = $card_inicial;
        $atual = "";
        $ii=0;$cadeado = true;
    @endphp
    <div id="resultado" style="display:flex;flex-wrap:wrap;justify-content:space-between;">

    @for($i=0;$i < count($tabelas); $i++) 
            
                @if($ii==0)
                    <div class="card" style="flex-basis:33%;padding:7px;">
                   

                    <div class="d-flex" style="flex-wrap:wrap;">
                        <div class="w-50 my-auto">
                            {{$tabelas[$i]->administradora}}
                        </div>

                        <div class="w-50 d-flex flex-column text-center">
                            <span>{{$tabelas[$i]->plano}}</span>
                            <span>{{$tabelas[$i]->odontos}}</span>
                        </div>

                        <div class="w-100 text-center">
                            <span>{{$tabelas[$i]->cidade}}</span>
                        </div>
                    </div>            





                    <table class="table table-sm">
                            <thead>
                                <tr>
                                    <td class="text-nowrap" rowspan="2" style="width:5%;text-align:center;vertical-align: middle;background-color:#D3D3D3;">Faixas</td>
                                    <td colspan="2">Com Copart.</td>
                                    <td colspan="2">Sem Copart.</td>
                                </tr>
                                <tr>
                                    
                                    <td class="text-nowrap" style="width:5%;">Enfer.</td>
                                    <td class="text-nowrap" style="width:5%;">Apart.</td>
                                    <td class="text-nowrap" style="width:5%;">Enfer.</td>
                                    <td class="text-nowrap" style="width:5%;">Apart.</td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                @endif
                @if($tabelas[$i]->card == $inicial)
                    
                    <tr>
                        <td class="text-nowrap" style="width:5%;">{{$tabelas[$i]->faixas}}</td>
                        <td class="text-nowrap" style="width:5%;">{{number_format($tabelas[$i]->enfermaria_com_coparticipacao_com_odonto,2,",",".")}}</td>
                        <td class="text-nowrap" style="width:5%;">{{number_format($tabelas[$i]->apartamento_com_coparticipacao_com_odonto,2,",",".")}}</td>
                        <td class="text-nowrap" style="width:5%;">{{number_format($tabelas[$i]->enfermaria_sem_coparticipacao_com_odonto,2,",",".")}}</td>
                        <td class="text-nowrap" style="width:5%;">{{number_format($tabelas[$i]->apartamento_sem_coparticipacao_com_odonto,2,",",".")}}</td>
                        
                    </tr>
                    @php $ii++ @endphp
            @else
                    </tbody>
                </table>
                </div>

                @php
                    $ii=0;
                    $inicial = $tabelas[$i]->card;
                    $i--;
                @endphp

            @endif

        @endfor





 
    </div>
        




   

   

    
 
@stop

@section('css')
    <style>
        table tbody tr:nth-child(even) {
            background-color:#696969;
            color:#FFF;
        }
        .form-search {
            display:none;
        }
        .btns {
            
            display: flex;
            justify-content: end;
            padding:5px 0; 
        }
        .btn-search {
            border:none;
            background-color: white;
        }

    </style>   
@stop



@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){

                $("form[name='pesquisar_modal']").on('submit',function(){
                    
                    $.ajax({
                        url:"{{route('admin.home.search.post')}}",
                        method:"POST",
                        data:$(this).serialize(),
                        success:function(res){
                            $('#resultado').slideUp('slow',function(){
                                $("#resultado").html(res).slideDown('slow')
                            });        
                        }
                    });
                    return false;
                });





                $('.btn-search').on('click',function(){
                    $(".form-search").slideToggle('slow')
                });



                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#operadora_search').on('change',function(){
                    $('input[name="old_operadora"]').val($(this).val());
                });

                $('#administradora_search').change(function(){
                    let valor = $(this).val();
                    
                    verificar_administradora(valor)

                });

                $("#cidade_search").change(function(){
                    $('input[name="city"]').val($(this).val());
                });  

                $("#planos_search").change(function(){
                    $('input[name="plans"]').val($(this).val());
                });



                
                

            function verificar_administradora(valor,city,plans){

                let selectedCity = (city != null && city != '' ? city : '');
                let selectedPlan = (plans != null && plans != '' ? plans : '');
                
                if(valor != "") {
                    
                    $.ajax({
                        url:"{{route('home.pegar.cidades')}}",
                        method:"POST",
                        data:"administradora="+valor,
                        success:function(res) {
                            if(res.citys.length >= 1) {
                                $("#cidade_search").html("");
                                $("#cidade_search").prepend("<option value=''>--Escolher a Cidade--</option>")
                                $(res.citys).each(function(index,value){
                                    $('#cidade_search').       
                                    append("<option value='"+value.id+"' "+(value.id == selectedCity ? 'selected' : '')+" >"+value.nome+"</option>")     
                                });
                            } else {
                                $("#cidade_search").html("");
                                $("#cidade_search").append('<option value="">--Esta administradora não possui cidades cadastradas--</option>');
                            }

                            if(res.planos.length >= 1) {
                                $("#planos_search").html("");
                                $("#planos_search").prepend("<option value=''>--Escolher o Plano--</option>");
                                $(res.planos).each(function(index,value){
                                    $('#planos_search').       
                                    append("<option value='"+value.plano_id+"' "+(value.plano_id == selectedPlan ? 'selected' : '')+">"+value.nome_plano+"</option>")     
                                });

                            } else {
                                $("#planos_search").html("");
                                $("#planos_search").append('<option value="">--Esta administradora não possui planos cadastradas--</option>');
                            }
                        }
                    });  

                } 
            }

            verificar_administradora($("#administradora_search").val(),$('input[name="city"]').val(),$('input[name="plans"]').val());
        });
    </script>    
@stop
