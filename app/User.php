<?php

namespace App;

use App\Model\Job;
use App\Model\JobCollaborator;
use App\Model\Occupation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;

use App\Role;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

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
            )
        ->get();

        return $collaborators_all;
    }


    /**
     * author:thuantruong
     * created_at:3/12/2020
     * description: get all review of a collaborator
     */
    static function collaboratorReviews($user_id)
    {
        // return $user_id;
        $collaborator_reviews = DB::table('users')
        ->join('job_collaborators','job_collaborators.user_id','=','users.id')
        ->join('job_confirms','job_confirms.job_collaborator_id','=','job_collaborators.id')
        ->join('evaluates','evaluates.job_confirm_id','=','job_confirms.id')
        ->where('users.id','=',$user_id)
        ->select('evaluates.*')
        ->get();

        return $collaborator_reviews;
        return 1;
    }


    public function getOccupationByUserId(){
         $collaborator_occupations = DB::table('users')
                                    ->join('occupation_user','occupation_user.user_id','=','users.id')
                                    ->join('occupations','occupations.id','=','occupation_user.occupation_id')
                                    ->where('users.id',$this->id)
                                    ->select('occupations.id','occupations.name','occupations.slug','occupations.status','occupations.image')
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
