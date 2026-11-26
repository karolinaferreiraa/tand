<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanque extends Model
{
    use HasFactory;

    protected $table = 'tanques';
    protected $primaryKey = 'id_tanque';

    protected $fillable = [
        'status',
        'id_usuario',
        'tipo',
        'datatanque_registrada',
        'nome',
        'dimensoes',
        'quantidade_alevinos',
        'especie',
        'volume_estimado',
    ];

    protected function casts(): array
    {
        return [
            'datatanque_registrada' => 'date',
            'volume_estimado' => 'decimal:2',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function sensores()
    {
        return $this->hasMany(Sensor::class, 'id_tanque', 'id_tanque');
    }

    public function peixes()
    {
        return $this->hasMany(Peixe::class, 'id_tanque', 'id_tanque');
    }

    public function alimentacoes()
    {
        return $this->hasMany(Alimentacao::class, 'id_tanque', 'id_tanque');
    }

    public function mortalidades()
    {
        return $this->hasMany(Mortalidade::class, 'id_tanque', 'id_tanque');
    }
}