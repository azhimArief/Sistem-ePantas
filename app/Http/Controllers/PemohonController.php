<?php

namespace App\Http\Controllers;

use App\Agensi;
use App\DasarSemasa;
use App\LkpAccess;
use App\LkpJenisBelanja;
use Carbon;
use App\LkpJenisPeruntukan;
use App\LkpOA;
use App\LkpObjek;
use App\LkpOS;
use App\LkpPerkara;
use App\LkpPerkaraOneOff;
use App\LkpStatus;
use App\LkpVot;
use App\MaklumatPermohonan;
use App\Objektif;
use App\Pengesah;
use App\PerancanganPerolehan;
use App\PLkpBahagian;
use App\PPemohonPeruntukan;
use App\PPersonel;
use App\ProgramDirancang;
use App\Tindakan;
use App\User;
use App\VotByAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;
use App\Http\Resources\MaklumatPermohonanResource;
use App\JustifikasiPermohonan;
use App\LatarBelakang;
use App\Tujuan;
use App\UlasanBahagian;
use Dompdf\Dompdf;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;


class PemohonController extends Controller
{
    // global variable tuk assign the word Kementerian Perpaduan Negara (KPN)
    protected $KPN; 
    public function __construct()
    {
        // Set the value of $KPN in the constructor
        // $this->KPN = Agensi::where('id', 1)->value('agensi')->first();
        $this->KPN = Agensi::where('id', 1)->value('agensi');
    }
    // global variable tuk assign the word Kementerian Perpaduan Negara (KPN) 

    public function profil($id){
        // return Auth::User();
        // $personel = PPersonel::where('nokp', Auth::User()->mykad)->first();
        // $user = User::where('id', $id)->first();
        $user = User::where('id', Auth::User()->id)->first();
        
        return view('pemohon.profil', compact('user'));
    }

