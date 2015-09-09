<?php


namespace app\Models;



use app\Models\DTO\Message;

interface IDAOSystem
{
    public function allAcomByCity($city);
    public function allAccomByDates($city, $c_in, $c_out);
    public function addMessage(Message $message, $id_user);
    public function allIncomingMessages($user_email);
    public function allOutcomingMessages($user_email);
}