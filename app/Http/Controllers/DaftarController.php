<?php

namespace App\Http\Controllers;

use App\Agensi;
use App\PLkpBahagian;
use App\PPersonel;
use App\User;
use App\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use Carbon;



class DaftarController extends Controller
{
    public function password_email(Request $request) {
        $data = $request->input();

        if( isset($data['hantar']) ) {

            $user = User::where('email', $data['emel'])->first();
            
            if($user){
                // $id = $user->mykad;

                //For Token Remember password
                $token = Str::random(20);

                $usertoken = new UserToken();
                $usertoken->email = $data['emel'];
                $usertoken->token = $token;
                $usertoken->created_at = Carbon\Carbon::now();
                $usertoken->save();

                // User::where('mykad', $user->mykad)->update([
                //     'token' => $token,
                // ]);
                // return 'ok';
                
                 //HANTAR EMEL KEPADA EMEL PENDAFTAR
				Mail::send('email/emelResetPassword', ['content' => $token], function ($header) use ($user)
				{
					$header->from('no_reply@perpaduan.gov.my', 'ePantas');
					$header->to($user->email, $user->name); //emel pemohon
					// $header->to('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing

					// foreach($pentadbirs as $pentadbir)
					// {
					// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
					// }

					$header->subject('Notifikasi Set Semula Kata Laluan Akaun ePantas.');
				});

                $request->session()->flash('emel', "Sila periksa emel anda untuk reset kata laluan anda.");
                return redirect('/');

            }
            else{
                $request->session()->flash('fail', "Kami tidak dapat mencari pengguna dengan alamat emel tersebut.");
                return redirect('/password/email/');
            }
        }
        else {
            return view('auth.emailPassword');
        }
    }

