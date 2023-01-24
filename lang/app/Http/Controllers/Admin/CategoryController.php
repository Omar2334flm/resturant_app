<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;        
use App\Http\Requests\CategoryStoreRequest;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
         $categories=Category::all();
        return view ('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $image=$request->file('image')->store('public/images');
        Category::create([
            "name"=>$request->name,
            'image'=>$image,
            'description'=>$request->description,
        ]);
        return redirect()->route('admin.categories.index')->with('success','category created succefully');
        
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)

    {

        return view ('admin.categories.edit',compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,category $category)
    {

      
        $image=$category->image;
        if ($request->hasFile('image')){
            Storage::delete([$category->image]);
            $image =$request->file('image')->store('public/images');
        }
        $category->update([

            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$image
        ]);
        return redirect()->route('admin.categories.index')->with('success','category updated succefully');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        Storage::delete($category->image);
        $category->menus()->detach();

        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success','category deleted succefully');

    }
}
