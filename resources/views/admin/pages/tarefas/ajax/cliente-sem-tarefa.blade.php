
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $c)
                    <tr>
                        <td>{{$c->nome}}</td>
                        <td>{{$c->telefone}}</td>
                        <td><div style="display:flex;align-items: center;margin-left:5px;"><div style="width:20px;height:20px;border-radius:50%;background-color:{{$c->etiqueta}}"></div></div></td>
                        <td>
                        <a href="{{route('clientes.agendarTarefa',$c->id)}}" style="display:block;color:white;width:120px;border-radius:10px;text-align: center;background-color:rgb(249,3,110);">
                                    Criar Tarefa
                                </a>  
                        </td>
                        
                    </tr>
                    @endforeach

                </tbody>
            </table>

