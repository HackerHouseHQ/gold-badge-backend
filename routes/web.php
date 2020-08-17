<?php

Route::group(['prefix'=>'admin'], function (){
   Route::get('/login', 'Auth\LoginController@index');
});

// Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::group(['middleware'=>['auth:admin']], function(){
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/user_magagement', 'UserController@index')->name('user_magagement');

Route::group(['prefix' => 'manage_data'], function () {
  Route::get('/manage_data', 'ManageDataController@countries')->name('countries');
  Route::get('/add_country', 'ManageDataController@add_country_page')->name('add_country_page');
});

});

