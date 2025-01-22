<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// base
Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');
Route::get('/generateCaptcha', [Controller::class, 'generateCaptcha'])->name('generateCaptcha');
Route::get('/logout', [Controller::class, 'logout'])->name('logout');
Route::get('/error404', [Controller::class, 'error404'])->name('error404');


// page
Route::get('/login',  [Controller::class, 'login'])->name('login');
Route::get('/setting', [Controller::class, 'setting'])->name('setting');
Route::get('/register', [Controller::class, 'register'])->name('register');
Route::get('/lowongan', [Controller::class, 'lowongan'])->name('lowongan');

// aksi
Route::post('/aksi_login', [Controller::class, 'aksi_login'])->name('aksi_login');
Route::post('/editsetting', [Controller::class, 'editsetting']);
Route::post('/aksi_register', [Controller::class, 'aksiregister'])->name('aksi_register');
Route::post('/addlowongan', [Controller::class, 'addlowongan'])->name('addlowongan');