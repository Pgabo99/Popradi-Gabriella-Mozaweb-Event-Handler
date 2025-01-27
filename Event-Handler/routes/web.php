<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InviteesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//Routes for logged in users
Route::middleware("auth")->group(function () {
    //User
    Route::get('/',[EventController::class, 'show'] )->name('home');
    Route::post("/logout", [AuthController::class, "logoutPost"])->name("logout.post");
    Route::get('/user/events', [EventController::class, 'showUserEvent'])->name('user.events');
    Route::resource("user", UserController::class)->only("show", "edit", "update", "destroy");

    //Events
    Route::get('/events/index', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::delete('/events/{id}/delete', [EventController::class, 'destroy'])->name('events.destroy');

    //Invitees
    Route::post('/invitees/store', [InviteesController::class, 'store'])->name('invitees.store');
    Route::get('/invitees/{user_id}/{event_id}/getone', [InviteesController::class, 'getOne'])->name('invitees.getOne');
    Route::delete('/invitees/{user_id}/{event_id}/delete', [InviteesController::class, 'destroy'])->name('invitees.destroy');
    Route::get('/invitees/{event_id}/index', [InviteesController::class, 'index'])->name('invitees.index');
    Route::get('/invitees/{event_id}/create', [InviteesController::class, 'create'])->name('invitees.create');
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