<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DTO\AbstractUser;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\QueryException;

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
            return $u;
        }
        return $u;
    }

    public function updateUser($id, $user)
    {

    }

    public function deleteUser($id)
    {

    }

    public function userByEmail($email)
    {

    }

    public function userByName($name)
    {

    }

    public function allBookings($user)
    {

    }

    public function allPreBookings($user)
    {

    }

}