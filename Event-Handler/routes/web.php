<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Routes for logged in users
Route::middleware("auth")->group(function () {
    //User
    Route::get('/', function () {
        return view('welcome'); })->name('home');
    Route::post("/logout", [AuthController::class, "logoutPost"])->name("logout.post");
    Route::resource("user", UserController::class)->only("show", "edit", "update", "destroy");

    //Events
    Route::get('/events/index', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::delete('/events/{id}/delete', [EventController::class, 'destroy'])->name('events.destroy');
});

//Routes for Guests
Route::middleware("guest")->group(function () {
    //Login
    Route::get("/login", [AuthController::class, "login"])->name("login");
    Route::post("/login", [AuthController::class, "loginPost"])->name("login.post");

    //Register
    Route::get("/register", [AuthController::class, "register"])->name("register");
    Route::post("/register", [AuthController::class, "registerPost"])->name(name: "register.post");
});