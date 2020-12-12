<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ModelJobController;
use App\Http\Resources\CollaboratorJobApplyingCollection;
use App\Http\Resources\JobCollaboratorCollection;
use App\Http\Resources\JobCollaboratorResource;
use App\Model\Job;
use App\Model\JobCollaborator as ModelJobCollaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobCollaborator extends Controller
{

    const CONFIRM_STATUS = 3;
    const PENDING_STATUS = 2;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $per_page = 15;
        if ($request->input('per_page')) {
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





            $validator = Validator::make($request->all(), [
                'expected_price' => 'required',
                'description' => 'required',
                'job_id' => 'required',
                'user_id' => 'required',
            ]);



            if ($validator->fails()) {
                return response()->json([
                    'status' => $validator->errors()
                ]);
            }



            //code...
            $job_id  = $request->job_id;
            $collaborator_id = $request->user_id;

            $check_full_candidates = ModelJobCollaborator::checkIsFullCandidates($job_id);
            if ($check_full_candidates) {
                return response()->json([
                    'status' => false,
                    'message' => 'Collaborator is full!!!'
                ]);
            }

            $check_duplicate = ModelJobCollaborator::where('job_id', $job_id)
                ->where('user_id', $collaborator_id)->count();

            if ($check_duplicate > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Collaborator was exists!!!'
                ]);
            }



            $job_collaborator = new ModelJobCollaborator();
            $job_collaborator->expected_price = $request->expected_price;
            $job_collaborator->description = $request->description;
            $job_collaborator->start_at = $request->start_at;
            $job_collaborator->finish_at = $request->finish_at;
            $job_collaborator->user_id = $request->user_id;
            $job_collaborator->job_id = $request->job_id;
            $job_collaborator->status = ModelJobCollaborator::PENDING;
            $job_collaborator->save();

            DB::commit();

            return new JobCollaboratorResource($job_collaborator);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'status' => 204,
                'message' => $th
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
        $job_collaborator = ModelJobCollaborator::where('id', $id)->first();
        if ($job_collaborator) {
            return new JobCollaboratorResource($job_collaborator);
        } else {
            return response()->json([
                "data" => null,
                "message" => "not found any item."
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

            $validator = Validator::make($request->all(), [
                'expected_price' => 'required',
                'description' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => $validator->errors()
                ]);
            }

            //code...

            $job_collaborator = ModelJobCollaborator::where('id', $id)->first();
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
                'status' => 204,
                'message' => $th
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
            $job_collaborator = ModelJobCollaborator::where('id', $id)->first();
            $job_collaborator->delete();

            return response()->json([
                'status' => 204,
                'message' => 'Delete successfully.'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 404,
                'message' => $th
            ]);
        }
    }


    public function getJobCollaboratorApplying(Request $request)
    {
        try {
            //code...
            $per_page = 15;
            if ($request->input('per_page')) {
                $per_page = (int)$request->input('per_page');
            }
            $collaborator_id = $request->input('user_id');
            $collaborator_job_status = $request->input('status');

            if ($collaborator_id && $collaborator_job_status == JobCollaborator::PENDING_STATUS) {
                $job_collaborator = ModelJobCollaborator::where('user_id', $collaborator_id)
                    ->where("status", $collaborator_job_status)
                    ->orderBy('created_at', 'desc')
                    ->limit($per_page)
                    ->get();

                return response()->json([
                    "status" => true,
                    "data" => CollaboratorJobApplyingCollection::collection($job_collaborator)
                ]);
            }
            // else if ($collaborator_id && $collaborator_job_status == JobCollaborator::CONFIRM_STATUS) {
            //     $job_collaborator = ModelJobCollaborator::where('user_id', $collaborator_id)
            //         ->where("status", $collaborator_job_status)
            //         ->orderBy('created_at', 'desc')
            //         ->limit($per_page)
            //         ->get();

            //     return response()->json([
            //         "status" => true,
            //         "data" => CollaboratorJobApplyingCollection::collection($job_collaborator)
            //     ]);
            // }




            return response()->json([
                "status" => false,
                "data" => []
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => false,
                "data" => []
            ]);
        }
    }



    public function selectCandidate(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'job_id' => 'required',
            'job_collaborator_id' => 'required',
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status" => false,
                "data" => $validated->errors(),
            ]);
        }
        try {


            DB::beginTransaction();
            $job_collaborators_cancel = ModelJobCollaborator::where('job_id', $request->job_id)
                ->where('id', '!=', $request->job_collaborator_id)
                ->get();


            foreach ($job_collaborators_cancel as $job_collaborator) {
                # code...

                $job_collaborator->status = ModelJobCollaborator::CANCEL;
                $job_collaborator->update();
            }


            $job_collaborator_approve = ModelJobCollaborator::where('id', $request->job_collaborator_id)
                ->first();
            $job_collaborator_approve->status = ModelJobCollaborator::APPROVED;
            $job_collaborator_approve->update();

            $job = Job::where('id', $request->job_id)->first();
            $job->status = Job::APPROVED;
            $job->update();

            DB::commit();

            return response()->json([
                "status" => true,
                "data" => [
                    "id" => $job_collaborator_approve->user->id,
                    "name" => $job_collaborator_approve->user->name,
                    "email" => $job_collaborator_approve->user->email,
                    "phonenumber" => $job_collaborator_approve->phonenumber,
                    "address" => $job_collaborator_approve->address
                ],
                "message" => "Approved Candidate Successfully"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => false,
                "data" => [],
                "message" => "ERROR ==> " . $th
            ]);
        }
    }





    public function confirmCandidate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'job_collaborator_id' => 'required',
            'job_id' => 'required',

        ]);



        if ($validator->fails()) {
            return response()->json([
                'status' => $validator->errors()
            ]);
        }

        DB::beginTransaction();

        try {
            //code...

            $job_collaborator_confirm = ModelJobCollaborator::where('id', $request->job_collaborator_id)
                ->first();
            $job_collaborator_confirm->confirmed_price = $request->confirmed_price;
            $job_collaborator_confirm->range = $request->range;
            $job_collaborator_confirm->review_content = $request->content;
            $job_collaborator_confirm->status = ModelJobCollaborator::CONFIRMED;

            $job_collaborator_confirm->update();
            $job = Job::where('id', $request->job_id)->first();
            $job->status = Job::CONFIRMED;
            $job->update();



            DB::commit();
            return response()->json([
                "status" => true,
                "data" => [
                    "id" => $job_collaborator_confirm->user->id,
                    "name" => $job_collaborator_confirm->user->name,
                    "email" => $job_collaborator_confirm->user->email,
                    "phonenumber" => $job_collaborator_confirm->phonenumber,
                    "address" => $job_collaborator_confirm->address
                ],
                "message" => "Confirmed Candidate Successfully"
            ]);
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();
            return response()->json([
                "status" => false,
                "data" => [],
                "message" => "ERROR ==> " . $th
            ]);
        }
    }




    public function getJobCollaboratorStatus($user_id,$status,Request $request)
    {


        try {
            //code...
            $per_page = 15;
            if ($request->input('per_page')) {
                $per_page = (int)$request->input('per_page');
            }

            $collaborator_jobs = ModelJobCollaborator::where('user_id',$user_id)
                                                ->where("status",$status)
                                                ->orderBy('created_at','desc')
                                                ->limit($per_page)
                                                ->get();


            return response()->json([
                "status" => true,
                "data" => JobCollaboratorCollection::collection($collaborator_jobs),
                "message"=>"Get job successfully"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "data" => [],
                "message"=>"Get job failed"
            ]);
        }
    }
}
