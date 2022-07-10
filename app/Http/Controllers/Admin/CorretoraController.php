<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateCorretora;
use App\Models\Corretora;
use App\Models\User;


class CorretoraController extends Controller
{   
    private $repository;


    public function __construct(Corretora $corretora)
    {
        $this->repository = $corretora;   
        $this->middleware(['can:corretora']); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corretora = $this->repository->with('user')->first();
        return view('admin.pages.corretora.index',[
            'corretora' => $corretora
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.corretora.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCorretora $request)
    {
        
        $this->repository->create($request->all());
        return redirect()->route('corretora.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$corretora = $this->repository->find($id)) {
            return redirect()->back();
        }
        
        return view('admin.pages.corretora.edit',[
            'corretora' => $corretora
        ]);

    }

    public function update(Request $request, $id)
    {
        if(!$corretora = $this->repository->find($id)) {
            return redirect()->back();
        }

        $corretora->update($request->all());

        return redirect()->route("corretora.index");
    }


    public function destroy($id)
    {
        //
    }
}
