@foreach($tarefas as $tt)
    <div style="text-align:center;" data-id="{{$tt->id}}" class="alvos">
        <p>{{$tt->title}} - {{$tt->data}}</p>  
    </div>
@endforeach