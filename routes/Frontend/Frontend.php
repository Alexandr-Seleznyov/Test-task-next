<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'FrontendController@index')->name('index');

Route::post('childs',  'ApiController@getChildsHtml')->name('childs.get');
Route::post('list/editparent', 'ApiController@editParent')->name('list.editparent');


/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', 'AccountController@index')->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');


        Route::get('positions', 'TaskController@positions')->name('positions');
        Route::get('position/edit', 'PositionController@edit')->name('position.edit');
        Route::post('position/update', 'PositionController@update')->name('position.update');
        Route::get('position/create', 'PositionController@create')->name('position.create');
        Route::post('position/store', 'PositionController@store')->name('position.store');
        Route::post('position/destroy', 'PositionController@destroy')->name('position.destroy');


//        Route::get('test', 'WorkersListController@test')->name('test');

        Route::get('list', 'TaskController@workersList')->name('list');
        Route::post('list', 'TaskController@workersListAjax')->name('list');
        Route::get('list/edit', 'WorkersListController@edit')->name('list.edit');
        Route::post('list/update', 'WorkersListController@update')->name('list.update');
        Route::post('list/destroy', 'WorkersListController@destroy')->name('list.destroy');
        Route::get('list/create', 'WorkersListController@create')->name('list.create');
        Route::post('list/store', 'WorkersListController@store')->name('list.store');

        Route::post('parent', 'TaskController@parentSearch')->name('parent');

        Route::post('preview', 'UploadController@preview')->name('image.preview');
        Route::post('image/delete', 'WorkersListController@deleteImage')->name('image.delete');

    });
});
