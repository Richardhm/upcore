<!doctype html>
<html lang="pt-br">
<head>
<style type="text/css">
		* {
			margin:0;
			padding:0;
			box-sizing:border-box;
		}
	</style>	
</head>
    <body>
    
        <div class="envolver planos" style="margin-left:10px;">
        @php $ii=0;$apartamento=0;$enfermaria=0;$ambulatorial=0;$totalApartamento=0;$totalEnfermaria=0;$totalAmbulatorial=0;   @endphp
        @for($i=0;$i < count($planos); $i++)
                @if($ii == 0)
                            <div><img src="{{public_path('storage/'.$planos[$i]->admin_logo)}}" width="100" height="50" alt=""></div>
                            <div style="display:block;">
                                <p style="display:block;border:1px solid black;text-align:center;padding:10px;margin:10px 0;">{{$planos[$i]->copartipicao_texto}} {{$planos[$i]->odonto_texto}}</p>
                            </div>
                            <div style="float:left;width:20%;">
                                <p style="background-color:rgb(49,134,155);box-sizing: border-box;padding:10px 0 9px 0;border-left:1px solid black;border-top:1px solid black;">
                                    <span>Faixas Etarias</span>
                                    <span>&nbsp;</span>
                                </p>
                                    
                                    @foreach($faixas as $ff)
                                        <p style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;"><span>{{$ff['faixa_nome']}}</span></p>
                                    @endforeach
                                    
                                <p style="background-color:rgb(49,134,155);border-right:1px solid black;border-top:1px solid black;"><span>Total Do Plano</span></p>
                            </div>
                @endif


                @if($planos[$i]->modelo == "Apartamento")
                        @if($apartamento == 0)      
                            <div class="apartamento" style="float:left;width:20%;">
                                <p style="background-color:rgb(49,134,155);box-sizing: border-box;">
                                    <span style="text-align:center;display:block;color:#000;">{{$planos[$i]->plano}}</span>
                                    <span style="text-align:center;display:block;color:#000;">Apartamento</span>
                                </p>
                        @endif  
                        @php $totalApartamento += $planos[$i]->Total @endphp
                        <p><span>{{number_format($planos[$i]->Total,2,",",".")}}</span></p>
                        @if($apartamento == count($faixas)-1) 
                                <p style="background-color:rgb(49,134,155);border-right:1px solid black;color:#000;"><span>{{number_format($totalApartamento,2,",",".")}}</span></p>
                            </div>
                        @endif
                        @php $apartamento++ @endphp
                @endif

                @if($planos[$i]->modelo == "Enfermaria")
                    @if($enfermaria == 0) 
                        <div class="enfermaria" style="float:left;width:20%;"> 
                            <p style="background-color:rgb(49,134,155);box-sizing: border-box;">
                            <span style="text-align:center;display:block;color:#000;">{{$planos[$i]->plano}}</span>
                                <span style="text-align:center;display:block;color:#000;">Enfermaria</span>
                            </p>
                    @endif 
                    @php $totalEnfermaria += $planos[$i]->Total @endphp 
                    <p><span>{{number_format($planos[$i]->Total,2,",",".")}}</span></p>   
                    @if($enfermaria == count($faixas)-1) 
                            <p style="background-color:rgb(49,134,155);border-right:1px solid black;color:#000;"><span>{{number_format($totalEnfermaria,2,",",".")}}</span></p>
                        </div> 
                    @endif    
                    @php $enfermaria++ @endphp
                @endif

                @if($planos[$i]->modelo == "Ambulatorial")
                    @if($ambulatorial == 0) 
                        <div class="ambulatorial" style="float:left;width:20%;"> 
                            <p style="box-sizing: border-box;background-color:rgb(49,134,155);">
                                <span style="text-align:center;display:block;color:#000;">{{$planos[$i]->plano}}</span>
                                <span style="text-align:center;display:block;color:#000;">Ambulatorial</span>
                            </p>
                    @endif  
                        @php $totalAmbulatorial += $planos[$i]->Total @endphp   
                        <p><span>{{number_format($planos[$i]->Total,2,",",".")}}</span></p>    
                    @if($ambulatorial == count($faixas)-1) <p style="background-color:rgb(49,134,155);border-right:1px solid black;"><span>{{number_format($totalAmbulatorial,2,",",".")}}</span></p></div> @endif    
                    @php $ambulatorial++ @endphp
                @endif
							
							
                   
                @php $ii++; @endphp
                       
        @endfor            
               
                    
                        


                        </div>                              
                
                       
    
    </body>
</html>