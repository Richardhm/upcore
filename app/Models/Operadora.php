<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operadora extends Model
{
    use HasFactory;
    protected $fillable = ["nome","logo"];

    public function corretoras()
    {
        return $this->belongsToMany(CorretoraOperadora::class);
    }
    
}
