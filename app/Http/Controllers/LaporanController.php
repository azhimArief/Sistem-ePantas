<?php

namespace App\Http\Controllers;

use App\Agensi;
use App\LkpOA;
use App\LkpStatus;
use App\LkpVot;
use App\MaklumatPermohonan;
use App\Pengurusan_Belanjawan;
use App\PLkpBahagian;
use App\PPersonel;
use App\ProgramDirancang;
use App\User;
use App\VotByAdmin;
use Illuminate\Http\Request;

use Auth;

class LaporanController extends Controller
{
    public function laporan_peruntukan(Request $request)
    {
        $bil = 1;
        // $search = ['status'=>'', 'bahagian'=>'', 'agensi'=>'' , 'tkhMula'=>'','tkhTamat'=>'', 'punca'=> '' ];
        $search = ['status'=>'', 'bahagian'=>'' , 'tkhMula'=>'','tkhTamat'=>'', 'punca'=> '' ];

        $votByAdmins = VotByAdmin::get();
        // $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'pemohon_peruntukan.idPemohonPeruntukan', '=', 'maklumat_permohonan.idPemohonPeruntukan')->get();
        // $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'pemohon_peruntukan.idPemohonPeruntukan', '=', 'maklumat_permohonan.idPemohonPeruntukan')
        //                                 ->leftJoin('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
        //                                 ->where('votbyadmin.id_Status', 9)
        //                                 ->orderBy('maklumat_permohonan.idMaklumatPermohonan', 'asc')
        //                                 ->get();
        $maklumats = MaklumatPermohonan::join('pemohon_peruntukan', 'pemohon_peruntukan.idPemohonPeruntukan', '=', 'maklumat_permohonan.idPemohonPeruntukan')
                                        ->leftJoin('votbyadmin', function ($join) {
                                            $join->on('votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan');
                                                //  ->where('votbyadmin.id_Status', '=', 9);
                                        })
                                        ->orwhere('id_status', 9)
                                        ->orwhere('id_status', 10)
                                        ->orwhere('id_status', 1)
                                        ->orderBy('maklumat_permohonan.idMaklumatPermohonan', 'asc')
                                        ->get();

        // $maklumats = MaklumatPermohonan::get();

        $optBahagians = PLkpBahagian::get();
        $optAgensis = Agensi::get();

        $optStatus = LkpStatus::whereIn('id_status', ['1', '9', '10'])->get();

        if(isset($_POST['search_laporan'])){
            $data = $request->input();
            
            if(strlen($data['status']) > 0) { 
                
                $maklumats = $maklumats->where('id_status',$data['status']);
                $search['status']=$data['status'];    
             }
            //  if(strlen($data['agensi']) > 0) {  $maklumats = $maklumats->where('agensi', $data['agensi']); $search['agensi']=$data['agensi'] ;  }
             if(strlen($data['bahagian']) > 0) {  $maklumats = $maklumats->where('namaBahagian', $data['bahagian']); $search['bahagian']=$data['bahagian'] ;  }
             if(strlen($data['punca']) > 0) {  $maklumats = $maklumats->where('id_jenis_perbelanjaan', $data['punca']); $search['punca']=$data['punca'] ;  }
             if(strlen($data['tkhMula']) > 0) {  $maklumats = $maklumats->where('tkhCadangMula', '>=',$data['tkhMula']); $search['tkhMula']=$data['tkhMula'] ;  }
             if(strlen($data['tkhTamat']) > 0) {  $maklumats = $maklumats->where('tkhCadangAkhir', '<=',$data['tkhTamat']); $search['tkhTamat']=$data['tkhTamat'] ;  }
        }
        
        //    return $maklumats;
        // dd($maklumats);
        
        return view('laporan.peruntukan', compact('optStatus', 'search', 'bil', 'maklumats', 'optBahagians', 'optAgensis', 'votByAdmins'));
    }

