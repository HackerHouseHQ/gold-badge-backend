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

use App\Http\Controllers\Api\User\GalleryController;
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
	Route::get('auth/user/{user_id}', 'ChatController@auth_user');
	Route::get('/chat/list/{sender_id}/{receiver_id}', 'ChatController@user_chat_list');
	Route::post('/send_message', 'ChatController@send_message');
	Route::post('/send-otp', 'LoginController@sendOtpToMail');
	Route::post('/verifyOtp', 'LoginController@verifyOtp');
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
		Route::post('/saveSubCommentLike', 'PostController@saveSubCommentLike');
		Route::post('/saveCommentLike', 'PostController@saveCommentLike');
		Route::post('/savePostDepartmentShare', 'UserController@savePostDepartmentShare');
		Route::post('/savePostDepartmentComment', 'UserController@savePostDepartmentComment');
		Route::post('/savePostDepartmentSubComment', 'UserController@savePostDepartmentSubComment');
		Route::post('/getPostDepartmentCommentList', 'UserController@getPostDepartmentCommentList');
		Route::post('/savePostReport', 'UserController@savePostReport');
		Route::post('/savePostVote', 'UserController@savePostVote');
		Route::post('/deparmentBadgeList', 'UserController@deparmentBadgeList');
		Route::post('/saveDepartmentRequest', 'DepartmentController@saveDepartmentRequest');
		Route::get('/reasonList', 'ManageDataController@reasonQuestionList');
		Route::post('/postProfile', 'PostController@postProfile');
		Route::post('/departmentFollow', 'DepartmentController@departmentFollow');
		Route::post('/myActivity', 'PostController@myActivity');
		Route::post('/chats/list', 'ChatController@user_list');
		Route::post('/saveGalleryImage', 'GalleryController@saveGalleryImage');
		Route::get('/getGalleryImage', 'GalleryController@getGalleryImage');
		Route::post('/deleteGalleryImage', 'GalleryController@deleteGalleryImage');
		Route::get('/getNotification', 'InformationManagementController@getNotification');
	});
});
