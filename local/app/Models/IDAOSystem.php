<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 21/08/2015
 * Time: 18:13
 */

namespace app\Models;



use app\Models\DTO\Message;

interface IDAOSystem
{
    public function allAcomByCity($city);
    public function allAccomByDates($city, $c_in, $c_out);
    public function addMessage(Message $message, $id_user);
}