<?php

/*Route::get('/', function(){
	return response()->json(['message'=> 'Hola mundo'], 200);
});*/

//Public routes
Route::get('me', 'User\MeController@getMe');

// Route group for authenticated users only
Route::group(['middleware' => ['auth:api']], function(){

 	Route::post('logout', 'Auth\LoginController@logout');

 	Route::put('settings/profile', 'User\SettingsController@updateProfile');
 	Route::put('settings/password', 'User\SettingsController@updatePassword');

 	//Rutas para categoria
 	Route::get('categories', 'Producto\CategoriaController@index');
 	Route::post('category/register', 'Producto\CategoriaController@store');


});



// Routes for guests only
Route::group(['middleware' => ['guest:api']], function(){
	Route::post('register', 'Auth\RegisterController@register');
	Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
 	Route::post('verification/resend', 'Auth\VerificationController@resend');
 	Route::post('login', 'Auth\LoginController@login');
 	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
 	Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});
