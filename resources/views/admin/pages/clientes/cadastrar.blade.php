@extends('adminlte::page')

@section('title', 'Clientes Corretores')
@section('plugins.FullCalendar', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h4>Cadastrar Cliente</h4>
@stop

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Listar Clientes</a></li>
        <li class="breadcrumb-item">Cadastrar Cliente</li>
    </ol>   
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
                                @if($errors->has('celular'))
                                    <p class="alert alert-danger">{{$errors->first('celular')}}</p>
                                @endif
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

           $("#telefone").on('change',function(){
                let telefone = $(this).val();
                $.ajax({
                    method:"POST",
                    data:"telefone="+telefone,
                    url:"{{route('cliente.verificartelefone')}}",
                    success:function(res) {
                        if(res != "nada" && res != "indisponivel") {
                            
                            $("input[type='submit']").attr('disabled',true);
                            $('#email').val(res.email);
                            $('#nome').val(res.nome);
                            $("#cidade_id").val(res.cidade_id);
                            if(res.pessoa_fisica) {
                                $("#modelo").find("option[value='pf']").attr("selected", true);
                            } else {
                                $("#modelo").find("option[value='pj']").attr("selected", true);
                            }


                            Swal.fire({
                                title: '<h4>Cliente '+res.nome+' já esta cadastrado!</h4>',
                                icon: 'info',
                                type: 'info',
                                showCloseButton: true,
                                html:
                                    '<hr />'+
                                    '<p>Cliente Cadastrado em '+res.data_criacao+'</p><p>Seu status atual é <b>'+res.etiqueta.nome+'</b></p><p>Cidade: <b>'+res.cidade.nome+'</b></p>'+
                                    '<p>O que deseja fazer?</p><hr />'+
                                    "<a class='btn btn-primary btn-sm mr-5' href='/admin/cotacao/orcamento/"+res.id+"'>Orçamento</a> <a class='btn btn-info btn-sm mr-5' href='/admin/cotacao/contrato/"+res.id+"'>Contrato</a><a class='btn btn-secondary btn-sm mr-5' href='{{route('clientes.index')}}'>Listar Clientes</a></div>",
                                showCancelButton: false,
                                showConfirmButton: false                            
                            });
                        }

                        if(res == "indisponivel") {
                            Swal.fire({
                                icon: 'error',
                                type:'error',
                                title: 'Oops...',
                                
                                showCloseButton: true,
                                html:
                                    '<hr />'+
                                    '<h3>Cliente Indisponível</h3>'
                            })
                        }
                        


                    }

                })
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

                        if(res == "erroremailjacadastrado") {
                            $('.erroremail').html('<p class="alert alert-danger">Este Email já está cadastrado</p>')     
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

                        if(res == "errortelefonejacadastrado") {
                            $('.errortelefone').html('<p class="alert alert-danger">Este celular já está cadastrado</p>')   
                            return false;  
                        } else {
                            $('.errortelefone').html('');  
                        }

                        

                        if(res == "clienteexiste") {
                            $.ajax({
                                url:"{{route('cliente.existe')}}",
                                method:"POST",
                                data:"nome="+$('input[name="nome"]').val()+"&email="+$('input[name="email"]').val()+"&telefone="+$('input[name="telefone"]').val()
                            }).done(function(data){
                                Swal.fire({
                                    title: '<h4>Cliente '+data.nome+' já esta cadastrado!</h4>',
                                    icon: 'info',
                                    type: 'info',
                                    showCloseButton: true,
                                    html:
                                        '<hr />'+
                                        '<p>Cadastrado em '+data.cadastrado+' pelo corretor '+data.user+'</p><p>Seu status atual é <b>'+data.etiqueta+'</b> </p>'+
                                        '<p>O que deseja fazer?</p><hr />'+
                                        "<a class='btn btn-primary btn-sm mr-5' href='/admin/cotacao/orcamento/"+data.id+"'>Orçamento</a> <a class='btn btn-info btn-sm mr-5' href='/admin/cotacao/contrato/"+data.id+"'>Contrato</a><a class='btn btn-secondary btn-sm mr-5' href='{{route('clientes.index')}}'>Listar Clientes</a></div>",
                                    showCancelButton: false,
                                    showConfirmButton: false                            
                                });
                            });
                            return false;   
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