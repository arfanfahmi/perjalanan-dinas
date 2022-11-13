<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerdinController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;


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

// Route::get('/', function () {
//     return view('home', ["judul"=>"Aplikasi Perjalanan Dinas"]);
// });

Route::get('/', [LoginController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');;
Route::post('/login/logout/{id}', [LoginController::class, 'logout'])->middleware('auth');;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->middleware('auth');
Route::get('/dashboard/sdm', [DashboardController::class, 'sdm'])->middleware('auth');
Route::get('/dashboard/pegawai', [DashboardController::class, 'pegawai'])->middleware('auth');

Route::get('/kota', [KotaController::class,'index'])->middleware('auth');
Route::get('/kota/add', [KotaController::class,'create'])->middleware('auth');
Route::post('/kota/store', [KotaController::class,'store'])->middleware('auth');
Route::get('/kota/edit/{id}', [KotaController::class,'edit'])->middleware('auth');
Route::post('/kota/update/{id}', [KotaController::class,'update'])->middleware('auth');
Route::delete('/kota/destroy/{id}', [KotaController::class,'destroy'])->middleware('auth');

Route::get('/user', [UserController::class,'index'])->middleware('auth');
Route::get('/user/add', [UserController::class,'create'])->middleware('auth');
Route::post('/user/store', [UserController::class,'store'])->middleware('auth');
Route::get('/user/edit/{id}', [UserController::class,'edit'])->middleware('auth');
Route::post('/user/update/{id}', [UserController::class,'update'])->middleware('auth');
Route::post('/user/update-pass/{id}', [UserController::class,'updatePassword'])->middleware('auth');
Route::delete('/user/destroy/{id}', [UserController::class,'destroy'])->middleware('auth');

Route::get('/perdin', [PerdinController::class,'index'])->middleware('auth');
Route::post('/perdin/store', [PerdinController::class,'store'])->middleware('auth');
Route::get('/perdin/cek-perdin-by/{id}/{id1}/{id2}', [PerdinController::class,'cekPerdinBy'])->middleware('auth');

Route::get('/approval', [ApprovalController::class,'index'])->middleware('auth');
Route::get('/approval/history', [ApprovalController::class,'history'])->middleware('auth');
Route::post('/approval/update/{id}', [ApprovalController::class,'update'])->middleware('auth');