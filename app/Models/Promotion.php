<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'promotions';
    protected $fillable = [
        'IdUsr', 'include', 'idDiscount', 'id_type', 'paymentDay', 'name', 'method', 'email', 'startday', 'active', 'endDay','nowpay','status', 'last_updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsr');
    }

    public function listaPromocion()
    {
        return $this->belongsTo(ListaPromocion::class, 'id_type');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'idDiscount');
    }
}
