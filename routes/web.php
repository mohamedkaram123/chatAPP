<?php
Auth::routes();



Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return redirect('chat');
    });

Route::get('chat','ChatController@chat');
Route::post('send','ChatController@send');
Route::post('uploadrecordpublic','ChatController@uploadrecordpublic');

Route::post('sendprivate','ChatController@sendprivate');
Route::post('loadmassegesprivate','ChatController@loadmassegesprivate');

Route::post('uploadrecordprivate','ChatController@uploadrecordprivate');

Route::post('clearchatingprivate','ChatController@clearchatingprivate');

Route::post('uploadfilespublic','ChatController@uploadfilespublic');
Route::post('uploadfileprivate','ChatController@uploadfileprivate');


Route::get('loadmasseges','ChatController@loadmasseges');

Route::get('loadusers','ChatController@loadusers');
});



// Route::get('/home', 'HomeController@index')->name('home');
