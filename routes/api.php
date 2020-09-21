<?php
// echo"fghj"; die;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::group(['prefix' => 'user'], function () {
// Route::post('login', 'API\UserController@login');
// Route::post('social-login', 'API\UserController@social_login');

use Illuminate\Support\Facades\Route;

Route::post('register', 'UserController@register');
// Route::post('forget-password', 'API\UserController@forget_password');
// Route::post('verify-otp', 'API\UserController@verify_otp');
// Route::post('reset-password', 'API\UserController@reset_password');
// }); 
Route::group(['prefix' => 'guest', 'namespace' => 'Api\User'], function () {
	Route::post('/login', 'GuestController@guestLogin');
	Route::post('/logout', 'GuestController@guestLogout');
	Route::get('/homepage', 'GuestController@homePage');
});
Route::group(['prefix' => 'user', 'namespace' => 'Api\User'], function () {
	Route::get('/countryList', 'UserController@getCountryList');
	Route::post('/stateList', 'UserController@getStateList');
	Route::post('/cityList', 'UserController@getCityList');
	Route::post('/checkMobileNo', 'UserController@checkMobileNoExistence');
	Route::post('/DepartmentList', 'UserController@DepartmentList');
	Route::post('/signUp', 'UserController@signUp');
	Route::post('/login', 'UserController@login');
	Route::post('/checkUserNameEmail', 'UserController@checkUserNameEmail');
	Route::group(['middleware' => ['auth:api']], function () {
		Route::post('/savePostReview', 'UserController@savePostReview');
		Route::post('/getPostDepartment', 'UserController@getPostDepartment');
		Route::post('/savePostDepartmentLike', 'UserController@savePostDepartmentLike');
		Route::post('/savePostDepartmentShare', 'UserController@savePostDepartmentShare');
		Route::post('/savePostDepartmentComment', 'UserController@savePostDepartmentComment');
		Route::post('/savePostDepartmentSubComment', 'UserController@savePostDepartmentSubComment');
		Route::post('/getPostDepartmentCommentList', 'UserController@getPostDepartmentCommentList');
		Route::post('/savePostReport', 'UserController@savePostReport');
		Route::post('/savePostVote', 'UserController@savePostVote');
		Route::post('/deparmentBadgeList', 'UserController@deparmentBadgeList');
	});
});
