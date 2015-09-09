<?php


namespace App\Models\DTO;

use App\Models\DTO\Schedule;

class Booking extends PreBooking
{

    private $id;
    private $price;
    private $persons;
    private $accomm_id;
    private $user_id;
    private $owner_id;

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @param mixed $owner_id
     */
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
    }

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

    function makeInterval(){

        $schedule = new Schedule();
        $intervalo = "";

        for($i=$this->check_in;$i<=$this->check_out;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
            if($i==$this->check_out)
                $intervalo .= $i;
            else
                $intervalo .= $i . ",";
        }

        $schedule->setDays($intervalo);

        return $schedule;

    }
}