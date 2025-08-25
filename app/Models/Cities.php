<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_ciudad', 'country_id', 'level'];
    public function country()
    {
        
        return $this->belongsTo(Country::class);
    }
    

}
