<?php


namespace App\Models\DTO;


class Traveler extends AbstractUser
{

    function __construct() {

        $this->setAdmin(false);
        $this->setOwner(false);
    }

}