<?php

namespace App\Http\Controllers;

use App\Models\BookingModel;
use App\Models\DTO\Admin;
use App\Models\DTO\Commentary;
use App\Models\DTO\Message;
use App\Models\DTO\Owner;
use App\Models\DTO\Traveler;
use App\Models\SystemModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use Validator;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Recibe el email y la contraseña, y comprueba que los credenciales son correctos. Primero valida los campos.
     * Si la validación se cumple, comprueba los credenciales. Si el usuario existe, es redireccionado al panel de control
     * pertinente según su rol.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $credentials = $request->only('email','password');
            if (Auth::attempt($credentials, $request->has('remember'))) {
                if(!Auth::user()->admin && !Auth::user()->owner)
                    return redirect()->intended('/manage/traveler');
                else if(Auth::user()->owner)
                    return redirect()->intended('/manage/owner');
                else
                    return redirect()->intended('/manage/admin');
            }
            return redirect('/login')
                ->withInput()
                ->withErrors([
                    'email' => 'El usuario o la contraseña no son correctos',
                ]);
        }
    }

    /**
     *Cierra la sesión del usuario acutal, y lo redirige al home.
     *
     * @param  void
     * @return Response
     */
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    /**
     *Recibe los campos del usuario por parámetro y los valida. Si la validación es incorrecta, le redirige a la página
     * de registro indicándole los errores pertinente. Si es válida, intenta registrar al usuario. Si el email introducido ya
     * existe, se le vuelve a redirigir a la página de registro. En caso contrario, se inserta al usuario y se le loguea.
     *
     * @param  Request $request
     * @return Response
     */
    public function register(Request $request){

        $messages = [
            'email.required' => 'El email es obligatorio',
            'name.required' => 'El nombre es obligatorio',
            'surname.required' => 'Los apellidos son obligatorios',
            'password.required' => 'La contraseña es obligatoria',
            'phone.required' => 'El teléfono es obligatorio',
            'email.email' => 'El email introducido no es correcto',
            'password.regex' => 'La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica',
            'name.regex' => 'El nombre solo puede contener letras',
            'surname.regex' => 'Los apellidos solo puede contener letras',
            'digits' => 'El teléfono solo puede contener números, y debe ser correcto',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'surname' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'email' => 'required|email',
            'password' => 'required|regex:[^[a-zA-Z]\w{5,14}$]',
            'phone' => 'required|digits:9',

        ],$messages);
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }
        else{
                $user = null;
                if($request->input('owner'))
                    $user = new Owner();
                else
                    $user = new Traveler();
                $user->setName($request->input('name'));
                $user->setSurname($request->input('surname'));
                $user->setEmail($request->input('email'));
                $user->setPassword($request->input('password'));
                $user->setPhone($request->input('phone'));
                if($request->input('owner')!=null)
                    $user->setOwner($request->input('owner'));
                $uModel = new UserModel();
                $uCreated = $uModel->createUser($user);
                if($uCreated !=null) {
                    Auth::login($uCreated);
                    flash()->overlay('Su cuenta en Alojarural ha sido creada correctamente..', 'Bienvenido');
                    if (!Auth::user()->admin && !Auth::user()->owner)
                        return redirect()->intended('/manage/traveler');
                    else
                        return redirect()->intended('/manage/owner');
                }
                return redirect('/register')
                    ->withErrors([
                        'email' => 'El email introducido ya se encuentra registrado',
                    ])
                    ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Actualiza el usuario con el id pasado, mediante los nuevos valores almacenados en el request
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateUser(Request $request, $id)
    {
        $redirect = null;
        $user = null;
        if(Auth::user()->admin) {
            $redirect = "/manage/admin#account";
            $user = new Admin();
        }
        else if(Auth::user()->owner) {
            $redirect = "/manage/owner#account";
            $user = new Owner();
        }
        else {
            $redirect = "/manage/traveler#account";
            $user = new Traveler();
        }
        $messages = [
            'email.required' => 'El email es obligatorio',
            'name.required' => 'El nombre es obligatorio',
            'surname.required' => 'Los apellidos son obligatorios',
            'password.required' => 'La contraseña es obligatoria',
            'phone.required' => 'El teléfono es obligatorio',
            'email.email' => 'El email introducido no es correcto',
            'password.regex' => 'La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica',
            'name.regex' => 'El nombre solo puede contener letras',
            'surname.regex' => 'Los apellidos solo puede contener letras',
            'digits' => 'El teléfono solo puede contener números, y debe ser correcto',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'surname' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'email' => 'required|email',
            'password' => 'required|regex:[^[a-zA-Z]\w{5,14}$]',
            'phone' => 'required|digits:9',

        ],$messages);
        if ($validator->fails()) {
            return redirect($redirect)
                ->withErrors($validator)
                ->withInput();
        }
        else{
            $user->setName($request->input('name'));
            $user->setSurname($request->input('surname'));
            $user->setEmail($request->input('email'));
            $user->setPassword($request->input('password'));
            $user->setPhone($request->input('phone'));
            $um = new UserModel();
            if($um->updateUser($id, $user)) {
                flash()->overlay('Su cuenta en Alojarural ha sido actulizada correctamente.', 'Cuenta actualizada');
                return redirect($redirect);
            }else{
                return redirect($redirect)
                    ->withErrors([
                        "email" => "El email introducido ya se encuentra registrado"
                    ])
                    ->withInput();
            }

        }
    }


    public function sendConditions(Request $request, $id)
    {
        $u_email = $request->input("to");
        $u_name = $request->input("user-name");
        $owner = Auth::getUser();
        $user = new Traveler();
        $user->setEmail($u_email);
        $user->setName($u_name);
        $bm = new BookingModel();
        $b = $bm->showPreBooking($id);
        try {
            Mail::send('emails.confirmBooking', ['check_in' => $b->getCheckIn(), 'check_out' => $b->getCheckOut(), 'owner' => $owner, 'id' => $id, 'text' => $request->input("text-conditions")], function ($m) use ($user) {
                $m->to($user->getEmail(), $user->getEmail())->subject('Confirmar reserva');
            });
            flash()->overlay("Las condiciones han sido enviadas correctamente", "Condiciones enviadas");
            return redirect("manage/owner");
        }catch(\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
    }

    public function sendQuestion(Request $request)
    {
        $messages = [
            'email.required' => 'El email es obligatorio',
            'name.required' => 'El nombre es obligatorio',
            'text.required' => 'El mensaje es obligatorio',
            'subject.required' => 'El asunto es obligatorio',
            'email.email' => 'El email introducido no es correcto',
            'name.regex' => 'El nombre solo puede contener letras',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'email' => 'required|email',
            'subject' => 'required',
            'text' => 'required',

        ],$messages);

        if ($validator->fails()) {
            return redirect("contact")
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $um = new UserModel();
            $user = $um->getUserByEmail("alojarural.info@gmail.com");
            try {
                Mail::send('emails.question', ['text' => $request->input("text"), 'name' => $request->input("name"), 'email' => $request->input("email")], function ($message) use($user, $request) {
                    $message->to($user->getEmail())->subject($request->input("subject"));
                });
                Mail::send('emails.question_sent', ['text' => $request->input("text"), 'name' => $request->input("name"), 'email' => $request->input("email")], function ($message) use($request) {
                    $message->from('alojarural.info@gmail.com', 'AlojaRural');
                    $message->to($request->input("email"))->subject("Consulta enviada");
                });
            }catch(\Exception $ex){
                throw new \Exception($ex->getMessage());
            }

            try{
                $m = new Message();
                $m->setFrom($user->getName() ." " .$user->getSurname());
                $m->setTo($user->getEmail());
                $m->setText($request->input("text"));
                $m->setSubject($request->input("subject"));
                $m->setType("normal");
                $sm = new SystemModel();
                $sm->addMessage($m, $user->getId());
                flash()->overlay("Tu mensaje ha sido enviado correctamente.","Mensaje enviado");
                return redirect("contact");
            }catch (QueryException $ex){
                throw new \Exception($ex->getMessage());
            }
        }
    }

    public function sendMessage(Request $request){
        $um = new UserModel();
        $user = $um->userById($um->getID($request->input("from")), 'traveler');
        try {
            Mail::send('emails.new', ['text' => $request->input("new-text-message"), 'user' => Auth::user()], function ($message) use($user) {
                $message->from('alojarural.info@gmail.com', 'AlojaRural');
                $message->to($user->getEmail())->subject("Nuevo mensaje");
            });

        }catch(\Exception $ex){
            throw new \Exception($ex->getMessage());
        }

        try{
            $m = new Message();
            $m->setFrom(Auth::user()->name ." " . Auth::user()->surname);
            $m->setTo($user->getEmail());
            $m->setText($request->input("new-text-message"));
            $m->setSubject('Nuevo mensaje');
            $m->setType("normal");
            $sm = new SystemModel();
            $sm->addMessage($m, $user->getId());
            $redirect = null;
            if(Auth::user()->admin) {
                $redirect = "/manage/admin";
            }
            else if(Auth::user()->owner) {
                $redirect = "/manage/owner";
            }
            else {
                $redirect = "/manage/traveler";
            }
            flash()->overlay("Tu mensaje ha sido enviado correctamente.","Mensaje enviado");
            return redirect($redirect);
        }catch (QueryException $ex){
            throw new \Exception($ex->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function existsEmail($email){
        $um = new UserModel();
        if($um->userByEmail($email))
            return response()->json(['ok' => true, 'message' => 'Email was found'], 200);
        else
            return response()->json(['ok' => false, 'message' => 'Email was not found'], 404);
    }


    public function comment(Request $request){
        $um = new UserModel();
        $commentary = new Commentary();
        $text = "Sin comentario";
        if($request->has("commentary"))
            $text = $request->input("commentary");
        $commentary->setText($text);
        $commentary->setVote($request->input("stars"));
        $commentary->setAccomId($request->input("accom-id"));
        $commentary->setUserId(Auth::user()->id);
        if($um->insertCommentary($commentary)){
            return response()->json(['ok' => true, 'message' => 'Commentary was posted'], 200);
        }else{
            return response()->json(['ok' => false, 'message' => 'Commentary could not be posted'], 404);
        }
    }
}
