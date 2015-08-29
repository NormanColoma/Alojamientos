<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 28/08/2015
 * Time: 19:10
 */

namespace app\Models\DTO;


class Schedule
{

    private $id;
    private $days;

    function __construct() {

    }

    function setId($id){
        $this->id = $id;
    }

    function getId(){
        return $this->id;
    }

    function setDays($days){
        $this->days = $days;
    }

    function getDays(){
        return $this->days;
    }

}