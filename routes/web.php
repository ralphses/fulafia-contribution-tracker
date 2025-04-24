<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\ContributionSchemeController;
use App\Http\Controllers\CorperativeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Example Routes
Route::view('/', 'landing');
Route::match(['get', 'post'], '/dashboard', function(){
    return view('dashboard');
});
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');


Route::prefix("dashboard")->middleware(['auth'])->group(function(){

    Route::get("", [DashboardController::class, "index"])->name("dashboard");

    Route::prefix("recent-contributions")->group(function() {
        Route::get("", [ContributionController::class, "index"])->name("contributions.recent");
//        Route::get("/{id}", [ContributionController::class, "show"])->name("contributions.recent.show");
        Route::get("/add", [ContributionController::class, "create"])->name("contributions.recent.create");
        Route::post("/add", [ContributionController::class, "store"])->name("contributions.recent.store");
    });

    Route::prefix("contribution-schemes")->group(function() {
        Route::get("", [ContributionSchemeController::class, "index"])->name("contributions.schemes");
    });

    Route::prefix("cooperatives")->group(function() {

        Route::get("", [CorperativeController::class, "index"])->name("cooperatives");

    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{id}', [UserController::class, 'show'])->name('show');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{id}', [UserController::class, 'update'])->name('update');
        Route::patch('{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});


// Registration Routes
Route::get('register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthenticationController::class, 'register']);

// Login Routes
Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthenticationController::class, 'login']);

// Logout Route
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
