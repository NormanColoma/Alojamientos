<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 17/08/2015
 * Time: 12:20
 */

namespace app\Models;


use App\Models\DTO\Accommodation;

interface IDAOAccommodation
{
    public function createAccom(Accommodation $accom);
    public function accommodationByID($id);
}