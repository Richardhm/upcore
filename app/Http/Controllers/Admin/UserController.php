<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser($id)
    {
        $user = User::where("id",$id)->first();
        if(!$user || $user->id != $id) {
            return redirect()->back();
        }
        return view('admin.pages.profiles.edit',[
            'user' => $user
        ]);
    }

    public function setUser(Request $request,$id)
    {
        $user = User::where("id",$id)->first();
        
        if(!$user || $user->id != $id) {
            return redirect()->back();
        }

        if($request->email != $user->email) {
            return redirect()->route('profile.getUser',$user->id)->with('error',"Email diferente do cadastrado no Banco de Dados");
        }

        // $user->fill()







    }


}
