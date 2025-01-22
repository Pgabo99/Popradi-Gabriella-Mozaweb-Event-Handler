<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Routes for logged in users
Route::middleware("auth")->group(function () {
    //User
    Route::get('/', function () {
        return view('welcome'); })->name('home');
    Route::post("/logout", [AuthController::class, "logoutPost"])->name("logout.post");
    Route::resource("user", UserController::class)->only("show", "edit", "update", "destroy");
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