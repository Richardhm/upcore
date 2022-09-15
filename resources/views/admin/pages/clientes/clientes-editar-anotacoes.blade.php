<div style="border-bottom:1px solid black;border-right:1px solid black;border-left:1px solid black;">
    <form action="" method="POST" name="editar_cliente">
        @csrf
        <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}">
        <div class="form-row">
            <div class="col-4">
                <div class="d-flex flex-column">                                        
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="{{$cliente->nome}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{$cliente->email}}">
                        </div>    
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex flex-column">     
                        <div class="form-group">
                            <label for="telefone">Celular:</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" value="{{$cliente->telefone}}">
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento">Data Nascimento:</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" value="{{$cliente->data_nascimento}}">
                        </div>
                </div>
            </div>            
            <div class="col-4">
                <div class="form-group">
                    <label for="anotacoes">Anotações:</label>
                    <textarea name="anotacoes" id="anotacoes" class="form-control" rows="5">{{strip_tags($cliente->anotacoes) ?? ''}}</textarea>
                </div>
            </div>
        </div>
        <input type="submit" name="editar_cliente" id="editar_cliente" value="Editar Cliente" class="btn btn-primary btn-block">
    </form>
</div>