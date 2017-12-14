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
    Route::get('/', "ManageController@Spa");
    Route::get('/user', "ManageController@Spa");
    Route::get('/post', "ManageController@Spa");
    Route::get('/post/{postId}', "ManageController@Spa");
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
Route::get('/implement', 'HomeController@index');

Route::get('/service', 'PublicController@Spa');
Route::get('/about', 'PublicController@Spa');
Route::get('/question', 'PublicController@Spa');
Route::get('/news', 'PublicController@Spa');
Route::get('/news/{news}', 'PublicController@Spa');

Route::get('/service/equipment', 'HomeController@index');

Route::get('/userlist', "homeController@userlist");

Route::get('/activity', "PublicController@Spa");
Route::get('/my/activity', "PublicController@Spa");
Route::get('/user/activity', "HomeController@RegistedEvent");

Route::get('/activity/{activityId}', "PublicController@Activity");


Route::group(["prefix"=>"api"],function(){
    // Route::get('/api/{activityId}', "PublicController@Spa");
    Route::get('/user/activity', "ApiController@getAllRegistedEvent");
    Route::get('/user/list', "ApiController@getUserList");
    
    Route::get('/activity/list/{activityId}', "ApiController@getEventRegisterList");
    Route::post('/activity/list',"ActivityController@getList");
    
    Route::resource('activity',"ActivityController");
    Route::resource('question',"QuestionController");
    Route::resource('post',"PostController");
    Route::resource('teammember',"TeammemberController");
    Route::resource('equipment',"EquipmentController");

    Route::post("/equipment/rent","EquipmentController@rent");
    //管理員確認報名
    Route::post('/activity/record/{recordId}/confirm/{action}', "ActivityController@ConfirmRecord");
    Route::post('/activity/record/{recordId}/confirm', "ActivityController@ConfirmRecord");
    Route::get('/activity/{activityId}/mail/{action}', "ActivityController@previewMail");

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
