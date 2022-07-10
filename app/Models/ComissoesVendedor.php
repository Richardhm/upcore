<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissoesVendedor extends Model
{
    use HasFactory;
    protected $table = "comissoes_vendedor";
    protected $fillable = ["comissao_id","parcela","data","valor","status"];
}
