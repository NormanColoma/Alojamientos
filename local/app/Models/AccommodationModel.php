<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 17/08/2015
 * Time: 12:21
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

class AccommodationModel extends Model implements AuthenticatableContract, CanResetPasswordContract, IDAOAccommodation
{
    use Authenticatable, CanResetPassword;

    //Tabla con la que se interactua y se bindea el modelo
    protected $table = 'accommodations';

    //Por defecto laravel crea dos campos timestamps, en este caso no los queremos
    public $timestamps = false;

    //Cuando hacemos una asignación múltiple (mass assignament), necesitamos especificar un array con los campos
    protected $fillable = array('title', 'desc', 'capacity', 'beds', 'bathrooms', 'inside', 'outside', 'price_per_person', 'city', 'province', 'user_id');


    /**
     * Recibe el Accommodation que será insertado en la bd. Si el alojamiento no existe
     * lo inserta en la bd y devuelve el objeto. Si existe, lo devolverá null.
     *
     * @param  Accommodation $accom
     * @return Accommodation
     */
    public function createAccom(Accommodation $accom, $id)
    {
        $a = null;
        try {
            $a = AccommodationModel::create([
                'title' => $accom->getTitle(),
                'desc' => $accom->getDesc(),
                'capacity' => $accom->getCapacity(),
                'beds' => $accom->getBeds(),
                'bathrooms' => $accom->getBaths(),
                'inside' => $accom->getInside(),
                'outside' => $accom->getOutside(),
                'price_per_person' => $accom->getPrice(),
                'city' => $accom->getCity(),
                'province' => $accom->getProvince(),
                'user_id' => $id,
            ]);

            foreach($accom->getPhotos() as $photo){
                $this->addPhoto($photo, $a['id']);
            }

        }catch(QueryException $ex){
            throw new \Exception("Ha fallado la inserción");
        }


        return $a;
    }

    public function updateAccomm(Accommodation $accom, $id){

        $a = null;
        try{
            $a = AccommodationModel::where('id', $id)
                ->update([
                    'title' => $accom->getTitle(),
                    'desc' => $accom->getDesc(),
                    'capacity' => $accom->getCapacity(),
                    'beds' => $accom->getBeds(),
                    'bathrooms' => $accom->getBaths(),
                    'inside' => $accom->getInside(),
                    'outside' => $accom->getOutside(),
                    'price_per_person' => $accom->getPrice(),
                    'city' => $accom->getCity(),
                    'province' => $accom->getProvince(),
                    'user_id' => $id,
                ]);

            foreach($accom->getPhotos() as $photo){
                $this->addPhoto($photo, $a['id']);
            }

            echo "UPDATE: ".$a;
            if($a == null)
                return false;
            else
                return true;
        }catch(QueryException $ex){
            echo "EXCEPTION";
            return false;
        }
    }

    public function deleteAccomm($id){

        try {
            $deletedRows = AccommodationModel::where('id', $id)->delete();

            if($deletedRows == 0)
                return false;

            return true;
        }catch(QueryException $ex){
            return false;
        }

    }

    public function accommodationByID($id)
    {
        $accomm = null;
        $acom = new Accommodation();

        try{
            $accomm = DB::table('accommodations')->select('*')
                ->where('id', $id)
                ->get();

            if($accomm == null){
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
                $a->setPhotos($this->allPhotos($id));
                $a->setPrice($ac->price_per_person);
                $a->setProvince($ac->province);
                $a->setTitle($ac->title);
                $acom = $a;
            }
        }catch(QueryException $ex){
            throw new \Exception("No existe el alojamiento");
        }

        return $acom;
    }

    public function accommodationByOwner($owner_id)
    {
        $accomm = null;
        $accommodations = [];

        try{
            $accomm = AccommodationModel::all()->where('user_id', $owner_id);

            if($accomm->count() == 0) {
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
                $a->setPhotos($this->allPhotos($ac->id));
                $a->setPrice($ac->price_per_person);
                $a->setProvince($ac->province);
                $a->setTitle($ac->title);
                $a->setInitialDesc($ac->desc);
                $accommodations [] = $a;
            }
        }catch(QueryException $ex){
            return null;
        }
        return $accommodations;
    }

    public function addPhoto(Photo $photo, $id)
    {
        $p = null;
        try {
            $p = DB::table('photos')->insert(
                ['url' => $photo->getUrl(), 'main' => $photo->getMain(), 'accommodation_id' => $id]
            );
        }catch(QueryException $ex){
            return $p;
        }

        return $p;

    }

    public function allPhotos($id){

        $photos = null;
        $arrayPhotos = [];

        try{
            $photos = DB::table('photos')->select('*')
                ->where('accommodation_id', $id)
                ->get();

            foreach($photos as $photo){
                $p = new Photo();
                $p->setUrl($photo->url);
                $p->setMain($photo->main);
                $arrayPhotos[] = $p;
            }
        }catch(QueryException $ex){
            return $photos;
        }

        return $arrayPhotos;

    }

}