<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id', 'user_id', 'name', 'age', 'sex', 'breed', 'image', 'note',
    ];



    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }
}
