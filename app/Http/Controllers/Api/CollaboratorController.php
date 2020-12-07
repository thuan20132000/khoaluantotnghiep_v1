<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollaboratorDetailResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Model\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        try {
            //code...
            $limit = 15;
            if ($request->input('limit')) {
                $limit = $request->input('limit');
            }
            $category = null;


            // Get collaborators by category
            if ($request->input('category')) {
                $category = $request->input('category');

                //code...
                $occupations_by_category = Category::find($category)->occupations;

                $collaborator_id_by_category = [];
                foreach ($occupations_by_category as $key => $occupation) {
                    # code...
                    array_push($collaborator_id_by_category, $occupation->collaborators()->pluck('id'));
                }

                $collaborator_id = collect($collaborator_id_by_category)->collapse();

                $collaborator_by_category = User::whereIn('id', $collaborator_id)->distinct()->limit($limit)->get();


                return response()->json([
                    'status' => true,
                    'data' => UserCollection::collection($collaborator_by_category)
                ]);
            } else {
                $collaborators_id = User::getCollaborators()->pluck('id');
                $collaborator_by_category = User::whereIn('id', $collaborators_id)->limit($limit)->get();
                return response()->json([
                    'status' => false,
                    'data' => UserCollection::collection($collaborator_by_category)
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => []
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => true,
                'data' => $th
            ]);
        }
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
            $collaborator = User::where('id', $id)
                                ->first();


            return response()->json([
                'status' => true,
                'data' => new CollaboratorDetailResource($collaborator)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'data' => []
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

        $validatedData = $request->validate([
            'name' => 'required',
            'phonenumber' => 'required',
            'idcard' => 'required',
            'address' => 'required',

        ], [
            'name.required' => 'Please enter name',
            'idcard.required' => 'Please enter id card',
            'phonenumber' => 'Please enter phone number'
        ]);

        $images_thumbnail_array = Str::of($request->filepaths)->explode(',');
        try {
            //code...
            DB::beginTransaction();

            $user =  User::where('id', $id)->first();
            $user->name = $request->name;
            $user->phonenumber = $request->phonenumber;
            $user->idcard = $request->idcard;
            $user->address = $request->address;
            $user->updated_at =  Carbon::now();
            $user->profile_image  = $request->profile_image || $user->profile_image;

            $user->update();



            $user_occupation_collect = collect($user->occupations);
            $update_occupation = $request->occupations;
            $user->occupations()->detach($user_occupation_collect->pluck('id'));
            if ($update_occupation && count($update_occupation) > 0) {
                $user->occupations()->attach($update_occupation);
            }

            DB::commit();

            return response()->json([
                'status'=>true,
                'data'=>new UserResource($user)
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status'=>false,
                'data'=>[]
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
     */
    public function getCollaboratorDetail($id,Request $request)
    {

        try {
            //code...
            $collaborator = User::where('id',$id)->first();

            return $collaborator;


        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>'Error => '.$th
            ]);
        }


    }
}
