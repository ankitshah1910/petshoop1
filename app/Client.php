<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function pets()
    {
        return $this->hasMany('App\Pet');
    }
    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }

}
