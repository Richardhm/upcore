<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiacaoCorretoraLancadas extends Model
{
    use HasFactory;
    protected $table = "premiacao_corretora_lancadas";

    public function comissao()
    {
        return $this->belongsTo(Comissao::class);
    }


}
