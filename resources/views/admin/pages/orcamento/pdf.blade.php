<!doctype html>
<html lang="pt-br">
<head>
<style rel="stylesheet">
	table, tr, td, th{border:#000 solid 1px;width:280px;padding:0px;font-size:20px;border-collapse:collapse;margin:auto auto;}
	td{width:50px;height:30px;}
	th{font-weight: normal;width:90px;}
</style>
</head>
    <body>
        @php
          $total_apartamento_coparticipacao = 0;
          $total_enfermaria_coparticipacao = 0;
          $total_ambulatorial_coparticipacao =  0;
          $total_apartamento_sem_coparticipacao = 0;
          $total_enfermaria_sem_coparticipacao = 0;
          $total_ambulatorial_sem_coparticipacao = 0;
        @endphp
        @foreach($planos as $p)           
             @if($loop->first)
             <section>
             <table class="table table-striped">
                  <thead>
                      <tr>
                        <td colspan="7" align="center"><b>{{$p->titulos}}</b></td>
                      </tr>
                      <tr>
                        <td colspan="1">
                          {{$p->admin_nome}}
                        </td>
                        <td colspan="6" style="text-align:center;vertical-align: middle;">
                          <span style="margin:0 auto;width:auto;display:inline-block;vertical-align: middle;font-size:1.2em;">{{$p->plano}}</span>
                        </td>
                      </tr>
                      <tr>
                          <td></td>
                          <td colspan="3" style="text-align:center;">Plano C/ Coparticipação</td>
                          <td colspan="3" style="text-align:center;">Plano S/ Coparticipação</td>
                      </tr>
                      <tr>
                          <th style="text-align:center;font-size:0.875em;">Faixa Etária</th>
                          <th style="text-align:center;font-size:0.875em;">APART</th>
                          <th style="text-align:center;font-size:0.875em;">ENFER</th>
                          <th style="text-align:center;font-size:0.875em;">AMBUL</th>
                          <th style="text-align:center;font-size:0.875em;">APART</th>
                          <th style="text-align:center;font-size:0.875em;">ENFER</th>
                          <th style="text-align:center;font-size:0.875em;">AMBUL</th>
                      </tr>
                  </thead>
                  <tbody>
                @endif
                  <tr>
                        <th style="text-align:center;">{{$p->nome}}</th>
                        <th style="text-align:center;">
                            {{number_format($p->apartamento_coparticipacao,2,",",".")}}
                            @php
                              $total_apartamento_coparticipacao += $p->apartamento_coparticipacao;
                            @endphp
                        </th>
                          <th style="text-align:center;">
                            {{number_format($p->enfermaria_coparticipacao,2,",",".")}}
                            @php
                              $total_enfermaria_coparticipacao += $p->enfermaria_coparticipacao;
                            @endphp
                          </th>
                          <th style="text-align:center;">
                            {{number_format($p->ambulatorial_coparticipacao,2,",",".")}}
                            @php
                              $total_ambulatorial_coparticipacao += $p->ambulatorial_coparticipacao;
                            @endphp
                          </th>
                          <th style="text-align:center;">
                            {{number_format($p->apartamento_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_apartamento_sem_coparticipacao += $p->apartamento_sem_coparticipacao
                            @endphp
                          </th>
                          <th style="text-align:center;">
                            {{number_format($p->enfermaria_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_enfermaria_sem_coparticipacao += $p->enfermaria_sem_coparticipacao
                            @endphp
                          </th>
                          <th style="text-align:center;">
                            {{number_format($p->ambulatorial_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_ambulatorial_sem_coparticipacao += $p->ambulatorial_sem_coparticipacao
                            @endphp
                          </th>
                  </tr> 
                  @if($loop->last)
                  </tbody>
                  <tfoot>
                    <tr>
                      <td style="text-align:center;">Total</td>
                      <td style="text-align:center;color:#060;">{{isset($total_apartamento_coparticipacao) ? number_format($total_apartamento_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:#060;">{{isset($total_enfermaria_coparticipacao) ? number_format($total_enfermaria_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:#060;">{{isset($total_ambulatorial_coparticipacao) ? number_format($total_ambulatorial_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:#060;">{{isset($total_apartamento_sem_coparticipacao) ? number_format($total_apartamento_sem_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:#060;">{{isset($total_enfermaria_sem_coparticipacao) ? number_format($total_enfermaria_sem_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:#060;">{{isset($total_ambulatorial_sem_coparticipacao) ? number_format($total_ambulatorial_sem_coparticipacao,2,",",".") : 0}}</td>
                    </tr>
                  </tfoot>
                  </table>
            </section>      
            @endif        
      @endforeach 
    </body>
</html>