<?php

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'Auth\LoginController@index');
});

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', function () {
  return view('welcome');
});
Route::get('/forgot-password', 'Auth\ForgotPasswordController@forgotPasswordPage')->name('forgot-password');
Route::post('/forgot-mail', 'Auth\ForgotPasswordController@forgot_password')->name('forgot-mail');

Auth::routes();

Route::group(['middleware' => ['auth:admin']], function () {

  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/change-password', 'HomeController@change_password')->name('change-password');
  Route::post('/changePassword', 'HomeController@change_password_save')->name('changePassword');




  // Route::group(['prefix' => 'user_management'], function () {

  //   Route::get('/user', 'UserController@index')->name('user');
  //   Route::get('/user_list', 'UserController@user_list')->name('userList');
  //   Route::get('/userReviewList', 'UserController@userReviewList')->name('userReviewList');
  //   Route::post('/change_status', 'UserController@change_status')->name('change_status');
  //   Route::get('/UserDetail', 'UserController@UserDetail')->name('UserDetail');
  //   Route::get('/UserDetailFollowing', 'UserController@UserDetailFollowing')->name('UserDetailFollowing');
  //   Route::get('/UserDetailFollowingBadge', 'UserController@UserDetailFollowingBadge')->name('UserDetailFollowingBadge');
  //   Route::get('/departmentRequest', 'UserController@departmentRequest')->name('departmentRequest');
  //   Route::get('/deprtmentPendingRequest', 'UserController@deprtmentPendingRequest')->name('deprtmentPendingRequest');
  //   Route::get('/deprtmentRejectRequest', 'UserController@deprtmentRejectRequest')->name('deprtmentRejectRequest');
  //   Route::post('/acceptDepartmentRequest', 'UserController@acceptDepartmentRequest')->name('acceptDepartmentRequest');
  //   Route::get('/UserRequestData', 'UserController@UserRequestData')->name('UserRequestData');

  // });

  Route::group(['prefix' => 'user_management'], function () {

    Route::get('/user', 'UserController@index')->name('user');
    Route::get('/user_list', 'UserController@user_list')->name('userList');
    Route::post('/change_status', 'UserController@change_status')->name('change_status');
    Route::get('/UserDetail', 'UserController@UserDetail')->name('UserDetail');
    Route::get('/UserDetailData', 'UserController@UserDetailData')->name('UserDetailData');
    Route::get('/UserDetailFollowing', 'UserController@UserDetailFollowing')->name('UserDetailFollowing');
    Route::get('/UserDetailFollowingData', 'UserController@UserDetailFollowingData')->name('UserDetailFollowingData');
    Route::get('/UserDetailFollowingBadge', 'UserController@UserDetailFollowingBadge')->name('UserDetailFollowingBadge');
    Route::get('/UserDetailFollowingBadgeData', 'UserController@UserDetailFollowingBadgeData')->name('UserDetailFollowingBadgeData');

    Route::get('/deprtmentPendingRequest', 'UserController@deprtmentPendingRequest')->name('deprtmentPendingRequest');
    Route::get('/deprtmentRejectRequest', 'UserController@deprtmentRejectRequest')->name('deprtmentRejectRequest');
    Route::post('/acceptDepartmentRequest', 'UserController@acceptDepartmentRequest')->name('acceptDepartmentRequest');
    Route::get('/departmentRequest', 'UserController@departmentRequest')->name('departmentRequest');
    Route::get('/UserRequestData', 'UserController@UserRequestData')->name('UserRequestData');
    Route::get('/viewUserDetailModel/{id?}', 'UserController@viewUserDetailModel')->name('viewUserDetailModel');
    Route::get('/viewUserDetailLikeModel/{id?}', 'UserController@viewUserDetailLikeModel')->name('viewUserDetailLikeModel');
    Route::get('/viewUserDetailShareModel/{id?}', 'UserController@viewUserDetailShareModel')->name('viewUserDetailShareModel');
    Route::get('/viewUserDetailCommentModel/{id?}', 'UserController@viewUserDetailCommentModel')->name('viewUserDetailCommentModel');
    Route::get('/viewUserDetailBadgeRating/{id?}', 'UserController@viewUserDetailBadgeRating')->name('viewUserDetailBadgeRating');
    Route::get('/viewUserDetailVoteRating/{id?}', 'UserController@viewUserDetailVoteRating')->name('viewUserDetailVoteRating');
    Route::get('/delete_post', 'PostController@delete_post')->name('delete_post');
  });




  Route::group(['prefix' => 'department_management'], function () {
    Route::get('/department', 'DepartmentController@department')->name('department');
    Route::get('/badge', 'DepartmentController@badge')->name('badge');
    Route::post('/AddDepartment', 'DepartmentController@AddDepartment')->name('AddDepartment');
    Route::get('/department_list', 'DepartmentController@department_list')->name('department_list');
    Route::get('/DepartmentDetail', 'DepartmentController@DepartmentDetail')->name('DepartmentDetail');
    Route::get('/viewDepartmentBadgeModel/{id?}', 'DepartmentController@viewDepartmentBadgeModel')->name('viewDepartmentBadgeModel');
    Route::post('/department_status', 'DepartmentController@department_status')->name('department_status');
    Route::get('/department_profile_list', 'DepartmentController@department_profile_list')->name('department_profile_list');


    Route::post('/AddBadge', 'DepartmentController@AddBadge')->name('AddBadge');
    Route::get('/badge_list', 'DepartmentController@badge_list')->name('badge_list');
    Route::post('/badge_status', 'DepartmentController@badge_status')->name('badge_status');
    Route::get('/BadgeDetail', 'DepartmentController@BadgeDetail')->name('BadgeDetail');
    Route::get('/departmentExport', 'DepartmentController@departmentExport')->name('export');
    Route::get('/badgeExport', 'DepartmentController@badgeExport')->name('badgeExport');

    //Route::get('/departmentNewRequest', 'DepartmentController@department_new_request')->name('departmentNewRequest');

  });

  Route::group(['prefix' => 'post'], function () {
    Route::get('/posts', 'PostController@posts')->name('post-list');
    Route::get('/post-list', 'PostController@post_list')->name('postData');
    Route::get('/postViewDetail', 'PostController@postViewDetail')->name('postViewDetail');
    Route::get('/PostDepartmentDetail', 'PostController@PostDepartmentDetail')->name('PostDepartmentDetail');
    Route::post('/delete_post', 'PostController@delete_post')->name('delete_post');
    Route::post('/delete_post_user', 'PostController@delete_post_user')->name('delete_post_user');
  });


  Route::group(['prefix' => 'manage_data'], function () {
    Route::get('/countries', 'ManageDataController@countries')->name('countries');
    Route::get('/countries_list', 'ManageDataController@countries_list')->name('countryList');
    Route::get('/add_country', 'ManageDataController@add_country_page')->name('add_country_page');
    Route::post('/insert_country', 'ManageDataController@add_country')->name('add_country');
    Route::get('/viewCityModel/{id?}', 'ManageDataController@viewCityModel')->name('viewCityModel');
    Route::get('/editCityModelView', 'ManageDataController@editCityModelView')->name('editCityModelView');
    Route::post('/editCounty', 'ManageDataController@editCountry')->name('editCountry');
    Route::get('/viewDeparmentModel/{id?}', 'ManageDataController@viewDeparmentModel')->name('viewDeparmentModel');



    Route::get('/add_state', 'ManageDataController@add_state_page')->name('add_state_page');
    Route::post('/insert_state', 'ManageDataController@add_state')->name('add_state');
    Route::get('/get_state', 'ManageDataController@get_state')->name('get_state');
    Route::get('/get_city', 'ManageDataController@get_city')->name('get_city');
    Route::get('/add_city', 'ManageDataController@add_city_page')->name('add_city_page');
    Route::post('/insert_city', 'ManageDataController@add_city')->name('add_city');
    Route::post('/editState', 'ManageDataController@editState')->name('editState');



    Route::get('/add_ethnicity', 'ManageDataController@add_ethnicity_page')->name('add_ethnicity_page');
    Route::post('/insert_ethnicity', 'ManageDataController@add_ethnicity')->name('add_ethnicity');
    Route::get('/ethnicity', 'ManageDataController@ethnicity')->name('ethnicity');
    Route::get('/DeleteEthnicity/{id}', 'ManageDataController@DeleteEthnicity')->name('DeleteEthnicity');
    Route::get('/Show_edit_ethnicity/{id?}', 'ManageDataController@Show_edit_ethnicity')->name('Show_edit_ethnicity');
    Route::get('/updatEthnicity', 'ManageDataController@updatEthnicity')->name('updatEthnicity');

    Route::get('/gender', 'ManageDataController@gender')->name('gender');
    Route::get('/Show_edit_gender/{id?}', 'ManageDataController@Show_edit_gender')->name('Show_edit_gender');
    Route::get('/AddGender', 'ManageDataController@AddGender')->name('AddGender');
    Route::get('/updateGender', 'ManageDataController@updateGender')->name('updateGender');
    Route::get('/DeleteGender/{id}', 'ManageDataController@DeleteGender')->name('DeleteGender');

    Route::get('/report', 'ManageDataController@report')->name('report');
    Route::get('/Show_edit_report/{id?}', 'ManageDataController@Show_edit_report')->name('Show_edit_report');
    Route::post('/AddReport', 'ManageDataController@AddReport')->name('AddReport');
    Route::get('/add-report', 'ManageDataController@showAddReportform')->name('showAddReportform');
    Route::get('/updatReport', 'ManageDataController@updatReport')->name('updatReport');
    Route::get('/DeleteReport/{id}', 'ManageDataController@DeleteReport')->name('DeleteReport');
    Route::get('/countryExport', 'ManageDataController@countryExport')->name('countryExport');
    Route::get('/cityExport', 'ManageDataController@cityExport')->name('cityExport');
    Route::get('/stateExport', 'ManageDataController@stateExport')->name('stateExport');
    Route::get('/reportExport', 'ManageDataController@reportExport')->name('reportExport');
    Route::get('/ethnicityExport', 'ManageDataController@ethnicityExport')->name('ethnicityExport');
  });

  Route::group(['prefix' => 'cms'], function () {
    Route::get('/about_us', 'InformationManagementController@about_us')->name('about_us');
    Route::post('/edit_about_us', 'InformationManagementController@edit_about_us')->name('edit_about_us');
    Route::get('/privacy', 'InformationManagementController@privacy')->name('privacy');
    Route::post('/edit_privacy', 'InformationManagementController@edit_privacy')->name('edit_privacy');
    Route::get('/terms', 'InformationManagementController@terms')->name('terms');
    Route::post('/edit_terms', 'InformationManagementController@edit_terms')->name('edit_terms');
    Route::get('/notification', 'InformationManagementController@notification')->name('notification');
    Route::get('/sendNotification', 'InformationManagementController@sendNotification')->name('sendNotification');
    Route::get('/notificationList', 'InformationManagementController@notificationList')->name('notificationList');
    Route::post('/downloadNotification', 'InformationManagementController@downloadNotification')->name('downloadNotification');
    Route::get('/viewNotificationModel/{id?}', 'InformationManagementController@getNotificationDetail')->name('viewNotificationModel');
  });
});
