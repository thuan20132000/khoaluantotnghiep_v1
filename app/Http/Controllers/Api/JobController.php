<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateJobRequest;
use App\Http\Resources\ConfirmedJobCollection;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Model\Category;
use App\Model\Job;
use App\Model\JobCollaborator;
use App\Model\Location;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobController extends Controller
{

    public $per_page = 15;
    public $order_by = 'desc';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $perpage = 10;
        $postnumber = 0;
        $sortBy = 'desc';
        if ($request->input('postnumber')) {
            $postnumber = (int) $request->input('postnumber');
        }
        if ($request->input('perpage')) {
            $perpage = (int) $request->input('perpage');
        }

        try {
            //code...

            if ($request->input('category')) {
                $category_id = $request->input('category');
                $jobs =  Category::find($category_id)->jobs->where('status','<>',Job::CONFIRMED)->pluck('id');

               // $jobs_category = Job::hydrate($jobs);
                // $jobs_category->orderBy('created_at','desc');
              //  dd($jobs->toString);
                $jobs_category = Job::whereIn('id',$jobs->toArray())
                ->orderBy('created_at','desc')
                ->skip($postnumber)
                ->take($perpage)
                ->get();
          //      dd($jobs_category);
                return response()->json([
                    "status"=>true,
                    "message"=>"Get job by category",
                    "meta" => [
                        "perpage" => $perpage,
                        "total" => $jobs_category->count()
                    ],
                    "data"=>JobCollection::collection($jobs_category)
                ]);


            }else{
                $jobs = Job::where('status', '<>', Job::CONFIRMED)
                ->orderBy('created_at','desc')
                ->skip($postnumber)
                ->take($perpage)
                ->get();
                return response()->json([
                    "status"=>true,
                    "message"=>"Get all Jobs",
                    "meta" => [
                        "perpage" => $perpage,
                        "total" => $jobs->count()
                    ],
                    "data"=>JobCollection::collection($jobs)
                ]);
            }



            if ($request->input('user_id')) {


                $jobs_id_array = User::find($request->input('user_id'))->jobs->pluck('id');

                $jobs = Job::whereIn('id', $jobs_id_array)
                    ->orderBy('created_at', $sortBy)
                    ->limit($perpage)
                    ->get();
            }

            return  JobCollection::collection($jobs);
        } catch (\Throwable $th) {
            // throw $th;
            return  response()->json([
                "status" => false,
                "data" => []
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

        try {
            //code...

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'province' => 'required',
                'district' => 'required',
                'subdistrict' => 'required',
                'address' => 'required',
                'suggestion_price' => 'required',
                'author' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }

            $location = new Location();
            $location->province = $request->province;
            $location->district = $request->district;
            $location->subdistrict = $request->subdistrict;
            $location->address = $request->address;
            $location->save();

            $job = new Job();
            $job->name = $request->name;
            $job->slug = Str::slug($request->name, '-');
            $job->description = $request->description;
            $job->status = Job::PENDING;
            $job->suggestion_price = $request->suggestion_price;
            $job->location_id = $location->id;
            $job->occupation_id = $request->occupation_id;
            $job->user_id = $request->author;
            $job->save();


            $images_thumbnail_array = $request->images;

            if (is_array($images_thumbnail_array)) {
                foreach ($images_thumbnail_array as $key => $value) {
                    # code...
                    if ($value) {
                        DB::table('images')->insert(
                            ['image_url' => $value, 'job_id' => $job->id]
                        );
                    }
                }
            }



            DB::commit();

            return response()->json([
                'status' => true,
                'data' => new JobResource($job)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
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
        $job = Job::where('id', $id)->first();
        if ($job) {
            return new JobResource($job);
        } else {
            return response()->json([
                "data" => null,
                "message" => "Not found any item."
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

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'province' => 'required',
                'district' => 'required',
                'subdistrict' => 'required',
                'street' => 'required',
                'suggestion_price' => 'required',
                'author' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }

            // $location->province= $request->province;
            // $location->district = $request->district;
            // $location->subdistrict = $request->subdistrict;
            // $location->street = $request->street;
            // $location->save();

            $job = Job::where('id', $id)->first();

            $job->name = $request->name;
            $job->slug = Str::slug($request->name, '-');
            $job->description = $request->description;
            $job->status = 3;
            $job->suggestion_price = $request->suggestion_price;
            $job->occupation_id = $request->occupation_id;
            $job->user_id = $request->author;
            $job->update();


            $images_thumbnail_array = $request->images;

            if (is_array($images_thumbnail_array)) {
                foreach ($images_thumbnail_array as $key => $value) {
                    # code...
                    if ($value) {
                        DB::table('images')->insert(
                            ['image_url' => $value, 'job_id' => $job->id]
                        );
                    }
                }
            }

            $location = Location::where('id', $job->location_id)->first();
            $location->province = $request->province;
            $location->district = $request->district;
            $location->subdistrict = $request->subdistrict;
            $location->street = $request->street;
            $location->update();

            DB::commit();


            return response()->json([
                'status' => true,
                'data' => new JobResource($job)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th
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
        try {
            //code...
            $job = Job::where('id', $id)->first();
            Location::where('id', $job->location_id)->delete();
            $job->delete();

            return response()->json([
                'status' => 204,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 404,
                'message' => $th
            ]);
        }
    }


    /**
     * author:thuantruong
     * description:Sort Job by district and price
     * created_at:23/11/2020
     */
    public function sortJob(Request $request)
    {
        try {
            //code...
            $price_sort = 'desc';
            $category = '';
            $district_id = $request->input('district');
            $number = 12;

            if ($request->input('price')) {
                $price_sort = $request->input('price');
            }

            if ($request->input('limit')) {
                $number = $request->input('limit');
            }

            if ($request->input('category')) {
                $category = $request->input('category');
            }

            $data =  DB::table('jobs')
                ->join('location', 'location.id', '=', 'jobs.location_id')
                ->orderBy('jobs.suggestion_price', $price_sort)
                ->limit($number)
                ->select('jobs.*')
                ->get();


            if ($district_id) {

                $data =  DB::table('jobs')
                    ->join('location', 'location.id', '=', 'jobs.location_id')
                    ->where('location.district', $district_id)
                    ->orderBy('jobs.suggestion_price', $price_sort)
                    ->limit($number)
                    ->select('jobs.*')
                    ->get();
            }
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'data' => []
            ]);
        }
    }



    /**
     * author:thuantruong
     * desction:Search job by name,occupation,author
     * created_at:23/11/2020
     */
    public function searchJob(Request $request)
    {

        try {
            //code...
            $limit = 8;
            $district = null;
            $orderByPrice = 'desc';
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
                $filter = DB::table('jobs')
                    ->join('occupations', 'occupations.id', '=', 'jobs.occupation_id')
                    ->join('users', 'users.id', '=', 'jobs.user_id')
                    ->join('location', 'location.id', '=', 'jobs.location_id')
                    ->where([
                        ['jobs.status', '<>', Job::CONFIRMED],
                        ['jobs.name','LIKE','%'.$query.'%'],
                    ])
                    ->orWhere([
                        ['occupations.name', 'LIKE', '%' . $query . '%'],
                        ['jobs.status', '<>', Job::CONFIRMED],
                    ])
                    ->orderBy('jobs.suggestion_price', $orderByPrice)
                    ->limit($limit)
                    ->select('users.name as author', 'occupations.name as occupation_name', 'jobs.*')
                    ->get();
            } else if ($query) {
                $filter = DB::table('jobs')
                    ->join('occupations', 'occupations.id', '=', 'jobs.occupation_id')
                    ->join('users', 'users.id', '=', 'jobs.user_id')
                    ->where([
                        ['jobs.status', '<>', Job::CONFIRMED],
                        ['jobs.name','LIKE','%'.$query.'%'],
                    ])
                    ->orWhere([
                        ['occupations.name', 'LIKE', '%' . $query . '%'],
                        ['jobs.status', '<>', Job::CONFIRMED],
                    ])
                    ->limit($limit)
                    ->select('users.name as author', 'occupations.name as occupation_name', 'jobs.*')
                    ->get();
            } else if ($district) {
                $filter = DB::table('jobs')
                    ->join('occupations', 'occupations.id', '=', 'jobs.occupation_id')
                    ->join('users', 'users.id', '=', 'jobs.user_id')
                    ->join('location', 'location.id', '=', 'jobs.location_id')
                    ->where('jobs.status','<>',Job::CONFIRMED)
                    ->where('location.district', $district)
                    ->orderBy('jobs.suggestion_price', $orderByPrice)
                    ->limit($limit)
                    ->select('users.name as author', 'occupations.name as occupation_name', 'jobs.*')
                    ->get();
            } else {
                return response()->json([
                    'status' => true,
                    'data' => []
                ]);
            }

            $jobs = Job::hydrate($filter->toArray());


            return response()->json([
                'status' => true,
                "message"=>"Search Job ",
                'data' => JobCollection::collection($jobs),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                "message"=>"No data",
                'data' => [],
            ]);
        }
    }



    public function getJobsApproved($author_id, Request $request)
    {

        try {
            //code...

            $author = Job::getJobsApproved($author_id);

            return response()->json([
                'status' => true,
                'data' => $author
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }


    /**
     * author:thuantruon
     * created_at:02/12/2020
     * description: Get jobs by job's author pending
     */
    public function getPendingJobsByAuthor($author_id, Request $request)
    {
        try {
            //code...


            $per_page_get = $request->input('per_page');
            if ($per_page_get) {
                $this->per_page = $per_page_get;
            }
            $order_by_get = $request->input('sort_by');
            if ($order_by_get) {
                $this->order_by = $order_by_get;
            }

            $user_pending_jobs = Job::where('user_id', $author_id)
                ->where('status', Job::PENDING)
                ->orderBy('created_at', $this->order_by)
                ->limit($this->per_page)
                ->get();


            return response()->json([
                'status' => true,
                'data' => JobCollection::collection($user_pending_jobs),
                'message' => "Get pending'jobs is successfull"
            ]);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => $th
            ]);
        }
    }



    /**
     * author:thuantruong
     * created_at:02/12/2020
     * description:Get jobs by job's author approved
     */
    public function getApprovedJobsByAuthor($author_id, Request $request)
    {
        try {
            //code...
            $per_page_get = $request->input('per_page');
            if ($per_page_get) {
                $this->per_page = $per_page_get;
            }
            $order_by_get = $request->input('sort_by');
            if ($order_by_get) {
                $this->order_by = $order_by_get;
            }

            $user_approved_jobs = Job::where('user_id', $author_id)
                ->where('status', Job::APPROVED)
                ->orderBy('created_at', $this->order_by)
                ->limit($this->per_page)
                ->get();


            return response()->json([
                'status' => true,
                'data' => JobCollection::collection($user_approved_jobs),
                'message' => "Get approved'jobs is successfull"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => $th
            ]);
        }
    }


    /**
     * author:thuantruong
     * created_at:04/12/2020
     * description:Get jobs by job's author confirmed
     */
    public function getConfirmedJobsByAuthor($author_id, Request $request)
    {
        try {
            //code...
            $per_page_get = $request->input('per_page');
            if ($per_page_get) {
                $this->per_page = $per_page_get;
            }
            $order_by_get = $request->input('sort_by');
            if ($order_by_get) {
                $this->order_by = $order_by_get;
            }
            $user_confirmed_jobs = Job::where('user_id', $author_id)
                ->where('status', Job::CONFIRMED)
                ->orderBy('created_at', $this->order_by)
                ->limit($this->per_page)
                ->get();

            return response()->json([
                'status' => true,
                'data' => ConfirmedJobCollection::collection($user_confirmed_jobs),
                'message' => "Get confirmed'jobs is successfull"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => "ERROR =>> " . $th
            ]);
        }
    }


    /**
     * author:thuantruong
     * created_at:10/12/2020
     * description:Delete a job by author
     */
    public function deleteJobByAuthor($author_id, $job_id)
    {

        try {
            //code...
            $job_collaborator_delete = JobCollaborator::where('job_id', $job_id)->delete();
            $job_delete = Job::where('id', $job_id)->delete();

            return response()->json([
                "status" => true,
                "data" => null,
                "message" => "Delete a job successfully"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => false,
                "data" => null,
                "message" => "Delete Job Failed " . $th
            ]);
        }
    }
}
