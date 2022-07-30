@extends('adminlte::page')
@section('title', 'Pesquisar')
@section('content_header')
    <h1>Resultado pesquisa</h1>
@stop
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Sua Dashboard</a></li>
        <li class="breadcrumb-item">Pesquisa</li>
    </ol>
    <div class="card">
        <div class="card-body">
        <form action="{{route('admin.home.search.post')}}" method="POST" name="pesquisar_modal">
                <input type="hidden" name="city" id="city" value="{{$cidade_id ?? old('cidade_search')}}">
                <input type="hidden" name="plans" id="plans" value="{{$plano_id ?? old('planos_search')}}">
                
                        @csrf
                        <input type="hidden" name="old_operadora" id="old_operadora">
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="operadora_search">Operadora:</label>
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
                            <div class="col-md-3 mb-3">
                                <label for="administradora_search">Administradora:</label>
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
                            <div class="col-md-3 mb-3">
                                <label for="planos_search">Planos:</label>
                                <select name="planos_search" id="planos_search" class="form-control">
                                    <option value="">--Escolher o Plano--</option>
                                    <option value="">--Antes escolher a administradora--</option>
                                </select>
                                @if($errors->has('planos_search'))
                                    <p class="alert alert-danger">{{$errors->first('planos_search')}}</p>
                                @endif
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="cidade_search">Cidade:</label><br />
                                <select name="cidade_search" id="cidade_search" class="form-control">
                                    <option value="">--Escolher a Cidade--</option>
                                </select>  
                                @if($errors->has('cidade_search'))
                                    <p class="alert alert-danger">{{$errors->first('cidade_search')}}</p>
                                @endif 
                            </div>    



                        </div>
                        <div class="form-row">
                            <div class="col-3 col-md-3">
                                <div class="form-group">
                                    <label for="coparticipacao">Coparticipação:</label><br />
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-outline-secondary btn-lg" id="coparticipacao_sim">
                                            <input type="radio" name="coparticipacao_search" id="coparticipacao_radio_sim" value="sim" {{old('coparticipacao_search') == "sim" ? 'checked' : (isset($coparticipacao) && !empty($coparticipacao) == 1 ? 'checked' : '')}}> Sim
                                        </label>
                                        <label class="btn btn-outline-secondary btn-lg" id="coparticipacao_nao">
                                            <input type="radio" name="coparticipacao_search" id="coparticipacao_radio_nao" value="nao" {{old('coparticipacao_search') == "nao" ? 'checked' : (isset($coparticipacao) && !empty($coparticipacao) == 0 ? 'checked' : '')}}> Não
                                        </label>
                                        
                                    </div>
                                    @if($errors->has('coparticipacao_search'))
                                        <p class="alert alert-danger">{{$errors->first('coparticipacao_search')}}</p>
                                    @endif
                                </div>
                            </div>    
                            <div class="col-3 col-md-3">
                                <div class="form-group">
                                    <label for="odonto">Odonto:</label><br />
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-outline-secondary btn-lg" id="odonto_sim">
                                            <input type="radio" name="odonto_search" id="odonto_radio_sim" value="sim" {{old('odonto_search') == "sim" ? 'checked' : (isset($odonto) && !empty($odonto) == 1 ? 'checked' : '')}}> Sim
                                        </label>
                                        <label class="btn btn-outline-secondary btn-lg" id="odonto_nao">
                                            <input type="radio" name="odonto_search" id="odonto_radio_nao" value="nao" {{old('odonto_search') == "nao" ? 'checked' : (isset($odonto) && !empty($odonto) == 0 ? 'checked' : '')}}> Não
                                        </label>
                                    </div>
                                    @if($errors->has('odonto_search'))
                                        <p class="alert alert-danger">{{$errors->first('odonto_search')}}</p>
                                    @endif
                                </div>
                            </div>                         
                        </div>
                        <input type="submit" name="Enviar" value="Pesquisar" class="btn btn-block btn-primary mt-3">
                    </div>                                     
                </form>
   </div>
    
   @if(isset($tabelas) && count($tabelas) >= 1)
        <div class="card" style="width: 30rem;margin:0 auto;">
            
            <div class="card-body">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr class="border-bottom border-top">
                            <td colspan="4" align="center"><b>{{$administradora_texto}}</b></td>
                        </tr>
                        <tr class="border-bottom">
                            <td colspan="4" align="center"><b>{{$coparticipacao_texto}} - {{$odonto_texto}}</b></td>
                        </tr>
                        <tr>
                            <th align="center">Faixa</th>
                            <th align="center">Apartamento</th>
                            <th align="center">Enfermaria</th>
                            <th align="center">Ambulatorial</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tabelas as $t)
                        <tr>
                            <td align="center">{{$t->faixas}}</td>
                            <td align="center">{{number_format($t->apartamento,2,",",".")}}</td>
                            <td align="center">{{number_format($t->enfermaria,2,",",".")}}</td>
                            <td align="center">{{number_format($t->ambulatorial,2,",",".")}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
        
    @endif       
        
        
    

    @if(isset($tabelas) && count($tabelas) == 0) 
    <p class="alert alert-danger text-center">Sem Resultados com esses parametros, tente outros</p>
        

    @endif


   

   
</div>
    
  
@stop
@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){

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



                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            function verificar_administradora(valor,city,plans){
                
                let selectedCity = (city != null && city != '' ? city : '');
                let selectedPlan = (plans != null && plans != '' ? plans : '');
                
                if(valor != "") {
                    
                    $.ajax({
                        url:"{{route('cidades.administradoras.pegar')}}",
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

@section('css')
    <style>

    </style>        
@stop