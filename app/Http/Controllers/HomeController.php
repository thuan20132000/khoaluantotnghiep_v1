<?php

namespace App\Http\Controllers;
use App\Model\Category;
use App\Model\Occupation;
use App\Model\Job;
use App\Model\JobCollaborator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Model\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Role;
use App\Http\Resources\CollaboratorJobApplyingCollection;

class HomeController extends Controller
{
    
    public function index()
    {   
        $categories = Category::all();
        $occupation = Occupation::all();
        $jobs = Job::where('status','<>',Job::CONFIRMED)->get();
        $user = Auth::user();


        return view('page.pages.index',['categories'=>$categories,'occupation'=>$occupation,'jobs'=>$jobs,'user'=>$user]);
    }



    public function checkout()
    {
        return view('page.pages.checkout');
    }
    public function jobsingle($id)
    {
        
        $job = Job::where('id',$id)->get();
        return view('page.pages.jobsingle',['job'=>$job]);
        
    }
    public function jobdetail()
    {
        return view('page.pages.jobdetail');
    }
    public function custommer()
    {
        $users = User::getCollaborators();
        
        return view('page.pages.listuser', ['users'=>$users] );
    }
    public function listJob(){
        $job =Job::all();
        //dd($job);
        return view('page.pages.listJob',['job'=>$job]);

    }
    public function jobCategory($id){
        $job = Category::where('id',$id)->first()->jobs;
    
        return view('page.pages.listJob',['job'=>$job]);
    }

