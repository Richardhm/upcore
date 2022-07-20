<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiacaoCorretoresLancados extends Model
{
    use HasFactory;
    protected $table = "premiacao_corretores_lancados";
    protected $fillable = ["comissao_id","user_id","total","status"];

    public function comissao()
    {
        return $this->belongsTo(Comissao::class);
    }
}
