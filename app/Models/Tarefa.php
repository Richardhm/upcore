<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;
    protected $table = "tarefas";
    protected $fillable = ["cliente_id","user_id","titulo_id","data","descricao"];
    

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function titulo()
    {
        return $this->belongsTo(TarefasTitulo::class);
    }



}
