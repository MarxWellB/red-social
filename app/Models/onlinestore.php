<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class onlinestore extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'logourl',
        'fdo'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'cxsturs', 'user_id', 'onlinestore_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
