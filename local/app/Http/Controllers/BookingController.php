<?php

namespace App\Http\Controllers;


use App\Models\BookingModel;
use App\Models\DTO\Booking;
use App\Models\AccommodationModel;
use App\Models\DTO\Message;
use App\Models\SystemModel;
use App\Models\UserModel;
use Illuminate\Database\QueryException;
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

            $bm = new BookingModel();
            $am = new AccommodationModel();
            $accomm = $am->accommodationByID($id);
            $owner = $am->getOwner($id);

            $booking = new Booking();
            $booking->setAccommId($id);
            $booking->setCheckIn($request->input("check-in"));
            $booking->setCheckOut($request->input("check-out"));
            $booking->setUserId(Auth::user()->id);
            $booking->setPersons($request->input("persons"));
            $booking->setPrice($accomm->getPrice()*$booking->getPersons());
            $booking->setOwnerId($am->getOwner($id)->getId());
            if($bm->createBooking($booking)){
                $this->sendPreBookingEmail($request->input("message"),$owner,$request->input("check-in"), $request->input("check-out"), $request->input("persons"), $id);
                flash()->overlay("Tu prereserva ha sido realizada correctamente. Por favor accede a tu panel de control y comprúebalo.","Preserva realizada");
                return redirect("/manage/traveler");
            }
            else{
                flash()->error("No se ha podido realizar la reserva.");
                return redirect("accommodation/".$id ."/details");
            }



        }else{
            flash()->error("Debes seleccionar las fechas para poder realizar la prereserva");
            return redirect("accommodation/".$id ."/details");
        }

    }


    public function sendPreBookingEmail($message, $owner, $check_in, $check_out, $capacity, $id){
        $user = Auth::user();
        try {
            Mail::send('emails.prebooking', ['check_in' => $check_in, 'check_out' => $check_out, 'owner' => $owner, 'id' => $id], function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Prereserva realizada');
            });

            Mail::send('emails.prebooking_owner', ['capacity' => $capacity, 'text' => $message, 'check_in' => $check_in, 'check_out' => $check_out, 'id' => $id], function ($m) use ($owner) {
                $m->to($owner->getEmail(), $owner->getName())->subject('Nueva prereserva');
            });
        }catch(\Exception $ex){
            throw new \Exceptionx($ex->getMessage());
        }

        try{
            $m_owner = new Message();
            $m_owner->setFrom($user->name ." " . $user->surname);
            $m_owner->setTo($owner->getEmail());
            $m_owner->setText($message);
            $m_owner->setSubject('Nueva prereserva');
            $m_owner->setType("pb");
            $sm = new SystemModel();
            $sm->addMessage($m_owner, $owner->getId());
        }catch (QueryException $ex){
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showPrebooking($id)
    {
        $bm = new BookingModel();
        $b = $bm->showPreBooking($id);
        if($b != null){
            $um = new UserModel();
            $owner = $um->userById($b->getOwnerId(), "owner");
            $traveler = $um->userById($b->getUserId(), "traveler");
            return response()->json(['ok' => true, 'message' => 'Booking was retrieved', 'id' => $b->getId(),
                'check_in'=> $b->getCheckIn(), 'check_out' => $b->getCheckOut(), 'traveler' => $b->getUserId(),
                'traveler_email' => $traveler->getEmail(), 'traveler_name' => $traveler->getName() ." ". $traveler->getSurname(),
                'traveler_phone' => $traveler->getPhone(), 'owner_email' => $owner->getEmail(), 'owner_name' => $owner->getName() ." " . $owner->getSurname(),
                'owner_phone' => $owner->getPhone(),'owner' => $b->getOwnerId(), 'accomm' => $b->getAccommId(), 'date' => $b->getDate(),
                'persons' => $b->getPersons(), 'price' => $b->getPrice()], 200);
        }
        else
            return response()->json([ 'ok' => false, 'message' => 'Prebooking was not found or was removed' ], 404);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showBooking($id)
    {
        $bm = new BookingModel();
        $b = $bm->showBooking($id);
        if($b != null){
            $um = new UserModel();
            $owner = $um->userById($b->getOwnerId(), "owner");
            $traveler = $um->userById($b->getUserId(), "traveler");
            return response()->json(['ok' => true, 'message' => 'Booking was retrieved', 'id' => $b->getId(),
                'check_in'=> $b->getCheckIn(), 'check_out' => $b->getCheckOut(), 'traveler' => $b->getUserId(),
                'traveler_email' => $traveler->getEmail(), 'traveler_name' => $traveler->getName() ." ". $traveler->getSurname(),
                'traveler_phone' => $traveler->getPhone(), 'owner_email' => $owner->getEmail(), 'owner_name' => $owner->getName() ." " . $owner->getSurname(),
                'owner_phone' => $owner->getPhone(),'owner' => $b->getOwnerId(), 'accomm' => $b->getAccommId(), 'date' => $b->getDate(),
                'persons' => $b->getPersons(), 'price' => $b->getPrice()], 200);
        }
        else
            return response()->json([ 'ok' => false, 'message' => 'Booking was not found or was removed' ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function confirmBooking($id)
    {
       $bm = new BookingModel();
        if($bm->confirm($id)){
            flash()->overlay("Su rserva ha sido confirmada. Puede verificarlo desde sus reservas en el panel de control", "Reserva Confirmada");
            return redirect("manage/traveler");
        }
        else{
            return view("errors/503");
        }
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
    public function deletePrebooking($id)
    {
        $bm = new BookingModel();
        if($bm->deleteBooking($id)){
            return response()->json([ 'ok' => true, 'message' => 'Prebooking was removed' ], 200);
        }
        else{
            return response()->json([ 'ok' => false, 'message' => 'Prebooking was not found or was removed' ], 404);
        }
    }
}
