<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;
    protected $table = "comissoes";
    protected $fillable = ["cotacao_id","cliente_id","user_id","status"];

    public function comissaoLancadas()
    {
        return $this->hasMany(ComissoesCorretorLancados::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cotacao()
    {
        return $this->belongsTo(Cotacao::class);
    }
}
