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
    Route::get('/', 'App\Http\Controllers\productController@ajaxAll');
    Route::get('{product}', 'App\Http\Controllers\productController@ajaxOne');
    Route::get('{product_id}/paginate', 'App\Http\Controllers\BillController@getBillsForProductId');
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
    Route::get('/paginate', 'App\Http\Controllers\BillController@paginate');
    Route::get('/delivery', 'App\Http\Controllers\BillController@delivery');
    Route::post('/order/{order}', 'App\Http\Controllers\BillController@orderDone');
    Route::get('{bill}', 'App\Http\Controllers\BillController@ajaxOne');
    Route::delete('{bill}', 'App\Http\Controllers\BillController@destroy');
    Route::patch('{bill}', 'App\Http\Controllers\BillController@restore');
});
Route::prefix("expenses")->group(function () {
    Route::post('/', 'App\Http\Controllers\ExpensesController@store');
    Route::get('paginate', 'App\Http\Controllers\ExpensesController@ajaxAll');

    Route::get('{expenses}', 'App\Http\Controllers\ExpensesController@ajaxOne');
    Route::post('{expenses}', 'App\Http\Controllers\ExpensesController@update');
    Route::delete('{expenses}', 'App\Http\Controllers\ExpensesController@destroy');
    Route::patch('{expenses}', 'App\Http\Controllers\ExpensesController@restore');

});
Route::prefix("staffs")->group(function () {
    Route::post('/', 'App\Http\Controllers\StaffController@store');
    Route::get('/', 'App\Http\Controllers\StaffController@ajaxAll');
    Route::get('{staff}', 'App\Http\Controllers\StaffController@ajaxOne');
    Route::post('{staff}', 'App\Http\Controllers\StaffController@update');
    Route::post('/salary/{staff}', 'App\Http\Controllers\StaffController@salary');
    Route::delete('{staff}', 'App\Http\Controllers\StaffController@destroy');
    Route::patch('{staff}', 'App\Http\Controllers\StaffController@restore');

});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
