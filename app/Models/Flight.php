<?php

namespace App\Models;

use App\Http\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
     use HasFactory, UUID;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'from',
       'to',
       'departure_time',
       'arrival_time',
       'price',
   ];

   /**
     * Define the relationship with the Task model
     *
     * @return \App\Models\Booking  $booking
     */
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
