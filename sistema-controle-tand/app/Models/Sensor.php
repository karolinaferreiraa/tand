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
    ];

    public function tanque()
    {
        return $this->belongsTo(Tanque::class, 'id_tanque', 'id_tanque');
    }
}