<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function occupation(){
        return $this->belongsTo(Occupation::class);
    }
}
