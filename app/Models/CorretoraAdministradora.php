<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorretoraAdministradora extends Model
{
    use HasFactory;
    protected $fillable = ["corretora_id","administradora_id"];
    protected $table = "corretora_administradora";
}
