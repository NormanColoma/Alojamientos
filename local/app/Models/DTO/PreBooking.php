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
    protected $booking_time;
    protected $check_in;
    protected $check_out;

    function __construct() {
        $date = date('Y-m-d H:i:s');
        $preBooking = false;
    }

    function getDate(){ return $this->date; }

    function setPreBooking($preBooking){
        $this->preBooking = $preBooking;
    }

    function getPreBooking(){
        return $this->preBooking;
    }

    function setBookingTime(BookingDate $time){
        $this->booking_time = $time;
    }

    function getBookingTime(){
        return $this->booking_time;
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