<?php

use App\Http\Controllers\ContributionSchemeController;
use App\Http\Controllers\CorperativeController;
use Illuminate\Support\Facades\Route;


Route::get('/cooperatives/{cooperative}/schemes', [CorperativeController::class, 'getSchemes']);
Route::get('/contribution-schemes/{scheme}/user-contributions', [ContributionSchemeController::class, 'getUserContributions']);
