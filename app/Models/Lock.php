<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    use HasFactory;
    protected $table = 'locks'; 
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'key',
    ];
}
