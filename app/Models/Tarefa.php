<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;
    protected $table = "tarefas";
    protected $fillable = ["cliente_id","user_id","data","title","descricao"];
    

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }



}
