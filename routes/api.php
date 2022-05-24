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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/todos/get', 'App\Http\Controllers\TodosController@GetTodos');
Route::middleware('check.auth:api')->post('/todos/add', 'App\Http\Controllers\TodosController@AddTodos');
Route::middleware('check.auth:api')->post('/todos/update', 'App\Http\Controllers\TodosController@UpdateTodos');
Route::middleware('check.auth:api')->post('/todos/delete', 'App\Http\Controllers\TodosController@DeleteTodos');

Route::post('auth/register', 'App\Http\Controllers\AuthController@Registration');
Route::post('auth/login', 'App\Http\Controllers\AuthController@Login');
Route::middleware('check.auth:api')->post('auth/logout', 'App\Http\Controllers\AuthController@Logout');
