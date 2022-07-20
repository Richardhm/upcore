<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissoesCorretorLancados extends Model
{
    use HasFactory;
    protected $table = "comissoes_corretor_lancados";
    protected $fillable = ["comissao_id","parcela","data","valor","status","user_id"];

    public function comissao()
    {
        return $this->belongsTo(Comissao::class);
    }


}
