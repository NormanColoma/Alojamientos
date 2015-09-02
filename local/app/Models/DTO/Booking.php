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
    private $accomm_id;
    private $user_id;

    function __construct() {
        parent::__construct();
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

    function setAccommId($ac_id){
        $this->accomm_id = $ac_id;
    }

    function getAccommId(){
        return $this->accomm_id;
    }
    function getUserId(){
        return $this->user_id;
    }

    function setUserId($us_id){
        $this->user_id = $us_id;
    }
}