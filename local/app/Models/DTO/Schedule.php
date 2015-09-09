<?php


namespace App\Models\DTO;


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

    function format_calendar(){
        $calendar = [];
        $str ="";
        for($i=0;$i<strlen($this->days);$i++){
            if($this->days[$i] != ","){
                $str = $str . $this->days[$i];
                if($i+1 == strlen($this->days)){
                    $day = date('Y-m-d', strtotime($str));
                    $calendar [] = $day;
                }
            }
            else{
                $day = date('Y-m-d', strtotime($str));
                $calendar [] = $day;
                $str = "";
            }
        }

        $this->days = $calendar;
    }

}