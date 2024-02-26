<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Post extends Model
{
    use HasFactory, ApiTrait;
    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable = ['name', 'slug', 'extract', 'body', 'status', 'category_id', 'user_id'];

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
