@extends('adminlte::page')
@section('title', 'Comissões')
@section('content_header')
    <h3>Corretor</h3>
@stop
@section('content')
    <div class="card">

        <div class="card-body">
            <h4>Comissão</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Parcela</th>
                        <th>Valor</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($comissoes as $c)
                    <tr>
                        <td>{{date('d/m/Y',strtotime($c->data))}}</td>
                        <td>{{$c->parcela}}</td>
                        <td>{{number_format($c->valor,2,",",".")}}</td>
                       
                        <td>
                            <i 
                                class="far fa-thumbs-{{$c->status ? 'up' : 'down'}} fa-2x status" 
                                
                                data-toggleclass="far fa-thumbs-{{$c->status ? 'down' : 'up'}} fa-2x status"  
                                data-id="{{$c->id}}"
                                >
                            </i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>    
            
            


        </div>


    </div>

    <div class="card">
        <div class="card-header">
            <h3>Premiação</h3>
        </div>
        <div class="card-body">
        
            <table class="table">
                <thead>
                    <tr>
                        <th>Premiacao</th>
                        
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{number_format($premiacao->total,2,",",".")}}</td>
                        <td>status</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h4>Corretora</h4>


@stop   
@section('js')
   <script>
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


           $('.status').on('click',function(){
                let classeAtual = $(this).attr('class')
                let toggle = $(this).attr('data-toggleclass');
                $(this).attr('class',toggle);
                $(this).attr('data-toggleclass', classeAtual);
                let id = $(this).attr('data-id');
                $.ajax({
                    method:"POST",
                    data:"id="+id,
                    url:"{{route('comissoes.mudarStatus')}}"
                    
                })
           });  
        });
   </script>
@stop
@section('css')

     
@stop
