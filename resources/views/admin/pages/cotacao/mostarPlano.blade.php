<div class="card">
    <div class="card-header" id="headingTwo">
      <div class="row">
        <div class="col">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h5>Planos</h5>
            </button>
          </h2>
        </div>
        <div class="col">
          <div class="icones-link"></div>
        </div>
      </div>
      
      
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
      <input type="hidden" name="cotacao_id" id="cotacao_id" value="{{$orcamento}}">
      
      @php 
        $ii=0;         
        $total_apartamento_coparticipacao = 0;
        $total_enfermaria_coparticipacao = 0;
        $total_ambulatorial_coparticipacao =  0;
        $total_apartamento_sem_coparticipacao = 0;
        $total_enfermaria_sem_coparticipacao = 0;
        $total_ambulatorial_sem_coparticipacao = 0;
        $total_apartamento_odonto_final = 0;
        $total_enfermaria_odonto_final = 0;
        $total_ambulatorial_odonto_final =  0;
        $total_apartamento_sem_odonto_final = 0;
        $total_enfermaria_sem_odonto_final = 0;
        $total_ambulatorial_sem_odonto_final = 0;
      @endphp
      <div class="row">
      @for($i=0;$i < count($planos); $i++) 
        @if($planos[$i]->card == $card_inicial)
          @if($ii==0)
             
             <section class="cards col-6">
              <input type="hidden" name="administradora_id" id="administradora_id" value="{{$planos[$i]->admin_id}}"> 
              <input type="hidden" name="odonto" id="odonto" value="{{$planos[$i]->odonto}}"> 
             <input type="hidden" name="plano_id" id="plano_id" value="{{$planos[$i]->plano_id}}"> 
              <table class="table table-sm table-hover table-borderless table-striped" style="border:1px solid black;">
                  <thead>
                      <tr>
                        <td colspan="7" class="text-center" style="border-bottom:1px solid black;"><b>{{$planos[$i]->titulos}}</b></td>
                      </tr>
                      <tr>
                        <td colspan="1" rowspan="3" style="display:flex;border-right:1px solid black;margin:0 auto;">
                          <img src="{{\Illuminate\Support\Facades\Storage::url($planos[$i]->admin_logo)}}" style="margin-top:20px;" alt="{{$planos[$i]->admin_nome}}" width="100%;" height="51px;">
                        </td>
                        <td colspan="6" style="text-align:center;vertical-align: middle;">
                          <span style="margin:0 auto;width:auto;display:inline-block;vertical-align: middle;font-size:1.2em;">{{$planos[$i]->plano}}</span>
                        </td>
                      </tr>
                      <tr style="border-bottom:1px solid black;">
                          <td style="border-right:1px solid black;"></td>
                          <td colspan="3" style="text-align:center;border-right:1px solid black;border-top:1px solid black;">Plano C/ Coparticipação</td>
                          <td colspan="3" style="text-align:center;border-top:1px solid black;">Plano S/ Coparticipação</td>
                      </tr>
                      <tr style="border-bottom:1px solid black;">
                          <td rowspan="3" style="text-align:center;border-right:1px solid black;">Faixa Etária</td>
                          <td style="text-align:center;border-right:1px solid black;">APART</td>
                          <td style="text-align:center;border-right:1px solid black;">ENFER</td>
                          <td style="text-align:center;border-right:1px solid black;">AMBUL</td>
                          <td style="text-align:center;border-right:1px solid black;">APART</td>
                          <td style="text-align:center;border-right:1px solid black;">ENFER</td>
                          <td style="text-align:center;">AMBUL</td>
                      </tr>
                  </thead>
                  <tbody>
                  @endif
                  <tr style="border-bottom:1px solid black;">
                          <td style="text-align:center;border-right:1px solid black;">{{$planos[$i]->nome}}</td>
                          <td style="text-align:center;border-right:1px solid black;">
                            {{number_format($planos[$i]->apartamento_coparticipacao,2,",",".")}}
                            @php
                              $total_apartamento_coparticipacao += $planos[$i]->apartamento_coparticipacao;
                            @endphp
                          </td>
                          <td style="text-align:center;border-right:1px solid black;">
                            {{number_format($planos[$i]->enfermaria_coparticipacao,2,",",".")}}
                            @php
                              $total_enfermaria_coparticipacao += $planos[$i]->enfermaria_coparticipacao;
                            @endphp
                          </td>
                          <td style="text-align:center;border-right:1px solid black;">
                            {{number_format($planos[$i]->ambulatorial_coparticipacao,2,",",".")}}
                            @php
                              $total_ambulatorial_coparticipacao += $planos[$i]->ambulatorial_coparticipacao;
                            @endphp
                          </td>
                          <td style="text-align:center;border-right:1px solid black;">
                            {{number_format($planos[$i]->apartamento_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_apartamento_sem_coparticipacao += $planos[$i]->apartamento_sem_coparticipacao
                            @endphp
                          </td>
                          <td style="text-align:center;border-right:1px solid black;">
                            {{number_format($planos[$i]->enfermaria_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_enfermaria_sem_coparticipacao += $planos[$i]->enfermaria_sem_coparticipacao
                            @endphp
                          </td>
                          <td style="text-align:center;border-right:1px solid black;">
                            {{number_format($planos[$i]->ambulatorial_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_ambulatorial_sem_coparticipacao += $planos[$i]->ambulatorial_sem_coparticipacao
                            @endphp
                          </td>
                      </tr>   
                    @php $ii++; @endphp
                @else
                  @php $card_inicial = $planos[$i]->card; $ii=0; $i--;@endphp
                  </tbody>
                  <tfoot>
                    <tr>
                      <td style="text-align:center;border-right:1px solid black;">Total</td>
                      <td style="text-align:center;border-right:1px solid black;">{{isset($total_apartamento_coparticipacao) ? number_format($total_apartamento_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;border-right:1px solid black;">{{isset($total_enfermaria_coparticipacao) ? number_format($total_enfermaria_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;border-right:1px solid black;">{{isset($total_ambulatorial_coparticipacao) ? number_format($total_ambulatorial_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;border-right:1px solid black;">{{isset($total_apartamento_sem_coparticipacao) ? number_format($total_apartamento_sem_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;border-right:1px solid black;">{{isset($total_enfermaria_sem_coparticipacao) ? number_format($total_enfermaria_sem_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;border-right:1px solid black;">{{isset($total_ambulatorial_sem_coparticipacao) ? number_format($total_ambulatorial_sem_coparticipacao,2,",",".") : 0}}</td>
                    </tr>
                  </tfoot>
                  </table>
                  @php 
                    $total_apartamento_coparticipacao = 0;
                    $total_enfermaria_coparticipacao = 0;
                    $total_ambulatorial_coparticipacao =  0;
                    $total_apartamento_sem_coparticipacao = 0;
                    $total_enfermaria_sem_coparticipacao = 0;
                    $total_ambulatorial_sem_coparticipacao = 0;
                  @endphp
            </section>       
              @endif        
      @endfor
      <tfoot>
        <tr>
          <td style="text-align:center;border-left:1px solid black;">Total</td>
          <td style="text-align:center;border-left:1px solid black;">{{isset($total_apartamento_coparticipacao) ? number_format($total_apartamento_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;border-left:1px solid black;">{{isset($total_enfermaria_coparticipacao) ? number_format($total_enfermaria_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;border-left:1px solid black;">{{isset($total_ambulatorial_coparticipacao) ? number_format($total_ambulatorial_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;border-left:1px solid black;">{{isset($total_apartamento_sem_coparticipacao) ? number_format($total_apartamento_sem_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;border-left:1px solid black;">{{isset($total_enfermaria_sem_coparticipacao) ? number_format($total_enfermaria_sem_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;border-left:1px solid black;">{{isset($total_ambulatorial_sem_coparticipacao) ? number_format($total_ambulatorial_sem_coparticipacao,2,",",".") : 0}}</td>
        </tr>
      </tfoot>  
      </div>
     </div>
    </div>
</div>