    function postLoginClient(Request $request)
    {
      
        $this->validate(
            
            $request,
            [
                'email' => 'required|email',
                'password' => 'required|min:3|max:32',
            ],
            [
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Định dạng email chưa đúng',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu chứa từ 3-32 kí tự',
                'password.max' => 'Mật khẩu chứa từ 3-32 kí tự',
            ]
        );
       $check = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
   
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        } else {
            return back()->with('errorLogin', 'Đăng nhập không thành công');;
        }
    }
   
    public function registerClient(Request $request)
    {
       

        $this->validate(
            $request,
            [
                'name' => 'required|min:3|max:32',
                'email' => 'required|email|unique:users,email',
                'phonenumber' => 'required|min:3|max:32',
                'password' => 'required|min:3|max:32',
                'phonenumber' => 'required',
                'address' => 'required'
            ],
            [
                'name.required' => 'Bạn chưa nhập họ và tên',
                'name.min' => 'Họ và tên chứa từ 3-32 kí tự',
                'name.max' => 'Họ và tên chứa từ 3-32 kí tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Định dạng email chưa đúng',
                'email.unique' => 'Email đã tồn tại',
                'address.requidred' => 'Bạn chưa nhập địa chỉ',
                'phonenumber.required' => 'Please enter phone number',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu chứa từ 3-32 kí tự',
                'password.max' => 'Mật khẩu chứa từ 3-32 kí tự',
            
            ]
        );       
        
        $images_thumbnail_array = Str::of($request->filepaths)->explode(',');
                                                                                                                   
        try {
            //code...
            // dd($request->all());
            DB::beginTransaction();
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->address = $request->address;
            $user->phonenumber = $request->phonenumber;
            
            $user->save();
            
            $user_id = $user->id;
            
            
            $user->roles()->attach($request->role);
            $occupations = $request->occupations;
            if($occupations && count($occupations) > 0){
                $user->occupations()->attach($occupations);
            }

            DB::commit();
            

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('failed','Register Failed');
        }

        return redirect()->back()->with("success","Register Success");
    }
    
        
    public function getLogin(){
        return view ('page.pages.dangnhap');
    }

    public function getRegister(){

        return view ('page.pages.dangki');
    }
    
    function getLogoutClient()
    {
        Auth::logout();
        return redirect('http://127.0.0.1:8000/');
    }   
    public function getSearch(Request $req){
        


        $job = Job::Where('name','like','%'.$req->key.'%')
                ->get();
                return view ('page.pages.listJob',['job'=>$job]);
    }
    public function postJob(){
    
        $occupation = Occupation::all();
        return view('page.pages.postJob',['occupation'=>$occupation]);
    }
    public function postPostJob(request $request){
        
        $this->validate(
            $request,
            [
                'name' => 'required|min:3|max:32',
                'suggestion_price' => 'required',
                'address' => 'required|min:3|max:32',
                'description' => 'required',
            ],
            [
                'name.required' => 'Bạn chưa nhập họ và tên',
                'name.min' => 'Họ và tên chứa từ 3-32 kí tự',
                'name.max' => 'Họ và tên chứa từ 3-32 kí tự',
                'address.required' => 'Bạn chưa nhập địa chỉ',
                'description.required' => 'Bạn chưa nhập mô tả ',
                
            
            ]
        );  
                                                                                                                            
        try {
            
             
             DB::beginTransaction();
             
            //code...
            $location = new Location();
            $location->province = $request->province || 01; 
            $location->address =$request->address;
            $location->district = $request->district || 01;
            $location->subdistrict = $request->subdistrict || 01;
            $location->street = $request->street || 01;
            $location->save();
             

            $job = new Job();
            $job->occupation_id = $request->occupation_id;
            $job->slug = Str::slug($request->name, '-');
            $job->name = $request->name;
            $job->description = $request->description;
            $job->location_id = $location->id;
            $job->suggestion_price = $request->suggestion_price;
            $job->user_id = $request->author || 12;
            
            // dd($job);
            $job->save();
        
            $images_thumbnail_array = Str::of($request->filepaths)->explode(',');
            if($images_thumbnail_array && count($images_thumbnail_array) > 0){
                foreach ($images_thumbnail_array as $key => $value) {
                    # code...
                    if($value){
                        DB::table('images')->insert(
                            ['image_url'=>$value,'job_id'=>$job->id]
                        );
                    }
                }
            }
            DB::commit();


        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('failed','Đăng thất bại');
        }

        return redirect()->back()->with("success","Đăng thành công");
    }
    
    public function profile(){

        // dd(Auth::user());
        $user = Auth::user();
        return view('page.pages.profile',['user'=>$user]);
    }
    public function quanly(){
        return view('page.pages.quanlyvieclam');
    }
    public function getungtuyen(){
        return view('page.pages.listJob');
    }
    public function postungtuyen(Request $request){

    
    // dd($request->all());
        if(!$request->user){
            return redirect()->back()->with('failed','Bạn Cần Phải Đăng Nhập Với Vai Trò Người Tìm Việc Để Ứng Tuyển!');

        }

    $validated = $request->validate([
        'price'=>'required',
        'user'=>'required',
        'job'=>'required',
    ],[
        'price.required'=>'Please enter expected price!',
        'user.required'=>'Please choose collaborator!',
        'job.required'=>'Please choose job!',
    ]);

    try {
        //code...
        $user = User::where ('id',$request->user)->first();
        $user_role = $user->roles;
        
        if($request->user == null || $user_role[0]->id != Role::COLLABORATOR){
    
            return redirect()->back()->with('failed','Bạn Cần Phải Đăng Nhập Với Vai Trò Người Tìm Việc Để Ứng Tuyển!');
        }
        $job_id = $request->job;
        // dd($request->all());
        $collaborator_id = $request->user;

        $check_duplicate = JobCollaborator::where('job_id',$job_id)
                            ->where('user_id',$collaborator_id)->count();
        if($check_duplicate > 0){
            return redirect()->back()->with('failed','Công việc này đã tồn tại!');
        }


        $job_colaborator = new JobCollaborator();
        $job_colaborator->description = $request->description;
        $job_colaborator->user_id = $request->user;
        $job_colaborator->expected_price = $request->price;
        $job_colaborator->job_id = $request->job;
        $job_colaborator->status = JobCollaborator::PENDING;
        
        
        $job_colaborator->save();

        return redirect()->back()->with('success','Ứng tuyển thành công');
    } catch (\Throwable $th) {
        throw $th;
        return redirect()->back()->with('failed','Ứng tuyển thất bại!');

    }
   
}
public function getJobCollaborator($user_id,$status,Request $request)
{
    // dd($request->all());
    try {
        //code...
        $per_page = 15;
        if ($request->input('per_page')) {
            $per_page = (int)$request->input('per_page');
        }
        
        $collaborator_jobs = ModelJobCollaborator::where('user_id',$user_id)
                                            ->where("status",$status)
                                            ->orderBy('created_at','desc')
                                            ->limit($per_page)
                                            ->get();
        // $collaborator_jobs->user_id = $request->user_id;
        // $collaborator_jobs->status = ModelJobCollaborator::PENDING;
        // return new JobCollaboratorResource($job_collaborator);
                                            return redirect()->back()->with('success','Create Successfully');
                                        } catch (\Throwable $th) {
                                            throw $th;
                                            return redirect()->back()->with('failed','Create failed!');
                                    
                                        }
}

