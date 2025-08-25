<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CacheUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'profile_image_path', 'biography_image_path'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
