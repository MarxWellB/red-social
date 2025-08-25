<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'percent', 'active'
    ];

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'idDiscount');
    }
}
