<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateOperadora;
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
        $this->middleware(['can:configuracoes']);
    }

    public function index()
    {
        $operadoras = Operadora::all();    
        return view('admin.pages.operadora.index',[
            "operadoras" => $operadoras
        ]);
    }

    public function create()
    {
        return view('admin.pages.operadora.create');
    }

    public function store(StoreUpdateOperadora $request)
    {
        $operadora = new Operadora();
        $operadora->nome = $request->nome;
        if(!empty($request->file('logo'))) {
            $operadora->logo = $request->file('logo')->store('operadoras','public');
        }
        
        $operadora->save();
        
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

    public function update(StoreUpdateOperadora $request, $id)
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
