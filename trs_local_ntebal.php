<?php
Route::group(['namespace' => 'Trs\Local', 'middleware' => ['web', 'auth']], function () {
	Route::resource('/trs_local_ntebal', 'NtebalController');
	Route::get('/trs_local_ntebal_list', 'NtebalController@getList');
	Route::get('/trs_local_ntebal_lookup', 'NtebalController@getLookup');
});