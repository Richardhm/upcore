<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Cliente,
    Tarefa
};
use Illuminate\Support\Facades\DB;


class TarefaController extends Controller
{
    public function agendaTarefa($id)
    {
        
        $cliente = Cliente::where("id",$id)
            ->with('tarefas')
            ->first();
            
        
        if(!$cliente) {
            return redirect()->back();
        }

        return view('admin.pages.tarefas.index',[
            "cliente" => $cliente
        ]);

    }

    public function cadastrarTarefa(Request $request)
    {
        
        $rules = [
            "title" => "required",
            "data" => "required",
            "descricao" => "required"
        ];

        $message = [
            "title.required" => "O campo titulo e campo obrigatório",
            "data.required" => "O campo data e campo obrigatório",
            "descricao.required" => "Descrição e campo obrigatório"
        ];

        $request->validate($rules,$message);

        $cliente = Cliente::where("id",$request->cliente_id)->first();
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->save();

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        

        Tarefa::create($data);
        return redirect()->route('clientes.agendarTarefa',[$request->cliente_id]);
        
    }

    public function clienteTarefaEspecifica(Request $request)
    {
        $tarefas = DB::table("tarefas")
            ->selectRaw("title")
            ->selectRaw("id")
            ->selectRaw("descricao")
            ->selectRaw("DATE_FORMAT(DATA, '%Y-%m-%d') as start")
            ->whereRaw("tarefas.cliente_id = ".$request->id)
            ->get();
           
        return response()->json($tarefas);
    }

    public function alterarClienteTarefaEspecifica(Request $request)
    {
        $id = $request->tarefa_id;
        $title = $request->title;
        $data = $request->data;
        $descricao = $request->descricao;
        $tarefa = Tarefa::where("id",$id)->first();
        $tarefa->update(["title"=>$title,"data"=>$data,"descricao"=>$descricao]);
        $tarefa->save();
        return redirect()->route('clientes.agendarTarefa',[$request->cliente_id]);
    }

    public function tarefaEventDropEdit(Request $request)
    {
        $id = $request->id;
        $start = $request->start;
        $tarefa = Tarefa::where("id",$id)->first();
        $tarefa->data = $start;
        $tarefa->save();
    }

    public function deletarCliente(Request $request)
    {
        $id = $request->id;
        $cliente = $request->cliente;
        $tarefa = Tarefa::where("id",$id)->first();
        $tarefa->delete();
        return redirect()->route('clientes.agendarTarefa',[$cliente]);
    }

    public function tarefasProximo03Dias()
    {
        $tarefasProximas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                ->whereDate('data',">=",date("Y-m-d"))
                ->get();

        return view('admin.pages.tarefas.proximas',[
            "tarefas" => $tarefasProximas
        ]);       
    }



}
