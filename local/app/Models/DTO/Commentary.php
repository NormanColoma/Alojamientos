<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 10/09/2015
 * Time: 11:39
 */

namespace App\Models\DTO;


class Commentary
{

    private $id;
    private $accom_id;
    private $author;
    private $text;
    private $vote;
    private $date;
    
    /**
     * Commentary constructor.
     */
    public function __construct()
    {
        date_default_timezone_set('Europe/Madrid');
        $this->date = date('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAccomId()
    {
        return $this->accom_id;
    }

    /**
     * @param mixed $accom_id
     */
    public function setAccomId($accom_id)
    {
        $this->accom_id = $accom_id;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param mixed $vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}