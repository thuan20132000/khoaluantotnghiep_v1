<?php

namespace App;

use App\Model\Job;
use App\Model\Occupation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Role;
use Illuminate\Support\Facades\DB;

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

    static function getCollaborators(){
        $collaborators_all = DB::table('users')
        ->join('role_user','role_user.user_id','=','users.id')
        ->join('roles','role_user.role_id','=','roles.id')
        // ->join('occupation_user','occupation_user.user_id','=','users.id')
        // ->join('occupations','occupations.id','=','occupation_user.occupation_id')
        ->where('roles.name','=','isCollaborator')
        ->where('status','=',0)
        ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.idcard',
                'users.phonenumber',
                'users.address',
                'users.profile_image',
                'roles.name as role_name',
                // 'occupations.name as occupation_name'
            )
        ->get();

        return $collaborators_all;
    }

    public function getOccupationByUserId(){
         $collaborator_occupations = DB::table('users')
                                    ->join('occupation_user','occupation_user.id','=','users.id')
                                    ->join('occupations','occupations.id','occupation_user.occupation_id')
                                    ->where('users.id',$this->id)
                                    ->select('occupations')
                                    ->get();
        return $collaborator_occupations;

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
