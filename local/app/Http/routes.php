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
    Route::group(['middleware' => ['traveler']], function()
    {
        Route::post("accommodation/{id}/book", "BookingController@createBookingPrebooking");
        Route::get("booking/{id}/confirm", "BookingController@confirmBooking");
    });

    Route::group(['middleware' => ['owner']], function()
    {
        Route::post("booking/{id}/send","UserController@sendConditions");
    });

    Route::get('/manage/traveler',['middleware' => 'traveler', function()
    {
        $sm = new \App\Models\SystemModel();
        $um = new \App\Models\UserModel();
        $inc = $sm->allIncomingMessages(Auth::user()->email);
        $prebookings = $um->allPreBookings(Auth::user()->id);
        $bookings = $um->allBookings(Auth::user()->id);
        return view("account/control_panel",['incoming' => $inc, 'prebookings' => $prebookings, 'bookings' => $bookings]);
    }]);

    Route::get('/manage/owner',['middleware' => 'owner', function()
    {
        $am = new \App\Models\AccommodationModel();
        $um = new \App\Models\UserModel();
        $sm = new \App\Models\SystemModel();
        $inc = $sm->allIncomingMessages(Auth::user()->email);
        $prebookings = $um->allPreBookingsByOwner(Auth::user()->id);
        $bookings = $um->allBookingsByOwner(Auth::user()->id);
        return view("account/control_panel",['accommodations'=>$am->accommodationByOwner(Auth::user()->id), 'incoming' => $inc, 'prebookings' => $prebookings, 'bookings' => $bookings]);
    }]);

    Route::get('/manage/owner/accoms/page/{id}',['middleware' => 'owner', function()
    {
        $am = new \App\Models\AccommodationModel();
        return view("account/control_panel",['accommodations'=>$am->accommodationByOwner(Auth::user()->id)]);
    }]);



    Route::get('/manage/admin', ['middleware' => 'admin', function()
    {
        $sm = new \App\Models\SystemModel();
        $inc = $sm->allIncomingMessages(Auth::user()->email);
        return view("account/control_panel", ['incoming' => $inc]);
    }]);
    Route::get("accommodation/{id}/details", "AccommodationController@show");
    Route::get('message/{id}/show', "SystemController@showMessage");
    Route::post('message/read/{id}', "SystemController@readMessage");
    Route::delete('message/{id}/delete', "SystemController@showMessage");
    Route::get('prebooking/{id}/show', "BookingController@showPrebooking");
    Route::delete('prebooking/{id}/delete', "BookingController@deletePrebooking");
    Route::get('booking/{id}/show', "BookingController@showBooking");
    Route::post('message/send', "UserController@sendMessage");
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


Route::get("prueba", function(){
    return view("emails.confirmBooking");
});
Route::get("user/check/email/{email}","UserController@existsEmail");
Route::get("contact",function(){
    return view("account.contact");
});
Route::post("sendQuestion", "UserController@sendQuestion");