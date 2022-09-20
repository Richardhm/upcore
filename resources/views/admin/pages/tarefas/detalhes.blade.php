@extends('adminlte::page')

@section('title', 'Tarefas Corretores')
@section('content_header')
@stop

@section('content')
<h4 class="py-3 text-center">Tarefas</h4>
<ol class="breadcrumb py-3">
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('tarefas.home')}}">Listar Tarefas Corretores</a></li>
    <li class="breadcrumb-item">Detalhes</li>
</ol>

    <div class="card card-info">


        <div class="card-header">
            <h3 class="card-title">Todas as Tarefas</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        
        
        <div class="card-body">
            @if(count($tarefas) >= 1)
                <table class="table">
                    <thead>
                        <th>Titulo</th>
                        <th>Descrição</th>
                        <th class="text-center">Data Execução da tarefa</th>
                        <th>Cliente</th>
                    </thead>
                    <tbody>
                        @foreach($tarefas as $t)
                            <tr>
                                <td>{{$t->title}}</td>
                                <td>{{$t->descricao}}</td>
                                <td class="text-center">{{date('d/m/Y',strtotime($t->data))}}</td>
                                <td>{{$t->cliente}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            @else

            @endif
        </div>
    </div>


    <h3 class="bg-navy color-palette text-center rounded py-2">Perdas</h3>

    <div class="row">
        
        <div class="col-6">
            <div class="card card-navy">

                <div class="card-header">
                    <h3 class="card-title">Preço</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(count($preco) >= 1)
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                </tr>
                            </thead>
                            <tbody>                
                                @foreach($preco as $p)
                                    <tr>
                                        <td>{{$p->nome}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Sem Resultado</p>     
                    @endif
                </div>    
            </div>    
        </div>


        <div class="col-6">
            <div class="card card-navy">
                
                <div class="card-header">
                    <h3 class="card-title">Já Tem Plano</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>



                <div class="card-body">
            
                    @if(count($ja_tem_plano) >= 1)
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ja_tem_plano as $p)
                                    <tr>
                                        <td>{{$p->nome}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                            <p>Sem Resultado</p>     
                    @endif  
                </div>    
            </div>  
        </div>
    </div>        
            
            
    <div class="row">
        <div class="col-6">

            <div class="card card-navy">
                
                <div class="card-header">
                    <h3 class="card-title">Fez Unimed</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>





                <div class="card-body">
                
                    @if(count($fez_unimed) >= 1)
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fez_unimed as $p)
                                    <tr>
                                        <td>{{$p->nome}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Sem Resultado</p>     
                    @endif
                </div>    
            </div>        
        </div>

        <div class="col-6">

            <div class="card card-navy">
                
                <div class="card-header">
                    <h3 class="card-title">Sem Interesse</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>



                <div class="card-body">
                    @if(count($sem_interesse) >= 1)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tarefa</th>
                                    <th>Trocar De Corretor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sem_interesse as $p)
                                    <tr>
                                        <td data-toggle="modal" data-target="#exampleModal" class="verdatalhe" data-id="{{$p->id}}">{{$p->nome}}</td>
                                        <td>{{$p->title}}</td>
                                        <td>
                                            <select name="mudar_corretor" class="form-control mudar_corretor" data-atual="{{$p->cliente_id}}">
                                                @foreach($corretores as $c)
                                                    <option value="">--Escolher Corretor--</option>
                                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach  
                            </tbody>
                        </table>     
                    @else
                        <p>Sem Resultado</p>     
                    @endif
                </div>    
            </div>    
        </div>
    </div>    
    
    <div class="card card-danger">
        
        <div class="card-header">
            <h3 class="card-title">Clientes Sem Tarefa</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>




        <div class="card-body">
            
        @if(count($sem_tarefa) >= 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th class="text-center">Data de Cadastro Cliente</th>
                            
                            <th>Trocar De Corretor</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($sem_tarefa as $p)
                            <tr>
                                <td>{{$p->nome}}</td>
                                <td class="text-center">{{date('d/m/Y',strtotime($p->created_at))}}</td>
                               
                                <td width="220px">
                                    <select name="mudar_corretor" class="form-control mudar_corretor" data-atual="{{$p->id}}">
                                        @foreach($corretores as $c)
                                            <option value="">--Escolher Corretor--</option>
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                
           @else
                <p>Sem Resultado</p>     
           @endif



        </div>    
    </div>    


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalhes da Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="cliente_modal"></p>
                <p id="titulo_modal"></p>
                <p id="descricao_modal"></p>
                <p id="descricao_motivo_modal"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                
            </div>
            </div>
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



            $("body").on('change','.mudar_corretor',function(){
                let cliente = $(this).attr('data-atual');
                let user = $(this).val();
                $(this).closest('tr').fadeOut('slow');
                $.ajax({
                    url:"{{route('tarefas.mudarcorretor')}}",
                    method:"POST",
                    data:"cliente="+cliente+"&user="+user,
                    success:function(res) {
                        console.log(res);
                    }
                    
                });
            });

            $('body').on('click','.verdatalhe',function(){
                let id_tarefa = $(this).attr('data-id');
                $.ajax({
                    url:"{{route('tarefas.detalhesperda')}}",
                    method:"POST",
                    data:"id_tarefa="+id_tarefa,
                    success:function(res) {
                        $("#cliente_modal").html("<b>Cliente:</b> "+res.cliente);
                        $("#titulo_modal").html("<b>Tarefa:</b> "+res.title);
                        $("#descricao_modal").html("<b>Descrição da tarefa:</b><br /> "+res.descricao);
                        $("#descricao_motivo_modal").html("<b>Descrição do motivo da perda:</b> <br />"+res.descricao_motivo);
                    }
                })
            });




        });



        
    </script>

@stop

@section('css')
   
@stop