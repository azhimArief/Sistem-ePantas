<?php

use App\Http\Controllers\InputController;
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
    // return view('welcome');
    return view('auth/login');
    // return view('errors/503'); //UNCOMMENT THIS FOR MAINTENANCE MODE
})->name('login');

Route::get('/admin/login', function () {
    // return view('pemohon/pilih_jenis');
    return view('auth/adminLogin');
});

Route::get('/daftar/pilih', function () {
    // return view('pemohon/pilih_jenis');
    return view('daftar/pilihDaftar');
});

Route::post('/search', 'PemohonController@search')->name('pemohon.search'); //check nokp for login
Route::get('/logKeluar', 'HomeController@tamat')->name('logKeluar'); //if session expired

//Logout
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// Route::post('/admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

//LUPA PASSWORD
Route::get('/password/email/', 'DaftarController@password_email')->name('password_email');
Route::post('/password/email/send', 'DaftarController@password_email')->name('password_emailSend');

Route::get('/reset/password/{id}', 'DaftarController@reset_password')->name('reset_password');
Route::post('/reset/password/simpan/{id}', 'DaftarController@reset_password')->name('reset_passwordSimpan');

Route::get('/reload_captcha', 'DaftarController@reloadCaptcha')->name('reloadCaptcha');

//DAFTAR AGENSI & KEMENTERIAN
Route::get('/daftar/email/', 'DaftarController@check_email')->name('check_email'); //Untuk Gov Isi email
Route::post('/daftar/verify_email/', 'DaftarController@verify_email')->name('verify_email'); //Post hantar ke email

Route::get('/daftar/daftarGov/{id}', 'DaftarController@register_gov')->name('daftar.register_gov'); //View form bile tekan kt email
Route::post('/daftar/daftarGov/{id}', 'DaftarController@register_gov')->name('daftar.register_gov'); // masuk password n then save

Route::get('/daftar/daftarAgensi/', 'DaftarController@register_agensi')->name('daftar.register_agensi'); //Isi form Pendaftaran Agensi
Route::post('/daftar/daftarAgensi/', 'DaftarController@register_agensi')->name('daftar.register_agensi'); //daftar but tak aktif kene bukak email dulu

Route::get('/daftar/daftarAgensi/simpan/{id}', 'DaftarController@simpan_agensi')->name('daftar.simpan_agensi'); //dah tekan kat link email baru aktif akaun
// Route::post('/daftar/daftarAgensi/simpan/', 'DaftarController@simpan_agensi')->name('daftar.simpan_agensi');


//PEMOHON
// Route::get('/pemohon/option_1', [PemohonController::class, 'Option_1']);
// Route::get('/pemohon/menu/{nokp}', 'PemohonController@menu')->name('pemohon.menu'); 
// Route::get('/pemohon/butiran/{id}', 'PemohonController@butiran')->name('pemohon.butiran'); 

// Route::get('/pemohon/tambah/{id}', 'PemohonController@tambah')->name('pemohon.tambah'); 
// Route::post('/pemohon/simpan/tambah/{nokp}', 'PemohonController@simpan_tambah')->name('pemohon.simpanT'); 

// Route::get('/pemohon/kemaskini/{id}', 'PemohonController@kemaskini')->name('pemohon.kemaskini'); 
// Route::post('/pemohon/kemaskini/simpan/{id}', 'PemohonController@simpan_kemaskini')->name('pemohon.simpanK'); 

