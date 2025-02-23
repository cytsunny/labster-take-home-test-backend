<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserMessageController;

Route::post('user-message/store', [UserMessageController::class, 'store']);