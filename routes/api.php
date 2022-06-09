<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\InvoiceController;

 
Route::post('/login', [LoginController::class, 'login']);
Route::post('/registration', [RegistrationController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function($route){
    $route->get('/user', [LoginController::class, 'user']);
    $route->get('/user/id', [LoginController::class, 'userID']);

    $route->post('/logout', [LoginController::class, 'logout']);
    
    //add invoices to the database
    $route->post('/add/invoice', [InvoiceController::class, 'add']);
    $route->get('/invoice/{id}', [InvoiceController::class, 'index']);
});

