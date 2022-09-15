@foreach($parcelas as $k => $p)
<div class="campo_repetir">
    <label>Parcela {{$k+1}}:</label> 
    <input type="text" id="premiacoes" class="premiacoes" name="premiacoes[]" value="{{$p->valor}}" />
    <button type="button" value="Delete" class="btn btn-danger btn-sm deletar_campo"><i class="fas fa-minus"></i></button>
</div>
@endforeach
<input type="hidden" name="last_parcela" id="last_parcela" value="{{count($parcelas)}}">