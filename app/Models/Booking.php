<?php

namespace App\Models;

use App\Http\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, UUID;

     /**
        * The attributes that are mass assignable.
        *
        * @var array<int, string>
        */
    protected $fillable = [
        'user_id',
        'flight_id',
        'status',
    ];

    /**
     * Define the relationship with the Project model
     *
     * @return \App\Models\Flight  $flight
     */
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    /**
     * Define the relationship with the User model
     *
     * @return \App\Models\User  $user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
