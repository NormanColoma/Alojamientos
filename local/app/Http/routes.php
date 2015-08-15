<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', "HomeController@index");
Route::get('/home', "HomeController@index");
Route::group(['middleware' => ['guest']], function()
{
    Route::get('/login',function(){
        return view("account/login");
    });
    Route::get('/login',function(){
        return view("account/register");
    });
});

Route::post('/login',"UserController@login");
Route::get('/logout',"UserController@logout");

Route::group(['middleware' => ['auth']], function()
{
    Route::get('/manage/traveler',['middleware' => 'traveler', function()
    {
        return "Aquí irá el panel de control del viajero";
    }]);

    Route::get('/manage/owner',['middleware' => 'owner', function()
    {
        return "Aquí irá el panel de control del propietario";
    }]);
    Route::get('/manage/admin', ['middleware' => 'admin', function()
    {
        return "Aquí irá el panel de administración";
    }]);

});
