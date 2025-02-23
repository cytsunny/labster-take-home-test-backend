<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMessageController;

Route::get('user-message', [UserMessageController::class, 'index']);
Route::post('user-message/{id}', [UserMessageController::class, 'update']);