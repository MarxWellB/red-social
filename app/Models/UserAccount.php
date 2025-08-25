<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'onlinestore_id',
        'profile_link',
        'status'
    ];
    public function onlineStore()
    {
        return $this->belongsTo(OnlineStore::class, 'onlinestore_id');
    }
}
