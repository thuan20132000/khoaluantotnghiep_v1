<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Job extends Model
{
    //

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function occupation(){
        return $this->belongsTo(Occupation::class);
    }



    public function candidates(){
        $candidates = DB::table('users')
                        ->join('job_collaborators','users.id','=','job_collaborators.user_id')
                        ->join('jobs','jobs.id','=','job_collaborators.job_id')
                        ->where('jobs.id','=',$this->id)
                        ->select(
                            'users.name','users.phonenumber','users.address','users.id','users.email',
                            'job_collaborators.expected_price',
                            'job_collaborators.description as job_collaborator_description',
                            'job_collaborators.id as job_collaborator_id',
                            'job_collaborators.status as job_collaborator_status',
                        )
                        ->get();
        return $candidates;
    }
}