// Route::get('/pemohon/batal/{id}', 'PemohonController@batal')->name('pemohon.batal'); 
// Route::get('/pemohon/batal/simpan/{id}', 'PemohonController@simpan_batal')->name('pemohon.simpanB'); 

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

    //PEMOHON
    // Route::get('/pemohon/option_1', [PemohonController::class, 'Option_1']);
    Route::get('/pemohon/profil/{id}', 'PemohonController@profil')->name('pemohon.profil'); //butiran profil
    Route::get('/pemohon/profil/kemaskini/{id}', 'PemohonController@profil_kemaskini')->name('pemohon.profil_kemaskini'); //kemaskini profil
    Route::post('/pemohon/profil/kemaskini/simpan/{id}', 'PemohonController@profil_kemaskini')->name('pemohon.profil_kemaskiniS'); //simpan kemaskini profil

    Route::get('/pemohon/menu/{id}', 'PemohonController@menu')->name('pemohon.menu'); 
    Route::post('/pemohon/menu/{id}', 'PemohonController@menu')->name('pemohon.menu'); 

    Route::get('/pemohon/butiran/{id}', 'PemohonController@butiran')->name('pemohon.butiran'); 

    Route::get('pemohon/pengesahan/cetak/{id}', 'PemohonController@cetak_pengesahan')->name('pemohon.cetak');
    Route::get('/pemohon/cetak/{id}', 'PemohonController@cetak')->name('pemohon.cetak'); 

    Route::get('/pemohon/tambah/{id}', 'PemohonController@tambah')->name('pemohon.tambah'); 
    Route::post('/pemohon/simpan/tambah/{nokp}', 'PemohonController@simpan_tambah')->name('pemohon.simpanT'); 

    Route::get('/pemohon/mohon_semula/{id}', 'PemohonController@mohon_semula')->name('pemohon.mohon_semula'); 


    Route::get('/pemohon/kemaskini/{id}', 'PemohonController@kemaskini')->name('pemohon.kemaskini'); 
    Route::post('/pemohon/kemaskini/simpan/{id}', 'PemohonController@simpan_kemaskini')->name('pemohon.simpanK'); 

    Route::post('/pemohon/autoSave/', 'PemohonController@autoSave');

    Route::get('/pemohon/kemaskini/vot/{id}', 'PemohonController@kemaskini_vot')->name('pemohon.kemaskini_vot'); 
    Route::post('/pemohon/kemaskini/vot/simpan/{id}', 'PemohonController@kemaskini_vot')->name('pemohon.kemaskini_simpanvot'); 
    
    Route::get('/pemohon/kemaskini/vot/form/{id}', 'PemohonController@kemaskini_votForm')->name('pemohon.kemaskiniVotForm'); 
    Route::post('/pemohon/kemaskini/vot/form/simpan/{id}', 'PemohonController@kemaskini_votForm')->name('pemohon.kemaskiniVotFormS'); 

    Route::get('/pemohon/buang/vot/{id}', 'PemohonController@buang_vot')->name('pemohon.buang_vot'); 

    Route::get('/pemohon/batal/{id}', 'PemohonController@batal')->name('pemohon.batal'); 
    Route::post('/pemohon/batal/simpan/{id}', 'PemohonController@simpan_batal')->name('pemohon.simpanB'); 

    Route::get('/check', 'HomeController@check')->name('check');
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //INPUT

        Route::get('/tujuan/{idMaklumatPermohonan}', 'InputController@tujuan_index');
        Route::post('/tujuan', 'InputController@tujuan_store');
        Route::put('/tujuan/{id}', 'InputController@tujuan_update');
        Route::delete('/tujuan/{id}', 'InputController@tujuan_destroy');
        Route::get('/tujuan/show/{id}', 'InputController@tujuan_show');

        Route::get('/latar/{idMaklumatPermohonan}', 'InputController@latar_index');
        Route::post('/latar', 'InputController@latar_store');
        Route::put('/latar/{id}', 'InputController@latar_update');
        Route::delete('/latar/{id}', 'InputController@latar_destroy');
        Route::get('/latar/show/{id}', 'InputController@latar_show');

        Route::get('/dasar/{idMaklumatPermohonan}', 'InputController@dasar_index');
        Route::post('/dasar', 'InputController@dasar_store');
        Route::put('/dasar/{id}', 'InputController@dasar_update');
        Route::delete('/dasar/{id}', 'InputController@dasar_destroy');
        Route::get('/dasar/show/{id}', 'InputController@dasar_show');

        Route::get('/justifikasi/{idMaklumatPermohonan}', 'InputController@justifikasi_index');
        Route::post('/justifikasi', 'InputController@justifikasi_store');
        Route::put('/justifikasi/{id}', 'InputController@justifikasi_update');
        Route::delete('/justifikasi/{id}', 'InputController@justifikasi_destroy');
        Route::get('/justifikasi/show/{id}', 'InputController@justifikasi_show');

        Route::get('/ulasan/{idMaklumatPermohonan}', 'InputController@ulasan_index');
        Route::post('/ulasan', 'InputController@ulasan_store');
        Route::put('/ulasan/{id}', 'InputController@ulasan_update');
        Route::delete('/ulasan/{id}', 'InputController@ulasan_destroy');
        Route::get('/ulasan/show/{id}', 'InputController@ulasan_show');
    
    //INPUT 

    //Admin

        //TINDAKAN
        Route::get('/peruntukan/tindakan/{id}', 'PeruntukanController@tindakan')->name('peruntukan.tindakan');
        Route::post('/peruntukan/tindakan/simpan/{id}', 'PeruntukanController@simpan_tindakan')->name('peruntukan.simpanTindakan');

        Route::get('/peruntukan/tindakan/vot/{id}', 'PeruntukanController@tindakan_vot')->name('peruntukan.tindakan_vot'); 
        Route::post('/peruntukan/tindakan/vot/simpan/{id}', 'PeruntukanController@tindakan_vot')->name('peruntukan.tindakan_simpanvot');

        Route::get('/peruntukan/tindakan/vot/form/{id}', 'PeruntukanController@tindakan_votForm')->name('peruntukan.tindakanVotForm'); 
        Route::post('/peruntukan/tindakan/vot/form/simpan/{id}', 'PeruntukanController@tindakan_votForm')->name('peruntukan.tindakanVotFormS'); 

        Route::get('/peruntukan/tindakan/buang/vot/{id}', 'PeruntukanController@tindakan_buangVot')->name('peruntukan.tindakanBuangVot');
        //TINDAKAN

        //KEMASKINI TINDAKAN
        Route::get('/peruntukan/kemaskini/tindakan/{id}', 'PeruntukanController@tindakanK')->name('peruntukan.tindakanK'); 
        Route::post('/peruntukan/kemaskini/tindakan/simpan/{id}', 'PeruntukanController@simpan_tindakanK')->name('peruntukan.simpan_tindakanK');

        Route::get('/peruntukan/kemaskini/tindakan/vot/{id}', 'PeruntukanController@tindakan_votK')->name('peruntukan.tindakan_votK'); 
        Route::post('/peruntukan/kemaskini/tindakan/vot/simpan/{id}', 'PeruntukanController@tindakan_votK')->name('peruntukan.tindakan_simpanvotK');

        Route::get('/peruntukan/kemaskini/tindakan/vot/form/{id}', 'PeruntukanController@tindakan_votFormK')->name('peruntukan.tindakanVotFormK'); 
        Route::post('/peruntukan/kemaskini/tindakan/vot/form/simpan/{id}', 'PeruntukanController@tindakan_votFormK')->name('peruntukan.tindakanVotFormSaveK');

        Route::get('/peruntukan/kemaskini/tindakan/buang/vot/{id}', 'PeruntukanController@tindakan_buangVotK')->name('peruntukan.tindakanBuangVotK');
        //KEMASKINI TINDAKAN

    Route::get('/peruntukan/tambah', 'PeruntukanController@tambah')->name('peruntukan.tambah'); 
    Route::post('/peruntukan/tambah/simpan/', 'PeruntukanController@simpan_tambah')->name('peruntukan.simpanT'); 

    Route::get('/peruntukan/kemaskini/{id}', 'PeruntukanController@kemaskini')->name('peruntukan.kemaskini'); 
    Route::post('/peruntukan/kemaskini/simpan/{id}', 'PeruntukanController@simpan_kemaskini')->name('peruntukan.simpanK'); 

    Route::get('/peruntukan/kemaskini/vot/{id}', 'PeruntukanController@kemaskini_vot')->name('peruntukan.kemaskini_vot'); 
    Route::post('/peruntukan/kemaskini/vot/simpan/{id}', 'PeruntukanController@kemaskini_vot')->name('peruntukan.kemaskini_simpanvot'); 
    
    Route::get('/peruntukan/kemaskini/vot/form/{id}', 'PeruntukanController@kemaskini_votForm')->name('peruntukan.kemaskiniVotForm'); 
    Route::post('/peruntukan/kemaskini/vot/form/simpan/{id}', 'PeruntukanController@kemaskini_votForm')->name('peruntukan.kemaskiniVotFormS'); 

    Route::get('/peruntukan/buang/vot/{id}', 'PeruntukanController@buang_vot')->name('peruntukan.buang_vot'); 

    Route::get('/peruntukan/senarai', 'PeruntukanController@senarai')->name('peruntukan.senarai'); 
    Route::post('/peruntukan/senarai', 'PeruntukanController@senarai')->name('peruntukan.senarai'); 

    Route::get('/peruntukan/pengesahan/{id}', 'PeruntukanController@pengesahan')->name('peruntukan.pengesahan'); 

    Route::get('/peruntukan/butiran/{id}', 'PeruntukanController@butiran')->name('peruntukan.butiran'); 

    
    Route::post('/peruntukan/butiran_tindakan/{id}', 'PeruntukanController@butiran_tindakan')->name('peruntukan.butiran_tindakan'); 
    
    Route::get('/peruntukan/batal/{id}', 'PeruntukanController@batal')->name('peruntukan.batal'); 
    Route::post('/peruntukan/simpan/batal/{id}', 'PeruntukanController@simpan_batal')->name('peruntukan.simpanBatal'); 
    
    Route::get('peruntukan/pengesahan/cetak/{id}', 'PeruntukanController@cetak_pengesahan')->name('peruntukan.cetak');
    Route::get('/peruntukan/cetak/{id}', 'PeruntukanController@cetak')->name('peruntukan.cetak'); 

    //PDF
    Route::get('old_format/download_pdf/{id}', 'PeruntukanController@OldgeneratePDF')->name('peruntukan.OldgeneratePDF');  //format cetak lama
    
    Route::get('/download_pdf/{id}', 'PeruntukanController@generatePDF')->name('peruntukan.generatePDF'); 
    Route::get('/download_pdf/v2/{id}', 'PeruntukanController@generatePDF_v2')->name('peruntukan.generatePDF_v2'); 

    Route::get('pemohon/download_pdf/{id}', 'PemohonController@generatePDF')->name('pemohon.generatePDF'); 
    //PDF

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
    Route::post('/pengguna/senarai', 'PenggunaController@senarai')->name('pengguna.senarai');

    Route::get('/pengguna/butiran/{id}', 'PenggunaController@butiran')->name('pengguna.butiran');

    Route::get('/pengguna/kemaskini/{id}', 'PenggunaController@kemaskini')->name('pengguna.kemaskini');
    Route::post('/pengguna/kemaskini/simpan/{id}', 'PenggunaController@simpan_kemaskini')->name('pengguna.simpan_kemaskini');

    Route::get('/pengguna/hapus/{id}', 'PenggunaController@hapus')->name('pengguna.hapus');
    Route::post('/pengguna/hapus/simpan/{id}', 'PenggunaController@simpan_hapus')->name('pengguna.simpan_hapus');

    //CariObjek & CariNama
    Route::get('/cariObjek', 'PeruntukanController@searchObjek')->name('cariObjek');
    Route::get('/cariPerkara', 'PeruntukanController@searchPerkara')->name('cariPerkara');
    Route::get('/searchNamaUser', 'PeruntukanController@searchNamaUser')->name('searchNamaUser');
    Route::get('/searchNamaPersonel', 'PeruntukanController@searchNamaPersonel')->name('searchNamaPersonel');

    //Dashboard
    Route::get('home', 'HomeController@home')->name('home');

    // Test Emel
    Route::get('/testEmel', 'PeruntukanController@testEmel')->name('testEmel');

});










