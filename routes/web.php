<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DaftarGolonganController;
use App\Http\Controllers\DaftarSekolahController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\DataEksistingController;
use App\Http\Controllers\DataJabatanController;
use App\Http\Controllers\JenisGuruController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\MapelController;
use App\Models\DaftarJabatan;
use App\Models\DaftarSekolah;
use App\Models\Kecamatan;

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

    // DATA EKSISTING
    Route::get('/data-eksisting/admin', [DataEksistingController::class, 'index'])->name('data.eksisting');

    //KECAMATAN
    Route::get('/akseskecamatan/admin', [KecamatanController::class, 'index'])->name('data.kecamatan');
    Route::get('/get-kecamatan/data', [KecamatanController::class, 'getdatakecamatan']);
    Route::post('/kecamatan/store', [KecamatanController::class, 'storekecamatan']);
    Route::get('/kecamatan/edit/{id}', [KecamatanController::class, 'editKecamatan'])->name('kecamatan.edit');
    Route::put('/kecamatan/update/{id}', [KecamatanController::class, 'updateKecamatan'])->name('kecamatan.update');
    Route::delete('/kecamatan/delete/{id}', [KecamatanController::class, 'deleteKecamatan'])->name('kecamatan.delete');

    //SEKOLAH
    Route::get('/aksessekolah/admin', [DaftarSekolahController::class, 'index'])->name('data.sekolah');
    Route::get('/get-sekolah/data', [DaftarSekolahController::class, 'getdatasekolah']);
    Route::post('/sekolah/store', [DaftarSekolahController::class, 'storesekolah']);
    Route::get('/sekolah/edit/{id}', [DaftarSekolahController::class, 'editSekolah'])->name('sekolah.edit');
    Route::put('/sekolah/update/{id}', [DaftarSekolahController::class, 'updateSekolah'])->name('sekolah.update');
    Route::delete('/sekolah/delete/{id}', [DaftarSekolahController::class, 'deleteSekolah'])->name('sekolah.delete');

    //JABATAN
    Route::get('/aksesjabatan/admin', [DataJabatanController::class, 'index'])->name('data.jabatan');
    Route::get('/get-jabatan/data', [DataJabatanController::class, 'getdatajabatan']);
    Route::post('/jabatan/store', [DataJabatanController::class, 'storeJabatan']);
    Route::get('/jabatan/edit/{id}', [DataJabatanController::class, 'editJabatan'])->name('jabatan.edit');
    Route::put('/jabatan/update/{id}', [DataJabatanController::class, 'updateJabatan'])->name('jabatan.update');
    Route::delete('/jabatan/delete/{id}', [DataJabatanController::class, 'deleteJabatan'])->name('jabatan.delete');

    //GOLONGAN
    Route::get('/aksesgolongan/admin', [DaftarGolonganController::class, 'index'])->name('data.golongan');
    Route::get('/get-golongan/data', [DaftarGolonganController::class, 'getdatagolongan']);
    Route::post('/golongan/store', [DaftarGolonganController::class, 'storeGolongan']);
    Route::get('/golongan/edit/{id}', [DaftarGolonganController::class, 'editGolongan'])->name('golongan.edit');
    Route::put('/golongan/update/{id}', [DaftarGolonganController::class, 'updateGolongan'])->name('golongan.update');
    Route::delete('/golongan/delete/{id}', [DaftarGolonganController::class, 'deleteGolongan'])->name('golongan.delete');

    //JENIS GURU
    Route::get('/aksesjenis-guru/admin', [JenisGuruController::class, 'index'])->name('data.jenisguru');
    Route::get('/get-jenisguru/data', [JenisGuruController::class, 'getdatajenisguru']);
    Route::post('/jenisguru/store', [JenisGuruController::class, 'storeJenisGuru']);
    Route::get('/jenisguru/edit/{id}', [JenisGuruController::class, 'editJenisGuru'])->name('jenisguru.edit');
    Route::put('/jenisguru/update/{id}', [JenisGuruController::class, 'updateJenisGuru'])->name('jenisguru.update');
    Route::delete('/jenisguru/delete/{id}', [JenisGuruController::class, 'deleteJenisGuru'])->name('jenisguru.delete');

    //MATA PELAJARAN
    Route::get('/aksesmapel/admin', [MapelController::class, 'index'])->name('data.mapel');
    Route::get('/get-mapel/data', [MapelController::class, 'getdatamapel']);
    Route::post('/mapel/store', [MapelController::class, 'storeMapel']);
    Route::get('/mapel/edit/{id}', [MapelController::class, 'editMapel'])->name('mapel.edit');
    Route::put('/mapel/update/{id}', [MapelController::class, 'updateMapel'])->name('mapel.update');
    Route::delete('/mapel/delete/{id}', [MapelController::class, 'deleteMapel'])->name('mapel.delete');
});

Route::middleware(['auth', 'role:Operator'])->group(function () {
    Route::get('/operators-index', [OperatorController::class, 'index'])->name('operator.index');
});