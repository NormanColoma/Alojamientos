<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 12/08/2015
 * Time: 20:54
 */

namespace App\Models;


use App\Models\DTO\AbstractUser;
use App\Models\DTO\Commentary;

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
    public function insertCommentary(Commentary $commentary);
    public function getCommentary($id);
    public function allCommentaries($traveler_id);

}