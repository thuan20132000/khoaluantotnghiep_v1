<?php

namespace App\Http\Controllers;
use App\Model\Category;
use App\Model\Occupation;
use App\Model\Job;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
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
        dd($users);
        return view('page.pages.listuser', ['users'=>$users] );
    }
    public function listJob(){
        $job =Job::all();
        //dd($job);
        return view('page.pages.listJob',['job'=>$job]);

    }
    public function jobCategory($id){
        $job = Occupation::where('category_id',$id)->get();
        return view('page.pages.jobCategory',['job'=>$job]);
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
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->name = $request->name;
            $user->phonenumber = $request->phonenumber;
            $user-> profile_image = $request -> profile_image ;
            $user->save();
            $user->roles()->attach($request->role);

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
                ->orWhere('suggestion_price',$req->key)
                ->get();
                return view ('page.pages.search',['job'=>$job]);
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
                'occupation' => 'required',
                'address' => 'required|min:3|max:32',
                'description' => 'required',
            ],
            [
                'name.required' => 'Bạn chưa nhập họ và tên',
                'name.min' => 'Họ và tên chứa từ 3-32 kí tự',
                'name.max' => 'Họ và tên chứa từ 3-32 kí tự',
                'occupation.required' => 'Bạn chưa chọn lĩnh vực',
                
                'address.required' => 'Bạn chưa nhập địa chỉ',
                'description.required' => 'Bạn chưa nhập mô tả ',
                
            
            ]
        );                                                                                                                          
        try {
            DB::beginTransaction();
            $location_id = DB::table('location')->insertGetId(
                array(
                
            
                    
                    'address'=>$request->address
                    
                )
            );
            //code...
            $job = new Job();
            $job->occupation = $request->occupationail;
            $job->name = $request->name;
            $job->address = $request->address;
            $job-> profile_image = $request -> profile_image ;
            dd($job);
            $job->save();
        

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('failed','Đăng thất bại');
        }

        return redirect()->back()->with("success","Register Success");
    }
    
    
}