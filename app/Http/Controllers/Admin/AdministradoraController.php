<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administradora;
//use App\Models\AdministradoraParcelas;

use Illuminate\Support\Facades\Storage;
use App\Models\ComissoesCorretoraConfiguracoes;

class AdministradoraController extends Controller
{
    private $repository;

    public function __construct(Administradora $administradora)
    {
        $this->repository = $administradora;
        $this->middleware(['can:administradora']);
    }

    public function index()
    {
        $corretora = auth()->user()->corretora_id;
        

        $administradoras = Administradora::all();    

                
        return view('admin.pages.administradora.index',[
            "administradoras" => $administradoras
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.administradora.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $roles = [
            "nome" => "required|unique:administradoras",
            "logo" => "required",
            "premiacao_corretora" => "required"
        ];
        $messages = [
            "nome.required" => "O campo nome e campo obrigatorio",
            "nome.unique" => "Esta Administradora já esta cadastrada",
            "logo.required" => "O campo logo e campo obrigatorio",
            "premiacao_corretora.required" => "O campo Premiacao Corretora e campo obrigatorio"
        ];

        $request->validate($roles,$messages);
        $parcelas = array_values($request->parcelas);       
        $administradora = new Administradora();
        $administradora->nome = $request->nome;
        if(!empty($request->file('logo'))) {
            $administradora->logo = $request->file('logo')->store('administradoras','public');
        }
        $administradora->premiacao_corretora = $request->premiacao_corretora;
        // $administradora->premiacao_corretor = $request->premiacao_corretor;
        // $administradora->vitalicio = $request->vitalicio;
        //$administradora->quantidade_parcelas = count($request->parcelas);
        $administradora->save();
        
        foreach($parcelas as $k => $v) {
            $aa = new ComissoesCorretoraConfiguracoes();
            $aa->administradora_id = $administradora->id;
            $aa->corretora_id = auth()->user()->corretora_id;
            $aa->valor = $v['parcelas'];
            $aa->parcela = $k+1;
            $aa->save();    
            
        }

        return redirect()->route("administradora.index");
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $administradora = $this->repository->where("id",$id)->with('parcelas')->first();
        
        if(!$administradora) {
            return redirect()->back();
        }
        return view('admin.pages.administradora.edit',[
            "administradora" => $administradora
        ]);
    }

    public function update(Request $request, $id)
    {
        //$vitalicio = isset($request->vitalicio) && !empty($request->vitalicio) && $request->vitalicio != null ? $request->vitalicio : null;
        ComissoesCorretoraConfiguracoes::where('administradora_id',$id)->delete();
        $data = [];
        if($request->parcelas != null) {
            foreach($request->parcelas as $k => $v) {
                if($v['parcelas_new'] != null) {
                    $data[] = $v['parcelas_new'];    
                }
            }
        }
        $dados = array_merge($request->parcelas_bd,array_values($data));
        $administradora = $this->repository->where("id",$id)->first();      
        if(!$administradora) {
            return redirect()->back();
        }
        if(!empty($request->file('logo'))) {
            Storage::delete("public/".$administradora->logo);
            $administradora->logo = '';
        }        
        $administradora->fill($request->all());
        if(!empty($request->file('logo'))) {
            $administradora->logo = $request->file('logo')->store('administradoras','public');
        }
        $ii=1;
        foreach($dados as $kk => $vv) {
            $admP = new ComissoesCorretoraConfiguracoes();
            $admP->administradora_id = $administradora->id;
            $admP->valor = $vv;
            $admP->corretora_id = auth()->user()->corretora_id;
            $admP->parcela = $ii++;
            $admP->save();
        }
        //$administradora->vitalicio = $vitalicio;
        //$administradora->quantidade_parcelas = count($request->parcelas_bd);
        $administradora->save();
        return redirect()->route('administradora.index');
    }

    
    public function destroy($id)
    {
        $comissoes = ComissoesCorretoraConfiguracoes::where('administradora_id',$id)->first();
        if($comissoes) {
            ComissoesCorretoraConfiguracoes::where('administradora_id',$id)->delete();
        }
        $administradora = $this->repository->find($id);
        if(!$administradora) {
            return redirect()->back();
        }
        Storage::delete("public/".$administradora->logo);
        $administradora->delete();
        return redirect()->route('administradora.index');
    }
}
