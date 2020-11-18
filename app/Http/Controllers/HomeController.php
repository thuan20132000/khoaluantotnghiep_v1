<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
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
    public function shoplist()
    {
        return view('page.pages.shoplist');
    }


}
