<?php


namespace App\Models;


use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;
use App\Models\DTO\Schedule;

interface IDAOAccommodation
{
    public function createAccom(Accommodation $accom, $id);
    public function accommodationByID($id);
    public function addPhoto(Photo $photo, $id);
    public function allPhotos($id);
    public function updatePhoto($id, $url);
    public function deletePhoto($id);
    public function getGallery($id);
    public function photoUrl($id);
    public function accommodationByOwner($owner_id);
    public function deleteAccomm($id);
    public function addSchedule($id, Schedule $schedule);
    public function getSchedule($id);
    public function deleteSchedule($id);
    public function getOwner($id);
}