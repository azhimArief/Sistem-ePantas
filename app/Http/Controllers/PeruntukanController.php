<?php

namespace App\Http\Controllers;

use App\Agensi;
use App\DasarSemasa;
use App\JustifikasiPermohonan;
use App\LatarBelakang;
use App\LkpJenisBelanja;
use App\LkpJenisPeruntukan;
use App\LkpOA;
use App\LkpObjek;
use App\LkpOS;
use App\LkpPerkara;
use App\LkpPerkaraOneOff;
use App\LkpStatus;
use App\PPersonel;
use App\LkpVot;
use App\MaklumatPermohonan;
use App\Objektif;
use App\Pengesah;
use App\PerancanganPerolehan;
use App\PLkpBahagian;
use App\PPemohonPeruntukan;
use App\ProgramDirancang;
use App\Tindakan;
use App\Tujuan;
use App\UlasanBahagian;
use App\User;
use App\VotByAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Auth;
use Carbon;
// use Carbon\Carbon;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;

use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PeruntukanController extends Controller
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

    public function senarai (Request $request){
        $search = [ 'status'=>'', 'tkhMula'=>'', 'tkhTamat'=>'', 'tkhMulaProg'=>'', 'tkhTamatProg'=>'', 'kod'=> '', 'agensi'=> ''];

        $optStatus = LkpStatus::whereIn('id_status', ['1', '8', '9', '10', '13', '14', '15', '16', '17', '18', '19'])->get();

        $optAgensis = Agensi::whereIn('id', ['1','2','5','6','7'])->get();

        //Maklumats based on ID Access
        // if ( Auth::user()->id_access == 'Pentadbir Sistem' ||  Auth::user()->id_access == 'Pentadbir Teknikal Sistem') {
        if ( Auth::user()->id_access == 'Pentadbir Sistem' ) {
            // $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
            //                                 // ->orderBy('updatedAt','desc')
            //                                 ->where('id_status', '!=', 12) //Draft NO Show
            //                                 ->where('id_status', '!=', 1) //BARU NO Show
            //                                 ->where('id_status', '!=', 11) //SEMAK SEMULA NO Show
            //                                 // ->where('id_status', '!=', 10) //Tidak Diluluskan NO Show    
            //                                 // ->where('id_status', '!=', 8) //Batal NO Show
            //                                 ->orderBy('updatedAt', 'asc')
            //                                 ->get();

            $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
                                            ->whereNotIn('maklumat_permohonan.id_status', [12, 11, 20]) // Exclude id_status 12 and 11 globally
                                            ->where(function ($query) {
                                                $query->where('maklumat_permohonan.id_status', '!=', 1) // Exclude id_status 1 by default
                                                    ->orWhere(function ($subQuery) {
                                                        // $subQuery->where('maklumat_permohonan.id_status', 1)
                                                                // ->where('pemohon_peruntukan.agensi', '!=', 'Kementerian Perpaduan Negara (KPN)'); // Include id_status 1 only if agensi != KPN
                                                    });
                                            })
                                            ->orderBy('maklumat_permohonan.updatedAt', 'desc') // Order by updatedAt in ascending order
                                            ->get();


        }
        else if ( Auth::user()->id_access == 'Pentadbir-SUB Kewangan dan Pembangunan') {
            $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
                                            ->orderBy('updatedAt', 'desc')
                                            ->where('id_status', '!=', 12) // Draft NO Show
                                            ->where('id_status', '!=', 11) // SEMAK SEMULA PENGESAH NO Show
                                            ->where('id_status', '!=', 20) // DIKEMASKINI PENGESAH NO Show
                                            ->where('id_status', '!=', 8)  // BATAL NO Show
                                            ->where('id_status', '!=', 1)  // BATAL NO Show
                                            ->orWhere('id_status', 13)
                                            ->orWhere('id_status', 14)
                                            ->orWhere('id_status', 15)
                                            ->orWhere('id_status', 16)
                                            ->orWhere('id_status', 17)
                                            ->orWhere('id_status', 18)
                                            ->orWhere('id_status', 9)
                                            ->orWhere(function ($query) {
                                                $query->where('id_status', 1)
                                                      ->where('id_bahagian', 34);
                                            })
                                            ->get();
                                            
        }
        else if ( Auth::user()->id_access == 'Pentadbir-SUB Kanan Pengurusan') {
            $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
                                            ->orderBy('updatedAt','desc')
                                            ->where('id_status', '!=', 1)
                                            ->where('id_status', '!=', 8) //BATAL NO Show
                                            ->where('id_status', '!=', 12) //Draft NO Show
                                            ->where('id_status', '!=', 11) //SEMAK SEMULA NO Show
                                            ->where('id_status', '!=', 19) //DISYORKAN NO Show
                                            ->where('id_status', '!=', 20) //DIKEMASKINI PENGESAH NO Show
                                            ->orWhere('id_status', 15)
                                            // ->orWhere('id_status', 16)
                                            ->orWhere('id_status', 17)
                                            // ->orWhere('id_status', 18)
                                            ->orWhere('id_status', 9)
                                            // ->orWhere('id_status', 10)
                                            ->get();
        }
        else if ( Auth::user()->id_access == 'Pentadbir-KSU') {
            $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
                                            ->orderBy('updatedAt','desc')
                                            ->where('id_status', '!=', 1)
                                            ->where('id_status', '!=', 8) //BATAL NO Show
                                            ->where('id_status', '!=', 12) //Draft NO Show
                                            ->where('id_status', '!=', 11) //SEMAK SEMULA NO Show
                                            ->where('id_status', '!=', 19) //DISYORKAN NO Show
                                            ->where('id_status', '!=', 20) //DIKEMASKINI PENGESAH NO Show
                                            ->orWhere('id_status', 17)
                                            // ->orWhere('id_status', 18)
                                            ->orWhere('id_status', 9)
                                            // ->orWhere('id_status', 10)
                                            ->get();
        }
        else if( Auth::user()->id_access == 'Pengesah' ) {
            if( Auth::user()->agensi != 'Kementerian Perpaduan Negara (KPN)' ) { 
                $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
                                            ->where('pemohon_peruntukan.agensi', Auth::user()->agensi)
                                            ->orderBy('updatedAt','desc')
                                            ->where('id_status', '!=', 12) //Draft NO Show
                                            // ->orWhere('id_status', 10)
                                            ->get();
            }
            else {
                $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
                                            ->where('pemohon_peruntukan.namaBahagian', Auth::user()->bahagian)
                                            ->orderBy('updatedAt','desc')
                                            ->where('id_status', '!=', 12) //Draft NO Show
                                            // ->orWhere('id_status', 10)
                                            ->get();
            }
        }
        else if ( Auth::user()->id_access == 'Pentadbir Teknikal Sistem' ) {

            $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'maklumat_permohonan.idPemohonPeruntukan', '=', 'pemohon_peruntukan.idPemohonPeruntukan')
                                            ->whereNotIn('maklumat_permohonan.id_status', [12, 11])
                                            ->orderBy('maklumat_permohonan.updatedAt', 'desc') // Order by updatedAt in ascending order
                                            ->get();


        }
       

		if(isset($_POST['tapis'])){

			$data = $request->input();
            
            if(strlen($data['kod']) > 0) { $maklumats = $maklumats->where('kod_permohonan', $data['kod']);  $search['kod'] = $data['kod']; }
            if(strlen($data['agensi']) > 0) {
                $idAgensi = Agensi::where('id', $data['agensi'])->value('id');
                $maklumats = $maklumats->where('id_agensi', $idAgensi);  $search['agensi'] = $data['agensi']; 
            }
            if(strlen($data['status']) > 0) { $maklumats = $maklumats->where('id_status', $data['status']);  $search['status'] = $data['status']; }
            if(strlen($data['tkhMula']) > 0) {  $maklumats = $maklumats->where('createdAt', '>=',$data['tkhMula']); $search['tkhMula']=$data['tkhMula'] ;  }
            if(strlen($data['tkhTamat']) > 0) {  $maklumats = $maklumats->where('createdAt', '<=',$data['tkhTamat']); $search['tkhTamat']=$data['tkhTamat'] ;  }
            if(strlen($data['tkhMulaProg']) > 0) {  $maklumats = $maklumats->where('tkhCadangMula', '>=',$data['tkhMulaProg']); $search['tkhMulaProg']=$data['tkhMulaProg'] ;  }
            if(strlen($data['tkhTamatProg']) > 0) {  $maklumats = $maklumats->where('tkhCadangAkhir', '<=',$data['tkhTamatProg']); $search['tkhTamatProg']=$data['tkhTamatProg'] ;  }
        }
        return view('admin.senarai', compact('maklumats', 'search', 'optStatus', 'optAgensis'));
    }
    public function pengesahan ($id){

        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $personel = PPersonel::where('id', $maklumats->tindakan_oleh)->first();
        // $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)->get();

        return view('admin.pengesahan', compact('maklumats', 'personel', 'votByAdmins'));

    }
    public function tambah (){

        // $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
        $objekAms = LkpOA::get();

        // $objekSebs = LkpObjek::get();
        $objekSebs = LkpOs::get();

        $lkpPerkaras = LkpPerkara::get();
        $lkpOAs = LkpOA::get();
        $lkpOSs = LkpOS::get();

        $Opt_Peruntukan = LkpJenisPeruntukan::get();
        $Opt_Vots = LkpVot::get();
        // $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $id)->first();
        $users = User::where('status', 'Aktif')->get();
        $personels = PPersonel::get();

        $pengesahs = PPersonel::where('stat_pegawai', 1)
                                ->where(function ($query) {
                                    $query->whereRaw('CAST(REGEXP_REPLACE(gred, "[^0-9]", "") AS UNSIGNED) >= 48');
                                })
                                ->orderBy('name')
                                ->get();

        return view('admin.tambah', compact('Opt_Peruntukan', 'personels', 'Opt_Vots', 'users', 'objekAms', 'objekSebs', 'pengesahs', 'lkpPerkaras', 'lkpOAs', 'lkpOSs'));
    }

    public function simpan_tambah(Request $request)
    {
        $data = $request->input();

        //Cari User Pendaftar
        // $personel = PPersonel::where('id', $data['cariNama'])->first();
        $user = User::where('id', $data['cariNama'])->first();

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
                    'kos_mohon' => 'nullable|numeric|max:999999999999',
                    'dokumen' => 'file|mimes:pdf|max:1024', 
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
                    'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 1MB.',
                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/peruntukan/tambah/')->withInput();
                }
                else {
                        //Check if semua VOT dimasukkan lengkap
                        if ( $data['form_VOT'] != null ) {
                            $expVot = explode('|x|x|', $data['form_VOT']);

                            for($mj=0; $mj<count($expVot) - 1; $mj++) {
                                $decodeMJ = base64_decode($expVot[$mj]);
                                $expDecodeMJ = explode('x|x', $decodeMJ);

                                // if ( $expDecodeMJ[1] == null) { //Perkaraa
                                //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                                //     return redirect('/peruntukan/tambah/')->withInput();
                                // }
                                if ( $expDecodeMJ[3] == null) { //Objek Am
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Am tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
                                } 
                                else if ( $expDecodeMJ[5] == null) {  //Objek Sebagai
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Sebagai tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
                                }
                                else if ( $expDecodeMJ[9] == null) { //Kos
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Anggaran Kos tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
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
                    if( $data['agensi'] != 'Kementerian Perpaduan Negara (KPN)' ){ 
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
                    return redirect('/peruntukan/kemaskini/' . $input->idMaklumatPermohonan);// idMaklumatPermohonan
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
                'kos_mohon' => 'nullable|numeric|max:999999999999',
                'dokumen' => 'file|mimes:pdf|max:1024', 
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
                'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 1MB.',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/peruntukan/tambah/')->withInput();
            }
            else {
                    //Check if semua VOT dimasukkan lengkap
                        if ( $data['form_VOT'] != null ) {
                            $expVot = explode('|x|x|', $data['form_VOT']);

                            for($mj=0; $mj<count($expVot) - 1; $mj++) {
                                $decodeMJ = base64_decode($expVot[$mj]);
                                $expDecodeMJ = explode('x|x', $decodeMJ);
    
                                // if ( $expDecodeMJ[1] == null) { //Perkaraa
                                //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                                //     return redirect('/peruntukan/tambah/')->withInput();
                                // }
                                if ( $expDecodeMJ[3] == null) { //Objek Am
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Am tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
                                } 
                                else if ( $expDecodeMJ[5] == null) {  //Objek Sebagai
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Sebagai tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
                                }
                                else if ( $expDecodeMJ[9] == null) { //Kos
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Anggaran Kos tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
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
                return redirect('/peruntukan/kemaskini/' . $input->idMaklumatPermohonan);// idMaklumatPermohonan
            }
        }
        else if( isset($_POST['simpan_pemohon']) ) {  //IF BUTTON SIMPAN
            $rules = [
                'nama' => 'required|string',
                'jawatan' => 'required|string',
                'gred' => 'required|string',
                'agensi' => 'required|string',
                'bahagian' => 'required|string',
                'emel' => 'required|string',
                'tel_pejabat' => 'nullable|string',
                'telefon' => 'nullable|string',
            ];
            $messages = [
                'nama.required' => 'Sila pastikan nama pegawai telah diisi.',
                'nama.string' => 'Nama pegawai mesti mengandungi huruf sahaja.',

                'jawatan.required' => 'Sila pastikan jawatan pegawai telah diisi.',
                'jawatan.string' => 'Jawatan pegawai mesti mengandungi huruf sahaja.',

                'gred.required' => 'Sila pastikan gred pegawai telah diisi.',
                'gred.string' => 'Gred pegawai mesti mengandungi huruf sahaja.',

                'agensi.required' => 'Sila pastikan Agensi pegawai telah diisi.',
                'agensi.string' => 'Agensi pegawai mesti mengandungi huruf sahaja.',

                'bahagian.required' => 'Sila pastikan bahagian pegawai telah diisi.',
                'bahagian.string' => 'Bahagian pegawai mesti mengandungi huruf sahaja.',

                'emel.required' => 'Sila pastikan emel pegawai telah diisi.',
                'emel.string' => 'Emel pegawai mesti mengandungi huruf sahaja.',

                'tel_pejabat.required' => 'Sila pastikan no.telefon pejabat pegawai telah diisi.',
                'tel_pejabat.string' => 'No.telefon pejabat pegawai mesti mengandungi huruf sahaja.',

                'telefon.required' => 'Sila pastikan no.telefon bimbit pegawai telah diisi.',
                'telefon.string' => 'No.telefon bimbit pegawai mesti mengandungi huruf sahaja.',
                
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/peruntukan/tambah/')->withInput();
            }
            else {

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

                $request->session()->flash('status', 'Maklumat pemohon berjaya disimpan.');
                return redirect('/peruntukan/kemaskini/' . $input->idMaklumatPermohonan);// idMaklumatPermohonan
            }
        }
        else { //IF BUTTON HANTAR
                if( $data['agensi'] != 'Kementerian Perpaduan Negara (KPN)' ){ //if Agensi perlu detail pengesah
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
                    return redirect('/peruntukan/tambah/')->withInput();
                }
                else {

                    //Check if semua VOT dimasukkan lengkap
                        if ( $data['form_VOT'] != null ) {
                            $expVot = explode('|x|x|', $data['form_VOT']);

                            for($mj=0; $mj<count($expVot) - 1; $mj++) {
                                $decodeMJ = base64_decode($expVot[$mj]);
                                $expDecodeMJ = explode('x|x', $decodeMJ);

                                // if ( $expDecodeMJ[1] == null) { //Perkaraa
                                //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                                //     return redirect('/peruntukan/tambah/')->withInput();
                                // }
                                if ( $expDecodeMJ[3] == null) { //Objek Am
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Am tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
                                } 
                                else if ( $expDecodeMJ[5] == null) {  //Objek Sebagai
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Objek Sebagai tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
                                }
                                else if ( $expDecodeMJ[9] == null) { //Kos
                                    $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul. Anggaran Kos tidak dimasukkan.');
                                    return redirect('/peruntukan/tambah/')->withInput();
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
                    // $input->kosMohon = $data['kos_program'];
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

                        //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
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
                                            $header->cc($pentadbirs->email,$pentadbirs->nama);	//HANTAR KE KEWANGAN SELEPAS DISYORKAN KETUA BAHAGIAN
                                        }
    
                                        $header->subject('Notifikasi Permohonan Baru ePantas.');
                                    });
                                }
                        //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
                    }
                    else { //IF KPN HANTAR EMEL KE SUB UNTUK DISYORKAN
                        //HANTAR EMEL KEPADA SUB UNTUK DISYOR
                            $pentadbir = User::where('bahagian', $user->bahagian)
                                        ->where('id_access', 'Pengesah')
                                        ->where('status', 'Aktif')
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
    
                                    $header->subject('Notifikasi Permohonan Baru ePantas.');
                                });
                            }
                        //HANTAR EMEL KEPADA SUB UNTUK DISYOR
                    }
                    //IF KPN HANTAR KE SUB BAHAGIAN, ELSE HANTAR KE KEWANGAN

                    $request->session()->flash('status', 'Maklumat permohonan berjaya dihantar.');
                    return redirect('/peruntukan/butiran/' . $input->idMaklumatPermohonan);// nokp
                }
        }
    }

    public function kemaskini ($id){

        // $objekAms = LkpVot::get();
        $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
        $objekSebs = LkpObjek::get();
        $Opt_Peruntukan = LkpJenisPeruntukan ::get();

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
        // $pengesah = Pengesah::where('idMaklumatPermohonan', $id)->first();
        $pengesahs = Pengesah::where('agensiPengesah', $user->agensi)
                            ->where('statusPengesah', 'Aktif')
                            ->get();

        // $personel = PPersonel::where('name', $pemohon->namaPemohon)->first();

        return view('admin.kemaskini', compact('maklumats', 'pemohon', 'user', 'Opt_Peruntukan', 'objektifs', 'vots', 'objekAms', 'objekSebs', 'pengesahs', 'tujuans', 'latars', 'dasars', 'justifikasis', 'ulasans'));
    }
    public function simpan_kemaskini (Request $request, $id)
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
                    
                    'syor.string' => 'Syor mesti mengandungi huruf sahaja.',
                    
                    'kos_mohon.max' => 'Jumlah yang dimohon tidak boleh melebihi 12 digit.',

                    'dokumen.file' => 'Sila pastikan dokumen tambahan berjenis fail.',
                    'dokumen.mimes' => 'Sila pastikan dokumen tambahan berjenis PDF.',
                    'dokumen.max' => 'Sila pastikan saiz dokumen tambahan tidak melebihi 5MB.',
                ];
                
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/peruntukan/kemaskini/' . $id)->withInput();
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
                if( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    
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
                return redirect('/peruntukan/kemaskini/' . $id);// idMaklumatPermohonan
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
                    return redirect('/peruntukan/kemaskini/' . $id)->withInput();
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
                    // if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
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
                // if( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' ){
                    
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
                return redirect('/peruntukan/kemaskini/' . $id);// idMaklumatPermohonan
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

            $request->session()->flash('status', 'Fail berjaya dibuang.');
            return redirect('/peruntukan/kemaskini/' . $id);// idMaklumatPermohonan
        }
        else { //IF BUTTON HANTAR
                if( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //if Agensi perlu detail pengesah
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
            //     return redirect('/peruntukan/kemaskini/' . $id)->withInput();
            // }
            
            //Check if semua VOT dimasukkan lengkap
                if ( $data['form_VOT'] != null ) {
                    $expVot = explode('|x|x|', $data['form_VOT']);

                    for($mj=0; $mj<count($expVot) - 1; $mj++) {
                        $decodeMJ = base64_decode($expVot[$mj]);
                        $expDecodeMJ = explode('x|x', $decodeMJ);

                        if ( $expDecodeMJ[1] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/peruntukan/kemaskini/' . $id)->withInput();
                        }
                        else if ( $expDecodeMJ[2] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/peruntukan/kemaskini/' . $id)->withInput();
                        }
                        // else if ( $expDecodeMJ[7] == null) { UNIT
                        //     $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                        //     return redirect('/peruntukan/kemaskini/' . $id)->withInput();
                        // }
                        else if ( $expDecodeMJ[9] == null) {
                            $request->session()->flash('failed', 'Maklumat Vot tidak dimasukkan dengan betul.');
                            return redirect('/peruntukan/kemaskini/' . $id)->withInput();
                        }
                    }
                }
            //Check if semua VOT dimasukkan lengkap

            // CHECK IF BAHAGIAN/AGENSI PEMOHON TAKDE PENGESAH
                if( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ) {
                    $cariPengesahAgensi = User::where('agensi', $user->agensi)->where('id_access', 'Pengesah')->first();
                    if( !$cariPengesahAgensi ){
                        $request->session()->flash('failed', 'Akaun Pengesah Agensi/Jabatan belum dicipta. Sila maklumkan kepada Pentadbir Sistem untuk mencipta akaun pengesah agensi/jabatan sebelum menghantar permohonan.');
                    }
                    // return 'ada pengesah';
                }
                else{
                    $cariPengesahKPN = User::where('bahagian', $user->bahagian)->where('id_access', 'Pengesah')->first();
                    if( !$cariPengesahKPN ){
                        $request->session()->flash('failed', 'Akaun Pengesah Bahagian belum dicipta. Sila maklumkan kepada Pentadbir Sistem untuk mencipta akaun pengesah bahagian sebelum menghantar permohonan.');
                        return redirect('/peruntukan/kemaskini/' . $id)->withInput();
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
            if( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)'){
                // $kod = Agensi::where('agensi', $user->agensi)->first();
                $kod = Agensi::where('agensi', $pemohon->agensi)->value('akronim') ?? 'KPN';
            }
            else {
                $bahagian = PLkpBahagian::where('bahagian', $pemohon->namaBahagian)->first();
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
                // 'pengesah' => $data['pengesah'],
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
            // if( $user->agensi != 'Kementerian Perpaduan Negara' || $user->agensi != 'Kementerian Perpaduan Negara (KPN)' ){ //HANTAR KE KEWANGAN IF AGENSI

            //     //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
            //             $pentadbir = User::where('id_access', 'Pentadbir Sistem')
            //                                 ->where('status', 'Aktif')
            //                                 ->get(); //PENTADBIR KEWANGAN
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

            //             $pengesah = Pengesah::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)->first(); //PENGESAH UNTUK AGENSI
            //             // dd($pengesah);

            //             if ( !app()->environment('local') && !app()->environment('development') ) {
            //                 //HANTAR KE KEWANGAN
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
            // else { //IF KPN HANTAR EMEL KE SUB UNTUK DISYORKAN
                //HANTAR EMEL KEPADA SUB UNTUK DISYOR
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
    
                            // foreach($pentadbirs as $pentadbir)
                            // {
                            // $header->cc('ariefazhim@gmail.com', 'Azhim');	//emel pentadbir
                            // $header->cc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
                            // }
    
                            $header->subject('Notifikasi Permohonan Baru ePantas.');
                        });
                    }
                //HANTAR EMEL KEPADA SUB UNTUK DISYOR
            // }
            //IF KPN HANTAR KE SUB BAHAGIAN, ELSE HANTAR KE KEWANGAN

            $request->session()->flash('status', 'Maklumat permohonan berjaya dihantar.');
            return redirect('/peruntukan/butiran/' . $id); 
    
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

                    // 'unit.required' => 'Sila pastikan anda telah memasukkan Unit.',
                    'unit.integer' => 'Sila pastikan anda telah memasukkan Unit nombor sahaja.',

                    'kos.required' => 'Sila pastikan anda telah memasukkan Anggaran Kos.',

                ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/peruntukan/kemaskini/vot/' . $id)->withInput();
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
                // $input->unit = $data['unit'];
                // $input->keterangan = $data['lain'];
                $input->keterangan = $lain;
                $input->unit = $unit;
                $input->kos = $data['kos'];
                $input->save(); 

                $request->session()->flash('status', 'Maklumat Vot ditambah.');
                return redirect('/peruntukan/kemaskini/vot/' . $id);// idMaklumatPermohonan
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

            return view('admin.kemaskiniVot', compact('vots', 'maklumats', 'objekAms', 'objekSebs', 'lkpPerkaras', 'lkpOAs', 'lkpOSs'));
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
                return redirect('/peruntukan/kemaskini/vot/form/' . $id)->withInput();
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

            $request->session()->flash('status', 'Maklumat Vot dikemaskini.');
            return redirect('peruntukan/kemaskini/vot/'. $vot->idMaklumatPermohonan);
        }
        else {

            $lkpPerkaras = LkpPerkara::orderBy('perkara', 'asc')->get();

            // $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
            $objekAms = LkpOA::get();

            // $objekSebs = LkpObjek::get();
            $objekSebs = LkpOS::get();


            return view('admin.kemaskiniVotForm', compact('vot', 'objekAms', 'objekSebs', 'lkpPerkaras'));
        }
        

    }
 
    public function buang_vot(Request $request, $id) {

        $idMaklumat = VotByAdmin::where('idVotByAdmin', $id)->first();
        VotByAdmin::where('idVotByAdmin', $id)->delete();

        $request->session()->flash('status', 'Maklumat vot dibuang.');
        return redirect('/peruntukan/kemaskini/vot/' . $idMaklumat->idMaklumatPermohonan); // idMaklumatPermohonan
    }
    
    public function butiran ($id){
        // $maklumats = MaklumatPermohonan::join('tindakanperkew', 'maklumat_permohonan.idMaklumatPermohonan', '=', 'tindakanperkew.idMaklumatPermohonan')
        //                                 ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
        //                                 ->first();
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        $objektifs = Objektif::where('idMaklumatPermohonan', $id)->first();

        $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->get();
        $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->get();
        $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->get();
        $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->get();
        $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->get();

        if ( $maklumats->id_status != 1 || $maklumats->id_status != 12 )
        {
            $tindakan = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
            
            if( Auth::user()->id_access == 'Pengesah'  ){
                $tindakanLists = Tindakan::where('idMaklumatPermohonan', $id)->get(); //semua
        
                $tindakanSokong = null;
                $tindakanPeraku = null;
            }
            else {
                //keluar result bukan tuk pengesah
                $tindakanLists = Tindakan::where('idMaklumatPermohonan', $id)
                                        // ->where('id_status', '!=', 19)
                                        ->whereNotIn('id_status', [ 1, 11, 20])
                                        ->get(); //semua

                $tindakanSokong = Tindakan::where('idMaklumatPermohonan', $id)
                                ->whereIn('id_status', [15, 16])
                                ->latest('CreatedAt')
                                // ->orWhere('id_status', 16)
                                ->first();

                $tindakanPeraku = Tindakan::where('idMaklumatPermohonan', $id)
                                ->whereIn('id_status', [17, 18])
                                ->latest('CreatedAt')
                                // ->orWhere('id_status', 18)
                                ->first();
            }
            // $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        }
        else {
            $tindakan = null;
            $tindakanLists = null;

            $tindakanSokong = null;
            $tindakanPeraku = null;
            // $votByAdmins = null;
        }

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $user = User::where('mykad', $pemohon->noKp)->first();

        //IF != DRAF && BUKAN KPN CARI PENGESAH
        if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' && $maklumats->id_status != 12) {
            // $pengesahAgensi = Pengesah::where('idMaklumatPermohonan', $id)->first();
            $pengesahAgensi = Pengesah::where('idPengesah', $maklumats->pengesah)->first();
         }
         else {
            $pengesahAgensi = [];
         }
        //  return $pengesahAgensi;
        //IF != DRAF && BUKAN KPN CARI PENGESAH

        // $personel = PPersonel::where('name', $pemohon->namaPemohon)->first();

        return view('admin.butiran', compact('maklumats', 'tindakan', 'tindakanLists','pemohon', 'user', 'vots', 'objektifs', 'tindakanSokong', 'tindakanPeraku', 'pengesahAgensi', 'tujuans', 'latars', 'dasars', 'justifikasis', 'ulasans'));
    }
    public function butiran_tindakan (Request $request, $id){
        //function untuk setkan status sokong
        $data = $request->input();
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        // $name = PPersonel::where('nokp', Auth::user()->mykad)->first();
        $user = User::where('mykad',  Auth::User()->mykad)->first();

        if( isset($_POST['simpan_sokong']) ) { //TINDAKAN SUBBKEP
            //if simpan Sokong program
 
            if( $data['optSokong'] == 15 ) {
                $rules = [
                    'optSokong' => 'required',
                    // 'kosSokong' => 'required|numeric',
                ];
                $messages = [
                    'optSokong.required' => 'Sila pastikan anda telah memasukkan Tindakan Sokongan dengan betul.',
                    // 'kosSokong.required' => 'Sila pastikan anda telah memasukkan Tindakan Sokongan dengan betul.',
                ];
            }
            elseif ( $data['optSokong'] == 16 || $data['optSokong'] == 22 ) {
                $rules = [
                    'ulasan_sokong' => 'required',
                ];
                $messages = [
                    'ulasan_sokong.required' => 'Sila pastikan anda telah memasukkan ulasan anda.',
                ];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/peruntukan/butiran/' . $id)->withInput();
            }

            //validate kosSokong more than kos mohon?
            $kos = $maklumats->kosMohon;
            if ( $data['kosSokong'] > $kos ) {
                $request->session()->flash('failed', "Jumlah disokong tidak boleh lebih dari jumlah dimohon.");
                $request->session()->flash('sokongFailed', "Jumlah disokong tidak boleh lebih dari jumlah dimohon.");
                return redirect('/peruntukan/butiran/' . $id)->withInput();
            }

            //IF INPUT KOSSOKONG EMPTY KOSSEBENAR AMBIK KOS MOHON, ELSE KOSSOKONG = KOSSEBENAR
            if ( $data['kosSokong'] == null ) {
                $kosSebenar = $kos;
            }
            else {
                $kosSebenar = $data['kosSokong'];
            }
            //IF INPUT KOSSOKONG EMPTY KOSSEBENAR AMBIK KOS MOHON, ELSE KOSSOKONG = KOSSEBENAR

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['optSokong'],
                'kosSebenar' => $kosSebenar,
                // 'kosSebenar' => $data['kosSokong'],
                'updatedAt' => Carbon\Carbon::now(),
            ]);
            
            //Tindakan If Lulus
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = $data['optSokong'];
            $tindakan->Ulasan = $data['ulasan_sokong'];
            // $tindakan->Kos = $kosSebenar;
            $tindakan->Kos = $data['kosSokong'];
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy = $user->id;
            $tindakan->save();

            if ( $data['optSokong'] == 22) { //IF SEMAK SEMULA
                // EMEL KE PEMOHON SEMAK SEMULA
                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                    // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                    ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                    // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                    ->first();

                    $pemohon = User::where('mykad', $contentEmel->noKp)->first();

                    $ulasan = Tindakan::where('idTindakanPerkew', $tindakan->idTindakanPerkew)->first();

                    $pengesah = User::where('id', $ulasan->UpdatedBy)->first(); //YANG BUAT TINDAKAN

                    if ( !app()->environment('local') && !app()->environment('development') ) {

                        //HANTAR KE PEMOHON
                        Mail::send('email/tindakan/emel_semak_semula', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah, 'ulasan' => $ulasan], function ($header) use ($pemohon)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                            $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DISOKONG
    
                            $header->subject('Notifikasi Status Permohonan ePantas.');
                            // $header->subject('Notifikasi Status Permohonan ePantas.');
                        });
                    }

                // EMEL KE PEMOHON SEMAK SEMULA
            }
            else {
                //HANTAR EMEL KEPADA SUBK
                        $pentadbir = User::where('id_access', 'Pentadbir-SUB Kanan Pengurusan')
                                            ->where('status', 'Aktif')
                                            ->first(); //PENTADBIR SUBK
                        // dd($pentadbir);
    
                        $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                ->first();
                        // dd($contentEmel);

                        $pemohon = User::where('mykad', $contentEmel->noKp)->first();
    
                        $pengesah = User::where('id_access', 'Pentadbir-SUB Kewangan dan Pembangunan')
                                            ->where('status', 'Aktif')
                                            ->first(); //SUB BKP SOKONG ATAU TIDAK
                        // dd($pengesah);
    
                        $ulasan = Tindakan::where('idTindakanPerkew', $tindakan->idTindakanPerkew)->first();
                        // $ulasan = Tindakan::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)
                        // ->where(function ($query) {
                        //     $query->where('id_status', 13)
                        //         ->orWhere('id_status', 14);
                        // })
                        // ->latest('UpdatedAt')
                        // ->first();
                        // dd($ulasan);
    
                        $pentadbirKewangan = User::where('id', $ulasan->UpdatedBy)
                        ->first(); //PENTADBIR KEWANGAN
                        // dd($pentadbirKewangan);
    
                        if ( !app()->environment('local') && !app()->environment('development') ) {
                            //HANTAR KE SUBK
                            Mail::send('email/tindakan/emel_to_SUBK', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($pentadbir)
                            {
                                $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                $header->to($pentadbir->email, $pentadbir->nama); //HANTAR KE SUBK SELEPAS DISOKONG
                                $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
        
                                $header->subject('Notifikasi Permohonan Baru ePantas.');
                                // $header->subject('Notifikasi Permohonan Baru ePantas.');
                            });
    
                            //HANTAR KE KEWANGAN
                            Mail::send('email/tindakan/emel_Status', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($pentadbirKewangan)
                            {
                                $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                $header->cc($pentadbirKewangan->email, $pentadbirKewangan->nama); //HANTAR CC KE KEWANGAN SELEPAS DISOKONG
        
                                $header->subject('Notifikasi Status Permohonan ePantas.');
                                // $header->subject('Notifikasi Status Permohonan ePantas.');
                            });

                            //HANTAR KE PEMOHON
                            Mail::send('email/tindakan/emel_to_pemohon', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($pemohon)
                            {
                                $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DISOKONG
        
                                $header->subject('Notifikasi Status Permohonan ePantas.');
                                // $header->subject('Notifikasi Status Permohonan ePantas.');
                            });
                        }
    
                        
                //HANTAR EMEL KEPADA SUBK
            }

            $request->session()->flash('status', 'Tindakan berjaya disimpan.');
            return redirect('/peruntukan/butiran/'. $id);
        }
        else if( isset($_POST['simpan_peraku']) ) { 
            //if simpan Peraku/Disyorkan SUBK

            if( $data['optPeraku'] == 17 ) {
                $rules = [
                    'optPeraku' => 'required',
                    // 'kosPeraku' => 'required|numeric',
                ];
                $messages = [
                    'optPeraku.required' => 'Sila pastikan anda telah memasukkan Tindakan Syor dengan betul.',
                    // 'kosPeraku.required' => 'Sila pastikan anda telah memasukkan Tindakan Sokongan dengan betul.',
                ];
            }
            elseif ( $data['optPeraku'] == 18 || $data['optPeraku'] == 22 ) {
                $rules = [
                    'ulasan_peraku' => 'required',
                ];
                $messages = [
                    'ulasan_peraku.required' => 'Sila pastikan anda telah memasukkan ulasan anda.',
                ];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/peruntukan/butiran/' . $id)->withInput();
            }

            //validate kosPeraku more than kos mohon?
            $kos = $maklumats->kosMohon;
            if ( $data['kosPeraku'] > $kos ) {
                $request->session()->flash('failed', "Jumlah disyorkan tidak boleh lebih dari jumlah dimohon.");
                $request->session()->flash('perakuFailed', "Jumlah disyorkan tidak boleh lebih dari jumlah dimohon.");
                return redirect('/peruntukan/butiran/' . $id)->withInput();
            }

            //IF INPUT KOS PERAKU EMPTY KOSSEBENAR AMBIK KOSSEBENAR ORI, ELSE KOS PERAKU = KOSPERAKUI
            if ( $data['kosPeraku'] == null ) {
                $kosSebenar = $maklumats->kosSebenar;
            }
            else {
                $kosSebenar = $data['kosPeraku'];
            }
            //IF INPUT KOS PERAKU EMPTY KOSSEBENAR AMBIK KOS MOHON, ELSE KOS PERAKU = KOSPERAKUI

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['optPeraku'],
                'kosSebenar' => $kosSebenar,
                'updatedAt' => Carbon\Carbon::now(),
            ]);
            
            //Tindakan If Lulus
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = $data['optPeraku'];
            $tindakan->Ulasan = $data['ulasan_peraku'];
            // $tindakan->Kos = null;
            $tindakan->Kos = $data['kosPeraku'];
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy = $user->id;
            $tindakan->save();

            if ( $data['optPeraku'] == 22) { //IF SEMAK SEMULA
                // EMEL KE PEMOHON SEMAK SEMULA
                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                    // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                    ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                    // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                    ->first();

                    $pemohon = User::where('mykad', $contentEmel->noKp)->first();

                    $ulasan = Tindakan::where('idTindakanPerkew', $tindakan->idTindakanPerkew)->first();

                    $pengesah = User::where('id', $ulasan->UpdatedBy)->first(); //YANG BUAT TINDAKAN

                    if ( !app()->environment('local') && !app()->environment('development') ) {

                        //HANTAR KE PEMOHON
                        Mail::send('email/tindakan/emel_semak_semula', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah, 'ulasan' => $ulasan], function ($header) use ($pemohon)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                            $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DISOKONG
    
                            $header->subject('Notifikasi Status Permohonan ePantas.');
                            // $header->subject('Notifikasi Status Permohonan ePantas.');
                        });
                    }

                // EMEL KE PEMOHON SEMAK SEMULA
            }
            else {
                //HANTAR EMEL KEPADA KSU
                       $pentadbir = User::where(function ($query) {
                           $query->where('id_access', 'Pentadbir-KSU');
                       })
                       ->where('status', 'Aktif')
                       ->first();
                       // dd($pentadbir);
    
                       $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                               // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                               ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                               // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                               ->first();
                       // dd($contentEmel);
                       
                    //    $pemohonPeruntukan = \App\PPemohonPeruntukan::find($contentEmel->idPemohonPeruntukan);
                       $pemohon = User::where('mykad', $contentEmel->noKp)
                       ->first(); //PEMOHON
                       // dd($pemohon);
    
                       $subBKP = User::where('id_access', 'Pentadbir-SUB Kewangan dan Pembangunan')
                                       ->where('status', 'Aktif')
                                       ->first(); //SUB BKP
                       // dd($ketuaBahagian);
    
                       $pengesah = User::where('id_access', 'Pentadbir-SUB Kanan Pengurusan')
                                       ->where('status', 'Aktif')
                                       ->first(); //SUBK
                       // dd($pengesah);
    
                       $ulasan = Tindakan::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)
                       ->where(function ($query) {
                           $query->where('id_status', 13)
                               ->orWhere('id_status', 14);
                       })
                       ->latest('UpdatedAt')
                       ->first();
                       // dd($ulasan);
    
                       $pentadbirKewangan = User::where('id', $ulasan->UpdatedBy)
                       ->first(); //PENTADBIR KEWANGAN
                       // dd($pentadbirKewangan);
    
                       if ( !app()->environment('local') && !app()->environment('development') ) {
                           //HANTAR KE KSU
                           Mail::send('email/tindakan/emel_to_KSU', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($user, $pentadbir, $contentEmel)
                           {
                               $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                               $header->to($pentadbir->email, $pentadbir->nama); //HANTAR KE KSU SELEPAS DISYORKAN SUBK  
                               $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
       
                               $header->subject('Notifikasi Permohonan Baru ePantas.');
                               // $header->subject('Notifikasi Permohonan Baru ePantas.');
                           });
    
                           //HANTAR KE SUB BKP & KEWANGAN
                           Mail::send('email/tindakan/emel_Status', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($subBKP, $pentadbir, $contentEmel, $pentadbirKewangan)
                           {
                               $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                               $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                               $header->cc($subBKP->email, $subBKP->nama); //HANTAR CC KE SUB BKP SELEPAS DISYORKAN SUBK  
                               $header->cc($pentadbirKewangan->email, $pentadbirKewangan->nama); //HANTAR CC KE KEWANGAN SELEPAS DISYORKAN SUBK  
       
                               $header->subject('Notifikasi Status Permohonan ePantas.');
                               // $header->subject('Notifikasi Status Permohonan ePantas.');
                           });

                           //HANTAR KE PEMOHON
                           Mail::send('email/tindakan/emel_to_pemohon', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($pemohon)
                           {
                               $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                               $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                               $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DISOKONG
       
                               $header->subject('Notifikasi Status Permohonan ePantas.');
                               // $header->subject('Notifikasi Status Permohonan ePantas.');
                           });
                       }
                       
                       
               //HANTAR EMEL KEPADA KSU
            }


            $request->session()->flash('status', 'Tindakan berjaya disimpan.');
            return redirect('/peruntukan/butiran/'. $id);
        }
        else if( isset($_POST['simpan_lulus']) ) { 
            //if simpan Lulus program

            if( $data['optLulus'] == 9 ) {
                $rules = [
                    'optLulus' => 'required',
                    // 'kosLulus' => 'required|numeric',
                ];
                $messages = [
                    'optLulus.required' => 'Sila pastikan anda telah memasukkan Tindakan dengan betul.',
                    // 'kosLulus.required' => 'Sila pastikan anda telah memasukkan Tindakan Sokongan dengan betul.',
                ];
            }
            elseif ( $data['optLulus'] == 10 || $data['optLulus'] == 22 ) {
                $rules = [
                    'ulasan_lulus' => 'required',
                ];
                $messages = [
                    'ulasan_lulus.required' => 'Sila pastikan anda telah memasukkan ulasan anda.',
                ];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/peruntukan/butiran/' . $id)->withInput();
            }

            //validate koslulus more than kos mohon?
            $kos = $maklumats->kosMohon;
            if ( $data['kosLulus'] > $kos ) {
                $request->session()->flash('failed', "Jumlah diluluskan tidak boleh lebih dari jumlah dimohon.");
                $request->session()->flash('lulusFailed', "Jumlah diluluskan tidak boleh lebih dari jumlah dimohon.");
                return redirect('/peruntukan/butiran/' . $id)->withInput();
            }

            //IF INPUT KOS LULUS EMPTY KOSSEBENAR AMBIK KOSSEBENAR ORI, ELSE KOS LULUS = KOSLULUS
            if ( $data['kosLulus'] == null ) {
                $kosSebenar = $maklumats->kosSebenar;
            }
            else {
                $kosSebenar = $data['kosLulus'];
            }
            //IF INPUT KOS LULUS EMPTY KOSSEBENAR AMBIK KOSSEBENAR ORI, ELSE KOS LULUS = KOSLULUS

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['optLulus'],
                'kosSebenar' => $kosSebenar,
                'updatedAt' => Carbon\Carbon::now(),
            ]);
            
            //Tindakan If Lulus
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = $data['optLulus'];
            $tindakan->Ulasan = $data['ulasan_lulus'];
            // $tindakan->Kos = null;
            $tindakan->Kos = $data['kosLulus'];
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy = $user->id;
            $tindakan->save();

            if ( $data['optLulus'] == 22) { //IF SEMAK SEMULA
                // EMEL KE PEMOHON SEMAK SEMULA
                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                    // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                    ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                    // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                    ->first();

                    $pemohon = User::where('mykad', $contentEmel->noKp)->first();

                    $ulasan = Tindakan::where('idTindakanPerkew', $tindakan->idTindakanPerkew)->first();

                    $pengesah = User::where('id', $ulasan->UpdatedBy)->first(); //YANG BUAT TINDAKAN

                    if ( !app()->environment('local') && !app()->environment('development') ) {

                        //HANTAR KE PEMOHON
                        Mail::send('email/tindakan/emel_semak_semula', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah, 'ulasan' => $ulasan], function ($header) use ($pemohon)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                            $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DISOKONG
    
                            $header->subject('Notifikasi Status Permohonan ePantas.');
                            // $header->subject('Notifikasi Status Permohonan ePantas.');
                        });
                    }

                // EMEL KE PEMOHON SEMAK SEMULA
            }
            else {
                //HANTAR EMEL KEPADA PEMOHON, CC KE PENTADBIRS
    
                    if ( $user->id_access == 'Pentadbir-KSU') {
                        //IF KSU LULUS
                            $pentadbir = User::where(function ($query) {
                                $query->where('id_access', 'Pentadbir-SUB Kewangan dan Pembangunan')
                                        ->orWhere('id_access', 'Pentadbir-SUB Kanan Pengurusan');
                            })
                            ->where('status', 'Aktif')
                            ->get(); //UNTUK CC KE SUBK & SUB BKP
                            // dd($pentadbir);
    
                            $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                    // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                    ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                    // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                    ->first();
                            // dd($contentEmel);
                            
                            // $pemohonPeruntukan = \App\PPemohonPeruntukan::find($contentEmel->idPemohonPeruntukan);
                            $pemohon = User::where('mykad', $contentEmel->noKp)
                            ->first(); //PEMOHON
                            // dd($pemohon);
    
                            if( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' ) { 
                                $ketuaBahagian = User::where('agensi', $pemohon->agensi)
                                            ->where('id_access', 'Pengesah')
                                            ->where('status', 'Aktif')
                                            ->first(); //KETUA PENGARAH
                            }
                            else {
                                $ketuaBahagian = User::where('bahagian', $pemohon->bahagian)
                                            ->where('id_access', 'Pengesah')
                                            ->where('status', 'Aktif')
                                            ->first(); //KETUA BAHAGIAN
                            // dd($ketuaBahagian);
                            }
    
                            $pengesah = User::where('id_access', 'Pentadbir-KSU')
                                            ->where('status', 'Aktif')
                                            ->first(); //SUBK
                            // dd($pengesah);
    
                            $ulasan = Tindakan::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)
                            ->where(function ($query) {
                                $query->where('id_status', 13)
                                    ->orWhere('id_status', 14);
                            })
                            ->latest('UpdatedAt')
                            ->first();
                            // dd($ulasan);
    
                            $pentadbirKewangan = User::where('id', $ulasan->UpdatedBy)
                            ->first(); //PENTADBIR KEWANGAN
                            // dd($pentadbirKewangan);
    
                            if ( !app()->environment('local') && !app()->environment('development') ) {
                                //HANTAR KE PEMOHON
                                Mail::send('email/tindakan/emel_to_pemohon', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($user, $contentEmel, $pentadbir, $pemohon)
                                {
                                    $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                    $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                    $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DILULUSKAN KSU  
        
                                    // $header->subject('Notifikasi Status Permohonan ePantas. TEST: HANTAR KE PEMOHON');
                                    $header->subject('Notifikasi Status Permohonan ePantas.');
                                });
    
                                //HANTAR KE SUB BKP,KEWANGAN & SUBK, KETUA BAHAGIAN
                                Mail::send('email/tindakan/emel_Status', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($ketuaBahagian, $contentEmel, $pentadbir, $pentadbirKewangan)
                                {
                                    $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                    $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                    $header->cc($ketuaBahagian->email, $ketuaBahagian->nama); //HANTAR CC KE KETUA BAHAGIAN SELEPAS DILULUSKAN KSU  
                                    $header->cc($pentadbirKewangan->email, $pentadbirKewangan->nama); //HANTAR KE KEWANGAN SELEPAS DILULUSKAN KSU  
        
                                    foreach($pentadbir as $pentadbirs)
                                    {
                                        $header->cc($pentadbirs->email,$pentadbirs->nama);	//HANTAR KE SUBBKP & SUBK SELEPAS DILULUSKAN KSU 
                                    }
        
                                    // $header->subject('Notifikasi Status Permohonan ePantas. TEST: HANTAR CC BILA DAH LULUS OLEH KSU');
                                    $header->subject('Notifikasi Status Permohonan ePantas.');
                                });
                            }
    
                        //IF KSU LULUS
    
                    }   
                    elseif ( $user->id_access == 'Pentadbir-SUB Kanan Pengurusan') {
                        //IF SUBK LULUS
                            
                            $pentadbir = User::where(function ($query) {
                                                $query->where('id_access', 'Pentadbir-SUB Kewangan dan Pembangunan');
                                            })
                                            ->where('status', 'Aktif')
                                            ->first();
                                // dd($pentadbir);
    
                            $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                    // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                    ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                    // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                    ->first();
                            // dd($contentEmel);
                            
                            $pemohonPeruntukan = \App\PPemohonPeruntukan::find($contentEmel->idPemohonPeruntukan);
                            $pemohon = User::where('mykad', $pemohonPeruntukan->noKp)
                            ->first(); //PEMOHON
                            // dd($pemohon);
    
                            if( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' ) { 
                                $ketuaBahagian = User::where('agensi', $pemohon->agensi)
                                            ->where('id_access', 'Pengesah')
                                            ->where('status', 'Aktif')
                                            ->first(); //KETUA PENGARAH
                            }
                            else {
                                $ketuaBahagian = User::where('bahagian', $pemohon->bahagian)
                                            ->where('id_access', 'Pengesah')
                                            ->where('status', 'Aktif')
                                            ->first(); //KETUA BAHAGIAN
                            // dd($ketuaBahagian);
                            }
    
                            $pengesah = User::where('id_access', 'Pentadbir-SUB Kanan Pengurusan')
                                            ->where('status', 'Aktif')
                                            ->first(); //SUBK
                            // dd($pengesah);
    
                            $ulasan = Tindakan::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)
                            ->where(function ($query) {
                                $query->where('id_status', 13)
                                    ->orWhere('id_status', 14);
                            })
                            ->latest('UpdatedAt')
                            ->first();
                            // dd($ulasan);
    
                            $pentadbirKewangan = User::where('id', $ulasan->UpdatedBy)
                            ->first(); //PENTADBIR KEWANGAN
                            // dd($pentadbirKewangan);
    
                            if ( !app()->environment('local') && !app()->environment('development') ) {
                                //HANTAR KE PEMOHON
                                Mail::send('email/tindakan/emel_to_pemohon', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($pemohon, $pentadbir, $contentEmel)
                                {
                                    $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                    $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                    $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DILULUSKAN KSU  
        
                                    // foreach($pentadbirPrevious as $pentadbirPrev)
                                    // {
                                    // $header->cc('ariefazhim@gmail.com', 'Azhim');	//emel pentadbir
                                    // $header->cc($pentadbirPrev->email,$pentadbirPrev->nama);	//emel pentadbir
                                    // }
        
                                    $header->subject('Notifikasi Status Permohonan ePantas.');
                                    // $header->subject('Notifikasi Status Permohonan ePantas. TEST:HANTAR KE PEMOHON SUBK LULUS');
                                });
        
                                //HANTAR KE SUB BKP,KEWANGAN, KETUA BAHAGIAN
                                Mail::send('email/tindakan/emel_Status', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($ketuaBahagian, $pentadbir, $contentEmel, $pentadbirKewangan)
                                {
                                    $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                    $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                    $header->cc($ketuaBahagian->email, $ketuaBahagian->nama); //HANTAR CC KE KETUA BAHAGIAN SELEPAS DILULUSKAN SUBK  
                                    $header->cc($pentadbirKewangan->email, $pentadbirKewangan->nama); //HANTAR KE KEWANGAN SELEPAS DILULUSKAN SUBK  
                                    $header->cc($pentadbir->email,$pentadbir->nama);	//HANTAR KE SUBBKP SELEPAS DILULUSKAN SUBK 
        
                                    // foreach($pentadbirPrevious as $pentadbirPrev)
                                    // {
                                    // $header->cc($pentadbirPrevious->email,$pentadbirPrevious->nama);	//emel pentadbir
                                    // }
        
                                    // $header->subject('Notifikasi Status Permohonan ePantas. TEST: HANTAR CC BILA LULUS SUBK');
                                    $header->subject('Notifikasi Status Permohonan ePantas.');
                                });
                            }
                        //IF SUBK LULUS
                        
                    }
                        
                //HANTAR EMEL KEPADA PEMOHON
            }


            $request->session()->flash('status', 'Tindakan berjaya disimpan.');
            return redirect('/peruntukan/butiran/'. $id);
        }
        else if( isset($_POST['simpan_syor']) ) { 
            //if simpan Syor program oleh Pengesah
            if( $data['optSyor'] == 19 ) {
                $rules = [
                    'optSyor' => 'required',
                ];
                $messages = [
                    'optSyor.required' => 'Sila pastikan anda telah memasukkan Tindakan dengan betul.',
                ];
            }
            elseif ( $data['optSyor'] == 11 ) {
                $rules = [
                    'ulasan_syor' => 'required',
                ];
                $messages = [
                    'ulasan_syor.required' => 'Sila pastikan anda telah memasukkan ulasan anda.',
                ];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/peruntukan/butiran/' . $id)->withInput();
            }

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['optSyor'],
                'updatedAt' => Carbon\Carbon::now(),  
            ]);
            
            //Tindakan If Disyorkan
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = $data['optSyor'];
            $tindakan->Ulasan = $data['ulasan_syor'];
            $tindakan->Kos = null;
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy = $user->id;
            $tindakan->save();

            if( $data['optSyor'] == 19 ) {
                //IF DISYORKAN OLEH SUB

                //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
                        $pentadbir = User::where('id_access', 'Pentadbir Sistem')
                                            ->where('status', 'Aktif')
                                            ->get(); //PENTADBIR KEWANGAN
                        // dd($pentadbir);
                        
                        $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                    // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                    ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                    // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                    ->first();
                        // dd($contentEmel);

                        $pemohonPeruntukan = \App\PPemohonPeruntukan::find($contentEmel->idPemohonPeruntukan);
                        $pemohon = User::where('mykad', $pemohonPeruntukan->noKp)
                        ->first(); //PEMOHON
                        // dd($pemohon);

                        // $pengesah = User::where('bahagian', $contentEmel->namaBahagian)
                        //                 ->where('id_access', 'Pengesah')
                        //                 ->where('status', 'Aktif')
                        //                 ->first(); //KETUA BAHAGIAN
                        // dd($pengesah);
                        if( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' ) { 
                            $pengesah = User::where('agensi', $pemohon->agensi)
                                        ->where('id_access', 'Pengesah')
                                        ->where('status', 'Aktif')
                                        ->first(); //KETUA PENGARAH
                                        // dd($pentadbir);
                        }
                        else {
                            $pengesah = User::where('bahagian', $pemohon->bahagian)
                                        ->where('id_access', 'Pengesah')
                                        ->where('status', 'Aktif')
                                        ->first(); //KETUA BAHAGIAN
                                        // dd($pentadbir);
                        }

                        if ( !app()->environment('local') && !app()->environment('development') ) {
                            //HANTAR KE KEWANGAN
                            Mail::send('email/tindakan/emel_syor_kewangan', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($user, $pentadbir, $contentEmel)
                            {
                                $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
    
                                foreach($pentadbir as $pentadbirs)
                                {
                                    // $header->cc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                    $header->cc($pentadbirs->email,$pentadbirs->nama);	//HANTAR KE KEWANGAN SELEPAS DISYORKAN KETUA BAHAGIAN
                                }
    
                                // $header->subject('Notifikasi Permohonan Baru ePantas. TEST: HANTAR KE KEWANGAN LEPAS SYOR');
                                $header->subject('Notifikasi Permohonan Baru ePantas.');
                            });
    
                            //HANTAR KE PEMOHON
                            Mail::send('email/tindakan/emel_syor_pemohon', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah], function ($header) use ($pemohon, $pentadbir, $contentEmel)
                            {
                                $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                                $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                                $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS DISYORKAN OLEH KETUA BHAGIAN  
    
    
                                // $header->subject('Notifikasi Status Permohonan Baru ePantas. TEST: HANTAR KE KEWANGAN LEPAS SYOR SUB BAHAGIAN');
                                $header->subject('Notifikasi Status Permohonan Baru ePantas.');
                            });
                        }
                //HANTAR EMEL KEPADA PEMOHON & KEWANGAN
            }
            elseif ( $data['optSyor'] == 11 ) {
                //IF SEMAK SEMULA OLEH SUB

                //HANTAR EMEL KEPADA PEMOHON
                    $pentadbir = User::where('id_access', 'Pentadbir Sistem')
                                        ->where('status', 'Aktif')
                                        ->get(); //PENTADBIR KEWANGAN
                    // dd($pentadbir);

                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                                // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                                ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                                // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                                ->first();
                    // dd($contentEmel);

                    // $pengesah = User::where('bahagian', $contentEmel->namaBahagian)
                    //                 ->where('id_access', 'Pengesah')
                    //                 ->where('status', 'Aktif')
                    //                 ->first(); //KETUA BAHAGIAN
                    // dd($pengesah);
                    if( $contentEmel->agensi != 'Kementerian Perpaduan Negara (KPN)' ) { 
                        $pengesah = User::where('agensi', $contentEmel->agensi)
                                    ->where('id_access', 'Pengesah')
                                    ->where('status', 'Aktif')
                                    ->first(); //KETUA PENGARAH
                                    // dd($pentadbir);
                    }
                    else {
                        $pengesah = User::where('bahagian', $contentEmel->namaBahagian)
                                    ->where('id_access', 'Pengesah')
                                    ->where('status', 'Aktif')
                                    ->first(); //KETUA BAHAGIAN
                                    // dd($pentadbir);
                    }

                    $pemohonPeruntukan = \App\PPemohonPeruntukan::find($contentEmel->idPemohonPeruntukan);
                    $pemohon = User::where('mykad', $pemohonPeruntukan->noKp)
                    ->first(); //PEMOHON
                    // dd($pemohon);

                    $ulasan = Tindakan::where('idTindakanPerkew', $tindakan->idTindakanPerkew)->first();
                    // $ulasan = Tindakan::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)
                    // ->where('id_status', 11)
                    // ->latest('UpdatedAt')->first();

                    // dd($ulasan);

                    if ( !app()->environment('local') && !app()->environment('development') ) {
                        // HANTAR KE PEMOHON
                        Mail::send('email/tindakan/emel_semak_semula', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah, 'ulasan' => $ulasan], function ($header) use ($pemohon, $pentadbir, $contentEmel)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                            $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS SEMAK SEMULA OLEH KETUA BHAGIAN  
    
                            // $header->subject('Notifikasi Status Permohonan ePantas. TEST: HANTAR KE PEMOHON JIKA SEMAK SEMULA.');
                            $header->subject('Notifikasi Status Permohonan ePantas.');
                        });
                    }
                //HANTAR EMEL KEPADA PEMOHON
            }

            $request->session()->flash('status', 'Tindakan berjaya disimpan.');
            return redirect('/peruntukan/butiran/'. $id);
        }
        else {
            return redirect('/peruntukan/butiran/'. $id);
        }
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

        return view('admin.pengesahan', compact('maklumats', 'user', 'votByAdmins', 'tindakans'));
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

        return view('admin.cetak', compact('maklumats', 'personel', 'votByAdmins', 'tindakans', 'objektif'));
    }

    public function profil (){
        // return Auth::User();
        $personel = PPersonel::where('nokp', Auth::User()->mykad)->first();
        
        return view('admin.profil', compact('personel'));
    }

    public function batal ($id) {

        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        $objektifs = Objektif::where('idMaklumatPermohonan', $id)->first();

        $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->get();
        $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->get();
        $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->get();
        $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->get();
        $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->get();

        if ( $maklumats->id_status != 1 || $maklumats->id_status != 12 )
        {
            $tindakan = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
            
            if( Auth::user()->id_access == 'Pengesah'  ){
                $tindakanLists = Tindakan::where('idMaklumatPermohonan', $id)->get(); //semua
        
                $tindakanSokong = null;
                $tindakanPeraku = null;
            }
            else {
                //keluar result bukan tuk pengesah
                $tindakanLists = Tindakan::where('idMaklumatPermohonan', $id)
                                        // ->where('id_status', '!=', 19)
                                        ->whereNotIn('id_status', [19, 11, 20])
                                        ->get(); //semua

                $tindakanSokong = Tindakan::where('idMaklumatPermohonan', $id)
                                ->whereIn('id_status', [15, 16])
                                ->latest('CreatedAt')
                                // ->orWhere('id_status', 16)
                                ->first();

                $tindakanPeraku = Tindakan::where('idMaklumatPermohonan', $id)
                                ->whereIn('id_status', [17, 18])
                                ->latest('CreatedAt')
                                // ->orWhere('id_status', 18)
                                ->first();
            }
            // $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)->get();
        }
        else {
            $tindakan = null;
            $tindakanLists = null;

            $tindakanSokong = null;
            $tindakanPeraku = null;
            // $votByAdmins = null;
        }

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $user = User::where('mykad', $pemohon->noKp)->first();

        //IF != DRAF && BUKAN KPN CARI PENGESAH
        if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' && $maklumats->id_status != 12) {
            // $pengesahAgensi = Pengesah::where('idMaklumatPermohonan', $id)->first();
            $pengesahAgensi = Pengesah::where('idPengesah', $maklumats->pengesah)->first();
         }
         else {
            $pengesahAgensi = [];
         }
        //  return $pengesahAgensi;
        //IF != DRAF && BUKAN KPN CARI PENGESAH

        return view('admin.batal',  compact('maklumats', 'tindakan', 'tindakanLists','pemohon', 'user', 'vots', 'objektifs', 'pengesahAgensi', 'tujuans', 'latars', 'dasars', 'justifikasis', 'ulasans'));
    }
    public function simpan_batal (Request $request, $id) {

        $data = $request->input();
			$rules = [
				'catatanBatal' => 'required'
			];
            $message = [
                'catatanBatal.required' => 'Sila berikan alasan pembatalan.'
            ];

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				// $request->session()->flash('failed', "Sila berikan alasan pembatalan.");
                $request->validate($rules, $message);
				return redirect('/peruntukan/batal/' . $id)->withInput();
			}

            //cari user id 
            // $person = PPersonel::where('nokp',  Auth::User()->mykad)->first();
            $user = User::where('mykad',  Auth::User()->mykad)->first();
            //

			MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
				'id_status' => 8,
				// 'ulasanKewangan' => $data['catatanBatal'],
				'updatedAt' => Carbon\Carbon::now(),
			]);

            //tindakan simpan batal
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = 8;
            $tindakan->Ulasan = $data['catatanBatal'];
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy =  $user->id;
            $tindakan->save();

            $request->session()->flash('status', 'Permohonan berjaya dibatalkan.');
			// return redirect('senarai');
            return redirect()->route('peruntukan.senarai'); 

    }

    //TINDAKAN
    public function tindakan ($id){

        // $objekAms = LkpVot::get();
        $objekAms = LkpVot::orderBy('noVot', 'asc')->get();

        $objekSebs = LkpObjek::get();
        $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();

        $optStatus = LkpStatus::whereIn('id_status',['9','10', '11'])->get();           
        // $optStatus = LkpStatus::where('id_status','8')->get();           
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $objektifs = Objektif::where('idMaklumatPermohonan', $id)->first();
        // $personel = PPersonel::where('nokp', '761126115089') //Baitiyamin Bin Mamat
        //                             ->orWhere('nokp', '841017086119') //Mohd Shahril Shah Bin Jamil
        //                             ->get();
        $personel = PPersonel::get();

        return view('admin.tindakan', compact('optStatus', 'personel', 'maklumats', 'objekAms', 'objekSebs', 'pemohon', 'vots', 'objektifs'));

    }
    public function simpan_tindakan (Request $request, $id){

        $data = $request->input();
        $maklumat = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();

        if( isset($_POST['semak_semula'])) {

            $rules = [
                'ulasan' => 'required',
            ];
            $messages = [
                'ulasan.required' => 'Sila berikan ulasan anda.',
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $request->validate($rules, $messages);
                return redirect('/peruntukan/tindakan/' . $id)->withInput();
            }

            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => 22, //status = semak semula pentadbir
                'updatedAt' => Carbon\Carbon::now(),
            ]);

            $user = User::where('mykad',  Auth::User()->mykad)->first();
    
            //Tindakan SAVE
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            // $tindakan->id_status = $data['status'];
            $tindakan->id_status = 22; //status = semak semula pentadbir
            $tindakan->Ulasan = $data['ulasan'];
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedBy =  $user->id;
            $tindakan->save();

            //HANTAR EMEL SEMULA KE PEMOHON
                $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                    // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                    ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                    // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                    ->first();
                // dd($contentEmel);

                $pemohon = User::where('mykad', $contentEmel->noKp)
                                ->first(); //PEMOHON
                                // dd($pemohon);

                $ulasan = Tindakan::where('idTindakanPerkew', $tindakan->idTindakanPerkew)->first();
                // dd($ulasan);

                $pengesah = User::where('id', $ulasan->UpdatedBy)->first();


                if ( !app()->environment('local') && !app()->environment('development') ) {
                    // HANTAR KE PEMOHON
                    Mail::send('email/tindakan/emel_semak_semula', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah, 'ulasan' => $ulasan], function ($header) use ($pemohon, $pentadbir, $contentEmel)
                    {
                        $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                        $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                        $header->to($pemohon->email, $pemohon->nama); //HANTAR KE PEMOHON SELEPAS SEMAK SEMULA OLEH KETUA BHAGIAN  

                        // $header->subject('Notifikasi Status Permohonan ePantas. TEST: HANTAR KE PEMOHON JIKA SEMAK SEMULA.');
                        $header->subject('Notifikasi Status Permohonan ePantas.');
                    });
                }
            //HANTAR EMEL SEMULA KE PEMOHON
            
            $request->session()->flash('status', 'Tindakan berjaya disimpan.');
            return redirect('/peruntukan/butiran/' . $id);// 

        }
        elseif( isset($_POST['hantar'])) {

            // if( isset(data['status'] == 13) ) {
            if (isset($data['status']) && $data['status'] == 13) {
                $rules = [
                    // 'form_VOT' => 'required',
                    'status' => 'required',
                    'punca' => 'required',
                    // 'kos_lulus' => 'required|numeric',
                ];
                $messages = [
                    // 'form_VOT.required' => 'Sila isi No Vot.',
                    'status.required' => 'Sila pilih Status Peruntukan.',
                    'punca.required' => 'Sila pilih Punca Peruntukan.',
                    // 'kos_lulus.required' => 'Sila masukkan Jumlah Yang Diperuntukkan.',
                ];
    
                //validate koslulus more than kos mohon?
                // $kos = $maklumat->kosMohon;
                // if ( $data['kos_lulus'] > $kos ) {
                //     $request->session()->flash('failed', "Kos yang diperuntukkan tidak boleh lebih dari kos mohon.");
                //     return redirect('/peruntukan/tindakan/' . $id)->withInput();
                // }
    
            }
            else {
                $rules = [
                    'status' => 'required',
                    // 'catatanBatal' => 'required'
                ];
                $messages = [
                    'status.required' => 'Sila pilih Status Peruntukan.',
                ];
            }
            // $rules = [
            //     // 'catatanBatal' => 'required'
            // ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                // $request->session()->flash('failed', "Sila isi No Vot.");
                // $request->session()->flash('failed', $messages);
                $request->validate($rules, $messages);
                return redirect('/peruntukan/tindakan/' . $id)->withInput();
            }
    
            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['status'],
                'id_jenis_perbelanjaan' => $data['punca'], 
                // 'kosSebenar' => $data['kos_lulus'],
                // 'ulasanKewangan' => $data['ulasan'],
                // 'tindakan_oleh' => $data['nama'],
                'updatedAt' => Carbon\Carbon::now(),
            ]);
    
            //cari user id 
                // $person = PPersonel::where('nokp',  Auth::User()->mykad)->first();
                $user = User::where('mykad',  Auth::User()->mykad)->first();
                //
    
            //Tindakan SAVE
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            $tindakan->id_status = $data['status'];
            $tindakan->Ulasan = $data['ulasan'];
            // $tindakan->CreatedAt = $data['tarikh_tindakan'] .' '. $data['masa_tindakan'];
            $tindakan->CreatedAt = Carbon\Carbon::now();
            // $tindakan->UpdatedAt = $data['tarikh_tindakan'] .' '. $data['masa_tindakan'];
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            // $tindakan->UpdatedBy = $data['nama'];
            $tindakan->UpdatedBy =  $user->id;
            $tindakan->save();
    
            //HANTAR EMEL KEPADA SUBBKP
                    $pentadbir = User::where('id_access', 'Pentadbir-SUB Kewangan dan Pembangunan')
                                        ->where('status', 'Aktif')
                                        ->first(); //PENTADBIR SUBBKP
                    // dd($pentadbir);
    
                    $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                        // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                        ->where('maklumat_permohonan.idMaklumatPermohonan', $id)
                                        // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                        ->first();
                    // dd($contentEmel);
    
                    // $pengesah = User::where('bahagian', $contentEmel->namaBahagian)
                    //                     ->where('id_access', 'Pengesah')
                    //                     ->where('status', 'Aktif')
                    //                     ->first(); //KETUA BAHAGIAN
                    // dd($pengesah);
                    if( $contentEmel->agensi != 'Kementerian Perpaduan Negara (KPN)' ) { 
                        $pengesah = User::where('agensi', $contentEmel->agensi)
                                    ->where('id_access', 'Pengesah')
                                    ->where('status', 'Aktif')
                                    ->first(); //KETUA PENGARAH
                                    // dd($pentadbir);
                    }
                    else {
                        $pengesah = User::where('bahagian', $contentEmel->namaBahagian)
                                    ->where('id_access', 'Pengesah')
                                    ->where('status', 'Aktif')
                                    ->first(); //KETUA BAHAGIAN
                                    // dd($pentadbir);
                    }
    
                    $ulasan = Tindakan::where('idTindakanPerkew', $tindakan->idTindakanPerkew)->first();
                    // $ulasan = Tindakan::where('idMaklumatPermohonan', $contentEmel->idMaklumatPermohonan)
                    // ->where('id_status', $contentEmel->id_status)
                    // // ->orWhere('id_status', 14)
                    // ->latest('UpdatedAt')
                    // ->first();
                    // dd($ulasan);
    
                    $pentadbirKewangan = User::where('id', $ulasan->UpdatedBy)
                    ->first(); //PENTADBIR KEWANGAN
                    // dd($pentadbirKewangan);
    
                    if ( !app()->environment('local') && !app()->environment('development') ) {
                        // HANTAR KE SUB BKEP
                        Mail::send('email/tindakan/emel_to_SUBBKP', ['contentEmel' => $contentEmel, 'pengesah' => $pengesah, 'ulasan' => $ulasan, 'pentadbirKewangan' => $pentadbirKewangan], function ($header) use ($user, $pentadbir, $contentEmel)
                        {   
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                            $header->to($pentadbir->email, $pentadbir->nama); //HANTAR KE SUB BKP SELEPAS TINDAKAN KEWANGAN 
        
                            // foreach($pentadbirs as $pentadbir)
                            // {
                            // $header->cc('ariefazhim@gmail.com', 'Azhim');	//emel pentadbir
                            // $header->cc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
                            // }
        
                            // $header->subject('Notifikasi Permohonan Baru ePantas. TEST; HANTAR KE SUBBKP BILA KEWANGAN TINDAKAN.');
                            $header->subject('Notifikasi Permohonan Baru ePantas.');
                        });
                    }
            //HANTAR EMEL KEPADA SUBBKP
    
            $request->session()->flash('status', 'Tindakan berjaya disimpan.');
            return redirect('/peruntukan/butiran/' . $id);// 
            // return redirect()->route('peruntukan.senarai'); 
        }

    }
    public function tindakan_vot(Request $request, $id){

        $data = $request->input();

        if ( isset($_POST['tambah_vot']) ) {  //IF BUTTON TAMBAH VOT
             $rules = [
                //MODAL VOT VALIDATE
                'perkara' => 'nullable|string',
                'objekAm' => 'required',
                'objekSeb' => 'nullable',
                'lain' => 'nullable|string',
                // 'unit' => 'required',
                'kos' => 'required',
            ];
            $messages = [
                'perkara.required' => 'Sila pastikan anda telah memasukkan Perkara Vot.',
                'perkara.string' => 'Perkara mesti mengandungi huruf sahaja.',

                'objekAm.required' => 'Sila pastikan anda telah memasukkan Objek Am.',

                'lain.string' => 'Lain-lain mesti mengandungi huruf sahaja.',

                'unit.integer' => 'Sila pastikan anda telah memasukkan Unit nombor sahaja.',

                // 'unit.required' => 'Sila pastikan anda telah memasukkan Unit.',

                'kos.required' => 'Sila pastikan anda telah memasukkan kos.',

            ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/peruntukan/tindakan/vot/' . $id)->withInput();
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
                $input->unit = $unit;
                // $input->unit = $data['unit'];
                $input->kos = $data['kos'];
                $input->save(); 

                $request->session()->flash('status', 'Maklumat Vot ditambah.');
                return redirect('/peruntukan/tindakan/vot/' . $id);// idMaklumatPermohonan
        }
        else {
            // $objekAms = LkpVot::get();
            // $objekAms = LkpVot::orderBy('noVot', 'asc')->get(); 
            $objekAms = LkpOA::get();

            // $objekSebs = LkpObjek::get();
            $objekSebs = LkpOS::get();

            $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
            $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();

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


            return view('admin.tindakanVot', compact('vots', 'maklumats', 'objekAms', 'objekSebs', 'lkpPerkaras', 'lkpOAs', 'lkpOSs'));
        }
        
    }
    public function tindakan_votForm (Request $request, $id) { //kemaskini 1 form vot

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
                return redirect('/peruntukan/tindakan/vot/form/' . $id)->withInput();
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
                'kos' => $data['kosK']
            ]);

            return redirect('peruntukan/tindakan/vot/'. $vot->idMaklumatPermohonan);
        }
        else {

            $lkpPerkaras = LkpPerkara::orderBy('perkara', 'asc')->get();

            // $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
            $objekAms = LkpOA::get();

            // $objekSebs = LkpObjek::get();
            $objekSebs = LkpOS::get();


            return view('admin.tindakanVotForm', compact('vot', 'objekAms', 'objekSebs', 'lkpPerkaras'));
        }
        

    }
    public function tindakan_buangVot(Request $request, $id) {

        $idMaklumat = VotByAdmin::where('idVotByAdmin', $id)->first();
        VotByAdmin::where('idVotByAdmin', $id)->delete();

        $request->session()->flash('status', 'Maklumat vot dibuang.');
        return redirect('/peruntukan/tindakan/vot/' . $idMaklumat->idMaklumatPermohonan); // idMaklumatPermohonan
    }

    //TINDAKAN KEMASKINI
    public function tindakanK ($id){

        // $objekAms = LkpVot::get();
        $objekAms = LkpVot::orderBy('noVot', 'asc')->get();

        $objekSebs = LkpObjek::get();
        $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();

        $optStatus = LkpStatus::whereIn('id_status',['9','10', '11'])->get();           
        // $optStatus = LkpStatus::where('id_status','8')->get();           
        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
        
        // $tindakan = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first();
        if ( $maklumats->id_status != 1 )
        {
            $tindakan = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
            $tindakanLists = Tindakan::where('idMaklumatPermohonan', $id)->get(); //semua
        }
        else {
            $tindakan = null;
            $tindakanLists = null;
        }

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();
        $objektifs = Objektif::where('idMaklumatPermohonan', $id)->first();

        // $personel = PPersonel::where('nokp', '761126115089') //Baitiyamin Bin Mamat
        //                             ->orWhere('nokp', '841017086119') //Mohd Shahril Shah Bin Jamil
        //                             ->get();
        $personel = PPersonel::get();


        return view('admin.tindakanKemaskini', compact('optStatus', 'personel', 'maklumats', 'objekAms', 'objekSebs', 'pemohon', 'vots', 'tindakan', 'tindakanLists' , 'objektifs'));

    }
    public function simpan_tindakanK (Request $request, $id){

        $data = $request->input();
        $maklumat = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();

        if( isset($data['status']) && $data['status'] == 13 ) {  //KEWANGAN ADA
            $rules = [
                // 'form_VOT' => 'required',
                'status' => 'required',
                'punca' => 'required',
                // 'kos_lulus' => 'required|numeric',
                
            ];
            $messages = [
                // 'form_VOT.required' => 'Sila isi No Vot.',
                'status.required' => 'Sila pilih Status Peruntukan.',
                'punca.required' => 'Sila pilih Punca Peruntukan.',
                // 'kos_lulus.required' => 'Sila masukkan Jumlah Yang Diperuntukkan.',
            ];

            // validate koslulus more than kos mohon?
            // $kos = $maklumat->kosMohon;
            // if ( $data['kos_lulus'] > $kos ) {
            //     $request->session()->flash('failed', "Kos yang diperuntukkan tidak boleh lebih dari kos mohon.");
            //     return redirect('/peruntukan/kemaskini/tindakan/' . $id)->withInput();
            // }
        }
        else if( isset($data['status']) && $data['status'] == 14 ){ //KEWANGAN TAKDE
            $rules = [
                'status' => 'required',
            ];
            $messages = [
                'status.required' => 'Sila pilih Status Peruntukan.',
            ];
        }
        else if( isset($data['optSokong']) && $data['optSokong'] == 15 ) {  //SUBKP SOKONG
            $rules = [
                'optSokong' => 'required',
                // 'kosSokong' => 'required',
                
            ];
            $messages = [
                'optSokong.required' => 'Sila pilih Status Tindakan.',
                // 'kosSokong.required' => 'Sila masukkan Jumlah Disokong.',
            ];

            // validate koslulus more than kos mohon?
            $kos = $maklumat->kosMohon;
            if ( $data['kosSokong'] > $kos ) {
                $request->session()->flash('failed', "Kos yang disokong tidak boleh lebih dari kos mohon.");
                return redirect('/peruntukan/kemaskini/tindakan/' . $id)->withInput();
            }
        }
        else if( isset($data['optSokong']) && $data['optSokong'] == 16 ) {  //SUBKP TAK SOKONG
            $rules = [
                'optSokong' => 'required',
                // 'kosSokong' => 'required',
                
            ];
            $messages = [
                'optSokong.required' => 'Sila pilih Status Tindakan.',
                // 'kosSokong.required' => 'Sila masukkan Jumlah Disokong.',
            ];
        }
        else if( isset($data['optPeraku']) && $data['optPeraku'] == 17 ) {  //SUBK PERAKU
            $rules = [
                'optPeraku' => 'required',
                // 'kosPeraku' => 'required',
                
            ];
            $messages = [
                'optPeraku.required' => 'Sila pilih Status Tindakan.',
                // 'kosPeraku.required' => 'Sila masukkan Jumlah Diperaku.',
            ];

            // validate koslulus more than kos mohon?
            // $kos = $maklumat->kosMohon;
            // if ( $data['kosPeraku'] > $kos ) {
            //     $request->session()->flash('failed', "Kos yang diperaku tidak boleh lebih dari kos mohon.");
            //     return redirect('/peruntukan/kemaskini/tindakan/' . $id)->withInput();
            // }
        }
        else if( isset($data['optPeraku']) && $data['optPeraku'] == 18 ) {  //SUBKP TAK PERAKU
            $rules = [
                'optPeraku' => 'required',
                // 'kosPeraku' => 'required',
                
            ];
            $messages = [
                'optPeraku.required' => 'Sila pilih Status Tindakan.',
                // 'kosPeraku.required' => 'Sila masukkan Jumlah Diperaku.',
            ];
        }
        else {
            $rules = [
                'status' => 'required',
            ];
            $messages = [
                'status.required' => 'Sila pilih Status Peruntukan.',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
        	// $request->session()->flash('failed', "Sila isi No Vot.");
        	// $request->session()->flash('failed', $messages);
            $request->validate($rules, $messages);
        	return redirect('/peruntukan/kemaskini/tindakan/' . $id)->withInput();
        }
        
        //cari user id 
            // $person = PPersonel::where('nokp',  Auth::User()->mykad)->first();
            $user = User::where('mykad',  Auth::User()->mykad)->first();
            //
        
        //IF UBAH STATUS PERUNTUKAN
        if( isset($data['status'])){ $status = $data['status']; $ulasan = $data['ulasan']; $kosSebenar = null; }
        elseif( isset($data['optSokong'])){ 
            $status = $data['optSokong']; 
            $ulasan = $data['ulasan_sokong']; 
            //IF INPUT KOSSOKONG EMPTY KOSSEBENAR AMBIK KOS MOHON, ELSE KOSSOKONG = KOSSEBENAR
            if ( $data['kosSokong'] == null ) {
                $kosSebenar = $kos;
            }
            else {
                $kosSebenar = $data['kosSokong'];
            }
            //IF INPUT KOSSOKONG EMPTY KOSSEBENAR AMBIK KOS MOHON, ELSE KOSSOKONG = KOSSEBENAR
        }
        elseif( isset($data['optPeraku'])){ 
            $status = $data['optPeraku']; 
            $ulasan = $data['ulasan_peraku']; 
            $kosSebenar = null; 
            // $kos = $data['kosPeraku']; 
        }

        // if( $maklumat->id_status != $data['status']) {
        if( $maklumat->id_status != $status ) {
            //Tindakan SAVE
            $tindakan = new Tindakan();
            $tindakan->idMaklumatPermohonan = $id;
            // $tindakan->id_status = $data['status'];
            $tindakan->id_status = $status;
            // $tindakan->Ulasan = $data['ulasan'];
            $tindakan->Ulasan = $ulasan;
            $tindakan->Kos = $kosSebenar;
            $tindakan->CreatedAt = Carbon\Carbon::now();
            $tindakan->UpdatedAt = Carbon\Carbon::now();
            // $tindakan->UpdatedBy = $data['nama'];
            $tindakan->UpdatedBy =  $user->id;
            $tindakan->save();
        }
        else {

            Tindakan::where('idMaklumatPermohonan', $id)
                    ->where('id_status', $status)
                    ->update(['ulasan' => $ulasan, 'Kos' => $kosSebenar]);

        }


        //UPDATE BASED ON LEVEL PERUNTUKAN, SOKONG & PERAKU
        if( $maklumat->id_status == 13 || $maklumat->id_status == 14) {
            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['status'],
                'id_jenis_perbelanjaan' => $data['punca'], 
                'updatedAt' => Carbon\Carbon::now(),
            ]); 
        }
        elseif( $maklumat->id_status == 15 || $maklumat->id_status == 16) {
            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['optSokong'],
                'kosSebenar' => $kosSebenar,
                // 'kosSebenar' => $data['kosSokong'],
                'updatedAt' => Carbon\Carbon::now(),
            ]); 
        }
        elseif( $maklumat->id_status == 17 || $maklumat->id_status == 18) {
            MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
                'id_status' => $data['optPeraku'],
                // 'kosSebenar' => $data['kosPeraku'],
                'updatedAt' => Carbon\Carbon::now(),
            ]); 
        }
        //UPDATE BASED ON LEVEL PERUNTUKAN, SOKONG & PERAKU


        // MaklumatPermohonan::where('idMaklumatPermohonan', $id)->update([
        //     'id_status' => $data['status'],
        //     'id_jenis_perbelanjaan' => $data['punca'], 
        //     // 'kosSebenar' => $data['kos_lulus'],
        //     // 'ulasanKewangan' => $data['ulasan'],
        //     // 'tindakan_oleh' => $data['nama'],
        //     'updatedAt' => Carbon\Carbon::now(),
        // ]);

        $request->session()->flash('status', 'Tindakan berjaya dikemaskini.');
        return redirect('/peruntukan/butiran/' . $id);// 
        // return redirect()->route('peruntukan.senarai'); 

    }
    public function tindakan_votK(Request $request, $id){

        $data = $request->input();

        if ( isset($_POST['tambah_vot']) ) {  //IF BUTTON TAMBAH VOT
             $rules = [
                //MODAL VOT VALIDATE
                'perkara' => 'required|string',
                'objekAm' => 'required',
                'objekSeb' => 'nullable',
                // 'unit' => 'required',
                'kos' => 'required',
            ];
            $messages = [
                'perkara.required' => 'Sila pastikan anda telah memasukkan Perkara Vot.',
                'perkara.string' => 'Perkara mesti mengandungi huruf sahaja.',

                'objekAm.required' => 'Sila pastikan anda telah memasukkan Objek Am.',

                // 'unit.required' => 'Sila pastikan anda telah memasukkan Unit.',

                'kos.required' => 'Sila pastikan anda telah memasukkan kos.',

            ];

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $request->validate($rules, $messages);
                    return redirect('/peruntukan/kemaskini/tindakan/vot/' . $id)->withInput();
                }

                //IF UNIT TAKDE NILAI
                if ( $data['unit'] ) {
                    $unit = $data['unit'];
                }
                else {
                    $unit = 0;
                }
                //IF UNIT TAKDE NILAI

                $input = new VotByAdmin();
                $input->idMaklumatPermohonan = $id;
                $input->perkara = $data['perkara'];
                $input->objekAm = $data['objekAm'];
                $input->objekSebagai = $data['objekSeb'];
                $input->unit = $unit;
                $input->kos = $data['kos'];
                $input->save(); 

                $request->session()->flash('status', 'Maklumat Vot ditambah.');
                return redirect('/peruntukan/kemaskini/tindakan/vot/' . $id);// idMaklumatPermohonan
        }
        else {
            $objekAms = LkpOA::get();

             // $objekSebs = LkpObjek::get();
             $objekSebs = LkpOS::get();

            $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();
            $vots = VotByAdmin::where('idMaklumatPermohonan', $id)->get();

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


            return view('admin.tindakanKemaskiniVot', compact('vots', 'maklumats', 'objekAms', 'objekSebs', 'lkpPerkaras', 'lkpOAs', 'lkpOSs'));
        }
        
    }
    public function tindakan_votFormK (Request $request, $id) { //kemaskini 1 form vot

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
                return redirect('/peruntukan/kemaskini/tindakan/vot/form/' . $id)->withInput();
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
                'kos' => $data['kosK']
            ]);

            $request->session()->flash('status', 'Maklumat Vot dikemaskini.');
            return redirect('peruntukan/kemaskini/tindakan/vot/'. $vot->idMaklumatPermohonan);
        }
        else {
            $lkpPerkaras = LkpPerkara::orderBy('perkara', 'asc')->get();

            // $objekAms = LkpVot::get();
            // $objekAms = LkpVot::orderBy('noVot', 'asc')->get();
            $objekAms = LkpOA::get();

            // $objekSebs = LkpObjek::get();
            $objekSebs = LkpOS::get();

            return view('admin.tindakanKemaskiniVotForm', compact('vot', 'objekAms', 'objekSebs', 'lkpPerkaras'));
        }
        

    }
    public function tindakan_buangVotK(Request $request, $id) {

        $idMaklumat = VotByAdmin::where('idVotByAdmin', $id)->first();
        VotByAdmin::where('idVotByAdmin', $id)->delete();

        $request->session()->flash('status', 'Maklumat vot dibuang.');
        return redirect('/peruntukan/kemaskini/tindakan/vot/' . $idMaklumat->idMaklumatPermohonan); // idMaklumatPermohonan
    }

    //Bahagian PPT
    public function pilih_PPT(Request $request) {

		$data = $request->input();

		if(isset($_POST['pilih_PPT'])) {
            //if submit n nak tambah PPT
            $rules = [
                'tahun' => 'required'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
            	$request->session()->flash('failed', "Sila masukkan tahun PPT.");
            	return redirect('/peruntukan/pilih_ppt/')->withInput();
            }
            else {
                $nokp = $data['nokp'];
                $checkProg = PerancanganPerolehan::where('bahagian', $data['bahagian_id'])
                                                ->where('tahunPPT', $data['tahun'])
                                                ->where('id_status', '!=', 12)
                                                ->where('id_status', '!=', 10)
                                                ->where('id_status', '!=', 8)
                                                ->first();
                //check dah ade for that year n bahagian
                // if( $checkProg->isEmpty() ) {
                if( $checkProg == null ) {
                    return redirect('/peruntukan/tambah_ppt/'.$nokp)->withInput();
                }
                else {
                    $request->session()->flash('failed', "PPT bagi tahun " . $data['tahun'] . " telah didaftar.");
            	    return redirect('/peruntukan/pilih_ppt/')->withInput();
                }
            }
        }
        else if(isset($_POST['cari_nama'])) {
			
			$personel=PPersonel::where(['nokp'=>$data['nama_pendaftar']])->first();
				
				if(strlen($personel)==0) {
					$request->session()->flash('failed', 'Nama pengguna tiada dalam pangkalan data');
					return redirect('peruntukan/pilih_ppt')->withInput();
				} else {
					
					//$xemel = explode('@',$personel['emel']);
					$newdata = array(
						//'nama'=>PPersonel::find($personel['nokp'])->name,
						'nama'=>$personel->name,
						'nokp'=>$personel->nokp,
						'bahagian'=>PLkpBahagian::find($personel['bahagian_id'])->bahagian,
						'bahagian_id'=>$personel->bahagian_id,
						'jawatan'=>$personel['jawatan'],
						'gred'=>$personel['gred'],
						// 'emel'=>$personel['email'],
						// 'mykad'=>$data['mykad']
					);
					$data = array_replace($data,$newdata);
					
					return redirect('peruntukan/pilih_ppt')->withInput($data);
				}			
			
		}
        else {
            //If tekan from menu
            $OptjBelanje = LkpJenisBelanja::get();
            $OptBahagian = PLkpBahagian::get();
            $personels = PPersonel::get();

            return view('ppt.pilih_ppt', compact('OptjBelanje', 'OptBahagian', 'personels'));
        }
        
    }
    
    public function tambah_PPT(Request $request, $nokp) {

        $OptjBelanje = LkpJenisBelanja::get();
        $OptBahagian = PLkpBahagian::get();
        $OptOneOff = LkpPerkaraOneOff::get();
        $personel = PPersonel::where('nokp', $nokp)->first();

        return view('ppt.tambah_ppt', compact('OptjBelanje', 'OptBahagian', 'OptOneOff', 'personel'));
    }

    public function simpan_PPT (Request $request, $nokp) {
        
        $data = $request->input();
        $personel = PPersonel::where('nokp', $data['nokp'])->first();
        
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
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[2])->format('Y-m-d');
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
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[3])->format('Y-m-d');
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
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[3])->format('Y-m-d');
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
					$program->tkhMula = Carbon\Carbon::parse($expDecodeMJ[3])->format('Y-m-d');
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

        return redirect('peruntukan/pengesahan_ppt/'. $id_PPerolehan);
        
    }

    public function pengesahan_PPT (Request $request, $id) {

        $perancangan = PerancanganPerolehan::where('idPerancanganPerolehan', $id)->first();
        $pemohon = PPersonel::where('nokp', $perancangan->pemohon)->first();
        $programs = ProgramDirancang::where('idPerancanganPerolehan', $id)->get();
        $OptOneOff = LkpPerkaraOneOff::get();
        
        if(isset($_POST['selesaiPengesahan'])) { //setelah selesai pengesahan tukar status dari Draft ke Baru
            
            if( $perancangan->id_status == 1 || $perancangan->id_status == 9) {
                return redirect('peruntukan/senarai_ppt/');
            }
            else {

                PerancanganPerolehan::where('idPerancanganPerolehan', $id)
                 ->update([
                    'id_status' => 1,
                    'updatedAt' => Carbon\Carbon::now(),
                 ]);

                 return redirect('peruntukan/senarai_ppt/');

            }

        }
        else if (isset($_POST['batalPengesahan'])) { //Tekan jadi batal
            
            PerancanganPerolehan::where('idPerancanganPerolehan', $id)
             ->update([
                'id_status' => 8,
                'updatedAt' => Carbon\Carbon::now(),
             ]);

             return redirect('peruntukan/senarai_ppt/');

        }
        else if ( isset($_POST['selesaiKemaskini']) ) { //sudah selesai kemaskini senarai PPT terus ke senarai_PPT
            // return 'kemaskini';
            return redirect('peruntukan/senarai_ppt/');
        }
        else if ( session('kemaskini')) { //sudah selesai kemaskini senarai PPT terus ke menu
            // return 'kemaskini';
            return view('ppt.pengesahan_ppt', compact('programs', 'OptOneOff', 'personel'));
        }
        else {
            // return 'sini';
            $request->session()->flash('pengesahan', "Pengesahan Senarai");
            return view('ppt.pengesahan_ppt', compact('programs', 'OptOneOff', 'personel', 'perancangan', 'pemohon'));

        }
    }

    public function pengesahan_tambahPPT (Request $request, $id) { //id=idPerancanganPerolehan
      
        $data = $request->input();         

        if( isset($_POST['tambahPPT1']) ){

            $program = new ProgramDirancang();
            $program->idPerancanganPerolehan = $id;
            $program->idJenisBelanja = 1;
            $program->tujuanProgram = $data['tujuanProgram1'];
            $program->tkhMula = Carbon\Carbon::parse($data['tkhMula1'])->format('Y-m-d');
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

            return redirect('peruntukan/pengesahan_ppt/'. $id );
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

            return redirect('peruntukan/pengesahan_ppt/'. $id);
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

            return redirect('peruntukan/pengesahan_ppt/'. $id);
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

            return redirect('peruntukan/pengesahan_ppt/'. $id);
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

            return redirect('peruntukan/pengesahan_ppt/'. $id);
        }
    }

    public function simpan_kemaskiniPPT (Request $request, $id1, $id2) {    //$id1= id perancangan, id2= id program

        $data = $request->input();
        // $PPerancangan = PerancanganPerolehan::join('program_dirancang', 'perancangan_perolehan.idPerancanganPerolehan', '=', 'program_dirancang.idPerancanganPerolehan')
        //                                     ->where('perancangan_perolehan.idPerancanganPerolehan', $id1)
        //                                     ->where('program_dirancang.idProgramDirancang', $id2)
        //                                     ->get();
        $programs = ProgramDirancang::where('idPerancanganPerolehan', $id1)
                                    ->where('idProgramDirancang', $id2)
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

            return redirect('peruntukan/pengesahan_ppt/' . $programs->idPerancanganPerolehan );
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

            return redirect('peruntukan/pengesahan_ppt/' . $programs->idPerancanganPerolehan);
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

            return redirect('peruntukan/pengesahan_ppt/' . $programs->idPerancanganPerolehan );
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

            return redirect('peruntukan/pengesahan_ppt/' . $programs->idPerancanganPerolehan );
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

            return redirect('peruntukan/pengesahan_ppt/' . $programs->idPerancanganPerolehan );
        }
    }

    public function buangPPT($id) { //id = id ProgramDirancang
        $program = ProgramDirancang::where('idProgramDirancang', $id)->first();

        ProgramDirancang::where('idProgramDirancang', $id)->delete();

        return redirect('peruntukan/pengesahan_ppt/'. $program->idPerancanganPerolehan);

    }

    public function senarai_PPT(Request $request) {

        $search = ['status'=>'','bahagian'=>'','tahun'=>'' ];

        $progDirancangs = ProgramDirancang::get();
        $perancangans = PerancanganPerolehan::orderBy('bahagian', 'desc')->get();
        $optBahagians = PLkpBahagian::get();
        $optStatus = LkpStatus::whereIn('id_status', ['1', '8', '9', '10'])->get();

        if(isset($_POST['tapis'])){

			$data = $request->input();

			 if(strlen($data['status']) > 0) { $perancangans = $perancangans->where('id_status', $data['status']);  $search['status'] = $data['status']; }
			 if(strlen($data['bahagian']) > 0) {  $perancangans = $perancangans->where('bahagian',$data['bahagian']); $search['bahagian']=$data['bahagian'] ;  }
             if(strlen($data['tahun']) > 0) {  $perancangans = $perancangans->where('tahunPPT',$data['tahun']); $search['tahun']=$data['tahun'] ;  }

        }

        return view('ppt.senarai_ppt', compact('optBahagians', 'progDirancangs', 'perancangans', 'search', 'optStatus'));
    }

    public function tindakanPPT(Request $request, $id) {

        $perancangan = PerancanganPerolehan::where('idPerancanganPerolehan', $id)->first();
        $pemohon = PPersonel::where('nokp', $perancangan->pemohon)->first();
        $programs = ProgramDirancang::where('idPerancanganPerolehan', $id)->get();
        $OptOneOff = LkpPerkaraOneOff::get();
        $OptStatus = LkpStatus::whereIn('id_status',['9','10'])->get(); 

        if(isset($_POST['simpan_tindakan'])) {
            PerancanganPerolehan::where('idPerancanganPerolehan', $id)
             ->update([
                'id_status' => 9,
                'updatedAt' => Carbon\Carbon::now(),
             ]);

            $request->session()->flash('status', "Tindakan berjaya dikemaskini.");
             return redirect('peruntukan/senarai_ppt/');
        }
        else {
            return view('ppt.tindakan_ppt', compact('programs', 'OptOneOff', 'personel', 'perancangan', 'pemohon', 'OptStatus'));
        }
    }


    //JQUERY CARI OBJEK AM & OBJEK SEBAGAI
    public function searchObjek (Request $request)
    {
      $vot = $request->input('id'); //pegang idVot
      $cariVot = LkpVot::where('idVot', $vot)->first(); //cari noVot 
      $data = LkpObjek::where('noVot', $cariVot->noVot)->get(); //cari objekSebagai based on noVot

      return response()->json($data);
    }

    //JQUERY AUTO CARI OBJEK AM & OBJEK SEBAGAI BASED ON PERKARA YANG DIPILIH
    public function searchPerkara (Request $request)
    {
      $perkara = $request->input('id'); //pegang idVot
      $cariPerkara = LkpPerkara::where('id_lkp_perkara', $perkara)->first(); //cari Perkara 
      $cariOS = LkpOS::where('id_lkp_os', $cariPerkara->id_lkp_os)->first(); //cari OS 
      $cariOA = LkpOA::where('id_lkp_oa', $cariOS->id_lkp_oa)->first(); //cari OA 

      // Combine both data into a single array
        $data = [
            'oa' => $cariOA,
            'os' => $cariOS
        ];

      return response()->json($data);
    }

    public function searchNamaUser (Request $request)
    {
      $id = $request->input('id'); //pegang idPersonel
      $data = User::where('id', $id)->first(); //cari user

      return response()->json(['data' => $data]);
    }

    public function searchNamaPersonel (Request $request)
    {
      $id = $request->input('id'); //pegang idPersonel
      $data = PPersonel::where('id', $id)->first(); //cari personel
      $data2 = PLkpBahagian::where('id', $data->bahagian_id)->first();
      
      $data3 = Agensi::where('id', $data->agensi_id)->first();

      return response()->json(['data' => $data, 'data2' => $data2, 'data3' => $data3]);
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
                                    // ->orderBy('UpdatedAt', 'asc')                            
                                    // ->get();
                                    // ->where('id_status', 13)                            
                                    ->latest('UpdatedAt')->get(); //latest
                    
        $tindakanPengesah = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->where('id_status', 19)
                                    ->latest('UpdatedAt')
                                    ->first();

        $tindakanSokong = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [15, 16])
                                    ->latest('UpdatedAt')
                                    ->first();
    
        $tindakanPeraku = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [17, 18])
                                    ->latest('UpdatedAt')
                                    ->first();

        $tindakanLulus = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [9, 10])
                                    ->latest('UpdatedAt')
                                    ->first();

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
                    // $cariUser = User::where('bahagian', $bahagian->bahagian)->where('id_access', 'Pengesah')->where('status', 'Aktif')->first();
                    $cariUser = User::where('id', $tindakanPengesah->UpdatedBy)->where('id_access', 'Pengesah')->first();
                    $pengesah = PPersonel::where('nokp', $cariUser->mykad)->first();
                }
            }
            else {
                //  $setiausahaB = [];        
                 $pengesah = [];        
            }
            
        }
        else {
            // $pengesah = User::where('agensi', $pemohon->agensi)->where('id_access', 'Pengesah')->first();
            $pengesah = User::where('id', $tindakanPengesah->UpdatedBy)->where('id_access', 'Pengesah')->first();
        }

        // $personel = PPersonel::where('id', $tindakans->UpdatedBy)->first();

        // $imagePath = public_path('/images/JataNegara.png');
        // $imagePath = '\images\JataNegara.png';
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

            'tindakanPengesah' => $tindakanPengesah,
            'tindakanSokong' => $tindakanSokong,
            'tindakanPeraku' => $tindakanPeraku,
            'tindakanLulus' => $tindakanLulus,
        ];

        
        $dompdf = new Dompdf();

        // Set paper size and orientation
        // $dompdf->setPaper('A4', 'portrait');

        // Render Blade template into HTML
        $html = '<style>@page { margin-top: 14.1mm; }</style>'; // Set margin-top using @page rule           
        // $html = '<style>@page { margin-top: 10.1mm; }</style>'; // Set margin-top using @page rule

        $html .= View::make('admin.cetak', $data)->render(); // Add your content
        // $html = View::make('admin.cetak', $data)->render();

        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Render PDF
        $dompdf->render();
        
        // Output the generated PDF
        return response($dompdf->output())
        ->header('Content-Type', 'application/pdf');
        
        // JavaScript to set the browser tab title
        // echo '<script>document.title = "Cetak'. htmlspecialchars($maklumats->namaProgram) .'";</script>';

        // JavaScript to switch to the next tab
        echo '<script>window.location.href = "your_next_tab_url";</script>';

    }

    public function generatePDF_v2($id) {  //Tidak mengikut format just in case format lari banyak
 

        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();

        $tujuans = Tujuan::where('idMaklumatPermohonan', $id)->get();
        $latars = LatarBelakang::where('idMaklumatPermohonan', $id)->get();
        $dasars = DasarSemasa::where('idMaklumatPermohonan', $id)->get();
        $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $id)->get();
        $ulasans = UlasanBahagian::where('idMaklumatPermohonan', $id)->get();

        $objektif = Objektif::where('idMaklumatPermohonan', $id)->first();
        // $tindakans = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
        $tindakans = Tindakan::where('idMaklumatPermohonan', $id)
                                    // ->orderBy('UpdatedAt', 'asc')                            
                                    // ->get();
                                    // ->where('id_status', 13)                            
                                    ->latest('UpdatedAt')->get(); //latest
                    
        $tindakanPengesah = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->where('id_status', 19)
                                    ->latest('UpdatedAt')
                                    ->first();

        $tindakanSokong = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [15, 16])
                                    ->latest('UpdatedAt')
                                    ->first();
    
        $tindakanPeraku = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [17, 18])
                                    ->latest('UpdatedAt')
                                    ->first();

        $tindakanLulus = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [9, 10])
                                    ->latest('UpdatedAt')
                                    ->first();

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
                    // $cariUser = User::where('bahagian', $bahagian->bahagian)->where('id_access', 'Pengesah')->where('status', 'Aktif')->first();
                    $cariUser = User::where('id', $tindakanPengesah->UpdatedBy)->where('id_access', 'Pengesah')->first();
                    $pengesah = PPersonel::where('nokp', $cariUser->mykad)->first();
                }
            }
            else {
                //  $setiausahaB = [];        
                 $pengesah = [];        
            }
            
        }
        else {
            // $pengesah = User::where('agensi', $pemohon->agensi)->where('id_access', 'Pengesah')->first();
            $pengesah = User::where('id', $tindakanPengesah->UpdatedBy)->where('id_access', 'Pengesah')->first();
        }

        // $personel = PPersonel::where('id', $tindakans->UpdatedBy)->first();

        // $imagePath = public_path('/images/JataNegara.png');
        // $imagePath = '\images\JataNegara.png';
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

            'tindakanPengesah' => $tindakanPengesah,
            'tindakanSokong' => $tindakanSokong,
            'tindakanPeraku' => $tindakanPeraku,
            'tindakanLulus' => $tindakanLulus,
        ];

        
        $dompdf = new Dompdf();

        // Set paper size and orientation
        // $dompdf->setPaper('A4', 'portrait');

        // Render Blade template into HTML
        $html = '<style>@page { margin-top: 14.1mm; }</style>'; // Set margin-top using @page rule           
        // $html = '<style>@page { margin-top: 10.1mm; }</style>'; // Set margin-top using @page rule

        $html .= View::make('admin.cetak_no_format', $data)->render(); // Add your content
        // $html = View::make('admin.cetak', $data)->render();

        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Render PDF
        $dompdf->render();
        
        // Output the generated PDF
        return response($dompdf->output())
        ->header('Content-Type', 'application/pdf');
        
        // JavaScript to set the browser tab title
        // echo '<script>document.title = "Cetak'. htmlspecialchars($maklumats->namaProgram) .'";</script>';

        // JavaScript to switch to the next tab
        echo '<script>window.location.href = "your_next_tab_url";</script>';

    }

    public function OldgeneratePDF($id) {


        $maklumats = MaklumatPermohonan::where('idMaklumatPermohonan', $id)->first();

        $objektif = Objektif::where('idMaklumatPermohonan', $id)->first();
        // $tindakans = Tindakan::where('idMaklumatPermohonan', $id)->latest('UpdatedAt')->first(); //latest
        $tindakans = Tindakan::where('idMaklumatPermohonan', $id)
                                    // ->orderBy('UpdatedAt', 'asc')                            
                                    // ->get();
                                    // ->where('id_status', 13)                            
                                    ->latest('UpdatedAt')->get(); //latest
                    
        $tindakanPengesah = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->where('id_status', 19)
                                    ->first();

        $tindakanSokong = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [15, 16])
                                    ->first();
    
        $tindakanPeraku = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [17, 18])
                                    ->first();

        $tindakanLulus = Tindakan::where('idMaklumatPermohonan', $id)
                                    ->whereIn('id_status', [9, 10])
                                    ->first();

        $votByAdmins = VotByAdmin::where('idMaklumatPermohonan', $id)
                                // ->where('id_status', 9)
                                ->get();

        $pemohon = PPemohonPeruntukan::where('idPemohonPeruntukan', $maklumats->idPemohonPeruntukan)->first();

        $bahagian = PLkpBahagian::where('bahagian', $pemohon->namaBahagian)->first();
        if( $bahagian ) {
            // return $setiausahaB = PPersonel::where('bahagian_id', $bahagian->id)
            //                         // ->where('gred', 'LIKE', '%54%')   
            //                         // ->OrWhere('jawatan', 'Setiausaha Bahagian')                        
            //                         ->where('stat_pegawai', 1)                        
            //                         ->get(); 

            // return $setiausahaB = PPersonel::where('bahagian_id', $bahagian->id)
            // return $setiausahaB = PPersonel::where('bahagian_id', 29)
            //                                 ->where('stat_pegawai', 1)
            //                                 ->orderByRaw('CAST(REGEXP_REPLACE(gred, "[^0-9]", "") AS UNSIGNED) DESC')
            //                                 ->where(function ($query) {
            //                                     $query->where('jawatan', 'Setiausaha Bahagian');
            //                                 })
            //                                 ->first();
            // return $setiausahaCari = PPersonel::where('bahagian_id', 15)
            //                         ->where('stat_pegawai', 1)
            //                         ->orWhere('jawatan', 'Setiausaha Bahagian')
            //                         ->orWhere('jawatan', 'Ketua Unit Audit Dalam')
            //                         ->orWhere('jawatan', 'Ketua Integriti')
            //                         ->orWhere('jawatan', 'Ketua Unit Komunikasi Korporat')
            //                         ->orWhere('jawatan', 'Ketua Akauntan')
            //                         ->get();
                                    // ->orderByRaw('CAST(REGEXP_REPLACE(gred, "[^0-9]", "") AS UNSIGNED) DESC')

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
            // return $setiausahaCari;

            // $pengesah = PPersonel::where('id', $maklumats->pengesah)->first();
         }
         else {
            //  $setiausahaB = [];        
             $pengesah = [];        
         }

         //IF BUKAN KPN
         if ($pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)') {
            // $pengesah = Pengesah::where('idMaklumatPermohonan', $id)->first();
            $pengesah = Pengesah::where('idPengesah', $maklumats->pengesah)->first();
         }
         
         //IF BUKAN KPN

        // $personel = PPersonel::where('id', $tindakans->UpdatedBy)->first();

        // $imagePath = public_path('/images/JataNegara.png');
        // $imagePath = '\images\JataNegara.png';
        $imagePath = '/images/JataNegara.png';



        $data = [
            'maklumats' => $maklumats,
            'objektif' => $objektif,
            'tindakans' => $tindakans,
            'votByAdmins' => $votByAdmins,
            
            'pemohon' => $pemohon,
            // 'setiausahaB' => $setiausahaB,
            'pengesah' => $pengesah,
            // 'personel' => $personel,
            'image' => $imagePath,

            'tindakanPengesah' => $tindakanPengesah,
            'tindakanSokong' => $tindakanSokong,
            'tindakanPeraku' => $tindakanPeraku,
            'tindakanLulus' => $tindakanLulus,
        ];

        
        $dompdf = new Dompdf();

        // Set paper size and orientation
        // $dompdf->setPaper('A4', 'portrait');

        // Render Blade template into HTML
        $html = '<style>@page { margin-top: 14.1mm; }</style>'; // Set margin-top using @page rule           
        // $html = '<style>@page { margin-top: 10.1mm; }</style>'; // Set margin-top using @page rule

        $html .= View::make('admin.cetakOld', $data)->render(); // Add your content
        // $html = View::make('admin.cetak', $data)->render();

        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Render PDF
        $dompdf->render();
        
        // Output the generated PDF
        return response($dompdf->output())
        ->header('Content-Type', 'application/pdf');
        
        // JavaScript to set the browser tab title
        // echo '<script>document.title = "Cetak'. htmlspecialchars($maklumats->namaProgram) .'";</script>';

        // JavaScript to switch to the next tab
        echo '<script>window.location.href = "your_next_tab_url";</script>';

    }

    public function testEmel() {
        $contentEmel=MaklumatPermohonan:: join('pemohon_peruntukan','maklumat_permohonan.idPemohonPeruntukan', '=','pemohon_peruntukan.idPemohonPeruntukan')
                                            // ->join('tindakanperkew','maklumat_permohonan.idMaklumatPermohonan', '=','tindakanperkew.idMaklumatPermohonan')
                                            ->where('maklumat_permohonan.idMaklumatPermohonan', 1)
                                            // ->where('maklumat_permohonan.idMaklumatPermohonan', $input->idMaklumatPermohonan)
                                            ->first();
        // dd($contentEmel);
        if ( !app()->environment('local') && !app()->environment('production') ) {
            Mail::send('email/tindakan/emel_to_SUB', ['contentEmel' => $contentEmel], function ($header) use ($contentEmel)
            {
                $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                $header->to('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   

                $header->subject('Notifikasi Testing Emel Sistem ePantas.');
            });
        }
    }
        
}
