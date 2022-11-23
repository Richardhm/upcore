<?php

namespace App\Http\Controllers\Admin;

use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\{
    Acomodacao,
    Cliente,
    Cidade,
    Tabela,
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
    PremiacaoCorretoraLancadas,
    Tarefa,
    User
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CotacaoController extends Controller
{
    public function orcamento($id)
    {
        $cliente = Cliente::where("id",$id)->first();
        $tipo = $cliente->pessoa_fisica == 1 ? 'pf' : 'pj';
        
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
            "cidades" => Cidade::all(),
            "tipo" => $tipo
        ]);
    }

    public function enviarEmail($cotacao,$administradora,$plano,$odonto,$cliente,$cidade)
    {
        $planos = DB::table('cotacao_faixa_etarias as cfe')
        ->selectRaw("CONCAT('card_',ta.odonto,'_',ta.coparticipacao,'_',ta.administradora_id) AS card,cfe.cotacao_id,fe.id,cfe.quantidade,fe.nome,fe.id,ta.odonto,ta.coparticipacao,ta.administradora_id,ta.faixa_etaria,ta.plano_id")
        ->selectRaw("(SELECT nome FROM planos WHERE ta.plano_id = planos.id) AS plano")
        ->selectRaw("(CONCAT('tabela_',ta.odonto,'_',ta.coparticipacao,'_',(SELECT nome FROM administradoras WHERE administradoras.id = ta.administradora_id))) AS mesma_tabela")
        ->selectRaw("(CONCAT(if(odonto,'Com Odonto','Sem Odonto'))) AS titulos")
        ->selectRaw("(SELECT id FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_id")
        ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_nome")
        ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_logo")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Apartamento' OR ta.modelo = 'Apartamento') AND tad.coparticipacao = 1 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS apartamento_coparticipacao")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Enfermaria' OR ta.modelo = 'Enfermaria') AND tad.coparticipacao = 1 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS enfermaria_coparticipacao")  
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Apartamento' OR ta.modelo = 'Apartamento') AND tad.coparticipacao = 0 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS apartamento_sem_coparticipacao")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Enfermaria'  OR ta.modelo = 'Enfermaria') AND tad.coparticipacao = 0 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS enfermaria_sem_coparticipacao")
        ->join("faixas_etarias as fe",'cfe.faixa_etaria_id', '=', 'fe.id')  
        ->join("tabelas as ta","ta.faixa_etaria","=","cfe.faixa_etaria_id")
        ->whereRaw("cotacao_id = ".$cotacao." AND ta.cidade_id = ".$cidade." AND odonto = ".$odonto." AND plano_id = ".$plano." AND administradora_id = ".$administradora)
        ->groupByRaw("ta.administradora_id,ta.faixa_etaria,ta.odonto")
        ->orderByRaw("ta.administradora_id,card,fe.nome")    
        ->get();      
        
        $user = User::find(auth()->user()->id);
        
        if(!empty($user->image)) {
            $type = mime_content_type(public_path("storage/".$user->image));        
            $data = base64_encode(file_get_contents(public_path("storage/".$user->image)));
            $image_user = 'data:image/' . $type . ';base64,' . $data;     
        } else {
            // $type = mime_content_type(public_path("storage/avatar-default.jpg"));        
            // $data = base64_encode(file_get_contents(public_path("storage/avatar-default.jpg")));
            // $image_user = 'data:image/' . $type . ';base64,' . $data;
            $image_user = null;
        }
           
        $icone_site_oficial = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/01.png")));
        $icone_boleto = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/02.png")));
        $icone_marcar_consulta = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/03.png")));
        $icone_rede_atendimento = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/04.png")));
        $icone_clinica = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/05.png")));
        $icone_hospital = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/06.png")));
        $icone_lupa = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/07.png")));
        $icone_endereco = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/08.png")));
        $icone_zap_footer = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/telefone-consultar.png")));
        $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/logo.png")));

        // // @ts-ignore
        $pdf = PDF::loadView('admin.pages.orcamento.bootstrap',[
            'planos'=>$planos,
            "nome" => $user->name,
            "telefone" => $user->celular,
            "image"=>$image_user,
            "plano" => $planos[0]->plano,
            "icone_site_oficial"=>$icone_site_oficial,
            "icone_boleto"=>$icone_boleto,
            "icone_marcar_consulta" => $icone_marcar_consulta,
            "icone_rede_atendimento" => $icone_rede_atendimento,
            "icone_clinica" => $icone_clinica,
            "icone_hospital" => $icone_hospital,
            "icone_lupa" => $icone_lupa,
            "icone_endereco" => $icone_endereco,
            "icone_zap_footer" => $icone_zap_footer,
            "logo" => $logo
        ]);

        $cliente = Cliente::find($cliente);
        $cliente->lead = ($cliente->lead == 0 ? 1 : 0);
        $cliente->save();

        Mail::to($cliente->email)->send(new MensagemTesteMail($pdf->output(),$cliente->nome));

        return redirect()->route('cotacao.orcamento',$cliente)->with('message', 'Email enviado com sucesso');
        
    }



    public function criarPDF($cotacao,$administradora,$plano,$odonto,$cliente,$cidade)
    {
        



        $alt = Cliente::find($cliente);
        if($alt->lead == 1) {
            $alt->lead = 0;
        }
        
        $alt->save();


        $planos = DB::table('cotacao_faixa_etarias as cfe')
        ->selectRaw("CONCAT('card_',ta.odonto,'_',ta.coparticipacao,'_',ta.administradora_id) AS card,cfe.cotacao_id,fe.id,cfe.quantidade,fe.nome,fe.id,ta.odonto,ta.coparticipacao,ta.administradora_id,ta.faixa_etaria,ta.plano_id")
        ->selectRaw("(SELECT nome FROM planos WHERE ta.plano_id = planos.id) AS plano")
        ->selectRaw("(CONCAT('tabela_',ta.odonto,'_',ta.coparticipacao,'_',(SELECT nome FROM administradoras WHERE administradoras.id = ta.administradora_id))) AS mesma_tabela")
        ->selectRaw("(CONCAT(if(odonto,'Com Odonto','Sem Odonto'))) AS titulos")
        ->selectRaw("(SELECT id FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_id")
        ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_nome")
        ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_logo")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Apartamento' OR ta.modelo = 'Apartamento') AND tad.coparticipacao = 1 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS apartamento_coparticipacao")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Enfermaria' OR ta.modelo = 'Enfermaria') AND tad.coparticipacao = 1 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS enfermaria_coparticipacao")  
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Apartamento' OR ta.modelo = 'Apartamento') AND tad.coparticipacao = 0 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS apartamento_sem_coparticipacao")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cotacao.") FROM tabelas as tad WHERE (tad.modelo = 'Enfermaria'  OR ta.modelo = 'Enfermaria') AND tad.coparticipacao = 0 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS enfermaria_sem_coparticipacao")
        ->join("faixas_etarias as fe",'cfe.faixa_etaria_id', '=', 'fe.id')  
        ->join("tabelas as ta","ta.faixa_etaria","=","cfe.faixa_etaria_id")
        ->whereRaw("cotacao_id = ".$cotacao." AND ta.cidade_id = ".$cidade." AND odonto = ".$odonto." AND plano_id = ".$plano." AND administradora_id = ".$administradora)
        ->groupByRaw("ta.administradora_id,ta.faixa_etaria,ta.odonto")
        ->orderByRaw("ta.administradora_id,card,fe.nome")    
        ->get();
        
        $user = User::find(auth()->user()->id);
        
        if(!empty($user->image)) {
            $type = mime_content_type(public_path("storage/".$user->image));        
            $data = base64_encode(file_get_contents(public_path("storage/".$user->image)));
            $image_user = 'data:image/' . $type . ';base64,' . $data;     
        } else {
            // $type = mime_content_type(public_path("storage/avatar-default.jpg"));        
            // $data = base64_encode(file_get_contents(public_path("storage/avatar-default.jpg")));
            // $image_user = 'data:image/' . $type . ';base64,' . $data;
            $image_user = null;
        }
        
        
        $icone_site_oficial = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/01.png")));
        $icone_boleto = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/02.png")));
        $icone_marcar_consulta = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/03.png")));
        $icone_rede_atendimento = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/04.png")));
        $icone_clinica = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/05.png")));
        $icone_hospital = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/06.png")));
        $icone_lupa = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/07.png")));
        $icone_endereco = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/08.png")));
        $icone_zap_footer = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/telefone-consultar.png")));
        $logo = 'data:image/png;base64,'.base64_encode(file_get_contents(public_path("storage/logo.png")));

        // // @ts-ignore
        $pdf = PDF::loadView('admin.pages.orcamento.bootstrap',[
            'planos'=>$planos,
            "nome" => $user->name,
            "telefone" => $user->celular,
            "image"=>$image_user,
            "plano" => $planos[0]->plano,
            "icone_site_oficial"=>$icone_site_oficial,
            "icone_boleto"=>$icone_boleto,
            "icone_marcar_consulta" => $icone_marcar_consulta,
            "icone_rede_atendimento" => $icone_rede_atendimento,
            "icone_clinica" => $icone_clinica,
            "icone_hospital" => $icone_hospital,
            "icone_lupa" => $icone_lupa,
            "icone_endereco" => $icone_endereco,
            "icone_zap_footer" => $icone_zap_footer,
            "logo" => $logo
        ]);
        $nome_pdf = Str::slug(Cliente::where("id",$cliente)->first()->nome, '-')."-".date('d')."-".date('m')."-".date('Y')."-".substr(time(),0,5).".pdf";
        //session()->
        //orcamentosession(['download-completo' => "completo-pdf-".$cliente]);
        //session()->put('download-completo',"completo-pdf-".$cliente);
        //setcookie('download-pdf','download completado',time() + 86400,"/");
        
        return $pdf->download($nome_pdf);

        //return response()->download($pdf->download($nome_pdf));
        //return redirect()->
        //return redirect()->route('cotacao.orcamento',$cliente)->with('message', 'Email enviado com sucesso');
        
    }

    public function montarPlano(Request $request)
    {
        // return $request->all();
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
            $cot = Cotacao::where('cliente_id',$request->cliente_id)->first();
            /** Cliente Ja Possui Cotacao??? */    
            if(!$cot) {
                $cliente->etiqueta_id = 2;
                $cliente->ultimo_contato = date("Y-m-d");               
                $cliente->save();          
                $tarefa = new Tarefa();
                $tarefa->cliente_id = $request->cliente_id;
                $tarefa->user_id = auth()->user()->id;
                $tarefa->titulo_id = 1;
                $tarefa->data = date("Y-m-d");
                $tarefa->descricao = "Envio de Orçamento para o cliente ".$cliente->nome;
                $tarefa->save();
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
           
    $planos = DB::table('cotacao_faixa_etarias as cfe')
        ->selectRaw("CONCAT('card_',ta.odonto,'_',ta.coparticipacao,'_',ta.administradora_id) AS card,cfe.cotacao_id,fe.id,cfe.quantidade,fe.nome,fe.id,ta.odonto,ta.coparticipacao,ta.administradora_id,ta.faixa_etaria,ta.plano_id")
        ->selectRaw("(SELECT nome FROM planos WHERE ta.plano_id = planos.id) AS plano")
        ->selectRaw("(CONCAT('tabela_',ta.odonto,'_',ta.coparticipacao,'_',(SELECT nome FROM administradoras WHERE administradoras.id = ta.administradora_id))) AS mesma_tabela")
        ->selectRaw("(CONCAT(if(odonto,'Com Odonto','Sem Odonto'))) AS titulos")
        ->selectRaw("(SELECT id FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_id")
        ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_nome")
        ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = ta.administradora_id) AS admin_logo")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cot->id.") FROM tabelas as tad WHERE (tad.modelo = 'Apartamento' OR ta.modelo = 'Apartamento') AND tad.coparticipacao = 1 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS apartamento_coparticipacao")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cot->id.") FROM tabelas as tad WHERE (tad.modelo = 'Enfermaria' OR ta.modelo = 'Enfermaria') AND tad.coparticipacao = 1 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS enfermaria_coparticipacao")  
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cot->id.") FROM tabelas as tad WHERE (tad.modelo = 'Ambulatorial' OR ta.modelo = 'Ambulatorial') AND tad.coparticipacao = 1 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS ambulatorial_coparticipacao")            
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cot->id.") FROM tabelas as tad WHERE (tad.modelo = 'Apartamento' OR ta.modelo = 'Apartamento') AND tad.coparticipacao = 0 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS apartamento_sem_coparticipacao")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cot->id.") FROM tabelas as tad WHERE (tad.modelo = 'Enfermaria'  OR ta.modelo = 'Enfermaria') AND tad.coparticipacao = 0 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.cidade_id AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS enfermaria_sem_coparticipacao")
        ->selectRaw("(SELECT valor * (SELECT quantidade FROM cotacao_faixa_etarias as cfed WHERE cfed.faixa_etaria_id = tad.faixa_etaria AND cfed.cotacao_id = ".$cot->id.") FROM tabelas as tad WHERE (tad.modelo = 'Ambulatorial' OR ta.modelo = 'Ambulatorial') AND tad.coparticipacao = 0 AND tad.odonto = ta.odonto AND tad.faixa_etaria = ta.faixa_etaria AND tad.cidade_id = ta.faixa_etaria AND tad.administradora_id = ta.administradora_id GROUP BY ta.faixa_etaria) AS ambulatorial_sem_coparticipacao")
        ->join("faixas_etarias as fe",'cfe.faixa_etaria_id', '=', 'fe.id')  
        ->join("tabelas as ta","ta.faixa_etaria","=","cfe.faixa_etaria_id")
        ->whereRaw("cotacao_id = ".$cot->id." AND ta.cidade_id = ".$cot->cidade_id)
        ->groupByRaw("ta.administradora_id,ta.faixa_etaria,ta.odonto")
        ->orderByRaw("ta.administradora_id,card,fe.nome")    
        ->get();
       
        
    // return $planos;    
      
               
        $faixas = CotacaoFaixaEtaria::where("cotacao_id","=",$cot->id)
            ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixa_nome")  
            ->get();   
        return view('admin.pages.cotacao.mostarPlano',[
            'planos' => $planos,
            'orcamento' => $cot->id,
            'faixas' => $faixas->toArray(),
            'fisica' => $request->modelo == "pf" ? 1 : 0,
            'juridica' => $request->modelo == "pj" ? 1 : 0,
            'telefone' =>  str_replace(["-","(",")"," "],"",  $request->telefone),
            'cidade' => $request->cidade,
            'cliente' => $cliente->id,
            
            'card_inicial' => $planos[0]->card      
        ]); 

        } else {
            $planos = [];
            return view('admin.pages.cotacao.mostarPlano',[
                'planos' => $planos,
                'orcamento' => ""
            ]);     
        }       
    }

    public function detalhesDoContratoComissoes($id)
    {  
        $comissoes = ComissoesCorretorLancados::where("comissao_id",$id)->get();
        $premiacao = PremiacaoCorretoresLancados::where("comissao_id",$id)->first();
        return view('admin.pages.contrato.detalhes',[
            "comissoes" => $comissoes,
            "premiacao" => $premiacao
        ]);
    }

    public function contrato($id)
    {
        $cliente = Cliente::where("id",$id)->first();
        
        if(!$cliente) {
            return redirect()->back();
        }
        $cidades = Cidade::all();
        $administradoras = Cidade::where("id",$cliente->cidade_id)->with('administradoras')->first();
        
        $operadoras = Operadora::all();
        if($cliente->pessoa_fisica) {
            $planos = Planos::where("nome","LIKE","%Individual%")->orWhere("nome","LIKE","%Coletivo Por Ade%")->get();
        } else {
            $planos = Planos::where("nome","LIKE","%Super Simples%")->orWhere("nome","LIKE","PME Boletado")->get();
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

    public function storeContrato(Request $request)
    {
       
       
       $valor = str_replace([".",","],["","."],$request->valor); 
       
    //    $rules = [
    //      "valor_adesao" => "required",
    //      "cpf" => "unique:clientes,cpf"
    //    ];

    //    $message = [
    //     "valor_adesao.required" => "E valor adesão e campo obrigatorio",
    //     "cpf.unique" => "CPF já está cadastrado"
    //    ];

    //    $request->validate($rules,$message); 
        /** Vai Na Tabela Cliente E acaba de realizar o cadastro */       
        $cliente = Cliente::where("id",$request->cliente_id)->first();
        $cliente->etiqueta_id = 3;
        $cliente->ultimo_contato = date('Y-m-d');
        $cliente->cpf = $request->cpf;
        $cliente->data_nascimento = date('Y-m-d',strtotime($request->data_nascimento));
        $cliente->responsavel_financeiro = $request->responsavel_financeiro;
        $cliente->cpf_financeiro = $request->cpf_financeiro;
        $cliente->endereco = $request->endereco_financeiro;
        $cliente->data_vigente = date('Y-m-d',strtotime($request->data_vigencia));
        $cliente->valor_adesao = str_replace([".",","],["","."],$request->valor_adesao);
        $cliente->data_boleto = date('Y-m-d',strtotime($request->data_boleto));
        $cliente->save();

        /** Tabela Cotacao Cadastrao/Update */
        $cotacao = Cotacao::where("cliente_id",$request->cliente_id)->first();
        if($cotacao) {
            $cotacao->operadora_id = $request->operadora;
            $cotacao->administradora_id = $request->administradora;
            $cotacao->plano_id = $request->plano;
            $cotacao->acomodacao_id = $request->acomodacao;
            $cotacao->financeiro_id = ($request->plano == 1 ? 3 : 1);
            $cotacao->codigo_externo = $request->codigo_externo;
            $cotacao->coparticipacao = ($request->coparticipacao == "sim" ? 1 : 0);
            $cotacao->odonto = ($request->odonto == "sim" ? 1 : 0);
            $cotacao->valor = $valor;
            $cotacao->acomodacao_id = Acomodacao::where("nome",'LIKE',"%{$request->acomodacao}%")->first()->id;
            $cotacao->save();
        } else {
            $cotacao = new Cotacao();
            $cotacao->cliente_id = $request->cliente_id;
            $cotacao->cidade_id = $request->cidade;
            $cotacao->operadora_id = $request->operadora;
            $cotacao->administradora_id = $request->administradora;
            $cotacao->plano_id = $request->plano;
            $cotacao->acomodacao_id = $request->acomodacao;
            $cotacao->financeiro_id = ($request->plano == 1 ? 3 : 1);
            $cotacao->user_id = auth()->user()->id;
            $cotacao->corretora_id = auth()->user()->corretora_id;
            $cotacao->codigo_externo = $request->codigo_externo;
            $cotacao->coparticipacao = ($request->coparticipacao == "sim" ? 1 : 0);
            $cotacao->odonto = ($request->odonto == "sim" ? 1 : 0);
            $cotacao->acomodacao_id = Acomodacao::where("nome",'LIKE',"%{$request->acomodacao}%")->first()->id;
            $cotacao->valor = $valor;
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
        $comissao->status = 1;
        $comissao->data = date('Y-m-d');
        $comissao->save();    


        /** Comissao Corretor */
        $comissoes_configuradas_corretor = ComissoesCorretoresConfiguracoes
            ::where("plano_id",$request->plano)
            ->where("administradora_id",$request->administradora)
            ->where("user_id",auth()->user()->id)
            ->where("cidade_id",$request->cidade)
            ->get();
        $comissao_corretor_contagem = 0;
        if(count($comissoes_configuradas_corretor) >= 1) {
            foreach($comissoes_configuradas_corretor as $c) {
                $comissaoVendedor = new ComissoesCorretorLancados();
                $comissaoVendedor->comissao_id = $comissao->id;
                $comissaoVendedor->user_id = auth()->user()->id;
                $comissaoVendedor->parcela = $c->parcela;
                if($comissao_corretor_contagem == 0) {
                    $comissaoVendedor->data = date('Y-m-d',strtotime($request->data_boleto));
                } else {
                    $comissaoVendedor->data = date("Y-m-d",strtotime($request->data_boleto."+{$comissao_corretor_contagem}month"));
                }
                $comissaoVendedor->valor = ($valor * $c->valor) / 100;
                $comissaoVendedor->save();  
                $comissao_corretor_contagem++;  
            }
        }

        /** Premiacao Corretor Por Total de Vida */
        $premiacao_configurada_corretor = PremiacaoCorretoresConfiguracoes
            ::where("plano_id",$request->plano)
            ->where("administradora_id",$request->administradora)
            ->where("user_id",auth()->user()->id)
            ->where("cidade_id",$request->cidade)
            ->get();
        // dd($premiacao_configurada_corretor->valor);
        // $dd = (float) $premiacao_configurada_corretor->valor * $totalVidas;
        $premiacao_corretor_contagem = 0;
        if(count($premiacao_configurada_corretor)>=1) {
            foreach($premiacao_configurada_corretor as $k => $p) {
                $premiacaoCorretoresLancados = new PremiacaoCorretoresLancados();

                $premiacaoCorretoresLancados->comissao_id = $comissao->id;
                $premiacaoCorretoresLancados->user_id = auth()->user()->id;
                $premiacaoCorretoresLancados->total = (float) $p->valor * $totalVidas;
                if($premiacao_corretor_contagem == 0) {
                    $premiacaoCorretoresLancados->data = date('Y-m-d',strtotime($request->data_boleto));
                } else {
                    $premiacaoCorretoresLancados->data = date("Y-m-d",strtotime($request->data_boleto."+{$premiacao_corretor_contagem}month"));
                }
                $premiacaoCorretoresLancados->save();
                $premiacao_corretor_contagem++;
            }


            
        }
        
        /** Comissao Corretora */   
        $comissoes_configurada_corretora = ComissoesCorretoraConfiguracoes::where("administradora_id",$request->administradora)->get();
        $comissoes_corretora_contagem=0;
        if(count($comissoes_configurada_corretora)>=1) {
            foreach($comissoes_configurada_corretora as $cc) {                
                $comissaoCorretoraLancadas = new ComissoesCorretoraLancadas();
                $comissaoCorretoraLancadas->comissao_id = $comissao->id;            
                $comissaoCorretoraLancadas->parcela = $cc->parcela;
                if($comissoes_corretora_contagem == 0) {
                    $comissaoCorretoraLancadas->data = date('Y-m-d',strtotime($request->data_boleto));
                } else {
                    $comissaoCorretoraLancadas->data = date("Y-m-d",strtotime($request->data_boleto."+{$comissoes_corretora_contagem}month"));
                }
                $comissaoCorretoraLancadas->valor = ($valor * $cc->valor) / 100;
                $comissaoCorretoraLancadas->save();
                $comissoes_corretora_contagem++;
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
        if($cliente->pessoa_fisica == 1) {
            // return u
            return redirect()->route('contratos.pf.pendentes')->with('cliente_id',$request->cliente_id);
            //return redirect()->url('/admin/contratos/pf?id='.$request->cliente_id);
            // return redirect()->route('/admin/contratos/pf?id='.$request->cliente_id);
            //echo url("/admin/contratos/pf?id=".$request->cliente_id);
        
        } else {
            return redirect()->route('contratos.pj.pendentes')->with('cliente_id',$request->cliente_id);
        }
        
    }


    public function montarValoresFormularioAcomodacao(Request $request)
    {
        $cot = Cotacao::where('cliente_id',$request->cliente_id)->first();
        /** Cliente Ja Possui Cotacao??? */    
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
                } 
            }
            $cot = $cotacao;
            $valores = DB::table("cotacao_faixa_etarias")
            ->join("tabelas","tabelas.faixa_etaria","=","cotacao_faixa_etarias.faixa_etaria_id")
            ->selectRaw("sum(valor * (SELECT quantidade FROM cotacao_faixa_etarias WHERE cotacao_id = ".$cot->id." AND cotacao_faixa_etarias.faixa_etaria_id = tabelas.faixa_etaria)) AS total")
            ->selectRaw("(SELECT id FROM acomodacao WHERE tabelas.modelo LIKE acomodacao.nome) AS id_acomodacao")
            ->selectRaw("modelo")
            ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) AS plano")
            ->selectRaw("if(coparticipacao = 0,'Sem Coparticipacao','Com Coparticipacao') AS coparticipacao")
            ->selectRaw("if(odonto = 0,'Sem Odonto','Com Odonto') AS odonto")
            ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS operadora")
            ->whereRaw("tabelas.cidade_id = ".$request->cidade." AND tabelas.operadora_id = ".$request->operadora." AND tabelas.administradora_id = ".$request->administradora." AND odonto = ".($request->odonto == "sim" ? 1 : 0)." AND coparticipacao = ".($request->coparticipacao == "sim" ? 1 : 0)." AND tabelas.plano_id = ".$request->plano." AND cotacao_faixa_etarias.cotacao_id = ".$cot->id)
            ->groupBy('modelo')
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
            $valores = DB::table("cotacao_faixa_etarias")
            ->join("tabelas","tabelas.faixa_etaria","=","cotacao_faixa_etarias.faixa_etaria_id")
            ->selectRaw("sum(valor * (SELECT quantidade FROM cotacao_faixa_etarias WHERE cotacao_id = ".$cot->id." AND cotacao_faixa_etarias.faixa_etaria_id = tabelas.faixa_etaria)) AS total")
            ->selectRaw("(SELECT id FROM acomodacao WHERE tabelas.modelo LIKE acomodacao.nome) AS id_acomodacao")
            ->selectRaw("modelo")
            ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) AS plano")
            ->selectRaw("if(coparticipacao = 0,'Sem Coparticipacao','Com Coparticipacao') AS coparticipacao")
            ->selectRaw("if(odonto = 0,'Sem Odonto','Com Odonto') AS odonto")
            ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS operadora")
            ->whereRaw("tabelas.cidade_id = ".$request->cidade." AND tabelas.operadora_id = ".$request->operadora." AND tabelas.administradora_id = ".$request->administradora." AND odonto = ".($request->odonto == "sim" ? 1 : 0)." AND coparticipacao = ".($request->coparticipacao == "sim" ? 1 : 0)." AND tabelas.plano_id = ".$request->plano." AND cotacao_faixa_etarias.cotacao_id = ".$cot->id)
            ->groupBy('modelo')
            ->get();
          
        }
        $faixas_etarias = DB::table("cotacao_faixa_etarias")
            ->join("tabelas","tabelas.faixa_etaria","=","cotacao_faixa_etarias.faixa_etaria_id")
            ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = cotacao_faixa_etarias.faixa_etaria_id) AS faixas")
            ->selectRaw("quantidade,valor,modelo")
            ->selectRaw("(cotacao_faixa_etarias.quantidade * tabelas.valor) AS total")
            ->whereRaw("cotacao_id = ? AND administradora_id = ? AND cidade_id = ? AND odonto = ? AND coparticipacao = ? AND plano_id = ?",[$cot->id,$request->administradora,$request->cidade,($request->odonto == "sim" ? 1 : 0),($request->coparticipacao == "sim" ? 1 : 0),$request->plano])
            ->get();
        
        //$orcamentoFaixaEtaria = CotacaoFaixaEtaria::where("cotacao_id",$cot->id)->delete();
        //$cot->delete();
        return view("admin.pages.cotacao.acomodacao",[
            "valores" => $valores,
            "data_boleto" => $request->data_boleto,
            "data_vigencia" => $request->data_vigencia,
            "faixas" => $faixas_etarias
        ]);
    }

    public function detalhesDoContratoComissoesAdministrador($id)
    {
        
        $comissoes = ComissoesCorretorLancados::where("comissao_id",$id)->get();
        $premiacao = PremiacaoCorretoresLancados::where("comissao_id",$id)->get();

        $comissao_corretora = ComissoesCorretoraLancadas::where("comissao_id",$id)->get();
        $premiacao_corretora = PremiacaoCorretoraLancadas::where("comissao_id",$id)->first();
        
        return view('admin.pages.contrato.administrador',[
            "comissoes" => $comissoes,
            "premiacao" => $premiacao,
            "comissao_corretora" => $comissao_corretora,
            "premiacao_corretora" => $premiacao_corretora
        ]);
    }


}
