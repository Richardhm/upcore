@extends('adminlte::page')
@section('title', 'Tabela de Preços')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Tabela de Preços</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <a class="btn btn-warning" href="{{route('tabela.search')}}"><i class="fas fa-search"></i></a>
        </div>
    </div>    
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">                
            <form action="{{route('tabela.store')}}" class="invoice-repeater" method="POST">
                @csrf
                <input type="hidden" name="city" id="city" value="{{old('cidades')}}">
                <input type="hidden" name="plans" id="plans" value="{{old('planos')}}">
                <div class="form-row">
                    <div class="col-md-4 mb-2">
                        <label for="operadora">Operadora:</label>
                        <select name="operadora" id="operadora" class="form-control">
                            <option value="">--Escolher a Operadora--</option>
                            @foreach($operadoras as $oo)
                                <option value="{{$oo->id}}" {{$oo->id == old('operadora') ? 'selected' : ''}}>{{$oo->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('operadora'))
                            <p class="alert alert-danger">{{$errors->first('operadora')}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="administradora">Administradora:</label>
                        <select name="administradora" id="administradora" class="form-control">
                            <option value="">--Escolher a Administradora--</option>
                            @foreach($administradoras as $aa)
                                <option value="{{$aa->id}}" {{$aa->id == old('administradora') ? 'selected' : ''}}>{{$aa->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('administradora'))
                            <p class="alert alert-danger">{{$errors->first('administradora')}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="planos">Planos:</label>
                        <select name="planos" id="planos" class="form-control">
                            <option value="">--Escolher o Plano--</option>
                            <option value="">--Antes escolher a administradora--</option>
                        </select>
                        @if($errors->has('planos'))
                            <p class="alert alert-danger">{{$errors->first('planos')}}</p>
                        @endif
                    </div>
                </div>
               
                
                <div class="form-row">
                    <div class="col-md-4 mb-2">
                        <label for="">Cidade:</label>
                        <select name="cidades" id="cidades" class="form-control">
                            <option value="">--Escolher a Cidade--</option>
                        </select>
                        @if($errors->has('cidades'))
                            <p class="alert alert-danger">{{$errors->first('cidades')}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="coparticipacao">Coparticipação:</label><br />
                        <select name="coparticipacao" id="coparticipacao" class="form-control">
                            <option value="">--Escolher Coparticipacao--</option>
                            <option value="sim" {{old('coparticipacao') == "sim" ? 'selected' : ''}}>Sim</option>
                            <option value="nao" {{old('coparticipacao') == "nao" ? 'selected' : ''}}>Não</option>
                        </select>
                        @if($errors->has('coparticipacao'))
                            <p class="alert alert-danger">{{$errors->first('coparticipacao')}}</p>
                        @endif
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="odonto">Odonto:</label><br />
                        <select name="odonto" id="odonto" class="form-control">
                            <option value="">--Escolher Odonto--</option>
                            <option value="sim" {{old('odonto') == "sim" ? 'selected' : ''}}>Sim</option>
                            <option value="nao" {{old('odonto') == "nao" ? 'selected' : ''}}>Não</option>
                        </select>
                        @if($errors->has('odonto'))
                            <p class="alert alert-danger">{{$errors->first('odonto')}}</p>
                        @endif
                    </div>
                    
                </div>
                <h3 class="my-1">Faixas Etarias</h3>
                <div class="form-row">
                        
                    <div class="col" style="border-right:2px solid black;">
                        <div class="form-group">
                            @foreach($faixas as $k => $f)
                                <div>
                                    @if($loop->first)
                                        <h6 style="font-weight:bold;text-decoration:underline;">Apartamento</h6>
                                        
                                    @endif
                                    <div class="row mb-2">
                                        <div class="col">
                                            <input type="text" disabled class="" value="{{$f->nome}}" />
                                            <input type="hidden" value="{{$f->id}}" name="faixa_etaria_id_apartamento[]" />
                                            <input type="text" class="valor" placeholder="valor" name="valor_apartamento[]" id="valor" value="{{isset(old('valor_apartamento')[$k]) && !empty(old('valor_apartamento')[$k]) ? old('valor_apartamento')[$k] : ''}}" />
                                            @if($errors->any('valor_apartamento'.$k) && !empty($errors->get('valor_apartamento.'.$k)[0]))
                                                <p class="alert alert-danger">O valor da faixa etaria {{ $f->nome }} e campo obrigatorio</p>
                                            @endif        
                                        </div>    
                                    </div>  
                                    
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col" style="border-right:2px solid black;">
                        <div class="form-group">
                            @foreach($faixas as $k => $f)
                                <div>
                                    @if($loop->first)
                                        <h6 style="font-weight:bold;text-decoration:underline;">Enfermaria</h6>
                                    @endif
                                    <div class="row mb-2">
                                        <div class="col">
                                            <input type="text" disabled class="" value="{{$f->nome}}" />
                                            <input type="hidden" value="{{$f->id}}" name="faixa_etaria_id_enfermaria[]" />
                                            <input type="text" class="valor" placeholder="valor" name="valor_enfermaria[]" id="valor_enfermaria" value="{{isset(old('valor_enfermaria')[$k]) && !empty(old('valor_enfermaria')[$k]) ? old('valor_enfermaria')[$k] : ''}}" />
                                            @if($errors->any('valor_enfermaria'.$k) && !empty($errors->get('valor_enfermaria.'.$k)[0]))
                                                <p class="alert alert-danger">O valor da faixa etaria {{ $f->nome }} e campo obrigatorio</p>
                                            @endif        
                                        </div>    
                                    </div>  
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                                @foreach($faixas as $k => $f)
                                    <div>
                                        @if($loop->first)
                                            <h6 style="font-weight:bold;text-decoration:underline;">Ambulatorial</h6>
                                        @endif
                                        <div class="row mb-2">
                                            <div class="col">
                                                <input type="text" disabled class="" value="{{$f->nome}}" />
                                                <input type="hidden" value="{{$f->id}}" name="faixa_etaria_id_ambulatorial[]" />
                                                <input type="text" class="valor" placeholder="valor" name="valor_ambulatorial[]" id="valor_ambulatorial" value="{{isset(old('valor_ambulatorial')[$k]) && !empty(old('valor_ambulatorial')[$k]) ? old('valor_ambulatorial')[$k] : ''}}" />
                                                @if($errors->any('valor_ambulatorial'.$k) && !empty($errors->get('valor_ambulatorial.'.$k)[0]))
                                                    <p class="alert alert-danger">O valor da faixa etaria {{ $f->nome }} e campo obrigatorio</p>
                                                @endif        
                                            </div>    
                                        </div>  
                                    </div>
                                @endforeach
                            </div>
                        </div>
                </div>
                <button class="btn btn-primary btn-block mt-3">Cadastrar</button>
            </form>
        </div>
</div>
@stop

@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>

    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.valor').mask("#.##0,00", {reverse: true});
            
            $('#administradora').change(function(){
                let valor = $(this).val();
                verificar_administradora(valor);  
            });

            $("#cidades").change(function(){
                $('input[name="city"]').val($(this).val());
            });  

            $("#planos").change(function(){
                $('input[name="plans"]').val($(this).val());
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
                                $("#cidades").html("");
                                $("#cidades").prepend("<option value=''>--Escolher a Cidade--</option>")
                                $(res.citys).each(function(index,value){
                                    $('#cidades').       
                                    append("<option value='"+value.id+"' "+(value.id == selectedCity ? 'selected' : '')+" >"+value.nome+"</option>")     
                                });
                               
                            } else {
                                $("#cidades").html("");
                                $("#cidades").append('<option value="">--Esta administradora não possui cidades cadastradas--</option>');
                            }

                            if(res.planos.length >= 1) {
                                $("#planos").html("");
                                $("#planos").prepend("<option value=''>--Escolher o Plano--</option>");
                                $(res.planos).each(function(index,value){
                                    $('#planos').       
                                    append("<option value='"+value.plano_id+"' "+(value.plano_id == selectedPlan ? 'selected' : '')+">"+value.nome_plano+"</option>")     
                                });

                            } else {
                                $("#planos").html("");
                                $("#planos").append('<option value="">--Esta administradora não possui planos cadastradas--</option>');
                            }
                        }
                    });  

                } 
            }

            verificar_administradora($("#administradora").val(),$('input[name="city"]').val(),$('input[name="plans"]').val());

        });    
      
    </script>
@stop