<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

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
        //
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
            'username.email' => 'El email introducido no es correcto',
            'password.regex' => 'La contraseña introducida no es correcta. Debe empezar con una letra y tener un mínimo de 6 caracteres, y un máximo de 15.'
        ];
        $validator = Validator::make($request->all(), [
            'username' => 'required|email',
            'password' => 'required|regex:[^[a-zA-Z]\w{6,14}$]',
        ],$messages);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        }
        else {

            $pass= $request->input('password');
            $hashed = bcrypt($pass);
            $email = $request->input('username');
            echo $hashed;
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
