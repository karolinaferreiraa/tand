<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'name',
        'nome',
        'email',
        'password',
        'senha',
        'permissao',
    ];

    protected $hidden = [
        'password',
        'senha',
        'remember_token',
    ];

    public function getNameAttribute(): string
    {
        return $this->attributes['nome'] ?? '';
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['nome'] = $value;
    }

    public function getPasswordAttribute(): ?string
    {
        return $this->attributes['senha'] ?? null;
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['senha'] = Hash::make($value);
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'senha' => 'hashed',
        ];
    }

    public function tanques()
    {
        return $this->hasMany(Tanque::class, 'id_usuario', 'id_usuario');
    }
}