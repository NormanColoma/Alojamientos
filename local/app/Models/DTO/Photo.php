<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 17/08/2015
 * Time: 11:06
 */

namespace app\Models\DTO;


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