<?php


namespace App\Models;


use App\Models\DTO\Note;
use DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;

class NoteModel extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    //Tabla con la que se interactua y se bindea el modelo
    protected $table = 'notes';

    //Por defecto laravel crea dos campos timestamps, en este caso no los queremos
    public $timestamps = false;

    //Cuando hacemos una asignación múltiple (mass assignament), necesitamos especificar un array con los campos
    protected $fillable = array('text', 'created_at', 'user_id', 'about_user');

    public function createNote(Note $note){
        $n = null;
        try {
            $n =  DB::table('notes')->insertGetId([
                'text' => $note->getText(),
                'user_id' => $note->getOwnerId(),
                'about_user' => $note->getUserId(),
                'created_at' => $note->getCreatedAt(),
            ]);

        }catch(QueryException $ex){
            throw new \Exception("Ha fallado la inserción");
        }
        return $n;
    }

    public function deleteNote($id){
        try {
            $deletedRows = NoteModel::where('id', $id)->delete();

            if($deletedRows == 0)
                return false;
            return true;
        }catch(QueryException $ex){
            return false;
        }
    }

    public function getNotes($user_id){
        $notes = [];
        $no = null;
        try{
            $no = DB::table('notes')->select('*')
                ->where('about_user', $user_id)->orderBy("created_at", "asc")
                ->get();

            if($no == null)
                return null;

            foreach($no as $n) {
                $note = new Note();
                $note->setId($n->id);
                $note->setText($n->text);
                $note->setOwnerId($n->user_id);
                $note->setUserId($n->about_user);
                $note->setCreatedAt($n->created_at);
                $notes[] = $note;
            }
        }catch(QueryException $ex){
            throw new \Exception($ex->getMessage());
        }

        return $notes;
    }

}