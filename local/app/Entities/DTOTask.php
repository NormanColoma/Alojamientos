<?php namespace App\Entities;

/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 05/08/2015
 * Time: 20:04
 */
class DTOTask extends AbstractTask
{

    public function __construct($id,$name){
        $this->name = $name;
        $this->id = $id;
    }
    protected function concat($string)
    {
        return $this->name . $string;
    }
}