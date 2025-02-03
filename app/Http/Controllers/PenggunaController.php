<?php

namespace App\Http\Controllers;

use App\Agensi;
use App\LkpAccess;
use App\LkpJenisBelanja;
use Carbon;
use App\LkpJenisPeruntukan;
use App\LkpStatus;
use App\MaklumatPermohonan;
use App\Pengesah;
use App\PLkpBahagian;
use App\PPemohonPeruntukan;
use App\PPersonel;
use App\ProgramDirancang;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PenggunaController extends Controller
{
    public function senarai(Request $request)
    {
        $search = [ 'agensi'=>'', 'peranan'=>'', 'status'=>'' ];

        $optAgensis = Agensi::whereIn('id', ['1','2','5','6','7'])->get();
        $optStatusUsers = LkpStatus::whereIn('id_status', ['6','7'])->get();
        $optAccesss = LkpAccess::whereIn('id_access', ['1', '5', '12', '13', '14', '15', '16'])->get(); 
        $penggunas = User::get();

        if(isset($_POST['tapis'])){

			$data = $request->input();
            
			if(strlen($data['agensi']) > 0) { $penggunas = $penggunas->where('agensi', $data['agensi']);  $search['agensi'] = $data['agensi']; }
			if(strlen($data['status']) > 0) { $penggunas = $penggunas->where('status', $data['status']);  $search['status'] = $data['status']; }
			if(strlen($data['peranan']) > 0) { $penggunas = $penggunas->where('id_access', $data['peranan']);  $search['peranan'] = $data['peranan']; }
        }
        
        return view('pengguna.senarai', compact('penggunas', 'search', 'optAccesss', 'optStatusUsers', 'optAgensis'));
    }

    public function tambah()
    {
        $pengguna = User::get();
        $agensis = Agensi::where('id', '!=', 3)
                        ->where('id', '!=', 4)
                        ->get();

        // $bahagians = PLkpBahagian::whereBetween('id', [1, 15])
        //         ->orWhere('id', 29)
        //         ->get();    
        $bahagians = PLkpBahagian::where('status_bahagian', 1)->get();
        
        $personels = PPersonel::get();
		$optStatusUsers = LkpStatus::whereIn('id_status', ['6','7'])->get();
        $optAccesss = LkpAccess::whereIn('id_access', ['1', '5', '8', '12', '13', '14', '15', '16'])->get(); 

        return view('pengguna.tambah', compact('pengguna', 'personels', 'optStatusUsers', 'optAccesss', 'agensis', 'bahagians'));
    }

    public function simpan_tambah(Request $request)
    {
        $data = $request->input();

        if( isset($_POST['hantarEmel']) ) {
            $rules = [
                // 'mykad' => 'required|string|min:3|max:255'
                //'email' => 'required|string|email|max:255'
                'nama' => 'required|string',
                'bahagian' => 'required|string',
                'agensi' => 'required',
                'jawatan' => 'required|string',
                'gred' => 'required|string',
                'email' => 'required|string|email',
                'tel_pejabat' => 'required|string',
                'telefon' => 'required|string',

                'status' => 'required',
                'peranan' => 'required',

                'id_pengguna' => 'required',
                'kata_laluan' => 'required',
            ];
            $messages = [
                'nama.required' => 'Sila pastikan Nama pengguna telah dimasukkan.',
                'bahagian.required' => 'Sila pastikan Bahagian pengguna telah dimasukkan.',
                'agensi.required' => 'Sila pastikan Agensi pengguna telah dimasukkan.',
                'jawatan.required' => 'Sila pastikan Jawatan pengguna telah dimasukkan.',
                'gred.required' => 'Sila pastikan Gred pengguna telah dimasukkan.',
                'email.required' => 'Sila pastikan Emel pengguna telah dimasukkan.',
                'tel_pejabat.required' => 'Sila pastikan No.Telefon Pejabat pengguna telah dimasukkan.',
                'telefon.required' => 'Sila pastikan No.Telefon pengguna telah dimasukkan.',

                'status.required' => 'Sila pastikan pilihan Status pengguna dipilih.',
                'peranan.required' => 'Sila pastikan Peranan akaun pengguna dipilih.',

                'id_pengguna.required' => 'Sila pastikan No.Kad Pengenalan pengguna telah dimasukkan.',
                'kata_laluan.required' => 'Sila pastikan Kata Laluan pengguna telah dimasukkan.',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $request->validate($rules, $messages);
                return redirect('pengguna/tambah')->withInput();

            } else {

                    //Cari If Nama Sudah Didaftar
                    $cariPengguna = User::where('mykad', $data['id_pengguna'])->first();

                    if ( $cariPengguna ) {
                        // if( $cariPengguna->id_access != $data['peranan'] ) {
                            $request->session()->flash('failed', "Pengguna sudah didaftar.");
                            return redirect('pengguna/tambah')->withInput();
                        // }
                    }
                    // if( $cariPengguna ) {
                    //     $request->session()->flash('failed', "Pengguna sudah didaftar.");
                    //     return redirect('pengguna/tambah')->withInput();
                    // }
                    //Cari If Nama Sudah Didaftar

                    // $agensi = Agensi::find($personel->agensi_id);

                    $pengguna = new User;
                    //$users->id_pengguna = $data['id_pengguna'];
                    $pengguna->mykad = $data['id_pengguna'];
                    $pengguna->nama = $data['nama'];
                    $pengguna->agensi = $data['agensi'];
                    $pengguna->bahagian = $data['bahagian'];
                    $pengguna->email = $data['email'];
                    $pengguna->tel_pejabat = $data['tel_pejabat'];
                    $pengguna->telefon = $data['telefon'];
                    $pengguna->jawatan = $data['jawatan'];
                    $pengguna->gred = $data['gred'];
                    $pengguna->password = Hash::make($data['kata_laluan']);
                    $pengguna->status = $data['status'];
                    $pengguna->id_access = $data['peranan'];
                    $pengguna->updated_at = Carbon\Carbon::now();
                    $pengguna->created_at = Carbon\Carbon::now();
                    $pengguna->save();

                    // IF AGENSI PENGESAH MASUK DALAM TABLE PENGESAH
                    if( $data['agensi'] != 'Kementerian Perpaduan Negara (KPN)' && $data['peranan'] == 'Pengesah') {

                        $agensi = \App\Agensi::where('agensi', $data['agensi'])->first();

                        $pengesah = new Pengesah();
                        $pengesah->mykadPengesah = $data['id_pengguna'];
                        $pengesah->namaPengesah = $data['nama'];
                        $pengesah->jawatanPengesah = $data['jawatan'];
                        $pengesah->bahagianPengesah = $data['bahagian'];
                        $pengesah->agensiPengesah = $agensi->agensi;
                        $pengesah->idAgensiPengesah = $agensi->id;
                        $pengesah->statusPengesah = $data['status'];
                        $pengesah->save();
                    }
                // IF AGENSI PENGESAH MASUK DALAM TABLE PENGESAH

                    // $id_user = $pengguna->max('id');

                     //HANTAR EMEL KEPADA PENGGUNA
                     Mail::send('email/emelPengguna', ['content' => $data], function ($header) use ($data)
                     {
                         $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                         $header->to($data['email'] , $data['nama']); //emel pemohon
                         $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing
                         
                         // foreach($pentadbirs as $pentadbir)
                         // {
                         
                             // 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
                             // }
                             
                        $header->subject('Notifikasi Pendaftaran Akaun ePantas.');
                    });
                    //HANTAR EMEL KEPADA PENGGUNA
                            
                    $request->session()->flash('status', 'Maklumat berjaya disimpan dan emel telah dihantar kepada pengguna.');
                    return redirect('pengguna/butiran/' . $pengguna->id);
            }
        }
        else {
            $rules = [
                // 'mykad' => 'required|string|min:3|max:255'
                //'email' => 'required|string|email|max:255'
                'nama' => 'required|string',
                'bahagian' => 'required|string',
                'agensi' => 'required',
                'jawatan' => 'required|string',
                'gred' => 'required|string',
                'email' => 'required|string|email',
                'tel_pejabat' => 'required|string',
                'telefon' => 'required|string',

                'status' => 'required',
                'peranan' => 'required',

                'id_pengguna' => 'required',
                'kata_laluan' => 'required',
            ];
            $messages = [
                'nama.required' => 'Sila pastikan Nama pengguna telah dimasukkan.',
                'bahagian.required' => 'Sila pastikan Bahagian pengguna telah dimasukkan.',
                'agensi.required' => 'Sila pastikan Agensi pengguna telah dimasukkan.',
                'jawatan.required' => 'Sila pastikan Jawatan pengguna telah dimasukkan.',
                'gred.required' => 'Sila pastikan Gred pengguna telah dimasukkan.',
                'email.required' => 'Sila pastikan Emel pengguna telah dimasukkan.',
                'tel_pejabat.required' => 'Sila pastikan No.Telefon Pejabat pengguna telah dimasukkan.',
                'telefon.required' => 'Sila pastikan No.Telefon pengguna telah dimasukkan.',

                'status.required' => 'Sila pastikan pilihan Status pengguna dipilih.',
                'peranan.required' => 'Sila pastikan Peranan akaun pengguna dipilih.',

                'id_pengguna.required' => 'Sila pastikan No.Kad Pengenalan pengguna telah dimasukkan.',
                'kata_laluan.required' => 'Sila pastikan Kata Laluan pengguna telah dimasukkan.',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                // $request->session()->flash('failed', "Ruangan bertanda * wajib diisi.");
                $request->validate($rules, $messages);
                return redirect('pengguna/tambah')->withInput();

            } else {

                try {
                    //Cari Personel Pendaftar
                    // $personel = PPersonel::where('id', $data['cariNama'])->first();
                    //Cari Personel Pendaftar

                    //Cari If Nama Sudah Didaftar
                    $cariPengguna = User::where('mykad', $data['id_pengguna'])->first();
                    if ( $cariPengguna ) {
                        // if( $cariPengguna->id_access != $data['peranan'] ) {
                            $request->session()->flash('failed', "Pengguna sudah didaftar.");
                            return redirect('pengguna/tambah')->withInput();
                        // }
                    }
                    // if( $cariPengguna ) {
                    //     $request->session()->flash('failed', "Pengguna sudah didaftar.");
                    //     return redirect('pengguna/tambah')->withInput();
                    // }
                    //Cari If Nama Sudah Didaftar

                    // $agensi = Agensi::find($personel->agensi_id);

                    $pengguna = new User;
                    //$users->id_pengguna = $data['id_pengguna'];
                    $pengguna->mykad = $data['id_pengguna'];
                    $pengguna->nama = $data['nama'];
                    $pengguna->agensi = $data['agensi'];
                    $pengguna->bahagian = $data['bahagian'];
                    $pengguna->email = $data['email'];
                    $pengguna->tel_pejabat = $data['tel_pejabat'];
                    $pengguna->telefon = $data['telefon'];
                    $pengguna->jawatan = $data['jawatan'];
                    $pengguna->gred = $data['gred'];
                    $pengguna->password = Hash::make($data['kata_laluan']);
                    $pengguna->status = $data['status'];
                    $pengguna->id_access = $data['peranan'];
                    $pengguna->updated_at = Carbon\Carbon::now();
                    $pengguna->created_at = Carbon\Carbon::now();
                    $pengguna->save();

                    // IF AGENSI PENGESAH MASUK DALAM TABLE PENGESAH
                        if( $data['agensi'] != 'Kementerian Perpaduan Negara (KPN)' && $data['peranan'] == 'Pengesah') {

                            $agensi = \App\Agensi::where('agensi', $data['agensi'])->first();

                            $pengesah = new Pengesah();
                            $pengesah->mykadPengesah = $data['id_pengguna'];
                            $pengesah->namaPengesah = $data['nama'];
                            $pengesah->jawatanPengesah = $data['jawatan'];
                            $pengesah->bahagianPengesah = $data['bahagian'];
                            $pengesah->agensiPengesah = $agensi->agensi;
                            $pengesah->idAgensiPengesah = $agensi->id;
                            $pengesah->statusPengesah = $data['status'];
                            $pengesah->save();
                        }
                    // IF AGENSI PENGESAH MASUK DALAM TABLE PENGESAH

                    // $id_user = $pengguna->max('id');

                    $request->session()->flash('status', 'Maklumat pengguna berjaya disimpan.');
                    return redirect('pengguna/butiran/' . $pengguna->id);
                    // return redirect('pengguna/butiran/' . $id_user);
                } 
                catch (Exception $e) {
                    $request->session()->flash('failed', 'Maklumat pengguna tidak berjaya disimpan.');
                    return redirect('pengguna/tambah')->withInput();
                }
            }
            // }
        }

    }
    public function butiran($id)
    {
        $pengguna = User::where('id', $id)->first();

        return view('pengguna.butiran', compact('pengguna'));
    }
    public function kemaskini($id)
    {
        $pengguna = User::where('id', $id)->first();
        $agensis = Agensi::where('id', '!=', 3)
                        ->where('id', '!=', 4)
                        ->get();
        // $bahagians = PLkpBahagian::whereBetween('id', [1, 15])
        //                         ->orWhere('id', 29)
        //                         ->get();
        $bahagians = PLkpBahagian::where('status_bahagian', 1)->get();

        $personel = PPersonel::where('id', $pengguna->mykad)->first();
        $optStatusUsers = LkpStatus::whereIn('id_status', ['6','7'])->get(); 
        $optAccesss = LkpAccess::whereIn('id_access', ['1', '5', '8', '12', '13', '14', '15', '16'])->get(); 

        return view('pengguna.kemaskini', compact('pengguna', 'personel', 'optStatusUsers', 'optAccesss', 'agensis', 'bahagians'));
    }
    public function simpan_kemaskini(Request $request, $id)
    {
        $data = $request->input();

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
        //     'status' => $data['status'],
        //     'id_access' => $data['peranan'],
        //     'password' => $updatePass,
        //     'updated_at' => Carbon\Carbon::now()
        // ]);

        
        $currentUser = Auth::user();
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
        $user->status = $data['status'];
        $user->id_access = $data['peranan'];
        $user->mykad = $data['id_pengguna'];
        $user->password = $updatePass;
        $user->updated_at = Carbon\Carbon::now();
        $user->save();

        // IF AGENSI PENGESAH UPDATE DALAM TABLE PENGESAH
            if( $data['agensi'] != 'Kementerian Perpaduan Negara (KPN)' && $data['peranan'] == 'Pengesah') {

                $cariPengesah = Pengesah::where('mykadPengesah', $data['id_pengguna'])->first();
                $agensi = \App\Agensi::where('agensi', $data['agensi'])->first();

                if($cariPengesah){
                    // if ada maklumat dalam table pengesah update
                    Pengesah::where('mykadPengesah', $user->mykad)->update([
                        'namaPengesah' => $data['nama'],
                        'jawatanPengesah' => $data['jawatan'],
                        'bahagianPengesah' => $data['bahagian'],
                        'agensiPengesah' => $data['agensi'],
                        'idAgensiPengesah' => $agensi->id,
                        'statusPengesah' => $data['status'],
                    ]);
                }
                else {
                    // if takada maklumat dalam table pengesah create
                    $pengesah = new Pengesah();
                    $pengesah->mykadPengesah = $data['id_pengguna'];
                    $pengesah->namaPengesah = $data['nama'];
                    $pengesah->jawatanPengesah = $data['jawatan'];
                    $pengesah->bahagianPengesah = $data['bahagian'];
                    $pengesah->agensiPengesah = $agensi->agensi;
                    $pengesah->idAgensiPengesah = $agensi->id;
                    $pengesah->statusPengesah = $data['status'];
                    $pengesah->save();
                }
                
            }
        // IF AGENSI PENGESAH MASUK DALAM TABLE PENGESAH

        // Refresh user's session
        Auth::login($currentUser);

        $request->session()->flash('status', 'Maklumat pengguna berjaya dikemaskini.');
		return redirect('pengguna/butiran/'.$id);
        // return view('pemohon.butiran', compact('maklumats', 'pemohon', 'personel'));
    }
    public function hapus($id)
    {
        $pengguna  = User::where(['id'=>$id])->first();	
						
		return view('pengguna.hapus', compact('pengguna'));
    }
    public function simpan_hapus(Request $request, $id)
    {
        User::where('id', $id)->delete();
			
			$request->session()->flash('status', 'Maklumat pengguna berjaya dihapuskan.');
			return redirect('/pengguna/senarai');
    }
}
