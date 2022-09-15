<div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <h5>Planos</h5>
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
            @if(count($planos) >= 1)
                @php 
                    $card_inicial = $planos[0]->card; 
                    $ii=0; 
                    $apartamento = 0; 
                    $enfermaria = 0; 
                    $ambulatorial = 0; 
                    $totalApartamento=0;
                    $totalEnfermaria=0;
                    $totalAmbulatorial=0; 

                    $cidade_id = 0;
                    $plano_id = 0;
                    $coparticipacao = 0;
                    $odonto = 0;
                    $operadora_id = 0;
                    $administradora_id = 0;
                @endphp
                @php
                    $t = new \App\Support\Thumb();
                @endphp  
                    
                <section class="container_planos_section">

                                        
                        @for($i=0;$i < count($planos); $i++)

                            @if($planos[$i]->card == $card_inicial)
                                
                                @if($ii == 0)
                                    <div class="envolver planos" style="min-height:500px;">
                                        <div class="logo">
                                            <img src="{{\Illuminate\Support\Facades\Storage::url($planos[$i]->admin_logo)}}" width="100" height="50" alt="">
                                        </div>
                                        <div class="coparticipacao_odonto">
                                            <p>{{$planos[$i]->copartipicao_texto}} {{$planos[$i]->odonto_texto}}</p>
                                        </div>
                                        <div class="faixas_etarias_container">
                                            <p class="faixas_etarias_title"><span>Faixas Etarias</span></p>
                                                @foreach($faixas as $ff)
                                                    <p class="faixas_etarias_nome"><span>{{$ff['faixa_nome']}}</span></p>
                                                @endforeach
                                            <p class="faixas_total_plano"><span>Total Do Plano</span></p>
                                        </div>
                                @endif

                                @if($planos[$i]->modelo == "Apartamento")
                                    @if($apartamento == 0) 
                                        <div class="apartamento">
                                            <p class="plano_container_header">
                                                <span class="plano_container_header_title">{{$planos[$i]->plano}}</span>
                                                <span class="plano_container_header_acomodacao">Apartamento</span>
                                            </p>
                                    @endif 
                                        @php $totalApartamento += $planos[$i]->Total @endphp 
                                        <div class="plano_total_container">                                            
                                            <p class="plano_total"><span>{{number_format($planos[$i]->Total,2,",",".")}}</span></p>       
                                        </div>                                           
                                        @if($apartamento == count($faixas)-1) 
                                                <p class="total_somado"><span>{{number_format($totalApartamento,2,",",".")}}</span></p>
                                        </div> 
                                        @endif    
                                        @php $apartamento++ @endphp
                                    @endif
                                    
                                    @if($planos[$i]->modelo == "Enfermaria")
                                        @if($enfermaria == 0) 
                                            <div class="enfermaria"> 
                                                <p class="plano_container_header">
                                                    <span class="plano_container_header_title">{{$planos[$i]->plano}}</span>
                                                    <span class="plano_container_header_acomodacao">Enfermaria</span>
                                                </p>
                                        @endif 
                                        @php $totalEnfermaria += $planos[$i]->Total @endphp
                                                <div class="plano_total_container">
                                                    <p class="plano_total"><span>{{number_format($planos[$i]->Total,2,",",".")}}</span></p>   
                                                </div> 
                                                @if($enfermaria == count($faixas)-1) 
                                                    <p class="total_somado"><span>{{number_format($totalEnfermaria,2,",",".")}}</span></p>
                                            </div> 
                                                @endif    
                                        @php $enfermaria++ @endphp
                                    @endif

                                    @if($planos[$i]->modelo == "Ambulatorial")
                                        @if($ambulatorial == 0) 
                                            <div class="ambulatorial"> 
                                                <p class="plano_container_header">
                                                    <span class="plano_container_header_title">{{$planos[$i]->plano}}</span>
                                                    <span class="plano_container_header_acomodacao">Ambulatorial</span>
                                                </p>
                                        @endif  
                                            @php $totalAmbulatorial += $planos[$i]->Total @endphp   
                                                <div class="plano_total_container">
                                                    <p class="plano_total"><span>{{number_format($planos[$i]->Total,2,",",".")}}</span></p>    
                                                </div>    
                                            
                                        @if($ambulatorial == count($faixas)-1) 
                                                <p class="total_somado">
                                                    <span>{{number_format($totalAmbulatorial,2,",",".")}}</span>
                                                </p>
                                            </div> 
                                        @endif    

                                        @php $ambulatorial++ @endphp
                                    @endif

                                @php $ii++; @endphp
                            @else
                                        <div style="display:flex;flex-basis:100%;justify-content:center;align-items:center;padding:2px 0;">
                                            <a style="color:black;margin-right:10px;" href="https://api.whatsapp.com/send?phone=55{{$telefone}}"><i class="fab fa-whatsapp fa-2x"></i></a>
                                            <a style="color:black;margin-right:10px;"><i class="fas fa-envelope fa-2x"></i></a>
                                            <a style="color:black;margin-right:10px;" data-orcamento="" data-cidade="" data-plano="" data-coparticipacao="" data-odonto="" data-operadora="" data-administradora="" href="#"><i class="fas fa-file-pdf fa-2x"></i></a>
                                            <a style="color:black;margin-right:10px;" href="{{route('cotacao.contrato',$cliente)}}"><i class="fas fa-file-contract fa-2x"></i></a>
                                        </div>                 
                                        
                                        @php 
                                            $card_inicial = $planos[$i]->card;  
                                            $i--;
                                            $ii=0;
                                            $apartamento=0;
                                            $enfermaria=0;
                                            $ambulatorial=0;
                                            $totalApartamento = 0;
                                            $totalEnfermaria = 0;
                                            $totalAmbulatorial = 0;

                                            
                                        @endphp

                                    </div>                              
                            @endif
                            <p></p>    
                        @endfor 

                        <div style="display:flex;flex-basis:100%;justify-content:center;align-items:center;padding:2px 0;">
                            <a style="color:black;margin-right:10px;" href="https://api.whatsapp.com/send?phone=55{{$telefone}}"><i class="fab fa-whatsapp fa-2x"></i></a>
                            <a style="color:black;margin-right:10px;"><i class="fas fa-envelope fa-2x"></i></a>
                            <a style="color:black;margin-right:10px;" href="{{route('cotacao.orcamento',$cliente)}}"><i class="fas fa-file-pdf fa-2x"></i></a>
                            <a style="color:black;margin-right:10px;" href="{{route('cotacao.contrato',$cliente)}}"><i class="fas fa-file-contract fa-2x"></i></a>
                        </div>             


                        
                         

            @else
                <p>Não há planos com esses parametros, tente outros</p>
            @endif

            </section>
      </div>
     
    </div>
</div>



