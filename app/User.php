<?php

namespace App;

use App\Model\Job;
use App\Model\Occupation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function occupations()
    {
        return $this->belongsToMany(Occupation::class);
    }


    public function roles(){
        return $this->belongsToMany(Role::class);
    }


    public function hasAnyRoles($role){
        if($this->roles()->whereIn('name',$role)->first()){
            return true;
        }
        return false;
    }


    public function hasRole($role){
        if($this->roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

}
