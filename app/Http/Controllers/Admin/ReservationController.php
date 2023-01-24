<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;
use App\Http\Requests\ReservationStoreRequest;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations=Reservation::all();
        return view ('admin.reservation.index',compact('reservations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           $tables=Table::all();
           return view('admin.reservation.create' ,compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request)
    {
         $table=Table::findOrFail($request->table_id);
         if($request->guest_number > $table->guest_number){
            return back()->with('warning','choose table with more seats');
         }
        reservation::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'tel_number'=>$request->tel_number,
            'res_date'=>$request->res_date,
            'guest_number'=>$request->guest_number,
            'table_id'=>$request->table_id,


        ]);
return redirect()->route('admin.reservation.index')->with('success','reservation created succefully');
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
    public function edit(reservation $reservation)

    {
        $tables=Table::all();
        return view('admin.reservation.edit',compact('reservation','tables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reservation $reservation)
    {
        $reservation->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'tel_number'=>$request->tel_number,
            'res_date'=>$request->res_date,
            'guest_number'=>$request->guest_number,
            'table_id'=>$request->table_id,
        ]);
        return redirect()->route('admin.reservation.index')->with('success','reservation updated succefully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation=Reservation::find($id)->delete();
        return redirect()->route('admin.reservation.index')->with('danger','reservation deleted succefully');

    }
}
