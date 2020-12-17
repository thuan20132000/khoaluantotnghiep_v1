<?php

namespace App\Http\Controllers;

use App\Model\Job;
use App\Model\JobCollaborator;
use App\Model\Occupation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobCollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $job_collaborators = JobCollaborator::all();
        return view('admin.job_collaborator.index',[
            'job_collaborators'=>$job_collaborators
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $collaborators  = DB::table('users')
                    ->join('role_user',function($join){
                        $join->on('users.id','=','role_user.user_id')->where('role_user.role_id','=',2);
                    })
                    ->select('users.*')->get();
        $jobs = Job::all();

        // dd($collaborators);

        $occupations = Occupation::all();
        return view('admin.job_collaborator.create',[
            'collaborators'=>$collaborators,
            'jobs'=>$jobs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        dd($request->all());
        $validated = $request->validate([
            'price'=>'required',
            'user'=>'required',
            'job'=>'required',
        ],[
            'price'=>'Please enter expected price!',
            'user.required'=>'Please choose collaborator!',
            'job.required'=>'Please choose job!',
        ]);

        try {
            //code...
            $job_id = $request->job;
            $collaborator_id = $request->user;

            $check_duplicate = JobCollaborator::where('job_id',$job_id)
                                ->where('user_id',$collaborator_id)->count();
            if($check_duplicate > 0){
                return redirect()->back()->with('failed','Collaborator was exists in this job!');
            }


            $job_colaborator = new JobCollaborator();
            $job_colaborator->description = $request->description;
            $job_colaborator->user_id = $request->user;
            $job_colaborator->expected_price = $request->price;
            $job_colaborator->job_id = $request->job;
            $job_colaborator->status = $request->status;
            $job_colaborator->save();

            return redirect()->route('jobcollaborator.index')->with('success','Create Successfully');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('failed','Create failed!');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        // return view('admin.job.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $collaborators  = DB::table('users')
        ->join('role_user',function($join){
            $join->on('users.id','=','role_user.user_id')->where('role_user.role_id','=',2);
        })->select('users.*')->get();
        $jobs = Job::all();

        $job_colaborator = JobCollaborator::where('id',$id)->first();

        return view('admin.job_collaborator.edit',[
            'collaborators'=>$collaborators,
            'jobs'=>$jobs,
            'job_collaborator'=>$job_colaborator
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'price'=>'required',
        ],[
            'price'=>'Please enter expected price!',
        ]);

        try {
            //code...
            $job_id = $request->job;
            $collaborator_id = $request->user;

            // $check_duplicate = JobCollaborator::where('job_id',$job_id)
            //                     ->where('user_id',$collaborator_id)->count();
            // if($check_duplicate > 0){
            //     return redirect()->back()->with('failed','Collaborator was exists in this job!');
            // }


            $job_colaborator = JobCollaborator::where('id',$id)->first();
            $job_colaborator->description = $request->description;
            $job_colaborator->expected_price = $request->price;
            $job_colaborator->status = $request->status;
            $job_colaborator->update();

            return redirect()->back()->with('success','Updated Successfully');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('failed','Updated failed!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // dd($id);
        try {
            //code...

            $user = JobCollaborator::where('id',$id)->first();
            if($user->status <3){
                $user->delete();
                return redirect()->back()->with('success','Delete successfully');
            }
            return redirect()->back()->with('failed','Please Choose another Collaborator or remove collaborator confirm!');
            // dd($user);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('failed','Delete failed');

        }
    }


    /**
     * remove mass jobcollaborator
     */
    public function destroyMass(Request $request)
    {
        try {
            //code...
            $ids = $request->input('ids');
            if(count($ids) > 0 ){
                JobCollaborator::whereIn('id',$ids)->delete();

            }
            return response(['status'=>true,'data'=>$ids],200);

        } catch (\Throwable $th) {
            //throw $th;
            return response(['status'=>false],404);
        }
    }


    public function getAjaxCollaboratorByJob(Request $request,$job_id){

        // $job_id = $request->input('id');

        try {
            //code...
            $collaborators = DB::table('users')
            ->join('job_collaborators','users.id','=','job_collaborators.user_id')
            ->join('jobs','jobs.id','=','job_collaborators.job_id')
            ->where('jobs.id',$job_id)
            ->select('users.*','job_collaborators.expected_price')
            ->get();

            return response()->json([
            'data'=>$collaborators
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'data'=>$th
                ],404);
        }
    }

    public function addJobCollaborator(Request $request){
        try {
            //code...
            $validated = $request->validate([

                'user_id'=>'required',
                'job_id'=>'required',
            ],[
                'user.required'=>'Please choose collaborator!',
                'job.required'=>'Please choose job!',
            ]);

            try {
                //code...
                $job_id = $request->job_id;
                $collaborator_id = $request->user_id;

                $check_duplicate = JobCollaborator::where('job_id',$job_id)
                                    ->where('user_id',$collaborator_id)->count();
                if($check_duplicate > 0){
                    return redirect()->back()->with('failed','Collaborator was exists in this job!');
                }

                $check_full_candidates = JobCollaborator::checkIsFullCandidates($job_id);
                // dd($check_full_candidates);
                // dd($check_full_candidates);
                if($check_full_candidates){
                    return redirect()->back()->with('failed','Job was full candidates');
                }

                $job_colaborator = new JobCollaborator();
                $job_colaborator->description = $request->description;
                $job_colaborator->user_id = $collaborator_id;
                $job_colaborator->expected_price = $request->expected_price;
                $job_colaborator->job_id = $job_id;
                $job_colaborator->status = 2;
                $job_colaborator->save();

                return redirect()->back()->with('success','Added Collaborator Successfully');
            } catch (\Throwable $th) {
                throw $th;
                return redirect()->back()->with('failed','Added Collaborator failed!');

            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function updateJobCollaboratorStatus($job_collaborator_id,$status,Request $request)
    {
        try {
            //code...
            //dd($status,$job_collaborator_id);
            DB::beginTransaction();
            $current_job_collaborator = JobCollaborator::where('id',$job_collaborator_id)->first();
            $other_job_collaborator =  JobCollaborator::where('job_id',$current_job_collaborator->job_id)
                                        ->where('id','!=',$job_collaborator_id);
            $other_job_collaborator->update(['status'=>JobCollaborator::CANCEL]);


            $current_job_collaborator->status = $status;
            $current_job_collaborator->update();
        //    dd($other_job_collaborator);
            DB::commit();

            return redirect()->back();

        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }



    }

}
