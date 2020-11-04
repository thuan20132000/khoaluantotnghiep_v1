<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }


    public function collaborators()
    {
        $occupation_collaborators = DB::table('users')
                                    ->join('occupation_user','occupation_user.user_id','=','users.id')
                                    ->join('occupations','occupations.id','=','occupation_user.occupation_id')
                                    ->where('occupations.id','=',$this->id)
                                    ->select('users.*')->get();
        return $occupation_collaborators;
    }
}
