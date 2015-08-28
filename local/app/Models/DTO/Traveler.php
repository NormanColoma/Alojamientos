<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 12/08/2015
 * Time: 19:27
 */

namespace App\Models\DTO;


class Traveler extends AbstractUser
{

    function __construct() {

        $this->setAdmin(false);
        $this->setOwner(false);
    }

}