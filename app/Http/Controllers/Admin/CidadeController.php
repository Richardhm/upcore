<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Administradora,
    Cidade,
    AdministradoraCidade
};
use Illuminate\Support\Facades\DB;

class CidadeController extends Controller
{
    public function index()
    {
        $cidades = Cidade::paginate();
        

        return view('admin.pages.cidades.index',[
            "cidades" => $cidades
        ]);

    }

    public function vincular($id)
    {
        $cidade = Cidade::where("id",$id)->first();
        if(!$cidade) {
            return redirect()->back();
        }

        $administradoras = Administradora::all();

        $marcados = [];
        $cidades = AdministradoraCidade::where("cidade_id",$id)->get();
        
        if(count($cidades) >= 1) {
            foreach($cidades as $k => $v) {
                $marcados[] = $v->administradora_id;
            }
        }
        
        return view('admin.pages.cidades.administradoras',[
            "administradoras" => $administradoras,
            "cidade" => $cidade,
            "marcados" => $marcados
        ]);
    }

    public function vincularAdministradora(Request $request,$idCidade) 
    {
        $cidade = Cidade::where("id",$idCidade)->first();
        if(!$cidade) {
            return redirect()->back();
        }
        $cidade->administradoras()->sync($request->administradora_id);

        return redirect()->route('cidades.index');
    }




   




    public function cadastrar()
    {
        $administradoras = Administradora::all();
        return view('admin.pages.cidades.create',[
            "administradoras" => $administradoras
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            "nome" => "required|unique:cidades|min:3|max:255"
            
        ]; 

        $message = [
            "nome.required" => "O campo nome e campo obrigatorio",
            "nome.unique" => "Está cidade já esta cadastrada",
            "nome.min" => "O campo nome deve ter no minimo 3 caracteres",
            "nome.max" => "O campo nome deve ter no maximo 255 caracteres"
        ];

        $request->validate($rules,$message);
        $cidade = new Cidade();   

        $cidade->nome = $request->nome;
        $cidade->corretora_id = auth()->user()->id;
        $cidade->uf = $request->uf;
        $cidade->save();
        //$ac = new AdministradoraCidade();
        //$ac->cidade_id = $cidade->id;
        //$ac->administradora_id = $request->administradora_id;
        //$ac->save();
        //$ac->administradora_id = $reque
        // $ac->create([
        //     "cidade_id" => $cidade->id,
        //     "administradora_id" => $request->administradora_id
        // ]);
        return redirect()->route('cidades.index');
    }

    public function pegarCidade(Request $request)
    {
        $administradora = $request->administradora;
        $cidades = DB::table('administradora_cidade')
            ->selectRaw("administradora_id,cidade_id")
            ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = administradora_cidade.cidade_id) AS nome_cidade")
            ->whereRaw("administradora_id = ".$administradora)
            ->get();

       

        

        //$cidades = DB::select(DB::raw("SELECT id,nome FROM cidades WHERE ID IN(SELECT cidade_id FROM administradora_cidade WHERE administradora_id = '".$administradora."')"))->toSql();
        $citys = [];
        if(count($cidades) >= 1) {
            foreach($cidades as $c) {
                $citys[] = [
                    "id" => $c->cidade_id,
                    "nome" => $c->nome_cidade 

                ];
            }
        }
        return $citys;
        
    }

    public function pegarOperadorasViaCidade(Request $request)
    {
        $cidade = $request->cidade;
        //return $cidade;
        $dados = DB::select(DB::raw("SELECT 
        (SELECT nome FROM administradoras WHERE administradoras.id = administradora_cidade.administradora_id) AS administradoras_nome,
        (SELECT logo FROM administradoras WHERE administradoras.id = administradora_cidade.administradora_id) AS administradoras_logo,
        (SELECT id FROM administradoras WHERE administradoras.id = administradora_cidade.administradora_id) AS administradoras_id 
        FROM administradora_cidade WHERE cidade_id = ".$cidade));
        
        return view('admin.pages.orcamento.logo-operadoras',[
            'operadoras' => $dados
        ]);
    }


    public function destroy($id)
    {
        $cidade = Cidade::where("id",$id)->first();
        if(!$cidade) {
            return redirect()->back();
        }
        $cidade->delete();
        return redirect()->route('cidades.index');
    }




}
