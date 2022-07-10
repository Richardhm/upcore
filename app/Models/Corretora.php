<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Corretora extends Model
{
    use HasFactory;
    protected $fillable = ["nome","email","numero","cidade","estado","cep","telefone","celular"];
    protected $table = "corretoras";
    public function scopeCorretoraUser(Builder $query)
	{
		return $query->where('user_id',auth()->user()->id);
	}

    public function user()
    {
        return $this->belongsTo(Corretora::class);
    }

    public function operadoras()
    {
        return $this->belongsToMany(CorretoraOperadora::class);
    }



}
