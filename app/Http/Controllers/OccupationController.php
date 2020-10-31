<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Occupation;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $occupations = Occupation::orderBy('name','desc')->get();
        return view('admin.occupation.index',['occupations'=>$occupations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();

        return view('admin.occupation.create',['categories'=>$categories]);
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
                'filepath'=>'nullable',
                'category_id'=>'required'
            ],[
                'name.required' => 'Please enter  name!',
                'slug.required' => 'Please enter slug!',
                'status.required'=> 'Please choose status!',
                'name.unique' => 'name was exists!',
                'category_id.required'=>'Please choose category'
            ]);


            $occupation = new Occupation($validatedData);
            $occupation->image = $validatedData['filepath'];
            $occupation->category_id = $validatedData['category_id'];
            $occupation->save();

            return redirect()->route('occupation.index');

        } catch (\Throwable $th) {
            throw $th;
            // return redirect()->route('category.index');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Occupation  $occupation
     * @return \Illuminate\Http\Response
     */
    public function show(Occupation $occupation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Occupation  $occupation
     * @return \Illuminate\Http\Response
     */
    public function edit(Occupation $occupation)
    {
        //
        return view('admin.occupation.edit',['occupation'=>$occupation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Occupation  $occupation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Occupation $occupation)
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
                'name.required' => 'Please enter name!',
                'slug.required' => 'Please enter slug!',
                'status.required'=> 'Please choose status!',
                'name.unique' => 'Category name was exists!',
            ]);


            $occupation->name = $validatedData['name'];
            $occupation->slug = $validatedData['slug'];
            $occupation->status = $validatedData['status'];
            $occupation->image = $validatedData['filepath'];
            $occupation->update();

            return redirect()->back()->with('success','Updated Successfully.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Occupation  $occupation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Occupation $occupation)
    {
        //
        try {
            //code...
            $occupation->delete();
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
                Occupation::whereIn('id',$ids)->delete();

            }
            return response(['status'=>true,'data'=>$ids],200);

        } catch (\Throwable $th) {
            //throw $th;
            return response(['status'=>false],404);
        }
    }
}
