<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 01/09/2015
 * Time: 18:13
 */

namespace App\Models;

use App\Models\DTO\Booking;

interface IDAOBooking
{

    public function createBooking(Booking $booking);
    public function updateBooking(Booking $booking, $id);
    public function deleteBooking($id);
    public function showBooking();
    public function showPreBooking();
    public function confirm($id);

}