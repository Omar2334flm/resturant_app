<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;


use App\Http\Requests\MenuStoreRequest;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $menus =Menu::all();
        return view ('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        $categories=category::all();
        return view ('admin.menus.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        $image =$request->file('image')->store('public/images');
        $menu=Menu::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image' =>$image,
            'price' =>$request->price
        ]);

        if ($request->has('categories')){
            $menu->categories()->attach($request->categories);
        }
            else{
                return response('failed');
            };
        return redirect()->route('admin.menus.index')->with('success','menu created succefully');
        
        
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
    public function edit(menu $menu)

    {         
          $categories=category::all();
            return view('admin.menus.edit',compact('menu','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,menu $menu)
    {
       
        $image=$menu->image;
        if ($request->hasFile('image')){
            Storage::delete([$menu->image]);
            $image =$request->file('image')->store('public/images');
        }
        $menu->update([

            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$image,
            'price'=> $request->price,
        ]);
        if ($request->has('categories')){
            $menu->categories()->sync($request->categories);
        }
        return redirect()->route('admin.menus.index')->with('success','menu updated succefully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(menu $menu)
    {
        Storage::delete($menu->image);
        $menu->categories()->detach();
        $menu->delete();        
        return redirect()->route('admin.menus.index')->with('danger','menu deleted succefully');

        

    }
}
