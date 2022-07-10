<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabela extends Model
{
    use HasFactory;
    protected $table = "tabelas";
    protected $fillable = ["operadora_id","administradora_id","corretora_id","cidade_id","modelo","plano","coparticipacao","odonto","faixa_etaria","valor"];

    public function colaborador()
    {
        return $this->belongsTo(User::class,"colaborador_id","id");
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class,"tipo_id","id");
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class,"grupo_id","id");
    }



}