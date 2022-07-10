<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermissionUser;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUpdateColaboradores;



class ColaboradoresController extends Controller
{
    private $repository;

    public function __construct(User $user)
    {
        $this->repository = $user;
        $this->middleware(['can:colaboradores']);
    }
       
    public function index()
    {
        $id = auth()->user()->id;
        $corretora = auth()->user()->corretora_id;
        $colaboradores = DB::select("SELECT * FROM users WHERE corretora_id = ? AND id != ?",[$corretora,$id]);
        
        return view('admin.pages.colaboradores.index',[
            'colaboradores' => $colaboradores
        ]);
    }

    public function create()
    {
        $permission = Permission::all();

        return view('admin.pages.colaboradores.create',[
            "permissions" => $permission

        ]);
    }

    public function store(StoreUpdateColaboradores $request)
    {
        
        $user = new User();
        $user->name = $request->nome;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->corretora_id = auth()->user()->corretora_id;
        $user->save();

        foreach($request->permission as $p):
            $pu = new PermissionUser();
            $pu->user_id = $user->id;
            $pu->permission_id = $p;
            $pu->save();
        endforeach;

        return redirect()->route('colaboradores.index');

    }

    public function edit($id)
    {
        $colaborador = $this->repository->with('permissions')->find($id);
        if(!$colaborador) {
            return redirect()->back();  
        }
        
        $permissionUser = [];
        foreach($colaborador->permissions as $p):
            array_push($permissionUser,$p->permission_id);    
        endforeach;    
        $permissions = Permission::all();
        
        return view("admin.pages.colaboradores.edit",[
            'colaborador' => $colaborador,
            'permissions' => $permissions,
            'permissionUser' => $permissionUser
        ]);
    }

    public function update(Request $request,$id)
    {   
        $colaborador = $this->repository->where('id',$id)->first();
        if(!$colaborador) {
            return redirect()->back();  
        }
        if(empty($request->password)) {
            unset($request['password']);
        } 
        $colaborador->update($request->all());
        $colaborador->permissionsUser()->sync($request->permission);    
        return redirect()->route('colaboradores.index');
    }

    public function destroy($id)
    {
        $colaborador = $this->repository->where('id',$id)->first();
        if(!$colaborador) {
            return redirect()->back();  
        }
        //dd($id);


        $colaborador->delete();
        return redirect()->route('colaboradores.index');
    }



}
