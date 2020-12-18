<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollaboratorDetailResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Model\Category;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

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
            $orderby = 'desc';
            $perpage = 12;
            $postnumber = 0;
            if ($request->input('limit')) {
                $limit = $request->input('limit');
            }
            if ($request->input('orderby')) {
                $orderby = $request->input('orderby');
            }
            if ($request->input('postnumber')) {
                $postnumber = (int) $request->input('postnumber');
            }
            if ($request->input('perpage')) {
                $perpage = (int) $request->input('perpage');
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

                $collaborator_by_category = User::whereIn('id', $collaborator_id)
                    ->distinct()
                    ->skip($postnumber)
                    ->orderBy('created_at', $orderby)
                    ->take($perpage)
                    ->get();


                return response()->json([
                    'status' => true,
                    'data' => UserCollection::collection($collaborator_by_category),
                    'links' => [
                        "next" => URL::current() . "?postnumber=".($postnumber+$perpage)."&perpage=$perpage",
                    ],
                    "meta" => [
                        "per_page" => $perpage,
                        "total" => $collaborator_by_category->count()
                    ]
                ]);
            } else {
                $collaborators_id = User::getCollaborators()->pluck('id');

                $collaborator_by_category = User::whereIn('id', $collaborators_id)
                    // ->limit($limit)
                    ->skip($postnumber)
                    ->orderBy('created_at', $orderby)
                    ->take($perpage)
                    ->get();

                return response()->json([
                    'status' => false,
                    'data' => UserCollection::collection($collaborator_by_category),
                    'links' => [

                        "next" => URL::current() . "?postnumber=".($postnumber+$perpage)."&perpage=$perpage",
                    ],
                    "meta" => [
                        "perpage" => $perpage,
                        "total" => $collaborator_by_category->count()
                    ]
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => []
            ]);
        } catch (\Throwable $th) {
            throw $th;
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
                'status' => true,
                'data' => new UserResource($user)
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => []
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
    public function getCollaboratorDetail($id, Request $request)
    {

        try {
            //code...
            $collaborator = User::where('id', $id)->first();

            return $collaborator;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Error => ' . $th
            ]);
        }
    }




    public function search(Request $request)
    {
        try {
            //code...
            $limit = 6;
            $district = null;
            $orderBy = 'desc';
            $query = $request->input('query');

            if ($request->input('limit')) {
                $limit = (int)$request->input('limit');
            }
            if ($request->input('district')) {
                $district = (int)$request->input('district');
            }
            if ($request->input('order_by')) {
                $orderByPrice = $request->input('order_by');
            }



            if ($district && $query) {
                $collaborators = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->join('occupation_user', 'occupation_user.user_id', '=', 'users.id')
                    ->join('occupations', 'occupations.id', '=', 'occupation_user.occupation_id')
                    ->where('role_user.role_id', '=', Role::COLLABORATOR)
                    ->where('occupations.name', 'LIKE', '%' . $query . '%')
                    ->where('district', $district)
                    ->select('users.*')
                    ->get();
            } elseif ($district) {
                $collaborators = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->where('role_user.role_id', '=', Role::COLLABORATOR)
                    ->where('district', $district)
                    ->select('users.*')
                    ->get();
            } elseif ($query) {
                $collaborators = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->join('occupation_user', 'occupation_user.user_id', '=', 'users.id')
                    ->join('occupations', 'occupations.id', '=', 'occupation_user.occupation_id')
                    ->where('role_user.role_id', '=', Role::COLLABORATOR)
                    ->where('occupations.name', 'LIKE', '%' . $query . '%')
                    ->select('users.*')
                    ->get();
            }

            $collaborator_ids = $collaborators->pluck('id')->all();

            $collaborators = User::whereIn('id', $collaborator_ids)->get();

            $collaborator_collection = UserCollection::collection($collaborators);


            return response()->json([
                "status" => true,
                "data" => $collaborator_collection,
                "message" => "Search Users Successfully"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => false,
                "data" => null,
                "message" => "Search Users Failed " . $th
            ]);
        }
    }
}
