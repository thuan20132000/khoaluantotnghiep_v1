<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobConfirm extends Model
{
    //

    const DRAFT = 1;
    const PENDING = 2;
    const PUBLISHED = 3;

    public function job()
    {
        $job = DB::table('job_confirms')
            ->join('job_collaborators', 'job_collaborators.id', '=', 'job_confirms.job_collaborator_id')
            ->join('jobs', 'jobs.id', '=', 'job_collaborators.job_id')
            ->join('users', 'users.id', '=', 'jobs.user_id')
            ->where('job_confirms.id', $this->id)
            ->select('jobs.*', 'users.name as user_name')
            ->first();
        return $job;
    }

    static function isConfirmedJob($job_id)
    {
        $is_confirm = DB::table('job_confirms')
            ->join('job_collaborators', 'job_collaborators.id', '=', 'job_confirms.job_collaborator_id')
            ->join('jobs', 'jobs.id', '=', 'job_collaborators.job_id')
            ->where('jobs.id', $job_id)
            ->select('job_confirms.id as job_confirm_id')
            ->first();
        return $is_confirm;

        if ($is_confirm > 0) {
            return true;
        }
        return false;
    }

    public function collaborator()
    {
        $collaborator = DB::table('job_confirms')
            ->join('job_collaborators', 'job_collaborators.id', '=', 'job_confirms.job_collaborator_id')
            ->join('users', 'users.id', '=', 'job_collaborators.user_id')
            ->where('job_confirms.id', $this->id)
            ->select('users.*')
            ->first();
        return $collaborator;
    }


    static function checkIsConfirmed($job_collaborator_id)
    {
        $confirmed = JobConfirm::where('job_collaborator_id',$job_collaborator_id)->first();
        if($confirmed){
            return true;
        }else{
            return false;
        }
    }

    // public function customer()
    // {
    //     $customer = DB::table('job_confirms')
    //                 ->join('job_coll')
    // }


    static function getUserConfirmedJob($user_id)
    {
        $job_confirmed = DB::table('users')
            ->join('jobs', 'jobs.user_id', '=', 'users.id')
            ->join('job_collaborators', 'job_collaborators.job_id', '=', 'jobs.id')
            ->join('job_confirms','job_confirms.job_collaborator_id','=','job_collaborators.id')
            ->where('jobs.user_id', $user_id)
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
                'job_collaborators.created_at',
                'job_confirms.confirmed_price'

            )
            ->get();
        return $job_confirmed;
    }



    public function evaluates()
    {
        return $this->hasMany(Evaluate::class);
    }
}
