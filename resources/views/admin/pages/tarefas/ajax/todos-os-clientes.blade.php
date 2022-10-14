@if(count($clientes) >= 1)
    <h4 class="text-white text-center" style="padding:8px;border-bottom:2px solid white;">Clientes</h4>
    @foreach($clientes as $c)
        <a href="#">
            <p class="text-white">{{$c->nome}}</p>
        </a>
    @endforeach
@else   
    <p>Nenhum Cliente</p>
@endif