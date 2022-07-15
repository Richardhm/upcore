<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Cliente,
    Cidade,
    Tabela,
    User,
    
    Cotacao,
    CotacaoFaixaEtaria,
    Administradora,
    Comissao,
    
    Operadora,
    Planos,
    ComissoesCorretoresConfiguracoes,
    ComissoesCorretoraConfiguracoes,
    ComissoesCorretoraLancadas,
    ComissoesCorretorLancados,
    PremiacaoCorretoresConfiguracoes,
    PremiacaoCorretoresLancados,
    PremiacaoCorretoraLancadas
};
use Illuminate\Support\Facades\DB;

class CotacaoController extends Controller
{
    public function orcamento($id)
    {
        
        $cliente = Cliente::where("id",$id)->first();
        if(!$cliente) {
            return redirect()->back();
        }
        
        $cot = Cotacao::where("cliente_id",$id)->first();
        $faixas = [];
        $colunas = [];
        if($cot) {
            $faixas = CotacaoFaixaEtaria::where("cotacao_id","=",$cot->id)
            ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_nome")  
            ->selectRaw("(SELECT quantidade FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_quantidade")  
            ->selectRaw("(SELECT faixa_etaria_id FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_etaria_id")  
            ->get()->toArray();    
            $colunas =  array_column($faixas, 'faixa_etaria_id');   
        }
            
        return view('admin.pages.cotacao.orcamento',[
            "cliente" => $cliente,
            "faixas" => $faixas,
            "colunas" => $colunas,
            "cidades" => Cidade::all()
        ]);
    }

