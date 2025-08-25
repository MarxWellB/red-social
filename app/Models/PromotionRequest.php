<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionRequest extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'package', 'message'];

}
