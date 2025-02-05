<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Chat;

Route::get('/messages', [MessageController::class, 'index']);
Route::post('/messages', [MessageController::class, 'store']);
Route::get('/chat', Chat::class);
