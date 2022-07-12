<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissoesCorretoraAdministradora extends Model
{
    use HasFactory;
    protected $table = "comissoes_corretora_administradoras";
    protected $fillable = ["administradora_id","corretora_id","parcela","data","valor","status"];
}
