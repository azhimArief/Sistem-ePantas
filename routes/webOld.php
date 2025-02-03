<?php

use Illuminate\Support\Facades\Route;

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

//Login
Route::get('/', function () {
    // return view('pemohon/pilih_jenis');
    return view('auth/login');
})->name('login');

Route::get('/admin/login', function () {
    // return view('pemohon/pilih_jenis');
    return view('auth/adminLogin');
});
Route::post('/search', 'PemohonController@search')->name('pemohon.search'); //check nokp for login
Route::get('/logKeluar', 'HomeController@tamat')->name('logKeluar'); //if session expired

//Logout
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// Route::post('/admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');


//PEMOHON
// Route::get('/pemohon/option_1', [PemohonController::class, 'Option_1']);
Route::get('/pemohon/menu/{nokp}', 'PemohonController@menu')->name('pemohon.menu'); 
Route::get('/pemohon/butiran/{id}', 'PemohonController@butiran')->name('pemohon.butiran'); 

Route::get('/pemohon/tambah/{id}', 'PemohonController@tambah')->name('pemohon.tambah'); 
Route::post('/pemohon/simpan/tambah/{nokp}', 'PemohonController@simpan_tambah')->name('pemohon.simpanT'); 

Route::get('/pemohon/kemaskini/{id}', 'PemohonController@kemaskini')->name('pemohon.kemaskini'); 
Route::post('/pemohon/kemaskini/simpan/{id}', 'PemohonController@simpan_kemaskini')->name('pemohon.simpanK'); 

Route::get('/pemohon/batal/{id}', 'PemohonController@batal')->name('pemohon.batal'); 
Route::get('/pemohon/batal/simpan/{id}', 'PemohonController@simpan_batal')->name('pemohon.simpanB'); 

// Route::get('/pemohon/tambah_PPT', 'PemohonController@tambah_PPT')->name('pemohon.tambah_PPT'); 
// Route::get('/pemohon/dummy', 'PemohonController@dummy')->name('pemohon.dummy'); 

//PEMOHON PPT
Route::get('/pemohon/menu_ppt/{nokp}', 'PemohonController@menu_PPT')->name('pemohon.menu_ppt'); 
Route::get('/pemohon/pilih_ppt/{nokp?}', 'PemohonController@pilih_PPT')->name('pemohon.pilih_ppt'); 
Route::post('/pemohon/pilih_ppt/{nokp?}', 'PemohonController@pilih_PPT')->name('pemohon.pilih_ppt'); 

Route::get('/pemohon/tambah_ppt/{nokp}', 'PemohonController@tambah_PPT')->name('pemohon.tambah_ppt'); 
Route::post('/pemohon/simpan_ppt/{nokp}', 'PemohonController@simpan_PPT')->name('pemohon.simpan_ppt');

Route::post('/pemohon/simpan_kemaskiniPPT/{id}/{id2}/{nokp}', 'PemohonController@simpan_kemaskiniPPT')->name('pemohon.simpan_kemaskiniPPT');         

Route::get('/pemohon/pengesahan_ppt/{id}/{nokp}', 'PemohonController@pengesahan_PPT')->name('pemohon.pengesahan_ppt'); // ke list pengesahan 
Route::post('/pemohon/pengesahan_ppt/{id}/{nokp}', 'PemohonController@pengesahan_PPT')->name('pemohon.pengesahan_ppt');   // selesai pengesahan akan ubah draft ke baru 
Route::post('/pemohon/pengesahan_tambahPPT/{id}/{nokp}', 'PemohonController@pengesahan_tambahPPT')->name('pemohon.pengesahan_tambahPPT'); 
Route::get('/pemohon/buangPPT/{id}/{nokp}', 'PemohonController@buangPPT')->name('peruntukan.buangPPT'); //buang dari senarai program PPT

Route::get('/pemohon/senarai_ppt/{nokp?}', 'PemohonController@senarai_PPT')->name('pemohon.senarai_ppt'); 
Route::post('/pemohon/senarai_ppt/{nokp?}', 'PemohonController@senarai_PPT')->name('pemohon.senarai_ppt');

