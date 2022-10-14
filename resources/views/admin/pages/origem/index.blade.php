@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('title', 'Listar Origens')

@section('content_header')
    <h1 class="text-white">Cadastrar: <a data-toggle="modal" data-target="#cadastrarOrigem" href="{{route('cidades.cadastrar')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop

@section('content')
    <div class="card" style="background-color:rgba(0,34,62,0.2);color:#FFF;">       
        <div class="card-body" style="border-radius:10px;background-color:rgba(0,34,62,0.2);color:#FFF;">
            @if(count($origem) >= 1)
                <table class="table listarorigem">
                    <thead>
                        <th>Nome</th>
                    </thead>
                    <tbody></tbody>
                </table>
            @else 
                <h4 class="text-center">Nenhum Item Cadastrado</h4>
            @endif
        </div>
    </div>

    <div class="modal fade" id="cadastrarOrigem" tabindex="-1" aria-labelledby="cadastrarOrigemLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color:rgba(0,0,0,0.8);">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="cadastrarOrigemLabel">Cadastrar</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="cadastrar_origem" name="cadastrar_origem"  method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nome" class="text-white">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da Origem">
                        <div class="erronome"></div>
                    </div>
                    <input type="submit" value="Cadastrar" class="btn btn-block btn-info">
                </form>
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



           $("form[name='cadastrar_origem']").on('submit',function(){
                let form = $(this);
                $.ajax({
                    url:"{{route('origem.store')}}",
                    method:"POST",
                    data:$(this).serialize(),
                    beforeSend:function() {
                        if(form.find("#nome").val() == "") {
                            $(".erronome").html('<p class="alert alert-danger">Este campo é obrigatorio</p>')
                            return false;
                        } else {
                            $(".erronome").html('');
                        }
                        // return false;
                    },  
                    success:function(res) {
                        window.location.reload();
                    }
                });
                return false;
           });

           $(".listarorigem").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('origem.readorigem') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [10,20,30,40,100],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                columns: [
                    {data:"nome",name:"nome"},
                ],
                rowCallback: function (row, data) {
                    if ( $(row).hasClass('odd') ) {
                        //$(row).addClass('table-cell-edit');
                    } else {
                        //$(row).addClass('alvo');
                    }
                }
            });




        });   
</script>           
@stop