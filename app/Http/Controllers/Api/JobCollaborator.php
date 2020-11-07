<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobCollaboratorCollection;
use App\Http\Resources\JobCollaboratorResource;
use App\Model\JobCollaborator as ModelJobCollaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobCollaborator extends Controller
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
            $per_page = (int)$request->input('per_page');
        }
        return JobCollaboratorCollection::collection(ModelJobCollaborator::paginate($per_page));
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
            DB::beginTransaction();

            $validator = Validator::make($request->all(),[
                'expected_price'=>'required',
                'description'=>'required',
                'job_id'=>'required',
                'user_id'=>'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>$validator->errors()
                ]);
            }

            //code...
            $job_id  = $request->job_id;
            $collaborator_id = $request->user_id;

            $check_duplicate = ModelJobCollaborator::where('job_id',$job_id)
            ->where('user_id',$collaborator_id)->count();

            if($check_duplicate > 0){
                return response()->json([
                    'status'=>false,
                    'message'=>'Collaborator was exists!!!'
                ]);
            }

            $job_collaborator = new ModelJobCollaborator();
            $job_collaborator->expected_price = $request->expected_price;
            $job_collaborator->description = $request->description;
            $job_collaborator->start_at = $request->start_at;
            $job_collaborator->finish_at = $request->finish_at;
            $job_collaborator->user_id = $request->user_id;
            $job_collaborator->job_id = $request->job_id;
            $job_collaborator->status = 0;
            $job_collaborator->save();

            DB::commit();

            return new JobCollaboratorResource($job_collaborator);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
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
        $job_collaborator = ModelJobCollaborator::where('id',$id)->first();
        if($job_collaborator){
            return new JobCollaboratorResource($job_collaborator);
        }else{
            return response()->json([
                "data"=>null,
                "message"=>"not found any item."
            ]);
        }
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
            DB::beginTransaction();

            $validator = Validator::make($request->all(),[
                'expected_price'=>'required',
                'description'=>'required',

            ]);

            if($validator->fails()){
                return response()->json([
                    'status'=>$validator->errors()
                ]);
            }

            //code...

            $job_collaborator = ModelJobCollaborator::where('id',$id)->first();
            $job_collaborator->expected_price = $request->expected_price;
            $job_collaborator->description = $request->description;
            $job_collaborator->start_at = $request->start_at;
            $job_collaborator->finish_at = $request->finish_at;
            $job_collaborator->update();

            DB::commit();

            return new JobCollaboratorResource($job_collaborator);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
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
            $job_collaborator = ModelJobCollaborator::where('id',$id)->first();
            $job_collaborator->delete();

            return response()->json([
                'status'=>204,
                'message'=>'Delete successfully.'
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
