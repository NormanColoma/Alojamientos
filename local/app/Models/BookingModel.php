<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 01/09/2015
 * Time: 18:16
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DTO\Booking;
use App\Models\DTO\PreBooking;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\QueryException;
use DB;

class BookingModel extends Model implements AuthenticatableContract, CanResetPasswordContract, IDAOBooking
{

    use Authenticatable, CanResetPassword;

    //Tabla con la que se interactua y se bindea el modelo
    protected $table = 'bookings';

    //Por defecto laravel crea dos campos timestamps, en este caso no los queremos
    public $timestamps = false;

    //Cuando hacemos una asignación múltiple (mass assignament), necesitamos especificar un array con los campos
    protected $fillable = array('persons', 'total_price', 'booking_date', 'prebooking','user_id', 'accommodation_id', 'check-in', 'check-out');

    /**
     * Recibe un objeto del tipo booking y lo inserta en la base de datos siempre y cuando
     * no exista una reserva ya para el usuario (pasado en el atributo user_id de Booking)
     * entre las fechas check_in y check_out. Es decir, si ya tiene una reserva hecha con
     * fecha inicial 2015/15/10 y fecha final 2015/19/10, no podrá tener otra reserva en ese intervalo.
     * Para el caso de una prereserva, si podrá tener más de una, por lo que primero comprobamos si Booking
     * es prebooking o no.
     * @param Booking $booking
     * @return null
     * @throws \Exception
     */
    public function createBooking(Booking $booking){

        $b = null;

        try {

            if($booking->getPreBooking()){
                $b = DB::table('bookings')->insertGetId([
                    'persons' => $booking->getPersons(),
                    'total_price' => $booking->getPrice(),
                    'booking_date' => $booking->getDate(),
                    'prebooking' => $booking->getPreBooking(),
                    'user_id' => $booking->getUserId(),
                    'accommodation_id' => $booking->getAccommId(),
                    'check_in' => $booking->getCheckIn(),
                    'check_out' => $booking->getCheckOut(),
                ]);
            }else{

                $book = DB::table('bookings')
                    ->where('user_id', '=', $booking->getUserId())
                    ->where('check_out', '>=', $booking->getCheckIn())
                    ->first();

                //No existen reservas para esa fecha
                if(is_null($book)){
                    $b = DB::table('bookings')->insertGetId([
                        'persons' => $booking->getPersons(),
                        'total_price' => $booking->getPrice(),
                        'booking_date' => $booking->getDate(),
                        'prebooking' => $booking->getPreBooking(),
                        'user_id' => $booking->getUserId(),
                        'accommodation_id' => $booking->getAccommId(),
                        'check_in' => $booking->getCheckIn(),
                        'check_out' => $booking->getCheckOut(),
                    ]);
                }
            }

        }catch(QueryException $ex){
            throw new \Exception("Ha fallado la inserción");
        }

        return $b;
    }

    /**
     * Recibimos el objeto booking a modificar. Solo se podrá modificar el precio de la reserva.
     * @param Booking $booking
     * @param $id
     * @return bool
     */
    public function updateBooking(Booking $booking, $id){

        $b = null;
        try {
            $b = BookingModel::where('id', $id)
                ->update([
                    'total_price' => $booking->getPrice(),
                ]);

            if($b!=null)
                return true;
            return false;
        }catch(QueryException $ex){
            return false;
        }
    }
    public function deleteBooking($id){

        try {
            $deletedRows = BookingModel::where('id', $id)->delete();

            if($deletedRows == 0)
                return false;

            return true;
        }catch(QueryException $ex){
            return false;
        }
    }
    public function showBooking($id){

        $booking = null;
        $book = new Booking();

        try{
            $booking = DB::table('bookings')->select('*')
                ->where('id', $id)->where('prebooking', 0)
                ->get();

            if($booking == null){
                return null;
            }

            foreach($booking as $bc) {
                $b = new Booking();
                $b->setAccommId($bc->accommodation_id);
                $b->setUserId($bc->user_id);
                $b->setPrice($bc->total_price);
                $b->setPersons($bc->persons);
                $b->setId($bc->id);
                $b->setPreBooking($bc->prebooking);
                $b->setCheckIn($bc->check_in);
                $b->setCheckOut($bc->check_out);
                $book = $b;
            }
        }catch(QueryException $ex){
            throw new \Exception("No existe el alojamiento");
        }

        return $book;

    }
    public function showPreBooking($id){

        $booking = null;
        $book = new Booking();

        try{
            $booking = DB::table('bookings')->select('*')
                ->where('id', $id)
                ->where('prebooking', 1)
                ->get();

            if($booking == null){
                return null;
            }

            foreach($booking as $bc) {
                $b = new Booking();
                $b->setAccommId($bc->accommodation_id);
                $b->setUserId($bc->user_id);
                $b->setPrice($bc->total_price);
                $b->setPersons($bc->persons);
                $b->setId($bc->id);
                $b->setPreBooking($bc->prebooking);
                $b->setCheckIn($bc->check-in);
                $b->setCheckOut($bc->check-out);
                $b->setBookingTime($bc->booking_date);
                $book = $b;
            }
        }catch(QueryException $ex){
            throw new \Exception("No existe el alojamiento");
        }

        return $book;

    }
    public function confirm($id){

    }

}