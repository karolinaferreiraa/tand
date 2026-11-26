<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mortalidade extends Model
{
    protected $table = 'mortalidades';
    protected $primaryKey = 'id_mortalidade';

    protected $fillable = [
        'id_tanque',
        'quantidade',
        'observacao',
        'ocorrido_em',
    ];

    protected function casts(): array
    {
        return [
            'ocorrido_em' => 'date',
        ];
    }

    public function tanque(): BelongsTo
    {
        return $this->belongsTo(Tanque::class, 'id_tanque', 'id_tanque');
    }
}
