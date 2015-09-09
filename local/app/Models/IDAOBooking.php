<?php


namespace App\Models;

use App\Models\DTO\Booking;

interface IDAOBooking
{

    public function createBooking(Booking $booking);
    public function updateBooking(Booking $booking, $id);
    public function deleteBooking($id);
    public function showBooking($id);
    public function showPreBooking($id);
    public function confirm($id);

}