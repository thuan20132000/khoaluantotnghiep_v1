<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Evaluate;
use App\Model\JobCollaborator;
use App\Model\JobConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobConfirmController extends Controller
{
    //



    public function confirmJobCollaborator(Request $request)
    {

        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'confirmed_price' => 'required',
            'job_collaborator_id' => 'required'
        ]);



        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }



        try {
            //code...

            $isConfirmed = JobConfirm::checkIsConfirmed($request->job_collaborator_id);

            if(!$isConfirmed){
                $job_confirm = new JobConfirm();
                $job_confirm->confirmed_price = $request->confirmed_price;
                $job_confirm->job_collaborator_id = $request->job_collaborator_id;
                $job_confirm->status = 0;
                $job_confirm->save();




                $evaluate = new Evaluate();
                $evaluate->range = $request->range;
                $evaluate->content = $request->content;
                $evaluate->job_confirm_id  = $job_confirm->id;
                $evaluate->status = 0;

                $evaluate->save();


            }else{
                $job_confirm = JobConfirm::where('job_collaborator_id',$request->job_collaborator_id)->first();
                $job_confirm->confirmed_price = $request->confirmed_price;
                $job_confirm->status = 0;

                $job_confirm->update();

                $evaluate = Evaluate::where('job_confirm_id',$job_confirm->id)->first();
                $evaluate->range = $request->range || $evaluate->range;
                $evaluate->content = $request->content || $evaluate->content;
                $evaluate->status = 0;

                $evaluate->update();
            }


            $job_collaborator_confirmed =  JobCollaborator::where('id',$job_confirm->job_collaborator_id)->first();
            $job_collaborator_confirmed->status = JobCollaborator::CONFIRMED;
            $job_collaborator_confirmed->update();




            DB::commit();

            return response()->json([
                "status"=>true,
                "data"=>[
                    'confirm_id'=>$job_confirm->id,
                    'confirmed_price'=>$job_confirm->confirmed_price,
                    'range'=>$evaluate->range,
                    'content'=>$evaluate->content,

                ]
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            return response()->json([
                "status"=>false,
                "data"=>[],
                "message"=>$th
            ]);
        }
    }


    public function getUserConfirmJob($author_id, Request $request)
    {
        try {
            //code...
            $user_job_confirm = JobConfirm::getUserConfirmedJob($author_id);

            return response()->json([
                'status' => true,
                'data' => $user_job_confirm

            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'data' => $th
            ]);
        }
    }
}
