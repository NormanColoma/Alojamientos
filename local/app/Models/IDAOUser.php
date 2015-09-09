<?php


namespace App\Models;


use App\Models\DTO\AbstractUser;

interface IDAOUser
{

    public function createUser(AbstractUser $user);
    public function updateUser($id, AbstractUser $user);
    public function deleteUser($id);
    public function userByEmail($email);
    public function userByName($name);
    public function allBookings($user);
    public function allPreBookings($user);
    public function getID($email);

}