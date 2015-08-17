<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 17/08/2015
 * Time: 10:05
 */

namespace App\Models\DTO;


class Accommodation
{
    private $id;
    private $title;
    private $desc;
    private $capacity;
    private $beds;
    private $baths;
    private $inside;
    private $outside;
    private $price_per_person;
    private $city;
    private $province;
    private $photos;

    function __construct() {
        $this->inside = "El propietario aún no ha detallado nada sobre las características interiores del alojamiento.";
        $this->outside = "El propietario aún no ha detallado nada sobre las características exteriores del alojamiento.";
    }

    public function getID(){
        return $this->id;
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
        return $this->baths;
    }

    public function setBaths($baths){
        $this->baths = $baths;
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
        $this->price = $p;
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
}