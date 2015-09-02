<?php

namespace App\Http\Controllers;

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
            $this->sendPreBookingEmail();
        }else{
            flash()->error("Debes seleccionar las fechas para poder realizar la prereserva");
            return redirect("accommodation/".$id ."/details");
        }

    }


    public function sendPreBookingEmail(){
        $user = Auth::user();
        Mail::send('emails.prebooking', ['user' => $user, 'prueba' => 'paco'], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Prereserva realizada');
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
