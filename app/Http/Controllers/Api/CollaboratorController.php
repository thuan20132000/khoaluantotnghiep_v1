<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Model\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            }else{
                $collaborators_id = User::getCollaborators()->pluck('id');
                $collaborator_by_category = User::whereIn('id',$collaborators_id)->limit($limit)->get();
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
}
