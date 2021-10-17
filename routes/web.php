<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'adminMiddleware']], function () {
    Route::get('/', 'Auth\HomeController@index')->name('admin');

    Route::group(['prefix' => 'audio'], function () {
        Route::get('/', 'Admin\AudioController@index')->name('admin.audio');
        Route::get('/get-list', 'Admin\AudioController@getList')->name('admin.audio.list');
        Route::get('create', 'Admin\AudioController@create')->name('admin.audio.create');
        Route::post('store', 'Admin\AudioController@store')->name('admin.audio.store');
        Route::get('{id}/edit', 'Admin\AudioController@edit')->name('admin.audio.edit');
        Route::post('{id}/update', 'Admin\AudioController@update')->name('admin.audio.update');
        Route::get('{id}/delete', 'Admin\AudioController@delete')->name('admin.audio.delete');

        Route::get('{id}/text-audio-sync-edit', 'Admin\AudioController@textAudioSyncEdit')->name('admin.text.audio.sync.edit');
        Route::post('{id}/text-audio-sync-update', 'Admin\AudioController@textAudioSyncUpdate')->name('admin.text.audio.sync.update');
    });
});
