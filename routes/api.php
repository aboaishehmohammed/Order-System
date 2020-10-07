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

Route::prefix("categories")->group(function () {
    Route::post('/', 'App\Http\Controllers\CategoryController@store');
    Route::get('{category}', 'App\Http\Controllers\CategoryController@ajaxOne');
    Route::get('/', 'App\Http\Controllers\CategoryController@ajaxAll');
    Route::post('{category}', 'App\Http\Controllers\CategoryController@update');
    Route::delete('{category}', 'App\Http\Controllers\CategoryController@destroy');
    Route::patch('{category}', 'App\Http\Controllers\CategoryController@restore');

});
Route::prefix("products")->group(function () {
    Route::post('/', 'App\Http\Controllers\productController@store');
    Route::get('{product}', 'App\Http\Controllers\productController@ajaxOne');
    Route::get('/', 'App\Http\Controllers\productController@ajaxAll');
    Route::post('{product}', 'App\Http\Controllers\productController@update');
    Route::delete('{product}', 'App\Http\Controllers\productController@destroy');
    Route::patch('{product}', 'App\Http\Controllers\productController@restore');

});
Route::prefix("sub-products")->group(function () {
    Route::post('/', 'App\Http\Controllers\SubProductController@store');
    Route::get('{sub}', 'App\Http\Controllers\SubProductController@ajaxOne');
    Route::get('/', 'App\Http\Controllers\SubProductController@ajaxAll');
    Route::post('{sub}', 'App\Http\Controllers\SubProductController@update');
    Route::delete('{sub}', 'App\Http\Controllers\SubProductController@destroy');
    Route::patch('{sub}', 'App\Http\Controllers\SubProductController@restore');

});
Route::prefix("bills")->group(function () {
    Route::post('/', 'App\Http\Controllers\BillController@store');
    Route::get('{bill}', 'App\Http\Controllers\BillController@ajaxOne');
    Route::get('/', 'App\Http\Controllers\BillController@ajaxAll');
    Route::delete('{bill}', 'App\Http\Controllers\BillController@destroy');
    Route::patch('{bill}', 'App\Http\Controllers\BillController@restore');
});
Route::prefix("expenses")->group(function () {
    Route::post('/', 'App\Http\Controllers\ExpensesController@store');
    Route::get('{expenses}', 'App\Http\Controllers\ExpensesController@ajaxOne');
    Route::get('/', 'App\Http\Controllers\ExpensesController@ajaxAll');
    Route::post('{expenses}', 'App\Http\Controllers\ExpensesController@update');
    Route::delete('{expenses}', 'App\Http\Controllers\ExpensesController@destroy');
    Route::patch('{expenses}', 'App\Http\Controllers\ExpensesController@restore');

});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
