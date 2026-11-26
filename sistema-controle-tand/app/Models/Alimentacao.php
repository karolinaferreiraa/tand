<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alimentacao extends Model
{
    protected $table = 'alimentacoes';
    protected $primaryKey = 'id_alimentacao';

    protected $fillable = [
        'id_tanque',
        'quantidade_kg',
        'tipo_racao',
        'registrado_em',
    ];

    protected function casts(): array
    {
        return [
            'quantidade_kg' => 'decimal:2',
            'registrado_em' => 'datetime',
        ];
    }

    public function tanque(): BelongsTo
    {
        return $this->belongsTo(Tanque::class, 'id_tanque', 'id_tanque');
    }
}
