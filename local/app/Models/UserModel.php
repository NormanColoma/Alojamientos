<?php

namespace App\Models;

use App\Models\DTO\Admin;
use App\Models\DTO\Commentary;
use App\Models\DTO\Owner;
use App\Models\DTO\Traveler;
use Illuminate\Database\Eloquent\Model;
use App\Models\DTO\AbstractUser;
use App\Models\DTO\Booking;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\QueryException;
use DB;

class UserModel extends Model implements AuthenticatableContract, CanResetPasswordContract, IDAOUser
{
    use Authenticatable, CanResetPassword;

    //Tabla con la que se interactua y se bindea el modelo
    protected $table = 'users';

    //Por defecto laravel crea dos campos timestamps, en este caso no los queremos
    public $timestamps = false;

    //Cuando hacemos una asignación múltiple (mass assignament), necesitamos especificar un array con los campos
    protected $fillable = array('name', 'password', 'email', 'surname', 'phone', 'owner', 'admin');


    /**
     * Recibe el AbstractUser que será insertado en la bd. Si el usuario no existe (no está ya ese email registrado)
     * lo inserta en la bd y devuelve el objeto. Si existe, lo devolverá null.
     *
     * @param  AbstractUser $user
     * @return AbstractUser
     */
    public function createUser(AbstractUser $user)
    {
        $u = null;
            try {
                $u = UserModel::create([
                    'name' => $user->getName(),
                    'password' => bcrypt($user->getPassword()),
                    'email' => $user->getEmail(),
                    'surname' => $user->getSurname(),
                    'phone' => $user->getPhone(),
                    'owner' => $user->getOwner(),
                    'admin' => $user->getAdmin(),
                ]);
            }catch(QueryException $ex){
                return null;
            }
        return $u;
    }

    /**Recibe el AbstractUser que será actualizado en la bd.
     *
     * @param $id
     * @param AbstractUser $user
     * @return bool
     */
    public function updateUser($id, AbstractUser $user)
    {
        $u = null;
        try {
            $u = UserModel::where('id', $id)
                ->update([
                    'name' => $user->getName(),
                    'password' => bcrypt($user->getPassword()),
                    'email' => $user->getEmail(),
                    'surname' => $user->getSurname(),
                    'phone' => $user->getPhone(),
                ]);

            if($u!=null)
                return true;
            return false;
        }catch(QueryException $ex){
            return false;
        }
    }

    public function deleteUser($id)
    {

    }


    public function userByEmail($email)
    {
        try{
            $email = DB::table('users')->where('email', $email)->get();
            if($email == null){
                return false;
            }
            return true;
        }catch(QueryException $ex){
            return false;
        }
    }

    public function userByName($name)
    {

    }

    public function getUserByEmail($email)
    {
        $users = null;
        $user = null;
        try{
            $users = DB::table('users')->where('email', $email)->get();
            if($users == null){
                return null;
            }

            foreach($users as $u) {
                if(!$u->admin && !$u->owner)
                    $us = new Traveler();
                else if($u->owner)
                    $us = new Owner();
                else
                    $us = new Admin();
                $us->setEmail($u->email);
                $us->setName($u->name);
                $us->setSurname($u->surname);
                $us->setPhone($u->phone);
                $us->setId($u->id);
                $user = $us;
            }
        }catch(QueryException $ex){
            throw new \Exception($ex);
        }

        return $user;
    }

    public function userById($id, $type)
    {
        $users = null;
        $user = null;
        try{
            $users = DB::table('users')->where('id', $id)->get();
            if($users == null){
                return null;
            }

            foreach($users as $u) {
                if($type == "traveler")
                    $us = new Traveler();
                else if($type == "owner")
                    $us = new Owner();
                else
                    $us = new Admin();
                $us->setEmail($u->email);
                $us->setName($u->name);
                $us->setSurname($u->surname);
                $us->setPhone($u->phone);
                $us->setId($id);
                $user = $us;
            }
        }catch(QueryException $ex){
           throw new \Exception($ex);
        }

        return $user;
    }

    public function allBookings($user)
    {
        $bookings = [];
        $books = null;
        try{
            $books = DB::table('bookings')->select('*')
                ->where('user_id', $user)->where('prebooking', 0)->orderBy("booking_date", "desc")
                ->get();

            if($books == null)
                return null;

            foreach($books as $bk) {
                $b = new Booking();
                $b->setId($bk->id);
                $b->setPersons($bk->persons);
                $b->setPrice($bk->total_price);
                $b->setPreBooking($bk->prebooking);
                $b->setCheckIn($bk->check_in);
                $b->setCheckOut($bk->check_out);
                $b->setUserId($bk->user_id);
                $b->setAccommId($bk->accommodation_id);
                $b->setOwnerId($bk->owner_id);
                $bookings[] = $b;
            }
        }catch(QueryException $ex){
            throw new \Exception("No existen reservas.");
        }

        return $bookings;

    }

