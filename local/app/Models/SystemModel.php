<?php


namespace App\Models;


use App\Models\DTO\Commentary;
use App\Models\DTO\Message;
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
                $a->setInitialDesc($ac->desc);
                $accommodations [] = $a;
            }
        }catch(QueryException $ex){
            return null;
        }
        return $accommodations;
    }

    public function displayHighlights()
    {
        $am = new AccommodationModel();
        $accomm = null;
        $accommodations = [];
        try{
            $accomm = DB::table('accommodations')->orderBy("created_at","desc")->take(3)->get();
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
                $a->setInitialDesc($ac->desc);
                $accommodations [] = $a;
            }
        }catch(QueryException $ex){
            return null;
        }
        return $accommodations;
    }

    public function allAccomByDates($city, $c_in, $c_out){
        $am = new AccommodationModel();
        $accomm = null;
        $accommodations = [];
        try{
            $ids = $this->accommodationsForDates($c_in, $c_out);
            $accomm = DB::table('accommodations')->whereNotIn("id",$ids)->where('province', $city)->orWhere('city', $city)->whereNotIn("id", $ids)->paginate(5);
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
                $a->setInitialDesc($ac->desc);
                $accommodations [] = $a;
            }
        }catch(QueryException $ex){
            return null;
        }
        return $accommodations;
    }

    public function accommodationsForDates($c_in, $c_out){
        try{
            return $accommodations_id = DB::table('schedules')->where('day',$c_in)->orWhere('day',$c_out)->distinct()->lists("accommodation_id");
        }catch(QueryException $ex){
            return null;
        }
    }


    /**
     * @param Message $message
     * @param $id_user
     * @return bool|null
     */
    public function addMessage(Message $message, $id_user)
    {
        $message_id = null;
        try {
            $message_id = DB::table('messages')->insertGetId(
                ['from' => $message->getFrom(), 'to' => $message->getTo(), 'text' => $message->getText(),
                'subject' => $message->getSubject(), 'type' => $message->getType(), 'user_id' => $id_user, 'read' =>$message->isRead()]
            );
        }catch(QueryException $ex){
            throw new \Exception($ex->getMessage());
        }

        return $message_id;
    }


    public function allIncomingMessages($user_email){
        $m = null;
        $messages = [];
        try{
            $m = DB::table('messages')->select("messages.id","messages.from","messages.to","messages.subject","messages.text","messages.read")
                ->leftJoin('users', 'email', '=', 'to')->where('email', $user_email)->orderBy("messages.read", "asc")->get();
            if(count($m) == 0) {
                return null;
            }

            foreach($m as $message) {
                $me = new Message();
                $me->setId($message->id);
                $me->setFrom($message->from);
                $me->setTo($message->to);
                $me->setSubject($message->subject);
                $me->setText($message->text);
                $me->setRead($message->read);
                $messages [] = $me;
            }
        }catch(QueryException $ex){
            return null;
        }
        return $messages;
    }

    public function allOutcomingMessages($user_email){
        $m = null;
        $messages = [];
        try{
            $m = DB::table('messages')->select("messages.id","messages.from","messages.to","messages.subject","messages.text", "messages.read")
                ->leftJoin('users', 'email', '=', 'from')->where('email', $user_email)->get();;
            if(count($m) == 0) {
                return null;
            }

            foreach($m as $message) {
                $me = new Message();
                $me->setId($message->id);
                $me->setFrom($message->from);
                $me->setTo($message->to);
                $me->setSubject($message->subject);
                $me->setText($message->text);
                $me->setRead($message->read);
                $messages [] = $me;
            }
        }catch(QueryException $ex){
            return null;
        }
        return $messages;
    }

    public function getMessage($id)
    {
        $m = null;
        $messages = [];
        try{
            $m= DB::table('messages')->where('id', $id)->get();
            if(count($m) == 0) {
                return null;
            }
            foreach($m as $message) {
                $me = new Message();
                $me->setId($message->id);
                $me->setFrom($message->from);
                $me->setTo($message->to);
                $me->setSubject($message->subject);
                $me->setText($message->text);
                $me->setRead($message->read);
                $me->setType($message->type);
                $messages [] = $me;
            }

        }catch(QueryException $ex){
            return null;
        }
        return $messages[0];
    }

    public function readMessage($id){
        try {
            $read = DB::table('messages')->where('id', $id)->where('read', 0)
                ->update([
                    'read' => true,
                ]);
            return $read;
        }catch(QueryException $ex){
            return false;
        }
    }

    public function deleteMessage($id){
        try {
            $deleted = DB::table('messages')->where('id', $id)
                ->delete();
            return $deleted;
        }catch(QueryException $ex){
            return false;
        }
    }

}