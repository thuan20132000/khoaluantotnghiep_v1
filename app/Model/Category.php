<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name','slug','status'];

    public function occupations()
    {
        return $this->hasMany(Occupation::class);
    }

    public function jobs()
    {
        return $this->hasManyThrough(Job::class, Occupation::class);
    }

}