    public function allBookingsByOwner($owner)
    {
        $bookings = [];
        $books = null;
        try{
            $books = DB::table('bookings')->select('*')
                ->where('owner_id', $owner)->where('prebooking', 0)->orderBy("booking_date", "desc")
                ->get();

            if($books == null)
                return null;

            foreach($books as $bk) {
                $b = new Booking();
                $b->setId($bk->id);
                $b->setPersons($bk->persons);
                $b->setPrice($bk->total_price);
                $b->setPreBooking($bk->prebooking);
                $b->setCheckIn($bk->check_in);
                $b->setCheckOut($bk->check_out);
                $b->setUserId($bk->user_id);
                $b->setAccommId($bk->accommodation_id);
                $b->setOwnerId($bk->owner_id);
                $bookings[] = $b;
            }
        }catch(QueryException $ex){
            throw new \Exception("No existen reservas.");
        }

        return $bookings;

    }

    public function allPreBookings($user)
    {

        $bookings = [];
        $books = null;
        try{
            $books = DB::table('bookings')->select('*')
                ->where('user_id', $user)->where('prebooking', 1)->orderBy("booking_date", "desc")
                ->get();

            if($books == null)
                return null;

            foreach($books as $bk) {
                $b = new Booking();
                $b->setId($bk->id);
                $b->setPersons($bk->persons);
                $b->setPrice($bk->total_price);
                $b->setPreBooking($bk->prebooking);
                $b->setCheckIn($bk->check_in);
                $b->setCheckOut($bk->check_out);
                $b->setUserId($bk->user_id);
                $b->setOwnerId($bk->owner_id);
                $b->setAccommId($bk->accommodation_id);
                $bookings[] = $b;
            }
        }catch(QueryException $ex){
            throw new \Exception("No existen reservas.");
        }

        return $bookings;

    }

    public function allPreBookingsByOwner($owner)
    {

        $bookings = [];
        $books = null;
        try{
            $books = DB::table('bookings')->select('*')
                ->where('owner_id', $owner)->where('prebooking', 1)->orderBy("booking_date", "desc")
                ->get();

            if($books == null)
                return null;

            foreach($books as $bk) {
                $b = new Booking();
                $b->setId($bk->id);
                $b->setPersons($bk->persons);
                $b->setPrice($bk->total_price);
                $b->setPreBooking($bk->prebooking);
                $b->setCheckIn($bk->check_in);
                $b->setCheckOut($bk->check_out);
                $b->setUserId($bk->user_id);
                $b->setOwnerId($bk->owner_id);
                $b->setAccommId($bk->accommodation_id);
                $bookings[] = $b;
            }
        }catch(QueryException $ex){
            throw new \Exception("No existen reservas.");
        }

        return $bookings;

    }

    public function getID($email){

        $user = UserModel::where('email', $email)->first();

        return (int)$user['id'];

    }

    public function insertCommentary(Commentary $commentary){
        $commentary_id = null;
        try {
            $commentary_id = DB::table('commentaries')->insertGetId(
                ['text' => $commentary->getText(), 'stars' => $commentary->getVote(), 'user_id' => $commentary->getUserId(),
                    'accom_id' => $commentary->getAccomId(), 'created_at' => $commentary->getDate()]
            );
        }catch(QueryException $ex){
            throw new \Exception($ex->getMessage());
        }

        return $commentary_id;
    }

    public function allCommentaries($traveler_id){
        $commentaries = [];
        $commentary = null;
        try{
            $commentary = DB::table('commentaries')->select('*')
                ->where('user_id', $traveler_id)->orderBy("created_at", "asc")
                ->get();

            if($commentary == null)
                return null;

            foreach($commentary as $c) {
                $comm = new Commentary();
                $comm->setId($c->id);
                $comm->setAccomId($c->accom_id);
                $comm->setUserId($c->user_id);
                $comm->setAuthor($this->userById($c->user_id,"traveler"));
                $comm->setDate($c->created_at);
                $comm->setVote($c->stars);
                $comm->setText($c->text);
                $commentaries[] = $comm;
            }
        }catch(QueryException $ex){
            throw new \Exception($ex->getMessage());
        }

        return $commentaries;
    }

    public function getCommentary($id){
        $commentaries = [];
        $commentary = null;
        try{
            $commentary = DB::table('commentaries')->select('*')
                ->where('id', $id)->orderBy("created_at", "asc")
                ->get();

            if($commentary == null)
                return null;

            foreach($commentary as $c) {
                $comm = new Commentary();
                $comm->setId($c->id);
                $comm->setAccomId($c->accom_id);
                $comm->setUserId($c->user_id);
                $comm->setAuthor($this->userById($c->user_id,"traveler"));
                $comm->setDate($c->created_at);
                $comm->setVote($c->stars);
                $comm->setText($c->text);
                $commentaries[] = $comm;
            }
        }catch(QueryException $ex){
            throw new \Exception($ex->getMessage());
        }

        return $commentaries[0];
    }
}