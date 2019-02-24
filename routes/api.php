<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    // 'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {  

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::post("password/email","Auth\ForgotPasswordController@sendResetLinkEmail");
    Route::post("password/reset","Auth\ResetPasswordController@resetPasswordHandler");

});



Route::post("/course/wish","CourseController@wish");


//--------------------------尚未遷移--------------------------
// Route::get('/api/{activityId}', "PublicController@Spa");
Route::get('/user/activity', "ApiController@getAllRegistedEvent");
Route::get('/user/list', "ApiController@getUserList");
Route::get('/user/equipment', "ApiController@getEquipmentList");

Route::resource('page',"PageController");
Route::resource('activity',"ActivityController");
Route::resource('question',"QuestionController");
Route::resource('qainfo',"QAinfoController");
Route::resource('post',"PostController");
Route::resource('teammember',"TeammemberController");
Route::post("/course/updateAll","CourseController@updateAll");
Route::resource('course',"CourseController");
Route::post("/teammember/updateAll","TeammemberController@updateAll");
Route::resource('equipment',"EquipmentController");


//活動相關api
Route::get('/activity/list/{activityId}', "ApiController@getEventRegisterList");
Route::post('/activity/list',"ActivityController@getList");
Route::get('/activity/{activityId}/status', "ActivityController@getActivityStatus");
Route::post('/activity/{activityId}/register', "ActivityController@registActivity");
Route::post('/activity/{activityId}/cancel', "ActivityController@cancelRegistActivity");


Route::get("/equipment/all","ApiController@getEquipmentListAll");

Route::post("/equipment/rent","EquipmentController@rent");
Route::post("/equipment/confirm","EquipmentController@confirm");

// Route::get('/activity/{activityId}', "ActivityController@Activity");

//管理員確認報名
Route::post('/activity/record/{recordId}/confirm/{action}', "ActivityController@ConfirmRecord");
Route::post('/activity/record/{recordId}/confirm', "ActivityController@ConfirmRecord");
Route::get('/activity/{activityId}/mail/{action}', "ActivityController@previewMail");

Route::get('/activity/{activityId}/register', "ActivityController@registActivity");
Route::get('/activity/{activityId}/status', "ActivityController@getActivityStatus");

//----------------------------------------------------

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('upload',"ApiController@upload_image");

Route::group(['middleware' => ['auth:api']],function(){
    Route::get('/test',function(){return 'yeah';});
});
Route::get('/siteinfo/{title}','ApiController@siteInfo');

// Route::group([],function(){
//     Route::get("activity/{id}","ApiController@getActivityById");
//     Route::get("activity/","ApiController@getAllActivities");
// });

Route::get('/color',"ApiController@get_color");