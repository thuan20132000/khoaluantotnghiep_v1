<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', 'HomeController@index');
Route::get('checkout','HomeController@checkout');
Route::get('jobsingle/{id}','HomeController@jobsingle');
Route::get('listJob','HomeController@listJob');
Route::get('shop_detail','HomeController@shop_detail');
Route::get('user','HomeController@custommer');
Route::get('jobCategory/{id}','HomeController@jobCategory');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();



Route::group(['prefix' => '', 'middleware' => ['web', 'auth']], function () {
    Route::get('/admin', 'AdminHomeController@index')->name('adminhome');

    Route::resource('/admin/category', 'CategoryController');
    Route::delete('/admin/category', 'CategoryController@destroyMass')->name('destroyMass');

    Route::resource('/admin/occupation', 'OccupationController');
    Route::delete('/admin/occupation', 'OccupationController@destroyMass')->name('destroyMass');

    Route::resource('/admin/user', 'UserController');
    Route::delete('/admin/user', 'UserController@destroyMass')->name('destroyMass');

    Route::resource('/admin/job', 'JobController');
    Route::delete('/admin/job', 'JobController@destroyMass')->name('destroyMass');

    Route::resource('/admin/jobcollaborator', 'JobCollaboratorController');
    Route::post('/admin/add-jobcollaborator', 'JobCollaboratorController@addJobCollaborator')->name('jobcollaborator.add');
    Route::delete('/admin/jobcollaborator', 'JobCollaboratorController@destroyMass')->name('destroyMass');
    Route::get('/admin/jobcollaborator/{id}/status/{status}', 'JobCollaboratorController@updateJobCollaboratorStatus')->name('jobcollaborator.updatestatus');
    Route::get('/admin/jobcollaborator/confirmed','JobCollaboratorController@getConfirmedJob')->name("jobcollaborator.confirmed");


    // Route::get('/admin/job-confirm', 'JobConfirmController@index')->name('jobconfirm.index');
    // Route::post('/admin/job-confirm', 'JobConfirmController@confirmJobCollaborator')->name('jobconfirm.post');
    // Route::delete('/admin/job-confirm/{id}', 'JobConfirmController@destroy')->name('jobconfirm.destroy');

    Route::get('admin/ajax/jobcollaborator/{id}', 'JobCollaboratorController@getAjaxCollaboratorByJob');


});

Route::get('verify/{remember_token}','UserController@verifyUser')->name('user.verify');


Route::post('registerrr','HomeController@registerClient');
Route::post('loginnn','HomeController@postLoginClient');
Route::get('loginn','HomeController@getLogin');
Route::get('registerr','HomeController@getRegister');
Route::get('search','HomeController@getSearch');
Route::get('logout','HomeController@getLogoutClient');
Route::get('search','HomeController@getSearch');
Route::get('postjob','HomeController@postJob');
Route::post('postjob','HomeController@postPostJob')->name('post.job');
Route::get('profile','HomeController@profile');
Route::get('vieclam','HomeController@quanly')->name('quanlyvieclam');
Route::get('ungtuyen','HomeController@getungtuyen');
Route::post('ungtuyen','HomeController@postungtuyen')->name('post.ungtuyen');
Route::get('jobcollaborator/{user_id}/status/{status}','HomeController@getJobCollaborator');
Route::get('editprofile','HomeController@geteditprofile');
Route::post('posteditprofile','HomeController@posteditProfile');





Route::get('collaborator/{collaborator_id}/job/status/{status}','HomeController@getCollaboratorJobByStatus')->name('getCollaboratorJobByStatus');
Route::get('author/{author_id}/job/status/{status}','HomeController@getAuthorJobByStatus')->name('getAuhorJobByStatus');

Route::get('chitietcongviec/{job_id}','HomeController@chitietcongviec')->name('chitietcongviec');
Route::post('postxacnhan','HomeController@postxacnhan')->name('post.xacnhan');