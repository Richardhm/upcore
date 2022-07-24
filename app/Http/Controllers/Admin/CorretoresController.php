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
        $corretora = auth()->user()->corretora_id;
        $corretores = DB::select("SELECT * FROM users WHERE corretora_id = ? AND id != ?",[$corretora,$id]);
        return view('admin.pages.corretores.index',[
            'corretores' => $corretores
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

    public function store(StoreUpdateColaboradores $request)
    {
        $dados = $request->all();
        
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
