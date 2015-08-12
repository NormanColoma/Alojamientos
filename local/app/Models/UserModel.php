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

    protected $fillable = array('name', 'password', 'email', 'surname', 'phone', 'owner', 'admin');

    public function createUser(AbstractUser $user){

        return UserModel::create([
            'name' => $user->getName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'surname' => $user->getSurname(),
            'phone' => $user->getPhone(),
            'owner' => $user->getOwner(),
            'admin' => $user->getAdmin(),
        ]);
    }

    public function update($id, $user){

    }

    public function delete($id){

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