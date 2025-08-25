<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPromocion extends Model
{
    use HasFactory;
    protected $table = 'listapromociones';
    protected $fillable = [
        'cost', 'time', 'name','active','max', 'actives'
    ];

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'id_type');
    }
}
