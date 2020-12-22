<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::orderBy('name','desc')->get();
        // dd($categories);
        return view('admin.category.index',['categories'=>$categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.category.create');
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
            $validatedData =  $request->validate([
                'name' => 'required|unique:categories|max:255',
                'slug' => 'required',
                'status' => 'required',
                'filepath'=>'nullable'
            ],[
                'name.required' => 'Please enter category name!',
                'slug.required' => 'Please enter slug!',
                'status.required'=> 'Please choose status!',
                'name.unique' => 'Category name was exists!',
            ]);


            $category = new Category($validatedData);
            $category->image = $validatedData['filepath'];
            $category->save();

            return redirect()->route('category.index');





        } catch (\Throwable $th) {
            throw $th;
        }





    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return view('admin.category.show',['category'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('admin.category.edit',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        try {
            //code...
            $validatedData =  $request->validate([
                'name' => 'required|max:255',
                'slug' => 'required',
                'status' => 'required',
                'filepath'=>'nullable'
            ],[
                'name.required' => 'Please enter category name!',
                'slug.required' => 'Please enter slug!',
                'status.required'=> 'Please choose status!',
                'name.unique' => 'Category name was exists!',
            ]);


            $category->name = $validatedData['name'];
            $category->slug = $validatedData['slug'];
            $category->status = $validatedData['status'];
            $category->image = $validatedData['filepath'];
            $category->update();

            return redirect()->back()->with('success','Updated Success fully.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        try {
            //code...
            $category->delete();
            return redirect()->back()->with('success','Delete successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * remove mass category
     */
    public function destroyMass(Request $request)
    {
        try {
            //code...
            $ids = $request->input('ids');
            if(count($ids) > 0 ){
                Category::whereIn('id',$ids)->delete();

            }
            return response(['status'=>true,'data'=>$ids],200);

        } catch (\Throwable $th) {
            //throw $th;
            return response(['status'=>false],404);
        }
    }
}
