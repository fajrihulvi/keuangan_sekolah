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
    // return view('welcome');
    return view('auth.login');
});

Auth::routes([
    'register' => false, // disable register
    'reset' => false, // disable reset password
    'verify' => false, // disable verifikasi email saat pendaftaran
]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/kategori', 'HomeController@kategori')->name('kategori');
Route::post('/kategori/aksi', 'HomeController@kategori_aksi')->name('kategori.aksi');
Route::put('/kategori/update/{id}', 'HomeController@kategori_update')->name('kategori.update');
Route::delete('/kategori/delete/{id}', 'HomeController@kategori_delete')->name('kategori.delete');

Route::get('/password', 'HomeController@password')->name('password');
Route::post('/password/update', 'HomeController@password_update')->name('password.update');

Route::get('/transaksi', 'HomeController@transaksi')->name('transaksi');
Route::post('/transaksi/aksi', 'HomeController@transaksi_aksi')->name('transaksi.aksi');
Route::put('/transaksi/update/{id}', 'HomeController@transaksi_update')->name('transaksi.update');
Route::delete('/transaksi/delete/{id}', 'HomeController@transaksi_delete')->name('transaksi.delete');

Route::get('/pengguna', 'HomeController@user')->name('user');
Route::get('/pengguna/tambah', 'HomeController@user_add')->name('user.tambah');
Route::post('/pengguna/aksi', 'HomeController@user_aksi')->name('user.aksi');
Route::get('/pengguna/edit/{id}', 'HomeController@user_edit')->name('user.edit');
Route::put('/pengguna/update/{id}', 'HomeController@user_update')->name('user.update');
Route::delete('/user/delete/{id}', 'HomeController@user_delete')->name('user.delete');


Route::get('/laporan', 'HomeController@laporan')->name('laporan');
Route::get('/laporan/pdf', 'HomeController@laporan_pdf')->name('laporan_pdf');
// Route::get('/laporan/excel', 'HomeController@laporan_excel')->name('laporan_excel');
Route::get('/laporan/print', 'HomeController@laporan_print')->name('laporan_print');

Route::resource('/siswa',App\Http\Controllers\SiswaController::class)->except('show');
Route::resource('/kelas',App\Http\Controllers\KelasController::class)->except('show');
Route::resource('/jenis',App\Http\Controllers\JenisController::class)->except('show');

Route::get('/kwetansi', [App\Http\Controllers\KwetansiController::class,"index"])->name("kwetansi.index");
Route::get('/kwetansi-pdf', [App\Http\Controllers\KwetansiController::class,"pdf"])->name("kwetansi.pdf");
Route::get('/kwetansi-print', [App\Http\Controllers\KwetansiController::class,"print"])->name("kwetansi.print");

Route::get('/getSiswaInKelas', [App\Http\Controllers\HomeController::class,"getSiswaInKelas"])->name("siswa-kelas");
Route::get('/getKelas', [App\Http\Controllers\HomeController::class,"getKelas"])->name("kelas");
Route::get('/dataCategoryMonth', [App\Http\Controllers\HomeController::class,"dataCategotyMonth"])->name('data-cateroty-month');

Route::view('test','test');

route::post('/import-siswa',[App\Http\Controllers\HomeController::class,'importSiswa'])->name('import.siswa');
