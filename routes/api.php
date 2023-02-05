<?php

use App\Http\Controllers\DeeDeeController;
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

/**
 * For simple CRUD, the framework is opinionated, and makes all the boilerplate for you
 * Running the following command with the a flag makes: Model, Controller, Seeder, Factory, Migration, Policy, Request Objects 
 * 
 * php artisan make:model <model_name> -a
 * 
 */ 

Route::apiResource('deedee', DeeDeeController::class);