<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermissionUser;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUpdateColaboradores;
use App\Models\Administradora;
use Illuminate\Support\Facades\Storage;
use App\Support\Thumb;


class CorretoresController extends Controller
{
    private $repository;

    public function __construct(User $user)
    {
        $this->repository = $user;
        //$this->middleware(['can:corretor']);
    }
       
    public function index()
    {
        
        $id = auth()->user()->id;
        
        $corretores = $this->repository->where("id","!=",$id)->whereHas('permissions',function($query){
            $query->where("permission_id","!=",5);
        })->get();

        $financeiro = $this->repository->where("id","!=",$id)->whereHas('permissions',function($query){
            $query->where("permission_id",5);
        })->get();
        
        
        return view('admin.pages.corretores.index',[
            'corretores' => $corretores,
            'financeiro' => $financeiro
        ]);
    }

    public function create()
    {
        $administradoras = Administradora::all();

        $permission = Permission::all();
        return view('admin.pages.corretores.create',[
            "permissions" => $permission,
            "administradoras" => $administradoras
        ]);
    }

    public function validaCPF($cpf) {
 
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    
    }

    public function store(StoreUpdateColaboradores $request)
    {
        $dados = $request->all();
        
        if(isset($request->cpf) && !empty($request->cpf)) {
            if(!$this->validaCPF($request->cpf)) {
                return redirect()->route('corretores.create')->with("errorcpf","CPF inválido")->withInput($request->input());
            }
        }

        
        
        $dados['password'] = bcrypt($request->password);
        if(!empty($request->file('image'))) {
            $dados['image'] = $request->file('image')->store('users','public');
        }
        $dados['corretora_id'] = auth()->user()->corretora_id; 
        $user = User::create($dados);
        foreach($request->permission as $p):
            $pu = new PermissionUser();
            $pu->user_id = $user->id;
            $pu->permission_id = $p;
            $pu->save();
        endforeach;
        return redirect()->route('corretores.index');
    }

    public function edit($id)
    {
        $corretor = $this->repository->with('permissions')->find($id);
                
        if(!$corretor) {
            return redirect()->back();  
        }
        
        $permissionUser = [];
        foreach($corretor->permissions as $p):
            array_push($permissionUser,$p->permission_id);    
        endforeach;    
        $permissions = Permission::all();
        
        return view("admin.pages.corretores.edit",[
            'corretor' => $corretor,
            'permissions' => $permissions,
            'permissionUser' => $permissionUser
        ]);
    }

    public function update(Request $request,$id)
    {   
        $corretor = User::find($id);
        if(!$corretor) {
            return redirect()->back();  
        }
        $dados = $request->all();
        if(empty($request->password)) {
            unset($dados['password']);
        } else {
            $dados['password'] = bcrypt($request->password);
        }
        if(!empty($request->file('image'))) {
            Storage::delete("public/".$corretor->image);
            
            (new Thumb())->flush($corretor->image);
            $corretor->image = "";
        }
        $corretor->fill($dados);
        if(!empty($request->file('image'))) {
            $corretor->image =  $request->file('image')->store('users','public');
        }
        $corretor->save();
        
        $corretor->permissionsUser()->sync($request->permission);    
        return redirect()->route('corretores.index');
    }

    public function destroy($id)
    {
        $corretor = $this->repository->where('id',$id)->first();
        if(!$corretor) {
            return redirect()->back();  
        }
        $corretor->delete();
        return redirect()->route('corretores.index');
    }



}
