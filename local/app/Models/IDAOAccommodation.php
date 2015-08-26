<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 17/08/2015
 * Time: 12:20
 */

namespace App\Models;


use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;

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
}