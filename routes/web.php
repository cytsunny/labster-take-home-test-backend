<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('user-message', [UserMessageController::class, 'index']);
