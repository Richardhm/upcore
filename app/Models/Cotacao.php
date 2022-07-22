<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    use HasFactory;
    protected $table = "cotacoes";
    protected $fillable = ["cliente_id","cidade_id","operadora_id","administradora_id","acomodacao_id","plano_id","user_id","corretora_id","codigo_externo","valor"];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }

    public function administradora()
    {
        return $this->belongsTo(Administradora::class);
    }

    public function acomodacao()
    {
        return $this->belongsTo(Acomodacao::class);
    }

    public function plano()
    {
        return $this->belongsTo(Planos::class);
    }

}
