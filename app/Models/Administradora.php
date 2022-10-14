<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administradora extends Model
{
    use HasFactory;
    protected $table = "administradoras";
    protected $fillable = ["nome","logo","vitalicio","premiacao_corretora"];

    public function parcelas()
    {
        return $this->hasMany(ComissoesCorretoraConfiguracoes::class);
    }


    public function cidades()
    {
        return $this->belongsToMany(Cidade::class);
    }

    public function planos()
    {
        return $this->belongsToMany(Planos::class,'administradora_planos', 'administradora_id','plano_id');
    }

}
