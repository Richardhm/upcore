<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiquetas extends Model
{
    use HasFactory;
    protected $table = "etiquetas";
    protected $fillable = ["nome","cor","padrao"];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
