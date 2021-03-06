<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\UserVerify;
use App\Model\JobCollaborator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            //code...
            $user = User::where('id',$id)->first();

        return response()->json([
                "status"=>true,
                "data" => new UserResource($user),
                "message"=>"Get user successfully"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status"=>false,
                "data"=>[],
                "message"=>"Get user data failed".$th
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
            //code...
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phonenumber' => 'required',
                'idcard' => 'required',
                'address' => 'required',


            ], [
                'name.required' => 'Please enter name',
                'phonenumber.required' => 'Please enter phone number',
                'idcard.required' => 'Please enter id card',
                'address' => 'Please enter yout address'
            ]);

            if ($validator->fails()) {
                return response([
                    "message" => $validator->errors(),
                    "data" => null
                ], 401);
            }

            $user = User::where('id',$id)->first();
            $user->name = $request->name;
            $user->phonenumber = $request->phonenumber;
            $user->idcard = $request->idcard;
            $user->address = $request->address;
            $user->province = $request->province ?  $request->province : $user->province;
            $user->district = $request->district ? $request->district : $user->district;
            $user->subdistrict = $request->subdistrict ? $request->subdistrict : $user->subdistrict;
            $user->profile_image = $request->profile_image ? $request->profile_image : $user->profile_image;
            $user->update();



            $occupations = $request->occupations;
            if($occupations && count($occupations) > 0){
                $user->occupations()->detach();
                $user->occupations()->attach($occupations);
            }


            return response([
                "message" => 'updated successfully',
                "data" => new UserResource($user),
                "status"=>true
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "message" => "ERROR: ".$th,
                "data" => null,
                "status"=>false
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
    }


    /**
     *
     * author:thuantruong
     * created_at:19/11/2020
     *
     */
    public function login(Request $request)
    {

        try {
            //code...
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
            ], [
                'email.required' => 'Please enter email',
                'password.required' => 'Please enter password'
            ]);

            if ($validator->fails()) {
                return response([
                    "message" => $validator->errors(),
                    "data" => null
                ], 200);
            }


            $user = User::where('email', $request->email)->first();

            if ($user) {


                if (Hash::check($request->password, $user->password)) {

                    if($user->email_verified_at){
                        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                        $response = [
                            'token' => $token,
                            "data" => new UserResource(User::find($user->id)),
                        ];
                        return response($response, 200);
                    }else{
                        return response([
                            'message'=>"Email was not verified, Please verify your email!",
                            "data"=>null

                        ],200);
                    }

                } else {
                    $response =[
                        "message" => "Password mismatch",
                        "data"=>null,
                    ];
                    return response($response, 200);
                }
            } else {
                $response = [
                    "message" => 'User does not exist',
                    "data"=>null
                ];
                return response($response, 200);
            }
        } catch (\Throwable $th) {
            return response([
                'message' => $th,
                'data'=>null
            ], 401);
        }
    }



    /**
     * author:thuantruong
     * created_at:19/11/2020
     */
    public function register(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users',
                'password' => 'required',
                'name' => 'required',
                'phonenumber' => 'required',
                'idcard' => 'required',
                'address' => 'required',


            ], [
                'email.required' => 'Please enter email',
                'password.required' => 'Please enter password',
                'name.required' => 'Please enter name',
                'email.unique' => 'Email was exists',
                'phonenumber.required' => 'Please enter phone number',
                'idcard.required' => 'Please enter id card',
                'address.required' => 'Please enter your address'
            ]);

            if ($validator->fails()) {
                return response([
                    "message" =>$validator->errors(),
                    "data" => null
                ], 200);
            }

            DB::beginTransaction();
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->phonenumber = $request->phonenumber;
            $user->idcard = $request->idcard;
            $user->address = $request->address;
            $user->province = $request->province;
            $user->district = $request->district;
            $user->subdistrict = $request->subdistrict;
            $user->profile_image = $request->profile_image;
            $user->status = 2;
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            $user->access_token = $token;
            $user->remember_token = $user->email.'-'.Str::random(60);
            $user->save();

            $user->roles()->attach($request->role);


            Mail::to($request->email)->send(new UserVerify($user));

            DB::commit();
            return response([
                "message" => 'created successfully',
                "data" => new UserResource(User::find($user->id)),
                "token" => $token
            ], 201);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response([
                "message" =>"ERROR CATCH:".$th,
                "data" => null
            ], 401);
        }
    }




    public function collaboratorStatistic($collaborator_id)
    {



        try {
            //code...
            $collaborator_income_total = 0;
            $collaborator_income = JobCollaborator::where('user_id',$collaborator_id)
            ->where('status',JobCollaborator::CONFIRMED)
            ->get();

            foreach ($collaborator_income as $collaborator) {
                # code...
                $collaborator_income_total += $collaborator->confirmed_price;
            }

            return response()->json([
                "status"=>true,
                "message"=>"Success",
                "data"=>[
                    "totalIncome"=>$collaborator_income_total,
                    "jobNumber"=>count($collaborator_income)
                ]

            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status"=>false,
                "message"=>"failed",
                "data"=>null
            ]);
        }




    }





}
