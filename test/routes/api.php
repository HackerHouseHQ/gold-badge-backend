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
	Route::post('register', 'UserController@register');
	// Route::post('forget-password', 'API\UserController@forget_password');
	// Route::post('verify-otp', 'API\UserController@verify_otp');
	// Route::post('reset-password', 'API\UserController@reset_password');
// });
