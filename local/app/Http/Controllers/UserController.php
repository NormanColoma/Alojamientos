<?php

namespace App\Http\Controllers;

use App\Models\DTO\Owner;
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
     * Store a newly created resource in storage.
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
                return redirect()->intended('/');
            }
            return redirect('/login')
                ->withInput()
                ->withErrors([
                    'email' => 'El usuario o la contraseña no son correctos',
                ]);
        }
    }

    public function logout(){
        Auth::logout();
        //flash()->success("You've logged out successfully");
        return redirect('/');
    }


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
            'numeric' => 'El teléfono solo puede contener números',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'surname' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'email' => 'required|email',
            'password' => 'required|regex:[^[a-zA-Z]\w{5,14}$]',
            'phone' => 'required|numeric',

        ],$messages);
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }
        else{
            try{
                Auth::login($this->create($request->all()));
                return redirect('/');
            }catch(QueryException $ex){
                flash()->error("El email introducido ya está registrado");
                return redirect('/register');
            }
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
