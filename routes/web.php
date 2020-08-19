<?php

Route::group(['prefix'=>'admin'], function (){
   Route::get('/login', 'Auth\LoginController@index');
});

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::group(['middleware'=>['auth:admin']], function(){
  Route::get('/home', 'HomeController@index')->name('home');
  Route::group(['prefix' => 'user_management'], function () {
    Route::get('/user', 'UserController@index')->name('user');
    Route::get('/user_list', 'UserController@user_list')->name('userList');
    Route::post('/change_status', 'UserController@change_status')->name('change_status');
    Route::get('/UserDetail', 'UserController@UserDetail')->name('UserDetail');
  });


  Route::group(['prefix' => 'department_management'], function () {
    Route::get('/department', 'DepartmentController@department')->name('department');
    Route::get('/badge', 'DepartmentController@badge')->name('badge');
  });



  Route::group(['prefix' => 'manage_data'], function () {
    Route::get('/countries', 'ManageDataController@countries')->name('countries');
    Route::get('/countries_list', 'ManageDataController@countries_list')->name('countryList');

    Route::get('/add_country', 'ManageDataController@add_country_page')->name('add_country_page');
    Route::get('/insert_country', 'ManageDataController@add_country')->name('add_country');
    Route::get('/add_state', 'ManageDataController@add_state_page')->name('add_state_page');
    Route::post('/insert_state', 'ManageDataController@add_state')->name('add_state');
    Route::get('/get_state', 'ManageDataController@get_state')->name('get_state');
    Route::get('/add_city', 'ManageDataController@add_city_page')->name('add_city_page');
    Route::post('/insert_city', 'ManageDataController@add_city')->name('add_city');


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
    Route::get('/AddReport', 'ManageDataController@AddReport')->name('AddReport');
    Route::get('/updatReport', 'ManageDataController@updatReport')->name('updatReport');
    Route::get('/DeleteReport/{id}', 'ManageDataController@DeleteReport')->name('DeleteReport');



  });

  Route::group(['prefix' => 'cms'], function () {
    Route::get('/about_us', 'InformationManagementController@about_us')->name('about_us');
    Route::get('/edit_about_us', 'InformationManagementController@edit_about_us')->name('edit_about_us');
    Route::get('/privacy', 'InformationManagementController@privacy')->name('privacy');
    Route::get('/edit_privacy', 'InformationManagementController@edit_privacy')->name('edit_privacy');
    Route::get('/terms', 'InformationManagementController@terms')->name('terms');
    Route::get('/edit_terms', 'InformationManagementController@edit_terms')->name('edit_terms');
    Route::get('/notification', 'InformationManagementController@notification')->name('notification');
    // Route::post('/send_notification', 'InformationManagementController@send_notification')->name('send_notification');
  });

});

