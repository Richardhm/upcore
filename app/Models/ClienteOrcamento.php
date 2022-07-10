<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteOrcamento extends Model
{
    use HasFactory;
    protected $table = "cliente_orcamento";
    protected $fillable = ["cliente_id","orcamento_id","cidade_id"];
    
}
