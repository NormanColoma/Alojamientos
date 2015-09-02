<?php

namespace App\Http\Controllers;

use App\Models\AccommodationModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createBookingPrebooking(Request $request, $id)
    {
        if($request->has("check-in") && $request->has("check-out")){
            //TODO Implement logic for create booking or prebooking
            $am = new AccommodationModel();
            $owner = $am->getOwner($id);
            $this->sendPreBookingEmail($request->input("message"),$owner,$request->input("check-in"), $request->input("check-out"),$request->input("check-out"), $request->input("persons"));
        }else{
            flash()->error("Debes seleccionar las fechas para poder realizar la prereserva");
            return redirect("accommodation/".$id ."/details");
        }

    }


    public function sendPreBookingEmail($message, $owner, $check_in, $check_out, $capacity){
        $user = Auth::user();
        Mail::send('emails.prebooking', ['check_in' => $check_in, 'check_out' => $check_out, 'owner' => $owner], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Prereserva realizada');
        });

        Mail::send('emails.prebooking_owner', ['capacity' => $capacity, 'text' => $message, 'check_in' => $check_in, 'check_out' => $check_out], function ($m) use ($owner) {
            $m->to($owner->getEmail(), $owner->getName())->subject('Nueva prereserva');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
