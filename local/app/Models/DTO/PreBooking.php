<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 01/09/2015
 * Time: 17:51
 */

namespace App\Models\DTO;


abstract class PreBooking
{

    protected $date;
    protected $preBooking;

    function __construct() {

    }

    function setDate($date){
        $this->date = date('Y-m-d', strtotime($date));
    }

    function getDate(){ return $this->date; }

    function setPreBooking($preBooking){
        $this->preBooking = $preBooking;
    }

    function getPreBooking(){
        return $this->preBooking;
    }

}