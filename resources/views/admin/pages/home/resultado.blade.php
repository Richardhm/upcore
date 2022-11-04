<div class="card" style="width: 30rem;margin:0 auto;">
            
            <div class="card-body">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <tr class="border-bottom border-top">
                            <td colspan="4" align="center"><b>{{$administradora_texto}}</b></td>
                        </tr>
                        <tr class="border-bottom">
                            <td colspan="4" align="center"><b>{{$coparticipacao_texto}} - {{$odonto_texto}}</b></td>
                        </tr>
                        <tr>
                            <th align="center">Faixa</th>
                            <th align="center">Apartamento</th>
                            <th align="center">Enfermaria</th>
                            <th align="center">Ambulatorial</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tabelas as $t)
                        <tr>
                            <td align="center">{{$t->faixas}}</td>
                            <td align="center">{{number_format($t->apartamento,2,",",".")}}</td>
                            <td align="center">{{number_format($t->enfermaria,2,",",".")}}</td>
                            <td align="center">{{number_format($t->ambulatorial,2,",",".")}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>