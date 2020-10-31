<?php

namespace App\Http\Controllers;

use App\Model\Occupation;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use function PHPSTORM_META\type;

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
        $users = User::orderBy('created_at','desc')->get();
        return view('admin.users.index',['users'=>$users]);
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
        $roles = Role::all();

        return view('admin.users.create',['occupations'=>$occupations,'roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $images_thumbnail_array = Str::of($request->filepaths)->explode(',');
        // dd($images_thumbnail_array);
        // dd($request->all());
        //
        $validatedData = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'phonenumber'=>'required',
            'idcard'=>'required',
            'password'=>'required',
            'province'=>'required',
            'district'=>'required',
            'subdistrict'=>'required',
            'address'=>'required',

        ],[
            'name.required'=>'Please enter name',
            'email.required'=>'Please enter email',
            'password.required'=>'Please enter password',
            'idcard.required'=>'Please enter id card',
            'phonenumber'=>'Please enter phone number'
        ]);

        $images_thumbnail_array = Str::of($request->filepaths)->explode(',');

        try {
            //code...
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phonenumber = $request->phonenumber;
            $user->idcard = $request->idcard;
            $user->province = $request->province;
            $user->district = $request->district;
            $user->password = $request->password;
            $user->subdistrict = $request->subdistrict;
            $user->address = $request->address;
            $user->status = $request->status;
            $user->save();

            $user_id = $user->id;
            if($images_thumbnail_array && count($images_thumbnail_array) > 1){
                foreach ($images_thumbnail_array as $key => $value) {
                    # code...
                    if($value){
                        DB::table('images')->insert(
                            ['image_url'=>$value,'user_id'=>$user_id]
                        );
                    }
                }
            }
            $user->roles()->attach($request->role);


            $occupations = $request->occupations;
            if($occupations && count($occupations) > 0){
                $user->occupations()->attach($occupations);
            }

            DB::commit();
            return redirect()->route('user.index')->with('success','Create Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('failed','Create Failed!');
            // throw $th;
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
        try {
            //code...
            $occupations = Occupation::all();
            $user = User::where('id',$id)->first();
            $roles = Role::all();

            $user_occupation_array = $user->occupations->pluck('id')->toArray();
            $user_images = DB::table('images')->where('user_id',$id)->get();
            $user_images_array = $user_images->pluck('image_url')->toArray();
            return view('admin.users.edit',[
                'user'=>$user,
                'roles'=>$roles,
                'occupations'=>$occupations,
                'user_occupation_array'=>$user_occupation_array,
                'user_image_array'=>$user_images_array,
            ]);

        } catch (\Throwable $th) {
            throw $th;
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
        // dd($request->all());
        $validatedData = $request->validate([
            'name'=>'required',
            'phonenumber'=>'required',
            'idcard'=>'required',
            'province'=>'required',
            'district'=>'required',
            'subdistrict'=>'required',
            'address'=>'required',

        ],[
            'name.required'=>'Please enter name',
            'idcard.required'=>'Please enter id card',
            'phonenumber'=>'Please enter phone number'
        ]);

        $images_thumbnail_array = Str::of($request->filepaths)->explode(',');
        try {
            //code...
            DB::beginTransaction();

            $user =  User::where('id',$id)->first();
            $user->name = $request->name;
            $user->phonenumber = $request->phonenumber;
            $user->idcard = $request->idcard;
            $user->province = $request->province;
            $user->district = $request->district;
            $user->subdistrict = $request->subdistrict;
            $user->address = $request->address;
            $user->status = $request->status;
            $user->update();

            $roless = $user->roles->pluck('id')->all();
            if(count($roless)>0){
                foreach ($roless as  $value) {
                    if($request->role != $value){
                        $user->roles()->detach($value);
                        $user->roles()->attach($request->role);
                    }
                }
            }else{
                $user->roles()->attach($request->role);
            }



            $user_id = $user->id;
            if($images_thumbnail_array && count($images_thumbnail_array) > 1){
                foreach ($images_thumbnail_array as $key => $value) {
                    # code...
                    if($value){
                        DB::table('images')->insert(
                            ['image_url'=>$value,'user_id'=>$user_id]
                        );
                    }
                }
            }




            $occupations = $request->occupations;
            if($occupations && count($occupations) > 0){
                $user->occupations()->attach($occupations);
            }

            DB::commit();
            return redirect()->route('user.index')->with('success','Update Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('failed','Update Failed!');
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

            $user = User::find($id)->first();
            // dd($user);
            $user->delete();
            return redirect()->back()->with('success','Delete successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * remove mass category
     */
    public function destroyMass(Request $request)
    {
        try {
            //code...
            $ids = $request->input('ids');
            if(count($ids) > 0 ){
                User::whereIn('id',$ids)->delete();

            }
            return response(['status'=>true,'data'=>$ids],200);

        } catch (\Throwable $th) {
            //throw $th;
            return response(['status'=>false],404);
        }
    }
}
