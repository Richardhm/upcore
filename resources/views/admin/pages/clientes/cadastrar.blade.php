@extends('adminlte::page')

@section('title', 'Clientes Corretores')
@section('plugins.FullCalendar', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
<div class="card-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Listar Clientes</a></li>
                
            </ol>
        </nav>
    </div>  
@stop

@section('content')
   
    <div class="card">

        <div class="card-body">
        <form action="" method="post">
                        @csrf
                        
                        <div class="form-group">
                            <label for="">Pessoa Fisica/Pessoa Juridica</label>
                            <select name="modelo" id="modelo" class="form-control">
                                <option value="">-- Escolher PF/PJ --</option>
                                <option value="pf">Pessoa Fisica</option> 
                                <option value="pj">Pessoa Juridica</option> 
                           </select> 
                           <div class="errormodelo"></div>
                        </div>
                        <div class="form-row">
                            <div class="col-4">
                                <label for="">Nome:</label>
                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome Cliente">    
                                <div class="errornome"></div>
                            </div>
                            <div class="col-4">
                                <label for="">Cidade:</label>
                                <select name="cidade_id" id="cidade_id" class="form-control">
                                    <option value="">-- Escolher Cidade --</option>
                                    @foreach($cidades as $c)
                                        <option value="{{$c->id}}">{{$c->nome}}</option>     
                                    @endforeach
                                </select>
                                <div class="errorcidade"></div>
                            </div>    
                            <div class="col-4">
                                <label for="telefone">Celular:</label>
                                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone">  
                                <div class="errortelefone"></div>  
                            </div>
                        </div>

                        <div class="form-group empresa_dados"></div>

                        <div class="form-group mb-3">
                            <label for="">Email:</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">    
                            <div class="erroremail"></div>  
                        </div>
                        
                        <input type="submit" class="btn btn-primary btn-block" value="Cadastrar">
                    </form>
                   
                    
                
            
        </div>   
    <div>
@stop
@section('js')
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
         
        $(function(){
            $('#telefone').mask('(00) 0 0000-0000');       
           
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
            
            
            
            $("select[name='modelo']").on('change',function(){
                let valor = $(this).val();
                if(valor == "pj") {
                    $('.empresa_dados').html(
                        "<div class='form-row my-3'>"+
                            "<div class='col'>"+
                                "<label for='cnpj'>CNPJ:</label>"+
                                "<input type='text' name='cnpj' id='cnpj' class='form-control' placeholder='XX.XXX.XXX/XXXX-XX' />"+
                            "</div>"+
                            "<div class='col'>"+
                                "<label for='nome_empresa'>Nome Empresa:</label>"+
                                "<input type='text' name='nome_empresa' id='nome_empresa' class='form-control' placeholder='Nome Empresa' />"+
                            "</div>"+
                        "</div>"
                    );
                    $('#cnpj').mask('00.000.000/0000-00');
                } else {
                    $('.empresa_dados').html("");
                }
            });


            $("form").on('submit',function(){
                $.ajax({
                    method:"POST",
                    url:"{{route('clientes.store')}}",
                    data:$(this).serialize(),
                    success:function(res) {
                        if(res == "errormodelo") {
                            $('.errormodelo').html('<p class="alert alert-danger">Modelo campo e obrigatório</p>') 
                            return false;    
                        } else {
                            $(".errormodelo").html('');

                        }
                        if(res == "errornome") {
                            $('.errornome').html('<p class="alert alert-danger">Nome campo e obrigatório</p>')
                            return false;
                        } else {
                            $(".errornome").html('');
                        }

                        if(res == "errorcidade") {
                            $('.errorcidade').html('<p class="alert alert-danger">Cidade campo e obrigatório</p>')     
                            return false;
                        } else {
                            $(".errorcidade").html('');
                        }
                        if(res == "erroremail") {
                            $('.erroremail').html('<p class="alert alert-danger">Email campo e obrigatório</p>')     
                            return false;
                        } else {
                            $('.erroremail').html('');
                        }

                        if(res == "errortelefone") {
                            $('.errortelefone').html('<p class="alert alert-danger">Celular campo e obrigatório</p>')   
                            return false;  
                        } else {
                            $('.errortelefone').html('');  
                        }

                        Swal.fire({
                            title: '<p>Cliente <b><u>'+res.nome+'</u></b> cadastrado com sucesso!</p>',
                            icon: 'success',
                            type: 'success',
                            showCloseButton: true,
                            html:
                                '<p>O que deseja fazer?</p><hr />'+
                                "<a class='btn btn-primary btn-sm mr-5' href='/admin/cotacao/orcamento/"+res.id+"'>Orçamento</a> <a class='btn btn-info btn-sm mr-5' href='/admin/cotacao/contrato/"+res.id+"'>Contrato</a><a class='btn btn-secondary btn-sm mr-5' href='{{route('clientes.index')}}'>Listar Clientes</a></div>",
                                
                            
                            showCancelButton: false,
                            showConfirmButton: false
                            
                        })
                        
                    }
                });
                return false;
            });








        });




    </script>




@stop