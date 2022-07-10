<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Comissao,
    ComissoesVendedor
};
use Illuminate\Support\Facades\DB;

class ComissoesController extends Controller
{
    public function index()
    {
        $comissoes = DB::table('comissoes')
            ->selectRaw("id,created_at")
            ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = comissoes.cliente_id) AS cliente")
            ->selectRaw("(SELECT name FROM users WHERE users.id = comissoes.user_id) AS corretor")
            ->selectRaw("(SELECT COUNT(*) FROM comissoes_vendedor WHERE comissoes.id = comissoes_vendedor.comissao_id) AS quantidade_parcelas")
            ->get();
        return view('admin.pages.comissoes.index',[
            'comissoes' => $comissoes
        ]);
    }

    public function detalhes($id)
    {
        $comissoes = ComissoesVendedor::where('comissao_id',$id)->get();
        return view('admin.pages.comissoes.detalhes',[
            'comissoes' => $comissoes
        ]);
    }

    public function mudarStatus(Request $request)
    {
        $id = $request->id;
        $comissao = ComissoesVendedor::where("id",$id)->first();
        if(!$comissao) {
            return false;
        }
        $comissao->status = $comissao->status ? false : true;
        $comissao->save();

        return $comissao->status;
    }

    



}
