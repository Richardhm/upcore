@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashbord</h1>
@stop

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        
                        <h3>---</h3>
                        <p class="d-flex"><span class="mr-auto">Orçamentos Realizados</span> <span style="font-size:0.8em;font-weight:bold;">Hoje: 0</span></p>
                        
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>---</h3>
                        <p class="d-flex"><span class="mr-auto">Contratos Realizados</span> <span style="font-size:0.8em;font-weight:bold;">Hoje: 0</span></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{count($corretores)}}</h3>
                        <p>Nossos Corretores</p>
                    </div>
                    <div class="icon">
                     
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$cidades}}</h3>
                        <p>Cidades onde estamos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <a href="" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>    












@stop
@section('js')
    <script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>   
    <script>
        $(document).ready(function(){

            $(".myorcamentos").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('admin.orcamentos') }}",
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
                    {data:"cliente",name:"cliente"},
                    {data:"quantidade",name:"quantidade"}
                ]
            });

            $(".outherorcamentos").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('admin.outherorcamentos') }}",
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
                    {data:"cliente",name:"cliente"},
                    {data:"corretor",name:"corretor"},
                ]
            });

            
            $(".comisaoapagar").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('comissoes.apagar') }}",
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
                    {data:"corretor",name:"corretor"},
                    {data:"valor",name:"valor"},
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };
 
                    total = this.api()
                        .column(2)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        console.log(total);
                        $(api.column(2).footer()).html(total);    
                }
                
            });

            

            

            $(".areceber").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('comissoes.areceber') }}",
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
                    {data:"corretor",name:"corretor"},
                    {data:"valor",name:"valor"},
                ]
            });



        });
    </script>
    <script src="{{asset('js/dashboard.js')}}"></script>  
@stop