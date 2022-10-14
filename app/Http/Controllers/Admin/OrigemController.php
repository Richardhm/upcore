<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Origem;
use Illuminate\Http\Request;

class OrigemController extends Controller
{
    public function index() 
    {
        $origens = Origem::all();
        return view("admin.pages.origem.index",[
            "origem" => $origens
        ]);
    }

    public function store(Request $request)
    {
        Origem::create($request->all());
    }

    public function readOrigem()
    {
        $origem = Origem::all();
        return $origem;
    }
}
