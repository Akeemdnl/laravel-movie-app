<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['showtime_id','name','phone_no','quantity','total'];

    public function showtime() {
        return $this->belongsTo(Showtime::class,'showtime_id');
    }
}
