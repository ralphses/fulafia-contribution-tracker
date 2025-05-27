<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\ContributionSchemeController;
use App\Http\Controllers\CorperativeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserContributionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Example Routes
Route::middleware(['auth'])->group(function () {
    Route::view('/', 'landing');
    Route::match(['get', 'post'], '/dashboard', function(){
        return view('dashboard');
    });
    Route::view('/pages/slick', 'pages.slick');
    Route::view('/pages/datatables', 'pages.datatables');
    Route::view('/pages/blank', 'pages.blank');
});


Route::prefix("dashboard")->middleware(['auth'])->group(function(){

    Route::get('/cooperatives/{id}/schemes', [ContributionController::class, 'getSchemesByCooperative']);
    Route::get('/contribution-schemes/{id}/user-contributions', [ContributionController::class, 'getUserContributionsByScheme']);

    Route::get("", [DashboardController::class, "index"])->name("dashboard");

    Route::prefix('my-contributions')->group(function(){
        Route::get("user", [UserContributionController::class, "getUserContributions"])->name("userContributions.user");
        Route::get("users", [UserContributionController::class, "index"])->name("userContributions.users");
        Route::post("users", [UserContributionController::class, "store"])->name("userContributions.create");
    });

    Route::prefix("recent-contributions")->group(function() {
        Route::get("", [ContributionController::class, "index"])->name("contributions.recent");
        Route::get("/add", [ContributionController::class, "create"])->name("contributions.recent.create");
        Route::post("/add", [ContributionController::class, "store"])->name("contributions.recent.store");
    });

    Route::prefix("contribution-schemes")->group(function() {
        Route::get("", [ContributionSchemeController::class, "index"])->name("contributions.schemes");
        Route::get("create", [ContributionSchemeController::class, "create"])->name("contribution-schemes.create");
        Route::post("create", [ContributionSchemeController::class, "store"])->name("contribution-schemes.store");
    });

    Route::prefix("cooperatives")->group(function() {
        Route::get("", [CorperativeController::class, "index"])->name("cooperatives");
        Route::get("create", [CorperativeController::class, "create"])->name("cooperatives.create");
        Route::post("create", [CorperativeController::class, "store"])->name("cooperatives.store");

    });

    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('users');
        Route::get('create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('{id}', [UserController::class, 'update'])->name('users.update');
        Route::patch('{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('users.destroy');
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
