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
  Route::get('/user_magagement', 'UserController@index')->name('user_magagement');

Route::group(['prefix' => 'manage_data'], function () {
  Route::get('/countries', 'ManageDataController@countries')->name('countries');
  Route::get('/add_country', 'ManageDataController@add_country_page')->name('add_country_page');
  Route::get('/insert_country', 'ManageDataController@add_country')->name('add_country');
  Route::get('/add_state', 'ManageDataController@add_state_page')->name('add_state_page');
  Route::get('/add_city', 'ManageDataController@add_city_page')->name('add_city_page');
  Route::get('/add_ethnicity', 'ManageDataController@add_ethnicity_page')->name('add_ethnicity_page');
 Route::get('/ethnicity', 'ManageDataController@ethnicity')->name('ethnicity');
 Route::get('/gender', 'ManageDataController@gender')->name('gender');
 Route::get('/report', 'ManageDataController@report')->name('report');


});

});

