<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Define login route
Route::post('login', [AuthController::class, 'login']);
