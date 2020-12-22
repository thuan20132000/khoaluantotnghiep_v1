<?php

namespace App\Model;

use App\User;
use App\Model\JobCollaborator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Job extends Model
{
    //
    const CONFIRMED = 4;
    const DRAFT = 1;
    const PENDING = 2;
    const APPROVED = 3;

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function jobCollaborators()
    {
        return $this->hasMany(JobCollaborator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }



    public function candidates()
    {
        $candidates = DB::table('users')
            ->join('job_collaborators', 'users.id', '=', 'job_collaborators.user_id')
            ->join('jobs', 'jobs.id', '=', 'job_collaborators.job_id')
            ->where('jobs.id', '=', $this->id)
            ->select(
                'users.name',
                'users.phonenumber',
                'users.address',
                'users.id',
                'users.profile_image',
                'users.email',
                'job_collaborators.expected_price',
                'job_collaborators.description as job_collaborator_description',
                'job_collaborators.id as job_collaborator_id',
                'job_collaborators.status as job_collaborator_status',
            )
            ->get();
        return $candidates;
    }



    static function getJobsApproved($user_id)
    {
        $job_approved = DB::table('users')
            ->join('jobs', 'jobs.user_id', '=', 'users.id')
            ->join('job_collaborators', 'job_collaborators.job_id', '=', 'jobs.id')
            ->where('jobs.user_id', $user_id)
            ->where('job_collaborators.status', JobCollaborator::APPROVED)
            ->select(
                'job_collaborators.user_id as collaborator_id',
                'users.name',
                'users.phonenumber',
                'users.email',
                'job_collaborators.id as job_collaborator_id',
                'job_collaborators.expected_price',
                'job_collaborators.status as job_collaborator_status',
                'jobs.id as job_id',
                'jobs.name as job_name',
                'jobs.suggestion_price',
                'jobs.user_id as author_id',
                'job_collaborators.updated_at',
                'job_collaborators.created_at'

            )
            ->get();
        return $job_approved;
    }




}
