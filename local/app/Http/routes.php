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
    Route::get('/register',function(){
        return view("account/register");
    });
});

Route::post('/login',"UserController@login");
Route::post('/register',"UserController@register");
Route::get('/logout',"UserController@logout");

Route::group(['middleware' => ['auth']], function()
{
    Route::get('/manage/traveler',['middleware' => 'traveler', function()
    {
        return view("account/control_panel");
    }]);

    Route::get('/manage/owner',['middleware' => 'owner', function()
    {
        return view("account/control_panel");
    }]);
    Route::get('/manage/admin', ['middleware' => 'admin', function()
    {
        return view("account/control_panel");
    }]);

});

Route::post('accommodation/publish',"AccommodationController@addAccommodation");
