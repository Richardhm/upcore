<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;
    protected $table = "comissoes";
    protected $fillable = ["contrato_id","cliente_id","user_id"];

    public function comissaoLancadas()
    {
        return $this->hasMany(ComissoesCorretorLancados::class);
    }
}
