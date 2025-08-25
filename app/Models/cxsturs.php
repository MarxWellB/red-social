<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cxsturs extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'onlinestore_id',
        'enlace'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tienda()
    {
        return $this->belongsTo('App\Models\onlinestore');
    }
}
