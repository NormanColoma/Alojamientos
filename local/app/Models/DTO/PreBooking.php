<?php


namespace App\Models\DTO;


abstract class PreBooking
{

    protected $date;

    /**
     * @param bool|string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    protected $preBooking;
    protected $check_in;
    protected $check_out;

    function __construct() {
        date_default_timezone_set('Europe/Madrid');
        $this->date = date('Y-m-d H:i:s');
        $this->preBooking = true;
    }

    function getDate(){ return $this->date; }

    function setPreBooking($preBooking){
        $this->preBooking = $preBooking;
    }

    function getPreBooking(){
        return $this->preBooking;
    }

    function setCheckIn($c_in){
        $this->check_in = date('Y-m-d', strtotime($c_in));
    }

    function getCheckIn(){
        return $this->check_in;
    }

    function setCheckOut($c_out){
        $this->check_out = date('Y-m-d', strtotime($c_out));
    }

    function getCheckOut(){
        return $this->check_out;
    }

}