<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    use HasFactory;
    protected $table = "cotacoes";
    protected $fillable = ["cliente_id","cidade_id","operadora_id","administradora_id","acomodacao_id","financeiro_id","plano_id","user_id","corretora_id","codigo_externo","valor"];

    public function financeiro()
    {
        return $this->belongsTo(Financeiro::class,'financeiro_id','id');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }


    public function clientes()
    {
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }

    public function administradora()
    {
        return $this->belongsTo(Administradora::class);
    }

    public function acomodacao()
    {
        return $this->belongsTo(Acomodacao::class);
    }

    public function plano()
    {
        return $this->belongsTo(Planos::class);
    }

    public function cotacaoFaixaEtaria()
    {
        return $this->hasMany(CotacaoFaixaEtaria::class);
    }

    public function somarCotacaoFaixaEtaria()
    {
        return $this->hasMany(CotacaoFaixaEtaria::class)
            ->selectRaw("cotacao_faixa_etarias.cotacao_id,sum(cotacao_faixa_etarias.quantidade) as soma")
            ->groupBy("cotacao_faixa_etarias.cotacao_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comissao()
    {
        return $this->hasOne(Comissao::class);
    }

}
