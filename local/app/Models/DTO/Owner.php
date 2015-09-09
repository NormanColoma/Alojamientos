<?php


namespace App\Models\DTO;


class Owner extends AbstractUser
{

    function __construct() {
        $this->setAdmin(false);
        $this->setOwner(true);
    }

}