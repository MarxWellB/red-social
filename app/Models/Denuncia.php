<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_elemento',
        'id_elemento_denunciado',
        'correo_que_denuncia',
        'detalles',
        'motivacion',
        'estado'
    ];
}
