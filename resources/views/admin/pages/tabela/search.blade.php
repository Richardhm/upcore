@extends('adminlte::page')
@section('title', 'Pesquisar')
@section('content_header')
    <h1>Resultado pesquisa</h1>
@stop
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('tabela.index')}}">Criar tabela de preço</a></li>
        <li class="breadcrumb-item">Pesquisa</li>
    </ol>
    <div class="card">
        <div class="card-body">
        <form action="{{route('tabela.pesquisar')}}" method="POST" name="pesquisar_modal">
                <input type="hidden" name="city" id="city" value="{{old('cidade_search')}}">
                <input type="hidden" name="plans" id="plans" value="{{old('planos_search')}}">
                        @csrf
                        <input type="hidden" name="old_operadora" id="old_operadora">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="operadora_search">Operadora:</label>
                                <select name="operadora_search" id="operadora_search" class="form-control">
                                    <option value="">--Escolher a Operadora--</option>
                                    @foreach($operadoras as $oo)
                                        <option value="{{$oo->id}}" {{old('operadora_search') == $oo->id ? 'selected' :  (!empty($operadora_id) && $operadora_id == $oo->id ? 'selected' : '')}} >{{$oo->nome}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('operadora_search'))
                                    <p class="alert alert-danger">{{$errors->first('operadora_search')}}</p>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="administradora_search">Administradora:</label>
                                <select name="administradora_search" id="administradora_search" class="form-control">
                                    <option value="">--Escolher a Administradora--</option>
                                    @foreach($administradoras as $aa)
                                        <option value="{{$aa->id}}" {{$aa->id == old('administradora_search') ? 'selected' : (!empty($administradora_id) && $administradora_id == $aa->id ? 'selected' : '')}}>{{$aa->nome}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('administradora_search'))
                                    <p class="alert alert-danger">{{$errors->first('administradora_search')}}</p>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="planos_search">Planos:</label>
                                <select name="planos_search" id="planos_search" class="form-control">
                                    <option value="">--Escolher o Plano--</option>
                                    <option value="">--Antes escolher a administradora--</option>
                                </select>
                                @if($errors->has('planos_search'))
                                    <p class="alert alert-danger">{{$errors->first('planos_search')}}</p>
                                @endif
                            </div>            
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="cidade_search">Cidade:</label><br />
                                <select name="cidade_search" id="cidade_search" class="form-control">
                                    <option value="">--Escolher a Cidade--</option>
                                </select>  
                                @if($errors->has('cidade_search'))
                                    <p class="alert alert-danger">{{$errors->first('cidade_search')}}</p>
                                @endif 
                            </div>



                            <div class="col-md-4 mb-3">
                                <label for="coparticipacao_search">Coparticipação:</label><br />
                                <select name="coparticipacao_search" id="coparticipacao_search" class="form-control">
                                    <option value="">--Escolher Coparticipacao--</option>
                                    <option value="sim" {{old('coparticipacao_search') == "sim" ? 'selected' : (!empty($coparticipao) && $coparticipacao == 1 ? 'selected' : '')  }}>Sim</option>
                                    <option value="nao" {{old('coparticipacao_search') == "nao" ? 'selected' : (!empty($coparticipao) && $coparticipacao == 0 ? 'selected' : '') }}>Não</option>
                                </select>
                                @if($errors->has('coparticipacao_search'))
                                    <p class="alert alert-danger">{{$errors->first('coparticipacao_search')}}</p>
                                @endif 
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="odonto_search">Odonto:</label><br />
                                <select name="odonto_search" id="odonto_search" class="form-control">
                                    <option value="">--Escolher Odonto--</option>
                                    <option value="sim" {{old('odonto_search') == "sim" ? 'selected' : (!empty($odonto) && $odonto == 1 ? 'selected' : '') }}>Sim</option>
                                    <option value="nao" {{old('odonto_search') == "nao" ? 'selected' : (!empty($odonto) && $odonto == 0 ? 'selected' : '') }}>Não</option>
                                </select>
                                @if($errors->has('odonto_search'))
                                    <p class="alert alert-danger">{{$errors->first('odonto_search')}}</p>
                                @endif 
                            </div>
                            
                        </div>
                        <input type="submit" name="Enviar" value="Pesquisar" class="btn btn-block btn-primary mt-3">
                    </div>                                     
                </form>
   </div>
    @if(isset($header) && !empty($header) && isset($tabelas) && !empty($tabelas))
    <div class="card">
    <table class="table table-sm">
        <thead>
            <tr>
                @foreach($header as $k => $v)              
                    <th colspan="5" style="text-align:center;">{{$v->COPARTICIPACAO_TEXTO}}</th>
                    <tr>
                        <th colspan="5" style="text-align:center;">{{$v->ODONTO_TEXTO}}</th>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align:center;">{{$v->administradora}}</th>
                    </tr>
                @endforeach
            </tr>    
        </thead>
        <tbody>
            <tr>
                <th>Faixa Etaria</th>
                <th>Apartamento</th>
                <th>Enfermaria</th>
                <th>Ambulatorial</th>
            </tr>
            @foreach($tabelas as $k => $v)
                <tr>
                    <th>{{$v->etaria}}</th>
                    <td>
                        @if($v->apartamento >= 1)
                            <button style="border:none;background-color:#FFF;" data-toggle="modal" data-target="#alterarModal" data-id="{{$v->apartamento_id}}" data-valor="{{number_format($v->apartamento,2,',','.')}}">{{number_format($v->apartamento,2,",",".")}}</button>
                        @else
                            {{number_format($v->apartamento,2,",",".")}}
                        @endif
                    </td>
                    <td>
                        @if($v->enfermaria >= 1)
                            <button style="border:none;background-color:#FFF;" data-toggle="modal" data-target="#alterarModal" data-id="{{$v->enfermaria_id}}" data-valor="{{number_format($v->enfermaria,2,',','.')}}">{{number_format($v->enfermaria,2,",",".")}}</button>
                        @else
                            {{number_format($v->enfermaria,2,",",".")}}
                        @endif
                    </td>
                    <td>
                        @if($v->ambulatorial >= 1)
                            <button style="border:none;background-color:#FFF;" data-toggle="modal" data-target="#alterarModal" data-id="{{$v->ambulatorial_id}}" data-valor="{{number_format($v->ambulatorial,2,',','.')}}">{{number_format($v->ambulatorial,2,",",".")}}</button>
                        @else
                            {{number_format($v->ambulatorial,2,",",".")}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alterarModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('orcamento.edit.valor')}}" method="POST" name="alterar_valor" id="alterar_valor">
            @csrf    
            <input type="hidden" name="id" id="id">
            
            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="text" name="valor" id="valor" class="form-control">
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Alterar Dados</button>
      </div>
      </form>
    </div>
  </div>
