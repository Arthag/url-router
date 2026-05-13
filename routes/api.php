<?php

use App\Http\Controllers\UrlRouterController;
use Illuminate\Support\Facades\Route;

Route::post('/create', [UrlRouterController::class, 'create']);
Route::get('/r/{slug}', [UrlRouterController::class, 'redirect']);
Route::post('/deact', [UrlRouterController::class, 'deactivate']);
Route::get('/statistic/{slug}', [UrlRouterController::class, 'statistic']);



//Fallback if no route matches
Route::view('/{any}', 'app')->where('any', '.*');