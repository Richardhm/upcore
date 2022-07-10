<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\UserACLTrait;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,UserACLTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'corretora_id',
        'name',
        'email',
        'cpf',
        'endereco',
        'cidade',
        'estado',
        'celular',
        'numero',
        'image',
        'password',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function corretora()
    {
        return $this->belongsTo(Corretora::class);
    }

    public function permissions()
    {
        return $this->hasMany(PermissionUser::class,"user_id","id");
    }

    public function permissionsUser()
    {
        return $this->belongsToMany(PermissionUser::class,"permission_user","user_id","permission_id");
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }

}
