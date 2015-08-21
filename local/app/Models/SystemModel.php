<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 21/08/2015
 * Time: 18:14
 */

namespace App\Models;


use App\Models\IDAOAccommodation;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;
use DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;

class SystemModel extends Model implements IDAOSystem, AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    private $am;



    public function allAcomByCity($city)
    {
        $am = new AccommodationModel();
        $accomm = null;
        $accommodations = [];
        try{
            $accomm = DB::table('accommodations')->where('province', $city)->orWhere('city', $city)->paginate(5);
            //$accomm = AccommodationModel::where('city', $city);
            if(count($accomm) == 0) {
                return null;
            }

            foreach($accomm as $ac) {
                $a = new Accommodation();
                $a->setID($ac->id);
                $a->setBaths($ac->bathrooms);
                $a->setBeds($ac->beds);
                $a->setCapacity($ac->capacity);
                $a->setCity($ac->city);
                $a->setDesc($ac->desc);
                $a->setInside($ac->inside);
                $a->setOutside($ac->outside);
                $a->setPhotos($am->allPhotos($ac->id));
                $a->setPrice($ac->price_per_person);
                $a->setProvince($ac->province);
                $a->setTitle($ac->title);
                $accommodations [] = $a;
            }
        }catch(QueryException $ex){
            return null;
        }
        return $accommodations;
        //return DB::table("accommodations")->where('city',$city)->orWhere('province',$city)->paginate(1);
    }
}