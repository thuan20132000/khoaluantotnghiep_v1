<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Job;
use App\Model\Occupation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jobs = Job::all();
        return view('admin.job.index',[
            'jobs'=>$jobs
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
        $occupations = Occupation::all();
        // $users = User::all();

        $customers  = DB::table('users')
                    ->join('role_user',function($join){
                        $join->on('users.id','=','role_user.user_id')->where('role_user.role_id','=',3);
                    })
                    ->select('users.*')->get();


        return view('admin.job.create',[
            'occupations'=>$occupations,
            'customers'=>$customers
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
        // dd($request->filepaths);
        $validated = $request->validate([
            'name'=>'required',
            'description'=>'required',
            'slug'=>'required',
            'province'=>'required',
            'district'=>'required',
            'subdistrict'=>'required',
            'street'=>'required',
            'user'=>'required',
            'price'=>'required|numeric'
        ],[
            'name.required'=>'Please enter title!',
            'description.required'=>'Please enter description!',
            'slug.required'=>'Please enter slug',
            'province.required'=>'Please choose province',
            'district.required'=>'Please choose district',
            'subdistrict.required'=>'Please choose subdistrict',
            'street.required'=>'Please enter street',
            'user.required'=>'Please choose customer!',
            'price.required'=>'Please enter suggestion price!'

        ]);
        try {
            //code...
            DB::beginTransaction();
            $location_id = DB::table('location')->insertGetId(
                array(
                    'province'=>$request->province,
                    'district'=>$request->district,
                    'subdistrict'=>$request->subdistrict,
                    'address'=>$request->address,
                    'street'=>$request->street
                )
            );



            $job = new Job();
            $job->name = $request->name;
            $job->slug = $request->slug;
            $job->description = $request->description;
            $job->location_id = $location_id;
            $job->user_id = $request->user;
            $job->occupation_id = $request->occupation;
            $job->suggestion_price = $request->price;
            $job->status = $request->status;
            $job->save();


            $images_thumbnail_array = Str::of($request->filepaths)->explode(',');
            if($images_thumbnail_array && count($images_thumbnail_array) > 1){
                foreach ($images_thumbnail_array as $key => $value) {
                    # code...
                    if($value){
                        DB::table('images')->insert(
                            ['image_url'=>$value,'job_id'=>$job->id]
                        );
                    }
                }
            }

            // dd($job);
            DB::commit();
            return redirect()->route('job.index')->with('success','Create Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
        $occupations = Occupation::all();
        // $users = User::all();

        $customers  = DB::table('users')
                    ->join('role_user',function($join){
                        $join->on('users.id','=','role_user.user_id')->where('role_user.role_id','=',3);
                    })
                    ->select('users.*')->get();
        $job_images = DB::table('images')->where('job_id',$job->id)->get();
        $job_images_array = $job_images->pluck('image_url')->toArray();
        return view('admin.job.edit',[
            'job'=>$job,
            'occupations'=>$occupations,
            'customers'=>$customers,
            'job_images_array'=>$job_images_array
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //
        // dd($request->all());
        // dd($request->filepaths);
        $validated = $request->validate([
            'name'=>'required',
            'description'=>'required',
            'slug'=>'required',
            'province'=>'required',
            'district'=>'required',
            'subdistrict'=>'required',
            'street'=>'required',
            'user'=>'required',
            'price'=>'required|numeric'
        ],[
            'name.required'=>'Please enter title!',
            'description.required'=>'Please enter description!',
            'slug.required'=>'Please enter slug',
            'province.required'=>'Please choose province',
            'district.required'=>'Please choose district',
            'subdistrict.required'=>'Please choose subdistrict',
            'street.required'=>'Please enter street',
            'user.required'=>'Please choose customer!',
            'price.required'=>'Please enter suggestion price!'

        ]);
        try {
            //code...
            DB::beginTransaction();
            $location_id = DB::table('location')->insertGetId(
                array(
                    'province'=>$request->province,
                    'district'=>$request->district,
                    'subdistrict'=>$request->subdistrict,
                    'street'=>$request->street,
                    'address'=>$request->address,
                )
            );

            $job->name = $request->name;
            $job->slug = $request->slug;
            $job->description = $request->description;
            $job->location_id = $location_id;
            $job->user_id = $request->user;
            $job->occupation_id = $request->occupation;
            $job->suggestion_price = $request->price;
            $job->status = $request->status;
            $job->save();


            $images_thumbnail_array = Str::of($request->filepaths)->explode(',');
            if($images_thumbnail_array && count($images_thumbnail_array) > 1){
                foreach ($images_thumbnail_array as $key => $value) {
                    # code...
                    if($value){
                        DB::table('images')->insert(
                            ['image_url'=>$value,'job_id'=>$job->id]
                        );
                    }
                }
            }

            // dd($job);
            DB::commit();
            return redirect()->route('job.index')->with('success','Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;

            return redirect()->back()->with('failed','Updated Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
        try {
            //code...

            $job->delete();
            return redirect()->back()->with('success','Delete successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * remove mass User
     */
    public function destroyMass(Request $request)
    {
        try {
            //code...
            $ids = $request->input('ids');
            if(count($ids) > 0 ){
                Job::whereIn('id',$ids)->delete();

            }
            return response(['status'=>true,'data'=>$ids],200);

        } catch (\Throwable $th) {
            //throw $th;
            return response(['status'=>false],404);
        }
    }
}
