<?php


namespace App\Models\DTO;


class Admin extends AbstractUser
{
    function __construct() {
        $this->admin= true;
        $this->owner = false;
        $this->surname = "";
        $this->phone = "";
    }

}