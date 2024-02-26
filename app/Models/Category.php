<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, ApiTrait;

    protected $fillable = ['name', 'slug'];
    protected $allowIncluded = ['posts', 'posts.user']; //Relaciones que se pueden incluir
    protected $allowFilter = ['name', 'slug']; //Campos por los que se puede filtrar
    protected $allowSort = ['id', 'name', 'slug']; //Campos por los que se puede ordenar

    //Relacion uno a muchos
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
