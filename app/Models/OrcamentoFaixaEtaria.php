<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoFaixaEtaria extends Model
{
    use HasFactory;
    protected $table = "orcamento_faixa_etarias";
    protected $fillable = ["orcamento_id","faixa_etaria_id","quantidade"];
}
