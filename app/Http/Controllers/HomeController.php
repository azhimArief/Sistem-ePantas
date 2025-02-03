<?php

namespace App\Http\Controllers;

use App\MaklumatPermohonan;
use App\PPersonel;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    public function check(Request $request)
    {   //Login For Admin
        $user = Auth::User();
        
        // dd($user);
        if($user)      
        {
            if( $user->status == 'Aktif' ) {
                if($user->id_access == 'Pengguna Biasa') {
                    return redirect('pemohon/menu/'. $user->id);
                    // return redirect('pemohon/menu/'. $user->mykad);
                }
                else {
                    return redirect()->route('peruntukan.senarai'); 
                }
            }
            else {
                Auth::logout();
                $request->session()->flash('fail', "Akaun tidak aktif");
                return redirect('/');
            }
        }
        else
        {
            // return 'ok';
            Auth::logout();
            $request->session()->flash('fail', "Sila pastikan No. Mykad dan kata laluan anda dimasukkan dengan betul");
            // return redirect('/');
        }
    }

    public function home (){

        // $jumlPermohonan = MaklumatPermohonan::get()->count();
        $jumlPermohonan = MaklumatPermohonan::where('id_status', '!=', 12)->count();
        $jumlBaru = MaklumatPermohonan::where('id_status', 1)->count();
        $jumlLulus = MaklumatPermohonan::where('id_status', 9)->count();
        $jumlGagal = MaklumatPermohonan::where('id_status', 10)->count();

        return view('home', compact('jumlPermohonan', 'jumlBaru', 'jumlLulus', 'jumlGagal'));
    }

}