    public function profil_kemaskini(Request $request, $id){

        $data = $request->input();

        if( isset($_POST['kemaskini_profil']) ) {

            $rules = [
                'kata_laluan' => 'nullable|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
            ];
            $messages = [
                'passwkata_laluanord.min' => 'Kata laluan mesti mengandungi sekurang-kurangnya 8 aksara.',
                'kata_laluan.regex' => 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor dan satu karakter khas.',
            ];
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $request->validate($rules, $messages);  
                return redirect('/pemohon/profil/kemaskini/' . $id)->withInput();
            }
            
                if($data['kata_laluan'] != '') {
                    $updatePass = Hash::make($data['kata_laluan']);
                } else {
                    $updatePass = User::find($id)->password;
                }

            // User::where('id', $id)->update([
            //     'nama' => $data['nama'],
            //     'bahagian' => $data['bahagian'],
            //     'agensi' => $data['agensi'],
            //     'jawatan' => $data['jawatan'],
            //     'gred' => $data['gred'],
            //     'email' => $data['email'],
            //     'tel_pejabat' => $data['tel_pejabat'],
            //     'telefon' => $data['telefon'],
            //     // 'status' => $data['status'],
            //     // 'id_access' => $data['peranan'],
            //     'password' => $updatePass,
            //     'updated_at' => Carbon\Carbon::now()
            // ]);

            $user = User::where('id', $id)->first();

            //UPDATE PEMOHON PERUNTUKAN
            PPemohonPeruntukan::where('noKp', $user->mykad)->update([
                'namaPemohon' => $data['nama'],
                'namaBahagian' => $data['bahagian'],
                'agensi' => $data['agensi'],
                'jawatanPemohon' => $data['jawatan'],
                'gredPemohon' => $data['gred'],
                'telefonPejabat' => $data['tel_pejabat'],
                'telefon' => $data['telefon'],
            ]);

            // Update user's password
            $user->nama = $data['nama'];
            $user->bahagian = $data['bahagian'];
            $user->agensi = $data['agensi'];
            $user->jawatan = $data['jawatan'];
            $user->gred = $data['gred'];
            $user->email = $data['email'];
            $user->tel_pejabat = $data['tel_pejabat'];
            $user->telefon = $data['telefon'];
            // $user->status = $data['status'];
            // $user->id_access = $data['id_access'];
            $user->password = $updatePass;
            $user->updated_at = Carbon\Carbon::now();
            $user->save();

            // Refresh user's session
            Auth::login($user);
    
            $request->session()->flash('status', 'Maklumat pengguna berjaya dikemaskini.');
            return redirect('pemohon/profil/'.$id);
        }
        else {
            $user = User::where('id', $id)->first();
            // $bahagians = PLkpBahagian::whereBetween('id', [1, 15])
            //                     ->orWhere('id', 29)
            //                     ->get();
            $bahagians = PLkpBahagian::where('status_bahagian', 1)->get();
            
            $agensis = Agensi::where('id', '!=', 4)
                            ->where('id', '!=', 3)
                            ->get();
            $optStatusUsers = LkpStatus::whereIn('id_status', ['6','7'])->get(); 
            $optAccesss = LkpAccess::whereIn('id_access', ['1', '5', '8', '12', '13', '14'])->get(); 

            return view('pemohon.kemaskini_profil', compact('user', 'agensis', 'optStatusUsers', 'optAccesss', 'bahagians') );
        }
    }


    // public function tambah($id)
    // {
    //     // $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
    //     $objekAms = LkpOA::get();

    //     // $objekSebs = LkpObjek::get();
    //     $objekSebs = LkpOs::get();

    //     $lkpPerkaras = LkpPerkara::orderBy('perkara', 'asc')->get();
    //     $lkpOAs = LkpOA::get();
    //     $lkpOSs = LkpOS::get();
        
    //     $Opt_Peruntukan = LkpJenisPeruntukan::get();
    //     $Opt_Vots = LkpVot::get();
    //     // $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $id)->first();
    //     // $personel = PPersonel::where('nokp', $nokp)->first();

    //     $pengesahs = PPersonel::where('stat_pegawai', 1)
    //                             ->where(function ($query) {
    //                                 $query->whereRaw('CAST(REGEXP_REPLACE(gred, "[^0-9]", "") AS UNSIGNED) >= 48');
    //                             })
    //                             ->orderBy('name')
    //                             ->get();

    //     $user = User::where('id', $id)->first();


    //     return view('pemohon.tambah', compact('Opt_Peruntukan', 'Opt_Vots', 'user', 'objekAms', 'objekSebs', 'pengesahs', 'lkpPerkaras', 'lkpOAs', 'lkpOSs'));
    // }
    
    public function tambah($id)
    {
        // Insert Pemohon
            $user = User::where('id', $id)->first();
            $cariPemohon = PPemohonPeruntukan::where('noKp', $user->mykad)->first();
            if( $cariPemohon == null ) {
                $pemohon = new PPemohonPeruntukan();
                $pemohon->namaPemohon = $user->nama;
                $pemohon->noKp = $user->mykad;
                $pemohon->agensi = $user->agensi;
                $pemohon->namaBahagian = $user->bahagian;
                $pemohon->gredPemohon = $user->gred;
                $pemohon->jawatanPemohon = $user->jawatan;
                $pemohon->telefon = $user->telefon;
                $pemohon->telefonPejabat = $user->tel_pejabat;
                $pemohon->save();
            }
            else {
                $pemohon = $cariPemohon;
            }
        // Insert Untuk Pemohon

        if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' ) {
            $bahagian = $user->bahagian;
        }
        else {
            $bahagian = optional(\App\PLkpBahagian::where('bahagian', $user->bahagian)->first())->id;
        }

        $input = new MaklumatPermohonan();
        $input->idPemohonPeruntukan = $pemohon->idPemohonPeruntukan;
        // $input->id_bahagian = optional(\App\PLkpBahagian::where('bahagian', $user->bahagian)->first())->id;
        $input->id_bahagian = $bahagian;
        $input->id_agensi = optional(\App\Agensi::where('agensi', $user->agensi)->first())->id;
        // $input->kod_permohonan = $kod_permohonan; 
        // $input->rujukan_fail = $data['ruj_fail'];
        // $input->namaProgram = $data['nama_program'];
        // $input->tujuanProgram = $data['tujuan'];
        // $input->latarBelakang = $data['latarBelakang'];
        $input->id_jenis_peruntukan = 1;
        // $input->id_jenis_perbelanjaan = null;
        $input->tkhCadangMula = null;
        $input->tkhCadangAkhir = null;
        // $input->tkhCadangAkhir = Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d');
        $input->id_status = 12; //Draft
        // $input->kosMohon = $data['kos_mohon'];
        // $input->kosSebenar = 0;
        // if( !$request->input('perancangan') ) { $input->perancangan = null; }
        // else { $input->perancangan = $data['perancangan']; }
        // $input->doc_Sokongan = $filePath;
        // $input->ulasanKewangan = '';
        // $input->tindakan_oleh = '';
        $input->createdAt = Carbon\Carbon::now();
        $input->updatedAt = Carbon\Carbon::now();
        $input->save();

        return redirect('pemohon/kemaskini/' . $input->idMaklumatPermohonan);
        // return view('pemohon.kemaskini', compact( 'user', 'pengesah', 'maklumats', 'vots'));
    }

    public function simpan_tambah(Request $request, $id)
    {
        $data = $request->input();
        $user = User::where('id', $id)->first();

        if ( isset($_POST['submit_obj']) ) {  //IF BUTTON TAMBAH OBJEKTIF
                $rules = [
                    'nama_program' => 'nullable|string',
                    'tujuan' => 'nullable|string',
                    'latarBelakang' => 'nullable|string',
                    'objektif1' => 'nullable|string',
                    'objektif2' => 'nullable|string',
                    'objektif3' => 'nullable|string',
                    'objektif4' => 'nullable|string',
                    'objektif5' => 'nullable|string',
                    // 'syor' => 'nullable|string',
                    // 'perancangan' => 'required',    
                    // 'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    // 'ruj_fail' => 'nullable|string',
                    'kos_mohon' => 'nullable|numeric|max:999999999999',
                    'dokumen' => 'file|mimes:pdf|max:5120', 
                ];
                $messages = [
                    'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',
                    'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',
                    'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',

                    'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',
                    'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',
                    'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',
                    'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                    'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                    // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',

                    'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                    'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                    'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                    'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
                ];
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/pemohon/tambah/' . $id)->withInput();
                }

                //Method 2 Validate the uploaded file   
                // $validator = Validator::make($request->all(), [
                //     'kertas_cadangan' => 'required|file|mimes:pdf|max:1024', // Max file size (1MB in this example)
                //     'minit_permohonan' => 'file|mimes:pdf|max:1024', // Max file size (1MB in this example)
                //     // 'minit_permohonan' => 'required|file|mimes:pdf|max:1024', // Max file size (1MB in this example)
                // ]);
                
                // if ($validator->fails()) {
                //     $request->session()->flash('failed',"Sila pastikan anda telah masukkan fail bersaiz 1MB dan jenis PDF");
                //     return redirect('pemohon/tambah/' . $nokp)->withInput();  
                // } 
                
                else {

                    //Check if semua VOT dimasukkan lengkap
                        if ( $data['form_VOT'] != null ) {
                            $expVot = explode('|x|x|', $data['form_VOT']);

                            for($mj=0; $mj<count($expVot) - 1; $mj++) {
                                $decodeMJ = base64_decode($expVot[$mj]);
                                $expDecodeMJ = explode('x|x', $decodeMJ);

                                // if ( $expDecodeMJ[1] == null) { //Perkara
                                //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                                //     return redirect('/pemohon/tambah/' . $id)->withInput();
                                // }
                                if ( $expDecodeMJ[3] == null) { //Objek Am
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Am tidak dimasukkan.');
                                    return redirect('/pemohon/tambah/' . $id)->withInput();
                                } 
                                else if ( $expDecodeMJ[5] == null) {  //Objek Sebagai
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Sebagai tidak dimasukkan.');
                                    return redirect('/pemohon/tambah/' . $id)->withInput();
                                }
                                else if ( $expDecodeMJ[9] == null) { //Kos
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Anggaran Kos tidak dimasukkan.');
                                    return redirect('/pemohon/tambah/' . $id)->withInput();
                                }
                            }
                        }
                    //Check if semua VOT dimasukkan lengkap

                    // Store the file
                    $file = $request->file('dokumen');
                    if (isset ($file)) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->move('uploads/dokumen_tambahan/', $filename);
                    }
                    else {
                        $filePath = null;
                    }

                    // Insert Untuk Pemohon
                        $cariPemohon = PPemohonPeruntukan::where('noKp', $user->mykad)->first();
                    if( $cariPemohon == null ) {
                        $pemohon = new PPemohonPeruntukan();
                        $pemohon->namaPemohon = $data['nama'];
                        $pemohon->noKp = $user->mykad;
                        $pemohon->agensi = $data['agensi'];
                        $pemohon->namaBahagian = $data['bahagian'];
                        $pemohon->gredPemohon = $data['gred'];
                        $pemohon->jawatanPemohon = $data['jawatan'];
                        $pemohon->telefon = $data['telefon'];
                        $pemohon->telefonPejabat = $data['tel_pejabat'];
                        $pemohon->save();
                        // $pemohon->kertasCadangan = $filePath1;
                        // $pemohon->kertasCadangan = '';
                        // $pemohon->minitCadangan = $filePath2;
                        // $pemohon->minitCadangan = '';
                    }
                    else {
                        $pemohon = $cariPemohon;
                    }
                    // Insert Untuk Pemohon

                    //kod permohonan
                    // $jumlah = MaklumatPermohonan::whereYear('createdAt', '=', Carbon\Carbon::now()->format('Y'))->count('idMaklumatPermohonan');
                    // $jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
                    // $kod_permohonan = 'M'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;

                    $input = new MaklumatPermohonan();
                    // $input->idPemohonPeruntukan = $pemohonInsert->idPemohonPeruntukan;
                    $input->idPemohonPeruntukan = $pemohon->idPemohonPeruntukan;
                    // $input->id_bahagian = $data['bahagian'];
                    $input->id_bahagian = optional(\App\PLkpBahagian::where('bahagian', $data['bahagian'])->first())->id;
                    $input->id_agensi = optional(\App\Agensi::where('agensi', $data['agensi'])->first())->id;
                    // $input->idVotByAdmin = null; 
                    // $input->kod_permohonan = $kod_permohonan; 
                    $input->rujukan_fail = $data['ruj_fail'];
                    $input->namaProgram = $data['nama_program'];
                    $input->tujuanProgram = $data['tujuan'];
                    $input->latarBelakang = $data['latarBelakang'];
                    $input->id_jenis_peruntukan = $data['jenis_peruntukan'];
                    $input->id_jenis_perbelanjaan = null;
                    // $input->id_jenis_perbelanjaan = 0;
                    $input->tkhCadangMula = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
                    $input->tkhCadangAkhir = Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d');
                    $input->id_status = 12; //Draft
                    $input->kosMohon = $data['kos_mohon'];
                    // $input->syor = $data['syor'];
                    // $input->pengesah = $data['pengesah'];
                    // $input->kosSebenar = 0;
                    if( !$request->input('perancangan') ) { $input->perancangan = null; }
                    else { $input->perancangan = $data['perancangan']; }
                    $input->doc_Sokongan = $filePath;
                    // $input->ulasanKewangan = '';
                    // $input->tindakan_oleh = '';
                    $input->createdAt = Carbon\Carbon::now();
                    $input->updatedAt = Carbon\Carbon::now();
                    $input->save();

                    //INSERT OBJEKTIF PROGRAM
                        $obj = new Objektif();
                        $obj->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                        $obj->obj1 = $data['objektif1'];
                        $obj->obj2 = $data['objektif2'];
                        $obj->obj3 = $data['objektif3'];
                        $obj->obj4 = $data['objektif4'];
                        $obj->obj5 = $data['objektif5'];
                        $obj->save();
                    //INSERT OBJEKTIF PROGRAM

                    //Masuk Dalam VotByAdmin
                    if ( $data['form_VOT'] != null ) {
                        $expVot = explode('|x|x|', $data['form_VOT']);

                        for($mj=0; $mj<count($expVot) - 1; $mj++) {
                            $decodeMJ = base64_decode($expVot[$mj]);
                            $expDecodeMJ = explode('x|x', $decodeMJ);

                            //reference urutan OLD
                            // var objekAmId = column[1];
                            // var objekAmNama = column[2];
                            // var objekSebId = column[3];
                            // var objekSebNama = column[4];
                            // var kos = column[5];
                            // var statusId = column[6];
                            // var statusNama = column[7];
                            //reference urutan

                            //Susunan form_VOT
                            // 1 - perkara ID
                            // 2 - perkara title
                            // 3 - ObjekAm ID
                            // 4 - ObjekAm title
                            // 5 - ObjekSeb ID
                            // 6 - ObjekSeb title
                            // 7 - Lain
                            // 8 - Unit
                            // 9 - Kos

                            //IF UNIT TAKDE NILAI
                            if ( $expDecodeMJ[8] ) { $unit = $expDecodeMJ[8]; }
                            else {  $unit = 0; }
                            //IF UNIT TAKDE NILAI

                            //IF PERKARA TAKDE NILAI
                            if ( $expDecodeMJ[1] ) { $perkara = $expDecodeMJ[1]; }
                            else { $perkara = null; }
                            //IF PERKARA TAKDE NILAI

                            $vot = new VotByAdmin();
                            $vot->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                            // $vot->perkara = $expDecodeMJ[1];
                            $vot->perkara = $perkara;
                            $vot->objekAm = $expDecodeMJ[3];
                            $vot->objekSebagai = $expDecodeMJ[5];
                            // if( $expDecodeMJ[5] == '') { $vot->objekSebagai = null; } else { $vot->objekSebagai = $expDecodeMJ[5]; }
                            $vot->keterangan = $expDecodeMJ[7];
                            $vot->unit = $unit;
                            // $vot->unit = isset($expDecodeMJ[7]) ? $expDecodeMJ[7] : 0;
                            $vot->kos = $expDecodeMJ[9];
                            // $vot->id_status = $expDecodeMJ[6];
                            // $vot->id_Status = $expDecodeMJ[6];
                            // $vot->created_at = Carbon\Carbon::now();
                            // $vot->updated_at = Carbon\Carbon::now();
                            $vot->save();
                        }
                    }

                    //IF AGENSI PERLU SAVE DETAIL PENGESAH
                    if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ 
                        $pengesah = new Pengesah();
                        $pengesah->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                        $pengesah->namaPengesah = $data['nama_pengesah'];
                        $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
                        $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
                        $pengesah->agensiPengesah = $data['agensi_pengesah'];
                        $pengesah->save();
                    }

                    // UPDATE NO TELEFONN USER 
                    // PPersonel::where('nokp', $user->mykad)->update([
                    //                 'tel' => $data['tel_pejabat'],
                    //                 'tel_bimbit' =>  $data['telefon'],
                    //                 'updated_at' => Carbon\Carbon::now(),
                    //             ]);
                    User::where('mykad', $user->mykad)->update([
                                    'tel_pejabat' => $data['tel_pejabat'],
                                    'telefon' =>  $data['telefon'],
                                    'updated_at' => Carbon\Carbon::now(),
                                ]);
                    PPemohonPeruntukan::where('idPemohonPeruntukan', $pemohon->idPemohonPeruntukan)->update([
                        'telefon' => $data['telefon'],
                        'telefonPejabat' => $data['tel_pejabat'],
                    ]);

                    $request->session()->flash('status', 'Maklumat objektif ditambah.');
                    return redirect('/pemohon/kemaskini/' . $input->idMaklumatPermohonan);// idMaklumatPermohonan
                }
        }
        else if( isset($_POST['simpan']) ) {  //IF BUTTON SIMPAN
            $rules = [
                'nama_program' => 'nullable|string',
                'tujuan' => 'nullable|string',
                'latarBelakang' => 'nullable|string',
                    'objektif1' => 'nullable|string',
                    'objektif2' => 'nullable|string',
                    'objektif3' => 'nullable|string',
                    'objektif4' => 'nullable|string',
                    'objektif5' => 'nullable|string',
                // 'syor' => 'nullable|string',
                // 'perancangan' => 'required',    
                // 'tkh_mula' => 'required',    
                // 'tkh_tamat' => 'required',    
                // 'ruj_fail' => 'nullable|string',
                'kos_mohon' => 'nullable|numeric|max:999999999999',
                'dokumen' => 'file|mimes:pdf|max:5120', 
            ];
            $messages = [
                'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',
                'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',
                'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',

                'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',
                'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',
                'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',
                'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',        

                'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/pemohon/tambah/' . $id)->withInput();
            }
            else {

                //Check if semua VOT dimasukkan lengkap
                    if ( $data['form_VOT'] != null ) {
                        $expVot = explode('|x|x|', $data['form_VOT']);

                        for($mj=0; $mj<count($expVot) - 1; $mj++) {
                            $decodeMJ = base64_decode($expVot[$mj]);
                            $expDecodeMJ = explode('x|x', $decodeMJ);

                            // if ( $expDecodeMJ[1] == null) { //Perkara
                            //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            //     return redirect('/pemohon/tambah/' . $id)->withInput();
                            // }
                            if ( $expDecodeMJ[3] == null) { //Objek Am
                                $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Am tidak dimasukkan.');
                                return redirect('/pemohon/tambah/' . $id)->withInput();
                            } 
                            else if ( $expDecodeMJ[5] == null) {  //Objek Sebagai
                                $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Sebagai tidak dimasukkan.');
                                return redirect('/pemohon/tambah/' . $id)->withInput();
                            }
                            else if ( $expDecodeMJ[9] == null) { //Kos
                                $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Anggaran Kos tidak dimasukkan.');
                                return redirect('/pemohon/tambah/' . $id)->withInput();
                            }
                        }
                    }
                //Check if semua VOT dimasukkan lengkap

                // Store the file
                $file = $request->file('dokumen');
                if (isset ($file)) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->move('uploads/dokumen_tambahan/', $filename);
                }
                else {
                    $filePath = null;
                }

                // Insert Untuk Pemohon
                $cariPemohon = PPemohonPeruntukan::where('noKp', $user->mykad)->first();
                if( $cariPemohon == null ) {
                    $pemohon = new PPemohonPeruntukan();
                    $pemohon->namaPemohon = $data['nama'];
                    $pemohon->noKp = $user->mykad;
                    $pemohon->agensi = $data['agensi'];
                    $pemohon->namaBahagian = $data['bahagian'];
                    $pemohon->gredPemohon = $data['gred'];
                    $pemohon->jawatanPemohon = $data['jawatan'];
                    $pemohon->telefon = $data['telefon'];
                    $pemohon->telefonPejabat = $data['tel_pejabat'];
                    $pemohon->save();
                    // $pemohon->kertasCadangan = $filePath1;
                    // $pemohon->kertasCadangan = '';
                    // $pemohon->minitCadangan = $filePath2;
                    // $pemohon->minitCadangan = '';
                }
                else {
                    $pemohon = $cariPemohon;
                }
                // Insert Untuk Pemohon

                //kod permohonan
                // $jumlah = MaklumatPermohonan::whereYear('createdAt', '=', Carbon\Carbon::now()->format('Y'))->count('idMaklumatPermohonan');
                // $jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
                // $kod_permohonan = 'M'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;

                $input = new MaklumatPermohonan();
                $input->idPemohonPeruntukan = $pemohon->idPemohonPeruntukan;
                // $input->id_bahagian = $data['bahagian'];
                $input->id_bahagian = optional(\App\PLkpBahagian::where('bahagian', $data['bahagian'])->first())->id;
                $input->id_agensi = optional(\App\Agensi::where('agensi', $data['agensi'])->first())->id;
                // $input->kod_permohonan = $kod_permohonan; 
                $input->rujukan_fail = $data['ruj_fail'];
                $input->namaProgram = $data['nama_program'];
                $input->tujuanProgram = $data['tujuan'];
                $input->latarBelakang = $data['latarBelakang'];
                $input->id_jenis_peruntukan = $data['jenis_peruntukan'];
                $input->id_jenis_perbelanjaan = null;
                $input->tkhCadangMula = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
                $input->tkhCadangAkhir = Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d');
                $input->id_status = 12; //Draft
                $input->kosMohon = $data['kos_mohon'];
                // $input->syor = $data['syor'];
                // $input->pengesah = $data['pengesah'];
                if( !$request->input('perancangan') ) { $input->perancangan = null; }
                else { $input->perancangan = $data['perancangan']; }
                $input->doc_Sokongan = $filePath;
                $input->createdAt = Carbon\Carbon::now();
                $input->updatedAt = Carbon\Carbon::now();
                $input->save();

                //INSERT OBJEKTIF PROGRAM
                    $obj = new Objektif();
                    $obj->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                    $obj->obj1 = $data['objektif1'];
                    $obj->obj2 = $data['objektif2'];
                    $obj->obj3 = $data['objektif3'];
                    $obj->obj4 = $data['objektif4'];
                    $obj->obj5 = $data['objektif5'];
                    $obj->save();
                //INSERT OBJEKTIF PROGRAM

                //Masuk Dalam VotByAdmin
                if ( $data['form_VOT'] != null ) {
                    $expVot = explode('|x|x|', $data['form_VOT']);

                    for($mj=0; $mj<count($expVot) - 1; $mj++) {
                        $decodeMJ = base64_decode($expVot[$mj]);
                        $expDecodeMJ = explode('x|x', $decodeMJ);

                        //Susunan form_VOT
                            // 1 - perkara ID
                            // 2 - perkara title
                            // 3 - ObjekAm ID
                            // 4 - ObjekAm title
                            // 5 - ObjekSeb ID
                            // 6 - ObjekSeb title
                            // 7 - Lain
                            // 8 - Unit
                            // 9 - Kos

                        //IF UNIT TAKDE NILAI
                        if ( $expDecodeMJ[8] ) { $unit = $expDecodeMJ[8]; }
                        else { $unit = 0; }
                        //IF UNIT TAKDE NILAI

                        //IF PERKARA TAKDE NILAI
                        if ( $expDecodeMJ[1] ) { $perkara = $expDecodeMJ[1]; }
                        else { $perkara = null; }
                        //IF PERKARA TAKDE NILAI

                        $vot = new VotByAdmin();
                        $vot->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                        // $vot->perkara = $expDecodeMJ[1];
                        $vot->perkara = $perkara;
                        $vot->objekAm = $expDecodeMJ[3];
                        $vot->objekSebagai = $expDecodeMJ[5];
                        // if( $expDecodeMJ[5] == '') { $vot->objekSebagai = null; } else { $vot->objekSebagai = $expDecodeMJ[5]; }
                        $vot->keterangan = $expDecodeMJ[7];
                        $vot->unit = $unit;
                        // $vot->unit = isset($expDecodeMJ[7]) ? $expDecodeMJ[7] : 0;
                        $vot->kos = $expDecodeMJ[9];
                        // $vot->id_status = $expDecodeMJ[6];
                        // $vot->id_Status = $expDecodeMJ[6];
                        // $vot->created_at = Carbon\Carbon::now();
                        // $vot->updated_at = Carbon\Carbon::now();
                        $vot->save();
                    }
                }

                //IF AGENSI PERLU SAVE DETAIL PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ 
                    $pengesah = new Pengesah();
                    $pengesah->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                    $pengesah->namaPengesah = $data['nama_pengesah'];
                    $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
                    $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
                    $pengesah->agensiPengesah = $data['agensi_pengesah'];
                    $pengesah->save();
                }

                // UPDATE NO TELEFONN USER 
                // PPersonel::where('nokp', $user->mykad)->update([
                //                 'tel' => $data['tel_pejabat'],
                //                 'tel_bimbit' =>  $data['telefon'],
                //                 'updated_at' => Carbon\Carbon::now(),
                //             ]);
                User::where('mykad', $user->mykad)->update([
                                'tel_pejabat' => $data['tel_pejabat'],
                                'telefon' =>  $data['telefon'],
                                'updated_at' => Carbon\Carbon::now(),
                            ]);
                PPemohonPeruntukan::where('idPemohonPeruntukan', $pemohon->idPemohonPeruntukan)->update([
                    'telefon' => $data['telefon'],
                    'telefonPejabat' => $data['tel_pejabat'],
                ]);

                $request->session()->flash('status', 'Maklumat berjaya disimpan.');
                return redirect('/pemohon/kemaskini/' . $input->idMaklumatPermohonan);// idMaklumatPermohonan
            }
        }
        else { //IF BUTTON HANTAR

                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //if Agensi perlu detail pengesah
                    $rules = [
                        'nama_program' => 'required|string',
                        'tujuan' => 'required|string',
                        'latarBelakang' => 'required|string',
                        'objektif1' => 'required|string',
                        'objektif2' => 'nullable|string',
                        'objektif3' => 'nullable|string',
                        'objektif4' => 'nullable|string',
                        'objektif5' => 'nullable|string',
                        'perancangan' => 'required',    
                        'tkh_mula' => 'required',    
                        // 'tkh_tamat' => 'required',    
                        'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                        // 'syor' => 'required|string',
                        // 'pengesah' => 'required',
                        'ruj_fail' => 'required|string',
                        'dokumen' => 'file|mimes:pdf|max:1024',
                        'nama_pengesah' => 'required|string', 
                        'jawatan_pengesah' => 'required|string', 
                        'bahagian_pengesah' => 'required|string', 
                        'agensi_pengesah' => 'required|string', 
                    ];
                }
                else {
                    $rules = [
                        'nama_program' => 'required|string',
                        'tujuan' => 'required|string',
                        'latarBelakang' => 'required|string',
                        'objektif1' => 'required|string',
                        'objektif2' => 'nullable|string',
                        'objektif3' => 'nullable|string',
                        'objektif4' => 'nullable|string',
                        'objektif5' => 'nullable|string',
                        'perancangan' => 'required',    
                        'tkh_mula' => 'required',    
                        // 'tkh_tamat' => 'required',    
                        'ruj_fail' => 'required|string',
                        'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                        // 'syor' => 'required|string',
                        // 'pengesah' => 'required',
                        'dokumen' => 'file|mimes:pdf|max:1024', 
                    ];
                }
            
                $messages = [
                    'nama_program.required' => 'Sila pastikan anda telah memasukkan nama program.',
                    'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',

                    'tujuan.required' => 'Sila pastikan anda telah memasukkan tujuan program.',
                    'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',

                    'latarBelakang.required' => 'Sila pastikan anda telah memasukkan Latar Belakang.',
                    'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',

                    'objektif1.required' => 'Sila pastikan anda telah memasukkan Objektif 1.',
                    'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',

                    'objektif2.required' => 'Sila pastikan anda telah memasukkan Objektif 2.',
                    'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',

                    'objektif3.required' => 'Sila pastikan anda telah memasukkan Objektif 3.',
                    'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',

                    'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                    'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                    'perancangan.required' => 'Sila pastikan anda telah memilih Status Program.',
                    'tkh_mula.required' => 'Sila pastikan anda telah memasukkan Tarikh Mula.',
                    'tkh_tamat.required' => 'Sila pastikan anda telah memasukkan Tarikh Tamat.',
                    'kos_mohon.required' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                    'kos_mohon.not_in' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                    'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                    // 'syor.required' => 'Sila pastikan anda telah memasukkan Syor.',
                    // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',
                    
                    // 'pengesah.required' => 'Sila pastikan anda telah memilih Pengesah.',

                    'nama_pengesah.required' => 'Sila pastikan anda telah memasukkan Nama Pengesah.',
                    'jawatan_pengesah.required' => 'Sila pastikan anda telah memasukkan Jawatan Pengesah.',
                    'bahagian_pengesah.required' => 'Sila pastikan anda telah memasukkan Bahagian Pengesah.',
                    'agensi_pengesah.required' => 'Sila pastikan anda telah memasukkan Agensi Pengesah.',

                    'ruj_fail.required' => 'Sila pastikan anda telah memasukkan No. Rujukan Fail.',
                    
                    'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                    'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                    'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 1MB.',
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/pemohon/tambah/' . $id)->withInput();
                }
                else {
                    
                    //Check if semua VOT dimasukkan lengkap
                        if ( $data['form_VOT'] != null ) {
                            $expVot = explode('|x|x|', $data['form_VOT']);

                            for($mj=0; $mj<count($expVot) - 1; $mj++) {
                                $decodeMJ = base64_decode($expVot[$mj]);
                                $expDecodeMJ = explode('x|x', $decodeMJ);

                                // if ( $expDecodeMJ[1] == null) { //Perkara
                                //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                                //     return redirect('/pemohon/tambah/' . $id)->withInput();
                                // }
                                if ( $expDecodeMJ[3] == null) { //Objek Am
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Am tidak dimasukkan.');
                                    return redirect('/pemohon/tambah/' . $id)->withInput();
                                } 
                                else if ( $expDecodeMJ[5] == null) {  //Objek Sebagai
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Sebagai tidak dimasukkan.');
                                    return redirect('/pemohon/tambah/' . $id)->withInput();
                                }
                                else if ( $expDecodeMJ[9] == null) { //Kos
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Anggaran Kos tidak dimasukkan.');
                                    return redirect('/pemohon/tambah/' . $id)->withInput();
                                }
                            }
                        }
                    //Check if semua VOT dimasukkan lengkap

                    // Store the file
                    $file = $request->file('dokumen');

                    if (isset ($file)) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $filePath = $file->move('uploads/dokumen_tambahan/', $filename);
                    }
                    else {
                        $filePath = null;
                    }

                    // Insert Untuk Pemohon
                    $cariPemohon = PPemohonPeruntukan::where('noKp', $user->mykad)->first();
                    if( $cariPemohon == null ) {
                        $pemohon = new PPemohonPeruntukan();
                        $pemohon->namaPemohon = $data['nama'];
                        $pemohon->noKp = $user->mykad;
                        $pemohon->agensi = $data['agensi'];
                        $pemohon->namaBahagian = $data['bahagian'];
                        $pemohon->gredPemohon = $data['gred'];
                        $pemohon->jawatanPemohon = $data['jawatan'];
                        $pemohon->telefon = $data['telefon'];
                        $pemohon->telefonPejabat = $data['tel_pejabat'];
                        $pemohon->save();
                    }
                    else {
                        $pemohon = $cariPemohon;
                    }
                    // Insert Untuk Pemohon
                

                    //kod permohonan
                    if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)'){
                        // $kod = Agensi::where('agensi', $user->agensi)->first();
                        $kod = Agensi::where('agensi', $user->agensi)->value('akronim') ?? 'KPN';
                    }
                    else {
                        $bahagian = PLkpBahagian::where('bahagian', $user->bahagian)->first();
                        $kod = $bahagian->singkatan;
                    }
                    $jumlah = MaklumatPermohonan::where('id_status', '!=', 12)->whereYear('createdAt', '=', Carbon\Carbon::now()->format('Y'))->count('idMaklumatPermohonan');
                    $jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
                    $kod_permohonan = $kod.'/'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;
                    // $kod_permohonan = $bahagian->singkatan.'/'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;


                    $input = new MaklumatPermohonan();
                    // $input->idPemohonPeruntukan = $pemohonInsert->idPemohonPeruntukan;
                    $input->idPemohonPeruntukan = $pemohon->idPemohonPeruntukan;
                    // $input->id_bahagian = $data['bahagian'];
                    $input->id_bahagian = optional(\App\PLkpBahagian::where('bahagian', $data['bahagian'])->first())->id;
                    $input->id_agensi = optional(\App\Agensi::where('agensi', $data['agensi'])->first())->id;
                    // $input->idVotByAdmin = null; 
                    $input->kod_permohonan = $kod_permohonan; 
                    $input->rujukan_fail = $data['ruj_fail'];
                    $input->namaProgram = $data['nama_program'];
                    $input->tujuanProgram = $data['tujuan'];
                    $input->latarBelakang = $data['latarBelakang'];
                    $input->id_jenis_peruntukan = $data['jenis_peruntukan'];
                    $input->id_jenis_perbelanjaan = null;
                    // $input->id_jenis_perbelanjaan = 0;
                    $input->tkhCadangMula = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
                    $input->tkhCadangAkhir = Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d');
                    $input->id_status = 1;
                    $input->kosMohon = $data['kos_mohon'];
                    // $input->kosSebenar = 0;
                    $input->perancangan = $data['perancangan'];
                    // $input->syor = $data['syor'];
                    // $input->pengesah = $data['pengesah'];
                    $input->doc_Sokongan = $filePath;
                    $input->createdAt = Carbon\Carbon::now();
                    $input->updatedAt = Carbon\Carbon::now();
                    $input->save();

                    //INSERT OBJEKTIF PROGRAM
                        $obj = new Objektif();
                        $obj->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                        $obj->obj1 = $data['objektif1'];
                        $obj->obj2 = $data['objektif2'];
                        $obj->obj3 = $data['objektif3'];
                        $obj->obj4 = $data['objektif4'];
                        $obj->obj5 = $data['objektif5'];
                        $obj->save();
                    //INSERT OBJEKTIF PROGRAM

                    //Masuk Dalam VotByAdmin
                    if ( $data['form_VOT'] != null ) {
                        $expVot = explode('|x|x|', $data['form_VOT']);

                        for($mj=0; $mj<count($expVot) - 1; $mj++) {
                            $decodeMJ = base64_decode($expVot[$mj]);
                            $expDecodeMJ = explode('x|x', $decodeMJ);

                            //Susunan form_VOT
                            // 1 - perkara ID
                            // 2 - perkara title
                            // 3 - ObjekAm ID
                            // 4 - ObjekAm title
                            // 5 - ObjekSeb ID
                            // 6 - ObjekSeb title
                            // 7 - Lain
                            // 8 - Unit
                            // 9 - Kos

                            //IF UNIT TAKDE NILAI
                            if ( $expDecodeMJ[8] ) { $unit = $expDecodeMJ[8]; }
                            else { $unit = 0; }
                            //IF UNIT TAKDE NILAI

                            //IF PERKARA TAKDE NILAI
                            if ( $expDecodeMJ[1] ) { $perkara = $expDecodeMJ[1]; }
                            else { $perkara = null; }
                            //IF PERKARA TAKDE NILAI

                            $vot = new VotByAdmin();
                            $vot->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                            // $vot->perkara = $expDecodeMJ[1];
                            $vot->perkara = $perkara;
                            $vot->objekAm = $expDecodeMJ[3];
                            $vot->objekSebagai = $expDecodeMJ[5];
                            // if( $expDecodeMJ[5] == '') { $vot->objekSebagai = null; } else { $vot->objekSebagai = $expDecodeMJ[5]; }
                            $vot->keterangan = $expDecodeMJ[7];
                            $vot->unit = $unit;
                            // $vot->unit = isset($expDecodeMJ[7]) ? $expDecodeMJ[7] : 0;
                            $vot->kos = $expDecodeMJ[9];
                            // $vot->id_status = $expDecodeMJ[6];
                            // $vot->id_Status = $expDecodeMJ[6];
                            // $vot->created_at = Carbon\Carbon::now();
                            // $vot->updated_at = Carbon\Carbon::now();
                            $vot->save();
                        }
                    }

                    //IF AGENSI PERLU SAVE DETAIL PENGESAH
                    if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ 
                        $pengesah = new Pengesah();
                        $pengesah->idMaklumatPermohonan = $input->idMaklumatPermohonan;
                        $pengesah->namaPengesah = $data['nama_pengesah'];
                        $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
                        $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
                        $pengesah->agensiPengesah = $data['agensi_pengesah'];
                        $pengesah->save();
                    }

                    // UPDATE NO TELEFONN USER 
                    // PPersonel::where('nokp', $user->mykad)->update([
                    //                 'tel' => $data['tel_pejabat'],
                    //                 'tel_bimbit' =>  $data['telefon'],
                    //                 'updated_at' => Carbon\Carbon::now(),
                    //             ]);
                    PPemohonPeruntukan::where('idPemohonPeruntukan', $pemohon->idPemohonPeruntukan)->update([
                        'telefon' => $data['telefon'],
                        'telefonPejabat' => $data['tel_pejabat'],
                    ]);
                    User::where('mykad', $user->mykad)->update([
                                    'tel_pejabat' => $data['tel_pejabat'],
                                    'telefon' =>  $data['telefon'],
                                    'updated_at' => Carbon\Carbon::now(),
                                ]);

                    //IF KPN HANTAR KE SUB BAHAGIAN, ELSE HANTAR KE KEWANGAN
                    if( $user->agensi != 'Kementerian Perpaduan Negara' && $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //HANTAR KE KEWANGAN IF AGENSI

                        //HANTAR EMEL KEPADA KEWANGAN
                                $pentadbir = User::where('id_access', 'Pentadbir Sistem')
                                                    ->where('status', 'Aktif')
                                                    ->get(); //PENTADBIR KEWANGAN
                                // dd($pentadbir);
                                
                                $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                                // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                                ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                                // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                                ->first();
                                // dd($contentEmel);

                                $pemohonPeruntukan = \App\PPemohonPeruntukan::find($contentEmel->idPemohonPeruntukan);
                                $pemohon = User::where('mykad', $pemohonPeruntukan->noKp)
                                ->first(); //PEMOHON
                                // dd($pemohon);

                                $pengesah = Pengesah::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)->first(); //PENGESAH UNTUK AGENSI
                                // dd($pengesah);

                                //HANTAR KE KEWANGAN
                                if ( !app()->environment('local') && !app()->environment('development') ) {
                                    Mail::send('email/tindakan/emel_agensi_kewangan', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($user, $pentadbir, $contentEmel)
                                    {
                                        $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                        $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
    
                                        foreach($pentadbir as $pentadbirs)
                                        {
                                            // $header->cc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                            $header->cc($pentadbirs->email,$pentadbirs->nama);	//HANTAR KE KEWANGAN
                                        }
    
                                        $header->subject('Notifikasi Permohonan Baru ePantas. TEST: HANTAR KE KEWANGAN TERUS IF AGENSI');
                                    });
                                }
                        //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
                    }
                    else { //IF KPN HANTAR EMEL KE SUB UNTUK DISYORKAN
                        //HANTAR EMEL KEPADA SUB UNTUK DISYOR
                            $pentadbir = User::where('bahagian', $user->bahagian)
                                                ->where('id_access', 'Pengesah')
                                                ->first(); //KETUA BAHAGIAN
                            // dd($pentadbir);
                            $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                                // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                                ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                                // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                                ->first();
                            // dd($contentEmel);

                            if ( !app()->environment('local') && !app()->environment('development') ) {
                                Mail::send('email/tindakan/emel_to_SUB', ['contentEmel' => $contentEmel], function ($header) use ($user, $pentadbir, $contentEmel)
                                {
                                    $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                    $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                    $header->to($pentadbir->email, $pentadbir->nama); //HANTAR KE KETUA BAHAGIAN UNTUK DISYORKAN 
    
                                    // foreach($pentadbirs as $pentadbir)
                                    // {
                                    // $header->cc('ariefazhim@gmail.com', 'Azhim');	//emel pentadbir
                                    // $header->cc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
                                    // }
    
                                    $header->subject('Notifikasi Permohonan Baru ePantas. TEST:HANTAR KE SUB BAHAGIAN.');
                                });
                            }
                        //HANTAR EMEL KEPADA SUB UNTUK DISYOR
                    }
                    //IF KPN HANTAR KE SUB BAHAGIAN, ELSE HANTAR KE KEWANGAN

                    $request->session()->flash('status', 'Maklumat permohonan berjaya dihantar.');
                    // return redirect('/pemohon/menu/' . $pemohonInsert->noKp);// nokp
                    return redirect('/pemohon/butiran/' . $input->idMaklumatPermohonan);// nokp
                }
        }
    }

    public function mohon_semula(Request $request, $id) {

        // Retrieve the previous data from the database
        $maklumatLama = MaklumatPermohonan::findOrFail($id); // Replace $id with the ID of the previous data
        // $objLama = Objektif::findOrFail($id); 
        $votLama = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        $tujuansLama = Tujuan::where('idMaklumatPermohonan', $id)->get();
        $latarsLama = LatarBelakang::where('idMaklumatPermohonan', $id)->get();
        $dasarsLama = DasarSemasa::where('idMaklumatPermohonan', $id)->get();
        $justifikasisLama = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->get();
        $ulasansLama = UlasanBahagian::where('idMaklumatPermohonan', $id)->get();

        // Make a copy of the previous data
        $maklumatBaru = $maklumatLama->replicate();
        // $objBaru = $objLama->replicate();

        // Make any necessary modifications to the copied data
        $maklumatBaru->kod_permohonan = null;
        $maklumatBaru->id_jenis_perbelanjaan = null;
        $maklumatBaru->id_status = 12;
        $maklumatBaru->kosSebenar = null;
        $maklumatBaru->createdAt = Carbon\Carbon::now();
        $maklumatBaru->updatedAt = Carbon\Carbon::now();
        $maklumatBaru->save();
        
        // $objBaru->idMaklumatPermohonan = $maklumatBaru->idMaklumatPermohonan;
        // $objBaru->save();
        
        foreach ($votLama as $vot) {
            $votCopy = $vot->replicate(); // Create a copy of the model
            $votCopy->idMaklumatPermohonan = $maklumatBaru->idMaklumatPermohonan;
            $votCopy->save(); // Save the copied instance to the database
        }
        foreach ($tujuansLama as $tujuan) {
            $tujuanCopy = $tujuan->replicate(); // Create a copy of the model
            $tujuanCopy->idMaklumatPermohonan = $maklumatBaru->idMaklumatPermohonan;
            $tujuanCopy->save(); // Save the copied instance to the database
        }
        foreach ($latarsLama as $latar) {
            $latarCopy = $latar->replicate(); // Create a copy of the model
            $latarCopy->idMaklumatPermohonan = $maklumatBaru->idMaklumatPermohonan;
            $latarCopy->save(); // Save the copied instance to the database
        }
        foreach ($dasarsLama as $dasar) {
            $dasarCopy = $dasar->replicate(); // Create a copy of the model
            $dasarCopy->idMaklumatPermohonan = $maklumatBaru->idMaklumatPermohonan;
            $dasarCopy->save(); // Save the copied instance to the database
        }
        foreach ($justifikasisLama as $justifikasi) {
            $justifikasiCopy = $justifikasi->replicate(); // Create a copy of the model
            $justifikasiCopy->idMaklumatPermohonan = $maklumatBaru->idMaklumatPermohonan;
            $justifikasiCopy->save(); // Save the copied instance to the database
        }
        foreach ($ulasansLama as $ulasan) {
            $ulasanCopy = $ulasan->replicate(); // Create a copy of the model
            $ulasanCopy->idMaklumatPermohonan = $maklumatBaru->idMaklumatPermohonan;
            $ulasanCopy->save(); // Save the copied instance to the database
        }

        return redirect('pemohon/kemaskini/' . $maklumatBaru->idMaklumatPermohonan);

    }

    public function simpan_tambah_old(Request $request, $id) //tak guna
    {
        $data = $request->input();
        $user = User::where('id', $id)->first();

        $rules = [
            'nama_program' => 'required|string',
            'perancangan' => 'required',    
            'tkh_mula' => 'required',    
            'tkh_tamat' => 'required',    
            'kos_program' => 'required|numeric',    
            'kertas_cadangan' => 'required|file|mimes:pdf|max:1024', 
            'minit_permohonan' => 'file|mimes:pdf|max:1024' 
        ];
        $messages = [
            'kertas_cadangan.required' => 'Sila pastikan anda telah memasukkan Kertas Cadangan.',
            'kertas_cadangan.file' => 'Sila pastikan Kertas Cadangan berjenis fail.',
            'kertas_cadangan.mimes' => 'Sila pastikan Kertas Cadangan berjenis PDF.',
            'kertas_cadangan.max' => 'Sila pastikan saiz Kertas Cadangan tidak melebihi 1MB.',

            'minit_permohonan.file' => 'Sila pastikan Minit Permohonan berjenis fail.',
            'minit_permohonan.mimes' => 'Sila pastikan Minit Permohonan berjenis PDF.',
            'minit_permohonan.max' => 'Sila pastikan saiz Minit Permohonan tidak melebihi 1MB.'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->validate($rules, $messages);
        	return redirect('/pemohon/tambah/' . $id)->withInput();
        }

        //Method 2 Validate the uploaded file   
        // $validator = Validator::make($request->all(), [
        //     'kertas_cadangan' => 'required|file|mimes:pdf|max:1024', // Max file size (1MB in this example)
        //     'minit_permohonan' => 'file|mimes:pdf|max:1024', // Max file size (1MB in this example)
        //     // 'minit_permohonan' => 'required|file|mimes:pdf|max:1024', // Max file size (1MB in this example)
        // ]);
        
        // if ($validator->fails()) {
        //     $request->session()->flash('failed',"Sila pastikan anda telah masukkan fail bersaiz 1MB dan jenis PDF");
        //     return redirect('pemohon/tambah/' . $nokp)->withInput();  
        // } 
        
        else {
            // Store the file
            $file1 = $request->file('kertas_cadangan');
            $file2 = $request->file('minit_permohonan');
            if (isset ($file2)) {
                $filename2 = time() . '_' . $file2->getClientOriginalName();
    			$filePath2 = $file2->move('uploads/minit_permohonan/', $filename2);
            }
            else {
                $filePath2 = null;
            }
            $filename1 = time() . '_' . $file1->getClientOriginalName();
            // $filename2 = time() . '_' . $file2->getClientOriginalName();
			$filePath1 = $file1->move('uploads/kertas_cadangan/', $filename1);
			// $filePath2 = $file2->move('uploads/minit_permohonan/', $filename2);
            // $file->storeAs('public/uploads', $filename); // Store in the "storage/app/uploads" directory
            // $filePath = 'public/uploads/' . $filename ;

            // Insert data into the database
            $pemohon = new PPemohonPeruntukan();
            $pemohon->namaPemohon = $data['nama'];
            $pemohon->noKp = $user->mykad;
            $pemohon->namaBahagian = $data['bahagian'];
            $pemohon->gredPemohon = $data['gred'];
            $pemohon->jawatanPemohon = $data['jawatan'];
            $pemohon->kertasCadangan = $filePath1;
            // $pemohon->kertasCadangan = '';
            $pemohon->minitCadangan = $filePath2;
            // $pemohon->minitCadangan = '';
            $pemohon->save();
        

            //kod permohonan
            $jumlah = MaklumatPermohonan::whereYear('createdAt', '=', Carbon\Carbon::now()->format('Y'))->count('idMaklumatPermohonan');
            $jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
            $kod_permohonan = 'M'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;


            $input = new MaklumatPermohonan();
            // $input->idPemohonPeruntukan = $pemohonInsert->idPemohonPeruntukan;
            $input->idPemohonPeruntukan = $pemohon->idPemohonPeruntukan;
            // $input->idVotByAdmin = null; 
            $input->kod_permohonan = $kod_permohonan; 
            $input->namaProgram = $data['nama_program'];
            $input->kosMohon = $data['kos_program'];
            $input->id_jenis_peruntukan = $data['jenis_peruntukan'];
            $input->id_jenis_perbelanjaan = null;
            // $input->id_jenis_perbelanjaan = 0;
            $input->tkhCadangMula = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
            $input->tkhCadangAkhir = Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d');
            $input->tkhSebenarMula = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
            $input->tkhSebenarAkhir = Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d');
            $input->id_status = 1;
            $input->kosMohon = $data['kos_program'];
            $input->kosSebenar = 0;
            $input->perancangan = $data['perancangan'];
            // $input->ulasanKewangan = '';
            // $input->tindakan_oleh = '';
            $input->createdAt = Carbon\Carbon::now();
            $input->updatedAt = Carbon\Carbon::now();
            $input->save();

            // UPDATE NO TELEFONN USER 
            PPersonel::where('nokp', $user->mykad)->update([
                            'tel' => $data['tel_pejabat'],
                            'tel_bimbit' =>  $data['telefon'],
                            'updated_at' => Carbon\Carbon::now(),
                        ]);
            User::where('mykad', $user->mykad)->update([
                            'tel_pejabat' => $data['tel_pejabat'],
                            'telefon' =>  $data['telefon'],
                            'updated_at' => Carbon\Carbon::now(),
                        ]);

            $request->session()->flash('status', 'Maklumat permohonan berjaya dihantar.');
            // return redirect('/pemohon/menu/' . $pemohonInsert->noKp);// nokp
            return redirect('/pemohon/butiran/' . $input->idMaklumatPermohonan);// nokp
        }

    }
    

    public function butiran($id)
    {
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        $objektifs = Objektif::where('idMaklumatPermohonan', $id)->first();

        $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->get();
        $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->get();
        $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->get();
        $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->get();
        $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->get();

        // if ( $maklumats->id_status != 1 || $maklumats->id_status != 12 ) {
        if ( $maklumats->id_status != 12 ) {
        // if( $maklumats->id_status == 8 || $maklumats->id_status == 9 || $maklumats->id_status == 10 || $maklumats->id_status == 11){
            $tindakan = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest

            $tindakanLists = Tindakan::where('idMaklumatPermohonan', $id)
                                        ->where(function ($query) {
                                            $query->where('id_status', 21)
                                                ->orWhere('id_status', 22) // Group id_status conditions
                                                ->orWhere('id_status', 1);
                                        })
                                        // ->latest('CreatedAt')
                                        ->get(); 

            $disyor = Tindakan::where('idMaklumatPermohonan', $id)
                                ->where(function ($query) {
                                    $query->where('id_status', 19)
                                        ->orWhere('id_status', 11) // Group id_status conditions
                                        ->orWhere('id_status', 1);
                                        // ->orWhere('id_status', 22); // Group id_status conditions
                                })
                                ->latest('CreatedAt')
                                ->first(); // Get the latest tindakan Pengesah

            // $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        }
        else {
            $tindakan = null;
            $tindakanLists = null; 
            $disyor = null; 
            // $votByAdmins = null;
        }

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $user = User::where('mykad', $pemohon->noKp)->first();

        //IF != DRAF && BUKAN KPN CARI PENGESAH
            if ( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' && $maklumats->id_status != 12) {
                // $pengesahAgensi = Pengesah::where('idMaklumatPermohonan', $id)->first();
                $pengesahAgensi = Pengesah::where('idPengesah', $maklumats->pengesah)->first();
            }
            else {
                $pengesahAgensi = [];
            }
            //  return $pengesahAgensi;
        //IF != DRAF && BUKAN KPN CARI PENGESAH
        $personel = PPersonel::where('nokp', $pemohon->noKp)->first();
        

        return view('pemohon.butiran', compact('maklumats', 'pemohon', 'personel', 'tindakan', 'tindakanLists', 'vots', 'objektifs', 'user', 'disyor', 'pengesahAgensi', 'tujuans', 'latars', 'dasars', 'justifikasis', 'ulasans'));
    }


    public function cetak_pengesahan($id) {
        
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        // $tindakans = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
        $tindakans = Tindakan::where('idMaklumatPermohonan', $id)
                                    // ->orderBy('UpdatedAt', 'asc')                            
                                    // ->get();
                                    // ->where('id_status', 13)                            
                                    ->latest('UpdatedAt')->first(); //latest

        $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)
                                // ->where('id_status', 9)
                                ->get();

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $user = User::where('id', $tindakans->UpdatedBy)->first();
        // $personel = PPersonel::where('name', $pemohon->namaPemohon)->first();

        return view('pemohon.pengesahan', compact('maklumats', 'user', 'votByAdmins', 'tindakans'));
    }

    public function cetak($id) {
        
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $objektif = Objektif::where('idMaklumatPermohonan', $id)->first();
        // $tindakans = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
        $tindakans = Tindakan::where('idMaklumatPermohonan', $id)
                                    // ->orderBy('UpdatedAt', 'asc')                            
                                    // ->get();
                                    // ->where('id_status', 13)                            
                                    ->latest('UpdatedAt')->first(); //latest

        $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)
                                // ->where('id_status', 9)
                                ->get();

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $personel = PPersonel::where('id', $tindakans->UpdatedBy)->first();
        // $personel = PPersonel::where('name', $pemohon->namaPemohon)->first();

        return view('pemohon.cetak', compact('maklumats', 'personel', 'votByAdmins', 'tindakans', 'objektif'));
    }

    public function kemaskini($id)
    {
        // $objekAms = LkpVot::get();
        $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
        $objekSebs = LkpObjek::get();
        $Opt_Peruntukan = LkpJenisPeruntukan::get();

        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $objektifs = Objektif::where('idMaklumatPermohonan', $id)->first();
        $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();

        //Untuk validate check required function simpan_kemaskini:Hantar,
            $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->first();
            $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->first();
            $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->first();
            $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->first();
            $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->first();
        //Untuk validate check required function simpan_kemaskini:Hantar,

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $user = User::where('mykad', $pemohon->noKp)->first();
        $personel = PPersonel::where('nokp', $pemohon->noKp)->first();

        // $pengesahs = PPersonel::where('stat_pegawai', 1)
        //                         ->where(function ($query) {
        //                             $query->whereRaw('CAST(REGEXP_REPLACE(gred, "[^0-9]", "") AS UNSIGNED) >= 48');
        //                         })
        //                         ->orderBy('name')
        //                         ->get();
        $pengesahs = Pengesah::where('agensiPengesah', $user->agensi)
                            ->where('statusPengesah', 'Aktif')
                            ->get();

        return view('pemohon.kemaskini', compact('maklumats', 'pemohon', 'personel', 'Opt_Peruntukan', 'objekAms', 'objekSebs', 'user', 'objektifs', 'vots', 'pengesahs', 'tujuans', 'latars', 'dasars', 'justifikasis', 'ulasans'));
    }
    public function simpan_kemaskini(Request $request, $id)
    {
        $data = $request->input();

        $maklumat1 = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumat1->idPemohonPeruntukan)->first();
        $user = User::where('mykad', $pemohon->noKp)->first();

        // $personel1 = PPersonel::where('nokp', $pemohon->noKp)->first();
        // PPersonel::where('nokp', $personel1->nokp)->update([
        //     'email' => $emel,
        //     'tel' => $data['telefon'],
        //     'tel_bimbit' =>  $data['tel_bimbit'],
        //     'updated_at' => Carbon\Carbon::now(),
        // ]);

        if ( isset($_POST['submit_obj']) ) {  //IF BUTTON KEMASKINI OBJEKTIF
                $rules = [
                    'nama_program' => 'nullable|string',
                    'tujuan' => 'nullable|string',
                    'latarBelakang' => 'nullable|string',
                    'objektif1' => 'nullable|string',
                    'objektif2' => 'nullable|string',
                    'objektif3' => 'nullable|string',
                    'objektif4' => 'nullable|string',
                    'objektif5' => 'nullable|string',
                    // 'syor' => 'nullable|string',
                    // 'perancangan' => 'required',    
                    // 'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'kos_mohon' => 'nullable|numeric|max:999999999999',
                    // 'dokumen' => 'file|mimes:pdf|max:1024', 
                    'dokumen' => 'file|mimes:pdf|max:5120', 
                ];
                $messages = [
                    'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',

                    'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',

                    'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',

                    'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',
                    'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',
                    'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',
                    'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                    'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                    // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',

                    'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                    'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                    'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                    'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/pemohon/kemaskini/' . $id)->withInput();
                }

                //File Kemaskini
                $file1 = $request->file('dokumen');

                if($request->hasFile('dokumen')) {
                    $filename1 = time() . '_' . $file1->getClientOriginalName();
                    $filePath1 = $file1->move('uploads/dokumen_tambahan/', $filename1);
                }
                else {
                    $filePath1 = '';
                }
            
                if($filePath1 == ''){
                    $filePath1 = $maklumat1->doc_Sokongan;
                } 

                //Radio Button Perancangan IF NULL
                if( !$request->input('perancangan') ) { $perancangan = null; }
                else { $perancangan = $data['perancangan']; }

                MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                    'rujukan_fail' => $data['ruj_fail'],
                    'namaProgram' => $data['nama_program'],
                    'tujuanProgram' => $data['tujuan'],
                    'latarBelakang' => $data['latarBelakang'],
                    'id_jenis_peruntukan' => $data['jenis_peruntukan'],
                    // 'id_jenis_perbelanjaan' => $data['no_vot'],
                    'tkhCadangMula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
                    'tkhCadangAkhir' => Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d'),
                    'kosMohon' => $data['kos_mohon'],
                    'perancangan' => $perancangan,
                    // 'syor' => $data['syor'],
                    // 'pengesah' => $data['pengesah'],
                    'doc_Sokongan' => $filePath1,
                    'updatedAt' => Carbon\Carbon::now()
                ]);

                Objektif::where('idMaklumatPermohonan', $id)->update([
                    'obj1' => $data['objektif1'],
                    'obj2' => $data['objektif2'],
                    'obj3' => $data['objektif3'],
                    'obj4' => $data['objektif4'],
                    'obj5' => $data['objektif5']
                ]);

                //IF AGENSI PERLU SAVE DETAIL PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    
                    $cariPengesah = Pengesah::where('idMaklumatPermohonan', $id)->first();

                    if( $cariPengesah) {
                        // return 'ada';
                        Pengesah::where('idMaklumatPermohonan', $id)->update([
                            'namaPengesah' => $data['nama_pengesah'],
                            'jawatanPengesah' => $data['jawatan_pengesah'],
                            'bahagianPengesah' => $data['bahagian_pengesah'],
                            'agensiPengesah' => $data['agensi_pengesah'],
                        ]);
                    }
                    else {
                        // return 'tak ada';
                        $pengesah = new Pengesah();
                        $pengesah->idMaklumatPermohonan = $id;
                        $pengesah->namaPengesah = $data['nama_pengesah'];
                        $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
                        $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
                        $pengesah->agensiPengesah = $data['agensi_pengesah'];
                        $pengesah->save();
                    }
                    
                }

                
                // UPDATE NO TELEFON USER 
                // PPersonel::where('nokp', $pemohon->noKp)->update([
                    //     'tel' => $data['tel_pejabat'],
                    //     'tel_bimbit' =>  $data['telefon'],
                    //     'updated_at' => Carbon\Carbon::now(),
                    // ]);
                PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumat1->idPemohonPeruntukan)->update([
                    'telefon' => $data['telefon'],
                    'telefonPejabat' => $data['tel_pejabat'],
                ]);
                User::where('mykad', $pemohon->noKp)->update([
                    'tel_pejabat' => $data['tel_pejabat'],
                    'telefon' =>  $data['telefon'],
                    'updated_at' => Carbon\Carbon::now(),
                ]);

                $request->session()->flash('status', 'Maklumat objektif dikemaskini.');
                return redirect('/pemohon/kemaskini/' . $id);// idMaklumatPermohonan
        }
        else if( isset($_POST['simpan']) ) {  //IF BUTTON SIMPAN
                $rules = [
                    'nama_program' => 'nullable|string',
                    'tujuan' => 'nullable|string',
                    'ruj_fail' => 'nullable|string',
                    'latarBelakang' => 'nullable|string',
                    'dasarSemasa' => 'nullable|string',
                    'justifikasiPermohonan' => 'nullable|string',
                    'ulasanBahagian' => 'nullable|string',
                    'pengesah' => 'nullable|int',

                    'objektif1' => 'nullable|string',
                    'objektif2' => 'nullable|string',
                    'objektif3' => 'nullable|string',
                    'objektif4' => 'nullable|string',
                    'objektif5' => 'nullable|string',

                    // 'syor' => 'nullable|string',
                    // 'perancangan' => 'required',    
                    // 'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'kos_mohon' => 'nullable|numeric|max:999999999999',
                    // 'dokumen' => 'file|mimes:pdf|max:1024', 
                    'dokumen' => 'file|mimes:pdf|max:5120', 
                ];
                $messages = [
                    'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',

                    'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',

                    'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',
                    'dasarSemasa.string' => 'Dasar Semasa mesti mengandungi huruf sahaja.',
                    'justifikasiPermohonan.string' => 'Justifikasi Permohonan mesti mengandungi huruf sahaja.',
                    'ulasanBahagian.string' => 'Ulasan Bahagian mesti mengandungi huruf sahaja.',

                    'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',
                    'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',
                    'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',
                    'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                    'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                    // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',

                    'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                    'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                    'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                    'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/pemohon/kemaskini/' . $id)->withInput();
                }

                //File Kemaskini
                $file1 = $request->file('dokumen');

                if($request->hasFile('dokumen')) {

                     // Check if there is an existing file
                    if ($maklumat1 && $maklumat1->doc_Sokongan) {
                        $existingFilePath = 'public/' . $maklumat1->doc_Sokongan; // Full path to the existing file

                        // Delete the existing file if it exists
                        if (Storage::exists($existingFilePath)) {
                            Storage::delete($existingFilePath);
                        }
                    }

                    $filename1 = time() . '_' . $file1->getClientOriginalName();
                    // $filePath1 = $file1->move('uploads/dokumen_tambahan/', $filename1);
                    $filePath1 = $file1->storeAs('dokumen_tambahan', $filename1, 'public'); // Save in storage/app/public/dokumen_tambahan
                }
                else {
                    $filePath1 = '';
                }
            
                if($filePath1 == ''){
                    $filePath1 = $maklumat1->doc_Sokongan;
                } 

                //Radio Button Perancangan IF NULL
                if( !$request->input('perancangan') ) { $perancangan = null; }
                else if( $data['perancangan'] == 1 || $data['perancangan'] == 2 ) { $perancangan = $data['perancangan']; }

                // IF AGENSI MASUKKAN NAMA PENGESAH
                    if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                        $pengesahData = $data['pengesah'];
                    }
                    else {
                        $pengesahData = null;
                    }
                // IF AGENSI MASUKKAN NAMA PENGESAH

                MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                    'rujukan_fail' => $data['ruj_fail'],
                    'pengesah' => $pengesahData,
                    'namaProgram' => $data['nama_program'],
                    // 'tujuanProgram' => $data['tujuan'],
                    // 'latarBelakang' => $data['latarBelakang'],
                    // 'dasarSemasa' => $data['dasarSemasa'],
                    // 'justifikasiPermohonan' => $data['justifikasiPermohonan'],
                    // 'ulasanBahagian' => $data['ulasanBahagian'],
                    'id_jenis_peruntukan' => $data['jenis_peruntukan'],
                    // 'id_jenis_perbelanjaan' => $data['no_vot'],
                    'tkhCadangMula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
                    'tkhCadangAkhir' => Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d'),
                    'kosMohon' => $data['kos_mohon'],
                    'perancangan' => $perancangan,
                    // 'syor' => $data['syor'],
                    // 'pengesah' => $data['pengesah'],
                    'doc_Sokongan' => $filePath1,
                    'updatedAt' => Carbon\Carbon::now()
                ]);

                // Objektif::where('idMaklumatPermohonan', $id)->update([
                //     'obj1' => $data['objektif1'],
                //     'obj2' => $data['objektif2'],
                //     'obj3' => $data['objektif3'],
                //     'obj4' => $data['objektif4'],
                //     'obj5' => $data['objektif5']
                // ]);

                //IF AGENSI PERLU SAVE DETAIL PENGESAH
                // if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    
                //     $cariPengesah = Pengesah::where('idMaklumatPermohonan', $id)->first();

                //     if( $cariPengesah) {
                //         // return 'ada';
                //         Pengesah::where('idMaklumatPermohonan', $id)->update([
                //             'namaPengesah' => $data['nama_pengesah'],
                //             'jawatanPengesah' => $data['jawatan_pengesah'],
                //             'bahagianPengesah' => $data['bahagian_pengesah'],
                //             'agensiPengesah' => $data['agensi_pengesah'],
                //         ]);
                //     }
                //     else {
                //         // return 'tak ada';
                //         $pengesah = new Pengesah();
                //         $pengesah->idMaklumatPermohonan = $id;
                //         $pengesah->namaPengesah = $data['nama_pengesah'];
                //         $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
                //         $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
                //         $pengesah->agensiPengesah = $data['agensi_pengesah'];
                //         $pengesah->save();
                //     }
                    
                // }
                
                // UPDATE NO TELEFON USER 
                // PPersonel::where('nokp', $pemohon->noKp)->update([
                    //     'tel' => $data['tel_pejabat'],
                    //     'tel_bimbit' =>  $data['telefon'],
                    //     'updated_at' => Carbon\Carbon::now(),
                    // ]);
                PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumat1->idPemohonPeruntukan)->update([
                    'telefon' => $data['telefon'],
                    'telefonPejabat' => $data['tel_pejabat'],
                ]);
                User::where('mykad', $pemohon->noKp)->update([
                    'tel_pejabat' => $data['tel_pejabat'],
                    'telefon' =>  $data['telefon'],
                    'updated_at' => Carbon\Carbon::now(),
                ]);

                $request->session()->flash('status', 'Maklumat berjaya disimpan.');
                return redirect('/pemohon/kemaskini/' . $id);// idMaklumatPermohonan
        }
        else if( isset($_POST['buang_file']) ) {  //IF BUTTON BUANG FILE

            $maklumat = MaklumatPermohonan::find($id); // Retrieve the record by ID

            if ($maklumat && $maklumat->doc_Sokongan) {
                // Get the file path
                $filePath = 'public/' . $maklumat->doc_Sokongan; //public/dokumen_tambahan/namafile.pdf
        
                // Check if the file exists and delete it
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
        
                // Update the database to remove the reference
                $maklumat->update([
                    'doc_Sokongan' => null,
                    'updatedAt' => Carbon\Carbon::now(),
                ]);
                // MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                //     'doc_Sokongan' => null,
                //     'updatedAt' => Carbon\Carbon::now()
                // ]);
            }
        
            // Set a success message
            $request->session()->flash('status', 'Fail berjaya dibuang.');
            return redirect('/pemohon/kemaskini/' . $id); // Redirect to the update page
        }
        else if( isset($_POST['hantar_semula_pentadbir']) ) { 
            //PENTADBIR SEMAK SEMULA 
            //PEMOHON HANTAR SEMULA KE PENTADBIR
            if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //if Agensi perlu detail pengesah
                $rules = [
                    'nama_program' => 'required|string',
                    // 'tujuan' => 'required|string',
                    // 'latarBelakang' => 'required|string',
                    // 'objektif1' => 'required|string',
                    // 'objektif2' => 'nullable|string',
                    // 'objektif3' => 'nullable|string',
                    // 'objektif4' => 'nullable|string',
                    // 'objektif5' => 'nullable|string',
                    'pengesah' => 'required|int',

                    'perancangan' => 'required',    
                    'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                    // 'syor' => 'required|string',
                    // 'pengesah' => 'required',
                    'ruj_fail' => 'required|string',
                    'dokumen' => 'file|mimes:pdf|max:5120',
                    // 'nama_pengesah' => 'required|string', 
                    // 'jawatan_pengesah' => 'required|string', 
                    // 'bahagian_pengesah' => 'required|string', 
                    // 'agensi_pengesah' => 'required|string', 
                ];
            }
            else {
                $rules = [
                    'nama_program' => 'required|string',
                    // 'tujuan' => 'required|string',
                    // 'latarBelakang' => 'required|string',
                    // 'objektif1' => 'required|string',
                    // 'objektif2' => 'nullable|string',
                    // 'objektif3' => 'nullable|string',
                    // 'objektif4' => 'nullable|string',
                    // 'objektif5' => 'nullable|string',
                    'perancangan' => 'required',    
                    'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'ruj_fail' => 'required|string',
                    'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                    // 'syor' => 'required|string',
                    // 'pengesah' => 'required',
                    'dokumen' => 'file|mimes:pdf|max:5120', 
                ];
            }
            $messages = [
                'nama_program.required' => 'Sila pastikan anda telah memasukkan nama program.',
                'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',

                'tujuan.required' => 'Sila pastikan anda telah memasukkan tujuan program.',
                'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',

                'latarBelakang.required' => 'Sila pastikan anda telah memasukkan Latar Belakang.',
                'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',

                'dasarSemasa.required' => 'Sila pastikan anda telah memasukkan Dasar Semasa.',
                'dasarSemasa.string' => 'Dasar Semasa mesti mengandungi huruf sahaja.',

                'justifikasiPermohonan.required' => 'Sila pastikan anda telah memasukkan Justifikasi Permohonan.',
                'justifikasiPermohonan.string' => 'Justifikasi Permohonan mesti mengandungi huruf sahaja.',

                'ulasanBahagian.required' => 'Sila pastikan anda telah memasukkan Ulasan Bahagian.',
                'ulasanBahagian.string' => 'Ulasan Bahagian mesti mengandungi huruf sahaja.',

                'pengesah.required' => 'Sila pastikan anda telah memilih Pengesah Permohonan.',

                'objektif1.required' => 'Sila pastikan anda telah memasukkan Objektif 1.',
                'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',

                'objektif2.required' => 'Sila pastikan anda telah memasukkan Objektif 2.',
                'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',

                'objektif3.required' => 'Sila pastikan anda telah memasukkan Objektif 3.',
                'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',

                'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                'perancangan.required' => 'Sila pastikan anda telah memilih Status Program.',
                'tkh_mula.required' => 'Sila pastikan anda telah memasukkan Tarikh Mula.',
                'tkh_tamat.required' => 'Sila pastikan anda telah memasukkan Tarikh Tamat.',
                'kos_mohon.required' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                'kos_mohon.not_in' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                // 'syor.required' => 'Sila pastikan anda telah memasukkan Syor.',
                // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',
                
                // 'pengesah.required' => 'Sila pastikan anda telah memilih Pengesah.',

                'nama_pengesah.required' => 'Sila pastikan anda telah memasukkan Nama Pengesah.',
                'jawatan_pengesah.required' => 'Sila pastikan anda telah memasukkan Jawatan Pengesah.',
                'bahagian_pengesah.required' => 'Sila pastikan anda telah memasukkan Bahagian Pengesah.',
                'agensi_pengesah.required' => 'Sila pastikan anda telah memasukkan Agensi Pengesah.',

                'ruj_fail.required' => 'Sila pastikan anda telah memasukkan No. Rujukan Fail.',
                
                'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
            ];

            $validator = Validator::make($request->all(), $rules);

            //Check if semua INPUT dimasukkan lengkap
                $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->first();
                $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->first();
                $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->first();
                $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->first();
                $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->first();

                // Check if validation fails or related data is missing
                if ($validator->fails() || !$tujuans || !$latars || !$dasars || !$justifikasis || !$ulasans) {
                    $errors = $validator->errors();

                    // Add custom error messages for missing related data
                    if (!$tujuans) {
                        $errors->add('tujuan', 'Maklumat Tujuan tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$latars) {
                        $errors->add('latarBelakang', 'Maklumat Latar Belakang tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$dasars) {
                        $errors->add('dasarSemasa', 'Maklumat Dasar Semasa tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$justifikasis) {
                        $errors->add('justifikasiPermohonan', 'Maklumat Justifikasi Permohonan tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$ulasans) {
                        $errors->add('ulasanBahagian', 'Maklumat Ulasan Bahagian tidak lengkap. Sila semak dan isi semula.');
                    }

                    // Redirect with errors and input data
                    return redirect('/pemohon/kemaskini/' . $id)
                        ->withErrors($errors)
                        ->withInput();
                }

            //Check if semua INPUT dimasukkan lengkap

            // if ($validator->fails()) {
            //     $request->validate($rules, $messages);
            //     return redirect('/pemohon/kemaskini/' . $id)->withInput();
            // }

            //Check if semua VOT dimasukkan lengkap
                if ( $data['form_VOT'] != null ) {
                    $expVot = explode('|x|x|', $data['form_VOT']);

                    for($mj=0; $mj<count($expVot) - 1; $mj++) {
                        $decodeMJ = base64_decode($expVot[$mj]);
                        $expDecodeMJ = explode('x|x', $decodeMJ);

                        if ( $expDecodeMJ[1] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                        else if ( $expDecodeMJ[2] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                        // else if ( $expDecodeMJ[7] == null) { UNIT
                        //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                        //     return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        // }
                        else if ( $expDecodeMJ[9] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                    }
                }
            //Check if semua VOT dimasukkan lengkap

            // CHECK IF BAHAGIAN/AGENSI PEMOHON TAKDE PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ) {
                    $cariPengesahAgensi = User::where('agensi', $user->agensi)->where('id_access', 'Pengesah')->first();
                    if( !$cariPengesahAgensi ){
                        $request->session()->flash('failed', 'Akaun Pengesah Agensi/Jabatan belum dicipta. Sila maklumkan kepada Pentadbir Sistem untuk mencipta akaun pengesah agensi/jabatan sebelum menghantar permohonan.');
                        return redirect('/pemohon/kemaskini/' . $id)->withInput();
                    }
                    // return 'ada pengesah';
                }
                else{
                    $cariPengesahKPN = User::where('bahagian', $user->bahagian)->where('id_access', 'Pengesah')->first();
                    if( !$cariPengesahKPN ){
                        $request->session()->flash('failed', 'Akaun Pengesah Bahagian belum dicipta. Sila maklumkan kepada Pentadbir Sistem untuk mencipta akaun pengesah bahagian sebelum menghantar permohonan.');
                        return redirect('/pemohon/kemaskini/' . $id)->withInput();
                    }
                }
            // CHECK IF BAHAGIAN/AGENSI PEMOHON TAKDE PENGESAH

            //File Kemaskini
            $file1 = $request->file('dokumen');

            if($request->hasFile('dokumen')) {

                // Check if there is an existing file
                if ($maklumat1 && $maklumat1->doc_Sokongan) {
                    $existingFilePath = 'public/' . $maklumat1->doc_Sokongan; // Full path to the existing file

                    // Delete the existing file if it exists
                    if (Storage::exists($existingFilePath)) {
                        Storage::delete($existingFilePath);
                    }
                }

                $filename1 = time() . '_' . $file1->getClientOriginalName();
                // $filePath1 = $file1->move('uploads/dokumen_tambahan/', $filename1);
                $filePath1 = $file1->storeAs('dokumen_tambahan', $filename1, 'public'); // Save in storage/app/public/dokumen_tambahan
            }
            else {
                $filePath1 = '';
            }
        
            if($filePath1 == ''){
                $filePath1 = $maklumat1->doc_Sokongan;
            } 

            // IF AGENSI MASUKKAN NAMA PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    $pengesahData = $data['pengesah'];
                }
                else {
                    $pengesahData = null;
                }
            // IF AGENSI MASUKKAN NAMA PENGESAH

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'rujukan_fail' => $data['ruj_fail'],
                'pengesah' => $pengesahData,
                'namaProgram' => $data['nama_program'],
                // 'tujuanProgram' => $data['tujuan'],
                // 'latarBelakang' => $data['latarBelakang'],
                'id_jenis_peruntukan' => $data['jenis_peruntukan'],
                // 'id_jenis_perbelanjaan' => $data['no_vot'],
                'tkhCadangMula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
                'tkhCadangAkhir' => Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d'),
                'kosMohon' => $data['kos_mohon'],
                'perancangan' => $data['perancangan'],
                // 'syor' => $data['syor'],
                // 'pengesah' => $data['pengesah'],
                'doc_Sokongan' => $filePath1,
                'id_status' => 21, //Dikemaskini ke Pentadbir
                'updatedAt' => Carbon\Carbon::now()
            ]);

            // Objektif::where('idMaklumatPermohonan', $id)->update([
            //     'obj1' => $data['objektif1'],
            //     'obj2' => $data['objektif2'],
            //     'obj3' => $data['objektif3'],
            //     'obj4' => $data['objektif4'],
            //     'obj5' => $data['objektif5']
            // ]);


            //Tindakan SAVE
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = 21; //status = Dikemaskini to Pentadbir
            $tindakan->Ulasan = '';
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy =  $user->id;
            $tindakan->save();

            //IF AGENSI PERLU SAVE DETAIL PENGESAH
            // if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    
            //     $cariPengesah = Pengesah::where('idMaklumatPermohonan', $id)->first();

            //     if( $cariPengesah) {
            //         // return 'ada';
            //         Pengesah::where('idMaklumatPermohonan', $id)->update([
            //             'namaPengesah' => $data['nama_pengesah'],
            //             'jawatanPengesah' => $data['jawatan_pengesah'],
            //             'bahagianPengesah' => $data['bahagian_pengesah'],
            //             'agensiPengesah' => $data['agensi_pengesah'],
            //         ]);
            //     }
            //     else {
            //         // return 'tak ada';
            //         $pengesah = new Pengesah();
            //         $pengesah->idMaklumatPermohonan = $id;
            //         $pengesah->namaPengesah = $data['nama_pengesah'];
            //         $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
            //         $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
            //         $pengesah->agensiPengesah = $data['agensi_pengesah'];
            //         $pengesah->save();
            //     }
                
            // }
            
            // UPDATE NO TELEFON USER 
            // PPersonel::where('nokp', $pemohon->noKp)->update([
                //     'tel' => $data['tel_pejabat'],
                //     'tel_bimbit' =>  $data['telefon'],
                //     'updated_at' => Carbon\Carbon::now(),
                // ]);
            PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumat1->idPemohonPeruntukan)->update([
                'telefon' => $data['telefon'],
                'telefonPejabat' => $data['tel_pejabat'],
            ]);
            User::where('mykad', $pemohon->noKp)->update([
                'tel_pejabat' => $data['tel_pejabat'],
                'telefon' =>  $data['telefon'],
                'updated_at' => Carbon\Carbon::now(),
            ]);

            //IF KPN, HANTAR KE PENTADBIR SISTEM SEMULA
            // if( $user->agensi == 'Kementerian Perpaduan Negara' || $user->agensi == 'Kementerian Perpaduan Negara (KPN)' ){ //HANTAR SEMULA KE PENTADBIR

                    // $tindakanPentadbir = Tindakan::where('id_status', 22)->latest('CreatedAt')->first(); //if nk hantar email ke sape pentadbir yang suruh semak semula
                    $tindakanPentadbir = Tindakan::whereIn('id_status', [13, 14])
                                                    ->latest('CreatedAt')->first(); //hantar email ke pentadbir sistem semula untuk tindakan

                    $pentadbir = User::where('id', $tindakanPentadbir->UpdatedBy)->first(); //PENTADBIR
                                
                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                        // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                        ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                        // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                        ->first();
                    // dd($contentEmel);
                    if ( !app()->environment('local') && !app()->environment('development') ) {
                        Mail::send('email/tindakan/emel_semula_to_PENTADBIR_SUB', ['contentEmel' => $contentEmel], function ($header) use ($user, $pentadbir, $contentEmel)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->to($pentadbir->email, $pentadbir->nama); //HANTAR KE PENTADBIR SISTEM 
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
    
                            $header->subject('Notifikasi Permohonan Dikemaskini ePantas.');
                        });
                    }
            // }
            //IF KPN, HANTAR KE PENTADBIR SISTEM SEMULA

            $request->session()->flash('status', 'Maklumat permohonan berjaya dihantar.');
            return redirect('/pemohon/butiran/' . $id); 
    
        }
        else if( isset($_POST['hantar_semula_pengesah']) ) { //IF BUTTON HANTAR SEMULA
            if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //if Agensi perlu detail pengesah
                $rules = [
                    'nama_program' => 'required|string',
                    // 'tujuan' => 'required|string',
                    // 'latarBelakang' => 'required|string',
                    // 'objektif1' => 'required|string',
                    // 'objektif2' => 'nullable|string',
                    // 'objektif3' => 'nullable|string',
                    // 'objektif4' => 'nullable|string',
                    // 'objektif5' => 'nullable|string',
                    'pengesah' => 'required|int',

                    'perancangan' => 'required',    
                    'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                    // 'syor' => 'required|string',
                    // 'pengesah' => 'required',
                    'ruj_fail' => 'required|string',
                    'dokumen' => 'file|mimes:pdf|max:5120',
                    // 'nama_pengesah' => 'required|string', 
                    // 'jawatan_pengesah' => 'required|string', 
                    // 'bahagian_pengesah' => 'required|string', 
                    // 'agensi_pengesah' => 'required|string', 
                ];
            }
            else {
                $rules = [
                    'nama_program' => 'required|string',
                    // 'tujuan' => 'required|string',
                    // 'latarBelakang' => 'required|string',
                    // 'objektif1' => 'required|string',
                    // 'objektif2' => 'nullable|string',
                    // 'objektif3' => 'nullable|string',
                    // 'objektif4' => 'nullable|string',
                    // 'objektif5' => 'nullable|string',
                    'perancangan' => 'required',    
                    'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'ruj_fail' => 'required|string',
                    'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                    // 'syor' => 'required|string',
                    // 'pengesah' => 'required',
                    'dokumen' => 'file|mimes:pdf|max:5120', 
                ];
            }
            $messages = [
                'nama_program.required' => 'Sila pastikan anda telah memasukkan nama program.',
                'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',

                'tujuan.required' => 'Sila pastikan anda telah memasukkan tujuan program.',
                'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',

                'latarBelakang.required' => 'Sila pastikan anda telah memasukkan Latar Belakang.',
                'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',

                'dasarSemasa.required' => 'Sila pastikan anda telah memasukkan Dasar Semasa.',
                'dasarSemasa.string' => 'Dasar Semasa mesti mengandungi huruf sahaja.',

                'justifikasiPermohonan.required' => 'Sila pastikan anda telah memasukkan Justifikasi Permohonan.',
                'justifikasiPermohonan.string' => 'Justifikasi Permohonan mesti mengandungi huruf sahaja.',

                'ulasanBahagian.required' => 'Sila pastikan anda telah memasukkan Ulasan Bahagian.',
                'ulasanBahagian.string' => 'Ulasan Bahagian mesti mengandungi huruf sahaja.',

                'objektif1.required' => 'Sila pastikan anda telah memasukkan Objektif 1.',
                'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',

                'objektif2.required' => 'Sila pastikan anda telah memasukkan Objektif 2.',
                'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',

                'objektif3.required' => 'Sila pastikan anda telah memasukkan Objektif 3.',
                'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',

                'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                'perancangan.required' => 'Sila pastikan anda telah memilih Status Program.',
                'tkh_mula.required' => 'Sila pastikan anda telah memasukkan Tarikh Mula.',
                'tkh_tamat.required' => 'Sila pastikan anda telah memasukkan Tarikh Tamat.',
                'kos_mohon.required' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                'kos_mohon.not_in' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                // 'syor.required' => 'Sila pastikan anda telah memasukkan Syor.',
                // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',
                
                'pengesah.required' => 'Sila pastikan anda telah memilih Pengesah.',

                'nama_pengesah.required' => 'Sila pastikan anda telah memasukkan Nama Pengesah.',
                'jawatan_pengesah.required' => 'Sila pastikan anda telah memasukkan Jawatan Pengesah.',
                'bahagian_pengesah.required' => 'Sila pastikan anda telah memasukkan Bahagian Pengesah.',
                'agensi_pengesah.required' => 'Sila pastikan anda telah memasukkan Agensi Pengesah.',

                'ruj_fail.required' => 'Sila pastikan anda telah memasukkan No. Rujukan Fail.',
                
                'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
            ];

            $validator = Validator::make($request->all(), $rules);

            //Check if semua INPUT dimasukkan lengkap
                $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->first();
                $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->first();
                $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->first();
                $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->first();
                $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->first();

                // Check if validation fails or related data is missing
                if ($validator->fails() || !$tujuans || !$latars || !$dasars || !$justifikasis || !$ulasans) {
                    $errors = $validator->errors();

                    // Add custom error messages for missing related data
                    if (!$tujuans) {
                        $errors->add('tujuan', 'Maklumat Tujuan tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$latars) {
                        $errors->add('latarBelakang', 'Maklumat Latar Belakang tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$dasars) {
                        $errors->add('dasarSemasa', 'Maklumat Dasar Semasa tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$justifikasis) {
                        $errors->add('justifikasiPermohonan', 'Maklumat Justifikasi Permohonan tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$ulasans) {
                        $errors->add('ulasanBahagian', 'Maklumat Ulasan Bahagian tidak lengkap. Sila semak dan isi semula.');
                    }

                    // Redirect with errors and input data
                    return redirect('/pemohon/kemaskini/' . $id)
                        ->withErrors($errors)
                        ->withInput();
                }

            //Check if semua INPUT dimasukkan lengkap

            // if ($validator->fails()) {
            //     $request->validate($rules, $messages);
            //     return redirect('/pemohon/kemaskini/' . $id)->withInput();
            // }

            //Check if semua VOT dimasukkan lengkap
                if ( $data['form_VOT'] != null ) {
                    $expVot = explode('|x|x|', $data['form_VOT']);

                    for($mj=0; $mj<count($expVot) - 1; $mj++) {
                        $decodeMJ = base64_decode($expVot[$mj]);
                        $expDecodeMJ = explode('x|x', $decodeMJ);

                        if ( $expDecodeMJ[1] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                        else if ( $expDecodeMJ[2] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                        // else if ( $expDecodeMJ[7] == null) { UNIT
                        //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                        //     return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        // }
                        else if ( $expDecodeMJ[9] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                    }
                }
            //Check if semua VOT dimasukkan lengkap

            //File Kemaskini
            $file1 = $request->file('dokumen');

            if($request->hasFile('dokumen')) {

                // Check if there is an existing file
                if ($maklumat1 && $maklumat1->doc_Sokongan) {
                    $existingFilePath = 'public/' . $maklumat1->doc_Sokongan; // Full path to the existing file

                    // Delete the existing file if it exists
                    if (Storage::exists($existingFilePath)) {
                        Storage::delete($existingFilePath);
                    }
                }

                $filename1 = time() . '_' . $file1->getClientOriginalName();
                // $filePath1 = $file1->move('uploads/dokumen_tambahan/', $filename1);
                $filePath1 = $file1->storeAs('dokumen_tambahan', $filename1, 'public'); // Save in storage/app/public/dokumen_tambahan
            }
            else {
                $filePath1 = '';
            }
        
            if($filePath1 == ''){
                $filePath1 = $maklumat1->doc_Sokongan;
            } 

            // IF AGENSI MASUKKAN NAMA PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    $pengesahData = $data['pengesah'];
                }
                else {
                    $pengesahData = null;
                }
            // IF AGENSI MASUKKAN NAMA PENGESAH

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'rujukan_fail' => $data['ruj_fail'],
                'pengesah' => $pengesahData,
                'namaProgram' => $data['nama_program'],
                // 'tujuanProgram' => $data['tujuan'],
                // 'latarBelakang' => $data['latarBelakang'],
                'id_jenis_peruntukan' => $data['jenis_peruntukan'],
                // 'id_jenis_perbelanjaan' => $data['no_vot'],
                'tkhCadangMula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
                'tkhCadangAkhir' => Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d'),
                'kosMohon' => $data['kos_mohon'],
                'perancangan' => $data['perancangan'],
                // 'syor' => $data['syor'],
                // 'pengesah' => $data['pengesah'],
                'doc_Sokongan' => $filePath1,
                'id_status' => 20, //Dikemaskini ke Pengesah
                'updatedAt' => Carbon\Carbon::now()
            ]);

            // Objektif::where('idMaklumatPermohonan', $id)->update([
            //     'obj1' => $data['objektif1'],
            //     'obj2' => $data['objektif2'],
            //     'obj3' => $data['objektif3'],
            //     'obj4' => $data['objektif4'],
            //     'obj5' => $data['objektif5']
            // ]);

            //Tindakan SAVE
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = 20; //status = Dikemaskini to Pengesah
            $tindakan->Ulasan = '';
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy =  $user->id;
            $tindakan->save();

            //IF AGENSI PERLU SAVE DETAIL PENGESAH
            // if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    
            //     $cariPengesah = Pengesah::where('idMaklumatPermohonan', $id)->first();

            //     if( $cariPengesah) {
            //         // return 'ada';
            //         Pengesah::where('idMaklumatPermohonan', $id)->update([
            //             'namaPengesah' => $data['nama_pengesah'],
            //             'jawatanPengesah' => $data['jawatan_pengesah'],
            //             'bahagianPengesah' => $data['bahagian_pengesah'],
            //             'agensiPengesah' => $data['agensi_pengesah'],
            //         ]);
            //     }
            //     else {
            //         // return 'tak ada';
            //         $pengesah = new Pengesah();
            //         $pengesah->idMaklumatPermohonan = $id;
            //         $pengesah->namaPengesah = $data['nama_pengesah'];
            //         $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
            //         $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
            //         $pengesah->agensiPengesah = $data['agensi_pengesah'];
            //         $pengesah->save();
            //     }
                
            // }

            
            // UPDATE NO TELEFON USER 
            // PPersonel::where('nokp', $pemohon->noKp)->update([
                //     'tel' => $data['tel_pejabat'],
                //     'tel_bimbit' =>  $data['telefon'],
                //     'updated_at' => Carbon\Carbon::now(),
                // ]);
            PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumat1->idPemohonPeruntukan)->update([
                'telefon' => $data['telefon'],
                'telefonPejabat' => $data['tel_pejabat'],
            ]);
            User::where('mykad', $pemohon->noKp)->update([
                'tel_pejabat' => $data['tel_pejabat'],
                'telefon' =>  $data['telefon'],
                'updated_at' => Carbon\Carbon::now(),
            ]);

            //IF KPN HANTAR KE SUB BAHAGIAN/PENGESAH SEMULA
            // if( $user->agensi == 'Kementerian Perpaduan Negara' || $user->agensi == 'Kementerian Perpaduan Negara (KPN)' ){ //HANTAR SEMULA KE PENGESAH

                    $tindakanPengesah = Tindakan::where('id_status', 11)->latest('CreatedAt')->first();

                    $pentadbir = User::where('id', $tindakanPengesah->UpdatedBy)->first(); //PENGESAH
                                
                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                        // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                        ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                        // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                        ->first();
                    // dd($contentEmel);
                    if ( !app()->environment('local') && !app()->environment('development') ) {
                        Mail::send('email/tindakan/emel_semula_to_PENTADBIR_SUB', ['contentEmel' => $contentEmel], function ($header) use ($user, $pentadbir, $contentEmel)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                            $header->to($pentadbir->email, $pentadbir->nama); //HANTAR KE KETUA BAHAGIAN UNTUK DISYORKAN 
    
                            // foreach($pentadbirs as $pentadbir)
                            // {
                            // $header->cc('ariefazhim@gmail.com', 'Azhim');	//emel pentadbir
                            // $header->cc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
                            // }
    
                            $header->subject('Notifikasi Permohonan Dikemaskini ePantas.');
                        });
                    }
            // }
            //IF KPN HANTAR KE SUB BAHAGIAN/PENGESAH SEMULA

            $request->session()->flash('status', 'Maklumat permohonan berjaya dihantar.');
            return redirect('/pemohon/butiran/' . $id); 
    
        }
        else { //IF BUTTON HANTAR
            if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //if Agensi perlu detail pengesah
                $rules = [
                    'nama_program' => 'required|string',
                    // 'tujuan' => 'required|string',
                    // 'latarBelakang' => 'required|string',
                    // 'dasarSemasa' => 'required|string',
                    // 'justifikasiPermohonan' => 'required|string',
                    // 'ulasanBahagian' => 'required|string',

                    'pengesah' => 'required|int',

                    // 'objektif1' => 'required|string',
                    // 'objektif2' => 'nullable|string',
                    // 'objektif3' => 'nullable|string',
                    // 'objektif4' => 'nullable|string',
                    // 'objektif5' => 'nullable|string',

                    'perancangan' => 'required',    
                    'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                    // 'syor' => 'required|string',
                    // 'pengesah' => 'required',
                    'ruj_fail' => 'required|string',
                    'dokumen' => 'file|mimes:pdf|max:5120',
                    // 'nama_pengesah' => 'required|string', 
                    // 'jawatan_pengesah' => 'required|string', 
                    // 'bahagian_pengesah' => 'required|string', 
                    // 'agensi_pengesah' => 'required|string', 
                ];
            }
            else {
                $rules = [
                    'nama_program' => 'required|string',
                    // 'tujuan' => 'required|string',
                    // 'latarBelakang' => 'required|string',
                    // 'dasarSemasa' => 'required|string',
                    // 'justifikasiPermohonan' => 'required|string',
                    // 'ulasanBahagian' => 'required|string',

                    // 'objektif1' => 'required|string',
                    // 'objektif2' => 'nullable|string',
                    // 'objektif3' => 'nullable|string',
                    // 'objektif4' => 'nullable|string',
                    // 'objektif5' => 'nullable|string',

                    'perancangan' => 'required',    
                    'tkh_mula' => 'required',    
                    // 'tkh_tamat' => 'required',    
                    'ruj_fail' => 'required|string',
                    'kos_mohon' => 'required|numeric|not_in:0|max:999999999999',    
                    // 'syor' => 'required|string',
                    // 'pengesah' => 'required',
                    'dokumen' => 'file|mimes:pdf|max:5120', 
                ];
            }
            $messages = [
                'nama_program.required' => 'Sila pastikan anda telah memasukkan nama program.',
                'nama_program.string' => 'Nama Program mesti mengandungi huruf sahaja.',

                'tujuan.required' => 'Sila pastikan anda telah memasukkan tujuan program.',
                'tujuan.string' => 'Tujuan Program mesti mengandungi huruf sahaja.',

                'latarBelakang.required' => 'Sila pastikan anda telah memasukkan Latar Belakang.',
                'latarBelakang.string' => 'Latar Belakang mesti mengandungi huruf sahaja.',

                'dasarSemasa.required' => 'Sila pastikan anda telah memasukkan Dasar Semasa.',
                'dasarSemasa.string' => 'Dasar Semasa mesti mengandungi huruf sahaja.',

                'justifikasiPermohonan.required' => 'Sila pastikan anda telah memasukkan Justifikasi Permohonan.',
                'justifikasiPermohonan.string' => 'Justifikasi Permohonan mesti mengandungi huruf sahaja.',

                'ulasanBahagian.required' => 'Sila pastikan anda telah memasukkan Ulasan Bahagian.',
                'ulasanBahagian.string' => 'Ulasan Bahagian mesti mengandungi huruf sahaja.',

                'pengesah.required' => 'Sila pastikan anda telah memilih Pengesah Permohonan.',

                'objektif1.required' => 'Sila pastikan anda telah memasukkan Objektif 1.',
                'objektif1.string' => 'Objektif 1 mesti mengandungi huruf sahaja.',

                'objektif2.required' => 'Sila pastikan anda telah memasukkan Objektif 2.',
                'objektif2.string' => 'Objektif 2 mesti mengandungi huruf sahaja.',

                'objektif3.required' => 'Sila pastikan anda telah memasukkan Objektif 3.',
                'objektif3.string' => 'Objektif 3 mesti mengandungi huruf sahaja.',

                'objektif4.string' => 'Objektif 4 mesti mengandungi huruf sahaja.',
                'objektif5.string' => 'Objektif 5 mesti mengandungi huruf sahaja.',

                'perancangan.required' => 'Sila pastikan anda telah memilih Status Program.',
                'tkh_mula.required' => 'Sila pastikan anda telah memasukkan Tarikh Mula.',
                'tkh_tamat.required' => 'Sila pastikan anda telah memasukkan Tarikh Tamat.',
                'kos_mohon.required' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                'kos_mohon.not_in' => 'Sila pastikan anda telah mengisi Anggaran Implikasi Kewangan',
                'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                // 'syor.required' => 'Sila pastikan anda telah memasukkan Syor.',
                // 'syor.string' => 'Syor mesti mengandungi huruf sahaja.',
                
                // 'pengesah.required' => 'Sila pastikan anda telah memilih Pengesah.',

                'nama_pengesah.required' => 'Sila pastikan anda telah memasukkan Nama Pengesah.',
                'jawatan_pengesah.required' => 'Sila pastikan anda telah memasukkan Jawatan Pengesah.',
                'bahagian_pengesah.required' => 'Sila pastikan anda telah memasukkan Bahagian Pengesah.',
                'agensi_pengesah.required' => 'Sila pastikan anda telah memasukkan Agensi Pengesah.',

                'ruj_fail.required' => 'Sila pastikan anda telah memasukkan No. Rujukan Fail.',
                
                'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
            ];

            // $validator = Validator::make($request->all(), $rules);
            $validator = Validator::make($request->all(), $rules, $messages);

            //Check if semua INPUT dimasukkan lengkap
                $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->first();
                $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->first();
                $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->first();
                $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->first();
                $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->first();

                // Check if validation fails or related data is missing
                if ($validator->fails() || !$tujuans || !$latars || !$dasars || !$justifikasis || !$ulasans) {
                    $errors = $validator->errors();

                    // Add custom error messages for missing related data
                    if (!$tujuans) {
                        $errors->add('tujuan', 'Maklumat Tujuan tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$latars) {
                        $errors->add('latarBelakang', 'Maklumat Latar Belakang tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$dasars) {
                        $errors->add('dasarSemasa', 'Maklumat Dasar Semasa tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$justifikasis) {
                        $errors->add('justifikasiPermohonan', 'Maklumat Justifikasi Permohonan tidak lengkap. Sila semak dan isi semula.');
                    }
                    if (!$ulasans) {
                        $errors->add('ulasanBahagian', 'Maklumat Ulasan Bahagian tidak lengkap. Sila semak dan isi semula.');
                    }

                    // Redirect with errors and input data
                    return redirect('/pemohon/kemaskini/' . $id)
                        ->withErrors($errors)
                        ->withInput();
                }

            //Check if semua INPUT dimasukkan lengkap

            // if ($validator->fails()) {
            //     $request->validate($rules, $messages);
            //     return redirect('/pemohon/kemaskini/' . $id)->withInput();
            // }

            //Check if semua VOT dimasukkan lengkap
                if ( $data['form_VOT'] != null ) {
                    $expVot = explode('|x|x|', $data['form_VOT']);

                    for($mj=0; $mj<count($expVot) - 1; $mj++) {
                        $decodeMJ = base64_decode($expVot[$mj]);
                        $expDecodeMJ = explode('x|x', $decodeMJ);

                        if ( $expDecodeMJ[1] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                        else if ( $expDecodeMJ[2] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                        // else if ( $expDecodeMJ[7] == null) { UNIT
                        //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                        //     return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        // }
                        else if ( $expDecodeMJ[9] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/pemohon/kemaskini/' . $id)->withInput();
                        }
                    }
                }
            //Check if semua VOT dimasukkan lengkap

            // CHECK IF BAHAGIAN/AGENSI PEMOHON TAKDE PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ) {
                    $cariPengesahAgensi = User::where('agensi', $user->agensi)->where('id_access', 'Pengesah')->first();
                    if( !$cariPengesahAgensi ){
                        $request->session()->flash('failed', 'Akaun Pengesah Agensi/Jabatan belum dicipta. Sila maklumkan kepada Pentadbir Sistem untuk mencipta akaun pengesah agensi/jabatan sebelum menghantar permohonan.');
                        return redirect('/pemohon/kemaskini/' . $id)->withInput();
                    }
                    // return 'ada pengesah';
                }
                else{
                    $cariPengesahKPN = User::where('bahagian', $user->bahagian)->where('id_access', 'Pengesah')->first();
                    if( !$cariPengesahKPN ){
                        $request->session()->flash('failed', 'Akaun Pengesah Bahagian belum dicipta. Sila maklumkan kepada Pentadbir Sistem untuk mencipta akaun pengesah bahagian sebelum menghantar permohonan.');
                        return redirect('/pemohon/kemaskini/' . $id)->withInput();
                    }
                }
            // CHECK IF BAHAGIAN/AGENSI PEMOHON TAKDE PENGESAH

            //File Kemaskini
            $file1 = $request->file('dokumen');

            if($request->hasFile('dokumen')) {

                // Check if there is an existing file
                if ($maklumat1 && $maklumat1->doc_Sokongan) {
                    $existingFilePath = 'public/' . $maklumat1->doc_Sokongan; // Full path to the existing file

                    // Delete the existing file if it exists
                    if (Storage::exists($existingFilePath)) {
                        Storage::delete($existingFilePath);
                    }
                }

                $filename1 = time() . '_' . $file1->getClientOriginalName();
                $filePath1 = $file1->move('uploads/dokumen_tambahan/', $filename1);
            }
            else {
                $filePath1 = '';
            }
        
            if($filePath1 == ''){
                $filePath1 = $maklumat1->doc_Sokongan;
            } 

            //kod permohonan
            if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)'){
                // $kod = Agensi::where('agensi', $user->agensi)->first();
                $kod = Agensi::where('agensi', $user->agensi)->value('akronim') ?? 'KPN';
            }
            else {
                $bahagian = PLkpBahagian::where('bahagian', $user->bahagian)->first();
                $kod = $bahagian->singkatan;
            }
            $jumlah = MaklumatPermohonan::where('id_status', '!=', 12)->whereYear('createdAt', '=', Carbon\Carbon::now()->format('Y'))->count('idMaklumatPermohonan');
            $jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
            $kod_permohonan = $kod.'/'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;
            // $kod_permohonan = $bahagian->singkatan.'/'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;

            // IF AGENSI MASUKKAN NAMA PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    $pengesahData = $data['pengesah'];
                }
                else {
                    $pengesahData = null;
                }
            // IF AGENSI MASUKKAN NAMA PENGESAH

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'kod_permohonan' => $kod_permohonan,
                'rujukan_fail' => $data['ruj_fail'],
                'pengesah' => $pengesahData,
                'namaProgram' => $data['nama_program'],
                // 'tujuanProgram' => $data['tujuan'],
                // 'latarBelakang' => $data['latarBelakang'],
                // 'dasarSemasa' => $data['dasarSemasa'],
                // 'justifikasiPermohonan' => $data['justifikasiPermohonan'],
                // 'ulasanBahagian' => $data['ulasanBahagian'],
                'id_jenis_peruntukan' => $data['jenis_peruntukan'],
                // 'id_jenis_perbelanjaan' => $data['no_vot'],
                'tkhCadangMula' => Carbon\Carbon::parse($data['tkh_mula'])->format('Y-m-d'),
                'tkhCadangAkhir' => Carbon\Carbon::parse($data['tkh_tamat'])->format('Y-m-d'),
                'kosMohon' => $data['kos_mohon'],
                'perancangan' => $data['perancangan'],
                // 'syor' => $data['syor'],
                'id_status' => 1,
                'doc_Sokongan' => $filePath1,
                'updatedAt' => Carbon\Carbon::now()
            ]);

            //Tindakan SAVE PERMOHONAN BARU
                $tindakan = new Tindakan();
                $tindakan->idMaklumatPermohonan = $id;
                $tindakan->id_status = 1; //status = PERMOHONAN BARU
                $tindakan->Ulasan = '';
                $tindakan->CreatedAt = Carbon\Carbon::now();
                $tindakan->UpdatedAt = Carbon\Carbon::now();
                $tindakan->UpdatedBy =  $user->id;
                $tindakan->save();

            // Objektif::where('idMaklumatPermohonan', $id)->update([
            //     'obj1' => $data['objektif1'],
            //     'obj2' => $data['objektif2'],
            //     'obj3' => $data['objektif3'],
            //     'obj4' => $data['objektif4'],
            //     'obj5' => $data['objektif5']
            // ]);

            //IF AGENSI PERLU SAVE DETAIL PENGESAH
            // if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    
            //     $cariPengesah = Pengesah::where('idMaklumatPermohonan', $id)->first();

            //     if( $cariPengesah) {
            //         // return 'ada';
            //         Pengesah::where('idMaklumatPermohonan', $id)->update([
            //             'namaPengesah' => $data['nama_pengesah'],
            //             'jawatanPengesah' => $data['jawatan_pengesah'],
            //             'bahagianPengesah' => $data['bahagian_pengesah'],
            //             'agensiPengesah' => $data['agensi_pengesah'],
            //         ]);
            //     }
            //     else {
            //         // return 'tak ada';
            //         $pengesah = new Pengesah();
            //         $pengesah->idMaklumatPermohonan = $id;
            //         $pengesah->namaPengesah = $data['nama_pengesah'];
            //         $pengesah->jawatanPengesah = $data['jawatan_pengesah'];
            //         $pengesah->bahagianPengesah = $data['bahagian_pengesah'];
            //         $pengesah->agensiPengesah = $data['agensi_pengesah'];
            //         $pengesah->save();
            //     }
                
            // }
            
            // UPDATE NO TELEFON USER 
            // PPersonel::where('nokp', $pemohon->noKp)->update([
                //     'tel' => $data['tel_pejabat'],
                //     'tel_bimbit' =>  $data['telefon'],
                //     'updated_at' => Carbon\Carbon::now(),
                // ]);
            PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumat1->idPemohonPeruntukan)->update([
                'telefon' => $data['telefon'],
                'telefonPejabat' => $data['tel_pejabat'],
            ]);
            User::where('mykad', $pemohon->noKp)->update([
                'tel_pejabat' => $data['tel_pejabat'],
                'telefon' =>  $data['telefon'],
                'updated_at' => Carbon\Carbon::now(),
            ]);

            //IF KPN HANTAR KE SUB BAHAGIAN, ELSE HANTAR KE KEWANGAN
            // if( $user->agensi != 'Kementerian Perpaduan Negara' && $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //HANTAR KE KEWANGAN IF AGENSI

            //     //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
            //             $pentadbir = User::where('id_access', 'Pentadbir Sistem')
            //                             ->where('status', 'Aktif')
            //                             ->get(); //PENTADBIR KEWANGAN
            //             // dd($pentadbir);
                        
            //             $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
            //                                             // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
            //                                             ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
            //                                             // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
            //                                             ->first();
            //             // dd($contentEmel);

            //             $pemohonPeruntukan = \App\PPemohonPeruntukan::find($contentEmel->idPemohonPeruntukan);
            //             $pemohon = User::where('mykad', $pemohonPeruntukan->noKp)
            //             ->first(); //PEMOHON
            //             // dd($pemohon);

            //             // $pengesah = Pengesah::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)->first(); //PENGESAH UNTUK AGENSI
            //             $pengesah = Pengesah::where('idPengesah', $contentEmel->pengesah)->first(); //PENGESAH UNTUK AGENSI
            //             // dd($pengesah);

            //             //HANTAR KE KEWANGAN
            //             if ( !app()->environment('local') && !app()->environment('development') ) {
            //                 Mail::send('email/tindakan/emel_agensi_kewangan', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($user, $pentadbir, $contentEmel)
            //                 {
            //                     $header->from('no_reply@perpaduan.gov.my', 'ePantas');
            //                     $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
    
            //                     foreach($pentadbir as $pentadbirs)
            //                     {
            //                         // $header->cc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
            //                         $header->cc($pentadbirs->email,$pentadbirs->nama);	//HANTAR KE KEWANGAN SELEPAS DISYORKAN KETUA BAHAGIAN
            //                     }
    
            //                     $header->subject('Notifikasi Permohonan Baru ePantas.');
            //                 });
            //             }
            //     //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
            // }
            //else { //IF KPN HANTAR EMEL KE SUB UNTUK DISYORKAN
                //HANTAR EMEL KEPADA SUB/PENGESAH UNTUK DISYOR
                    if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ) { 
                        $pentadbir = User::where('agensi', $user->agensi)
                                    ->where('id_access', 'Pengesah')
                                    ->where('status', 'Aktif')
                                    ->first(); //KETUA PENGARAH
                                    // dd($pentadbir);
                    }
                    else {
                        $pentadbir = User::where('bahagian', $user->bahagian)
                                    ->where('id_access', 'Pengesah')
                                    ->where('status', 'Aktif')
                                    ->first(); //KETUA BAHAGIAN
                                    // dd($pentadbir);
                    }

                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                        // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                        ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                        // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                        ->first();
                    // dd($contentEmel);
                    if ( !app()->environment('local') && !app()->environment('development') ) {
                        Mail::send('email/tindakan/emel_to_SUB', ['contentEmel' => $contentEmel], function ($header) use ($user, $pentadbir, $contentEmel)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                            $header->to($pentadbir->email, $pentadbir->nama); //HANTAR KE KETUA BAHAGIAN UNTUK DISYORKAN 
    
                            // $header->subject('Notifikasi Permohonan Baru ePantas. TEST:HANTAR KE SUB BAHAGIAN.');
                            $header->subject('Notifikasi Permohonan Baru ePantas.');
                        });
                    }
                //HANTAR EMEL KEPADA SUB UNTUK DISYOR
            // }
            //IF KPN HANTAR KE SUB BAHAGIAN, ELSE HANTAR KE KEWANGAN

            $request->session()->flash('status', 'Maklumat permohonan berjaya dihantar.');
            return redirect('/pemohon/butiran/' . $id); 
    
        }
    }

    public function autoSave(Request $request) {

        // return response()->json(['message' => $request->input('objektif2')]);
        // $data = $request->input();
        
        // Retrieve $maklumat_id from the request
        $maklumat_id = $request->input('maklumat_id');
        
        // $formData = MaklumatPermohonan::where('idMaklumatPermohonan', $maklumat_id)->first();
        $formData = MaklumatPermohonan::firstOrNew(['idMaklumatPermohonan' => $maklumat_id]);

        // $formData = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $formData->idPemohonPeruntukan)->first();

        // Check if auto-save condition is met
        if ($request->input('autosave_enabled')) {
            // Validate incoming data
            $validatedData = $request->validate([
                'nama_program' => 'nullable|string',
                'ruj_fail' => 'nullable|string',
                // 'tujuan' => 'nullable|string',
                // 'latarBelakang' => 'nullable|string',
                // 'objektif1' => 'nullable|string',
                // 'objektif2' => 'nullable|string',
                // 'objektif3' => 'nullable|string',
                // 'objektif4' => 'nullable|string',
                // 'objektif5' => 'nullable|string',
                // 'syor' => 'nullable|string',
                // 'perancangan' => 'required',    
                // 'tkh_mula' => 'required',    
                // 'tkh_tamat' => 'required',    
                'kos_mohon' => 'nullable|numeric|max:999999999999',
                'dokumen' => 'file|mimes:pdf|max:5120', 
            ]);

            // Update FormData with new data
            MaklumatPermohonan::where('idMaklumatPermohonan', $maklumat_id)->update([
                'rujukan_fail' => $request->input('ruj_fail'),
                'namaProgram' => $request->input('nama_program'),
                // 'tujuanProgram' => $request->input('tujuan'),
                // 'latarBelakang' => $request->input('latarBelakang'),
                'tkhCadangMula' => Carbon\Carbon::parse($request->input('tkh_mula'))->format('Y-m-d'),
                'tkhCadangAkhir' => Carbon\Carbon::parse($request->input('tkh_tamat'))->format('Y-m-d'),
                // 'kosMohon' => $data['kos_mohon'],
                'perancangan' => $request->input('perancangan'),
                // 'syor' => $request->input('syor'),
                // 'pengesah' => $request->input('pengesah'),
                // 'doc_Sokongan' => $filePath1,
                // 'doc_Sokongan' => $filePath1,
                'updatedAt' => Carbon\Carbon::now()
            ]);

            // Objektif::where('idMaklumatPermohonan', $maklumat_id)->update([
            //     'obj1' => $request->input('objektif1'),
            //     'obj2' => $request->input('objektif2'),
            //     'obj3' => $request->input('objektif3'),
            //     'obj4' => $request->input('objektif4'),
            //     'obj5' => $request->input('objektif5')
            // ]);

            // $formData->fill($validatedData);
            // $formData->save();

            return response()->json(['message' => 'Data saved successfully']);
        } else {
            return response()->json(['message' => 'Auto-save is disabled']);
        }
    }

    public function kemaskini_vot(Request $request, $id){

         $data = $request->input();

        if ( isset($_POST['tambah_vot']) ) {  //IF BUTTON TAMBAH VOT
                $rules = [
                    //MODAL VOT VALIDATE
                    'perkara' => 'nullable|string',
                    'objekAm' => 'required',    
                    'objekSeb' => 'nullable',
                    'lain' => 'nullable|string',
                    'unit' => 'nullable|integer',
                    'kos' => 'required',
                ];
                $messages = [
                    'perkara.required' => 'Sila pastikan anda telah memasukkan Perkara Vot.',
                    'perkara.string' => 'Perkara mesti mengandungi huruf sahaja.',

                    'objekAm.required' => 'Sila pastikan anda telah memasukkan Objek Am.',

                    'lain.string' => 'Lain-lain mesti mengandungi huruf sahaja.',

                    'unit.integer' => 'Sila pastikan anda telah memasukkan Unit nombor sahaja.',

                    'kos.required' => 'Sila pastikan anda telah memasukkan Anggaran Kos.',

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/pemohon/kemaskini/vot/' . $id)->withInput();
                }

                //IF UNIT TAKDE NILAI
                if ( $data['unit'] ) { $unit = $data['unit']; }
                else { $unit = 0; }
                //IF UNIT TAKDE NILAI

                //IF LAIN TAKDE NILAI
                if ( $data['lain'] ) { $lain = $data['lain']; }
                else { $lain = null; }
                //IF LAIN TAKDE NILAI

                $input = new VotByAdmin();
                $input->idMaklumatPermohonan = $id;
                $input->perkara = $data['perkara'];
                $input->objekAm = $data['objekAm'];
                $input->objekSebagai = $data['objekSeb'];
                $input->keterangan = $lain;
                // $input->keterangan = $data['lain'];
                // $input->unit = $data['unit'];
                $input->unit = $unit;
                $input->kos = $data['kos'];
                $input->save(); 

                $request->session()->flash('status', 'Maklumat Vot ditambah.');
                return redirect('/pemohon/kemaskini/vot/' . $id);// idMaklumatPermohonan
        }
        else {
            // $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
            $objekAms = LkpOA::get();

            // $objekSebs = LkpObjek::get();
            $objekSebs = LkpOs::get();

            $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
            $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();

            // $lkpPerkaras = LkpPerkara::get();
            $lkpPerkaras = LkpPerkara::orderBy('perkara', 'asc')->get();

            $lkpOAs = LkpOA::get();
            $lkpOSs = LkpOS::get();

            //KIRE BALIK TOTAL KOS MOHON
            $totalKos = $vots->sum('kos');

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'kosMohon' => $totalKos,
                'updatedAt' => Carbon\Carbon::now(),
            ]);
            //KIRE BALIK TOTAL KOS MOHON

            return view('pemohon.kemaskiniVot', compact('vots', 'maklumats', 'objekAms', 'objekSebs', 'lkpPerkaras', 'lkpOAs', 'lkpOSs'));
        }
        
    }

    public function kemaskini_votForm (Request $request, $id) { //kemaskini 1 form vot

        $data = $request->input();
        $vot = VotByAdmin::where('idVotByAdmin', $id)->first();

        if ( isset($_POST['simpan_vot']) ) {  //IF BUTTON SIMPAN VOT

            $rules = [
                //MODAL VOT VALIDATE
                'perkaraK' => 'nullable',
                'objekAmK' => 'required',
                'objekSebK' => 'nullable',
                'lainK' => 'nullable|string',
                // 'unitK' => 'required',
                'kosK' => 'required',
            ];
            $messages = [
                'perkaraK.required' => 'Sila pastikan anda telah memasukkan Perkara Vot.',
                'perkaraK.string' => 'Perkara mesti mengandungi huruf sahaja.',

                'objekAmK.required' => 'Sila pastikan anda telah memasukkan Objek Am.',

                // 'unitK.required' => 'Sila pastikan anda telah memasukkan Unit.',

                'kosK.required' => 'Sila pastikan anda telah memasukkan kos.',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/pemohon/kemaskini/vot/form/' . $id)->withInput();
            }

            //IF UNIT TAKDE NILAI
             if ( $data['unitK'] ) { $unit = $data['unitK']; }
            else { $unit = 0; }
            //IF UNIT TAKDE NILAI

            //IF LAIN TAKDE NILAI
            if ( $data['lainK'] ) { $lain = $data['lainK']; }
            else { $lain = null; }
            //IF LAIN TAKDE NILAI
            
            VotByAdmin::where('idVotByAdmin', $id)->update([
                'perkara' => $data['perkaraK'],
                'objekAm' => $data['objekAmK'],
                'objekSebagai' => $data['objekSebK'],
                'keterangan' => $lain,
                'unit' => $unit,
                // 'unit' => $data['unitK'],
                'kos' => $data['kosK']
            ]);

            return redirect('pemohon/kemaskini/vot/'. $vot->idMaklumatPermohonan);
        }
        else {

            $lkpPerkaras = LkpPerkara::orderBy('perkara', 'asc')->get();

            // $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
            $objekAms = LkpOA::get();

            // $objekSebs = LkpObjek::get();
            $objekSebs = LkpOS::get();

            return view('pemohon.kemaskiniVotForm', compact('vot', 'objekAms', 'objekSebs', 'lkpPerkaras'));
        }
        

    }
 
    public function buang_vot(Request $request, $id) {

        $idMaklumat = VotByAdmin::where('idVotByAdmin', $id)->first();
        VotByAdmin::where('idVotByAdmin', $id)->delete();

        $request->session()->flash('status', 'Maklumat vot dibuang.');
        return redirect('/pemohon/kemaskini/vot/' . $idMaklumat->idMaklumatPermohonan); // idMaklumatPermohonan
    }

    public function batal($id)
    {
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        $objektifs = Objektif::where('idMaklumatPermohonan', $id)->first();

        $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->get();
        $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->get();
        $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->get();
        $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->get();
        $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->get();

        if ( $maklumats->id_status != 1 || $maklumats->id_status != 12 ) {
            // if( $maklumats->id_status == 8 || $maklumats->id_status == 9 || $maklumats->id_status == 10 || $maklumats->id_status == 11){
                $tindakan = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
    
                $tindakanLists = Tindakan::where('idMaklumatPermohonan', $id)
                                            ->where(function ($query) {
                                                $query->where('id_status', 21)
                                                    ->orWhere('id_status', 22); // Group id_status conditions
                                            })
                                            // ->latest('CreatedAt')
                                            ->get(); 
    
                $disyor = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->where(function ($query) {
                                        $query->where('id_status', 19)
                                            ->orWhere('id_status', 11); // Group id_status conditions
                                            // ->orWhere('id_status', 22); // Group id_status conditions
                                    })
                                    ->latest('CreatedAt')
                                    ->first(); // Get the latest tindakan Pengesah
    
                // $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
            }
            else {
                $tindakan = null;
                $tindakanLists = null; 
                $disyor = null; 
                // $votByAdmins = null;
            }

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $user = User::where('mykad', $pemohon->noKp)->first();

        //IF != DRAF && BUKAN KPN CARI PENGESAH
            if ( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' && $maklumats->id_status != 12) {
                // $pengesahAgensi = Pengesah::where('idMaklumatPermohonan', $id)->first();
                $pengesahAgensi = Pengesah::where('idPengesah', $maklumats->pengesah)->first();
            }
            else {
                $pengesahAgensi = [];
            }
            //  return $pengesahAgensi;
        //IF != DRAF && BUKAN KPN CARI PENGESAH

        return view('pemohon.batal',  compact('maklumats', 'tindakan', 'tindakanLists','pemohon', 'user', 'vots', 'objektifs', 'pengesahAgensi', 'tujuans', 'latars', 'dasars', 'justifikasis', 'ulasans'));
    }
    public function simpan_batal(Request $request, $id)
    {

        $data = $request->input();
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();

        if( $maklumats->id_status == 12 ) {
            $rules = [
                // 'catatanBatal' => 'required'
            ];
            $message = [
                // 'catatanBatal.required' => 'Sila berikan alasan pembatalan.'
            ];
        }
        else {
            $rules = [
                'catatanBatal' => 'required'
            ];
            $message = [
                'catatanBatal.required' => 'Sila berikan alasan pembatalan.'
            ];
        }
        

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        	// $request->session()->flash('failed', "Sila berikan alasan pembatalan.");
            $request->validate($rules, $message);
        	return redirect('/pemohon/batal/' . $id)->withInput();
        }

        //cari user id 
            // $person = PPersonel::where('nokp',  Auth::User()->mykad)->first();
            $user = User::where('mykad',  Auth::User()->mykad)->first();
            //


        //IF KALO NAK DELETE TERUS
            $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
            if( $maklumats->id_status == 12 ){
                MaklumatPermohonan::where('idMaklumatPermohonan', $id)->delete();
                Objektif::where('idMaklumatPermohonan', $id)->delete();
                VotByAdmin::where('idMaklumatPermohonan', $id)->delete();

                Tujuan::where('idMaklumatPermohonan', $id)->delete();
                LatarBelakang::where('idMaklumatPermohonan', $id)->delete();
                DasarSemasa::where('idMaklumatPermohonan', $id)->delete();
                JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->delete();
                UlasanBahagian::where('idMaklumatPermohonan', $id)->delete();

                $request->session()->flash('buang', 'Maklumat permohonan berjaya dibuang.');
                return redirect('/pemohon/menu/' . $user->id); 
            }
            else {
                MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                    'id_status' => 8,
                    'updatedAt' => Carbon\Carbon::now(),
                ]);
            }

        //tindakan simpan batal
        $tindakan = new Tindakan();
        $tindakan->idMaklumatPermohonan = $id;
        $tindakan->id_status = 8;
        $tindakan->Ulasan = $data['catatanBatal'];
        $tindakan->CreatedAt = Carbon\Carbon::now();
        $tindakan->UpdatedAt = Carbon\Carbon::now();
        $tindakan->UpdatedBy =  $user->id;
        $tindakan->save();

        // $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        // $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();

        // $request->session()->flash('batal', 'Permohonan berjaya dibatalkan.');
        // return redirect('/pemohon/menu/' . $user->id);
        $request->session()->flash('status', 'Maklumat permohonan berjaya dibatal.');
        return redirect('/pemohon/butiran/' . $id); 
    }

    public function dummy() //tak gune
    {
        return view('pemohon.dummy');
        //Blank page for testing
    }

    public function search(Request $request) //tak gune
    { //Login for User

        //Validate input
        $rules = [
            'nokp' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $request->session()->flash('fail', "Sila masukkan No. MyKad anda dengan betul");
            return redirect('/');
        }

        // Get the search value from the request
        $id = $request->input('nokp');

        // $personel = PPersonel::where('nokp', $id)->first();
        $personel = PPersonel:: where('nokp', $id)
                                ->where(function ($query) {
                                    $query->where('gred', 'LIKE', '%' . "41" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "44" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "48" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "52" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "54" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "JUSA A" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "JUSA B" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "JUSA C" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "TURUS I" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "TURUS II" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "TURUS III" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "UTAMA A" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "UTAMA B" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "UTAMA C" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "Menteri" . '%')
                                        ->orWhere('gred', 'LIKE', '%' . "MENTERI" . '%');
                                })
                                ->where('stat_pegawai', '!=', 0)
								->first();

        
        if ($personel) { //ada user
            if ($personel->agensi_id == '2') {

                $request->session()->flash('fail', "Sila hubungi pentadbir bilik mesyuarat kementerian.");
                return redirect('/');
            }
        } else {
            $request->session()->flash('fail', "No Kad Pengenalan tidak sah");
            return redirect('/');
        }
        
        $noKp = $personel->nokp;

        $pemohon = PPemohonPeruntukan::where('noKp', $personel->nokp)->first();
        if ($pemohon) {
            $maklumat = MaklumatPermohonan::where('idPemohonPeruntukan', $pemohon->idPemohonPeruntukan)->get();
        }

        $Opt_Peruntukan = LkpJenisPeruntukan::get();

        return redirect('/pemohon/menu/' . $noKp);
    }

    public function menu(Request $request, $id)
    {
        //Get Session
        // $name = Session::get('name'); //name tuk header bar user 
        $user = User::where('id', $id)->first();
        $nokp = $user->mykad;

        // TRY TAPIS SENARAI
            $search = [ 'status'=>'' ];
            $optStatus = LkpStatus::whereIn('id_status', ['1', '8', '9', '10', '12', '13', '14', '15', '16', '17', '18', '19'])->get();

            if(isset($_POST['tapis'])){

                $data = $request->input();
            
                if(strlen($data['status']) > 0) { 
                    $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan') 
                                                ->where('pemohon_peruntukan.noKp', $nokp)
                                                ->where('id_status', $data['status'])
                                                ->orderBy('createdAt','desc')
                                                // ->orderBy('updatedAt','desc')
                                                ->get();
                    // $maklumats = $maklumats->where('id_status', $data['status'])->where('pemohon_peruntukan.noKp', $nokp);  
                    $search['status'] = $data['status']; 
                    $request->session()->flash('tapis', "Untuk aktifkan tab senarai di menu.");

                }
                
            }
            else {
                // $personel = PPersonel::where('nokp', $nokp)->first();
                $pemohon = PPemohonPeruntukan::where('noKp', $nokp)->first();

                if ($pemohon) {

                        // $maklumats = MaklumatPermohonan::where('id_status', '!=', 12)
                        //                                 ->orderBy('createdAt','asc')
                        //                                 ->get();
                        $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan') 
                                                        ->where('pemohon_peruntukan.noKp', $nokp)
                                                        // ->where('id_status', '!=', 12)
                                                        ->orderBy('createdAt','desc')
                                                        ->orderBy('updatedAt','desc')
                                                        ->get();
                } else {
                    $maklumats = [];
                }
            }

        // TRY TAPIS SENARAI

        return view('pemohon.menu', compact('maklumats', 'user', 'search', 'optStatus'));
    }


    public function old_menu(Request $request, $id)
    {
        //Get Session
        // $name = Session::get('name'); //name tuk header bar user 
        $user = User::where('id', $id)->first();
        $nokp = $user->mykad;

        // $personel = PPersonel::where('nokp', $nokp)->first();
        $pemohon = PPemohonPeruntukan::where('noKp', $nokp)->first();

        if ($pemohon) {

                // $maklumats = MaklumatPermohonan::where('id_status', '!=', 12)
                //                                 ->orderBy('createdAt','asc')
                //                                 ->get();
                $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan') 
                                                ->where('pemohon_peruntukan.noKp', $nokp)
                                                // ->where('id_status', '!=', 12)
                                                ->orderBy('createdAt','desc')
                                                ->orderBy('updatedAt','desc')
                                                ->get();
        } else {
            $maklumats = [];
        }
        return view('pemohon.menu', compact('maklumats', 'user'));
    }

    //Bahagian PPT
    public function menu_PPT($nokp) {
        return view('pemohon.menu_ppt', compact('nokp'));
    }

    public function pilih_PPT(Request $request, $nokp) {

		$data = $request->input();

		if(isset($_POST['pilih_PPT'])) {
            //if submit n nak tambah PPT
            $rules = [
                'tahun' => 'required'
            ];
    
            $validator = Validator::make($request->all(), $rules);
            
    
            if ($validator->fails()) {
            	$request->session()->flash('failed', "Sila masukkan tahun PPT.");
            	return redirect('/pemohon/pilih_ppt/' . $nokp)->withInput();
            }
            else {
                $checkProg = PerancanganPerolehan::where('bahagian', $data['bahagian'])
                                                ->where('tahunPPT', $data['tahun'])
                                                ->where('id_status', '!=', 12)
                                                ->where('id_status', '!=', 10)
                                                ->where('id_status', '!=', 8)
                                                ->first();
                //check dah ade for that year n bahagian

                // if( $checkProg->isEmpty() ) {
                if( $checkProg == null ) {
                    return redirect('/pemohon/tambah_ppt/'.$nokp)->withInput();
                }
                else {
                    $request->session()->flash('failed', "PPT bagi tahun " . $data['tahun'] . " telah didaftar.");
            	    return redirect('/pemohon/pilih_ppt/' . $nokp)->withInput();
                }
            }
        }
        else {
            //If tekan from menu
            $OptjBelanje = LkpJenisBelanja::get();
            $OptBahagian = PLkpBahagian::get();
            $personel = PPersonel::where('nokp', $nokp)->first();

            return view('pemohon.pilih_ppt', compact('OptjBelanje', 'OptBahagian', 'personel'));
        }
        
    }

    public function tambah_PPT(Request $request, $nokp) {

        $OptjBelanje = LkpJenisBelanja::get();
        $OptBahagian = PLkpBahagian::get();
        $OptOneOff = LkpPerkaraOneOff::get();
        $personel = PPersonel::where('nokp', $nokp)->first();

        return view('pemohon.tambah_ppt', compact('OptjBelanje', 'OptBahagian', 'OptOneOff', 'personel'));
    }

    public function simpan_PPT (Request $request, $nokp) {
        
        $personel = PPersonel::where('nokp', $nokp)->first();
        $data = $request->input();

        //kod permohonan
        $jumlah = PerancanganPerolehan::whereYear('createdAt', '=', Carbon\Carbon::now()->format('Y'))->count('idPerancanganPerolehan');
        $jumPK = str_pad($jumlah+1, 5, '0', STR_PAD_LEFT);
		$kod_permohonan = 'P'.Carbon\Carbon::now()->format('Y').'/'.$jumPK;

        //Insert into Perancangan Perolehan 
        $PPerolehan = new PerancanganPerolehan();
        $PPerolehan->kod_permohonan = $kod_permohonan;
        $PPerolehan->pemohon = $personel->nokp;
        $PPerolehan->tahunPPT = $data['tahun'];
        $PPerolehan->bahagian = $data['bahagian'];
        $PPerolehan->id_status = 12;
        $PPerolehan->createdAt = Carbon\Carbon::now();
        $PPerolehan->updatedAt = Carbon\Carbon::now();
        $PPerolehan->save();
        
        $id_PPerolehan = $PPerolehan->idPerancanganPerolehan;
            

        if( $data['form_PPT1'] ){

            $expPPT = explode('|x|x|', $data['form_PPT1']);
				
				for($mj=0; $mj<count($expPPT) - 1; $mj++) {
					$decodeMJ = base64_decode($expPPT[$mj]);
					$expDecodeMJ = explode('x|x', $decodeMJ);

					$program = new ProgramDirancang();
                    $program->idPerancanganPerolehan = $id_PPerolehan;
					$program->idJenisBelanja = 1;
					$program->tujuanProgram = $expDecodeMJ[1];
					// $program->tkhMula = $expDecodeMJ[2];
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[2])->format('Y-m-d');
					// $program->tkhTamat = $expDecodeMJ[3];
					$program->tkhTamat = Carbon\Carbon::parse($expDecodeMJ[3])->format('Y-m-d');
					$program->kosProgram = $expDecodeMJ[4];
					$program->justifikasi = $expDecodeMJ[5];
					$program->createdAt = Carbon\Carbon::now();
					$program->updatedAt = Carbon\Carbon::now();
                    //Null
					$program->pembekal = null;
					$program->kosSetahun = null;
					$program->idJenisPerkaraOneOff = null;
					$program->idJenisABM = null;
					$program->quantityOneOff = null;
					$program->save();

        		}

        }
        if( $data['form_PPT2'] ){

            $expPPT = explode('|x|x|', $data['form_PPT2']);
				
				for($mj=0; $mj<count($expPPT) - 1; $mj++) {
					$decodeMJ = base64_decode($expPPT[$mj]);
					$expDecodeMJ = explode('x|x', $decodeMJ);

					$program = new ProgramDirancang();
                    $program->idPerancanganPerolehan = $id_PPerolehan;
					$program->idJenisBelanja = 2;
					$program->tujuanProgram = $expDecodeMJ[1];
					$program->pembekal = $expDecodeMJ[2];
					// $program->tkhMula = $expDecodeMJ[2];
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[3])->format('Y-m-d');
					// $program->tkhTamat = $expDecodeMJ[3];
					$program->tkhTamat = Carbon\Carbon::parse($expDecodeMJ[4])->format('Y-m-d');
					$program->kosProgram = $expDecodeMJ[5];
					$program->kosSetahun = $expDecodeMJ[6];
					$program->createdAt = Carbon\Carbon::now();
					$program->updatedAt = Carbon\Carbon::now();
                    //Null
					$program->idJenisPerkaraOneOff = null;
					$program->idJenisABM = null;
					$program->quantityOneOff = null;
					$program->justifikasi = null;
					$program->save();
        		}

        }
        if( $data['form_PPT3'] ){

            $expPPT = explode('|x|x|', $data['form_PPT3']);
				
				for($mj=0; $mj<count($expPPT) - 1; $mj++) {
					$decodeMJ = base64_decode($expPPT[$mj]);
					$expDecodeMJ = explode('x|x', $decodeMJ);

					$program = new ProgramDirancang();
                    $program->idPerancanganPerolehan = $id_PPerolehan;
					$program->idJenisBelanja = 3;
					$program->tujuanProgram = $expDecodeMJ[1];
					$program->pembekal = $expDecodeMJ[2];
					// $program->tkhMula = $expDecodeMJ[2];
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[3])->format('Y-m-d');
					// $program->tkhTamat = $expDecodeMJ[3];
					$program->tkhTamat = Carbon\Carbon::parse($expDecodeMJ[4])->format('Y-m-d');
					$program->kosProgram = $expDecodeMJ[5];
					$program->kosSetahun = $expDecodeMJ[6];
					$program->createdAt = Carbon\Carbon::now();
					$program->updatedAt = Carbon\Carbon::now();
                    //Null
					$program->idJenisPerkaraOneOff = null;
					$program->idJenisABM = null;
					$program->quantityOneOff = null;
					$program->justifikasi = null;
					$program->save();
        		}

        }
        if( $data['form_PPT4'] ){

            $expPPT = explode('|x|x|', $data['form_PPT4']);
				
				for($mj=0; $mj<count($expPPT) - 1; $mj++) {
					$decodeMJ = base64_decode($expPPT[$mj]);
					$expDecodeMJ = explode('x|x', $decodeMJ);

					$program = new ProgramDirancang();
                    $program->idPerancanganPerolehan = $id_PPerolehan;
					$program->idJenisBelanja = 4;
					$program->tujuanProgram = $expDecodeMJ[1];
					$program->pembekal = $expDecodeMJ[2];
					// $program->tkhMula = $expDecodeMJ[2];
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[3])->format('Y-m-d');
					// $program->tkhTamat = $expDecodeMJ[3];
					$program->tkhTamat = Carbon\Carbon::parse($expDecodeMJ[4])->format('Y-m-d');
					$program->kosProgram = $expDecodeMJ[5];
					$program->kosSetahun = $expDecodeMJ[6];
					$program->createdAt = Carbon\Carbon::now();
					$program->updatedAt = Carbon\Carbon::now();
                    //Null
					$program->idJenisPerkaraOneOff = null;
					$program->idJenisABM = null;
					$program->quantityOneOff = null;
					$program->justifikasi = null;
					$program->save();
        		}

        }
        if( $data['form_PPT5'] ){

            $expPPT = explode('|x|x|', $data['form_PPT5']);
				
				for($mj=0; $mj<count($expPPT) - 1; $mj++) {
					$decodeMJ = base64_decode($expPPT[$mj]);
					$expDecodeMJ = explode('x|x', $decodeMJ);

					$program = new ProgramDirancang();
                    $program->idPerancanganPerolehan = $id_PPerolehan;
					$program->idJenisBelanja = 5;
					$program->tujuanProgram = $expDecodeMJ[1];
					$program->idJenisPerkaraOneOff = $expDecodeMJ[2];
					$program->quantityOneOff = $expDecodeMJ[3];
					$program->kosProgram = $expDecodeMJ[4];
					$program->justifikasi = $expDecodeMJ[6];
					$program->createdAt = Carbon\Carbon::now();
					$program->updatedAt = Carbon\Carbon::now();
                    //Null
					$program->tkhMula = null;
					$program->tkhTamat = null;
					$program->idJenisABM = null;
					$program->pembekal = null;
					$program->kosSetahun = null;
					$program->save();
        		}

        }
        // else {
        //     return redirect('/pemohon/tambah_ppt/' . $nokp)->withInput();
        // }

        return redirect('pemohon/pengesahan_ppt/'. $id_PPerolehan . '/' . $nokp);
        
    }

    public function pengesahan_PPT (Request $request, $id, $nokp) {

        $perancangan = PerancanganPerolehan::where('idPerancanganPerolehan', $id)->first();
        $pemohon = PPersonel::where('nokp', $perancangan->pemohon)->first();
        $programs = ProgramDirancang::where('idPerancanganPerolehan', $id)->get();
        $personel = PPersonel::where('nokp', $nokp)->first();
        $OptOneOff = LkpPerkaraOneOff::get();
        
        if(isset($_POST['selesaiPengesahan'])) { //setelah selesai pengesahan tukar status dari Draft ke Baru
            
            if( $perancangan->id_status == 1 || $perancangan->id_status == 9) {
                // return redirect('pemohon/menu/'. $nokp);
                return redirect('pemohon/senarai_ppt/'. $nokp);
            }
            else {

                PerancanganPerolehan::where('idPerancanganPerolehan', $id)
                 ->update([
                    'id_status' => 1,
                    'updatedAt' => Carbon\Carbon::now(),
                 ]);

                // return redirect('pemohon/menu/'. $nokp);
                return redirect('pemohon/senarai_ppt/'. $nokp);


            }

        }
        else if (isset($_POST['batalPengesahan'])) { //Tekan jadi batal or buang terus?
            
            PerancanganPerolehan::where('idPerancanganPerolehan', $id)
             ->update([
                'id_status' => 8,
                'updatedAt' => Carbon\Carbon::now(),
             ]);

            // return redirect('pemohon/menu/'. $nokp);
            return redirect('pemohon/senarai_ppt/'. $nokp);


        }
        else if ( isset($_POST['selesaiKemaskini']) ) { //sudah selesai kemaskini senarai ppt terus ke menu
            // return 'kemaskini';
            return redirect('pemohon/menu/'. $nokp);
        }
        else if ( session('kemaskini')) { //sudah selesai kemaskini senarai ppt terus ke menu
            // return 'kemaskini';
            return view('pemohon.pengesahan_ppt', compact('programs', 'OptOneOff', 'personel'));
        }
        else {
            // return 'sini';
            $request->session()->flash('pengesahan', "Pengesahan Senarai");
            return view('pemohon.pengesahan_ppt', compact('programs', 'OptOneOff', 'personel', 'pemohon', 'perancangan'));

        }
    }

    public function pengesahan_tambahPPT(Request $request, $id, $nokp){

        $personel = PPersonel::where('nokp', $nokp)->first();
        $data = $request->input();         

        if( isset($_POST['tambahPPT1']) ){

            $program = new ProgramDirancang();
            $program->idPerancanganPerolehan = $id;
            $program->idJenisBelanja = 1;
            $program->tujuanProgram = $data['tujuanProgram1'];
            // $program->tkhMula = $expDecodeMJ[2];
            $program->tkhMula = Carbon\Carbon::parse($data['tkhMula1'])->format('Y-m-d');
            // $program->tkhTamat = $expDecodeMJ[3];
            $program->tkhTamat = Carbon\Carbon::parse($data['tkhTamat1'])->format('Y-m-d');
            $program->kosProgram = $data['kosProgram1'];
            $program->justifikasi = $data['justifikasi1'];
            $program->createdAt = Carbon\Carbon::now();
            $program->updatedAt = Carbon\Carbon::now();
            //Null
            $program->pembekal = null;
            $program->kosSetahun = null;
            $program->idJenisPerkaraOneOff = null;
            $program->idJenisABM = null;
            $program->quantityOneOff = null;
            $program->save();

            return redirect('pemohon/pengesahan_ppt/'. $id . '/' . $nokp);
        }
        else if( isset($_POST['tambahPPT2']) ){

            $program = new ProgramDirancang();
            $program->idPerancanganPerolehan = $id;
            $program->idJenisBelanja = 2;
            $program->tujuanProgram = $data['tujuanProgram2'];
            $program->pembekal = $data['pembekal2'];
            $program->tkhMula = Carbon\Carbon::parse($data['tkhMula2'])->format('Y-m-d');
            $program->tkhTamat = Carbon\Carbon::parse($data['tkhTamat2'])->format('Y-m-d');
            $program->kosProgram = $data['kosProgram2'];
            $program->kosSetahun = $data['kosSetahun2'];
            $program->createdAt = Carbon\Carbon::now();
            $program->updatedAt = Carbon\Carbon::now();
            //Null
            $program->idJenisPerkaraOneOff = null;
            $program->idJenisABM = null;
            $program->quantityOneOff = null;
            $program->justifikasi = null;
            $program->save();

            return redirect('pemohon/pengesahan_ppt/'. $id . '/' . $nokp);
        }
        else if( isset($_POST['tambahPPT3']) ){

            $program = new ProgramDirancang();
            $program->idPerancanganPerolehan = $id;
            $program->idJenisBelanja = 3;
            $program->tujuanProgram = $data['tujuanProgram3'];
            $program->pembekal = $data['pembekal3'];
            $program->tkhMula = Carbon\Carbon::parse($data['tkhMula3'])->format('Y-m-d');
            $program->tkhTamat = Carbon\Carbon::parse($data['tkhTamat3'])->format('Y-m-d');
            $program->kosProgram = $data['kosProgram3'];
            $program->kosSetahun = $data['kosSetahun3'];
            $program->createdAt = Carbon\Carbon::now();
            $program->updatedAt = Carbon\Carbon::now();
            //Null
            $program->idJenisPerkaraOneOff = null;
            $program->idJenisABM = null;
            $program->quantityOneOff = null;
            $program->justifikasi = null;
            $program->save();

            return redirect('pemohon/pengesahan_ppt/'. $id . '/' . $nokp);
        }
        else if( isset($_POST['tambahPPT4']) ){

            $program = new ProgramDirancang();
            $program->idPerancanganPerolehan = $id;
            $program->idJenisBelanja = 4;
            $program->tujuanProgram = $data['tujuanProgram4'];
            $program->pembekal = $data['pembekal4'];
            $program->tkhMula = Carbon\Carbon::parse($data['tkhMula4'])->format('Y-m-d');
            $program->tkhTamat = Carbon\Carbon::parse($data['tkhTamat4'])->format('Y-m-d');
            $program->kosProgram = $data['kosProgram4'];
            $program->kosSetahun = $data['kosSetahun4'];
            $program->createdAt = Carbon\Carbon::now();
            $program->updatedAt = Carbon\Carbon::now();
            //Null
            $program->idJenisPerkaraOneOff = null;
            $program->idJenisABM = null;
            $program->quantityOneOff = null;
            $program->justifikasi = null;
            $program->save();

            return redirect('pemohon/pengesahan_ppt/'. $id . '/' . $nokp);
        }
        else if( isset($_POST['tambahPPT5']) ){

            $program = new ProgramDirancang();
            $program->idPerancanganPerolehan = $id;
            $program->idJenisBelanja = 5;
            $program->tujuanProgram = $data['tujuanProgram5'];
            $program->idJenisPerkaraOneOff = $data['jenis_OneOff5'];
            $program->quantityOneOff = $data['kuantiti5'];
            $program->kosProgram = $data['kosProgram5'];
            $program->justifikasi = $data['justifikasi5'];
            $program->createdAt = Carbon\Carbon::now();
            $program->updatedAt = Carbon\Carbon::now();
            //Null
            $program->tkhMula = null;
            $program->tkhTamat = null;
            $program->idJenisABM = null;
            $program->pembekal = null;
            $program->kosSetahun = null;
            $program->save();

            return redirect('pemohon/pengesahan_ppt/'. $id . '/' . $nokp);
        }
    }

    public function simpan_kemaskiniPPT (Request $request, $id1, $id2, $nokp) {

        $data = $request->input();
         $programs = ProgramDirancang::where('idProgramDirancang', $id2)
                                        ->first();

        if(isset($_POST['editData1']) ) {
            $programs->update([
                'tujuanProgram' => $data['tujuanProgram1'],
                'tkhMula' => Carbon\Carbon::parse($data['tkhMula1'])->format('Y-m-d'),
                'tkhTamat' => Carbon\Carbon::parse($data['tkhTamat1'])->format('Y-m-d'),
                'kosProgram' => $data['kosProgram1'],
                'justifikasi' => $data['justifikasi1'],
                'updatedAt' => Carbon\Carbon::now(),
            ]);

            return redirect('pemohon/pengesahan_ppt/' . $programs->idPerancanganPerolehan . '/' . $nokp);
        }
        else if(isset($_POST['editData2']) ) {
            $programs->update([
                'tujuanProgram' => $data['tujuanProgram2'],
                'pembekal' => $data['pembekal2'],
                'tkhMula' => Carbon\Carbon::parse($data['tkhMula2'])->format('Y-m-d'),
                'tkhTamat' => Carbon\Carbon::parse($data['tkhTamat2'])->format('Y-m-d'),
                'kosProgram' => $data['kosProgram2'],
                'kosSetahun' => $data['kosSetahun2'],
                'updatedAt' => Carbon\Carbon::now(),
            ]);

            return redirect('pemohon/pengesahan_ppt/' . $programs->idPerancanganPerolehan . '/' . $nokp);
        }
        else if(isset($_POST['editData3']) ) {
            $programs->update([
                'tujuanProgram' => $data['tujuanProgram3'],
                'pembekal' => $data['pembekal3'],
                'tkhMula' => Carbon\Carbon::parse($data['tkhMula3'])->format('Y-m-d'),
                'tkhTamat' => Carbon\Carbon::parse($data['tkhTamat3'])->format('Y-m-d'),
                'kosProgram' => $data['kosProgram3'],
                'kosSetahun' => $data['kosSetahun3'],
                'updatedAt' => Carbon\Carbon::now(),
            ]);

            return redirect('pemohon/pengesahan_ppt/' . $programs->idPerancanganPerolehan . '/' . $nokp);
        }
        else if(isset($_POST['editData4']) ) {
            $programs->update([
                'tujuanProgram' => $data['tujuanProgram4'],
                'pembekal' => $data['pembekal4'],
                'tkhMula' => Carbon\Carbon::parse($data['tkhMula4'])->format('Y-m-d'),
                'tkhTamat' => Carbon\Carbon::parse($data['tkhTamat4'])->format('Y-m-d'),
                'kosProgram' => $data['kosProgram4'],
                'kosSetahun' => $data['kosSetahun4'],
                'updatedAt' => Carbon\Carbon::now(),
            ]);

            return redirect('pemohon/pengesahan_ppt/' . $programs->idPerancanganPerolehan . '/' . $nokp);
        }
        else if(isset($_POST['editData5']) ) {
            $programs->update([
                'tujuanProgram' => $data['tujuanProgram5'],
                'idJenisPerkaraOneOff' => $data['jenis_OneOff5'],
                'quantityOneOff' => $data['kuantiti5'],
                'kosProgram' => $data['kosProgram5'],
                'justifikasi' => $data['justifikasi5'],
                'updatedAt' => Carbon\Carbon::now(),
            ]);

            return redirect('pemohon/pengesahan_ppt/' . $programs->idPerancanganPerolehan . '/' . $nokp);
        }
    }

    public function buangPPT($id, $nokp) { //id = id ProgramDirancang
        $program = ProgramDirancang::where('idProgramDirancang', $id)->first();

        ProgramDirancang::where('idProgramDirancang', $id)->delete();

        return redirect('pemohon/pengesahan_ppt/'. $program->idPerancanganPerolehan . '/' . $nokp);

    }

    //Senarai PPT
    public function senarai_PPT(Request $request, $nokp) {

        $personel = PPersonel::where('nokp', $nokp)->first();

        $perancangans = PerancanganPerolehan::where('bahagian', $personel->bahagian_id)
                                            ->where('id_status', '!=', 12)
                                            ->get();
        
        return view('pemohon.senarai_ppt', compact('personel', 'perancangans'));
    }

    //DOWNLOAD JADI PDF PLUGIN
    public function generatePDF($id) {

        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();

        $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->get();
        $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->get();
        $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->get();
        $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->get();
        $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->get();

        $objektif = Objektif::where('idMaklumatPermohonan', $id)->first();
        // $tindakans = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
        $tindakans = Tindakan::where('idMaklumatPermohonan', $id)
                            ->latest('UpdatedAt')->get(); //latest
                                    // ->orderBy('UpdatedAt', 'asc')                            
                                    // ->get();
                                    // ->where('id_status', 13)                            
                                    

        $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)
                                // ->where('id_status', 9)
                                ->get();

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();

        if( $pemohon->agensi == 'Kementerian Perpaduan Negara (KPN)' ){
            
            $bahagian = PLkpBahagian::where('bahagian', $pemohon->namaBahagian)->first();

            if( $bahagian ) {
    
                $positions = [
                    'Setiausaha Bahagian',
                    'Ketua Unit Audit Dalam',
                    'Ketua Unit Integriti',
                    'Ketua Unit Komunikasi Korporat',
                    'Ketua Akauntan'
                ];
                
                $pengesah = null;
                
                foreach ($positions as $position) {
                    $pengesah = PPersonel::where('bahagian_id', $bahagian->id)
                                                ->where('stat_pegawai', 1)
                                                ->where('jawatan', $position)
                                                ->first();
                
                    if ($pengesah) {
                        break;
                    }
                }
                
                if( $pengesah == null ) { //CARI DALAM USERPERUNTUKAN
                    $cariUser = User::where('bahagian', $bahagian->bahagian)->where('id_access', 'Pengesah')->first();
                    $pengesah = PPersonel::where('nokp', $cariUser->mykad)->first();
                }
            }
            else {
                //  $setiausahaB = [];        
                 $pengesah = [];        
            }
            
        }
        else {
            $pengesah = User::where('agensi', $pemohon->agensi)->where('id_access', 'Pengesah')->first();
        }

        
        $imagePath = '/images/JataNegara.png';

        $data = [
            'maklumats' => $maklumats,
            'objektif' => $objektif,
            'tindakans' => $tindakans,
            'votByAdmins' => $votByAdmins,
            
            'tujuans' => $tujuans,
            'latars' => $latars,
            'dasars' => $dasars,
            'justifikasis' => $justifikasis,
            'ulasans' => $ulasans,

            'pemohon' => $pemohon,
            // 'setiausahaB' => $setiausahaB,
            'pengesah' => $pengesah,
            // 'personel' => $personel,
            'image' => $imagePath,
            // 'ruj_fail' => $ruj_fail,
        ];

        $dompdf = new Dompdf();

        // Set paper size and orientation
        // $dompdf->setPaper('A4', 'portrait');

        // Render Blade template into HTML
        $html = '<style>@page { margin-top: 14.1mm; }</style>'; // Set margin-top using @page rule

        $html .= View::make('pemohon.cetak', $data)->render(); // Add your content

        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Render PDF
        $dompdf->render();

        // Output the generated PDF
        return response($dompdf->output())
        ->header('Content-Type', 'application/pdf');

        // JavaScript to switch to the next tab
        echo '<script>window.location.href = "your_next_tab_url";</script>';

    }

}