</div>    
</div>
    @endif
    @if(isset($header) && empty($header) && isset($tabelas) && empty($tabelas))
        <p class="alert alert-danger text-center">Sem Resultados com esses parametros, tente outros</p>
    @endif
@stop
@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){

            $('#operadora_search').on('change',function(){
                $('input[name="old_operadora"]').val($(this).val());
            });

            $('#administradora_search').change(function(){
                let valor = $(this).val();
                verificar_administradora(valor)

            });

            $("#cidade_search").change(function(){
                $('input[name="city"]').val($(this).val());
            });  

            $("#planos_search").change(function(){
                $('input[name="plans"]').val($(this).val());
            });



            $('#valor').mask("#.##0,00", {reverse: true});
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function verificar_administradora(valor,city,plans){
                let selectedCity = (city != null && city != '' ? city : '');
                let selectedPlan = (plans != null && plans != '' ? plans : '');
                if(valor != "") {
                    
                    $.ajax({
                        url:"{{route('cidades.administradoras.pegar')}}",
                        method:"POST",
                        data:"administradora="+valor,
                        success:function(res) {
                            if(res.citys.length >= 1) {
                                $("#cidade_search").html("");
                                $("#cidade_search").prepend("<option value=''>--Escolher a Cidade--</option>")
                                $(res.citys).each(function(index,value){
                                    $('#cidade_search').       
                                    append("<option value='"+value.id+"' "+(value.id == selectedCity ? 'selected' : '')+" >"+value.nome+"</option>")     
                                });
                               
                            } else {
                                $("#cidade_search").html("");
                                $("#cidade_search").append('<option value="">--Esta administradora não possui cidades cadastradas--</option>');
                            }

                            if(res.planos.length >= 1) {
                                $("#planos_search").html("");
                                $("#planos_search").prepend("<option value=''>--Escolher o Plano--</option>");
                                $(res.planos).each(function(index,value){
                                    $('#planos_search').       
                                    append("<option value='"+value.plano_id+"' "+(value.plano_id == selectedPlan ? 'selected' : '')+">"+value.nome_plano+"</option>")     
                                });

                            } else {
                                $("#planos_search").html("");
                                $("#planos_search").append('<option value="">--Esta administradora não possui planos cadastradas--</option>');
                            }
                        }
                    });  

                } 
            }

            verificar_administradora($("#administradora_search").val(),$('input[name="city"]').val(),$('input[name="plans"]').val());


            
            $('#alterarModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var valor = button.data('valor');
                var id = button.data('id');
                var modal = $(this);
                modal.find('.modal-body input[name="valor"]').val(valor.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
                modal.find('.modal-body input[name="id"]').val(id);
            });
            
            $('form[name="alterar_valor"]').on('submit',function(e){
                $.ajax({
                    url:$(this).attr('action'),
                    data:$(this).serialize(),
                    method:"POST",
                    success(res) {
                        if(res == "alterado") {
                            window.location.reload();
                        }
                    }
                });
                return false;
            });    







        });
    </script>    
@stop