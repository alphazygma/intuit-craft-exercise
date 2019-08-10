<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('users/{user}', 'UserController@show');
Route::post('users',       'UserController@store');
Route::put('users/{user}', 'UserController@update');

Route::get('sellers/{user}', 'SellerController@show');   // TBI
Route::post('sellers',       'SellerController@store');  // TBI
Route::put('sellers/{user}', 'SellerController@update'); // TBI

Route::get('buyers/{user}', 'BuyerController@show');   // TBI
Route::post('buyers',       'BuyerController@store');  // TBI
Route::put('buyers/{user}', 'BuyerController@update'); // TBI

Route::get('projects',             'ProjectController@index');
Route::get('projects/page/{page}', 'ProjectController@page');
Route::get('projects/{project}',   'ProjectController@show');
Route::post('projects',            'ProjectController@store');

Route::get('sellers/{seller}/projects',           'SellerProjectController@index'); // TBI
Route::get('sellers/{seller}/projects/{project}', 'SellerProjectController@show');  // TBI

Route::get('project/{project}/bids',  'ProjectBidController@index');
Route::post('project/{project}/bids', 'ProjectBidController@store');


