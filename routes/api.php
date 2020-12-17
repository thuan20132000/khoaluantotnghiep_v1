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
    Route::get('job/{author_id}/approved','Api\JobController@getJobsApproved');

    /**
     *
     */
    Route::get('job/{author_id}/status/pending','Api\JobController@getPendingJobsByAuthor');
    Route::get('job/{author_id}/status/approved','Api\JobController@getApprovedJobsByAuthor');
    Route::get('job/{author_id}/status/confirmed','Api\JobController@getConfirmedJobsByAuthor');

    Route::delete('job/{author_id}/delete/{job_id}','Api\JobController@deleteJobByAUthor');




    /**
     *
     */
    Route::resource('job-collaborator', 'Api\JobCollaborator');
    Route::post('job/select-candidate','Api\JobCollaborator@selectCandidate');
    Route::post('job/confirm-candidate','Api\JobCollaborator@confirmCandidate');



    /**
     *
     */
    // Route::get('collaborator/{id}/detail','Api\CollaboratorController@getCollaboratorDetail');
    Route::resource('collaborators','Api\CollaboratorController');




    Route::get('job-collaborator-applying','Api\JobCollaborator@getJobCollaboratorApplying');

    Route::get('jobcollaborator/{user_id}/status/{status}','Api\JobCollaborator@getJobCollaboratorStatus');

    // Route::get('job-collaborator/{author_id}/status/{status}','Api\JobCollaborator@getJobCollaboratorStatusByAuthor');
    Route::get('job-collaborator-confirm','Api\JobCollaborator@confirmJobCollaborator');

    Route::put('user/{id}', 'Api\UserController@update');
    Route::get('user/{id}','Api\UserController@show');
    Route::post('login', 'Api\UserController@login');
    Route::post('register', 'Api\UserController@register');


    /**
     *
     */
    Route::get('jobconfirm/{user_id}','Api\JobConfirmController@getUserConfirmJob');
    Route::post('jobconfirm','Api\JobConfirmController@confirmJobCollaborator');


    /**
     *
     */
    Route::get('job-sort','Api\JobController@sortJob');

    Route::get('job-search','Api\JobController@searchJob');
    Route::get('collaborator-search','Api\CollaboratorController@search');




});
