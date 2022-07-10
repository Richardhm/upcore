<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorretoraOperadora extends Model
{
    use HasFactory;
    protected $fillable = ["corretora_id","operadora_id"];
    protected $table = "corretora_operadora";
}
