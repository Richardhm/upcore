@extends('adminlte::page')
@section('title', 'Listar Comissoes')
@section('content_header')
    <div class="d-flex justify-content-between">
        <div>
            <h1 class="text-white">
                Cadastrar Comissoes: <button type="button" class="btn btn-warning cadastrar_comissoes" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i>
                </button>
            </h1>
        </div>
        
    </div>
@stop
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('corretores.index')}}">Voltar Listagem de Colaboradores</a></li>
        <li class="breadcrumb-item">Listagem de Comissões do Corretor <b>{{$corretor->name}}</b></li>
    </ol>   
    
    <div class="row">
        <div class="col-12">

            <div class="card">
                @if(count($comissoes) >= 1)
                    <div class="card-body">
                        <div class="card-header mb-2">
                            <h2>Comissões</h2>
                        </div>
                        <div class="d-flex flex-wrap">
                            @php  $parcelas = "";@endphp    
                            @foreach($comissoes as $c)
                                <div class="cards mr-3 d-flex flex-column" style="border:1px solid black;border-radius:5px;margin-bottom:10px;flex-basis:30%;flex-wrap:wrap;">
                                    <div class="d-flex" style="min-height:80px;flex-wrap:wrap;">
                                        <div class="text-center d-flex justify-content-center align-items-center" style="border-right:1px solid black;border-bottom:1px solid black;width:50%;">
                                            <span class="" data-administradora="{{$c->id_administradora}}" style="font-size:0.875em;">{{$c->administradora}}</span>
                                        </div>
                                        <div class="text-center d-flex justify-content-center align-items-center" style="border-bottom:1px solid black;width:50%;">
                                            <span class="text-center" data-plano="{{$c->id_plano}}" style="font-size:0.875em;">
                                                {{$c->plano}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <span data-cidade="{{$c->id_cidade}}"><b>Cidade: </b>&nbsp; {{$c->cidade}}</span>
                                    </div>
                                    @php
                                        $parcelas = explode(",",$c->parcela)
                                    @endphp
                                    <div style="border-top:1px solid black;">  
                                        @foreach($parcelas as $k => $p)
                                            <p class="d-flex justify-content-around mt-3 parcelas" style="font-size:0.875em;"><b>Parcela {{$k+1}}:</b><span>{{$p}}%</span></p>
                                        @endforeach
                                    </div>                            
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else 
                    <h5 class="py-3 text-center">Este Corretor Não possui comissões cadastradas!</h5>
                @endif     
            </div>

        </div>

        
    </div>    


    <!--------------------------------------------- Modal de Cadastro -------------------------------------------------------------->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastrar Comissão/Premiação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form_cadastrar_comissao">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{$corretor->id}}">
                    <div class="form-row">

                        <div class="col">
                            <label for="name">Administradora:</label>
                            <select name="administradora_id" id="administradora_id" class="form-control">
                                <option value="">--Escolher Administradora--</option>
                                @foreach($administradoras as $a)
                                <option value="{{$a->id}}" {{old('administradora_id') == $a->id ? 'selected' : ''}}>{{$a->nome}}</option>
                                @endforeach
                            </select>
                            <div class="erroradministradora"></div>
                        </div>
                        <div class="col">
                            <label for="plano_id">Plano:</label>
                            <select name="plano_id" id="plano_id" class="form-control">
                                <option value="">--Escolher Plano--</option>
                                @foreach($planos as $p)
                                <option value="{{$p->id}}" {{old('plano_id') == $p->id ? 'selected' : ''}}>{{$p->nome}}</option>
                                @endforeach
                            </select>
                            <div class="errorplano"></div>
                        </div>
                        <div class="col">
                            <label for="cidade_id">Cidade:</label>
                            <select name="cidade_id" id="cidade_id" class="form-control">
                                <option value="">--Escolher Cidade--</option>
                                @foreach($cidades as $c)
                                <option value="{{$c->id}}" {{old('cidade_id') == $c->id ? 'selected' : ''}}>{{$c->nome}}</option>
                                @endforeach
                            </select>
                            <div class="errorcidade"></div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col border-right border-dark">
                            <div class="form-group">
                                <label>Comissões:</label> 
                                <div class="errorparcela"></div>
                                <div class="campos">
                                    <div class="campo_repetir">
                                        <label>Parcela 1:</label> 
                                        <input type="text" id="parcelas" name="parcelas[]" placeholder="%" />
                                        <button type="button" value="Delete" class="btn btn-danger btn-sm deletar_campo"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm acrescentar"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="col">

                            <div class="form-group">
                                <label>Premiacões:</label> 
                                <div class="errorparcela"></div>
                                <div class="campos_premiacao">
                                    <div class="campo_repetir_premiacao">
                                        <label>Parcela 1:</label> 
                                        <input type="text" id="premiacoes" class="premiacoes" name="premiacoes[]" placeholder="R$" />
                                        <button type="button" value="Delete" class="btn btn-danger btn-sm deletar_campo_premiacao"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm acrescentar_premiacao"><i class="fas fa-plus"></i></button>
                            </div>



                        </div>


                    </div>

                    <hr>
                    <button type="submit" class="btn btn-info btn-block">Cadastrar Comissão/Premiação</button>
                </form>
            </div>
            <div class="modal-footer">
                
                
            </div>
            </div>
        </div>
    </div>
    <!------------------------------------------ Fim Modal de Cadastro ----------------------------------------------------------------->


    <!------------------------------------------ Editar Modal --------------------------------------------------------------------->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Comissão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" name="form_editar_comissao" id="form_editar_comissao">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{$corretor->id}}">
                    <input type="hidden" name="plano_editar" id="plano_editar">
                    <input type="hidden" name="administradora_editar" id="administradora_editar">
                    <input type="hidden" name="cidade_editar" id="cidade_editar">
                    <div class="form-row">

                        <div class="col">
                            <label for="name">Administradora:</label>
                            <select name="administradora_id" id="administradora_id" class="form-control">
                                <option value="">--Escolher Administradora--</option>
                                @foreach($administradoras as $a)
                                <option value="{{$a->id}}">{{$a->nome}}</option>
                                @endforeach
                            </select>
                            <div class="erroradministradora"></div>
                        </div>
                        <div class="col">
                            <label for="plano_id">Plano:</label>
                            <select name="plano_id" id="plano_id" class="form-control">
                                <option value="">--Escolher Plano--</option>
                                @foreach($planos as $p)
                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                @endforeach
                            </select>
                            <div class="errorplano"></div>
                        </div>
                        <div class="col">
                            <label for="cidade_id">Cidade:</label>
                            <select name="cidade_id" id="cidade_id" class="form-control">
                                <option value="">--Escolher Cidade--</option>
                                @foreach($cidades as $c)
                                <option value="{{$c->id}}">{{$c->nome}}</option>
                                @endforeach
                            </select>
                            <div class="errorcidade"></div>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Comissões:</label> 
                        <div class="errorparcela"></div>
                        <div class="campos">
                            
                            
                        </div>
                        <button type="button" class="btn btn-primary btn-sm acrescentar"><i class="fas fa-plus"></i></button>
                        
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-info btn-block">Editar Comissão</button>
                </form>
            </div>
            <div class="modal-footer">
                
                
            </div>
            </div>
        </div>
    </div>
    <!------------------------------------------ Fim Editar Modal ----------------------------------------------------------------->

    <!------------------------------------------ Cadastrar Premiações ------------------------------------------------------------->
    <div class="modal fade" id="cadastrarPremiacaoModal" tabindex="-1" aria-labelledby="cadastrarPremiacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastrarPremiacaoLabel">Cadastrar Premiacão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{route('premiacao.corretores.store')}}" method="post" enctype="multipart/form-data" class="invoice-repeater">
                @csrf
            
                <input type="hidden" name="user_id" id="user_id" value="{{$corretor->id}}">

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Administradora</label>
                        <select name="administradora_id" id="administradora_id" class="form-control">
                            <option value="">--Escolha Uma Administradora--</option>
                            @foreach($administradoras as $a)
                            <option value="{{$a->id}}" {{old('administradora_id') == $a->id ? 'selected' : ''}}>{{$a->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('administradora_id'))
                            <p class="alert alert-danger">{{$errors->first('administradora_id')}}</p>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cpf">Plano:</label>
                        <select name="plano_id" id="plano_id" class="form-control">
                            <option value="">--Escolha Um Plano--</option>
                            @foreach($planos as $p)
                            <option value="{{$p->id}}" {{old('plano_id') == $p->id ? 'selected' : ''}}>{{$p->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('plano_id'))
                            <p class="alert alert-danger">{{$errors->first('plano_id')}}</p>
                        @endif
                    </div>
                </div>

            
                <div class="form-group">
                    <label>Premiacões:</label> 
                    <div class="errorparcela"></div>
                    <div class="campos_premiacao">
                        <div class="campo_repetir_premiacao">
                            <label>Parcela 1:</label> 
                            <input type="text" id="premiacoes" class="premiacoes" name="premiacoes[]" placeholder="R$" />
                            <button type="button" value="Delete" class="btn btn-danger btn-sm deletar_campo_premiacao"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm acrescentar_premiacao"><i class="fas fa-plus"></i></button>
                </div>
           
                <button class="btn btn-primary btn-block mt-5" type="submit">Cadastrar Premiação</button>
           </form>
            </div>
            <div class="modal-footer">
                
                
            </div>
            </div>
        </div>
    </div>
    <!------------------------------------------ Fim Cadastrar Premiações ------------------------------------------------------------->

    <!------------------------------------------ Editar Premiação --------------------------------------------------------------------->
    <div class="modal fade" id="editarPremiacaoModal" tabindex="-1" aria-labelledby="editarPremiacaoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cadastrarPremiacaoLabel">Editar Premiacão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{route('premiacao.corretores.edit')}}" id="editar_premiacao"  method="post" enctype="multipart/form-data" class="invoice-repeater">
                @csrf
            
                <input type="hidden" name="user_id" id="user_id" value="{{$corretor->id}}">
                <input type="hidden" name="plano_premiacao_editar" id="plano_premiacao_editar">
                <input type="hidden" name="administradora_premiacao_editar" id="administradora_premiacao_editar">

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Administradora</label>
                        <select name="administradora_premiacao_id_select" id="administradora_premiacao_id_select" class="form-control">
                            <option value="">--Escolha Uma Administradora--</option>
                            @foreach($administradoras as $a)
                            <option value="{{$a->id}}" {{old('administradora_premiacao_id_select') == $a->id ? 'selected' : ''}}>{{$a->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('administradora_premiacao_id_select'))
                            <p class="alert alert-danger">{{$errors->first('administradora_premiacao_id_select')}}</p>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="cpf">Plano:</label>
                        <select name="plano_premiacao_id_select" id="plano_premiacao_id_select" class="form-control">
                            <option value="">--Escolha Um Plano--</option>
                            @foreach($planos as $p)
                            <option value="{{$p->id}}" {{old('plano_premiacao_id_select') == $p->id ? 'selected' : ''}}>{{$p->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('plano_premiacao_id_select'))
                            <p class="alert alert-danger">{{$errors->first('plano_premiacao_id_select')}}</p>
                        @endif
                    </div>
                </div>

            
                <div class="form-group">
                    <label>Premiacões:</label> 
                    <div class="errorparcela"></div>
                    <div class="campos_premiacao">
                        <div class="campo_repetir_premiacao">
                            <label>Parcela 1:</label> 
                            <input type="text" id="premiacoes" class="premiacoes" name="premiacoes[]" placeholder="R$" />
                            <button type="button" value="Delete" class="btn btn-danger btn-sm deletar_campo_premiacao"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm acrescentar_premiacao"><i class="fas fa-plus"></i></button>
                </div>
           
                <button class="btn btn-primary btn-block mt-5" type="submit">Editar Premiação</button>
           </form>
            </div>
            <div class="modal-footer">
                
                
            </div>
            </div>
        </div>
    </div>
    <!------------------------------------------ Fim Editar Premiação ----------------------------------------------------------------->

@stop
@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){
            $('.premiacoes').mask("#.##0,00", {reverse: true});
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           let add = 1;
           let premiacao = 1;

           $('.cards').on('click',function(){
                $('#editarModal').modal('show');
                let administradora = $(this).find('span:eq(0)').attr('data-administradora');
                let plano = $(this).find('span:eq(1)').attr('data-plano');
                let cidade = $(this).find('span:eq(2)').attr('data-cidade');
                $("#plano_editar").val(plano);
                $("#administradora_editar").val(administradora);
                $("#cidade_editar").val(cidade);
            }); 

            $('.card_premiacao').on('click',function(){
                
                $("#editarPremiacaoModal").modal('show');
                let administradora = $(this).find('span:eq(0)').attr('data-administradora');
                let plano = $(this).find('span:eq(1)').attr('data-plano');
                
                $("#plano_premiacao_editar").val(plano);
                $("#administradora_premiacao_editar").val(administradora);
                
            });

            $('#editarPremiacaoModal').on('shown.bs.modal',function(e){
                let form = $(this);
                let administradora = form.find("#administradora_premiacao_editar").val();
                let plano = form.find("#plano_premiacao_editar").val();
                let user = form.find("#user_id").val();
                $("#editarPremiacaoModal").find('select[name="administradora_premiacao_id_select"]').find("option[value="+administradora+"]").attr('selected','selected');
                $("#editarPremiacaoModal").find('select[name="plano_premiacao_id_select"]').find("option[value="+plano+"]").attr('selected','selected');
                $.ajax({
                    url:"{{route('premiacao.pegarparcelas.ajax')}}",
                    method:"POST",
                    data:"administradora="+administradora+"&plano="+plano+"&user="+user,
                    success:function(res) {
                        premiacao = parseInt($($(res).last()[0]).val());                        
                        $('.campos_premiacao').html(res);
                    }
                });
            });


            $('#editarModal').on('shown.bs.modal', function (event) {
                let form = $(this);
                let administradora = form.find("#administradora_editar").val();
                let plano = form.find("#plano_editar").val();
                let cidade = form.find("#cidade_editar").val();     
                let user = form.find("#user_id").val();   


                $("#form_editar_comissao").find('select[name="administradora_id"]').find("option[value="+administradora+"]").attr('selected','selected');
                $("#form_editar_comissao").find('select[name="plano_id"]').find("option[value="+plano+"]").attr('selected','selected');
                $("#form_editar_comissao").find('select[name="cidade_id"]').find("option[value="+cidade+"]").attr('selected','selected');
                let last = document.body.last_parcela;
                $.ajax({
                    url:"{{route('comissao.pegarparcelas.ajax')}}",
                    method:"POST",
                    data:"administradora="+administradora+"&plano="+plano+"&cidade="+cidade+"&user="+user,
                    success:function(res) {
                        add = parseInt($($(res).last()[0]).val());                        
                        $('.campos').html(res);
                    }
                });
            });

            
            $('.acrescentar').on('click',function(){
                add++;
                $(".campos").append('<div class="campo_repetir"><label>Parcela '+add+': </label> <input type="text" id="parcelas" name="parcelas[]" placeholder="%" /> <button type="button" value="Delete" class="btn btn-danger btn-sm deletar_campo"><i class="fas fa-minus"></i></button></div>')   
            });

            $("body").on('click','.deletar_campo',function(){
                add--;
                let removido = parseInt($($(this).closest('.campo_repetir').find('label')).text().replace("Parcela ","").replace(":",""));
                $(this).closest('.campo_repetir').remove();
                $.each($('.campo_repetir').find('label'),function(i,e){
                    if(parseInt($(e).text().replace("Parcela ","").replace(":","")) > removido) {
                        let calculado = parseInt($(e).text().replace("Parcela ","").replace(":","")) - 1;
                        $(e).html("Parcela "+calculado+": ");
                    }
                });
            });

            $('.acrescentar_premiacao').on('click',function(){
                premiacao++;
                $(".campos_premiacao").append('<div class="campo_repetir_premiacao"><label>Parcela '+premiacao+': </label> <input type="text" class="premiacoes" id="premiacoes" name="premiacoes[]" placeholder="R$" />  <button type="button" value="Delete" class="btn btn-danger btn-sm deletar_campo_premiacao"><i class="fas fa-minus"></i></button></div>')   
                $('.premiacoes').mask("#.##0,00", {reverse: true});
            });

            $('body').on('click','.deletar_campo_premiacao',function(){
                premiacao--;
                let removido = parseInt($($(this).closest('.campo_repetir_premiacao').find('label')).text().replace("Parcela ","").replace(":",""));
                $(this).closest('.campo_repetir_premiacao').remove();
                $.each($('.campo_repetir_premiacao').find('label'),function(i,e){
                    if(parseInt($(e).text().replace("Parcela ","").replace(":","")) > removido) {
                        let calculado = parseInt($(e).text().replace("Parcela ","").replace(":","")) - 1;
                        $(e).html("Parcela "+calculado+": ");
                    }
                });
            });

            $("form[id='editar_premiacao']").on('submit',function(){
                let dados = $(this).serialize();
                let form = $(this);
                $.ajax({
                    url:"{{route('premiacao.corretores.edit')}}",
                    method:"POST",
                    data:dados,
                    beforeSend:function() {
                        if(form.find("select[name='administradora_premiacao_id_select']").val() ==  "") {
                            $(".erroradministradora").html("<p class='alert alert-danger'>Escolher administradora</p>");
                        } else {
                            $(".erroradministradora").html("");
                        }
                        if(form.find("select[name='plano_premiacao_id_select']").val() ==  "") {
                            $(".errorplano").html("<p class='alert alert-danger'>Escolher Plano</p>");
                        } else {
                            $(".errorplano").html("");
                        }
                        
                        if(form.find('#premiacoes').val().length == 0) {
                            $(".errorparcela").html("<p class='alert alert-danger'>Preencher pelo menos 1 parcela</p>");
                        } else {
                            $(".errorparcela").html("");
                        }
                    },
                    success:function(res) {
                        
                        if(res == "sucesso") {
                            window.location.reload();
                        } else {
                            
                            $('#editarModal').on('hide.bs.modal');
                        }        
                    }
                });
                
                return false;
            });


            $("form[id='form_cadastrar_comissao']").on('submit',function(){
                let dados = $(this).serialize();
                let form = $(this);
                $.ajax({
                    url:"{{route('comissao.corretores.store')}}",
                    method:"POST",
                    data:dados,
                    beforeSend:function() {
                        if(form.find("select[name='administradora_id']").val() ==  "") {
                            $(".erroradministradora").html("<p class='alert alert-danger'>Escolher administradora</p>");
                        } else {
                            $(".erroradministradora").html("");
                        }
                        if(form.find("select[name='plano_id']").val() ==  "") {
                            $(".errorplano").html("<p class='alert alert-danger'>Escolher Plano</p>");
                        } else {
                            $(".errorplano").html("");
                        }
                        if(form.find("select[name='cidade_id']").val() ==  "") {
                            $(".errorcidade").html("<p class='alert alert-danger'>Escolher Cidade</p>");
                        } else {
                            $(".errorcidade").html("");
                        }
                        if(form.find('#parcelas').val().length == 0) {
                            $(".errorparcela").html("<p class='alert alert-danger'>Preencher pelo menos 1 parcela</p>");
                        } else {
                            $(".errorparcela").html("");
                        }

                        if(form.find('#premiacoes').val().length == 0) {
                            $(".errorparcela").html("<p class='alert alert-danger'>Preencher pelo menos 1 parcela</p>");
                        } else {
                            $(".errorparcela").html("");
                        }



                    },
                    success:function(res) {
                        console.log(res);
                    //    if(res == "sucesso") {
                    //         window.location.reload();
                    //     // $("form[id='form_cadastrar_comissao']").submit();
                    //     //     return true;
                    //    } else {
                    //     console.log("Naoooo Entreiii");
                    //    }
                    
                    }
                });
                return false;
            });

            $('body').on('submit','form[name="form_editar_comissao"]',function(){
                let dados = $(this).serialize();
                let form = $(this);
                $.ajax({
                    url:"{{route('comissao.corretores.editar')}}",
                    method:"POST",
                    data:dados,
                    beforeSend:function() {
                        if(form.find("select[name='administradora_id']").val() ==  "") {
                            $(".erroradministradora").html("<p class='alert alert-danger'>Escolher administradora</p>");
                        } else {
                            $(".erroradministradora").html("");
                        }
                        if(form.find("select[name='plano_id']").val() ==  "") {
                            $(".errorplano").html("<p class='alert alert-danger'>Escolher Plano</p>");
                        } else {
                            $(".errorplano").html("");
                        }
                        if(form.find("select[name='cidade_id']").val() ==  "") {
                            $(".errorcidade").html("<p class='alert alert-danger'>Escolher Cidade</p>");
                        } else {
                            $(".errorcidade").html("");
                        }
                        if(form.find('#parcelas').val().length == 0) {
                            $(".errorparcela").html("<p class='alert alert-danger'>Preencher pelo menos 1 parcela</p>");
                        } else {
                            $(".errorparcela").html("");
                        }
                    },
                    success:function(res) {
                        if(res == "sucesso") {
                            window.location.reload();
                        } else {
                            
                            $('#editarModal').on('hide.bs.modal');
                        }        
                    }
                });
                return false;
            });

            $('#editarModal').on('hide.bs.modal', function (event) {
                $("#administradora_editar").val('');
                $("#plano_editar").val('');
                $("#cidade_editar").val('');
                window.location.reload();
            })
           
        });
    </script>
@stop


@section('css')
    <style>        
        .cards:hover {
            cursor:pointer;
            box-shadow: 5px 10px #888888;
        }

        .card_premiacao:hover {
            cursor:pointer;
        }



    </style>
@stop