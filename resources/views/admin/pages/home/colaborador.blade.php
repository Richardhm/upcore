@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$totalCliente}}</h3>
                        <p>Total de Clientes</p>
                        
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-6 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$clienteFechados}}</h3>
                        <p>Cliente Negociados</p>
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            

            
        </div>
    </div>
</section> 

<section class="row">

    <div class="col">
        <div class="card">
            <div class="card-header border-bottom bg-gray-dark disabled color-palette">
                <h3 class="card-title">Clientes</h3>
                <div class="card-tools">
                    
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered myorcamentosclientes">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Cidade</th>
                            <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                
                    </tbody>
                </table>            
            </div>
        </div>
    </div>

    <div class="col">
       




    </div>
    
         
</section>
@stop
@section('js')
    <script>
         $(document).ready(function(){
            $('.myorcamentosclientes').DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('corretor.especifico.orcamento.table') }}",
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
                    {data:"data",name:"data"},
                    {data:"cliente",name:"cliente"},
                    {data:"cidade",name:"cidade"},
                    {data:"telefone",name:"telefone"},
                    //{data:"administradora",name:"administradora"},
                    //{data:"quantidade",name:"quantidade"}

                ]
            });
         });
    </script>
@stop        