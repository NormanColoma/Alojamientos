<?php


namespace App\Models\DTO;


class Accommodation
{
    private $id;
    private $title;
    private $desc;
    private $capacity;
    private $beds;
    private $bathrooms;
    private $inside;
    private $outside;
    private $price_per_person;
    private $city;
    private $province;
    private $photos;
    private $intial_desc;
    function __construct() {
        $this->inside = "El propietario aún no ha detallado nada sobre las características interiores del alojamiento.";
        $this->outside = "El propietario aún no ha detallado nada sobre las características exteriores del alojamiento.";
    }

    public function getID(){
        return $this->id;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getDesc(){
        return $this->desc;
    }

    public function setDesc($desc){
        $this->desc = $desc;
    }

    public function getCapacity(){
        return $this->capacity;
    }

    public function setCapacity($cap){
        $this->capacity = $cap;
    }

    public function getBeds(){
        return $this->beds;
    }

    public function setBeds($beds){
        $this->beds = $beds;
    }

    public function getBaths(){
        return $this->bathrooms;
    }

    public function setBaths($baths){
        $this->bathrooms = $baths;
    }

    public function getInside(){
        return $this->inside;
    }

    public function setInside($inside){
        $this->inside = $inside;
    }

    public function getOutside(){
        return $this->outside;
    }

    public function setOutside($outside){
        $this->outside = $outside;
    }

    public function getPrice(){
        return $this->price_per_person;
    }

    public function setPrice($p){
        $this->price_per_person = $p;
    }

    public function getCity(){
        return $this->city;
    }

    public function setCity($city){
        $this->city = $city;
    }

    public function getProvince(){
        return $this->province;
    }

    public function setProvince($province){
        $this->province = $province;
    }

    public function getPhotos(){
        return $this->photos;
    }
    public function setPhotos($photos){
        $this->photos = $photos;
    }

    public function getInitialDesc()
    {
        return $this->intial_desc;
    }

    public function setInitialDesc($desc){
        if(strlen($desc) > 334) {
            $this->intial_desc = substr($desc, 0, 334);
            $this->intial_desc = $this->intial_desc . "...";
        }
        else
            $this->intial_desc = $desc;
    }

    public function setHightLightsDesc(){
        if(strlen($this->desc) > 165) {
            $this->desc = substr($this->desc, 0, 165);
            $this->desc = $this->desc . "...";
        }
    }

    public function getMainImg(){
        $main = null;
        foreach($this->photos as $photo){
            if($photo->getMain())
                $main = $photo;
        }
        return $main;
    }
}