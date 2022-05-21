<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id','date','time'];

    public function movie() {
        return $this->belongsTo(Movie::class,'movie_id');
    }

    public function booking() {
        return $this->hasMany(Booking::class, 'showtime_id');
    }
}
