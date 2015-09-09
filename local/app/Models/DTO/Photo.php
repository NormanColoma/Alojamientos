<?php


namespace App\Models\DTO;


class Photo
{

    private $id;
    private $url;
    private $main;

    function __construct() {

    }

    public function getID(){
        return $this->id;
    }

    public function setID($id){
        $this->id = $id;
    }

    public function getUrl(){
        return $this->url;
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function getMain(){
        return $this->main;
    }

    public function setMain($main){
        $this->main = $main;
    }
}