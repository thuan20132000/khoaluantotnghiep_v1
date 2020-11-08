<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobConfirm extends Model
{
    //

    public function job()
    {
        $job = DB::table('job_confirms')
                ->join('job_collaborators','job_collaborators.id','=','job_confirms.job_collaborator_id')
                ->join('jobs','jobs.id','=','job_collaborators.job_id')
                ->join('users','users.id','=','jobs.user_id')
                ->where('job_confirms.id',$this->id)
                ->select('jobs.*','users.name as user_name')
                ->first();
        return $job;
    }

    static function isConfirmedJob($job_id)
    {
        $is_confirm = DB::table('job_confirms')
                    ->join('job_collaborators','job_collaborators.id','=','job_confirms.job_collaborator_id')
                    ->join('jobs','jobs.id','=','job_collaborators.job_id')
                    ->where('jobs.id',$job_id)
                    ->select('job_confirms.id as job_confirm_id')
                    ->first();
        return $is_confirm;
        if($is_confirm > 0){
            return true;
        }
        return false;
    }

    public function collaborator()
    {
        $collaborator = DB::table('job_confirms')
                        ->join('job_collaborators','job_collaborators.id','=','job_confirms.job_collaborator_id')
                        ->join('users','users.id','=','job_collaborators.user_id')
                        ->where('job_confirms.id',$this->id)
                        ->select('users.*')
                        ->first();
        return $collaborator;
    }

    // public function customer()
    // {
    //     $customer = DB::table('job_confirms')
    //                 ->join('job_coll')
    // }
}
