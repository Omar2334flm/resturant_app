<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Table;


class ReservationController extends Controller
{
    public function stepOne (Request $request){

          $reservations= $request->session()->get('reservation');
        return view ('reservations.step-one',compact('reservations'));
    }
    
    public function StorestepOne(Request $request){
              
        $validated = $request->validate([
            "first_name"=>'required',
            "last_name"=>'required',
            "email"=>'required',
            "tel_number"=>'required',
            "res_date"=>'required',
            "guest_number"=>'required',

        ]);
        if(empty($request->session()->get('reservation'))){

            $reservation =new Reservation();
            $reservation->fill($validated);
            $request->session()->put('reservation',$reservation);


        }else{
            $reservation =$request->session()->get('reservation');
            $reservation->fill($validated);
            $request->session()->put('reservation',$reservation);
        }
        return to_route('reservation.step.two');
    }
    public function stepTwo (Request $request){
         
        $reservations= $request->session()->get('reservation');
        $tables=Table::all();

      return view ('reservations.step-two',compact('reservations','tables'));
  }
  public function StorestepTwo(Request $request){
    $validated = $request->validate([
        "table_id"=>'required',
        ]);
        $reservation = $request->session()->get('reservation');
        $reservation->fill($validated);
           $reservation->save();

           $request->session()->forget('reservation');
           return to_route('thankyou');


}
}
