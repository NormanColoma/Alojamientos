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
                //TODO implement logic for booking
            }else{
                //TODO implement logic for prebooking
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

    }
    public function showPreBooking($id){

    }
    public function confirm($id){

    }

}