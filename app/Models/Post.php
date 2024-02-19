<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    const BORRADOR = 1;
    const PUBLICADO = 2;

    //Relacion uno a muchos inversa con users
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relacion uno a muchos inversa con categorias
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Relacion muchos a muchos con tags
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    //Relacion uno a muchos polimorfica con Images
    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }
}
