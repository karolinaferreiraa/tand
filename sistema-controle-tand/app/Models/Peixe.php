<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peixe extends Model
{
    use HasFactory;

    protected $table = 'peixes';
    protected $primaryKey = 'id_peixe';

    protected $fillable = [
        'temperatura_ideal_min',
        'temperatura_ideal_max',
        'id_tanque',
        'mortalidade_media',
        'qtde_mortos',
        'datapeixe_registrada',
        'alimentacao_media',
        'alimentacao_no_dia',
    ];

    public function tanque()
    {
        return $this->belongsTo(Tanque::class, 'id_tanque', 'id_tanque');
    }
}