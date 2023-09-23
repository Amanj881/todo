<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('task','App\Http\Controllers\TaskController@store')->name('task.store');
Route::post('task/update','App\Http\Controllers\TaskController@update')->name('task.update');
Route::get('task','App\Http\Controllers\TaskController@index')->name('task.index');
Route::post('task/showAll','App\Http\Controllers\TaskController@show')->name('task.showAll');
Route::delete('task/destroy/{id}','App\Http\Controllers\TaskController@destroy')->name('task.destroy');


