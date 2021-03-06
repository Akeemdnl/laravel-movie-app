<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image', 'price'];


    public function showtime() {
        return $this->hasMany(Showtime::class, 'movie_id');
    }
}
