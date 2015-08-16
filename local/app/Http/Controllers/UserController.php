<?php

namespace App\Http\Controllers;

use App\Models\DTO\Owner;
use App\Models\DTO\Traveler;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
                else if(Auth::user()->admin)
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
                $user->setOwner($request->input('owner'));
                $uModel = new UserModel();
                $uCreated = $uModel->createUser($user);
                if($uCreated !=null) {
                    Auth::login($uCreated);
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
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
