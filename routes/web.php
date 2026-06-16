<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - The Lost Compass
|--------------------------------------------------------------------------
|
| Frontend-only routes serving Blade views.
| No controllers needed — each route returns its view directly.
|
*/

// Home
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Characters
Route::get('/characters', function () {
    return view('pages.characters');
})->name('characters');

// Ships
Route::get('/ships', function () {
    return view('pages.ships');
})->name('ships');

// Map
Route::get('/map', function () {
    return view('pages.map');
})->name('map');

// Missions
Route::get('/missions', function () {
    return view('pages.missions');
})->name('missions');

// Relics
Route::get('/relics', function () {
    return view('pages.relics');
})->name('relics');

// Rankings
Route::get('/rankings', function () {
    return view('pages.rankings');
})->name('rankings');

// Tavern
Route::get('/tavern', function () {
    return view('pages.tavern');
})->name('tavern');

// Profile
Route::get('/profile', function () {
    return view('pages.profile');
})->name('profile');

// Quiz
Route::get('/quiz', function () {
    return view('pages.quiz');
})->name('quiz');

// Auth Pages (frontend only, no backend logic yet)
Route::get('/login', function () {
    return view('pages.login');
})->name('login');

Route::get('/signup', function () {
    return view('pages.signup');
})->name('signup');
