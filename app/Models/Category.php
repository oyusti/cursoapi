<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];
    protected $allowIncluded = ['posts', 'posts.user']; //Relaciones que se pueden incluir
    protected $allowFilter = ['name', 'slug']; //Campos por los que se puede filtrar
    protected $allowSort = ['id', 'name', 'slug']; //Campos por los que se puede ordenar

    public function scopeIncluded(Builder $query){

        if(empty($this->allowIncluded) || empty(request('included'))){
            return;
        }
        $relations = explode(',', request('included')); // [posts, relation2]
        $allowIncluded = collect($this->allowIncluded);
    
        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }
	    $query->with($relations);
        //return $query;
    }

    public function scopeFilter(Builder $query){
        if(empty($this->allowFilter) || empty(request('filter'))){
            return;
        }
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
        }
    }

    public function scopeSort(Builder $query){
        if(empty($this->allowSort) || empty(request('sort'))){
            return;
        }
        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';
            if (Str::of($sortField)->startsWith('-')) {
                $direction = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    public function scopeGetorPaginate(Builder $query){
        if (request('perPage')) {
            $perPage = intval(request('perPage'));
            if($perPage){
                return $query->paginate($perPage);
            } 
        }
        return $query->get();
    }

    //Relacion uno a muchos
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
