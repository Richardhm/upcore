<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operadora;
use App\Models\Tipo;
use App\Models\CorretoraOperadora;
use Illuminate\Support\Facades\Storage;

class OperadoraController extends Controller
{
    private $repository;

    public function __construct(Operadora $operadora)
    {
        $this->repository = $operadora;
        $this->middleware(['can:operadora']);
    }

    public function index()
    {
        // $corretora = auth()->user()->corretora_id;
        // $operadoras = Operadora::whereIn('operadoras.id', function($query) use($corretora) {
        //     $query->select('corretora_operadora.operadora_id');
        //     $query->from('corretora_operadora');
        //     $query->whereRaw("corretora_operadora.corretora_id={$corretora}");
        // })->get();

        $operadoras = Operadora::all();    


        return view('admin.pages.operadora.index',[
            "operadoras" => $operadoras
        ]);
    }

    public function create()
    {
        return view('admin.pages.operadora.create');
    }

    public function store(Request $request)
    {
        $roles = [
            "nome" => "required",
            "logo" => "required"
        ];
        $messages = [
            "nome.required" => "O campo nome e campo obrigatorio",
            "logo.required" => "O campo logo e campo obrigatorio"
        ];
        $request->validate($roles,$messages);
        $operadora = new Operadora();
        $operadora->nome = $request->nome;
        if(!empty($request->file('logo'))) {
            $operadora->logo = $request->file('logo')->store('operadoras','public');
        }
        
        $operadora->save();
        // $co = new CorretoraOperadora();
        // $co->corretora_id = auth()->user()->corretora_id;
        // $co->operadora_id = $operadora->id;
        // $co->save();
        return redirect()->route('operadora.index');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $operadora = $this->repository->find($id);
        if(!$operadora) {
            return redirect()->back();
        }   
        return view('admin.pages.operadora.edit',[
            "operadora" => $operadora
        ]);
    }

    public function update(Request $request, $id)
    {
        $operadora = $this->repository->find($id);
        if(!$operadora) {
            return redirect()->back();
        }
        if(!empty($request->file('logo'))) {
            Storage::delete("public/".$operadora->logo);
            $operadora->logo = '';
        } 
        $operadora->fill($request->all());
        if(!empty($request->file('logo'))) {
            $operadora->logo = $request->file('logo')->store('operadoras','public');
        }
        $operadora->save();
        return redirect()->route('operadora.index');
    }

    public function destroy($id)
    {   
        $operadora = $this->repository->where("id",$id)->first();
        if(!$operadora) {
            return redirect()->back();
        }
        Storage::delete("public/".$operadora->logo);
        $operadora->delete();
        return redirect()->back();

    }
}
