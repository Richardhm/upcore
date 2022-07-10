<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministradoraCidade extends Model
{
    use HasFactory;
    protected $table = "administradora_cidade";
    protected $fillable = ["administradora_id","cidade_id"];
}
