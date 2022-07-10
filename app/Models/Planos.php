<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planos extends Model
{
    use HasFactory;
    protected $table = "planos";
    protected $fillable = ["nome"];


    public function administradoras()
    {
        return $this->belongsToMany(Administradora::class,'administradora_planos', 'plano_id', 'administradora_id');
    }




}
