<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    //

    public function jobConfirm()
    {
        return $this->belongsTo(JobConfirm::class);
    }
}
