<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSelection extends Model
{
    protected $fillable = [
        'choice', 'reservation_id', 

    ];
}
