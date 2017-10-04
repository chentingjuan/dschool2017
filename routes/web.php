<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('verification/{token}', 'Auth\AuthController@getVerification');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/testmail', 'HomeController@testmail');

Auth::routes();


Route::group(["prefix"=>"manage"],function(){
    Route::get('/activity/{activityId}', "ManageController@Activity");
    Route::get('/activity/{activityId}/list', "ManageController@Activity");
    Route::get('/activity/{activityId}/edit', "ManageController@ActivityEdit");
});



Route::group([],function(){
    Route::get('/activity/{activityId}/register', "ActivityController@registActivity");
    Route::get('/activity/{activityId}/status', "ActivityController@getActivityStatus");
    Route::get('/activity/{activityId}/cancel', "ActivityController@cancelRegistActivity");
});

// Route::get('/register_public', 'App\Http\Controllers\Auth\RegisterController@showRegistrationFormPublic');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/userlist', "homeController@userlist");


Route::get('/activity', "PublicController@Activity");
Route::get('/user/activity', "HomeController@RegistedEvent");

Route::get('/activity/{activityId}', "PublicController@Activity");

Route::group(["prefix"=>"api"],function(){
    Route::get('/user/activity', "ApiController@getAllRegistedEvent");
    Route::get('/activity/list/{activityId}', "ApiController@getEventRegisterList");
    Route::resource('activity',"ActivityController");
});

// Route::get('/event', "homeController@event");



//passport
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => '/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);
    return redirect('/oauth/authorize?'.$query);
});
Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;
    $response = $http->post('/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'De2kKabuM4bINufCLFQpzhLoGsx8GHuzI4uLnfx3',
            'redirect_uri' => '/callback',
            'code' => $request->code,
        ],
    ]);
    return json_decode((string) $response->getBody(), true);
});
