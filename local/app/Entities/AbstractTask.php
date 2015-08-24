<?php

/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 05/08/2015
 * Time: 19:59
 */

namespace App\Entities;

abstract class AbstractTask
{
    protected $name;
    protected $id;

    abstract protected function concat($string);

    public function getName(){
        return $this->name;
    }

    public function getID(){
        return $this->id;
    }

}