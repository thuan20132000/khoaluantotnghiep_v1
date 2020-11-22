<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobCollaborator extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function author()
    {
        $author = DB::table('job_collaborators')
                ->join('jobs','job_collaborators.job_id','=','jobs.id')
                ->join('users','users.id','=','jobs.user_id')
                ->where('job_collaborators.id',$this->id)
                ->select('users.id','users.name','users.email','users.phonenumber')
                ->first();
        return $author;
    }

    public function collaborators()
    {
        $collaborators = DB::table('job_collaborators')
                        ->join('jobs','job_collaborators.job_id','=','jobs.id')
                        ->join('users','job_collaborators.user_id','=','users.id')
                        ->where('users.id',$this->user_id)
                        ->select('users.id','users.name','users.phonenumber','users.idcard','users.profile_image','users.address')
                        ->first();
        return $collaborators;
    }
}
