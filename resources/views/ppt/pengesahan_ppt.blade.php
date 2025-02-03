@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                Content body start
        ***********************************-->
        <head>
            <style>
                #jenis_belanja {
                    pointer-events: none; /* Disable mouse events */
                    opacity: 0.6; /* Apply a faded appearance */
                    background-color: #0e0d0d; /* Change background color to indicate disabled state */
                }
    
            </style>
        </head>

        <div class="content-body">
			
            <div class="container-fluid">
                <div class="col-xl-13 col-lg-12">
                    <div class="card">
    
                        <div class="card-header">
                            <h4 class="card-title">
                                {{-- @if( session('pengesahan'))
                                    Pengesahan
                                @elseif ( session('kemaskini'))
                                    Kemaskini
                                @endif --}}
                                Perancangan Perolehan [Tahun {{ $perancangan->tahunPPT }}]
                            </h4>
                            <?php
                                $status = $perancangan->id_status;
                                // $status = 11;
                                $color = ""; 
                                switch($status){
                                //permohonan baru
                                case "1": $color="#2C87F0"; $status="Status : Permohonan Baru"; /*$badge="badge badge-secondary light";*/ $badge="badge badge-rounded badge-secondary badge-lg"; break; //biru
                                //Draft
                                case "12": $color="#FFB300"; $status="Status : Draft"; $badge="badge badge-rounded badge-info badge-lg"; break; //Biru Cair
                                //lulus
                                case "9":  $color="#32CD32"; $status="Status : Lulus"; /*$badge="badge badge-success light";*/ $badge="badge badge-rounded badge-success badge-lg"; break; //hijau
                                //Tidak Diluluskan
                                case "10": $color="#FF0000"; $status="Status : Tidak Diluluskan"; /*$badge="badge badge-danger light";*/ $badge="badge badge-rounded badge-danger badge-lg"; break; //merah
                                //semak semula
                                case "11": $color="#FFB300"; $status="Status : Semak Semula"; /*$badge="badge badge-warning light";*/ $badge="badge badge-rounded badge-warning badge-lg"; break; //biru
                                //batal
                                case "8": $color="#CC3300"; $status="Status : Batal"; /*$badge="badge badge-danger light";*/ $badge="badge badge-rounded badge-danger badge-lg";  break; //merah pekat
                                default : $color="#000000";
        
                                }
                            ?>
                            <span class="{{ $badge }}"> {{ $status }}</span>
                        </div>
    
                        <div class="card-body">
                            <p>Bahagian: {{ $perancangan->bahagian!='' ? \App\PLkpBahagian::find($perancangan->bahagian)->bahagian: '' }}</p>
                            {{-- <p>Pemohon: {{ $perancangan->pemohon!='' ? \App\PPersonel::find($perancangan->pemohon)->name: '' }}</p> --}}
                            <p>Pemohon: {{ $pemohon->name }}</p>
                            <div class="basic-form">                                    
                                            <h4>Program Perolehan Yang Dirancang</h4>
                                            <div class="card-body table-responsive">
                                                {{-- Nak Ubah Properties Dekat jquery.dataTables.min.js Eg; Tiada Rekod Ditemui  --}}
                                                <table id="" class="table table-bordered table-responsive-sm">
                                                    {{-- <thead bgcolor="#AED6F1" style="color:black;"> --}}
                                                    <thead class="thead-light" style="color:black;">
                                                        <tr>
                                                            {{-- <th>
                                                                <center>Bil.</center>
                                                            </th> --}}
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Tarikh Mula</center></th>
                                                            <th><center>Tarikh Tamat</center></th>
                                                            <th><center>Anggaran Kos(RM)</center></th>
                                                            <th><center>Catatan/Justifikasi</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                        
                                                    </thead>

                                                    {{-- Kira Jumlah Total1 --}}
                                                    <?php $total1 = 0 ?>
                                                    @foreach ($programs as $program1)
                                                        @if($program1->idJenisBelanja == 1)
                                                            <tbody>
                                                                    <tr>
                                                                        {{-- <td>{{ $loop->iteration }} </td> --}}
                                                                        <td><center> {{ $program1->tujuanProgram }} </center></td>
                                                                        <td><center>{{ Carbon\Carbon::parse($program1->tkhMula)->format('d.m.Y') }}</center> </td>
                                                                        <td><center>{{ Carbon\Carbon::parse($program1->tkhTamat)->format('d.m.Y') }}</center> </td>
                                                                        <td><center>RM {{ $program1->kosProgram }}</center></td>
                                                                        <?php $total1 = $total1 + $program1->kosProgram; ?>
                                                                        <td><center>{{ $program1->justifikasi }}</center></td>
                                                                        <td>
                                                                            <div class="d-flex justify-content-center">
                                                                                <a href="" title="Kemaskini" class="btn btn-sm btn-rounded btn-success" 
                                                                                    data-toggle="modal" data-target="#modal-default1-{{ $program1->idProgramDirancang }}">
                                                                                    <i class="fas fa-pen"></i>
                                                                                </a>
                                                                                <a href="{{ url('peruntukan/buangPPT/' . $program1->idProgramDirancang) }}" title="Buang" class="btn btn-sm btn-rounded btn-danger">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                            </tbody>
                                                        @endif
                                                        
                                                        @foreach($programs as $program1)
                                                        {{-- MODAL1 --}}
                                                            <div class="modal fade" id="modal-default1-{{ $program1->idProgramDirancang }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header bg-purple">
                                                                        <h4 class="modal-title">KEMASKINI PERBELANJAAN PERUNTUKAN</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form class="form-horizontal" method="POST" action="{{ route('peruntukan.simpan_kemaskiniPPT', ['id1' => $program1->idPerancanganPerolehan , 'id2' => $program1->idProgramDirancang] ) }}"
                                                                         enctype="multipart/form-data" id="myForm1"> 
                                                                        {{ csrf_field() }}
                                                                        <div class="modal-body">
                                                                            
                                                                            <div class="form-group row">
                                                                                <label for="tujuanProgram1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <textarea class="form-control" name="tujuanProgram1" id="tujuanProgram1" 
                                                                                        cols="" rows="2">{{ $program1->tujuanProgram }}
                                                                                    </textarea>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="tkhMula1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Mula <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Mula">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhMula1" id="tkhMula1" class="datepicker-default form-control"
                                                                                            value="{{ Carbon\Carbon::parse($program1->tkhMula)->format('d-m-Y') }}"> --}}
                                                                                        <input type="date" class="form-control" id="tkhMula1" name="tkhMula1"  value="{{ Carbon\Carbon::parse($program1->tkhMula)->format('Y-m-d') }}" required >
                                                                                        {{-- <div class="input-group-append" data-target="#tkhMula1" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                </div>
                            
                                                                                <label for="tkhTamat1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Tamat <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Tamat">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhTamat1" id="tkhTamat1" class="datepicker-default form-control" 
                                                                                            value="{{ Carbon\Carbon::parse($program1->tkhTamat)->format('d-m-Y') }}"> --}}
                                                                                        <input type="date" class="form-control" id="tkhTamat1" name="tkhTamat1"  value="{{ Carbon\Carbon::parse($program1->tkhTamat)->format('Y-m-d') }}" required >
                                                                                        {{-- <div class="input-group-append" data-target="#tkhTamat1" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosProgram1" class="col-sm-3 col-form-label" style="text-align:left"> Anggaran Kos
                                                                                    <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosProgram1" id="kosProgram1" value="{{ $program1->kosProgram }}">
                                                                                    </div>
                                                                                </div>   
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="justifikasi1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Catatan/Justifikasi <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <textarea class="form-control" name="justifikasi1" id="justifikasi1" cols="" rows="2">{{ $program1->justifikasi }}</textarea>
                                                                                </div>
                                                                            </div>
                                                            
                                                                        </div>
                            
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                            {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                            <button type="submit" class="btn btn-success btn-sm" name="editData1">Kemaskini</button>
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL1 --}} 
                                                        @endforeach
                                                        
                                                        {{-- FOR TAMBAH --}}
                                                        @if($loop->last)
                                                            <tr>
                                                                <td colspan="5">
                                                                    <b class="float-right">Jumlah</b>
                                                                </td>
                                                                <td colspan="1">
                                                                    <center>
                                                                        <b>RM {{ $total1 }}</b>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6"> 
                                                                    <center>
                                                                        <button type="button" title="Tambah" class="btn btn-sm btn-rounded float-right btn-primary" 
                                                                            data-toggle="modal" data-target="#modal-tambah1-{{ $program1->idPerancanganPerolehan }}"">
                                                                            <i class="fas fa-plus"></i> Tambah</button>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            {{-- MODAL1 TAMBAH--}}
                                                            <div class="modal fade" id="modal-tambah1-{{ $program1->idPerancanganPerolehan }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-purple">
                                                                            <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form class="form-horizontal" method="POST" action="{{ route('peruntukan.pengesahan_tambahPPT', ['id' => $program1->idPerancanganPerolehan] ) }}" enctype="multipart/form-data" id="myForm1">
                                                                            {{ csrf_field() }}
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="bahagian" value="{{ $program1->bahagian }}">

                                                                                <div class="form-group row">
                                                                                    <label for="tujuanProgram1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <textarea class="form-control" name="tujuanProgram1" id="tujuanProgram1" cols="" rows="2" required></textarea>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="tkhMula1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Mula <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Mula">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input type="text" name="tkhMula1" id="tkhMula1" class="datepicker-default form-control" required> --}}
                                                                                            <input type="date" class="form-control" id="tkhMula1" name="tkhMula1"  value="" required >
                                                                                            {{-- <div class="input-group-append" data-target="#tkhMula1" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                        </div>
                                                                                    </div>
                                
                                                                                    <label for="tkhTamat1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Tamat <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Tamat">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input name="tkhTamat1" id="tkhTamat1" class="datepicker-default form-control" required> --}}
                                                                                            <input type="date" class="form-control" id="tkhTamat1" name="tkhTamat1"  value="" required >
                                                                                            {{-- <div class="input-group-append" data-target="#tkhTamat1" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosProgram1" class="col-sm-3 col-form-label" style="text-align:left"> Anggaran Kos
                                                                                        <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosProgram1" id="kosProgram1" required>
                                                                                        </div>
                                                                                    </div>   
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="justifikasi1" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Catatan/Justifikasi <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <textarea class="form-control" name="justifikasi1" id="justifikasi1" cols="" rows="2" required></textarea>
                                                                                    </div>
                                                                                </div>
                                                                
                                                                            </div>
                                
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                                {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                                <button type="submit" class="btn btn-primary btn-sm" name="tambahPPT1"><i class="fas fa-plus"></i> Tambah</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL1 --}}
                                                        @endif
                                                        {{-- FOR TAMBAH --}}

                                                    @endforeach 

                                                </table>
                                                <!-- /.card-body -->
                                            </div>  

                                            <h4>Sewaan/Kontrak</h4>
                                            <div class="card-body table-responsive">
                                                {{-- Nak Ubah Properties Dekat jquery.dataTables.min.js Eg; Tiada Rekod Ditemui  --}}
                                                <table id="" class="table table-bordered table-responsive-sm">
                                                    {{-- <thead bgcolor="#AED6F1" style="color:black;"> --}}
                                                    <thead class="thead-light" style="color:black;">
                                                        <tr>
                                                            {{-- <th><center>Bil.</center> </th> --}}
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Pembekal</center></th>
                                                            <th><center>Tarikh Mula</center></th>
                                                            <th><center>Tarikh Tamat</center></th>
                                                            <th><center>Kadar Sebulan (RM)</center></th>
                                                            <th><center>Jumlah Setahun (RM)</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>

                                                    {{-- Kira Jumlah Total --}}
                                                    <?php $total2 = 0 ?>
                                                    @foreach ($programs as $program2)
                                                        @if($program2->idJenisBelanja == 2)
                                                                    <tbody>
                                                                            <tr>
                                                                                {{-- <td>{{ $loop->iteration }} </td> --}}
                                                                                <td><center>{{ $program2->tujuanProgram }}</center></td>
                                                                                <td><center>{{ $program2->pembekal }}</center></td>
                                                                                <td><center>{{ Carbon\Carbon::parse($program2->tkhMula)->format('d.m.Y') }}</center> </td>
                                                                                <td><center>{{ Carbon\Carbon::parse($program2->tkhTamat)->format('d.m.Y') }}</center> </td>
                                                                                <td><center>RM {{ $program2->kosProgram }}</center></td>
                                                                                <td><center>RM {{ $program2->kosSetahun }}</center></td>
                                                                                <?php $total2 = $total2 + $program2->kosSetahun; ?>
                                                                                <td>
                                                                                    <div class="d-flex justify-content-center">
                                                                                        <a href="" title="Kemaskini" class="btn btn-sm btn-rounded btn-success" 
                                                                                            data-toggle="modal" data-target="#modal-default2-{{ $program2->idProgramDirancang }}">
                                                                                            <i class="fas fa-pen"></i>
                                                                                        </a>
                                                                                        <a href="{{ url('peruntukan/buangPPT/' . $program2->idProgramDirancang) }}"
                                                                                            title="Buang" class="btn btn-sm btn-rounded btn-danger"><i
                                                                                                class="fas fa-trash"></i></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                    
                                                                    </tbody>
                                                        @endif
                                                    
                                                        @foreach ($programs as $program2)
                                                            {{-- MODAL2 --}}
                                                            <div class="modal fade" id="modal-default2-{{ $program2->idProgramDirancang }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header bg-purple">
                                                                        <h4 class="modal-title">KEMASKINI PERBELANJAAN PERUNTUKAN</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form class="form-horizontal" method="POST" action="{{ route('peruntukan.simpan_kemaskiniPPT', ['id1' => $program2->idPerancanganPerolehan , 'id2' => $program2->idProgramDirancang] ) }}" enctype="multipart/form-data" id="myForm2">
                                                                        {{ csrf_field() }}
                                                                        <div class="modal-body">
                                                                            
                                                                            <div class="form-group row">
                                                                                <label for="tujuanProgram2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <textarea class="form-control" name="tujuanProgram2" id="tujuanProgram2" 
                                                                                        cols="" rows="2">{{ $program2->tujuanProgram }}</textarea>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="pembekal2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Pembekal <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <input type="text" class="form-control" name="pembekal2" id="pembekal2" value="{{ $program2->pembekal }}">
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="tkhMula2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Mula <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Mula">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhMula2" id="tkhMula2" class="datepicker-default form-control"
                                                                                            value="{{ Carbon\Carbon::parse($program2->tkhMula)->format('d-m-Y') }}"> --}}
                                                                                            <input type="date" class="form-control" id="tkhMula2" name="tkhMula2"  value="{{ Carbon\Carbon::parse($program2->tkhMula)->format('Y-m-d') }}" required >
                                                                                        {{-- <div class="input-group-append" data-target="#tkhMula2" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                </div>
                            
                                                                                <label for="tkhTamat2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Tamat <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Tamat">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhTamat2" id="tkhTamat2" class="datepicker-default form-control" 
                                                                                            value="{{ Carbon\Carbon::parse($program2->tkhTamat)->format('d-m-Y') }}"> --}}
                                                                                        <input type="date" class="form-control" id="tkhTamat2" name="tkhTamat2"  value="{{ Carbon\Carbon::parse($program2->tkhTamat)->format('Y-m-d') }}" required >
                                                                                        {{-- <div class="input-group-append" data-target="#tkhTamat2" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosProgram2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Kadar Sebulan <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <input type="number" class="form-control" name="kosProgram" id="kosProgram"> --}}
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosProgram2" id="kosProgram2" 
                                                                                            value="{{ $program2->kosProgram }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosSetahun2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Jumlah Setahun <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <input type="number" class="form-control" name="kosSetahun" id="kosSetahun"> --}}
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosSetahun2" id="kosSetahun2"
                                                                                            value="{{ $program2->kosSetahun }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                            
                                                                        </div>
                            
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                            {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                            <button type="submit" class="btn btn-success btn-sm" name="editData2">Kemaskini</button>
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL2 --}}
                                                        @endforeach

                                                        {{-- FOR TAMBAH --}}
                                                        @if($loop->last)
                                                            <tr>
                                                                <td colspan="6">
                                                                    <b class="float-right">Jumlah</b>
                                                                </td>
                                                                <td colspan="1">
                                                                    <center>
                                                                        <b>RM {{ $total2 }}</b>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7"> 
                                                                    <center>
                                                                        <button type="button"  title="Tambah" class="btn btn-sm btn-rounded float-right btn-primary" 
                                                                            data-toggle="modal" data-target="#modal-tambah2-{{ $program2->idPerancanganPerolehan }}"">
                                                                            <i class="fas fa-plus"></i> Tambah</button>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            {{-- MODAL2 TAMBAH--}}
                                                            <div class="modal fade" id="modal-tambah2-{{ $program2->idPerancanganPerolehan }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-purple">
                                                                            <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form class="form-horizontal" method="POST" action="{{ route('peruntukan.pengesahan_tambahPPT', ['id' => $program2->idPerancanganPerolehan] ) }}" enctype="multipart/form-data" id="myForm1">
                                                                            {{ csrf_field() }}
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="bahagian" value="{{ $program2->bahagian }}">

                                                                                <div class="form-group row">
                                                                                    <label for="tujuanProgram2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <textarea class="form-control" name="tujuanProgram2" id="tujuanProgram2" 
                                                                                            cols="" rows="2" required></textarea>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="pembekal2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Pembekal <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <input type="text" class="form-control" name="pembekal2" id="pembekal2" value="" required>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="tkhMula2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Mula <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Mula">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input type="text" name="tkhMula2" id="tkhMula2" class="datepicker-default form-control" value="" required> --}}
                                                                                            <input type="date" class="form-control" id="tkhMula2" name="tkhMula2"  value="" required >
                                                                                            {{-- <div class="input-group-append" data-target="#tkhMula2" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                        </div>
                                                                                    </div>
                                
                                                                                    <label for="tkhTamat2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Tamat <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Tamat">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input type="text" name="tkhTamat2" id="tkhTamat2" class="datepicker-default form-control" value="" required> --}}
                                                                                            <input type="date" class="form-control" id="tkhTamat2" name="tkhTamat2"  value="" required >
                                                                                            {{-- <div class="input-group-append" data-target="#tkhTamat2" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosProgram2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Kadar Sebulan <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        {{-- <input type="number" class="form-control" name="kosProgram" id="kosProgram"> --}}
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosProgram2" id="kosProgram2" 
                                                                                                value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosSetahun2" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Jumlah Setahun <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        {{-- <input type="number" class="form-control" name="kosSetahun" id="kosSetahun"> --}}
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosSetahun2" id="kosSetahun2"
                                                                                                value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                
                                                                
                                                                            </div>
                                
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                                {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                                <button type="submit" class="btn btn-primary btn-sm" name="tambahPPT2"><i class="fas fa-plus"></i> Tambah</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL1 --}}
                                                        @endif
                                                        {{-- FOR TAMBAH --}}

                                                    @endforeach  
                                                </table>
                                                <!-- /.card-body -->
                                            </div>
                                   
                                            <h4>Penyelenggaraan</h4>
                                            <div class="card-body table-responsive">
                                                {{-- Nak Ubah Properties Dekat jquery.dataTables.min.js Eg; Tiada Rekod Ditemui  --}}
                                                <table id="" class="table table-bordered table-responsive-sm">
                                                    {{-- <thead bgcolor="#AED6F1" style="color:black;"> --}}
                                                    <thead class="thead-light" style="color:black;">
                                                        <tr>
                                                            {{-- <th><center>Bil.</center> </th> --}}
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Pembekal</center></th>
                                                            <th><center>Tarikh Mula</center></th>
                                                            <th><center>Tarikh Tamat</center></th>
                                                            <th><center>Kadar Sebulan (RM)</center></th>
                                                            <th><center>Jumlah Setahun (RM)</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>

                                                    {{-- Kira Jumlah Total --}}
                                                    <?php $total3 = 0 ?>
                                                    @foreach ($programs as $program3)
                                                        @if($program3->idJenisBelanja == 3)
                                                            <tbody>
                                                                <tr>
                                                                    {{-- <td>{{ $loop->iteration }} </td> --}}
                                                                    <td><center>{{ $program3->tujuanProgram }}</center></td>
                                                                    <td><center>{{ $program3->pembekal }}</center></td>
                                                                    <td><center>{{ Carbon\Carbon::parse($program3->tkhMula)->format('d.m.Y') }}</center> </td>
                                                                    <td><center>{{ Carbon\Carbon::parse($program3->tkhTamat)->format('d.m.Y') }}</center> </td>
                                                                    <td><center>RM {{ $program3->kosProgram }}</center></td>
                                                                    <td><center>RM {{ $program3->kosSetahun }}</center></td>
                                                                    <?php $total3 = $total3 + $program3->kosSetahun; ?>
                                                                    <td>
                                                                        <div class="d-flex justify-content-center">
                                                                            <a href="" title="Kemaskini" class="btn btn-sm btn-rounded btn-success" 
                                                                                data-toggle="modal" data-target="#modal-default3-{{ $program3->idProgramDirancang }}">
                                                                                <i class="fas fa-pen"></i>
                                                                            </a>
                                                                            <a href="{{ url('peruntukan/buangPPT/' . $program3->idProgramDirancang) }}"
                                                                                title="Buang" class="btn btn-sm btn-rounded btn-danger"><i
                                                                                    class="fas fa-trash"></i></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                        
                                                            </tbody>
                                                        @endif

                                                        @foreach ($programs as $program3)
                                                            {{-- MODAL3 --}}
                                                            <div class="modal fade" id="modal-default3-{{ $program3->idProgramDirancang }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header bg-purple">
                                                                        <h4 class="modal-title">KEMASKINI PERBELANJAAN PERUNTUKAN</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form class="form-horizontal" method="POST" action="{{ route('peruntukan.simpan_kemaskiniPPT', ['id1' => $program3->idPerancanganPerolehan , 'id2' => $program3->idProgramDirancang] ) }}" enctype="multipart/form-data" id="myForm2">
                                                                        {{ csrf_field() }}
                                                                        <div class="modal-body">
                                                                            
                                                                            <div class="form-group row">
                                                                                <label for="tujuanProgram3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <textarea class="form-control" name="tujuanProgram3" id="tujuanProgram2" 
                                                                                        cols="" rows="2">{{ $program3->tujuanProgram }}</textarea>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="pembekal3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Pembekal <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <input type="text" class="form-control" name="pembekal3" id="pembekal3" value="{{ $program3->pembekal }}">
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="tkhMula3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Mula <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Mula">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhMula3" id="tkhMula3" class="datepicker-default form-control"
                                                                                            value="{{ Carbon\Carbon::parse($program3->tkhMula)->format('d-m-Y') }}">
                                                                                        <div class="input-group-append" data-target="#tkhMula3" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                        <input type="date" class="form-control" id="tkhMula3" name="tkhMula3"  value="{{ Carbon\Carbon::parse($program3->tkhMula)->format('Y-m-d') }}" required >
                                                                                    </div>
                                                                                </div>
                            
                                                                                <label for="tkhTamat3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Tamat <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Tamat">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhTamat3" id="tkhTamat3" class="datepicker-default form-control" 
                                                                                            value="{{ Carbon\Carbon::parse($program3->tkhTamat)->format('d-m-Y') }}">
                                                                                        <div class="input-group-append" data-target="#tkhTamat3" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                        <input type="date" class="form-control" id="tkhTamat3" name="tkhTamat3"  value="{{ Carbon\Carbon::parse($program3->tkhTamat)->format('Y-m-d') }}" required >
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosProgram3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Kadar Sebulan <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <input type="number" class="form-control" name="kosProgram" id="kosProgram"> --}}
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosProgram3" id="kosProgram3" 
                                                                                            value="{{ $program3->kosProgram }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosSetahun3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Jumlah Setahun <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <input type="number" class="form-control" name="kosSetahun" id="kosSetahun"> --}}
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosSetahun3" id="kosSetahun3"
                                                                                            value="{{ $program3->kosSetahun }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                            
                                                                        </div>
                            
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                            {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                            <button type="submit" class="btn btn-success btn-sm" name="editData3">Kemaskini</button>
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL3 --}}
                                                        @endforeach

                                                        {{-- FOR TAMBAH --}}
                                                        @if($loop->last)
                                                            <tr>
                                                                <td colspan="6">
                                                                    <b class="float-right">Jumlah</b>
                                                                </td>
                                                                <td colspan="1">
                                                                    <center>
                                                                        <b>RM {{ $total3 }}</b>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7"> 
                                                                    <center>
                                                                        <button type="button"  title="Tambah" class="btn btn-sm btn-rounded float-right btn-primary" 
                                                                            data-toggle="modal" data-target="#modal-tambah3-{{ $program3->idPerancanganPerolehan }}"">
                                                                            <i class="fas fa-plus"></i> Tambah</button>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            {{-- MODAL3 TAMBAH--}}
                                                            <div class="modal fade" id="modal-tambah3-{{ $program3->idPerancanganPerolehan }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-purple">
                                                                            <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form class="form-horizontal" method="POST" action="{{ route('peruntukan.pengesahan_tambahPPT', ['id' => $program3->idPerancanganPerolehan] ) }}" enctype="multipart/form-data" id="myForm1">
                                                                            {{ csrf_field() }}
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="bahagian" value="{{ $program3->bahagian }}">

                                                                                <div class="form-group row">
                                                                                    <label for="tujuanProgram3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <textarea class="form-control" name="tujuanProgram3" id="tujuanProgram3" 
                                                                                            cols="" rows="2" required></textarea>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="pembekal3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Pembekal <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <input type="text" class="form-control" name="pembekal3" id="pembekal3" value="" required>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="tkhMula3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Mula <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Mula">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input type="text" name="tkhMula3" id="tkhMula3" class="datepicker-default form-control"
                                                                                                value="" required>
                                                                                            <div class="input-group-append" data-target="#tkhMula2" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                            <input type="date" class="form-control" id="tkhMula3" name="tkhMula3"  value="" required >
                                                                                        </div>
                                                                                    </div>
                                
                                                                                    <label for="tkhTamat3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Tamat <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Tamat">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input type="text" name="tkhTamat3" id="tkhTamat3" class="datepicker-default form-control" 
                                                                                                value="" required>
                                                                                            <div class="input-group-append" data-target="#tkhTamat3" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                            <input type="date" class="form-control" id="tkhTamat3" name="tkhTamat3"  value="" required >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosProgram3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Kadar Sebulan <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        {{-- <input type="number" class="form-control" name="kosProgram" id="kosProgram"> --}}
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosProgram3" id="kosProgram3" 
                                                                                                value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosSetahun3" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Jumlah Setahun <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        {{-- <input type="number" class="form-control" name="kosSetahun" id="kosSetahun"> --}}
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosSetahun3" id="kosSetahun3"
                                                                                                value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                
                                                                
                                                                            </div>
                                
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                                {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                                <button type="submit" class="btn btn-primary btn-sm" name="tambahPPT3"><i class="fas fa-plus"></i> Tambah</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL1 --}}
                                                        @endif
                                                        {{-- FOR TAMBAH --}}

                                                    @endforeach 
                                                </table>
                                                <!-- /.card-body -->
                                            </div>

                                            <h4>Utiliti</h4>
                                            <div class="card-body table-responsive">
                                                {{-- Nak Ubah Properties Dekat jquery.dataTables.min.js Eg; Tiada Rekod Ditemui  --}}
                                                <table id="" class="table table-bordered table-responsive-sm">
                                                    {{-- <thead bgcolor="#AED6F1" style="color:black;"> --}}
                                                    <thead class="thead-light" style="color:black;">
                                                        <tr>
                                                           {{-- <th><center>Bil.</center> </th> --}}
                                                           <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                           <th><center>Pembekal</center></th>
                                                           <th><center>Tarikh Mula</center></th>
                                                           <th><center>Tarikh Tamat</center></th>
                                                           <th><center>Kadar Sebulan (RM)</center></th>
                                                           <th><center>Jumlah Setahun (RM)</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>
        
                                                    {{-- Kira Jumlah Total --}}
                                                    <?php $total4 = 0 ?>
                                                    @foreach ($programs as $program4)
                                                        @if($program4->idJenisBelanja == 4)
                                                            <tbody>
                                                                    <tr>
                                                                        {{-- <td>{{ $loop->iteration }} </td> --}}
                                                                        <td><center>{{ $program4->tujuanProgram }}</center></td>
                                                                        <td><center>{{ $program4->pembekal }}</center></td>
                                                                        <td><center>{{ Carbon\Carbon::parse($program4->tkhMula)->format('d.m.Y') }}</center> </td>
                                                                        <td><center>{{ Carbon\Carbon::parse($program4->tkhTamat)->format('d.m.Y') }}</center> </td>
                                                                        <td><center>RM {{ $program4->kosProgram }}</center></td>
                                                                        <td><center>RM {{ $program4->kosSetahun }}</center></td>
                                                                        <?php $total4 = $total4 + $program4->kosSetahun; ?>
                                                                        <td>
                                                                            <div class="d-flex justify-content-center">
                                                                                <a href="" title="Kemaskini" class="btn btn-sm btn-rounded btn-success" 
                                                                                    data-toggle="modal" data-target="#modal-default4-{{ $program4->idProgramDirancang }}">
                                                                                    <i class="fas fa-pen"></i>
                                                                                </a>
                                                                                <a href="{{ url('peruntukan/buangPPT/' . $program4->idProgramDirancang) }}"
                                                                                    title="Buang" class="btn btn-sm btn-rounded btn-danger"><i
                                                                                        class="fas fa-trash"></i></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                            
                                                            </tbody>
                                                        @endif

                                                        @foreach ($programs as $program4)
                                                            {{-- MODAL4 --}}
                                                            <div class="modal fade" id="modal-default4-{{ $program4->idProgramDirancang }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header bg-purple">
                                                                        <h4 class="modal-title">KEMASKINI PERBELANJAAN PERUNTUKAN</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form class="form-horizontal" method="POST" action="{{ route('peruntukan.simpan_kemaskiniPPT', ['id1' => $program4->idPerancanganPerolehan , 'id2' => $program4->idProgramDirancang] ) }}" enctype="multipart/form-data" id="myForm2">
                                                                        {{ csrf_field() }}
                                                                        <div class="modal-body">
                                                                            
                                                                            <div class="form-group row">
                                                                                <label for="tujuanProgram4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <textarea class="form-control" name="tujuanProgram4" id="tujuanProgram2" 
                                                                                        cols="" rows="2">{{ $program4->tujuanProgram }}</textarea>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="pembekal4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Pembekal <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <input type="text" class="form-control" name="pembekal4" id="pembekal4" value="{{ $program4->pembekal }}">
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="tkhMula4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Mula <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Mula">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhMula4" id="tkhMula4" class="datepicker-default form-control"
                                                                                            value="{{ Carbon\Carbon::parse($program4->tkhMula)->format('d-m-Y') }}">
                                                                                        <div class="input-group-append" data-target="#tkhMula4" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                        <input type="date" class="form-control" id="tkhMula4" name="tkhMula4"  value="{{ Carbon\Carbon::parse($program4->tkhMula)->format('Y-m-d') }}" required >
                                                                                    </div>
                                                                                </div>
                            
                                                                                <label for="tkhTamat4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tarikh Tamat <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group date" id="" data-target-input="nearest"
                                                                                        placeholder="Tarikh Tamat">
                                                                                        {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                value="{{ old('tkh_mula') }}" required /> --}}
                                                                                        {{-- <input type="text" name="tkhTamat4" id="tkhTamat4" class="datepicker-default form-control" 
                                                                                            value="{{ Carbon\Carbon::parse($program4->tkhTamat)->format('d-m-Y') }}">
                                                                                        <div class="input-group-append" data-target="#tkhTamat4" data-toggle="datetimepicker">
                                                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                        </div> --}}
                                                                                        <input type="date" class="form-control" id="tkhTamat4" name="tkhTamat4"  value="{{ Carbon\Carbon::parse($program4->tkhTamat)->format('Y-m-d') }}" required >
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosProgram4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Kadar Sebulan <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <input type="number" class="form-control" name="kosProgram" id="kosProgram"> --}}
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosProgram4" id="kosProgram4" 
                                                                                            value="{{ $program4->kosProgram }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosSetahun4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Jumlah Setahun <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <input type="number" class="form-control" name="kosSetahun" id="kosSetahun"> --}}
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosSetahun4" id="kosSetahun4"
                                                                                            value="{{ $program4->kosSetahun }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                            
                                                                        </div>
                            
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                            {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                            <button type="submit" class="btn btn-success btn-sm" name="editData4" >Kemaskini</button>
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL3 --}}
                                                        @endforeach

                                                        {{-- FOR TAMBAH --}}
                                                        @if($loop->last)
                                                            <tr>
                                                                <td colspan="6">
                                                                    <b class="float-right">Jumlah</b>
                                                                </td>
                                                                <td colspan="1">
                                                                    <center>
                                                                        <b>RM {{ $total4 }}</b>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7"> 
                                                                    <center>
                                                                        <button type="button"  title="Tambah" class="btn btn-sm btn-rounded btn-primary float-right" 
                                                                            data-toggle="modal" data-target="#modal-tambah4-{{ $program4->idPerancanganPerolehan }}"">
                                                                            <i class="fas fa-plus"></i> Tambah</button>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            {{-- MODAL4 TAMBAH--}}
                                                            <div class="modal fade" id="modal-tambah4-{{ $program4->idPerancanganPerolehan }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-purple">
                                                                            <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form class="form-horizontal" method="POST" action="{{ route('peruntukan.pengesahan_tambahPPT', ['id' => $program4->idPerancanganPerolehan] ) }}" enctype="multipart/form-data" id="myForm1">
                                                                            {{ csrf_field() }}
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="bahagian" value="{{ $program4->bahagian }}">

                                                                                <div class="form-group row">
                                                                                    <label for="tujuanProgram4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <textarea class="form-control" name="tujuanProgram4" id="tujuanProgram4" 
                                                                                            cols="" rows="2" required></textarea>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="pembekal4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Pembekal <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <input type="text" class="form-control" name="pembekal4" id="pembekal4" value="" required>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="tkhMula4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Mula <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Mula">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input type="text" name="tkhMula4" id="tkhMula4" class="datepicker-default form-control"
                                                                                                value="" required>
                                                                                            <div class="input-group-append" data-target="#tkhMula4" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                            <input type="date" class="form-control" id="tkhMula4" name="tkhMula4"  value="" required >
                                                                                        </div>
                                                                                    </div>
                                
                                                                                    <label for="tkhTamat4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tarikh Tamat <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group date" id="" data-target-input="nearest"
                                                                                            placeholder="Tarikh Tamat">
                                                                                            {{-- <input type="text" id="tkh_pergi" name="tkh_mula"
                                                                                                    class="form-control datetimepicker-input" data-target="#tkh_mula"
                                                                                                    value="{{ old('tkh_mula') }}" required /> --}}
                                                                                            {{-- <input type="text" name="tkhTamat4" id="tkhTamat4" class="datepicker-default form-control" 
                                                                                                value="" required>
                                                                                            <div class="input-group-append" data-target="#tkhTamat4" data-toggle="datetimepicker">
                                                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                                            </div> --}}
                                                                                            <input type="date" class="form-control" id="tkhTamat4" name="tkhTamat4"  value="" required >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosProgram4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Kadar Sebulan <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        {{-- <input type="number" class="form-control" name="kosProgram" id="kosProgram"> --}}
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosProgram4" id="kosProgram4" 
                                                                                                value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosSetahun4" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Jumlah Setahun <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        {{-- <input type="number" class="form-control" name="kosSetahun" id="kosSetahun"> --}}
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosSetahun4" id="kosSetahun4"
                                                                                                value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                
                                                                
                                                                            </div>
                                
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                                {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                                <button type="submit" class="btn btn-primary btn-sm" name="tambahPPT4"><i class="fas fa-plus"></i> Tambah</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL4 --}}
                                                        @endif
                                                        {{-- FOR TAMBAH --}}

                                                    @endforeach    
                                                </table>
                                                <!-- /.card-body -->
                                            </div>
                                             
                                            <h4>Keperluan Harta Modal Di Bawah Aktiviti One-Off Harta Modal</h4>
                                            <div class="card-body table-responsive">
                                                {{-- Nak Ubah Properties Dekat jquery.dataTables.min.js Eg; Tiada Rekod Ditemui  --}}
                                                <table id="" class="table table-bordered table-responsive-sm">
                                                    {{-- <thead bgcolor="#AED6F1" style="color:black;"> --}}
                                                    <thead class="thead-light" style="color:black;">
                                                        <tr>
                                                            {{-- <th><center>Bil.</center> </th> --}}
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Jenis Perkara One-Off</center></th>
                                                            <th><center>Kuantiti</center></th>
                                                            <th><center>Harga Seunit (RM)</center></th>
                                                            <th><center>Jumlah Kos (RM)</center></th>
                                                            <th><center>Justifikasi Pembelian</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>

                                                    {{-- Kira Jumlah Total --}}
                                                    <?php $total5 = 0 ?>
                                                    @foreach ($programs as $program5)
                                                        @if($program5->idJenisBelanja == 5)
                                                            <tbody>
                                                                    <tr>
                                                                        {{-- <td>{{ $loop->iteration }} </td> --}}
                                                                        <td><center>{{ $program5->tujuanProgram }}</center></td>
                                                                        <?php 
                                                                            if($program5->idJenisPerkaraOneOff == 1){ $nameOneOff = 'Baru'; } 
                                                                            else if($program5->idJenisPerkaraOneOff == 2){ $nameOneOff = 'Tambahan'; } 
                                                                            else if($program5->idJenisPerkaraOneOff == 3){ $nameOneOff = 'Ganti'; }
                                                                        ?>
                                                                        <td><center>{{ $nameOneOff }}</center></td>
                                                                        <td><center>{{ $program5->quantityOneOff }}</center></td>
                                                                        <td><center>{{ $program5->kosProgram }}</center></td>
                                                                        <?php
                                                                            $jumlahKos = $program5->quantityOneOff * $program5->kosProgram;
                                                                            $total5 = $total5 + $jumlahKos;
                                                                        ?>
                                                                        <td><center>{{ $jumlahKos }}</center></td>
                                                                        <td><center>{{ $program5->justifikasi }}</center></td>
                                                                        <td>
                                                                            <div class="d-flex justify-content-center">
                                                                                <a href="" title="Kemaskini" class="btn btn-sm btn-rounded btn-success" 
                                                                                    data-toggle="modal" data-target="#modal-default5-{{ $program5->idProgramDirancang }}">
                                                                                    <i class="fas fa-pen"></i>
                                                                                </a>
                                                                                <a href="{{ url('peruntukan/buangPPT/' . $program5->idProgramDirancang) }}"
                                                                                    title="Buang" class="btn btn-sm btn-rounded btn-danger"><i
                                                                                        class="fas fa-trash"></i></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                            
                                                            </tbody>
                                                        @endif

                                                        @foreach($programs as $program5)
                                                            {{-- MODAL5 --}}
                                                            <div class="modal fade" id="modal-default5-{{ $program5->idProgramDirancang }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header bg-purple">
                                                                        <h4 class="modal-title">KEMASKINI PERBELANJAAN PERUNTUKAN</h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form class="form-horizontal" method="POST" action="{{ route('peruntukan.simpan_kemaskiniPPT', ['id1' => $program5->idPerancanganPerolehan , 'id2' => $program5->idProgramDirancang] ) }}" enctype="multipart/form-data" id="myForm5">
                                                                        {{ csrf_field() }}
                                                                        <div class="modal-body">
                                                                            
                                                                            <div class="form-group row">
                                                                                <label for="tujuanProgram5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <textarea class="form-control" name="tujuanProgram5" id="tujuanProgram5" 
                                                                                        cols="" rows="2">{{ $program5->tujuanProgram }}</textarea>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="jenis_OneOff5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Jenis Perkara One-Off <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <select class="default-select" id="jenis_OneOff" name="jenis_OneOff"
                                                                                    <select id="single-select" name="bahagian"
                                                                                        style="width:100%; text-align:left;">
                                                                                        <option value=""
                                                                                            @if (old('jenis_OneOff') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                                                        </option>
                                                                                        <option value="9"> Hello</option>
                                                                                        @foreach ($OptOneOff as $optO)
                                                                                            <option value="{{ $optO->idJenisPerkaraOneOff }}"
                                                                                                @if (old('jenis_OneOff') == $optO->idJenisPerkaraOneOff) {{ 'selected="selected"' }} @endif>
                                                                                                {{ $optO->perkaraOneOff }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select> --}}
                                                                                    
                                                                                    <select class="select2-with-label-single js-states d-block" id="jenis_OneOff5" name="jenis_OneOff5"
                                                                                        style="width: 100%;">
                                                                                        @php old('jenis_OneOff5') == NULL ? $pro5=$program5->idJenisPerkaraOneOff : $pro5=old('jenis_OneOff5') @endphp
                                                                                        {{-- <option value=""
                                                                                            @if ($pro5 == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                                                        </option> --}}
                                                                                        @foreach ($OptOneOff as $optO)
                                                                                            <option value="{{ $optO->idJenisPerkaraOneOff }}"
                                                                                                @if ($pro5 == $optO->idJenisPerkaraOneOff) {{ 'selected="selected"' }} @endif>
                                                                                                {{ $optO->perkaraOneOff }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kuantiti5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Kuantiti <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-3">
                                                                                    {{-- <input type="text" class="form-control"> --}}
                                                                                    <input type="number" class="form-control" name="kuantiti5" id="kuantiti5"
                                                                                        value="{{ $program5->quantityOneOff }}">
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="kosProgram5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Harga Seunit (Anggaran) <font color="red">*</font>
                                                                                </label>
                                                                                {{-- <div class="col-sm-3">
                                                                                    <input type="number" class="form-control" name="kosProgram" id="kosProgram">
                                                                                </div> --}}
                                                                                <div class="col-sm-3">
                                                                                    <div class="input-group input-secondary">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">RM</span>
                                                                                        </div>
                                                                                        <input type="number" class="form-control" name="kosProgram5" id="kosProgram5"
                                                                                            value="{{ $program5->kosProgram }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                            
                                                                            <div class="form-group row">
                                                                                <label for="justifikasi5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                    Justifikasi Pembelian/(Spesifikasi Khusus) <font color="red">*</font>
                                                                                </label>
                                                                                <div class="col-sm-9">
                                                                                    <textarea class="form-control" name="justifikasi5" id="justifikasi5" 
                                                                                        cols="" rows="2">{{ $program5->justifikasi }}</textarea>
                                                                                </div>
                                                                            </div>
                                                            
                                                                        </div>
                            
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                            {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                            <button type="submit" class="btn btn-success btn-sm" name="editData5">Kemaskini</button>
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL5 --}}
                                                        @endforeach

                                                        {{-- FOR TAMBAH --}}
                                                        @if($loop->last)
                                                            <tr>
                                                                <td colspan="6">
                                                                    <b class="float-right">Jumlah</b>
                                                                </td>
                                                                <td colspan="1">
                                                                    <center>
                                                                        <b>RM {{ $total5 }}</b>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7"> 
                                                                    <center>
                                                                        <button type="button"  title="Tambah" class="btn btn-sm btn-rounded btn-primary float-right" 
                                                                            data-toggle="modal" data-target="#modal-tambah5-{{ $program5->idPerancanganPerolehan }}"">
                                                                            <i class="fas fa-plus"></i> Tambah</button>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            {{-- MODAL5 TAMBAH--}}
                                                            <div class="modal fade" id="modal-tambah5-{{ $program5->idPerancanganPerolehan }}">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-purple">
                                                                            <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form class="form-horizontal" method="POST" action="{{ route('peruntukan.pengesahan_tambahPPT', ['id' => $program5->idPerancanganPerolehan] ) }}" enctype="multipart/form-data" id="myForm1">
                                                                            {{ csrf_field() }}
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="bahagian" value="{{ $program5->bahagian }}">
                                                                                
                                                                                <div class="form-group row">
                                                                                    <label for="tujuanProgram5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <textarea class="form-control" name="tujuanProgram5" id="tujuanProgram5" 
                                                                                            cols="" rows="2" required></textarea>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="jenis_OneOff5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Jenis Perkara One-Off <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        <select class="select2-with-label-single js-states d-block" id="jenis_OneOff5" name="jenis_OneOff5"
                                                                                        {{-- <select id="single-select" name="bahagian" --}}
                                                                                            style="width:100%; text-align:left;" required>
                                                                                            <option value="0" selected disabled>&nbsp;</option>
                                                                                            @foreach ($OptOneOff as $optO)
                                                                                                <option value="{{ $optO->idJenisPerkaraOneOff }}">
                                                                                                    {{ $optO->perkaraOneOff }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kuantiti5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Kuantiti <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-3">
                                                                                        {{-- <input type="text" class="form-control"> --}}
                                                                                        <input type="number" class="form-control" name="kuantiti5" id="kuantiti5"
                                                                                            value="" required>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="kosProgram5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Harga Seunit (Anggaran) <font color="red">*</font>
                                                                                    </label>
                                                                                    {{-- <div class="col-sm-3">
                                                                                        <input type="number" class="form-control" name="kosProgram" id="kosProgram">
                                                                                    </div> --}}
                                                                                    <div class="col-sm-3">
                                                                                        <div class="input-group input-secondary">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">RM</span>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" name="kosProgram5" id="kosProgram5"
                                                                                                value="" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                
                                                                                <div class="form-group row">
                                                                                    <label for="justifikasi5" class="col-sm-3 col-form-label" style="text-align:left">
                                                                                        Justifikasi Pembelian/(Spesifikasi Khusus) <font color="red">*</font>
                                                                                    </label>
                                                                                    <div class="col-sm-9">
                                                                                        <textarea class="form-control" name="justifikasi5" id="justifikasi5" 
                                                                                            cols="" rows="2" required></textarea>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                
                                                                            <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                                                {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                                <button type="submit" class="btn btn-primary btn-sm" name="tambahPPT5"><i class="fas fa-plus"></i> Tambah</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            {{-- MODAL4 --}}
                                                        @endif
                                                        {{-- FOR TAMBAH --}}
                                                    @endforeach 
                                                </table>
                                                <!-- /.card-body -->
                                            </div>

                                    
                                                                      
                                    <div class=" justify-content-center">
                                        {{-- <a href="{{ url('/peruntukan/pengesahan') }}" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                                class="fa fa-paper-plane"></i> |
                                                Hantar
                                        </a> --}}
                                        {{-- <button type="button" class="btn btn-primary" id="getDatetimeButton">Hantarss</button> --}}
                                        <form method="POST" action="{{ route('peruntukan.pengesahan_ppt', $perancangan->idPerancanganPerolehan ) }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                                    
                                            @if( session('pengesahan'))
                                                <button type="submit" name="selesaiPengesahan" class="btn btn-success float-right btn-sm">
                                                    <i class="fa fa-check" aria-hidden="true"></i> | Selesai
                                                </button>
                                            @elseif ( session('kemaskini'))
                                                <button type="submit" name="selesaiKemaskini" class="btn btn-success float-right btn-sm">
                                                    <i class="fa fa-check" aria-hidden="true"></i> | Selesai
                                                </button>
                                            @endif
                                            
                                            <button type="submit" name="batalPengesahan" class="btn btn-danger float-right btn-sm">
                                                <i class="fas fa-ban"></i> | Batal
                                            </button>
                                            <button type="button" class="btn btn-secondary float-left btn-sm" onclick="history.back();">
                                                <i class="fas fa-redo-alt"></i> | Kembali
                                            </button>
                                        </form>
                                    </div>

        
    
                                
    
                            </div>
                        </div> 
    
                    </div>
                </div>
    
            </div>

		</div>
    <!--**********************************
                Content body end
            ***********************************-->


        <!--**********************************
                Javascript section start
            ***********************************-->
    
@endsection