    public function laporan_perbelanjaan_objek(Request $request)
    {
        $bil = 1;
        $search = ['bahagian'=>'' , 'tkhMula'=>'','tkhTamat'=>'', 'punca'=> '' , 'vot'=> ''];

        // $objekAmValues = VotByAdmin::where('id_Status', 9)->pluck('objekAm')->unique()->sort()->values()->toArray();
        $objekAmValues = MaklumatPermohonan::leftJoin('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
                                            // ->where('votbyadmin.id_Status', 9)
                                            ->where('maklumat_permohonan.id_status', 9)
                                            ->pluck('objekAm')->unique()->sort()->values()->toArray();

        // $maklumats = MaklumatPermohonan::leftJoin('votbyadmin', function ($join) {
        //                                     $join->on('votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
        //                                          ->where('votbyadmin.id_Status', '=', 9);
        //                                 })
        //                                 ->where('maklumat_permohonan.id_status', 9)
        //                                 ->orderBy('votbyadmin.objekSebagai', 'asc')
        //                                 ->orderBy('maklumat_permohonan.idMaklumatPermohonan', 'asc')
        //                                 ->get();

        $maklumats = MaklumatPermohonan::join('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
                                        ->where('maklumat_permohonan.id_status', 9)
                                        ->orderBy('votbyadmin.objekSebagai', 'asc')
                                        ->orderBy('maklumat_permohonan.idMaklumatPermohonan', 'asc')
                                        ->get();
        // $maklumats = MaklumatPermohonan::get();

        $optBahagians = PLkpBahagian::get();
        $votByAdmins = VotByAdmin::get();
        // $optObjekAms = LkpVot::orderBy('noVot', 'asc')->get();
        $optObjekAms = LkpOA::get();


        $optStatus = LkpStatus::whereIn('id_status', ['1', '8', '9', '10'])->get();

        if(isset($_POST['search_laporan'])){
            $data = $request->input();

            if(strlen($data['tkhMula']) > 0) {  
                $maklumats = $maklumats->where('tkhCadangMula', '>=',$data['tkhMula']);
                // $objekAmValues = $objekAmValues->where('tkhCadangMula', '>=',$data['tkhMula']);
                // $objekAmValues = MaklumatPermohonan::leftJoin('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
                //                             ->where('votbyadmin.id_Status', 9)
                //                             ->where('maklumat_permohonan.id_status', 9)
                //                             ->where('tkhCadangMula', '>=',$data['tkhMula'])
                //                             ->pluck('objekAm')->unique()->sort()->values()->toArray();
                $search['tkhMula']=$data['tkhMula'] ;  
            }
            if(strlen($data['tkhTamat']) > 0) {  
                $maklumats = $maklumats->where('tkhCadangAkhir', '<=',$data['tkhTamat']); 
                // $objekAmValues = $objekAmValues->where('tkhCadangAkhir', '<=',$data['tkhTamat']);
                // $objekAmValues = MaklumatPermohonan::leftJoin('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
                //                             ->where('votbyadmin.id_Status', 9)
                //                             ->where('maklumat_permohonan.id_status', 9)
                //                             ->where('tkhCadangAkhir', '<=',$data['tkhTamat'])
                //                             ->pluck('objekAm')->unique()->sort()->values()->toArray();
                $search['tkhTamat']=$data['tkhTamat'] ;  
            }
            if(strlen($data['vot']) > 0) {  
                $maklumats = $maklumats->where('objekAm',$data['vot']); 
                $objekAmValues = VotByAdmin::where('objekAm', $data['vot'])->pluck('objekAm')->unique()->sort()->values()->toArray();
                // $objekAmValues = VotByAdmin::where('id_Status', 9)->where('objekAm', $data['vot'])->pluck('objekAm')->unique()->sort()->values()->toArray();
                $search['vot']=$data['vot'];  
            }
            //for objek
            if(strlen($data['tkhMula']) > 0) {  
                $objekAmValues = MaklumatPermohonan::leftJoin('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
                                            // ->where('votbyadmin.id_Status', 9)
                                            ->where('maklumat_permohonan.id_status', 9)
                                            ->where('tkhCadangMula', '>=',$data['tkhMula'])
                                            ->pluck('objekAm')->unique()->sort()->values()->toArray();
                $search['tkhMula']=$data['tkhMula'] ;  
            }
            if(strlen($data['tkhTamat']) > 0) {  
                $objekAmValues = MaklumatPermohonan::leftJoin('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
                                            // ->where('votbyadmin.id_Status', 9)
                                            ->where('maklumat_permohonan.id_status', 9)
                                            ->where('tkhCadangAkhir', '<=',$data['tkhTamat'])
                                            ->pluck('objekAm')->unique()->sort()->values()->toArray();
                $search['tkhTamat']=$data['tkhTamat'] ;  
            }
            if( strlen($data['tkhMula']) > 0 && strlen($data['tkhTamat']) > 0) {  
                $objekAmValues = MaklumatPermohonan::leftJoin('votbyadmin', 'votbyadmin.idMaklumatPermohonan', '=', 'maklumat_permohonan.idMaklumatPermohonan')
                                            // ->where('votbyadmin.id_Status', 9)
                                            ->where('maklumat_permohonan.id_status', 9)
                                            ->where('tkhCadangMula', '>=',$data['tkhMula'])
                                            ->where('tkhCadangAkhir', '<=',$data['tkhTamat'])
                                            ->pluck('objekAm')->unique()->sort()->values()->toArray();
                $search['tkhMula']=$data['tkhMula'] ;  
            }
            
        }
        
        //    return $maklumats;
        // dd($maklumats);
        
        return view('laporan.objek', compact('optStatus', 'search', 'bil', 'maklumats', 'optBahagians', 'votByAdmins', 'optObjekAms', 'objekAmValues'));
    }

    public function tambah_ppp()
    {
        $vots = LkpVot::get();
        $agensis = Agensi::get();
        return view('laporan.tambah_ppp', compact('vots', 'agensis'));
        // return view('laporan.test', compact('vots', 'agensis'));
    }

    public function simpan_tambah_ppp(Request $request)
    {

        $data = $request->input();

        $rules = [];

        $validator = Validator::make($request->all(), $rules);

        $expPenumpang = explode('|x|x|', $data['maklumat_penumpang']);

        for ($mj = 0; $mj < count($expPenumpang) - 1; $mj++) {
            $decodeMJ = base64_decode($expPenumpang[$mj]);
            $expDecodeMJ = explode('x|x', $decodeMJ);

            $penumpang = new Pengurusan_Belanjawan();
            $penumpang->idvot = $expDecodeMJ[2];
            $penumpang->PeruntukanPinda = $expDecodeMJ[3];
            $penumpang->JumTangungan = $expDecodeMJ[4];
            $penumpang->JumBelanja = $expDecodeMJ[5];
            // $penumpang->bahagian = $expDecodeMJ[2];
            // $penumpang->mykad = $expDecodeMJ[8];
            // $penumpang->id_tempahan = $id_permohonan;
            $penumpang->created_at = Carbon\Carbon::now();
            $penumpang->created_by = Auth::User(); 
            $penumpang->save();
        }

    }


    public function senarai()
    {
        return view('admin.senarai');
    }
    public function profil()
    {
        // return Auth::User();
        $personel = PPersonel::where('nokp', Auth::User()->mykad)->first();

        return view('admin.profil', compact('personel'));
    }
}
