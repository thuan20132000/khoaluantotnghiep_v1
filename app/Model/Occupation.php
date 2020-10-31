<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    //

    protected $fillable = ['name','slug','status','category_id'];

    public function category()
    {
        return $this->belongsTo('App\Model\Category', 'category_id', 'id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
