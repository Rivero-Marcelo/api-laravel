<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, ApiTrait;

    protected $fillable = ['name', 'slug', 'extract', 'body', 'status', 'category_id', 'user_id'];

    protected $allowIncluded = ['user', 'category'];

    const BORRADOR = 1;
    const PUBLICADO = 2;

    // relacion uno a muchos inversa

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function category() {

       return $this->belongsTo(Category::class);
    }


    // relacion muchos a muchos

    public function tags() {

        return $this -> belongsToMany(Tag::class);
    }


    // relacion muchos a muchos polimorfica

    public function images() {

        return $this->morphMany(Image::class, 'imageable');

    }


}