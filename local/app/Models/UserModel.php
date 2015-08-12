<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 12/08/2015
 * Time: 20:54
 */

namespace App\Models;

use App\Models\DTO\AbstractUser;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model implements IDAOUser
{
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = array('name', 'password', 'email', 'surname', 'phone', 'owner', 'admin');

    public function createUser(AbstractUser $user){

        $u = UserModel::create([
            'name' => $user->getName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'surname' => $user->getSurname(),
            'phone' => $user->getPhone(),
            'owner' => $user->getOwner(),
            'admin' => $user->getAdmin(),
        ]);

        if($u != null)
            return true;
        return false;
    }

    public function updateUser($id, $user){

    }

    public function deleteUser($id){

    }

    public function userByEmail($email){

    }

    public function userByName($name){

    }

    public function allBookings($user){

    }

    public function allPreBookings($user){

    }

}