<?php

Route::get('/', function(){
	return response()->json(['message'=> 'Hola mundo'], 200);
});
