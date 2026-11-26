<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensores';
    protected $primaryKey = 'id_sensores';

    protected $fillable = [
        'id_tanque',
        'temperatura_real',
        'temperatura_min_tanque',
        'temperatura_max_tanque',
        'ph_min',
        'ph_max',
        'ph_real',
        'manutencao',
        'datasensores_registrada',
        'temperatura_alerta_min',
        'temperatura_alerta_max',
        'temperatura_critica_min',
        'temperatura_critica_max',
    ];

    public function tanque()
    {
        return $this->belongsTo(Tanque::class, 'id_tanque', 'id_tanque');
    }

    public function statusTemperatura(): string
    {
        if ($this->temperatura_real === null) {
            return 'sem-leitura';
        }

        if (
            ($this->temperatura_critica_min !== null && $this->temperatura_real < $this->temperatura_critica_min)
            || ($this->temperatura_critica_max !== null && $this->temperatura_real > $this->temperatura_critica_max)
        ) {
            return 'critico';
        }

        if (
            $this->temperatura_real < $this->temperatura_min_tanque
            || $this->temperatura_real > $this->temperatura_max_tanque
        ) {
            return 'atencao';
        }

        return 'normal';
    }
}