<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $table = "cidades";
    protected $fillable = ["corretora_id","uf","nome"];


    public function administradoras()
    {
        return $this->belongsToMany(Administradora::class);
    }



}
