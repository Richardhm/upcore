@if(count($valores)>=1)
<h4 class="py-2">Nossos Planos</h4>  
<section class="d-flex justify-content-between">
      
    @foreach($valores as $v)
    <div class="d-flex justify-content-center flex-column border border-secondary rounded w-25 valores-acomodacao">
        <div class="text-center my-2 icheck-success d-inline">
            <input type="radio" name="acomodacao" id="acomodacao" value="{{$v->id_acomodacao}}" data-valor="{{$v->total}}">
        </div>

        <h4 class="text-center py-2" style="border-top:1px solid #D3D3D3;border-bottom:1px solid #D3D3D3;">
            <img src="{{\Illuminate\Support\Facades\Storage::url($v->operadora)}}" alt="" width="80" height="50">
        </h4>
        <p class="text-center py-2"><u>Nosso Plano <b>{{$v->plano}}</b></u></p> 
        <div class="d-flex justify-content-around">
            <p style="font-weight:bold;">{{$v->coparticipacao}}</p>
            <p style="font-weight:bold;">{{$v->odonto}}</p>
        </div>
        <div class="py-2" style="border-top:1px solid #D3D3D3;">
            <p class="text-center" style="margin:auto auto;font-style: italic;">{{$v->modelo}}</p> 
           
        </div>
        <div class="bg-secondary text-white py-2" style="clear: both;border-top:1px solid black;">
            <p class="text-center" style="font-weight:bold;margin:auto auto;">R$ {{number_format($v->total,2,",",".")}}</p>
        </div>
        
        
    </div>
    @endforeach
    
    
    
</section>
  

<input type="hidden" name="valor" id="valor" value="">


<div id="btn_submit"></div>
@else
    <h3 class="text-center py-3">Não há planos com esses parâmetros, tente outros</h3>

@endif

