<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administradora;
use App\Models\AdministradoraPlano;
use Illuminate\Http\Request;
use App\Models\Planos;
use JeroenNoten\LaravelAdminLte\AdminLte;

class PlanoController extends Controller
{
    private $repository;

    public function __construct(Planos $planos)
    {
        $this->repository = $planos;
    }


    public function index()
    {
        $planos = $this->repository->paginate();
        return view("admin.pages.plans.index",[
            "planos" => $planos
        ]);
    }

    public function create()
    {
        return view("admin.pages.plans.create");
    }

    public function store(Request $request)
    {
        $rules = [
            "nome" => "required|unique:planos,nome|min:3|max:255"
        ];

        $message = [
            "nome.required" => "O campo nome é campo obrigatório",
            "nome.unique" => "Esse plano já esta cadastrado",
            "nome.min" => "O campo plano deve ter no minimo 3 caracteres",
            "nome.max" => "O campo plano deve ter no maximo 255 caracteres"
        ];

        $request->validate($rules,$message);


        $this->repository->create($request->all());
        return redirect()->route('plano.index');
    }


    public function vincular($id)
    {
        $administradoras = Administradora::all();
        $plano = $this->repository->find($id);
        if(!$plano) {
            return redirect()->route('plano.index');
        }

        $marcados = [];
        $planos = AdministradoraPlano::where("plano_id",$id)->get();
        
        if(count($planos) >= 1) {
            foreach($planos as $k => $v) {
                $marcados[] = $v->administradora_id;
            }
        }

        return view('admin.pages.plans.vincular',[
            "administradoras" => $administradoras,
            "plano" => $plano,
            "marcados" => $marcados
        ]);
    }

    public function vincularAdministradoras(Request $request,$id)
    {
        
        $plano = Planos::where("id",$id)->first();
               
        if(!$plano) {
            return redirect()->back();
        }

        //dd($request->administradora_id);


        $plano->administradoras()->sync($request->administradora_id);

        return redirect()->route('plano.index');
        
       




        
        
        //dd($request->administradora_id);
        // $plano = $this->repository->find($id);
        // if(!$plano) {
        //     return redirect()->back();
        // }

        // $plano->administradoras()->sync($request->administradora_id);
        // return redirect()->route('plano.index');
        
        // $cidade = Cidade::where("id",$idCidade)->first();
        // if(!$cidade) {
        //     return redirect()->back();
        // }
        // $cidade->administradoras()->sync($request->administradora_id);

        // return redirect()->route('cidades.index');

        // $cidade = Cidade::where("id",$id)->first();
        // if(!$cidade) {
        //     return redirect()->back();
        // }
        // $cidade->administradoras()->sync($request->administradora_id);

        // return redirect()->route('cidades.index');
    }

    



    
    public function delete($id)
    {
        $plano = $this->repository->find($id);
        if(!$plano) {
            return redirect()->back();
        }

        $plano->delete();
        return redirect()->route('plano.index');



    }






}
