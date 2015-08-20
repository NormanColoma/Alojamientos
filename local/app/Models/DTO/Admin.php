<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 12/08/2015
 * Time: 19:21
 */

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