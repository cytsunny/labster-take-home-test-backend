<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMessageController;

Route::get('user-messages/show', [UserMessageController::class, 'show']);
Route::post('user-messages/store', [UserMessageController::class, 'store']);
