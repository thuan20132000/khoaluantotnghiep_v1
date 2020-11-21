<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\UserVerify;
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
            $user->province = $request->province | $user->province;
            $user->district = $request->district | $user->district;
            $user->subdistrict = $request->subdistrict | $user->subdistrict;
            $user->profile_image = $request->profile_image | $user->profile_image;
            $user->update();


            return response([
                "message" => 'updated successfully',
                "data" => $user,
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "message" => $th,
                "data" => null
            ], 401);
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
                ], 401);
            }


            $user = User::where('email', $request->email)->first();

            if ($user) {

                // Check verify email
                if(!$user->email_verify_at || $user->email_verify_at == ""){
                   return response(["message"=>"Please verify your email!"],401);
                }

                if (Hash::check($request->password, $user->password)) {

                    if($user->email_verified_at){
                        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                        $response = [
                            'token' => $token,
                            'data' => $user
                        ];
                        return response($response, 200);
                    }else{
                        return response([
                            'message'=>"Email was not verified, Please verify your email!",

                        ],401);
                    }

                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 401);
                }
            } else {
                $response = ["message" => 'User does not exist'];
                return response($response, 401);
            }
        } catch (\Throwable $th) {
            return response(['message' => $th], 401);
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
                'email' => 'required',
                'password' => 'required|unique:users',
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
                'address' => 'Please enter yout address'
            ]);

            if ($validator->fails()) {
                return response([
                    "message" =>"Valudation ERROR : ".$validator->errors(),
                    "data" => null
                ], 401);
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




}
