<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateJobRequest;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Model\Job;
use App\Model\Location;
use Illuminate\Support\Facades\Validator;
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
    public function index(Request $request)
    {
        //
        $per_page = 15;
        if($request->input('per_page')){
            $per_page = $request->input('per_page');
        }
        return  JobCollection::collection(Job::paginate($per_page));
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

        try {
            //code...

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name'=>'required|string',
                'province'=>'required',
                'district'=>'required',
                'subdistrict'=>'required',
                'street'=>'required',
                'suggestion_price'=>'required',
                'author'=>'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=>$validator->errors()
                ]);
            }

            $location = new Location();
            $location->province= $request->province;
            $location->district = $request->district;
            $location->subdistrict = $request->subdistrict;
            $location->street = $request->street;
            $location->save();

            $job = new Job();
            $job->name = $request->name;
            $job->slug = Str::slug($request->name,'-');
            $job->description = $request->description;
            $job->status = 3;
            $job->suggestion_price = $request->suggestion_price;
            $job->location_id = $location->id;
            $job->occupation_id = $request->occupation_id;
            $job->user_id = $request->author;
            $job->save();
            DB::commit();

            return new JobResource($job);


        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'status'=>204,
                'message'=>$th
            ]);
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
        return new JobResource(Job::find($id));
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
        try {
            //code...

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name'=>'required|string',
                'province'=>'required',
                'district'=>'required',
                'subdistrict'=>'required',
                'street'=>'required',
                'suggestion_price'=>'required',
                'author'=>'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=>$validator->errors()
                ]);
            }

            // $location->province= $request->province;
            // $location->district = $request->district;
            // $location->subdistrict = $request->subdistrict;
            // $location->street = $request->street;
            // $location->save();

            $job = Job::where('id',$id)->first();

            $job->name = $request->name;
            $job->slug = Str::slug($request->name,'-');
            $job->description = $request->description;
            $job->status = 3;
            $job->suggestion_price = $request->suggestion_price;
            $job->occupation_id = $request->occupation_id;
            $job->user_id = $request->author;
            $job->update();

            $location = Location::where('id',$job->location_id)->first();
            $location->province= $request->province;
            $location->district = $request->district;
            $location->subdistrict = $request->subdistrict;
            $location->street = $request->street;
            $location->update();

            DB::commit();

            return new JobResource($job);


        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'status'=>204,
                'message'=>$th
            ]);
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
            $job = Job::where('id',$id)->first();
            Location::where('id',$job->location_id)->delete();
            $job->delete();

            return response()->json([
                'status'=>204,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=>404,
                'message'=>$th
            ]);
        }

    }
}
