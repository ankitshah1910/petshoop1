<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'client_id', 'user_id', 'pet_id', 'appointment_time', 'description',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function pet()
    {
        return $this->belongsTo('App\Pet');
    }
}