public function posteditProfile(Request $request)
{
    //
    
        // code...
        $validated = $request->validate([
            
            'name' => 'required',
            'phonenumber' => 'required',
            'address' => 'required',
                

        ], [
            'name.required' => 'Mời bạn nhập tên',
            'phonenumber.required' => 'Mời bạn nhập số điện thoại',
            'address' => 'Mời bạn nhập địa chỉ'
        ]);
       try{

        DB::beginTransaction();
        // dd($user);
        $images_thumbnail_array = Str::of($request->filepaths)->explode(',');

        $user = Auth::user();
        $user->name = $request->name;
        $user->phonenumber = $request->phonenumber;
        $user->address = $request->address;
        $user->province = $request->province ?  $request->province : $user->province;
        $user->district = $request->district ? $request->district : $user->district;
        $user->subdistrict = $request->subdistrict ? $request->subdistrict : $user->subdistrict;
        // dd($user);
        $user->profile_image = $images_thumbnail_array[0];
        $user->update();
        $user_id = $user->id;
        // dd($images_thumbnail_array[0]);
     
            DB::commit();

        return redirect()->back()->with('success','Sửa thành công');
    } catch (\Throwable $th) {
        throw $th;
        return redirect()->back()->with('failed','Sửa thất bại!');


}
}
    public function geteditprofile(){
        $user = Auth::user();
        return view('page.pages.editProfile',['user'=>$user]);
    }


    public function getCollaboratorJobByStatus($collaborator_id,$status,Request $request)
    {

     //   $author_id = $request->author_id;
     
     
     $job_collaborator = JobCollaborator::where('user_id', $collaborator_id)
     ->where("status", $status)
     ->orderBy('created_at', 'desc')
     ->get();

        return redirect()->back();
    }



    public function getAuthorJobByStatus($author_id,$status)
    {
        $user_pending_jobs = Job::where('user_id', $author_id)
        ->where('status',$status)
        ->orderBy('created_at','desc')  
        ->get();
        // dd($user_pending_jobs);
        return view('page.pages.quanlyvieclam',['jobs'=>$user_pending_jobs]);
    }
    public function chitietcongviec($job_id){
    
        $job = Job::where('id',$job_id)->first();
        $job_images = DB::table('images')->where('job_id',$job->id)->get();
        $job_images_array = $job_images->pluck('image_url')->toArray();
        $candidates = $job->candidates();
        // dd($candidates);
        return view('page.pages.chitietcongviec',[
            'job'=>$job,
            'job_images_array'=>$job_images_array,
            'candidates'=>$candidates,
            

        ]);
            
    }
    public function postxacnhan(Request $request){
    //  dd($request->all());
        try {


            DB::beginTransaction();
            $job_collaborators_cancel = JobCollaborator::where('job_id', $request->job_id)
                ->where('id', '!=', $request->job_collaborator_id)
                ->get();


            foreach ($job_collaborators_cancel as $job_collaborator) {
                # code...

                $job_collaborator->status = JobCollaborator::CANCEL;
                $job_collaborator->update();
            }


            $job_collaborator_approve = JobCollaborator::where('id', $request->job_collaborator_id)
                ->first();
            $job_collaborator_approve->status = JobCollaborator::APPROVED;
            $job_collaborator_approve->update();

            $job = Job::where('id', $request->job_id)->first();
            $job->status = Job::APPROVED;
            $job->update();

            DB::commit();
            return redirect()->back()->with('success','Sửa thành công');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('failed','Sửa thất bại!');
    
    
}
    }
}