//Auth
Auth::routes();
Route::group(['middleware' => 'auth'], function(){

    Route::get('/check', 'HomeController@check')->name('check');
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Admin
    Route::get('/peruntukan/tindakan/{id}', 'PeruntukanController@tindakan')->name('peruntukan.tindakan');
    Route::post('/peruntukan/tindakan/simpan/{id}', 'PeruntukanController@simpan_tindakan')->name('peruntukan.simpanTindakan');

    Route::get('/peruntukan/tambah', 'PeruntukanController@tambah')->name('peruntukan.tambah'); 
    Route::post('/peruntukan/tambah/simpan/', 'PeruntukanController@simpan_tambah')->name('peruntukan.simpanT'); 

    Route::get('/peruntukan/senarai', 'PeruntukanController@senarai')->name('peruntukan.senarai'); 
    Route::post('/peruntukan/senarai', 'PeruntukanController@senarai')->name('peruntukan.senarai'); 

    Route::get('/peruntukan/pengesahan/{id}', 'PeruntukanController@pengesahan')->name('peruntukan.pengesahan'); 

    Route::get('/peruntukan/butiran/{id}', 'PeruntukanController@butiran')->name('peruntukan.butiran'); 

    Route::post('/peruntukan/butiran_tindakan/{id}', 'PeruntukanController@butiran_tindakan')->name('peruntukan.butiran_tindakan'); 

    Route::get('/peruntukan/kemaskini/{id}', 'PeruntukanController@kemaskini')->name('peruntukan.kemaskini'); 
    Route::post('/peruntukan/kemaskini/simpan/{id}', 'PeruntukanController@simpan_kemaskini')->name('peruntukan.simpanK'); 

    Route::get('/peruntukan/batal/{id}', 'PeruntukanController@batal')->name('peruntukan.batal'); 
    Route::post('/peruntukan/simpan/batal/{id}', 'PeruntukanController@simpan_batal')->name('peruntukan.simpanBatal'); 

    Route::get('peruntukan/pengesahan/cetak/{id}', 'PeruntukanController@cetak_pengesahan')->name('peruntukan.cetak');

    // Route::get('/peruntukan/profil', 'PeruntukanController@profil')->name('peruntukan.profil');

    //Admin PPT
    Route::get('/peruntukan/tambah', 'PeruntukanController@tambah')->name('peruntukan.tambah'); //dummy test
    Route::get('/peruntukan/pilih_ppt', 'PeruntukanController@pilih_PPT')->name('peruntukan.pilih_ppt'); 
    Route::post('/peruntukan/pilih_ppt', 'PeruntukanController@pilih_PPT')->name('peruntukan.pilih_ppt'); 
    Route::get('/peruntukan/tambah_ppt/{nokp}', 'PeruntukanController@tambah_PPT')->name('peruntukan.tambah_ppt'); 
    Route::post('/peruntukan/simpan_ppt/{nokp}', 'PeruntukanController@simpan_PPT')->name('peruntukan.simpan_ppt'); 

    Route::get('/peruntukan/senarai_ppt', 'PeruntukanController@senarai_PPT')->name('peruntukan.senarai_ppt'); 
    Route::post('/peruntukan/senarai_ppt', 'PeruntukanController@senarai_PPT')->name('peruntukan.senarai_ppt'); 

    Route::get('/peruntukan/pengesahan_ppt/{id}', 'PeruntukanController@pengesahan_PPT')->name('peruntukan.pengesahan_ppt');  // tngok view PPT tuk pengesahan
    Route::post('/peruntukan/pengesahan_ppt/{id}', 'PeruntukanController@pengesahan_PPT')->name('peruntukan.pengesahan_ppt');  // untuk jika tekan button selesai tukar draft ke baru

    Route::post('/peruntukan/simpan_kemaskiniPPT/{id1}/{id2}', 'PeruntukanController@simpan_kemaskiniPPT')->name('peruntukan.simpan_kemaskiniPPT');   //kemaskini PPT      
    Route::post('/peruntukan/pengesahan_tambahPPT/{id}', 'PeruntukanController@pengesahan_tambahPPT')->name('peruntukan.pengesahan_tambahPPT'); //tambah PPT
    Route::get('/peruntukan/buangPPT/{id}', 'PeruntukanController@buangPPT')->name('peruntukan.buangPPT'); //buang dari senarai program PPT

    Route::get('/peruntukan/tindakanPPT/{id}', 'PeruntukanController@tindakanPPT')->name('peruntukan.tindakanPPT'); //tindakan PPT
    Route::post('/peruntukan/tindakanPPT/{id}', 'PeruntukanController@tindakanPPT')->name('peruntukan.tindakanPPT'); //simpan tindakan PPT


    // 

    //Laporan
    Route::get('/laporan/tambah_ppp', 'LaporanController@tambah_ppp')->name('peruntukan.tambah_ppp'); 
    Route::post('/laporan/simpan/tambah_ppp', 'LaporanController@simpan_tambah_ppp')->name('peruntukan.simpan_tambah_ppp'); 

    Route::get('/laporan/peruntukan', 'LaporanController@laporan_peruntukan')->name('laporan.peruntukan'); 
    Route::post('/laporan/peruntukan', 'LaporanController@laporan_peruntukan')->name('laporan.peruntukan'); 

    Route::get('/laporan/perbelanjaan_objek', 'LaporanController@laporan_perbelanjaan_objek')->name('laporan.perbelanjaan_objek'); 
    Route::post('/laporan/perbelanjaan_objek', 'LaporanController@laporan_perbelanjaan_objek')->name('laporan.perbelanjaan_objek'); 

    //Pengguna
    Route::get('/pengguna/tambah', 'PenggunaController@tambah')->name('pengguna.tambah');
    Route::post('/pengguna/tambah/simpan/', 'PenggunaController@simpan_tambah')->name('pengguna.simpan_tambah');
    Route::get('/pengguna/senarai', 'PenggunaController@senarai')->name('pengguna.senarai');
    Route::get('/pengguna/butiran/{id}', 'PenggunaController@butiran')->name('pengguna.butiran');

    Route::get('/pengguna/kemaskini/{id}', 'PenggunaController@kemaskini')->name('pengguna.kemaskini');
    Route::post('/pengguna/kemaskini/simpan/{id}', 'PenggunaController@simpan_kemaskini')->name('pengguna.simpan_kemaskini');

    Route::get('/pengguna/hapus/{id}', 'PenggunaController@hapus')->name('pengguna.hapus');
    Route::post('/pengguna/hapus/simpan/{id}', 'PenggunaController@simpan_hapus')->name('pengguna.simpan_hapus');

    //CariObjek & CariNama
    Route::get('/cariObjek', 'PeruntukanController@searchObjek')->name('cariObjek');
    Route::get('/searchNama', 'PeruntukanController@searchNama')->name('searchNama');

    //Dashboard
    Route::get('home', 'HomeController@home')->name('home');

});