    public function montarPlano(Request $request)
    {
        
        // $this->middleware(['can'=>'cadastrar_orcamentos']);
        if(empty($request->nome) || empty($request->telefone) || empty($request->email) || empty($request->cidade)) {
            return "error";
        }

        if(!preg_match('/^\([1-9]{2}\) [0-9]{1} [0-9]{4}-[0-9]{4}$/',$request->telefone)) {
            return "error";
        }

        if(!filter_var($request->email,FILTER_VALIDATE_EMAIL)) {
            return "error";
        }

        if(empty($request->faixas[0][1]) && empty($request->faixas[0][2]) && empty($request->faixas[0][3]) && empty($request->faixas[0][4]) && empty($request->faixas[0][5]) && empty($request->faixas[0][6]) && empty($request->faixas[0][7]) && empty($request->faixas[0][8]) && empty($request->faixas[0][9]) && empty($request->faixas[0][10])) {
            return "error";
        }     

        if($request->modelo == "pf") {
            $where_planos_pegar = ' AND (plano_id = (SELECT id FROM planos WHERE NOME LIKE "%Coletivo Por Adesão%") OR plano_id = (SELECT id FROM planos WHERE NOME LIKE "%Individual%"))';
        } else {
            $where_planos_pegar = ' AND (plano_id = (SELECT id FROM planos WHERE nome LIKE "%PME Boletado%") OR plano_id = (SELECT id FROM planos WHERE NOME LIKE "%Super Simples%"))';
        }
        
        $verificarPlano = Tabela::where(function($query) use($request){
            $query->where("cidade_id",$request->cidade);
           
        })->get();        
        if(count($verificarPlano) >= 1) {           
            $cliente = Cliente::find($request->cliente_id);
            $cliente->etiqueta_id = 2;
            $cliente->ultimo_contato = date("Y-m-d");
            $cliente->save();

            
            $cot = Cotacao::where('cliente_id',$request->cliente_id)->first();
            /** Cliente Ja Possui Cotacao??? */    
           
            if(!$cot) {
                $cotacao = new Cotacao();
                $cotacao->cliente_id = $request->cliente_id;
                $cotacao->cidade_id = $request->cidade;
                $cotacao->user_id = auth()->user()->id;
                $cotacao->corretora_id = auth()->user()->corretora_id;
               
                $cotacao->save();
                $faixas = $request->faixas[0];
                foreach($faixas as $k => $v) {
                    if($v != 0) {
                        $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
                        $orcamentoFaixaEtaria->cotacao_id = $cotacao->id;
                        $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                        $orcamentoFaixaEtaria->quantidade = $v;
                        $orcamentoFaixaEtaria->save();
                    } 
                }
                $cot = $cotacao;
            } else {
                
                $cot->update($request->all());
                CotacaoFaixaEtaria::where("cotacao_id",$cot->id)->delete();
                $faixas = $request->faixas[0];
                foreach($faixas as $k => $v) {
                    if($v != 0) {
                        $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
                        $orcamentoFaixaEtaria->cotacao_id = $cot->id;
                        $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                        $orcamentoFaixaEtaria->quantidade = $v;
                        $orcamentoFaixaEtaria->save();
                    } 
                }
                
            }
            
            $planos = DB::table('tabelas')
                ->join("cotacao_faixa_etarias",'tabelas.faixa_etaria', '=', 'cotacao_faixa_etarias.faixa_etaria_id')
                ->selectRaw("tabelas.id")
                ->selectRaw("tabelas.modelo")
                ->selectRaw("tabelas.plano_id")
                ->selectRaw("tabelas.valor")
                ->selectRaw("tabelas.operadora_id")
                ->selectRaw("tabelas.administradora_id")
                ->selectRaw("tabelas.cidade_id")
                ->selectRaw("tabelas.coparticipacao")
                ->selectRaw("tabelas.odonto")
                ->selectRaw("cotacao_faixa_etarias.quantidade")
                ->selectRaw("(tabelas.valor * cotacao_faixa_etarias.quantidade) AS Total")
                ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = tabelas.faixa_etaria) AS faixas")
                ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS admin_nome")
                ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS admin_logo")
                ->selectRaw("if(coparticipacao,'Com Copartipacao','Sem Coparticipacao') AS copartipicao_texto")
                ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) plano")
                ->selectRaw("if(odonto,'Com Odonto','Sem Odonto') AS odonto_texto")
                ->selectRaw("case 
                    when coparticipacao = 1 AND odonto = 1 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                        then CONCAT('Card_Coparticipaca_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                    
                    when coparticipacao = 1 AND odonto = 0 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                    then CONCAT('Card_Coparticipaca_Sem_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                    		
                
                    when coparticipacao = 0 AND odonto = 0 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                        then CONCAT('Card_Sem_Coparticipaca_Sem_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                    	
                    
                    when coparticipacao = 0 AND odonto = 1 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                    then CONCAT('Card_Sem_Coparticipaca_Com_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                                       	
                END AS card")
                ->whereRaw("cidade_id = ".$request->cidade." AND cotacao_faixa_etarias.cotacao_id = ".$cot->id.$where_planos_pegar)
                ->orderBy("tabelas.id")
                ->get();
                       
            $faixas = CotacaoFaixaEtaria::where("cotacao_id","=",$cot->id)
                ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_nome")  
                ->get();
               
                              
            return view('admin.pages.orcamento.mostarPlano',[
                'planos' => $planos,
                'orcamento' => $cot->id,
                'faixas' => $faixas->toArray(),
                'fisica' => $request->modelo == "pf" ? 1 : 0,
                'juridica' => $request->modelo == "pj" ? 1 : 0,
                'telefone' =>  str_replace(["-","(",")"," "],"",  $request->telefone),
                'cidade' => $request->cidade,
                'cliente' => $cliente->id
                    
            ]); 

        } else {
            $planos = [];
            return view('admin.pages.orcamento.mostarPlano',[
                'planos' => $planos,
                'orcamento' => ""
            ]);     
        }       
    }

    public function detalhesDoContratoComissoes($id)
    {
       
        $comissoes = ComissoesCorretorLancados::whereRaw("comissao_id = (SELECT id FROM comissoes WHERE cliente_id = ".$id.")")->get();
        
        return view('admin.pages.contrato.detalhes',[
            "comissoes" => $comissoes
        ]);
    }


    public function contrato($id)
    {
        $cliente = Cliente::where("id",$id)->first();
        if(!$cliente) {
            return redirect()->back();
        }
        $cidades = Cidade::all();
        $administradoras = Administradora::all();
        $operadoras = Operadora::all();
        if($cliente->pessoa_fisica) {
            $planos = Planos::where("nome","LIKE","%Individual%")->orWhere("nome","LIKE","%Coletivo Por Ade%")->get();
        } else {
            $planos = PLanos::where("nome","LIKE","%Super Simples%")->orWhere("nome","LIKE","PME Boletado")->get();
        }


        $cot = Cotacao::where("cliente_id",$id)->first();
        $faixas = [];
        $colunas = [];
        if($cot) {
            $faixas = CotacaoFaixaEtaria::where("cotacao_id","=",$cot->id)
            ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_nome")  
            ->selectRaw("(SELECT quantidade FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_quantidade")  
            ->selectRaw("(SELECT faixa_etaria_id FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_etaria_id")  
            ->get()->toArray();    
            $colunas =  array_column($faixas, 'faixa_etaria_id');   
        }
        
        
        
        return view('admin.pages.cotacao.contrato',[
            "cliente" => $cliente,
            "cidades" => $cidades,
            "administradoras" => $administradoras,
            "operadoras" => $operadoras,
            "planos" => $planos,
            "faixas" => $faixas,
            "colunas" => $colunas
                    
        ]);
    }

    public function montarValoresFormularioAcomodacao(Request $request)
    {
        
        $cot = Cotacao::where('cliente_id',$request->cliente_id)->first();
        /** Cliente Ja Possui Cotacao??? */    
        $chaves = [];
        if(!$cot) {
            $cotacao = new Cotacao();
            $cotacao->cliente_id = $request->cliente_id;
            $cotacao->cidade_id = $request->cidade;
            $cotacao->user_id = auth()->user()->id;
            $cotacao->corretora_id = auth()->user()->corretora_id;
           
            $cotacao->save();
            $faixas = $request->faixas;
            foreach($faixas as $k => $v) {
                if($v != 0) {
                    $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
                    $orcamentoFaixaEtaria->cotacao_id = $cotacao->id;
                    $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                    $orcamentoFaixaEtaria->quantidade = $v;
                    $orcamentoFaixaEtaria->save();
                    $chaves[] = $k;
                } 
            }
            
            $cot = $cotacao;
            $valores = DB::table("tabelas")
            ->selectRaw("SUM((valor * (SELECT quantidade FROM cotacao_faixa_etarias WHERE cotacao_faixa_etarias.faixa_etaria_id = tabelas.faixa_etaria LIMIT 1))) AS total")
            ->selectRaw("(SELECT id FROM acomodacao WHERE tabelas.modelo LIKE acomodacao.nome) AS id_acomodacao")
            ->selectRaw("modelo")
            ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) AS plano")
            ->selectRaw("if(coparticipacao = 0,'Sem Coparticipacao','Com Coparticipacao') AS coparticipacao")
            ->selectRaw("if(odonto = 0,'Sem Odonto','Com Odonto') AS odonto")
            ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS operadora")
            ->whereRaw("cidade_id = ".$request->cidade." AND operadora_id = ".$request->operadora." AND administradora_id = ".$request->administradora." AND odonto = ".($request->odonto == "sim" ? 1 : 0)." AND coparticipacao = ".($request->coparticipacao == "sim" ? 1 : 0)." AND plano_id = ".$request->plano." AND faixa_etaria IN(".implode(",",$chaves).")")
            
            ->groupBy("modelo")
            ->get();
            
        } else {
            
            $cot->update($request->all());
            CotacaoFaixaEtaria::where("cotacao_id",$cot->id)->delete();
            $faixas = $request->faixas;
            foreach($faixas as $k => $v) {
                if($v != 0) {
                    $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
                    $orcamentoFaixaEtaria->cotacao_id = $cot->id;
                    $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                    $orcamentoFaixaEtaria->quantidade = $v;
                    $orcamentoFaixaEtaria->save();
                    $chaves[] = $k;
                } 
            }
            
            $valores = DB::table("tabelas")
            ->selectRaw("SUM((valor * (SELECT quantidade FROM cotacao_faixa_etarias WHERE cotacao_faixa_etarias.faixa_etaria_id = tabelas.faixa_etaria LIMIT 1))) AS total")
            ->selectRaw("(SELECT id FROM acomodacao WHERE tabelas.modelo LIKE acomodacao.nome) AS id_acomodacao")
            ->selectRaw("modelo")
            ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) AS plano")
            ->selectRaw("if(coparticipacao = 0,'Sem Coparticipacao','Com Coparticipacao') AS coparticipacao")
            ->selectRaw("if(odonto = 0,'Sem Odonto','Com Odonto') AS odonto")
            ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS operadora")
            ->whereRaw("cidade_id = ".$request->cidade." AND operadora_id = ".$request->operadora." AND administradora_id = ".$request->administradora." AND odonto = ".($request->odonto == "sim" ? 1 : 0)." AND coparticipacao = ".($request->coparticipacao == "sim" ? 1 : 0)." AND plano_id = ".$request->plano." AND faixa_etaria IN(".implode(",",$chaves).")")
            
            ->groupBy("modelo")
            ->get();
            
        }
        
        $orcamentoFaixaEtaria = CotacaoFaixaEtaria::where("cotacao_id",$cot->id)->delete();
        $cot->delete();
           
            
           
        return view("admin.pages.cotacao.acomodacao",[
            "valores" => $valores
        ]);

    }


    


    public function storeContrato(Request $request)
    {
        
        //$request->valor = str_replace([",","."],[".",""],$request->valor);
        //$valor = number_format($request->valor,2,",",".");
        
        /** Vai Na Tabela CLiente E acaba de realizar o cadastro */
        
        $cliente = Cliente::where("id",$request->cliente_id)->first();
        $cliente->etiqueta_id = 3;
        $cliente->ultimo_contato = date('Y-m-d');
        $cliente->cpf = $request->cpf;
        $cliente->data_nascimento = date('Y-m-d',strtotime($request->data_nascimento));
        $cliente->save();


        /** Tabela Cotacao Cadastrao/Update */
        $cotacao = Cotacao::where("cliente_id",$request->cliente_id)->first();
        
        if($cotacao) {
            $cotacao->operadora_id = $request->operadora;
            $cotacao->administradora_id = $request->administradora;
            $cotacao->plano_id = $request->plano;
            $cotacao->acomodacao_id = $request->acomodacao;
            $cotacao->codigo_externo = $request->codigo_externo;
            $cotacao->valor = $request->valor;
            $cotacao->save();
        } else {
            
            $cotacao = new Cotacao();
            $cotacao->cliente_id = $request->cliente_id;
            $cotacao->cidade_id = $request->cidade;
            $cotacao->operadora_id = $request->operadora;
            $cotacao->administradora_id = $request->administradora;
            $cotacao->plano_id = $request->plano;
            $cotacao->acomodacao_id = $request->acomodacao;
            $cotacao->user_id = auth()->user()->id;
            $cotacao->corretora_id = auth()->user()->corretora_id;
            $cotacao->codigo_externo = $request->codigo_externo;
            $cotacao->valor = $request->valor;
            $cotacao->save();
        }


        
        /** Tabela CotacaoFaixaEtaria */
        CotacaoFaixaEtaria::where("cotacao_id",$cotacao->id)->delete();
        $totalVidas = 0;
        $faixas = $request->faixas_etarias;
        foreach($faixas as $k => $v) {
            if($v != 0) {
                $orcamentoFaixaEtaria = new CotacaoFaixaEtaria();
                $orcamentoFaixaEtaria->cotacao_id = $cotacao->id;
                $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                $orcamentoFaixaEtaria->quantidade = $v;
                $orcamentoFaixaEtaria->save();
                $totalVidas += $v;
            } 
        }
        
        
        
        /*Gera Comissao Para O Corretor*/

        /** Tabela Comissao */    
        $comissao = new Comissao();
        $comissao->cotacao_id = $cotacao->id;
        $comissao->cliente_id = $request->cliente_id;
        $comissao->user_id = auth()->user()->id;
        $comissao->save();    


        /** Comissao Corretor */
        $comissoes_configuradas_corretor = ComissoesCorretoresConfiguracoes::where("plano_id",$request->plano)->where("administradora_id",$request->administradora)->where("user_id",auth()->user()->id)->get();
        if(count($comissoes_configuradas_corretor) >= 1) {
            foreach($comissoes_configuradas_corretor as $c) {
                $comissaoVendedor = new ComissoesCorretorLancados();
                $comissaoVendedor->comissao_id = $comissao->id;
                $comissaoVendedor->parcela = $c->parcela;
                $comissaoVendedor->data = date("Y-m-d");
                $comissaoVendedor->valor = ($request->valor * $c->valor) / 100;
                $comissaoVendedor->save();    
            }
        }

        /** Premiacao Corretor Por Total de Vida */
        $premiacao_configurada_corretor = PremiacaoCorretoresConfiguracoes::where("plano_id",$request->plano)->where("administradora_id",$request->administradora)->where("user_id",auth()->user()->id)->first();
        // dd($premiacao_configurada_corretor->valor);
        // $dd = (float) $premiacao_configurada_corretor->valor * $totalVidas;
       
        if($premiacao_configurada_corretor) {
            $premiacaoCorretoresLancados = new PremiacaoCorretoresLancados();
            $premiacaoCorretoresLancados->comissao_id = $comissao->id;
            $premiacaoCorretoresLancados->user_id = auth()->user()->id;
            $premiacaoCorretoresLancados->total = (float) $premiacao_configurada_corretor->valor * $totalVidas;
            $premiacaoCorretoresLancados->save();
        }
        
        /** Comissao Corretora */   
        $comissoes_configurada_corretora = ComissoesCorretoraConfiguracoes::where("administradora_id",$request->administradora)->get();
        if(count($comissoes_configurada_corretora)>=1) {
            foreach($comissoes_configurada_corretora as $cc) {
                $comissaoCorretoraLancadas = new ComissoesCorretoraLancadas();
                $comissaoCorretoraLancadas->comissao_id = $comissao->id;            
                $comissaoCorretoraLancadas->parcela = $cc->parcela;
                $comissaoCorretoraLancadas->data = date("Y-m-d");
                
                $comissaoCorretoraLancadas->valor = ($request->valor * $cc->valor) / 100;
                $comissaoCorretoraLancadas->save();
            }
            

        }

        
        /** Premiação Corretora */
        $premiacao_administradora_corretora = Administradora::where("id",$request->administradora)->first();
        if($premiacao_administradora_corretora) {
            $premiacaoCorretoraLancadas = new PremiacaoCorretoraLancadas();
            $premiacaoCorretoraLancadas->comissao_id = $comissao->id;
            $premiacaoCorretoraLancadas->user_id = auth()->user()->id;
            $premiacaoCorretoraLancadas->total = (float) $premiacao_administradora_corretora->premiacao_corretora * $totalVidas;
            $premiacaoCorretoraLancadas->save();

        }

        return redirect()->route('clientes.index');
    }



}
