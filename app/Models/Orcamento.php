<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $table = 'orcamentos';
    protected $fillable = ['cliente_id','administradora_id','user_id','corretora_id','pessoa_fisica','pessoa_juridica','coparticipacao','odonto','contato_whatsapp','contato_email'];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class);
    }

    public function administradora()
    {
        return $this->belongsTo(Administradora::class);
    }

    public function faixas()
    {
        return $this->belongsToMany(FaixaEtaria::class,"orcamento_faixa_etarias")->withPivot("quantidade");
    }

    public function total($faixas)
    {
        $total = 0;
        foreach($faixas as $f) {
            $total +=  $f->pivot->quantidade;
        }
        return $total;
    }



    public function setContatoWhatsappAttribute($value)
    {
        $this->attributes['contato_whatsapp'] = ($value == "on" ? 1 : 0);
    }

    public function setContatoEmailAttribute($value)
    {
        $this->attributes['contato_email'] = ($value == "on" ? 1 : 0);
    }

        

    public function setCoparticipacaoAttribute($value)
    {
        $this->attributes['coparticipacao'] = ($value == "sim" ? 1 : 0);
    }

    public function setOdontoAttribute($value)
    {
        $this->attributes['odonto'] = ($value == "sim" ? 1 : 0);
    }



}
