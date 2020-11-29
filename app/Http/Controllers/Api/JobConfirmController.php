<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobConfirmController extends Controller
{
    //



    public function confirmJobCollaborator(Request $request)
    {

        // DB::beginTransaction();

        // $validator = Validator::make($request->all(), [
        //     'comfirmed_price'=>'required',
        //     'job_collaborator_id'=>''
        // ]);



        // if($validator->fails()){
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>$validator->errors()
        //     ]);
        // }

        try {
            //code...

        } catch (\Throwable $th) {
            //throw $th;
        }




    }

}
