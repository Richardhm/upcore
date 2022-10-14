<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarefasTitulo extends Model
{
    use HasFactory;
    protected $table = "tarefas_titulos";
    protected $fillable = ["titulo"];
}
