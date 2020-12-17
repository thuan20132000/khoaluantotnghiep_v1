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
Route::get('shoppingcart','HomeController@shoppingcart');
Route::get('listJob','HomeController@listJob');
Route::get('shop_detail','HomeController@shop_detail');
Route::get('user','HomeController@custommer');
Route::get('jobCategory/{id}','HomeController@jobCategory');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();



Route::group(['prefix' => '', 'middleware' => ['web', 'auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

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



    Route::get('/admin/job-confirm', 'JobConfirmController@index')->name('jobconfirm.index');
    Route::post('/admin/job-confirm', 'JobConfirmController@confirmJobCollaborator')->name('jobconfirm.post');
    Route::delete('/admin/job-confirm/{id}', 'JobConfirmController@destroy')->name('jobconfirm.destroy');

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
Route::get('vieclam','HomeController@quanly');
Route::get('ungtuyen','HomeController@getungtuyen');
Route::post('ungtuyen','HomeController@postungtuyen')->name('post.ungtuyen');
