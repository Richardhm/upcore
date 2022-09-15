@if(count($valores)>=1)
<h4 class="py-2">Nossos Planos</h4>  
<section class="d-flex justify-content-between">
    @foreach($valores as $v)
    <div class="d-flex justify-content-center flex-column border border-dark rounded valores-acomodacao" style="width:33%;">
        <div class="text-center my-2 icheck-success d-inline">
            <input type="radio" name="acomodacao" id="acomodacao" value="{{$v->id_acomodacao}}" data-valor="{{$v->total}}">
        </div>
        <h4 class="text-center py-2" style="border-top:1px solid black;border-bottom:1px solid black;">
            <img src="{{\Illuminate\Support\Facades\Storage::url($v->operadora)}}" alt="" width="80" height="50">
        </h4>
        <p class="text-center py-2" style="border-bottom:1px solid black"><u><b>{{$v->plano}}</b></u></p> 
        <div class="d-flex justify-content-around" style="border-bottom:1px solid black;">
            <p style="font-weight:bold;">{{$v->coparticipacao}}</p>
            <p style="font-weight:bold;">{{$v->odonto}}</p>
        </div>
        <div class="row d-flex align-items-center justify-content-around" style="padding:0px;">
                <div class="col border-right border-dark">
                    <div class="form-group">
                        <label for="data_vigente" class="ml-2">Data Vigencia:</label>
                        <input type="date" name="vigente" id="vigente" value="{{old('data_vigente')}}" class="form-control">
                    </div>
                    <div class="errordatavigente"></div>
                </div>    

                <div class="col">
                    <div class="form-group">
                        <label for="data_boleto" class="ml-2">Data Boleto:</label>
                        <input type="date" name="boleto" id="boleto" value="{{old('data_boleto')}}" placeholder="Data Boleto" class="form-control">
                    </div>
                    <div class="errordataboleto"></div>
                </div>
            
        </div>

        <div class="d-flex justify-content-center border-top border-dark">
            <div class="col">
                <div class="form-group">
                    <label for="valor_adesao">Valor Adesão:</label>
                    <input type="text" name="adesao" id="adesao" placeholder="R$" class="form-control valor_adesao" value="{{old('valor_adesao')}}">
                    <div class="errorvaloradesao"></div>
                    @if($errors->has('valor_adesao'))
                        <p class="alert alert-danger">{{$errors->first('valor_adesao')}}</p>
                    @endif
                </div>
            </div>
        </div>



        <div class="border-top border-dark d-flex align-items-center">
            <table class="table border-dark table-borderless table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Faixas</th>
                        <th>Vidas</th>
                        <th>Valor</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faixas as $f)
                        @if($f->modelo == $v->modelo)
                        <tr class="border-top border-dark">
                            <th>{{$f->faixas}}</th>
                            <td class="text-center">{{$f->quantidade}}</td>
                            <td>{{number_format($f->valor,2,",",".")}}</td>
                            <td>{{number_format($f->total,2,",",".")}}</td>
                        </tr>    
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="py-2 border-top border-dark">
            <p class="text-center" style="margin:auto auto;font-style: italic;">{{$v->modelo}}</p> 
        </div>
        <div class="bg-secondary text-white py-2" style="clear: both;border-top:1px solid black;">
            <p class="text-center" style="font-weight:bold;margin:auto auto;">R$ {{number_format($v->total,2,",",".")}}</p>
        </div>
    </div>
    @endforeach 
</section>
<input type="hidden" name="valor" id="valor" value="">
<input type="hidden" name="data_vigencia" id="data_vigencia" value="">
<input type="hidden" name="data_boleto" id="data_boleto" value="">
<input type="hidden" name="valor_adesao" id="valor_adesao" value="">
<div id="btn_submit"></div>
@else
    <h3 class="text-center py-3">Não há planos com esses parâmetros, tente outros</h3>
@endif
<script>
    $(function(){
        // $(".valores-acomodacao").css("background-color","red");
        $('.valor_adesao').mask("#.##0,00", {reverse: true});
    });
</script>