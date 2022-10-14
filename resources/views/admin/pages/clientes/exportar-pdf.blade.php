<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
           
            table, th, td {
                border: 1px solid;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
        </style>    
    </head>
    <body>
        @if(count($clientes) >= 1) 
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Origem</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $c) 
                    <tr>
                        <td>{{date('d/m/Y',strtotime($c->created_at))}}</td>
                        <td>{{$c->origem->nome}}</td>
                        <td>{{$c->nome}}</td>
                        <td>{{$c->telefone}}</td>
                        <td>{{$c->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Sem Clientes a serem criados</p>
        @endif        
    </body>
</html>