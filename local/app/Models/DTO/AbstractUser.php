<?php


namespace App\Models\DTO;


abstract class AbstractUser
{
    protected $name;
    protected $password;
    protected $email;
    protected $surname;
    protected $phone;
    protected $owner;
    protected $admin;
    protected $id;

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name=$name;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($pass){
        $this->password=$pass;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function getSurname(){
        return $this->surname;
    }

    public function setSurname($surname){
        $this->surname=$surname;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPhone($phone){
        $this->phone=$phone;
    }

    public function getOwner(){
        return $this->owner;
    }

    public function setOwner($owner){
        $this->owner=$owner;
    }

    public function getAdmin(){
        return $this->admin;
    }

    public function setAdmin($admin){
        $this->admin=$admin;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

}