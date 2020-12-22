<?php

namespace App;

use App\Model\Image;
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
    use Notifiable, HasApiTokens;
    const PUBLISH  = 0;
    const DRAFT = 1;
    const PENDING = 2;

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


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    static function getCollaborators()
    {
        $collaborators_all = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            // ->join('occupation_user','occupation_user.user_id','=','users.id')
            // ->join('occupations','occupations.id','=','occupation_user.occupation_id')
            ->where('roles.name', '=', 'isCollaborator')
            ->where('status', '=', User::PUBLISH)
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

    static function getCustomer()
    {
        $collaborators_all = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            // ->join('occupation_user','occupation_user.user_id','=','users.id')
            // ->join('occupations','occupations.id','=','occupation_user.occupation_id')
            ->where('roles.name', '=', 'isCustomer')
            ->where('status', '=', User::PUBLISH)
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

    static function getCollaboratorsOrderBy($by,$order,$skip=0,$perpage=10)
    {
        if($by == null || $by == ""){
            $by = "id";
        }
        if($order == null || $order == ""){
            $order = "desc";
        }

        $collaborators_all = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->join('job_collaborators','job_collaborators.user_id','=','users.id')
            ->where('roles.id', '=',Role::COLLABORATOR )
            ->where('users.status', '=', User::PUBLISH)
            ->orderBy($by,$order)
            ->distinct()
            ->skip($skip)
            ->take($perpage)
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


    public function getOccupationByUserId()
    {
        $collaborator_occupations = DB::table('users')
            ->join('occupation_user', 'occupation_user.user_id', '=', 'users.id')
            ->join('occupations', 'occupations.id', '=', 'occupation_user.occupation_id')
            ->where('users.id', $this->id)
            ->select('occupations.id', 'occupations.name', 'occupations.slug', 'occupations.status', 'occupations.image')
            ->get();
        return $collaborator_occupations;
    }

    public function hasAnyRoles($role)
    {
        if ($this->roles()->whereIn('name', $role)->first()) {
            return true;
        }
        return false;
    }


    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function jobCollaborators()
    {
        return $this->hasMany(JobCollaborator::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function getReviews()
    {
        $reviews = DB::table('job_collaborators')
            ->join('jobs','jobs.id','=','job_collaborators.job_id')
            ->join('users','users.id','=','jobs.user_id')
            ->where('job_collaborators.user_id',$this->id)
            ->where('job_collaborators.status',JobCollaborator::CONFIRMED)
            ->select(
                'users.name as author_name',
                'users.profile_image as author_image',
                'users.email as author_email',
                'job_collaborators.*',
                'jobs.name as job_name',
            )
            ->get();
        return $reviews;
    }
}
