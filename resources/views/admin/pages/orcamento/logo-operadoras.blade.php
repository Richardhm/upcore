<h3>Escolha a Operadoras</h3>
<div class="imagem-operadora">
    @foreach($operadoras as $o)
        <a href="#" id="{{$o->administradoras_id}}" data-image="imagem">
            <img class="img-fluid" width="120" height="80" src="{{\Illuminate\Support\Facades\Storage::url($o->administradoras_logo)}}" />
        </a>
    @endforeach
</div>
<hr />