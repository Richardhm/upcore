<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotacaoFaixaEtaria extends Model
{
    use HasFactory;
    protected $table = "cotacao_faixa_etarias";
    protected $fillable = ["cotacao_id","faixa_etaria_id","quantidade"];
}
