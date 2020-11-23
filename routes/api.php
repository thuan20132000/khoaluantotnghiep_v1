<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['prefix' => 'v1'], function () {
    Route::resource('category', 'Api\CategoryController');
    Route::resource('occupation', 'Api\OccupationController');
    Route::resource('job', 'Api\JobController');
    Route::resource('job-collaborator', 'Api\JobCollaborator');

    Route::put('user/{id}', 'Api\UserController@update');
    Route::post('login', 'Api\UserController@login');
    Route::post('register', 'Api\UserController@register');

    Route::get('job-collaborator-applying','Api\JobCollaborator@getCollaboratorJobApplying');

    Route::get('job-sort','Api\JobController@sortJob');
});
