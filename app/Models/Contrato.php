<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $table = "contratos";
    protected $fillable = ["cliente_id","cidade_id","operadora_id","administradora_id","orcamento_id","acomodacao_id","codigo_externo","valor","status"];



}
