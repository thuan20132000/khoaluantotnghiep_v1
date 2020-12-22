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
use App\Http\Controllers\Role;
class HomeController extends Controller
{
    
    public function index()

    {   
        $categories = Category::all();
        $occupation = Occupation::all();
        $jobs = Job::all();
        // foreach($jobs as $job) {
        //     $job_images = DB::table('images')->where('job_id',$job->id)->get();
        //     dd($job_images);
        //     $job_images_array = $job_images->pluck('image_url')->toArray();
        // }
       
        // $job_images = DB::table('images');
        
    
     
        
        // $job_images_array = $job_images->pluck('image_url')->toArray();
       
        // $candidates = $job->candidates();

        //dd($jobs);

        return view('page.pages.index',['categories'=>$categories,'occupation'=>$occupation,'jobs'=>$jobs]);
    }



    public function checkout()
    {
        return view('page.pages.checkout');
    }
    public function shoppingcart()
    {
        return view('page.pages.shoppingcart');
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
            return redirect('/home');
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
        try {
            //code...
           // dd($request->all());
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->address = $request->address;
            $user->phonenumber = $request->phonenumber;
            $user-> profile_image = $request -> profile_image ;
            $user->save();
            $user->roles()->attach($request->role);
            // dd($user);

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
        $job_id = $request->job;
        $collaborator_id = $request->user;

        $check_duplicate = JobCollaborator::where('job_id',$job_id)
                            ->where('user_id',$collaborator_id)->count();
        if($check_duplicate > 0){
            return redirect()->back()->with('failed','Collaborator was exists in this job!');
        }


        $job_colaborator = new JobCollaborator();
        $job_colaborator->description = $request->description;
        $job_colaborator->user_id = $request->user;
        $job_colaborator->expected_price = $request->price;
        $job_colaborator->job_id = $request->job;
        $job_colaborator->status = 0;
        
        
        $job_colaborator->save();

        return redirect()->route( )->with('success','Create Successfully');
    } catch (\Throwable $th) {
        throw $th;
        return redirect()->back()->with('failed','Create failed!');

    }

}
}