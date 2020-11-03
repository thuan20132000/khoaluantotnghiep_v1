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
        // dd($request->all());
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


            $job_colaborator = JobCollaborator::find($id)->first();
            $job_colaborator->description = $request->description;
            $job_colaborator->user_id = $request->user;
            $job_colaborator->expected_price = $request->price;
            $job_colaborator->job_id = $request->job;
            $job_colaborator->status = $request->status;
            $job_colaborator->update();

            return redirect()->route('jobcollaborator.index')->with('success','Updated Successfully');
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
        try {
            //code...

            $user = JobCollaborator::find($id)->first();
            // dd($user);
            $user->delete();
            return redirect()->back()->with('success','Delete successfully');
        } catch (\Throwable $th) {
            throw $th;
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

}
