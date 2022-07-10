@extends('adminlte::page')

@section('title', 'Clientes Corretores')
@section('plugins.Datatables', true)
@section('content_header')
    
    
@stop

@section('content')
    
    
    <div class="card">
       
        <div class="card-body">
            <table class="table table-bordered clientes">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Corretor</th>
                        <th>Cliente</th>
                        <th>Cidade</th>
                        <th>Status</th>
                        <!-- <th>Administradora</th> -->   
                    </tr>
                </thead>
                <tbody>            
                </tbody>
            </table>       
        </div>
    
    <div>
    
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
            $(".clientes").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('clientes.pegarClientesCorretores') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [5,10,15],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                columns: [
                    {
                        data:"datas",name:"datas"
                    },
                    {data:"corretor",name:"corretor"},
                    {data:"nome",name:"cliente"},
                    {data:"cidade",name:"cidade"},
                    {data:"cor",name:"status",
                        render: function (data, type, item) {
                            return "<div style='display:block;margin-left:15px;width:20px;height:20px;border-radius:50%;background-color:"+data+"'></div>"
                        }
                    }

                ]
            });

        });
    </script>  



@stop