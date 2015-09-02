<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 01/09/2015
 * Time: 17:51
 */

namespace App\Models\DTO;


class Booking extends PreBooking
{

    private $id;
    private $price;
    private $persons;

    function __construct() {

    }

    function setId($id){
        $this->id = $id;
    }

    function getId(){
        return $this->id;
    }

    function setPrice($price){
        $this->price = $price;
    }

    function getPrice(){
        return $this->price;
    }

    function setPersons($persons){
        $this->persons = $persons;
    }

    function getPersons(){
        return $this->persons;
    }

}