<?php

namespace App\Http\Controllers;

use App\Model\Job;
use App\Model\JobCollaborator;
use App\Model\JobConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobConfirmController extends Controller
{
    //
    public function index(Request $request)
    {
        $per_page = (int)$request->input('per_page') | 15;

        $job_confirms = JobConfirm::orderBy('created_at','desc')->paginate($per_page);
        return view('admin.job_confirmed.index',[
            'job_confirms'=>$job_confirms
        ]);
    }



    public function confirmJobCollaborator(Request $request)
    {
        $validated = $request->validate([
            'confirmed_price'=>'required',
            'job_collaborator_id'=>'required'
        ]);


        try {
            DB::beginTransaction();

            // $other_job_collaborators =  JobCollaborator::where('job_id',$request->job_id)
            //                             ->where('id','!=',$request->job_collaborator_id)
            //                             ->get();
            $job_collaborator_confirm = JobCollaborator::where('id',$request->job_collaborator_id)->first();
            $job_collaborator_confirm->status = JobCollaborator::CONFIRMED;
            $job_collaborator_confirm->update();

            // foreach ($other_job_collaborators as $job_collaborator) {
            //                 # code...
            //                 $job_collaborator->status = JobCollaborator::CANCEL;
            //                 $job_collaborator->update();
            // }

            // $check_is_confirm = JobConfirm::isConfirmedJob($request->job_id);
            // dd($check_is_confirm);
            // if($check_is_confirm){
            //     $job_confirmed = JobConfirm::where('id',$check_is_confirm->job_confirm_id)->first();
            //     $job_confirmed->job_collaborator_id = $request->job_collaborator_id;
            //     $job_confirmed->update();
            // }else{
                $job_confirmed = new JobConfirm();
                $job_confirmed->confirmed_price = $request->confirmed_price;
                $job_confirmed->status = JobConfirm::PUBLISHED;
                $job_confirmed->job_collaborator_id = $request->job_collaborator_id;
                $job_confirmed->save();
            // }
            DB::commit();

            return redirect()->back()->with('success','Confirmed Successfully.');

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy($job_confirm_id)
    {
       try {
           //code...
           $job_confirm = JobConfirm::where('id',$job_confirm_id)->delete();
           return redirect()->back()->with('success','Delete Successfully.');
       } catch (\Throwable $th) {
           throw $th;
           return redirect()->back()->with('failed','Delete Failed.');

       }
    }


}
