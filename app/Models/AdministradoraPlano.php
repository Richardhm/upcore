<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministradoraPlano extends Model
{
    use HasFactory;

    protected $table = "administradora_planos";
    protected $fillable = ["administradora_id","plano_id"];


}
