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
Route::get('/pelamaran', [Controller::class, 'lamaran'])->name('lamaran');
Route::get('/karyawan', [Controller::class, 'karyawan'])->name('karyawan');
Route::get('/user', [Controller::class, 'user'])->name('user');

// aksi
Route::post('/aksi_login', [Controller::class, 'aksi_login'])->name('aksi_login');
Route::post('/editsetting', [Controller::class, 'editsetting']);
Route::post('/aksi_register', [Controller::class, 'aksiregister'])->name('aksi_register');
Route::post('/addlamaran', [Controller::class, 'addlamaran'])->name('addlamaran');
Route::get('/pelamar/detail/{id}', [Controller::class, 'detailPelamar'])->name('detailPelamar');
Route::post('/pelamar/accept/{id}', [Controller::class, 'acceptPelamar'])->name('acceptPelamar');
Route::post('/pelamar/decline/{id}', [Controller::class, 'declinePelamar'])->name('declinePelamar');
Route::post('/tambahlowongan', [Controller::class, 'tambahlowongan'])->name('tambahlowongan');
Route::post('/editlowongan/{id}', [Controller::class, 'editlowongan'])->name('editlowongan');
Route::post('/hapuslowongan/{id}', [Controller::class, 'hapuslowongan'])->name('hapuslowongan');
Route::post('/editkaryawan/{id}', [Controller::class, 'editkaryawan'])->name('editkaryawan');
Route::get('/hapuskaryawan/{id}', [Controller::class, 'hapuskaryawan'])->name('hapuskaryawan');