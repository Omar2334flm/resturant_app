<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Http\Requests\TableStoreRequest;
use App\Enums;


class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables=table::all();
        return view ('admin.tables.index',compact('tables'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(table $table)
    {
        return view ('admin.tables.create',compact('table'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response 
     */
    public function store(TableStoreRequest $request)
    {
        Table::create([
            'name'=>$request->name,
            'guest_number'=>$request->guest_number,
            'status'=>$request->status,
            'location'=>$request->location 
        ]);
        return redirect()->route('admin.tables.index')->with('success','table created succefully');

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
    public function edit(table $table)
    {
        return view ('admin.tables.edit' ,compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function update(TableStoreRequest $request,table $table)
    {

        $validated = $request->validate([
            'name' => 'required|unique:tables|max:255',
            'status' => 'required',
            'guest_number' =>'required',
            'location' =>'required'

        ]);
        $table->update([
            'name'=>$request->name,
            'guest_number'=>$request->guest_number,
            'status'=>$request->status,
            'location'=>$request->location 
        ]);
        return redirect()->route('admin.tables.index')->with('success','table updated succefully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(table $table)
    {
        $table->delete();
        $table->reservations()->delete();
        return redirect()->route('admin.tables.index')->with('danger','table deleted succefully');


    }
}
