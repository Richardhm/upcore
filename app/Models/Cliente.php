<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = ['cidade_id','user_id','nome','telefone','email','cpf','endereco','cnpj','nome_empresa','pessoa_fisica','pessoa_juridica','etiqueta_id','ultimo_contato'];


    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class)->orderBy('data');
    }

    public function cotacao()
    {
        return $this->hasOne(Cotacao::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }


}
