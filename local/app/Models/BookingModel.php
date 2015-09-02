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

class BookingModel extends Model implements AuthenticatableContract, CanResetPasswordContract, IDAOBooking
{

    use Authenticatable, CanResetPassword;

    //Tabla con la que se interactua y se bindea el modelo
    protected $table = 'bookings';

    //Por defecto laravel crea dos campos timestamps, en este caso no los queremos
    public $timestamps = false;

    //Cuando hacemos una asignación múltiple (mass assignament), necesitamos especificar un array con los campos
    protected $fillable = array('persons', 'total_price', 'booking_date', 'user_id', 'accommodation_id');

    public function createBooking(Booking $booking, $userId, $accommId){

        $b = null;
        try {
            $b = BookingModel::create([
                'persons' => $booking->getPersons(),
                'total_price' => $booking->getPrice(),
                'booking_date' => $booking->getDate(),
                'user_id' => $userId,
                'accommodation_id' => $accommId,
            ]);

        }catch(QueryException $ex){
            throw new \Exception("Ha fallado la inserción");
        }

        return $b;
    }
    public function updateBooking(Booking $booking, $id){

        $b = null;
        try {
            $b = BookingModel::where('id', $id)
                ->update([
                    'persons' => $booking->getPersons(),
                    'total_price' => $booking->getPrice(),
                    'booking_date' => $booking->getDate(),
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
    public function showBooking(){}
    public function showPreBooking(){}
    public function confirm($id){}

}