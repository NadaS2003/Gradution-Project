<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('splash');
});
#############################################################################################3

Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/superLogin', function () {
    return view('Login.supervisorLogin');
});

Route::get('/studentLogin', function () {
    return view('Login.studentLogin');
});
Route::get('/companyLogin', function () {
    return view('Login.companyLogin');
});

Route::get('/adminLogin', function () {
    return view('Login.adminLogin');
});
#############################################################################################3

Route::get('/del', function () {
    return view('detail');
});
Route::get('/com', function () {
    return view('showCompanies');
});
Route::get('/super', function () {
    return view('supervisor');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
