<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperatorController;

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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/check-session', [AuthController::class, 'checkSession'])->name('check.session');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin-index', [AdminController::class, 'index'])->name('admin.index');

    // USER LIST
    Route::get('/listuser', [AdminController::class, 'userlist'])->name('admin.userlist');
    Route::get('/user/detail/{id}', [AdminController::class, 'detail'])->name('user.detail');
    Route::get('/user/{id}', [AdminController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [AdminController::class, 'update'])->name('user.update');
    Route::get('/get-user/data', [AdminController::class, 'getusertable']);
    Route::post('/force-logout/{id}', [AuthController::class, 'forceLogout']);
    Route::post('/user/store', [AdminController::class, 'store'])->name('user.store');
});

Route::middleware(['auth', 'role:Operator'])->group(function () {
    Route::get('/operators-index', [OperatorController::class, 'index'])->name('operator.index');
});