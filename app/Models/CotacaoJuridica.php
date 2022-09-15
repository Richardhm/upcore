<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotacaoJuridica extends Model
{
    use HasFactory;
    protected $table = "cotacao_juridicas";
    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }    


}
