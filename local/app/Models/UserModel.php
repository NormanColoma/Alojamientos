<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DTO\AbstractUser;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserModel extends Model implements AuthenticatableContract, CanResetPasswordContract, IDAOUser
{
    use Authenticatable, CanResetPassword;
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = array('name', 'password', 'email', 'surname', 'phone', 'owner', 'admin');

    public function createUser(AbstractUser $user)
    {

        $u = UserModel::create([
            'name' => $user->getName(),
            'password' =>  bcrypt($user->getPassword()),
            'email' => $user->getEmail(),
            'surname' => $user->getSurname(),
            'phone' => $user->getPhone(),
            'owner' => $user->getOwner(),
            'admin' => $user->getAdmin(),
        ]);
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