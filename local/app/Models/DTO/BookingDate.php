<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 28/08/2015
 * Time: 19:09
 */

namespace app\Models\DTO;


class BookingDate
{

    private $starting;
    private $ending;

    function __construct() {

    }

    function setStarting($start){
        $this->starting = date('Y-m-d', strtotime($start));
    }

    function getStarting(){
        return $this->starting;
    }

    function setEnding($end){
        $this->ending = date('Y-m-d', strtotime($end));
    }

    function getEnding(){
        return $this->ending;
    }

}