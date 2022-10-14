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
      <div class="d-flex align-self-start align-items-start" style="flex-wrap:wrap;">
        @for($i=0;$i < count($planos); $i++) 
          @if($planos[$i]->card == $card_inicial)
            @if($ii==0)
              <div class="card shadow card_plano align-self-start">
                <div class="card-body" style="box-shadow:rgba(0,0,0,0.8) 0.6em 0.7em 5px;padding:0.6rem;">
                  <input type="hidden" name="administradora_id" id="administradora_id" value="{{$planos[$i]->admin_id}}"> 
                  <input type="hidden" name="odonto" id="odonto" value="{{$planos[$i]->odonto}}">
                  <input type="hidden" name="plano_id" id="plano_id" value="{{$planos[$i]->plano_id}}"> 
                  <div class="d-flex justify-content-center">
                    <img class="mx-auto" src="{{\Illuminate\Support\Facades\Storage::url($planos[$i]->admin_logo)}}"  alt="{{$planos[$i]->admin_nome}}" width="30%;" height="51px;">
                  </div>
                  <div class="d-flex py-3">
                    <div class="col-6 text-center d-flex justify-content-center">
                      <span style="font-size:1.3em;">{{$planos[$i]->titulos}}</span>
                    </div>
                    <div class="col-6 text-center d-flex justify-content-center">
                    <span style="font-size:1.3em;" style="background-color:rgba(0,0,0,0.9)">{{$planos[$i]->plano}}</span>
                    </div>
                  </div>

                  <table class="">
                  <thead>
                      
                      
                      <tr>
                          <td rowspan="2" style="vertical-align:middle;background-color:rgba(0,0,0,0.8);text-align:center;border-right:1px solid #FFF;border-bottom:1px solid #FFF;">Faixa Etária</td>
                          <td colspan="3" style="text-align:center;border-right:1px solid #FFF;border-bottom:1px solid #FFF;" class="">Plano C/ Coparticipação</td>
                          <td colspan="3" style="text-align:center;background-color:rgba(0,0,0,0.8);border-bottom:1px solid #FFF;" class="">Plano S/ Coparticipação</td>
                      </tr>
                      <tr>
                          
                          <td style="text-align:center;border-bottom:1px solid #FFF;" class="">APART</td>
                          <td style="text-align:center;border-bottom:1px solid #FFF;" class="">ENFER</td>
                          <td style="text-align:center;border-right:1px solid #FFF;border-bottom:1px solid #FFF;" class="">AMBUL</td>

                          <td style="text-align:center;background-color:rgba(0,0,0,0.8);color:orange;border-bottom:1px solid #FFF;" class="">APART</td>
                          <td style="text-align:center;background-color:rgba(0,0,0,0.8);color:orange;border-bottom:1px solid #FFF;" class="">ENFER</td>
                          <td style="text-align:center;background-color:rgba(0,0,0,0.8);color:orange;border-bottom:1px solid #FFF;" class="">AMBUL</td>
                      </tr>
                  </thead>
                  <tbody>
                  @endif
                  <tr>
                          <td style="text-align:center;background-color:rgba(0,0,0,0.8);border-right:1px solid #FFF;">{{$planos[$i]->nome}}</td>
                          <td style="text-align:center;" class="">
                            {{number_format($planos[$i]->apartamento_coparticipacao,2,",",".")}}
                            @php
                              $total_apartamento_coparticipacao += $planos[$i]->apartamento_coparticipacao;
                            @endphp
                          </td>
                          <td style="text-align:center;" class="">
                            {{number_format($planos[$i]->enfermaria_coparticipacao,2,",",".")}}
                            @php
                              $total_enfermaria_coparticipacao += $planos[$i]->enfermaria_coparticipacao;
                            @endphp
                          </td>
                          <td style="text-align:center;border-right:1px solid #FFF;" class="">
                            {{number_format($planos[$i]->ambulatorial_coparticipacao,2,",",".")}}
                            @php
                              $total_ambulatorial_coparticipacao += $planos[$i]->ambulatorial_coparticipacao;
                            @endphp
                          </td>

                          <td style="text-align:center;background-color:rgba(0,0,0,0.8);color:orange;border-right:1px solid #FFF;" class="">
                            {{number_format($planos[$i]->apartamento_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_apartamento_sem_coparticipacao += $planos[$i]->apartamento_sem_coparticipacao
                            @endphp
                          </td>
                          <td style="text-align:center;background-color:rgba(0,0,0,0.8);color:orange;border-right:1px solid #FFF;" class="">
                            {{number_format($planos[$i]->enfermaria_sem_coparticipacao,2,",",".")}}
                            @php
                              $total_enfermaria_sem_coparticipacao += $planos[$i]->enfermaria_sem_coparticipacao
                            @endphp
                          </td>
                          <td style="text-align:center;background-color:rgba(0,0,0,0.8);color:orange;" class="">
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
                      <td style="text-align:center;border-top:1px solid #FFF;border-right:1px solid #FFF;" class="">Total</td>
                      <td style="text-align:center;border-top:1px solid #FFF;border-right:1px solid #FFF;" class="">{{isset($total_apartamento_coparticipacao) ? number_format($total_apartamento_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;border-top:1px solid #FFF;border-right:1px solid #FFF;" class="">{{isset($total_enfermaria_coparticipacao) ? number_format($total_enfermaria_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;border-top:1px solid #FFF;border-right:1px solid #FFF;" class="">{{isset($total_ambulatorial_coparticipacao) ? number_format($total_ambulatorial_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:orange;border-top:1px solid #FFF;" class="">{{isset($total_apartamento_sem_coparticipacao) ? number_format($total_apartamento_sem_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:orange;border-top:1px solid #FFF;" class="">{{isset($total_enfermaria_sem_coparticipacao) ? number_format($total_enfermaria_sem_coparticipacao,2,",",".") : 0}}</td>
                      <td style="text-align:center;color:orange;border-top:1px solid #FFF;" class="">{{isset($total_ambulatorial_sem_coparticipacao) ? number_format($total_ambulatorial_sem_coparticipacao,2,",",".") : 0}}</td>
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

                    
                  


                </div>    
              
          @endif
          </div>        
        @endfor
        
      <tfoot>
        <tr>
          <td style="text-align:center;" class="">Total</td>
          <td style="text-align:center;" class="">{{isset($total_apartamento_coparticipacao) ? number_format($total_apartamento_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;" class="">{{isset($total_enfermaria_coparticipacao) ? number_format($total_enfermaria_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;" class="">{{isset($total_ambulatorial_coparticipacao) ? number_format($total_ambulatorial_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;" class="">{{isset($total_apartamento_sem_coparticipacao) ? number_format($total_apartamento_sem_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;" class="">{{isset($total_enfermaria_sem_coparticipacao) ? number_format($total_enfermaria_sem_coparticipacao,2,",",".") : 0}}</td>
          <td style="text-align:center;" class="">{{isset($total_ambulatorial_sem_coparticipacao) ? number_format($total_ambulatorial_sem_coparticipacao,2,",",".") : 0}}</td>
          
          
        </tr>

        <tr>
        
        </tr>
       
      </tfoot>   



    
      






      
               
             

              

              



              
      </div>

      