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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\URL;
use phpDocumentor\Reflection\Types\Boolean;

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
            $perpage = 10;
            $postnumber = 0;

            $message_response = '';

            $sortByTopRating = false;
            $sortByNearByDistrict = false;

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
            if ($request->input('sortbytoprating')) {
                $sortByTopRating = (bool) $request->input('sortbytoprating');
            }
            if ($request->input('sortbynearbydistrict')) {
                $sortByNearByDistrict = (int) $request->input('sortbynearbydistrict');
            }




            $category = null;


            if ($sortByTopRating == true) {
                $collaborators_by_rating = User::getCollaboratorsOrderBy('range', 'desc', $postnumber, $perpage);

                $collaborators = User::hydrate($collaborators_by_rating->toArray());
                return response()->json([
                    'status' => true,
                    'data' => UserCollection::collection($collaborators),
                    'links' => [

                        "next" => URL::current() . "?postnumber=" . ($postnumber + $perpage) . "&perpage=$perpage",
                    ],
                    "meta" => [
                        "perpage" => $perpage,
                        "total" => $collaborators->count()
                    ]
                ]);
            }



            if ($sortByNearByDistrict) {

                $collaborators_by_district = User::getCollaboratorsNearBy($sortByNearByDistrict, $postnumber, $perpage);
                $collaborators = User::hydrate($collaborators_by_district->toArray());

                return response()->json([
                    'status' => true,
                    'data' => UserCollection::collection($collaborators),
                    'links' => [

                        "next" => URL::current() . "?postnumber=" . ($postnumber + $perpage) . "&perpage=$perpage",
                    ],
                    "meta" => [
                        "perpage" => $perpage,
                        "total" => $collaborators->count()
                    ]
                ]);
            }



            $category = $request->input('category');
            $district = $request->input('district');
            // Get collaborators by category
            if ($category && $district) {

                $collaborators = DB::table('users')
                    ->join('occupation_user', 'occupation_user.user_id', '=', 'users.id')
                    ->join('occupations', 'occupations.id', '=', 'occupation_user.occupation_id')
                    ->join('categories', 'categories.id', '=', 'occupations.category_id')
                    ->join('job_collaborators', 'job_collaborators.user_id', 'users.id')
                    ->select(DB::raw('SUM(job_collaborators.range) as user_range'))
                    ->where('categories.id', '=', $category)
                    ->where('users.district', '=', $district)
                    ->orderByRaw('SUM(job_collaborators.range) DESC')
                    // ->where('status', '<>', 1
                    ->groupBy('users.id')
                    ->skip($postnumber)
                    ->take($perpage)
                    ->select(
                        'users.*'
                    )
                    ->get();

                $collaborators = User::hydrate($collaborators->toArray());
                $message_response = "Get collaborators by Category and District Successfully";
            } else if ($category) {
                $collaborators = DB::table('users')
                    ->join('occupation_user', 'occupation_user.user_id', '=', 'users.id')
                    ->join('occupations', 'occupations.id', '=', 'occupation_user.occupation_id')
                    ->join('categories', 'categories.id', '=', 'occupations.category_id')
                    ->join('job_collaborators', 'job_collaborators.user_id', 'users.id')
                    ->select(DB::raw('SUM(job_collaborators.range) as user_range'))
                    ->where('categories.id', '=', $category)
                    ->orderByRaw('SUM(job_collaborators.range) DESC')
                    // ->where('status', '<>', 1
                    ->groupBy('users.id')
                    ->skip($postnumber)
                    ->take($perpage)
                    ->select(
                        'users.*'
                    )
                    ->get();
                $collaborators = User::hydrate($collaborators->toArray());

                $message_response = "Get collaborators by Category Successfully";
            } else if ($district) {
                $collaborators = DB::table('users')
                    ->join('occupation_user', 'occupation_user.user_id', '=', 'users.id')
                    ->join('occupations', 'occupations.id', '=', 'occupation_user.occupation_id')
                    ->join('categories', 'categories.id', '=', 'occupations.category_id')
                    ->join('job_collaborators', 'job_collaborators.user_id', 'users.id')
                    ->select(DB::raw('SUM(job_collaborators.range) as user_range'))
                    ->where('users.district', '=', $district)
                    ->orderByRaw('SUM(job_collaborators.range) DESC')
                    // ->where('status', '<>', 1
                    ->groupBy('users.id')
                    ->skip($postnumber)
                    ->take($perpage)
                    ->select(
                        'users.*'
                    )
                    ->get();
                $collaborators = User::hydrate($collaborators->toArray());

                $message_response = "Get collaborators by District Successfully";
            } else {
                $collaborators = DB::table('users')
                    ->join('occupation_user', 'occupation_user.user_id', '=', 'users.id')
                    ->join('occupations', 'occupations.id', '=', 'occupation_user.occupation_id')
                    ->join('categories', 'categories.id', '=', 'occupations.category_id')
                    ->join('job_collaborators', 'job_collaborators.user_id', 'users.id')
                    ->select(DB::raw('SUM(job_collaborators.range) as user_range'))
                    ->orderByRaw('SUM(job_collaborators.range) DESC')
                    // ->where('status', '<>', 1
                    ->groupBy('users.id')
                    ->skip($postnumber)
                    ->take($perpage)
                    ->select(
                        'users.*'
                    )
                    ->get();
                $collaborators = User::hydrate($collaborators->toArray());

                $message_response = "Get all Collaborators Successfully";
            }

            return response()->json([
                'status' => true,
                'message' => $message_response,
                'data' => UserCollection::collection($collaborators),
                'links' => [
                    "next" => URL::current() . "?postnumber=" . ($postnumber + $perpage) . "&perpage=$perpage",
                ],
                "meta" => [
                    "perpage" => $perpage,
                    "total" => $collaborators->count()
                ]
            ]);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => "ERROR : " . $th
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
