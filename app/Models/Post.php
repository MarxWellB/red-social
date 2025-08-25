<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable=[
        'titulo',
        'url',
        'user_id',
        'onlinestore_id',
        'flushe',
        'related'
    ];
    public function user(){
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
    public function onlinestore()
    {
        return $this->belongsTo(onlinestore::class);
    }

    public function volcado()
    {
        return $this->hasMany(Volcado::class, 'elemento');
    }






}
