@extends('adminlte::page')
@section('title', 'Detalhes Orçamento')
@section('content_header')
@stop
@section('content')
<ol class="breadcrumb py-3">
    <li class="breadcrumb-item"><a href="{{route('orcamentos.por.corretores',[$id_corretora,$id_administrador])}}">Listar Orçamento Corretores</a></li>
    <li class="breadcrumb-item"><a href="{{route('orcamento.por.corretor',$id_corretor)}}">Orçamentos corretor {{$nome_corretor->name}}</a></li>
    <li class="breadcrumb-item">Detalhes</li>
</ol>
    <div class="card px-3 py-3">
       <div class="card-body">
            <div>
                <div class="row">
                    <div class="col-4">
                        Status do Orçamento: <strong>{{$etiquetas->nome}}</strong>
                    </div>
                    <div class="col-4">
                        <img src="{{\Illuminate\Support\Facades\Storage::url($logo)}}" width="100" height="40" alt="">
                    </div>
                    <div class="col-4">
                        Data do Orçamento: <strong>{{date('d/m/Y H:i:s',strtotime($data_criacao))}}</strong>
                    </div>
                </div>
            </div>
            <hr />
            <h3 style="color:brown;"> - Cliente</h3>
            <div class="row">
                <div class="col-6">
                    <p><strong>Nome:</strong> {{$cliente->nome}}</p>
                    <p><strong>Email:</strong> {{$cliente->email}}</p>
                </div>    
                <div class="col-6">
                    <p><strong>Telefone:</strong> {{$cliente->telefone}}</p>
                    <p><strong>Plano:</strong> ???</p>
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