<?php

namespace App\Http\Controllers;

use App\Model\Job;
use App\Model\JobCollaborator;
use App\User;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    //

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $colaborator_total = User::getCollaborators()->toArray();
        $customer_total = User::getCustomer()->toArray();
        $jobs_total = Job::all()
        ->groupBy('occupation_id');
        // $a = JobCollection::collection($jobs_total);

        $job_collaborators = JobCollaborator::where('status',JobCollaborator::CONFIRMED)
        ->get();

        $profit_sum_of_collaborator = 0;
        $success_job_collaborator_number = count($job_collaborators);
        foreach ($job_collaborators as $value) {
            # code...
            $profit_sum_of_collaborator = $profit_sum_of_collaborator + $value->confirmed_price;
        }




        $collaborators = User::hydrate($colaborator_total);
        $customers = User::hydrate($customer_total);

        return view('admin.index',[
            'jobs_total'=>$jobs_total,
            'customers'=>$customers,
            'collaborator_total'=>$collaborators,
            'profit_sum_of_collaborators'=>$profit_sum_of_collaborator,
            'success_job_collaborator_number'=>$success_job_collaborator_number
        ]);
    }
}
