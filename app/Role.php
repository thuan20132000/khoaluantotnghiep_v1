<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public $timestamps = false;

    const COLLABORATOR = 2;
    const ADMIN = 1;
    const CUSTOMER = 3;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
