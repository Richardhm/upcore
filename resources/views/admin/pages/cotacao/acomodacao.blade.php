@if(count($valores)>=1)
<h4 class="py-2 text-white">Nossos Planos</h4>  
<section class="d-flex justify-content-between">
    @foreach($valores as $v)
    <div class="d-flex justify-content-center flex-column rounded valores-acomodacao mb-3 py-2">
        <!-- <div class="text-center my-2 icheck-success d-inline">
            <input type="radio" name="acomodacao" id="acomodacao" value="{{$v->id_acomodacao}}" data-valor="{{$v->total}}">
        </div> -->
        <h4 class="text-center py-5 d-flex justify-content-center mx-auto align-items-center" style="background-color:rgba(0,0,0,0.4);border-radius:50%;border:6px solid rgb(44,108,206);width:100px;height:100px;">
            <img src="{{\Illuminate\Support\Facades\Storage::url($v->operadora)}}" class="p-2 d-flex align-self-center" alt="" width="80" height="50" align="center">
        </h4>
        <div class="d-flex border-top border-bottom align-items-center">
            <div class="col-6 border-right">
                <p class="text-center h-100 my-auto py-2">{{$v->plano}}</p> 
            </div>
            <div class="col-6">
                <p class="text-center h-100 my-auto py-2 tipo">{{$v->modelo}}</p>   
            </div>
        </div>
        <div class="d-flex border-bottom">
            <div class="col-6 border-right">
                <p class="text-center h-100 my-auto py-2">{{$v->coparticipacao}}</p>
            </div>
            <div class="col-6">
                <p class="text-center h-100 my-auto py-2">{{$v->odonto}}</p>
            </div>
        </div>
        <div id="erros">
            <div class="errordatavigente"></div>
            <div class="errordataboleto"></div>
            <div class="errorvaloradesao"></div>
        </div>
        <div class="d-flex my-2" style="padding:0px;">
                <div class="ml-2">
                    <div class="form-group">
                        <p style="margin:0;padding:0;">Data Vigencia:</p>
                        <input type="date" name="vigente" id="vigente" value="" class="form-control form-control-sm vigente">
                    </div>
                    
                </div>    
                <div class="mx-1">
                    <div class="form-group">
                        <p style="margin:0;padding:0;">Data Boleto:</p>
                        <input type="date" name="boleto" id="boleto" value="" placeholder="Data Boleto" class="form-control form-control-sm boleto">
                    </div>
                    
                </div>
                <div class="mr-2">
                    <div class="form-group">
                        <p style="margin:0;padding:0;">Valor Adesão:</p>
                        <input type="text" name="adesao" id="adesao" placeholder="R$" class="form-control form-control-sm valor_adesao">
                    </div>
                </div>
        </div>

        <div class="d-flex align-items-center mx-auto mb-2" style="width:80%;border-radius:10px;">
            <table class="table table-borderless" style="border-radius:10px;">
                <thead>
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
                        <tr>
                            <td>{{$f->faixas}}</td>
                            <td>{{$f->quantidade}}</td>
                            <td>{{number_format($f->valor,2,",",".")}}</td>
                            <td>{{number_format($f->total,2,",",".")}}</td>
                        </tr>    
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="text-white py-2" style="clear: both;border-top:1px solid black;">
            <p class="text-center valor_plano" style="font-weight:bold;margin:auto auto;">R$ {{number_format($v->total,2,",",".")}}</p>
        </div>
    </div>
    @endforeach 
</section>
<input type="hidden" name="valor" id="valor" value="">
<input type="hidden" name="data_vigencia" id="data_vigencia" value="">
<input type="hidden" name="data_boleto" id="data_boleto" value="">
<input type="hidden" name="valor_adesao" id="valor_adesao" value="">
<input type="hidden" name="acomodacao" id="acomodacao" value="">
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