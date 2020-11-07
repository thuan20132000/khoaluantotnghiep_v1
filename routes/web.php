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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/admin','HomeController@index');



Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::resource('/admin/category', 'CategoryController');
Route::delete('/admin/category','CategoryController@destroyMass')->name('destroyMass');

Route::resource('/admin/occupation', 'OccupationController');
Route::delete('/admin/occupation','OccupationController@destroyMass')->name('destroyMass');

Route::resource('/admin/user', 'UserController');
Route::delete('/admin/user','UserController@destroyMass')->name('destroyMass');

Route::resource('/admin/job', 'JobController');
Route::delete('/admin/job','JobController@destroyMass')->name('destroyMass');

Route::resource('/admin/jobcollaborator', 'JobCollaboratorController');
Route::post('/admin/add-jobcollaborator','JobCollaboratorController@addJobCollaborator')->name('jobcollaborator.add');
Route::delete('/admin/jobcollaborator','JobCollaboratorController@destroyMass')->name('destroyMass');


Route::get('admin/ajax/jobcollaborator/{id}','JobCollaboratorController@getAjaxCollaboratorByJob');
