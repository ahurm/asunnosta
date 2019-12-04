<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    public function user() {
        
        //One to Many relationship with User model
        //Using id as user_id "foreign key"
        return $this->belongsTo('App\User');
    }
}