    public function reset_password(Request $request, $id) {
        // $id = token
        
        if( isset($_POST['reset']) ) {
            $data = $request->input();

            // if( $data['password'] == $data['Cpassword'] ) {

                $rules = [
                    'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                ];
                
                $messages = [
                    'password.required' => 'Masukkan kata laluan.',
                    'password.min' => 'Kata laluan mesti mengandungi sekurang-kurangnya 8 aksara.',
                    'password.regex' => 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor dan satu karakter khas.',
                ];
                
                $validator = Validator::make($request->all(), $rules, $messages);
                
                if ($validator->fails()) {
                    // return redirect('/daftar/email/')->withErrors($validator)->withInput();
                    return redirect('/reset/password/'. $id)->withErrors($validator);
                }
                else {
                    $usertoken = UserToken::where('token', $id)->first();
                    User::where('email', $usertoken->email)->update([
                        'password' =>  Hash::make( $data['password'] ),
                    ]);

                    //Delete token
                    UserToken::where('token', $id)->delete();

        
                    $request->session()->flash('status', "Kata laluan berjaya diubah.");
                    return redirect('/');
                }
            // }
            // else{
            //     $request->session()->flash('fail', "Pengesahan kata laluan tidak sepadan.");
            //     return redirect('/reset/password/'. $id);
            // }

        }
        else {
            $usertoken = UserToken::where('token', $id)->first();
            $user = User::where('email', $usertoken->email)->first();
            return view('auth.resetPassword', compact('user', 'id'));
        }

    }

    public function reloadCaptcha() {

        return response()->json(['captcha' => captcha_img('flat')]);
    }

   public function check_email() {
        return view('daftar.checkEmail');
   }

   public function verify_email(Request $request) {

        $data = $request->input();

        $rules = [
            'emel' => 'required|email|ends_with:@perpaduan.gov.my', 
        ];
        $messages = [
            'emel.required' => 'Masukkan Emel Anda.',
            'emel.email' => 'Sila masukkan emel yang mempunyai @perpaduan.gov.my',
            'emel.ends_with' => 'Hanya emel perpaduan.gov.my boleh digunakan',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            //validate email perpaduan
            $request->validate($rules, $messages);
        	return redirect('/daftar/email/')->withInput();
        }
        else {

            $checkUser = User::where('email', $data['emel'])->first();
            if ($checkUser) {
                //validate if account already in db cannot create account
                $request->session()->flash('fail', "Akaun sudah dicipta. Sila cuba login.");
                return redirect('/daftar/email/');
            }

            $contentEmel = PPersonel::where('email', $data['emel'])->first();

            
            if ($contentEmel == null) {
                //validate if email takde dalam database
                $request->session()->flash('failNull', "Alamat emel yang dimasukkan tidak dikenalpasti dalam pangkalan data kami.");
                return redirect('/daftar/email/');
            }

            // Ekstrak nombor daripada gred
            preg_match('/\d+/', $contentEmel->gred, $matches);
            $gredNumber = isset($matches[0]) ? (int)$matches[0] : 0;

            // Semak jika gred adalah 41 atau lebih
            if ($gredNumber < 41) {
                $request->session()->flash('failNull', "Hanya pemohon bergred 41 dan keatas dibenarkan untuk mendaftar.");
                return redirect('/daftar/email/');
            }


             //Create Token for Register Acc Gov 
             $token = Str::random(20);
             $usertoken = New UserToken();
             $usertoken->email = $contentEmel->email;
             $usertoken->token = $token;
             $usertoken->created_at = Carbon\Carbon::now();
             $usertoken->save();

            //  return $usertoken;
            // $id = $contentEmel->nokp;
            // return $checkUser;

            //HANTAR EMEL KEPADA EMEL PENDAFTAR
				Mail::send('email/emelGov', ['content' => $token], function ($header) use ($contentEmel)
				{
					$header->from('no_reply@perpaduan.gov.my', 'ePantas');
					$header->to($contentEmel->email, $contentEmel->name); //emel pemohon
					$header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing   
                    //akan go to emelGov.blade untuk send link for registration token will be passed

					// foreach($pentadbirs as $pentadbir)
					// {
					// 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
					// }

					$header->subject('Notifikasi Pendaftaran Akaun ePantas.');
				});

            $request->session()->flash('emel', "Sila periksa emel anda untuk meneruskan proses pendaftaran.");
            return redirect('/');
        }

   }

   public function register_gov(Request $request, $id) {
        // $id -> token pass from email
        $data = $request->input();

        $usertoken = UserToken::where('token', $id)->first();
        $personel = PPersonel::where('email', $usertoken->email)->first();
        $agensi = Agensi::where('id', 1)->first();


        if( isset($_POST['hantar']) ) {
            
            // if( $data['password'] == $data['Cpassword'] ) {

                $rules = [
                    'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                ];
                
                $messages = [
                    'password.required' => 'Masukkan kata laluan.',
                    'password.min' => 'Kata laluan mesti mengandungi sekurang-kurangnya 8 aksara.',
                    'password.regex' => 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor dan satu satu karakter khas.',
                ];
                
                $validator = Validator::make($request->all(), $rules, $messages);
                
                if ($validator->fails()) {
                    //validate if password cukup syarat
                    return redirect('/daftar/daftarGov/'. $id)->withErrors($validator);
                }
                
                $create = new User();
                $create->mykad = $personel->nokp;
                $create->nama = $personel->name;
                $create->agensi = $agensi->agensi;
                // $create->agensi = 'Kementerian Perpaduan Negara (KPN)';
                $create->bahagian = $personel->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : '';
                $create->jawatan = $personel->jawatan;
                $create->gred = $personel->gred;
                $create->id_access = 'Pengguna Biasa';
                $create->status = 'Aktif';
                $create->email = $personel->email;
                $create->tel_pejabat = $personel->tel;
                $create->telefon = $personel->tel_bimbit;
                $create->password = Hash::make( $data['password'] );
                $create->created_at = now();
                $create->updated_at = now();
                $create->save();

                UserToken::where('token', $id)->delete();

                $request->session()->flash('status', "Pendaftaran Berjaya!");
                return redirect('/');

            // }
            // else{
            //     $request->session()->flash('fail', "Sila pastikan kata laluan dimasukkan dengan betul.");
            //     return redirect('daftar/daftarGov/'. $id);
            // }

        }
        else {
            return view('daftar.daftarGov', compact('personel', 'usertoken'));
        }
   }

   public function register_agensi(Request $request) {

        $data = $request->input();

        if( isset($_POST['hantar']) ) {

            $rules = [
                'mykad' => 'required', 
                'name' => 'required|string', 
                'emel' => 'required|email', 
                'agensi' => 'required|string', 
                'bahagian' => 'required|string', 
                'jawatan' => 'required|string', 
                'gred' => 'required', 
                'tel' => 'required', 
                // 'emel' => 'required|email|ends_with:@perpaduan.gov.my, @pnm.gov.my, @arkib.gov.my, @jmm.gov.my, @sukarelawan.my, @yayasantunrazak.org.my, @yayasantar.org.my, mitra.gov.my', 
                'captcha' => 'required|captcha',
                'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                // 'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ];
            $messages = [
                'mykad.required' => 'Masukkan No. MyKad anda.',
                'name.required' => 'Masukkan Nama anda.',
                'emel.required' => 'Masukkan emel anda.',
                'emel.email' => 'Sila masukkan emel yang sahih.',
                // 'emel.ends_with' => 'Sila gunakan emel yang dibawah Kementerian Perpaduan Negara',
                'agensi.required' => 'Masukkan Agensi anda.',
                'bahagian.required' => 'Masukkan Bahagian anda.',
                'jawatan.required' => 'Masukkan Jawatan anda.',
                'gred.required' => 'Masukkan Gred anda.',
                'tel.required' => 'Masukkan No.Telefon anda.',

                'captcha.required' => 'Sila pastikan Captcha telah diisi.',
                'captcha.captcha' => 'Kesalahan pengisian captcha',

                'password.required' => 'Masukkan kata laluan.',
                'password.min' => 'Kata laluan mesti mengandungi sekurang-kurangnya 8 aksara.',
                'password.regex' => 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor dan satu karakter khas.',
            ];
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $request->validate($rules, $messages);  
                $request->session()->flash('failed', "Sila pastikan borang telah dilengkapkan dengan teliti dan lengkap.");
                return redirect('/daftar/daftarAgensi/')->withInput();
            }
            else {

                //Validate Multiple Email Types
                    $possibleEndings = [ "@perpaduan.gov.my", "@pnm.gov.my", "@arkib.gov.my", "@jmm.gov.my", "@sukarelawan.my", "@yayasantunrazak.org.my", "@yayasantar.org.my", "@mitra.gov.my"];

                    $endsWithAny = false;

                    foreach ($possibleEndings as $ending) {
                        if (substr($data['emel'], -strlen($ending)) === $ending) {
                            $endsWithAny = true;
                            break;
                        }
                    }

                    if (!$endsWithAny) {
                        $request->session()->flash('failed', "Sila gunakan emel yang dibawah Kementerian Perpaduan Negara.");
                        return redirect('/daftar/daftarAgensi/')->withInput();
                    } 
                    // return 'ok';
                //Validate Multiple Email Types

                // Ekstrak nombor daripada gred
                preg_match('/\d+/', $data['gred'], $matches);
                $gredNumber = isset($matches[0]) ? (int)$matches[0] : 0;

                // Semak jika gred adalah 41 atau lebih
                if ($gredNumber < 41) {
                    $request->session()->flash('failed', "Hanya pemohon bergred 41 dan keatas dibenarkan untuk mendaftar.");
                    return redirect('/daftar/daftarAgensi/')->withInput();
                }

                $user = User::where('mykad', $data['mykad'])
                            ->orWhere('email', $data['emel'])
                            ->first();

                if($user) {
                    $request->session()->flash('failed', "Akaun sudah dicipta.");
                    return redirect('/daftar/daftarAgensi/')->withInput();
                }
                else {
                    // return 'ok';
                    // if( $data['password'] == $data['Cpassword'] ) {

                        //SIMPAN TAPI TIDAK AKTIF DULU BILE DAH VERIFY KAT EMAIL BARU BOLEH AKTIF
                        $create = new User();
                        $create->mykad = $data['mykad'];
                        $create->nama = $data['name'];
                        $create->agensi = $data['agensi'];
                        $create->bahagian = $data['bahagian'];
                        // $create->bahagian = '';
                        $create->jawatan = $data['jawatan'];
                        $create->gred = $data['gred'];
                        $create->id_access = 'Pengguna Biasa';
                        $create->status = 'Tidak Aktif';
                        $create->email = $data['emel'];
                        $create->telefon = $data['tel'];
                        $create->password = Hash::make( $data['password'] );
                        $create->created_at = now();
                        $create->updated_at = now();
                        $create->save();
        
                        //HANTAR EMEL KEPADA EMEL PENDAFTAR
                        Mail::send('email/emelAgensi', ['content' => $data], function ($header) use ($data)
                        {
                            $header->from('no_reply@perpaduan.gov.my', 'ePantas');
                            $header->to($data['emel'] , $data['name']); //emel pemohon
                            $header->bcc('azhim@perpaduan.gov.my', 'Azhim'); //Dev Testing

                            // foreach($pentadbirs as $pentadbir)
                            // {
                            // 	$header->bcc($pentadbir->email,$pentadbir->nama);	//emel pentadbir
                            // }
        
                            $header->subject('Notifikasi Pendaftaran Akaun ePantas.');
                        });
        
                        $request->session()->flash('emel', "Sila periksa emel anda untuk pengesahan pendaftaran.");
                        return redirect('/');
        
                    // }
                    // else{
                    //     $request->session()->flash('fail', "Sila pastikan kata laluan dimasukkan dengan betul.");
                    //     return redirect('daftar/daftarAgensi/')->withInput();
                    // }
                }
                
            }
        }
        else {
            $agensis = Agensi::where('id', '!=', 1)
                            ->where('id', '!=', 3)
                            ->where('id', '!=', 4)
                            ->get();       
            return view('daftar.daftarAgensi', compact('agensis'));
        }
        
    }

    public function simpan_agensi(Request $request, $id) {

        User::where('mykad', $id)->update([
            'status' => 'Aktif',
        ]);
        // $user = User::where('mykad', $id)->first();
        // return $user;
        // $agensi = new User();
        // $agensi->mykad = $param->mykad;
        // $agensi->nama = $param->name;
        // $agensi->agensi = 'Kementerian Perpaduan Negara (KPN)';
        // $agensi->bahagian = $param->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : '';
        // $agensi->jawatan = $param->jawatan;
        // $agensi->gred = $param->gred;
        // $agensi->id_access = 'Pengguna Biasa';
        // $agensi->status = 'Aktif';
        // $agensi->email = $param->email;
        // $agensi->telefon = $param->tel;
        // $agensi->password = Hash::make( $data['password'] );
        // $agensi->created_at = now();
        // $agensi->updated_at = now();
        // $agensi->save();

        $request->session()->flash('status', "Pendaftaran Berjaya!");
        return redirect('/');

    }

}
