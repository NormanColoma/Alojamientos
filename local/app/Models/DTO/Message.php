<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 03/09/2015
 * Time: 17:22
 */

namespace App\Models\DTO;


class Message
{

    private $id;
    private $from;
    private $to;
    private $text;
    private $type;
    private $subject;


    function __construct(){
        $this->type = "normal";
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getFrom(){
        return $this->from;
    }

    public function setFrom($from){
        $this->from = $from;
    }

    public function getTo(){
        return $this->to;
    }

    public function setTo($to){
        $this->to = $to;
    }

    public function getText(){
        return $this->text;
    }

    public function setText($text){
        $this->text = $text;
    }

    public function getSubject(){
        return $this->subject;
    }

    public function setSubject($subject){
        $this->subject = $subject;
    }

    public function getType(){
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}