<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Initial route for list peoples
Route::get('/', function () {
    return redirect()->route('people.index');
});

// Authenticated routes (Login e Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route::get('/teste', [PersonController::class, 'create']);
// Public routes
Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/{person}', [PersonController::class, 'show'])->name('people.show');

// Report route (public)
Route::get('/reports/contacts-by-country', [ReportController::class, 'contactsByCountry'])->name('reports.contacts-by-country');


// Authenticated routes middleware
Route::middleware('auth.check')->group(function () {
//    Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
    Route::get('/create', [PersonController::class, 'create'])->name('people.create');
    Route::post('/people', [PersonController::class, 'store'])->name('people.store');
    Route::get('/people/{person}/edit', [PersonController::class, 'edit'])->name('people.edit');
    Route::put('/people/{person}', [PersonController::class, 'update'])->name('people.update');
    Route::delete('/people/{person}', [PersonController::class, 'destroy'])->name('people.destroy');

    Route::get('/people/{person}/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/people/{person}/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/people/{person}/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/people/{person}/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/people/{person}/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

