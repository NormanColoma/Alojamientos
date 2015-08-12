<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 12/08/2015
 * Time: 20:54
 */

namespace App\Models;


use App\Models\DTO\AbstractUser;

interface IDAOUser
{

    public function createUser(AbstractUser $user);
    public function update($id, $user);
    public function delete($id);
    public function userByEmail($email);
    public function userByName($name);
    public function allBookings($user);
    public function allPreBookings($user);

}