@extends('adminlte::page')
@section('title', 'Detalhes Orçamento')
@section('content_header')
@stop
@section('content')
<ol class="breadcrumb py-3">
    @if(auth()->user()->admin)
    <li class="breadcrumb-item"><a href="{{route('orcamento.admin.show',$cliente->user_id)}}">Listar Meus Clientes</a></li>
    @else
    <li class="breadcrumb-item"><a href="{{route('orcamento.corretor.show',$cliente->user_id)}}">Listar Meus Clientes</a></li>
    @endif
    <li class="breadcrumb-item"><a href="{{route('orcamento.detalhes',$cliente->id)}}">Orçamentos cliente {{$cliente->nome}}</a></li>
    <li class="breadcrumb-item">Detalhes</li>
</ol>
    <div class="card px-3 py-3">
       <div class="card-body">
            @if(count($etiquetas))
                Status:
                <form action="" method="POST" class="form-inline">
                    @csrf
                    @foreach($etiquetas as $et)
                        <button data-orcamento="{{$id}}" data-etiqueta="{{$et->id}}" type="button" class="mudarStatus btn btn-outline-{{$et->id == $status ? 'primary' : 'dark'}}" style="margin-right:10px;"><i class="fas fa-check"></i>{{$et->nome}}</button>
                    @endforeach
                </form> 
            @endif

            <hr />

            <div>

            </div>


            <h3 style="color:brown;"> - Cliente</h3>
            <div class="row">
                <div class="col-6">
                    <p><strong>Nome:</strong> {{$cliente->nome}}</p>
                    <p><strong>Email:</strong> {{$cliente->email}}</p>
                </div>    
                <div class="col-6">
                    <p><strong>Telefone:</strong> {{$cliente->telefone}}</p>
                    <p><strong>Cidade:</strong> {{$cidade->cidade}}</p>
                </div>    
            </div>        
            <hr />        
            <h3 style="color:brown;"> - Faixas Etarias</h3>        
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Faixa Etaria</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faixas as $f)
                        <tr>
                            <td>{{$f->nome}}</td>
                            <th>{{$f->pivot->quantidade}}</th>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="display:flex;justify-content: flex-end;">Total Vidas:</td>
                        <th>{{$total}}</th>
                    </tr>
                </tfoot>
            </table> 
        
        </div>
    </div>
@stop


@section('js')
    <script>
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



           $(".mudarStatus").on('click',function(){
                let orcamento = $(this).attr('data-orcamento');
                let etiqueta = $(this).attr('data-etiqueta');
                $.ajax({
                    method:"POST",
                    url:"{{ route('orcamentos.mudar.etiqueta') }}",
                    data:"orcamento="+orcamento+"&etiqueta="+etiqueta,
                    success:function(res) {
                        console.log(res);
                    }
                })
                $(".mudarStatus").removeClass().addClass("mudarStatus btn btn-outline-dark");
                $(this).removeClass().addClass("mudarStatus btn btn-outline-primary");
                
                
           });
        });
    </script>
@stop