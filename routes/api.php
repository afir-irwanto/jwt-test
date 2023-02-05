<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    Route::get('customers', [CustomerController::class, 'index']);
    Route::get('customers/{id}', [CustomerController::class, 'show']);
    Route::post('create', [CustomerController::class, 'store']);
    Route::put('update/{customer}',  [CustomerController::class, 'update']);
    Route::delete('delete/{customer}',  [CustomerController::class, 'destroy']);
    
    Route::post('cust_to_cust', [MessageController::class, 'cust_to_cust']);
    Route::post('staff_to_staff', [MessageController::class, 'staff_to_staff']);
    Route::post('staff_to_cust', [MessageController::class, 'staff_to_cust']);
    Route::get('own_chat/{customer}', [MessageController::class, 'own_chat']);
    Route::get('all_chat', [MessageController::class, 'all_chat']);
    Route::post('report', [ReportController::class, 'report']);
});