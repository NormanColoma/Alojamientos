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
        $sm = new \App\Models\SystemModel();
        $inc = $sm->allIncomingMessages(Auth::user()->email);
        return view("account/control_panel",['incoming' => $inc]);
    }]);

    Route::get('/manage/owner',['middleware' => 'owner', function()
    {
        $am = new \App\Models\AccommodationModel();
        $sm = new \App\Models\SystemModel();
        $inc = $sm->allIncomingMessages(Auth::user()->email);
        return view("account/control_panel",['accommodations'=>$am->accommodationByOwner(Auth::user()->id), 'incoming' => $inc]);
    }]);

    Route::get('/manage/owner/accoms/page/{id}',['middleware' => 'owner', function()
    {
        $am = new \App\Models\AccommodationModel();
        return view("account/control_panel",['accommodations'=>$am->accommodationByOwner(Auth::user()->id)]);
    }]);



    Route::get('/manage/admin', ['middleware' => 'admin', function()
    {
        return view("account/control_panel");
    }]);

});

Route::post('accommodation/publish',"AccommodationController@addAccommodation");
Route::post('search/accommodations',"SystemController@search");
Route::paginate('search/accommodations/{city}', 'SystemController@displayAccommodationsByCity');
Route::paginate('search/accommodations/{city}/checkIn/{check_in}/checkOut/{check_out}', 'SystemController@displayAccommodationsByDate');
Route::delete('/accommodation/delete/{id}',"AccommodationController@removeAccommodation");
Route::get('/accommodation/{id}/update', "AccommodationController@getAccommodation");
Route::delete('/photo/delete/{id}',"AccommodationController@removePhoto");
Route::post('/photo/update/{id}',"AccommodationController@updatePhoto");
Route::post('/gallery/update/{id}',"AccommodationController@updateGallery");
Route::post('/accommodation/{id}/update',"AccommodationController@updateAccommodation");
Route::post('user/update/{id}', "UserController@updateUser");
Route::post('accommodation/{id}/schedule/', "AccommodationController@updateSchedule");
Route::get('accommodation/{id}/schedule', "AccommodationController@getSchedule");
Route::delete('accommodation/{id}/schedule', "AccommodationController@deleteSchedule");
Route::get('accommodation/{id}/schedule/update',function($id){
    return view("account/schedule", ["id" => $id]);
});
Route::get("accommodation/{id}/details", "AccommodationController@show");
Route::post("accommodation/{id}/book", "BookingController@createBookingPrebooking");
Route::get("prueba", function(){
    return view("emails.prebooking_owner");
});