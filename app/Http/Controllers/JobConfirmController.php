<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobConfirmController extends Controller
{
    //
    public function index()
    {
        return view('admin.job_confirmed.index');
    }
}
