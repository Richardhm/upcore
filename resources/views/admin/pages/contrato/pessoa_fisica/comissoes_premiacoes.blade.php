    <h4 class="text-center text-white">Comissões</h4>
    <table class="table">
        <thead>
            <tr>
                <th class="text-white">Parcela</th>
                <th class="text-white">Data</th>
                <th class="text-white">Valor</th>
                <th class="text-white">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotacao->comissao->comissaoLancadas as $cc)
                <tr>
                    <td class="text-white">{{$cc->parcela}}</td>
                    <td class="text-white">{{date('d/m/Y',strtotime($cc->data))}}</td>
                    <td class="text-white">{{number_format($cc->valor,2,",",".")}}</td>
                    <td class="text-white">
                    <i 
                                class="far fa-thumbs-{{$cc->status ? 'up' : 'down'}} fa-2x" 
                                
                                >
                            </i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-center text-white">Premiações</h4>

    <table class="table">
        <thead>
            <tr>
                <th class="text-white">Parcela</th>
                <th class="text-white">Data</th>
                <th class="text-white">Valor</th>
                <th class="text-white">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cotacao->comissao->premiacaoCorretorLancados as $kk => $pp)
                <tr>
                    <td class="text-white">{{$kk+1}}</td>
                    <td class="text-white">{{date('d/m/Y',strtotime($pp->data))}}</td>
                    <td class="text-white">{{number_format($pp->total,2,",",".")}}</td>
                    <td class="text-white">
                    <i 
                                class="far fa-thumbs-{{$pp->status ? 'up' : 'down'}} fa-2x" 
                                
                                >
                            </i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
