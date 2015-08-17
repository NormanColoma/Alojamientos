<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 17/08/2015
 * Time: 12:21
 */

namespace app\Models\DTO;


use app\Models\IDAOAccommodation;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;

class AccommodationModel extends Model implements AuthenticatableContract, CanResetPasswordContract, IDAOAccommodation
{
    use Authenticatable, CanResetPassword;

    public function createAccom(Accommodation $accom)
    {
        // TODO: Implement createAccom() method.
    }

    public function accommodationByID($id)
    {
        // TODO: Implement accommodationByID() method.
    }
}