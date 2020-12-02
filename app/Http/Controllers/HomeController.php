<?php

namespace App\Http\Controllers;
use App\Model\Category;
use App\Model\Occupation;
use App\Model\Job;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     * inate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $categories = Category::all();
        $occupation = Occupation::all();
        $jobs = Job::all();
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
    public function shop_detail()
    {
        return view('page.pages.shop_detail');
    }
    public function joblist()
    {   $job =Job::all();
        //dd($job);
        return view('page.pages.joblist',['job'=>$job]);
    }
    public function collaborators()
    {
        $collaborators_all = User::all();
        //echo($collaborators_all);
        return view('page.pages.listcollaborator', ['collaborators_all'=>$collaborators_all] );
    }
}