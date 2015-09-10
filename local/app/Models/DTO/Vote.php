<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 10/09/2015
 * Time: 11:37
 */

namespace App\Models\DTO;


class Vote
{
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
    private $id;
    private $stars;

    /**
     * @return mixed
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * @param mixed $stars
     */
    public function setStars($stars)
    {
        $this->stars = $stars;
    }
    private $id_commentary;

    /**
     * @return mixed
     */
    public function getIdCommentary()
    {
        return $this->id_commentary;
    }

    /**
     * @param mixed $id_commentary
     */
    public function setIdCommentary($id_commentary)
    {
        $this->id_commentary = $id_commentary;
    }
}