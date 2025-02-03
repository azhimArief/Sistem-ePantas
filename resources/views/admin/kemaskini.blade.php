@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                        Content body start
                        ***********************************-->
    @if($errors->has('nama_program'))
        <style>
            #nama_program {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ($errors->has('tujuan'))
        <style>
            #tujuan {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ($errors->has('latarBelakang'))
        <style>
            #latarBelakang {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    {{-- @if ( $errors->has('objektif1') && $errors->has('objektif2') && $errors->has('objektif3')) --}}
    @if ( $errors->has('objektif1') )
        <style>
            #objektifButton {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ( $errors->has('perancangan'))
        <style>
            #perancangan {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ( $errors->has('tkh_mula'))
        <style>
            #tkh_mula {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ( $errors->has('tkh_tamat'))
        <style>
            #tkh_tamat {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ( $errors->has('pengesah'))
        <style>
            .select2-container--default .select2-selection--single.error {
                border: 2px solid red; /* Red border */
            }
        </style>
    @endif
    @if ( $errors->has('kos_mohon'))
        <style>
            #votButton {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ( $errors->has('syor'))
        <style>
            #syor {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    @if ( $errors->has('dokumen'))
        <style>
            #dokumen {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif
    <style>
        .table thead th {
            border-bottom-width: 1px;
            text-transform: capitalize;
            /* text-transform: uppercase; */
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-color: #EEEEEE;
            color: black;
            background-color: lightblue;
        }
        @media (max-width: 768px) {
            #arahan {
                display: none;
            }
        }

        /* TOOLTIP */
            .tooltip-text {
                visibility: hidden;
                position: absolute;
                z-index: 1;
                width: 180px;
                color: rgb(0, 0, 0);
                font-size: 13px;
                background-color: #51aeff;
                border-radius: 10px;
                padding: 10px 15px 10px 15px;
                }

                .tooltip-text-latarBelakang {
                visibility: hidden;
                position: absolute;
                z-index: 1;
                width: 180px;
                color: rgb(0, 0, 0);
                font-size: 13px;
                background-color: #51aeff;
                border-radius: 10px;
                padding: 10px 15px 10px 15px;
                }

                .hover-text:hover .tooltip-text {
                visibility: visible;
                }
                .hover-text-latarBelakang:hover .tooltip-text {
                visibility: visible;
                }

                #right {
                top: -8px;
                left: 120%;
                }

                .hover-text {
                color: #51aeff;
                position: relative;
                display: inline-block;
                /* margin: 40px; */
                text-align: center;
                }

                .hover-text-latarBelakang {
                color: #51aeff;
                position: relative;
                display: inline-block;
                /* margin: 40px; */
                text-align: left;
                }
            /* TOOLTIP */

            .card {
                height: auto !important; /* Reset to auto */
            }
    </style>

    <div class="content-body">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                    {{-- <i class="fa fa-check" aria-hidden="true"></i> --}}
                    {{ session('status') }}
                </div>
            @elseif(session('failed'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> --}}
                    {{ session('failed') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Sila lengkapkan borang dengan lengkap. --}}
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    Sila pastikan borang telah dilengkapkan dengan teliti dan lengkap.
                    {{-- <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul> --}}
                </div>
            @endif
        </div>

        <div class="container-fluid">
            <div class="col-xl-13 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h4 class="card-title">Kemaskini Peruntukan</h4> --}}
                        <h3 class="font-w600 title mb-2 mr-auto">Kemaskini Permohonan Peruntukan</h3>
                        <font color="red" name="arahan" id="arahan"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; Sila pastikan semua yang bertanda * diisi.</font> &nbsp;

                        <?php
                            $status = $maklumats->id_status;
                            $color = ""; 
                            switch($status){
                            //permohonan baru
                            case "1": $color="#2C87F0"; $status="Status : Permohonan Baru"; /*$badge="badge badge-secondary light";*/ $badge="badge badge-rounded badge-secondary badge-lg"; break; //biru
                            //telah dikemaskini
                            case "2": $color="#FFB300"; $status="Status : Dalam Proses"; break; //kuning
                            //lulus
                            case "9":  $color="#32CD32"; $status="Status : Lulus"; /*$badge="badge badge-success light";*/ $badge="badge badge-rounded badge-success badge-lg"; break; //hijau
                            //Tidak Diluluskan
                            case "10": $color="#FF0000"; $status="Status : Tidak Diluluskan"; /*$badge="badge badge-danger light";*/ $badge="badge badge-rounded badge-danger badge-lg"; break; //merah
                            //semak semula
                            case "11": $color="#FFB300"; $status="Status : Semak Semula"; /*$badge="badge badge-warning light";*/ $badge="badge badge-rounded badge-warning badge-lg"; break; //biru
                            case "22": $color="#FFB300"; $status="Status : Semak Semula"; /*$badge="badge badge-warning light";*/ $badge="badge badge-rounded badge-warning badge-lg"; break; //biru
                            //Draft
                            case "12": $color="#FFB300"; $status="Status : Draf"; /*$badge="badge badge-warning light";*/ $badge="badge badge-rounded badge-primary badge-lg text-white"; break; //biru
                            //batal
                            case "8": $color="#CC3300"; $status="Status : Batal"; /*$badge="badge badge-danger light";*/ $badge="badge badge-rounded badge-danger badge-lg";  break; //merah pekat
                            //sah
                            case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                            case '13':
                                $color = '#FFFFFF';
                                $status = 'Status : Ada Peruntukan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '14':
                                $color = '#FFFFFF';
                                $status = 'Status : Tiada Peruntukan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-danger badge-lg';
                                break; //merah pekat
                            case '15':
                                $color = '#FFFFFF';
                                $status = 'Status : Disokong';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '16':
                                $color = '#FFFFFF';
                                $status = 'Status : Tidak Disokong';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-danger badge-lg';
                                break; //merah pekat
                            case '17':
                                $color = '#FFFFFF';
                                $status = 'Status : Disyorkan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat SUBK
                            case '18':
                                $color = '#FFFFFF';
                                $status = 'Status : Tidak Disyorkan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-danger badge-lg';
                                break; //merah pekat SUBK
                            case '19':
                                $color = '#FFFFFF';
                                $status = 'Status : Disyorkan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '20':
                                $color = '#FFFFFF';
                                $status = 'Status : Dikemaskini'; //to Pengesah
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '21':
                                $color = '#FFFFFF';
                                $status = 'Status : Dikemaskini'; //to Pentadbir
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-secondary badge-lg text-white';
                                break; //merah pekat
                            //Banyak Banyak
                            default : $color="#000000";
                            }
                        ?>
                        <span class="{{ $badge }}" style="color: white;"> {{ $status }}</span>
                    </div>
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                    <div class="card-body">
                        
                        <div class="basic-form">
                            
                            <form method="POST" name="kemaskiniForm" id="kemaskiniForm" action="{{ route('peruntukan.simpanK', $maklumats->idMaklumatPermohonan) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                <div class="default-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link @if ( !$errors->any() && !session('status') ){ active } @endif" data-toggle="tab" href="#pemohon"><i
                                            {{-- <a class="nav-link active" data-toggle="tab" href="#pemohon"><i --}}
                                                    class="fa fa-user-o nr-2"></i>&nbsp; Maklumat Pemohon</a>
                                            {{-- class="fa fa-plus mr-2"></i> Maklumat Pemohon</a> --}}
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if ( $errors->any() || session('status') ){ active } @endif " data-toggle="tab" href="#maklumat"><i
                                                    class="flaticon-381-list"></i>&nbsp;&nbsp; Maklumat Permohonan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        {{-- MAKLUMAT PEMOHON --}}
                                        <div class="tab-pane fade @if ( !$errors->any() && !session('status') ){ show active } @endif" id="pemohon" role="tabpanel">
                                            <br>
                                            <br>

                                            <div class="form-group row">
                                                <label for="nama" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Nama
                                                    Pegawai </label>
                                                <div class="input-group col-sm-9 ">
                                                    <input type="text" class="form-control" id="nama" name="nama"
                                                        value="{{ $user->nama ?? '-' }}" readonly placeholder=" - ">
                                                    {{-- value="{{ $personel->name }}" readonly placeholder="Nama Pegawai"> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="jawatan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Jawatan
                                                </label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="jawatan" name="jawatan"
                                                        placeholder=" - " value="{{ $user->jawatan ?? '-' }}" readonly="readonly">
                                                    {{-- placeholder="Jawatan" value="{{ $personel->jawatan }}" readonly="readonly"> --}}
                                                </div>

                                                <label for="gred" class="col-sm-1 col-form-label" style="">Gred
                                                </label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="gred" name="gred"
                                                        placeholder=" - " value="{{ $user->gred ?? '-' }}" readonly="readonly">
                                                    {{-- placeholder="Gred" value="{{ $personel->gred }}" readonly="readonly"> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="agensi" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Agensi
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="agensi"
                                                        name="agensi" placeholder=" - " value="{{ $user->agensi ?? '-' }}"
                                                        readonly>
                                                    {{-- value="{{ $personel->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : old('bahagian') }}" readonly> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="bahagian" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Bahagian
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="bahagian"
                                                        name="bahagian" placeholder=" - " value="{{ $user->bahagian ?? '-' }}"
                                                        readonly>
                                                    {{-- value="{{ $personel->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : old('bahagian') }}" readonly> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="emel" class="col-sm-3 col-form-label"
                                                    style="text-align:left">E-mel
                                                    {{-- <font color="red">*</font>  --}}
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="emel" name="emel"
                                                        placeholder=" - " value="{{ $user->email ?? '-' }}" readonly>
                                                    {{-- value="{{ $personel->email }}"> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tel_pejabat" class="col-sm-3 col-form-label"
                                                    style="text-align:left">No.
                                                    Telefon Pejabat
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="tel_pejabat"
                                                        name="tel_pejabat" placeholder=" - "
                                                        value="{{ $user->tel_pejabat ?? old('tel_pejabat') }}">
                                                    {{-- placeholder=" - " value="{{ $personel->tel }}"> --}}
                                                </div>

                                                <label for="tel_bimbit" class="col-sm-3 col-form-label"
                                                    style="text-align:left">No.
                                                    Telefon Bimbit <font color="red">*</font> </label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="telefon"
                                                        name="telefon" placeholder=" - " value="{{ $user->telefon ??  old('telefon') }}">
                                                    {{-- placeholder=" - " value="{{ $personel->tel_bimbit }}"> --}}
                                                </div>
                                            </div>

                                            <div class=" justify-content-center">
                                                <a href="{{ url('peruntukan/senarai/') }}"
                                                    class="btn btn-secondary float-left btn-sm" style="color: black;">
                                                    <i class="fas fa-redo-alt"></i> | Kembali
                                                </a>
                                            </div>

                                        </div>

                                        {{-- MAKLUMAT PERMOHONAN --}}
                                        <div class="tab-pane fade @if ( $errors->any() || session('status') ){ show active } @endif" id="maklumat">
                                            <br>
                                            <br>

                                            <div class="form-group row">
                                                <label for="nama_program" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Tajuk Permohonan 
                                                        <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    {{-- <input type="text" class="form-control"> --}}
                                                    @error('nama_program') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    <textarea class="form-control" name="nama_program" id="nama_program" cols="" rows="2"
                                                        value="{{ $maklumats->namaProgram ?? old('nama_program') }}">{{ $maklumats->namaProgram ?? old('nama_program') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tujuan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Tujuan
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="card">
                                                        <div class="card-header" id="tujuan-heading">
                                                            <h4>Senarai Tujuan</h4>
                                                            {{-- <button id="add-tujuan" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Tujuan</button> --}}
                                                        </div>
                                                        <div class="card-body" id="tujuan-body" style="max-height: 300px; overflow-y: auto;">
                                                            <ul id="tujuan-list" class="list-group"></ul>
                                                        </div>
                                                        @error('tujuan') <div class="text-danger text-strong">{{ $message }} <br></div> @enderror
                                                        <textarea class="form-control summernote" name="tujuan" id="tujuan" cols="" rows="2"></textarea> 
                                                        {{-- value="{{ $maklumats->tujuanProgram ?? old('tujuan') }}">{{ $maklumats->tujuanProgram ?? old('tujuan') }} --}}
                                                        {{-- <div class="card-footer"> --}}
                                                        <button id="add-tujuan" class="btn btn-sm btn-primary float-right" ><i class="fa fa-plus"></i> Tambah Tujuan</button>
                                                        {{-- </div> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="latarBelakang" class="col-sm-3 col-form-label" style="text-align:left">Latar Belakang
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="card">
                                                        <div class="card-header" id="latarBelakang-heading">
                                                            <h4>Senarai Latar Belakang</h4>
                                                            {{-- <button id="add-latarBelakang" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Latar Belakang</button> --}}
                                                        </div>
                                                        <div class="card-body" id="latarBelakang-body" style="max-height: 300px; overflow-y: auto;">
                                                            <ul id="latarBelakang-list" class="list-group"></ul>
                                                        </div>
                                                        @error('latarBelakang')<div class="text-danger text-strong">{{ $message }} <br></div> @enderror
                                                        <textarea class="form-control summernote" name="latarBelakang" id="latarBelakang" cols="" rows="2"></textarea>
                                                        <button id="add-latarBelakang" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Tambah Latar Belakang</button>
                                                    </div>
                                            
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="dasarSemasa" class="col-sm-3 col-form-label" style="text-align:left">Dasar Semasa
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="card">
                                                        <div class="card-header" id="dasarSemasa-heading">
                                                            <h4>Senarai Dasar Semasa</h4>
                                                            {{-- <button id="add-dasarSemasa" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Dasar Semasa</button> --}}
                                                        </div>
                                                        <div class="card-body" id="dasarSemasa-body" style="max-height: 300px; overflow-y: auto;">
                                                            <ul id="dasarSemasa-list" class="list-group"></ul>
                                                        </div>
                                                        @error('dasarSemasa') <div class="text-danger text-strong">{{ $message }} <br></div> @enderror
                                                        <textarea class="form-control summernote" name="dasarSemasa" id="dasarSemasa" cols="" rows="2"></textarea>
                                                        <button id="add-dasarSemasa" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Dasar Semasa</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="justifikasiPermohonan" class="col-sm-3 col-form-label" style="text-align:left">Justifikasi Permohonan
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="card">
                                                        <div class="card-header" id="justifikasiPermohonan-heading">
                                                            <h4>Senarai Justifikasi Permohonan</h4>
                                                            {{-- <button id="add-justifikasiPermohonan" class="btn   btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Justifikasi Permohonan</button> --}}
                                                        </div>
                                                        <div class="card-body" id="justifikasiPermohonan-body" style="max-height: 300px; overflow-y: auto;">
                                                            <ul id="justifikasiPermohonan-list" class="list-group"></ul>
                                                        </div>
                                                        @error('justifikasiPermohonan') <div class="text-danger text-strong">{{ $message }} <br></div> @enderror
                                                        <textarea class="form-control summernote" name="justifikasiPermohonan" id="justifikasiPermohonan" cols="" rows="2"></textarea>
                                                        <button id="add-justifikasiPermohonan" class="btn   btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Justifikasi Permohonan</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="ulasanBahagian" class="col-sm-3 col-form-label" style="text-align:left">Ulasan Bahagian
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="card">
                                                        <div class="card-header"  id="ulasanBahagian-heading">
                                                            <h4>Senarai Ulasan Bahagian</h4>
                                                            {{-- <button id="add-ulasanBahagian" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Ulasan Bahagian</button> --}}
                                                        </div>
                                                        <div class="card-body" id="ulasanBahagian-body" style="max-height: 300px; overflow-y: auto;">
                                                            <ul id="ulasanBahagian-list" class="list-group"></ul>
                                                        </div>
                                                        @error('ulasanBahagian') <div class="text-danger text-strong">{{ $message }} <br></div> @enderror
                                                        <textarea class="form-control summernote" name="ulasanBahagian" id="ulasanBahagian" cols="" rows="2"></textarea>
                                                        <button id="add-ulasanBahagian" class="btn btn-sm btn-primary mt-2"><i class="fa fa-plus"></i> Tambah Ulasan Bahagian</button>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row">
                                                <label for="nama_pengerusi" class="col-sm-3 col-form-label"
                                                    style="text-align:left"> Objektif
                                                    <font color="red">*</font>
                                                </label>
                                                <textarea class="form-control" style="display:none;" id="form_OBJ" name="form_OBJ">{{ old('form_OBJ') }}</textarea>
                                                <div class="table-responsive">
                                                    <table id="example1"
                                                        class="table table-sm table-bordered"
                                                        style="width:98%;margin-left:10px;">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">
                                                                    <center>Bil.</center>
                                                                </th>
                                                                <th>
                                                                    <center>Objektif</center>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr> @if( $objektifs->obj1 ) <td>1. </td> <td>{{ $objektifs->obj1 }}</td> @endif </tr>
                                                            <tr> @if( $objektifs->obj2 ) <td>2. </td> <td>{{ $objektifs->obj2 }}</td> @endif </tr>
                                                            <tr> @if( $objektifs->obj3 ) <td>3. </td> <td>{{ $objektifs->obj3 }}</td> @endif </tr>
                                                            <tr> @if( $objektifs->obj4 ) <td>4. </td> <td>{{ $objektifs->obj4 }}</td> @endif </tr>
                                                            <tr> @if( $objektifs->obj5 ) <td>5. </td> <td>{{ $objektifs->obj5 }}</td> @endif </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="7" align="right">
                                                                    @if($errors->has('objektif1'))
                                                                        <div class="text-danger text-strong">Sila pastikan anda telah memasukkan sekurang-kurangnya 1 objektif.</div>
                                                                    @endif
                                                                    <br>
                                                                    <a
                                                                        class="btn btn-sm btn-success" style='color:white;'
                                                                        data-toggle="modal" data-target="#modal-obj" id="objektifButton">
                                                                        <i class="fa fa-edit"></i> 
                                                                        Kemaskini
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                
                                            </div> --}}

                                            <div class="form-group row">
                                                <label for="perancangan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Status Program
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-6" style="@if ($errors->has('perancangan')) border: 2px solid red; @endif">
                                                    {{-- <label class="radio-inline mr-3"><input type="radio" name="perancangan" value="1" required> Dalam Perancangan Perolehan Tahunan</label> --}}
                                                    <label class="radio-inline mr-3">
                                                        <input type="radio" name="perancangan" value="1" {{ $maklumats->perancangan == 1 ? 'checked' : '' }} {{ old('perancangan') == 1 ? 'checked' : '' }}>
                                                        Dalam Perancangan Perolehan Tahunan
                                                    </label>
                                                    <label class="radio-inline mr-3">
                                                        <input type="radio" name="perancangan" value="2" {{ $maklumats->perancangan == 2 ? 'checked' : '' }} {{ old('perancangan') == 2 ? 'checked' : '' }} >
                                                        Tiada Dalam Perancangan Perolehan Tahunan
                                                    </label>
                                                    @error('perancangan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    <br>
                                                    {{-- <label class="radio-inline mr-3"><input type="radio" name="perancangan" value="0"> Tiada Dalam Perancangan Perolehan Tahunan</label> --}}
                                                </div> 
                                            </div>

                                            <div class="form-group row">
                                                <label for="jenis_peruntukan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Jenis Peruntukan
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-4">
                                                    {{-- <select class="select2-with-label-single js-states d-block" id="jenis_peruntukan" name="jenis_peruntukan" --}}
                                                    {{-- <select class="select2" id="jenis_peruntukan" name="jenis_peruntukan"
                                                    style="width: 100%; text-align:left" required>
                                                    <option value=""
                                                        @if (old('jenis_peruntukan') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($Opt_Peruntukan as $peruntukans)
                                                        <option value="{{ $peruntukans->id_jenis_peruntukan }}"
                                                            @if (old('jenis_peruntukan') == $peruntukans->id_jenis_peruntukan) {{ 'selected="selected"' }} @endif>
                                                            {{ $peruntukans->jenis_perbelanjaan }}
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                                    <select class="select2" id="" disabled>
                                                        <option value="1" selected>Mengurus</option>
                                                    </select>
                                                    {{-- <input class="form-control" type="text" name="" id="" value="Mengurus" readonly> --}}
                                                    <input type="hidden" name="jenis_peruntukan" id="jenis_peruntukan"
                                                        value="1">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label for="tkh_mula" class="col-sm-3 col-form-label" style="text-align:left">
                                                    Tarikh Mula
                                                    <font color="red">*</font>
                                                    &nbsp;   
                                                    <div class="hover-text">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">Tarikh mula program/perolehan</span>
                                                    </div>
                                                </label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula') == null ? Carbon\Carbon::parse($maklumats->tkhCadangMula)->format('Y-m-d') : old('tkh_mula') }}" >
                                                        {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="2023-06-03" > --}}
                                                    </div>
                                                    @error('tkh_mula') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tkh_tamat" class="col-sm-3 col-form-label" style="text-align:left">
                                                    Tarikh Tamat
                                                    &nbsp;   
                                                    <div class="hover-text">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">Tarikh tamat program/perolehan</span>
                                                    </div>
                                                    {{-- <font color="red">*</font> --}}
                                                </label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" id="tkh_tamat" name="tkh_tamat"  value="{{ old('tkh_tamat') == null ? Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->format('Y-m-d') : old('tkh_tamat') }}" >
                                                    </div>
                                                    @error('tkh_tamat') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    {{-- <div class="input-group date" id="tkh_tamat" data-target-input="nearest"
                                                        placeholder="Tarikh Mula">
                                                        <input name="tkh_tamat" class="datepicker-default form-control" id="tkh_tamat"
                                                            value="{{ old('tkh_tamat') == null ? Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->format('d-m-Y') : old('tkh_tamat') }}"
                                                            required>
                                                        <div class="input-group-append" data-target="#tkh_tamat"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="ruj_fail" class="col-sm-3 col-form-label" style="text-align:left">
                                                    No. Rujukan Fail
                                                    <font color= "red">*</font> 
                                                </label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="ruj_fail" name="ruj_fail" value="{{ $maklumats->rujukan_fail ?? old('ruj_fail') }}">
                                                    </div>
                                                    @error('ruj_fail') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            
                                            @if ( $user->agensi != 'Kementerian Perpaduan Negara (KPN)')
                                                {{-- <hr style=" border-top: 2px solid #000000"> --}}
                                                {{-- <br> --}}

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-3 col-form-label" style="text-align:left"> 
                                                        Pengesah Permohonan <font color="red">*</font>
                                                        &nbsp;   
                                                        <div class="hover-text">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                            <span class="tooltip-text" id="right">Sila maklumkan kepada Pentadbir Sistem jika nama pengesah tidak ada di senarai pilihan.</span>
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        {{-- {{ $pengguna->id_access }} --}}
                                                        <select class="select2" id="pengesah" name="pengesah" style="width:100%;">
                                                            @php
                                                                // Determine the selected option: Use old input first, fallback to $maklumats->pengesah if available
                                                                $pengesahOpt = old('pengesah') ?? $maklumats->pengesah ?? '';
                                                            @endphp
                                                            <!-- Empty option -->
                                                            <option value="" @if ($pengesahOpt == '') selected @endif>&nbsp;</option>
                                                            <!-- Loop through the pengesahs and set selected if it matches -->
                                                            @foreach ($pengesahs as $pengesah)
                                                                <option value="{{ $pengesah->idPengesah }}"
                                                                    @if ($pengesahOpt == $pengesah->idPengesah) selected @endif>
                                                                    {{ $pengesah->namaPengesah }}, {{ $pengesah->jawatanPengesah }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="form-group row">
                                                    <label for="" class="col-sm-3 col-form-label" style="text-align:left"> Pengesah Permohonan
                                                        &nbsp;   
                                                        <div class="hover-text">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                            <span class="tooltip-text" id="right">Tarikh tamat program/perolehan</span>
                                                        </div>
                                                        <font color= "red">*</font> 
                                                    </label>
                                                </div> --}}

                                                {{-- <div class="form-group row">
                                                    <label for="nama_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Nama </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="nama_pengesah" name="nama_pengesah" value="{{ $pengesah->namaPengesah ?? old('nama_pengesah') }}">
                                                        </div>
                                                        @error('nama_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>

                                                </div> --}}

                                                {{-- <div class="form-group row">
                                                    <label for="jawatan_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Jawatan </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="jawatan_pengesah" name="jawatan_pengesah" value="{{ $pengesah->jawatanPengesah ?? old('jawatan_pengesah') }}">
                                                        </div>
                                                        @error('jawatan_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div> --}}

                                                {{-- <div class="form-group row">
                                                    <label for="bahagian_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Bahagian </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="bahagian_pengesah" name="bahagian_pengesah" value="{{ $pengesah->bahagianPengesah ?? old('bahagian_pengesah') }}">
                                                        </div>
                                                        @error('bahagian_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div> --}}

                                                {{-- <div class="form-group row">
                                                    <label for="kementerian_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Kementerian
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="agensi_pengesah" name="agensi_pengesah" value="{{ $user->agensi  ?? old('agensi_pengesah') }}">
                                                        </div>
                                                        @error('agensi_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div> --}}

                                            @else
                                            @endif

                                            {{-- <div class="form-group row">
                                                <label for="pengesah" class="col-sm-3 col-form-label" style="text-align:left">
                                                    Pengesah 
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="input-group col-sm-4">
                                                   <select class="select2" id="pengesah" name="pengesah"
                                                        style="width: 100%; text-align:left;">
                                                        @php old('pengesah') == NULL ? $pengesahOpt = $maklumats->pengesah : $perananOpt = old('pengesah') @endphp
                                                        <option value="" @if ( $pengesahOpt == '') {{ 'selected="selected"' }} @endif>&nbsp; </option>
                                                        @foreach ($pengesahs as $pengesah)
                                                            <option value="{{ $pengesah->id }}"
                                                                @if ( $pengesahOpt == $pengesah->id ) {{ 'selected="selected"' }} @endif>
                                                                {{ $pengesah->name }}, {{ $pengesah->gred }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div> --}}

                                            <br>
                                            <hr style=" border-top: 2px solid #000000">
                                            <br>

                                            <div class="form-group row">
                                                <label for="nama_pengerusi" class="col-sm-3 col-form-label"
                                                    style="text-align:left"> Anggaran Implikasi Kewangan
                                                    {{-- style="text-align:left">No Vot. --}}
                                                    <font color="red">*</font>
                                                </label>
                                                <textarea class="form-control" style="display:none;" id="form_VOT" name="form_VOT">{{ old('form_VOT') }}</textarea>
                                                <div class="table-responsive">
                                                    <table id="example1"
                                                        class="table table-sm table-bordered"
                                                        style="width:98%;margin-left:10px;">
                                                        {{-- <thead class="thead-light"> --}}
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <center>Bil.</center>
                                                                </th>
                                                                <th>
                                                                    <center>Perkara</center>
                                                                </th>
                                                                <th>
                                                                    <center>Objek Am/Objek Sebagai</center>
                                                                </th>
                                                                {{-- <th>
                                                                    <center>Lain-Lain/Keterangan</center>
                                                                </th> --}}
                                                                <th>
                                                                    <center>Unit/Bilangan</center>
                                                                </th>
                                                                <th>
                                                                    <center>Kos(RM)</center>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $kosAll = 0; ?>
                                                            @foreach ($vots as $vot)
                                                                <tr>
                                                                    <td><center>{{ $loop->iteration }}</center></td>
                                                                    <td>
                                                                        <center>
                                                                            @if ( $vot->perkara === null || $vot->perkara === "" )
                                                                                {{ $vot->keterangan }}
                                                                            @else
                                                                                {{ ($vot->perkara!='') ? \App\LkpPerkara::find($vot->perkara)->perkara : '' }}
                                                                            @endif  
                                                                        </center>
                                                                    </td>
                                                                    <td>
                                                                        <center>
                                                                            {{-- OA{{ ($vot->objekAm!='') ? \App\LkpVot::find($vot->objekAm)->noVot : '' }}@if ($vot->objekSebagai)/OS{{ $vot->objekSebagai }}     @endif --}}
                                                                            {{ ($vot->objekAm!='') ? \App\LkpOA::find($vot->objekAm)->oa : '' }} / {{ ($vot->objekSebagai!='') ? \App\LkpOS::find($vot->objekSebagai)->os : '' }}

                                                                        </center>    
                                                                    </td>
                                                                    {{-- <td>{{ $vot->objekAm }}</td> --}}
                                                                    {{-- <td>{{ $vot->objekSebagai }}</td> --}}
                                                                    {{-- <td><center> {{ $vot->keterangan ?: '-' }} </center></td> --}}
                                                                    <td><center>@if( $vot->unit != 0 ) {{ $vot->unit }} @else - @endif</center></td>
                                                                    <td><center>RM{{ number_format($vot->kos, 2) }}</center></td> <?php $kosAll = $kosAll + $vot->kos ?>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        {{-- <tbody id="senP1"></tbody> --}}
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="7" align="right">
                                                                    <span id="warningMessage" style="display: none;">
                                                                        <font color="red">
                                                                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp; 
                                                                            Sila pastikan borang anda telah disimpan sebelum tekan butang ini untuk mengelakkan sebarang kehilangan data.
                                                                        </font>
                                                                    </span>
                                                                    
                                                                    @error('kos_mohon') <div class="text-danger text-strong"> &nbsp;{{ $message }}</div> @enderror
                                                                    <br>
                                                                    <a
                                                                        href="{{ route('peruntukan.kemaskini_vot', $maklumats->idMaklumatPermohonan) }}"
                                                                        class="btn btn-sm btn-success" style='color:white;' id="votButton">
                                                                        <i class="fa fa-edit"></i> Kemaskini
                                                                    </a>
                                                                    {{-- <a
                                                                        class="btn btn-sm btn-success" style='color:white;'
                                                                        data-toggle="modal" data-target="#modal-vot"><i
                                                                            class="fa fa-edit"></i> Kemaskini
                                                                    </a> --}}
                                                                </td>
                                                                {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                            </tr>
                                                            <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="kos_mohon" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Jumlah Yang Dimohon
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-4">
                                                    <div class="input-group input-secondary">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">RM</span>
                                                        </div>
                                                        <input type="number" class="form-control" name="kos_mohon" id="kos_mohon" 
                                                            value="{{ $kosAll }}" readonly>
                                                            {{-- value="{{ old('kos_mohon') }}" readonly> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row">
                                                <label for="syor" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Syor
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="syor" id="syor" cols="" rows="2" value="{{ $maklumats->syor ?? old('syor') }}">{{ $maklumats->syor ?? old('syor') }}</textarea>
                                                    @error('syor') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div> --}}

                                            <div class="form-group row">
                                                <label for="dokumen" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Dokumen Tambahan
                                                    <br>
                                                    <small> <font color="red">(format PDF sahaja - Maksimun 5 MB.)</font> </small>
                                                    {{-- <font color="red">*</font> --}}
                                                </label>
                                                <div class="col-sm-9">
                                                    @if ( $maklumats->doc_Sokongan)
                                                        <small>
                                                            @if (App::environment('local'))
                                                                <a href="{{ Storage::url($maklumats->doc_Sokongan) }}" class="btn-sm btn-default" target="_blank" ><i class="fa fa-paperclip"></i> 
                                                                    &nbsp; {{ basename($maklumats->doc_Sokongan) }} 
                                                                </a>
                                                            @else
                                                                <a href="/ePantas{{ Storage::url($maklumats->doc_Sokongan) }}" class="btn-sm btn-default" target="_blank" ><i class="fa fa-paperclip"></i> 
                                                                    &nbsp; {{ basename($maklumats->doc_Sokongan) }} 
                                                                </a>
                                                            @endif
                                                            <button type="submit" class="btn-danger btn-sm" name="buang_file" id="buang_file" title="Buang Fail"><i class="fa fa-trash"></i></button>
                                                        </small>
                                                    @endif
                                                    <br>
                                                    <input type="file" class="form-control" id="dokumen"
                                                        name="dokumen" value="{{ old('dokumen') }}" />
                                                    @error('dokumen') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>

                                            </div>

                                            {{-- <div class="form-group row">
                                                <label for="minit_permohonan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Minit Permohonan
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" id="minit_permohonan"
                                                        name="minit_permohonan" value="{{ old('minit_permohonan') }}" />
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Lampiran</span>
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" name="minit_permohonan" id="minit_permohonan" class="custom-file-input">
                                                            <label class="custom-file-label">Pilih fail...</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <p style="color: red; font-weight: bold;">* Sila semak format dalam 'Papar PDF' untuk memastikan format dan maklumat telah dimasukkan dengan lengkap dan tersusun.</p>


                                            <div class="btn-group float-right">
                                                {{-- <a href="/peruntukan/tindakan" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                                        class="fa fa-paper-plane"></i> |
                                                         Hantar
                                                </a> --}}
                                                <!-- Button trigger modal -->
                                                    {{-- <button type="button" class="btn btn-primary float-left btn-sm" data-toggle="modal"
                                                    data-target="#exampleModalCenter"><i class="fa fa-paper-plane"></i> | Hantar
                                                </button> --}}
            
                                                <br>
                                                <button id="updateTimeButton" class="btn btn-sm btn-light float-right" disabled>
                                                    {{-- Dikemaskini : {{ \Carbon\Carbon::parse($maklumats->updatedAt)->format('d/m/Y H:i') }} --}}
                                                    Dikemaskini: {{ \Carbon\Carbon::parse($maklumats->updatedAt)->format('d/m/Y h:i a') }}          
                                                </button>
                                                <a href="{{ url('peruntukan/senarai/') }}"
                                                    class="btn btn-secondary float-left btn-sm">
                                                    <i class="fas fa-redo-alt"></i> | Kembali
                                                </a>

                                                <a href="{{ url('pemohon/download_pdf/'.$maklumats->idMaklumatPermohonan) }}" title="Paparan lihat PDF" target="_blank" id="" class="btn btn-warning float-right btn-sm"  style="background-color: green;">
                                                    {{-- <i class="fa fa-print"></i> | Cetak  --}}
                                                    <i class="fa fa-file-pdf-o"></i> | Papar PDF
                                                </a>

                                                <button type="submit" id="simpan" name="simpan" class="btn btn-success float-right btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> |
                                                    Simpan
                                                </button>

                                                @if ( $maklumats->id_status != 1 )
                                                    <button type="button" name="hantar" id="hantar" class="btn btn-info float-right btn-sm" >
                                                        <i class="fa fa-paper-plane"></i> | Hantar
                                                    </button>
                                                @endif

                                                <!-- Modal -->
                                                {{-- <div class="modal fade" id="exampleModalCenter">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                
                                                            </div>
                                                            <div class="modal-body">
                                                                <color="red">
                                                                    <h4 style="color:red;"><i class="fa fa-exclamation-circle fa-lg"
                                                                            aria-hidden="true"></i> Anda pasti ingin menghantar
                                                                        permohonan?</h4>
                                                                </color>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger light"
                                                                    data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Hantar</button>
                                                                <a href="{{ route('pemohon.dummy') }}" id="hantar" class="btn btn-primary">Hantar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                    {{-- <button type="button" class="btn btn-secondary float-left btn-sm"
                                                    onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali
                                                </button> --}}
                                                
                                            </div>

                                        </div>
                                        
                                    </div>
                                </div>

                                {{-- MODAL OBJEKTIF --}}
                                <div class="modal fade" id="modal-obj">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">KEMASKINI OBJEKTIF</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            {{-- <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm1"> --}}
                                                {{-- {{ csrf_field() }} --}}
                                                <div class="modal-body">

                                                    <div class="form-group row">
                                                        <label for="objektif1" class="col-sm-2 col-form-label"
                                                            style="text-align:left">
                                                                Objektif 1
                                                            <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-10">
                                                            {{-- <input class="form-control" type="text" name="objektif" id="objektif"> --}}
                                                            <textarea class='form-control' name="objektif1" id="objektif1" cols="" rows="2">{{ $objektifs->obj1 ?? old('objektif1') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="objektif2" class="col-sm-2 col-form-label"
                                                            style="text-align:left">
                                                                Objektif 2
                                                            {{-- <font color="red">*</font> --}}
                                                        </label>
                                                        <div class="col-sm-10">
                                                            {{-- <input class="form-control" type="text" name="objektif" id="objektif"> --}}
                                                            <textarea class='form-control' name="objektif2" id="objektif2" cols="" rows="2">{{ $objektifs->obj2 ?? old('objektif2') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="objektif3" class="col-sm-2 col-form-label"
                                                            style="text-align:left">
                                                                Objektif 3
                                                            {{-- <font color="red">*</font> --}}
                                                        </label>
                                                        <div class="col-sm-10">
                                                            {{-- <input class="form-control" type="text" name="objektif" id="objektif"> --}}
                                                            <textarea class='form-control' name="objektif3" id="objektif3" cols="" rows="2">{{ $objektifs->obj3 ?? old('objektif3') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="objektif4" class="col-sm-2 col-form-label"
                                                            style="text-align:left">
                                                                Objektif 4
                                                            {{-- <font color="red">*</font> --}}
                                                        </label>
                                                        <div class="col-sm-10">
                                                            {{-- <input class="form-control" type="text" name="objektif" id="objektif"> --}}
                                                            <textarea class='form-control' name="objektif4" id="objektif4" cols="" rows="2">{{ $objektifs->obj4 ?? old('objektif4') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="objektif5" class="col-sm-2 col-form-label"
                                                            style="text-align:left">
                                                                Objektif 5
                                                            {{-- <font color="red">*</font> --}}
                                                        </label>
                                                        <div class="col-sm-10">
                                                            {{-- <input class="form-control" type="text" name="objektif" id="objektif"> --}}
                                                            <textarea class='form-control' name="objektif5" id="objektif5" cols="" rows="2">{{ $objektifs->obj5 ?? old('objektif5') }}</textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- <div class="modal-footer justify-content-between"> --}}
                                                <div class="modal-footer float-right">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-dismiss="modal">Tutup</button>
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="submit" class="btn btn-success btn-sm" name="submit_obj" id="submit_obj">
                                                        <i class="fa fa-save"></i>
                                                            Simpan
                                                    </button>
                                                    {{-- <button type="button" class="btn btn-primary btn-sm" id="addData"
                                                        onclick="tambahOBJ()" data-dismiss="modal"><i class="fa fa-plus"></i>
                                                        Tambah
                                                    </button> --}}
                                                </div>

                                            {{-- </form> --}}
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                {{-- MODAL OBJEKTIF --}}

                                {{-- MODAL VOT --}}
                                <div class="modal fade" id="modal-vot">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">TAMBAH VOT</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            {{-- <form class="form-horizontal" method="POST" action=""
                                                enctype="multipart/form-data" id="myForm1">
                                                {{ csrf_field() }} --}}
                                                <div class="modal-body">
    
                                                    <div class="form-group row">
                                                        <label for="perkara" class="col-sm-3 col-form-label"
                                                            style="text-align:left">
                                                                Perkara
                                                            <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="perkara" id="perkara" maxlength="50" value="{{ old('perkara') }}">
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="objekAm" class="col-sm-3 col-form-label"
                                                            style="text-align:left">
                                                            Objek Am <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <textarea class="form-control" name="objekAm" id="objekAm" cols="" rows="2"></textarea> --}}
                                                            <select class="select2" id="objekAm" name="objekAm"
                                                                style="width: 100%; text-align:left;">
                                                                <option value=""
                                                                    @if (old('objekAm') == '') {{ 'selected="selected"' }} @endif>
                                                                    &nbsp;
                                                                </option>
                                                                @foreach ($objekAms as $objekAm)
                                                                    {{-- <option value="{{ $objekAm->idVot }}" --}}
                                                                    {{-- <option value="{{ $objekAm->noVot }}" title="{{ $objekAm->namaVot }}" --}}
                                                                    <option value="{{ $objekAm->idVot }}"
                                                                        title="{{ $objekAm->noVot }}"
                                                                        {{-- title="{{ $objekAm->namaVot }}" --}}
                                                                        @if (old('objekAm') == $objekAm->idVot) {{ 'selected="selected"' }} @endif>
                                                                        {{-- @if (old('objekAm') == $objekAm->noVot) {{ 'selected="selected"' }} @endif> --}}
                                                                        {{ $objekAm->noVot }}, {{ $objekAm->namaVot }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="objekSeb" class="col-sm-3 col-form-label"
                                                            style="text-align:left">
                                                            Objek Sebagai <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <textarea class="form-control" name="objekSeb" id="objekSeb" cols="" rows="2"></textarea> --}}
                                                            {{-- <select class="select2" id="objekSeb" name="objekSeb"
                                                            style="width: 100%; text-align:left;">
                                                            <option value=""
                                                                @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                            </option>
                                                            @foreach ($objekSebs as $objekSeb)
                                                                <option value="{{ $objekSeb->idObjek }}"
                                                                    @if (old('objekSeb') == $objekSeb->idObjek) {{ 'selected="selected"' }} @endif>
                                                                    {{ $objekSeb->idObjek }}, {{ $objekSeb->jenisPerbelanjaan }}
                                                                </option>
                                                            @endforeach
                                                        </select> --}}
                                                            <select class="select2" id="objekSeb" name="objekSeb"
                                                                style="width: 100%;">
                                                                <option value=""
                                                                    @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>
                                                                    &nbsp;</option>
                                                                <option value="" selected disabled> -- Sila Pilih Objek
                                                                    Am -- </option>
                                                            </select>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-3 col-form-label"
                                                            style="text-align:left"> Unit
                                                            <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control" name="unit" id="unit" value="{{ old('unit') }}">
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="kos" class="col-sm-3 col-form-label"
                                                            style="text-align:left"> Anggaran Kos
                                                            <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group input-secondary">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">RM</span>
                                                                </div>
                                                                <input type="number" class="form-control" name="kos" id="kos" value="{{ old('kos') }}">
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                </div>
    
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-dismiss="modal">Tutup</button>
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="submit" class="btn btn-primary btn-sm" name="tambah_vot" id="tambah_vot"><i class="fa fa-plus"></i>
                                                        Tambah
                                                    </button>
                                                    {{-- <button type="button" class="btn btn-primary btn-sm" id="addData"
                                                        onclick="tambahVot()" data-dismiss="modal"><i class="fa fa-plus"></i>
                                                        Tambah
                                                    </button> --}}
                                                </div>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                {{-- MODAL VOT --}}

                                <!-- Edit Modal -->
                                    {{-- TUJUAN MODAL --}}
                                        <div class="modal fade" id="tujuanModal" tabindex="-1" aria-labelledby="tujuanModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">KEMASKINI TUJUAN</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editForm">
                                                            <input type="hidden" id="editIdTujuan" name="editIdTujuan">
                                                            <div class="form-group">
                                                                <textarea id="editTujuan" class="form-control summernote" rows="2"></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                        <button type="button" class="btn btn-primary" id="saveEditTujuan">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- TUJUAN MODAL --}}

                                    <!-- LATAR BELAKANG MODAL -->   
                                        <div class="modal fade" id="latarBelakangModal" tabindex="-1" aria-labelledby="latarBelakangModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">KEMASKINI LATAR BELAKANG</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editLatarBelakangForm">
                                                            <input type="hidden" id="editIdLatarBelakang" name="editIdLatarBelakang">
                                                            <div class="form-group">
                                                                <textarea id="editLatarBelakang" class="form-control summernote" rows="2"></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                        <button type="button" class="btn btn-primary" id="saveEditLatarBelakang">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- END LATAR BELAKANG MODAL -->

                                    <!-- DASAR SEMASA MODAL -->
                                        <div class="modal fade" id="dasarSemasaModal" tabindex="-1" aria-labelledby="dasarSemasaModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">KEMASKINI DASAR SEMASA</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editDasarSemasaForm">
                                                            <input type="hidden" id="editIdDasarSemasa" name="editIdDasarSemasa">
                                                            <div class="form-group">
                                                                <textarea id="editDasarSemasa" class="form-control summernote" rows="2"></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                        <button type="button" class="btn btn-primary" id="saveEditDasarSemasa">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- END DASAR SEMASA MODAL -->

                                    <!-- JUSTIFIKASI PERMOHONAN MODAL -->
                                        <div class="modal fade" id="justifikasiPermohonanModal" tabindex="-1" aria-labelledby="justifikasiPermohonanModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">KEMASKINI JUSTIFIKASI PERMOHONAN</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editJustifikasiPermohonanForm">
                                                            <input type="hidden" id="editIdJustifikasiPermohonan" name="editIdJustifikasiPermohonan">
                                                            <div class="form-group">
                                                                <textarea id="editJustifikasiPermohonan" class="form-control summernote" rows="2"></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                        <button type="button" class="btn btn-primary" id="saveEditJustifikasiPermohonan">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- END JUSTIFIKASI PERMOHONAN MODAL -->

                                    <!-- ULASAN BAHAGIAN MODAL -->
                                        <div class="modal fade" id="ulasanBahagianModal" tabindex="-1" aria-labelledby="ulasanBahagianModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">KEMASKINI ULASAN BAHAGIAN</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editUlasanBahagianForm">
                                                            <input type="hidden" id="editIdUlasanBahagian" name="editIdUlasanBahagian">
                                                            <div class="form-group">
                                                                <textarea id="editUlasanBahagian" class="form-control summernote" rows="2"></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                        <button type="button" class="btn btn-primary" id="saveEditUlasanBahagian">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- END ULASAN BAHAGIAN MODAL -->
                                
                                <!-- Edit Modal -->

                            </form> 

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--**********************************
                            Content body end
                        ***********************************-->
@endsection

@section('script')

        {{-- TUJUAN --}}
            <script>
                $(document).ready(function () {
                    
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    let editId = null; // To store the ID being edited
                    const idMaklumatPermohonan = {{ $maklumats->idMaklumatPermohonan }}; // Assign the value from the controller
                    // console.log(idMaklumatPermohonan); // Check if the ID is logged correctly

                    // Initialize Summernote
                    // $('.summernote').summernote();
                    $('#tujuan').summernote({
                        toolbar: [
                            // Keep only the features you need
                            ['style', ['bold', 'italic', 'underline']], // Text styles
                            // ['para', ['ul', 'ol', 'paragraph']],                // Paragraph formatting
                            ['view', ['fullscreen', 'codeview']]               // Viewing options
                        ],
                        placeholder: 'Taipkan teks anda di sini, kemudian tekan butang Tambah di bawah.', // Optional placeholder text
                        height: 100,                            // Set editor height
                        // styleTags: ['p', 'blockquote', 'pre'], // Restrict to simple tags
                        callbacks: {
                            onPaste: function(e) {
                                let clipboardData = (e.originalEvent || e).clipboardData || window.clipboardData;
                                let text = clipboardData.getData('Text'); // Get plain text
                                e.preventDefault();
                                document.execCommand('insertText', false, text); // Insert plain text
                            },
                            onChange: function(contents, $editable) {
                                var button = $('#add-tujuan');
                                if (contents.trim()) {
                                    button.css('background-color', 'red');  // Change text color to red
                                } else {
                                    button.css('color', '');  // Reset to default color
                                }
                            },
                        },
                         // Ensure font size dropdown is not shown
                        // fontSizes: [], // Disables font size selection
                        // styleTags: ['p'], // Restrict to simple paragraph tags
                    });

                    // Load Tujuans
                    function loadTujuans() {
                        $.get(`${baseUrl}/tujuan/${idMaklumatPermohonan}`, function (data) {
                            const tujuanList = $('#tujuan-list');
                            const heading = $('#tujuan-heading'); // Select the <h4> element by its ID
                            const tujuanBody = $('#tujuan-body');

                            tujuanList.empty(); // Clear the existing list

                            if (data.length === 0) {
                                heading.hide(); // Hide the heading if no items
                                tujuanBody.hide(); // Hide the heading if no items
                            } else {
                                heading.show(); // Show the heading if there are items
                                tujuanBody.show(); // Show the heading if there are items
                                data.forEach((tujuan, index) => {
                                    tujuanList.append(`
                                        <li class="list-group-item" data-id="${tujuan.id}">
                                            ${index + 1}. ${tujuan.tujuan}
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-sm float-end ms-2 edit-tujuan">Kemaskini</button>
                                                <button class="btn btn-danger btn-sm float-end delete-tujuan">Hapus</button>
                                            </div>
                                        </li>
                                    `);
                                });
                            }
                        });
                    }


                    loadTujuans();

                    // Add Tujuan
                    $('#add-tujuan').click(function (event) {
                        event.preventDefault();

                        const tujuan = $('#tujuan').summernote('code'); // Get Summernote content
                        if (tujuan.trim() === '') {
                            alert('Sila masukkan tujuan.');
                            return;
                        }

                        $.ajax({
                            url: `${baseUrl}/tujuan`,
                            method: 'POST',
                            data: { tujuan, idMaklumatPermohonan }, // Include idMaklumatPermohonan
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#tujuan').summernote('reset'); // Clear the Summernote editor content
                                $('#add-tujuan').css('background-color', ''); // Reset button background color
                                loadTujuans();
                            },
                            error: function (xhr) {
                                alert('Gagal menambah tujuan. ' + xhr.responseText);
                            },
                        });
                    });

                    // Delete Tujuan
                    $(document).on('click', '.delete-tujuan', function (event) {
                        event.preventDefault();

                        const id = $(this).closest('li').data('id');

                        $.ajax({
                            url: `${baseUrl}/tujuan/${id}`,
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                loadTujuans();
                            },
                            error: function (xhr) {
                                alert('Gagal menghapus tujuan. ' + xhr.responseText);
                            },
                        });
                    });

                    // Open Edit Modal
                    $(document).on('click', '.edit-tujuan', function (event) {
                        event.preventDefault();

                        const li = $(this).closest('li');
                        const editId = li.data('id'); // Store the ID of the tujuan being edited

                        // Make an AJAX request to get the tujuan data by ID
                        $.ajax({
                            url: `${baseUrl}/tujuan/show/${editId}`, // Assuming this route returns the specific tujuan data
                            method: 'GET',
                            success: function (data) {
                                // Check if data exists
                                if (data && data.tujuan) {
                                    $('#editIdTujuan').val(editId); // Set the hidden field value
                                    $('#editTujuan').summernote('code', data.tujuan); // Populate the Summernote editor
                                    $('#tujuanModal').modal('show'); // Show the modal
                                } else {
                                    alert('Gagal mengeluarkan tujuan.');
                                }
                            },
                            error: function (xhr) {
                                alert('Gagal untuk mendapatkan maklumat tujuan. ' + xhr.responseText);
                            }
                        });
                    });



                    // Save Edit
                    $('#saveEditTujuan').click(function () {
                        const newTujuan = $('#editTujuan').summernote('code'); // Get the Summernote content

                        if (!newTujuan.trim()) {
                            alert('Tujuan tidak boleh dibiarkan kosong.');
                            return;
                        }

                        const editId = $('#editIdTujuan').val();

                        $.ajax({
                            url: `${baseUrl}/tujuan/${editId}`,
                            method: 'PUT',
                            data: { tujuan: newTujuan },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#tujuanModal').modal('hide'); // Hide the modal
                                loadTujuans(); // Reload tujuan list
                            },
                            error: function (xhr) {
                                alert('Gagal mengemaskini tujuan. ' + xhr.responseText);
                            },
                        });


                    });
                });
            </script>
        {{-- TUJUAN --}}

        {{-- LATAR BELAKANG --}}
            <script>
                $(document).ready(function () {
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    const idMaklumatPermohonan = {{ $maklumats->idMaklumatPermohonan }};

                    // Initialize Summernote for `Latar Belakang`
                    // $('.summernote').summernote();
                    $('#latarBelakang').summernote({
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline']],
                            // ['para', ['ul', 'ol', 'paragraph']],                // Paragraph formatting
                            ['view', ['fullscreen', 'codeview']]
                        ],
                        placeholder: 'Taipkan teks anda di sini, kemudian tekan butang Tambah di bawah.', // Optional placeholder text
                        height: 100,
                        // styleTags: ['p', 'blockquote', 'pre'],
                        callbacks: {
                            onPaste: function (e) {
                                let clipboardData = (e.originalEvent || e).clipboardData || window.clipboardData;
                                let text = clipboardData.getData('Text');
                                e.preventDefault();
                                document.execCommand('insertText', false, text);
                            },
                            onChange: function(contents, $editable) {
                                var button = $('#add-latarBelakang');
                                if (contents.trim()) {
                                    button.css('background-color', 'red');  // Change text color to red
                                } else {
                                    button.css('color', '');  // Reset to default color
                                }
                            },
                        },
                    });

                    // Load Latar Belakangs
                    function loadLatarBelakangs() {
                        $.get(`${baseUrl}/latar/${idMaklumatPermohonan}`, function (data) {
                            const latarBelakangList = $('#latarBelakang-list');
                            const heading = $('#latarBelakang-heading');
                            const latarBelakangBody = $('#latarBelakang-body');

                            latarBelakangList.empty();

                            if (data.length === 0) {
                                heading.hide();
                                latarBelakangBody.hide();
                            } else {
                                heading.show();
                                latarBelakangBody.show();
                                data.forEach((latarBelakang, index) => {
                                    latarBelakangList.append(`
                                        <li class="list-group-item" data-id="${latarBelakang.id}">
                                            ${index + 1}. ${latarBelakang.latarBelakang}
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-sm float-end ms-2 edit-latarBelakang">Kemaskini</button>
                                                <button class="btn btn-danger btn-sm float-end delete-latarBelakang">Hapus</button>
                                            </div>
                                        </li>
                                    `);
                                });
                            }
                        });
                    }

                    loadLatarBelakangs();

                    // Add Latar Belakang
                    $('#add-latarBelakang').click(function (event) {
                        event.preventDefault();

                        const latarBelakang = $('#latarBelakang').summernote('code');
                        if (latarBelakang.trim() === '') {
                            alert('Sila masukkan latar belakang.');
                            return;
                        }

                        $.ajax({
                            url: `${baseUrl}/latar`,
                            method: 'POST',
                            data: { latarBelakang, idMaklumatPermohonan },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#latarBelakang').summernote('reset');
                                $('#add-latarBelakang').css('background-color', ''); // Reset button background color
                                loadLatarBelakangs();
                            },
                            error: function (xhr) {
                                alert('Gagal menambah latar belakang. ' + xhr.responseText);
                            },
                        });
                    });

                    // Delete Latar Belakang
                    $(document).on('click', '.delete-latarBelakang', function (event) {
                        event.preventDefault();

                        const id = $(this).closest('li').data('id');

                        $.ajax({
                            url: `${baseUrl}/latar/${id}`,
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                loadLatarBelakangs();
                            },
                            error: function (xhr) {
                                alert('Gagal menghapus latar belakang. ' + xhr.responseText);
                            },
                        });
                    });

                    // Open Edit Modal
                    $(document).on('click', '.edit-latarBelakang', function (event) {
                        event.preventDefault();

                        const li = $(this).closest('li');
                        const editId = li.data('id');

                        $.ajax({
                            url: `${baseUrl}/latar/show/${editId}`,
                            method: 'GET',
                            success: function (data) {
                                if (data && data.latarBelakang) {
                                    $('#editIdLatarBelakang').val(editId);
                                    $('#editLatarBelakang').summernote('code', data.latarBelakang);
                                    $('#latarBelakangModal').modal('show');
                                } else {
                                    alert('Gagal mengeluarkan latar belakang.');
                                }
                            },
                            error: function (xhr) {
                                alert('Gagal untuk mendapatkan maklumat latar belakang. ' + xhr.responseText);
                            }
                        });
                    });

                    // Save Edit
                    $('#saveEditLatarBelakang').click(function () {
                        const newLatarBelakang = $('#editLatarBelakang').summernote('code');

                        if (!newLatarBelakang.trim()) {
                            alert('Latar belakang tidak boleh dibiarkan kosong.');
                            return;
                        }

                        const editId = $('#editIdLatarBelakang').val();

                        $.ajax({
                            url: `${baseUrl}/latar/${editId}`,
                            method: 'PUT',
                            data: { latarBelakang: newLatarBelakang },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#latarBelakangModal').modal('hide');
                                loadLatarBelakangs();
                            },
                            error: function (xhr) {
                                alert('Gagal mengemaskini latar belakang. ' + xhr.responseText);
                            },
                        });
                    });
                });

            </script>
        {{-- LATAR BELAKANG --}}

        {{-- DASAR SEMASA --}}
            <script>
                $(document).ready(function () {
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    const idMaklumatPermohonan = {{ $maklumats->idMaklumatPermohonan }};

                    // Initialize Summernote for `Dasar Semasa`
                    // $('.summernote').summernote();
                    $('#dasarSemasa').summernote({
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline']],
                            // ['para', ['ul', 'ol', 'paragraph']],                // Paragraph formatting
                            ['view', ['fullscreen', 'codeview']]
                        ],
                        placeholder: 'Taipkan teks anda di sini, kemudian tekan butang Tambah di bawah.', // Optional placeholder text
                        height: 100,
                        // styleTags: ['p', 'blockquote', 'pre'],
                        callbacks: {
                            onPaste: function (e) {
                                let clipboardData = (e.originalEvent || e).clipboardData || window.clipboardData;
                                let text = clipboardData.getData('Text');
                                e.preventDefault();
                                document.execCommand('insertText', false, text);
                            },
                            onChange: function(contents, $editable) {
                                var button = $('#add-dasarSemasa');
                                if (contents.trim()) {
                                    button.css('background-color', 'red');  // Change text color to red
                                } else {
                                    button.css('color', '');  // Reset to default color
                                }
                            },
                        },
                    });

                    // Load Dasar Semasas
                    function loadDasarSemasas() {
                        $.get(`${baseUrl}/dasar/${idMaklumatPermohonan}`, function (data) {
                            const dasarSemasaList = $('#dasarSemasa-list');
                            const heading = $('#dasarSemasa-heading');
                            const dasarSemasaBody = $('#dasarSemasa-body');

                            dasarSemasaList.empty();

                            if (data.length === 0) {
                                heading.hide();
                                dasarSemasaBody.hide();
                            } else {
                                heading.show();
                                dasarSemasaBody.show();
                                data.forEach((dasarSemasa, index) => {
                                    dasarSemasaList.append(`
                                        <li class="list-group-item" data-id="${dasarSemasa.id}">
                                            ${index + 1}. ${dasarSemasa.dasarSemasa}
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-sm float-end ms-2 edit-dasarSemasa">Kemaskini</button>
                                                <button class="btn btn-danger btn-sm float-end delete-dasarSemasa">Hapus</button>
                                            </div>
                                        </li>
                                    `);
                                });
                            }
                        });
                    }

                    loadDasarSemasas();

                    // Add Dasar Semasa
                    $('#add-dasarSemasa').click(function (event) {
                        event.preventDefault();

                        const dasarSemasa = $('#dasarSemasa').summernote('code');
                        if (dasarSemasa.trim() === '') {
                            alert('Sila masukkan dasar semasa.');
                            return;
                        }

                        $.ajax({
                            url: `${baseUrl}/dasar`,
                            method: 'POST',
                            data: { dasarSemasa, idMaklumatPermohonan },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#dasarSemasa').summernote('reset');
                                $('#add-dasarSemasa').css('background-color', ''); // Reset button background color
                                loadDasarSemasas();
                            },
                            error: function (xhr) {
                                alert('Gagal menambah dasar semasa. ' + xhr.responseText);
                            },
                        });
                    });

                    // Delete Dasar Semasa
                    $(document).on('click', '.delete-dasarSemasa', function (event) {
                        event.preventDefault();

                        const id = $(this).closest('li').data('id');

                        $.ajax({
                            url: `${baseUrl}/dasar/${id}`,
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                loadDasarSemasas();
                            },
                            error: function (xhr) {
                                alert('Gagal menghapus dasar semasa. ' + xhr.responseText);
                            },
                        });
                    });

                    // Open Edit Modal
                    $(document).on('click', '.edit-dasarSemasa', function (event) {
                        event.preventDefault();

                        const li = $(this).closest('li');
                        const editId = li.data('id');

                        $.ajax({
                            url: `${baseUrl}/dasar/show/${editId}`,
                            method: 'GET',
                            success: function (data) {
                                if (data && data.dasarSemasa) {
                                    $('#editIdDasarSemasa').val(editId);
                                    $('#editDasarSemasa').summernote('code', data.dasarSemasa);
                                    $('#dasarSemasaModal').modal('show');
                                } else {
                                    alert('Gagal mengeluarkan dasar semasa.');
                                }
                            },
                            error: function (xhr) {
                                alert('Gagal untuk mendapatkan maklumat dasar semasa. ' + xhr.responseText);
                            }
                        });
                    });

                    // Save Edit
                    $('#saveEditDasarSemasa').click(function () {
                        const newDasarSemasa = $('#editDasarSemasa').summernote('code');

                        if (!newDasarSemasa.trim()) {
                            alert('Dasar semasa tidak boleh dibiarkan kosong.');
                            return;
                        }

                        const editId = $('#editIdDasarSemasa').val();

                        $.ajax({
                            url: `${baseUrl}/dasar/${editId}`,
                            method: 'PUT',
                            data: { dasarSemasa: newDasarSemasa },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#dasarSemasaModal').modal('hide');
                                loadDasarSemasas();
                            },
                            error: function (xhr) {
                                alert('Gagal mengemaskini dasar semasa. ' + xhr.responseText);
                            },
                        });
                    });
                });
            </script>
        {{-- DASAR SEMASA --}}

        {{-- JUSTIFIKASI PERMOHONAN --}}
            <script>
                $(document).ready(function () {
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    const idMaklumatPermohonan = {{ $maklumats->idMaklumatPermohonan }};

                    // Initialize Summernote for `Justifikasi Permohonan`
                    // $('.summernote').summernote();
                    $('#justifikasiPermohonan').summernote({
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline']],
                            // ['para', ['ul', 'ol', 'paragraph']],                // Paragraph formatting
                            ['view', ['fullscreen', 'codeview']]
                        ],
                        placeholder: 'Taipkan teks anda di sini, kemudian tekan butang Tambah di bawah.', // Optional placeholder text,
                        height: 100,
                        // styleTags: ['p', 'blockquote', 'pre'],
                        callbacks: {
                            onPaste: function (e) {
                                let clipboardData = (e.originalEvent || e).clipboardData || window.clipboardData;
                                let text = clipboardData.getData('Text');
                                e.preventDefault();
                                document.execCommand('insertText', false, text);
                            },
                            onChange: function(contents, $editable) {
                                var button = $('#add-justifikasiPermohonan');
                                if (contents.trim()) {
                                    button.css('background-color', 'red');  // Change text color to red
                                } else {
                                    button.css('color', '');  // Reset to default color
                                }
                            },
                        },
                    });

                    // Load Justifikasi Permohonans
                    function loadJustifikasiPermohonans() {
                        $.get(`${baseUrl}/justifikasi/${idMaklumatPermohonan}`, function (data) {
                            const justifikasiPermohonanList = $('#justifikasiPermohonan-list');
                            const heading = $('#justifikasiPermohonan-heading');
                            const justifikasiPermohonanBody = $('#justifikasiPermohonan-body');

                            justifikasiPermohonanList.empty();

                            if (data.length === 0) {
                                heading.hide();
                                justifikasiPermohonanBody.hide();
                            } else {
                                heading.show();
                                justifikasiPermohonanBody.show();
                                data.forEach((justifikasiPermohonan, index) => {
                                    justifikasiPermohonanList.append(`
                                        <li class="list-group-item" data-id="${justifikasiPermohonan.id}">
                                            ${index + 1}. ${justifikasiPermohonan.justifikasiPermohonan}
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-sm float-end ms-2 edit-justifikasiPermohonan">Kemaskini</button>
                                                <button class="btn btn-danger btn-sm float-end delete-justifikasiPermohonan">Hapus</button>
                                            </div>
                                        </li>
                                    `);
                                });
                            }
                        });
                    }

                    loadJustifikasiPermohonans();

                    // Add Justifikasi Permohonan
                    $('#add-justifikasiPermohonan').click(function (event) {
                        event.preventDefault();

                        const justifikasiPermohonan = $('#justifikasiPermohonan').summernote('code');
                        if (justifikasiPermohonan.trim() === '') {
                            alert('Sila masukkan justifikasi permohonan.');
                            return;
                        }

                        $.ajax({
                            url: `${baseUrl}/justifikasi`,
                            method: 'POST',
                            data: { justifikasiPermohonan, idMaklumatPermohonan },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#justifikasiPermohonan').summernote('reset');
                                $('#add-justifikasiPermohonan').css('background-color', ''); // Reset button background color
                                loadJustifikasiPermohonans();
                            },
                            error: function (xhr) {
                                alert('Gagal menambah justifikasi permohonan. ' + xhr.responseText);
                            },
                        });
                    });

                    // Delete Justifikasi Permohonan
                    $(document).on('click', '.delete-justifikasiPermohonan', function (event) {
                        event.preventDefault();

                        const id = $(this).closest('li').data('id');

                        $.ajax({
                            url: `${baseUrl}/justifikasi/${id}`,
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                loadJustifikasiPermohonans();
                            },
                            error: function (xhr) {
                                alert('Gagal menghapus justifikasi permohonan. ' + xhr.responseText);
                            },
                        });
                    });

                    // Open Edit Modal
                    $(document).on('click', '.edit-justifikasiPermohonan', function (event) {
                        event.preventDefault();

                        const li = $(this).closest('li');
                        const editId = li.data('id');

                        $.ajax({
                            url: `${baseUrl}/justifikasi/show/${editId}`,
                            method: 'GET',
                            success: function (data) {
                                if (data && data.justifikasiPermohonan) {
                                    $('#editIdJustifikasiPermohonan').val(editId);
                                    $('#editJustifikasiPermohonan').summernote('code', data.justifikasiPermohonan);
                                    $('#justifikasiPermohonanModal').modal('show');
                                } else {
                                    alert('Gagal mengeluarkan justifikasi permohonan.');
                                }
                            },
                            error: function (xhr) {
                                alert('Gagal untuk mendapatkan maklumat justifikasi permohonan. ' + xhr.responseText);
                            }
                        });
                    });

                    // Save Edit
                    $('#saveEditJustifikasiPermohonan').click(function () {
                        const newJustifikasiPermohonan = $('#editJustifikasiPermohonan').summernote('code');

                        if (!newJustifikasiPermohonan.trim()) {
                            alert('Justifikasi permohonan tidak boleh dibiarkan kosong.');
                            return;
                        }

                        const editId = $('#editIdJustifikasiPermohonan').val();

                        $.ajax({
                            url: `${baseUrl}/justifikasi/${editId}`,
                            method: 'PUT',
                            data: { justifikasiPermohonan: newJustifikasiPermohonan },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#justifikasiPermohonanModal').modal('hide');
                                loadJustifikasiPermohonans();
                            },
                            error: function (xhr) {
                                alert('Gagal mengemaskini justifikasi permohonan. ' + xhr.responseText);
                            },
                        });
                    });
                });
            </script>
        {{-- JUSTIFIKASI PERMOHONAN --}}

        {{-- ULASAN BAHAGIAN --}}
            <script>
                $(document).ready(function () {
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    const idMaklumatPermohonan = {{ $maklumats->idMaklumatPermohonan }};

                    // Initialize Summernote for `Ulasan Bahagian`
                    // $('.summernote').summernote();
                    $('#ulasanBahagian').summernote({
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline']],
                            // ['para', ['ul', 'ol', 'paragraph']],                // Paragraph formatting
                            ['view', ['fullscreen', 'codeview']]
                        ],
                        placeholder: 'Taipkan teks anda di sini, kemudian tekan butang Tambah di bawah.', // Optional placeholder text
                        height: 100,
                        // styleTags: ['p', 'blockquote', 'pre'],
                        callbacks: {
                            onPaste: function (e) {
                                let clipboardData = (e.originalEvent || e).clipboardData || window.clipboardData;
                                let text = clipboardData.getData('Text');
                                e.preventDefault();
                                document.execCommand('insertText', false, text);
                            },
                            onChange: function(contents, $editable) {
                                var button = $('#add-ulasanBahagian');
                                if (contents.trim()) {
                                    button.css('background-color', 'red');  // Change text color to red
                                } else {
                                    button.css('color', '');  // Reset to default color
                                }
                            },
                        },
                    });

                    // Load Ulasan Bahagians
                    function loadUlasanBahagians() {
                        $.get(`${baseUrl}/ulasan/${idMaklumatPermohonan}`, function (data) {
                            const ulasanBahagianList = $('#ulasanBahagian-list');
                            const heading = $('#ulasanBahagian-heading');
                            const ulasanBahagianBody = $('#ulasanBahagian-body');

                            ulasanBahagianList.empty();

                            if (data.length === 0) {
                                heading.hide();
                                ulasanBahagianBody.hide();
                            } else {
                                heading.show();
                                ulasanBahagianBody.show();
                                data.forEach((ulasanBahagian, index) => {
                                    ulasanBahagianList.append(`
                                        <li class="list-group-item" data-id="${ulasanBahagian.id}">
                                            ${index + 1}. ${ulasanBahagian.ulasanBahagian}
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-sm float-end ms-2 edit-ulasanBahagian">Kemaskini</button>
                                                <button class="btn btn-danger btn-sm float-end delete-ulasanBahagian">Hapus</button>
                                            </div>
                                        </li>
                                    `);
                                });
                            }
                        });
                    }

                    loadUlasanBahagians();

                    // Add Ulasan Bahagian
                    $('#add-ulasanBahagian').click(function (event) {
                        event.preventDefault();

                        const ulasanBahagian = $('#ulasanBahagian').summernote('code');
                        if (ulasanBahagian.trim() === '') {
                            alert('Sila masukkan ulasan bahagian.');
                            return;
                        }

                        $.ajax({
                            url: `${baseUrl}/ulasan`,
                            method: 'POST',
                            data: { ulasanBahagian, idMaklumatPermohonan },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#ulasanBahagian').summernote('reset');
                                $('#add-ulasanBahagian').css('background-color', ''); // Reset button background color
                                loadUlasanBahagians();
                            },
                            error: function (xhr) {
                                alert('Gagal menambah ulasan bahagian. ' + xhr.responseText);
                            },
                        });
                    });

                    // Delete Ulasan Bahagian
                    $(document).on('click', '.delete-ulasanBahagian', function (event) {
                        event.preventDefault();

                        const id = $(this).closest('li').data('id');

                        $.ajax({
                            url: `${baseUrl}/ulasan/${id}`,
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                loadUlasanBahagians();
                            },
                            error: function (xhr) {
                                alert('Gagal menghapus ulasan bahagian. ' + xhr.responseText);
                            },
                        });
                    });

                    // Open Edit Modal
                    $(document).on('click', '.edit-ulasanBahagian', function (event) {
                        event.preventDefault();

                        const li = $(this).closest('li');
                        const editId = li.data('id');

                        $.ajax({
                            url: `${baseUrl}/ulasan/show/${editId}`,
                            method: 'GET',
                            success: function (data) {
                                if (data && data.ulasanBahagian) {
                                    $('#editIdUlasanBahagian').val(editId);
                                    $('#editUlasanBahagian').summernote('code', data.ulasanBahagian);
                                    $('#ulasanBahagianModal').modal('show');
                                } else {
                                    alert('Gagal mengeluarkan ulasan bahagian.');
                                }
                            },
                            error: function (xhr) {
                                alert('Gagal untuk mendapatkan maklumat ulasan bahagian. ' + xhr.responseText);
                            }
                        });
                    });

                    // Save Edit
                    $('#saveEditUlasanBahagian').click(function () {
                        const newUlasanBahagian = $('#editUlasanBahagian').summernote('code');

                        if (!newUlasanBahagian.trim()) {
                            alert('Ulasan bahagian tidak boleh dibiarkan kosong.');
                            return;
                        }

                        const editId = $('#editIdUlasanBahagian').val();

                        $.ajax({
                            url: `${baseUrl}/ulasan/${editId}`,
                            method: 'PUT',
                            data: { ulasanBahagian: newUlasanBahagian },
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            success: function () {
                                $('#ulasanBahagianModal').modal('hide');
                                loadUlasanBahagians();
                            },
                            error: function (xhr) {
                                alert('Gagal mengemaskini ulasan bahagian. ' + xhr.responseText);
                            },
                        });
                    });
                });

            </script>
        {{-- ULASAN BAHAGIAN --}}

        {{-- Summernote --}}
            <script>
                $(document).ready(function() {
                    // $('.summernote').summernote();

                    $('.summernote').summernote({
                        toolbar: [
                            // Keep only the features you need
                            ['style', ['bold', 'italic', 'underline']], // Text styles
                            // ['para', ['ul', 'ol', 'paragraph']],                // Paragraph formatting
                            ['view', ['fullscreen', 'codeview']]               // Viewing options
                        ],
                        placeholder: 'Taipkan teks anda di sini...', // Optional placeholder text
                        // height: 100,                            // Set editor height
                        // styleTags: ['p', 'blockquote', 'pre'], // Restrict to simple tags
                        // callbacks: {
                        //     onPaste: function(e) {
                        //         let clipboardData = (e.originalEvent || e).clipboardData || window.clipboardData;
                        //         let text = clipboardData.getData('Text'); // Get plain text
                        //         e.preventDefault();
                        //         document.execCommand('insertText', false, text); // Insert plain text
                        //     },
                        // },
                    });

                    // $('.summernote').summernote({
                        // toolbar: [
                        //     ['style', ['bold', 'italic', 'underline']],
                        //     ['para', ['ul', 'ol', 'paragraph']],
                        //     ['view', ['fullscreen', 'codeview']]               // Viewing options
                        // ],
                        // fontNames: ['Arial'], // Define allowed fonts
                        // fontSizeUnits: ['pt'], // Prevents using 'rem' or '%' units
                        // callbacks: {
                        //     onInit: function () {
                        //         $('.note-btn').on('click', function () {
                        //             // Toggle 'active' class on button click
                        //             $(this).toggleClass('active');
                        //         });
                        //         // Reset styles for ordered/unordered lists
                        //         $('#summernote').on('summernote.enter', function () {
                        //             $('.note-editable').find('ol, ul').css({
                        //                 'font-size': 'inherit', // Prevent font size from being applied
                        //                 'line-height': 'inherit'
                        //             });
                        //         });
                        //     },
                            // onPaste: function (e) {
                            //     // Prevent default paste behavior
                            //     e.preventDefault();

                            //     // Get the plain text data
                            //     var plainText = (e.originalEvent || e).clipboardData.getData('text/plain');

                            //     // Insert the plain text into the editor
                            //     document.execCommand('insertText', false, plainText);

                            // }
                    //     }
                    // });


                });

            </script>
        {{-- Summernote --}}

        {{-- HANTAR POPUP N ENTER NEXT LINE --}}
            <script type="text/javascript">
            $(function () {
                    //Initialize Select2 Elements
                    $('.select2').select2();
                    $('.select2-prgn').select2({
                        minimumResultsForSearch: Infinity
                    });

                    //Popup Pengesahan Bile HANTAR
                    document.getElementById('hantar').addEventListener('click', function() {
                        Swal.fire({
                            title: 'Pengesahan',
                            text: 'Adakah anda pasti untuk menghantar permohonan ini?',
                            // icon: 'success', 
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hantar!',
                            allowOutsideClick: false 
                        })
                        .then(function (result) {
                            if (result.dismiss !== 'cancel') {
                            // if (result.isConfirmed) {
                                $("#kemaskiniForm").submit();
                            }
                        });
                    });

                    //UNTUK BAGI TEXT INPUT & TEXTAREA BOLEH TEKAN ENTER NEXT LINE
                        // Get the form element
                        var form = document.getElementById('kemaskiniForm');
                        
                        // Add an event listener for the keydown event
                        form.addEventListener('keydown', function(event) {
                        // Check if the Enter key is pressed and the shift key is not held down
                        if (event.key === 'Enter' && !event.shiftKey) {
                            // Check if the event target is a textarea or input[type="text"]
                            if (event.target.tagName === 'TEXTAREA' || event.target.tagName === 'INPUT') {
                            // Prevent the default behavior of the Enter key (form submission)
                            event.preventDefault();
                    
                            // Insert a newline character at the current cursor position
                            var textarea = event.target;
                            var cursorPosition = textarea.selectionStart;
                            var textBeforeCursor = textarea.value.substring(0, cursorPosition);
                            var textAfterCursor = textarea.value.substring(cursorPosition);
                            textarea.value = textBeforeCursor + '\n' + textAfterCursor;
                    
                            // Move the cursor position after the inserted newline character
                            textarea.selectionStart = textarea.selectionEnd = cursorPosition + 1;
                            }
                        }
                        });
                    //UNTUK BAGI TEXT INPUT & TEXTAREA BOLEH TEKAN ENTER NEXT LINE
                    
                });
            </script>
        {{-- HANTAR POPUP N ENTER NEXT LINE --}}

        {{-- HILANGKAN ALERT --}}
        <script>
            // Wait for DOM to be fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Select the alert element
                var alertElement = document.querySelector('.alert.alert-success');
                
                // Hide the alert after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    alertElement.parentNode.removeChild(alertElement);
                }, 5000);
            });
        </script>
        {{-- HILANGKAN ALERT --}}

        {{-- FOCUS ON INPUT BILA USER ERROR --}}
            @if($errors->has('nama_program'))
                <script>
                    document.getElementById("nama_program").focus();
                </script>
            @elseif($errors->has('tujuan'))
                <script>
                    // document.getElementById("tujuan").focus();
                    $(document).ready(function() {
                        $('#tujuan').summernote('focus');
                    });
                </script>
            @elseif($errors->has('latarBelakang'))
                <script>
                    // document.getElementById("latarBelakang").focus();
                    $(document).ready(function() {
                        $('#latarBelakang').summernote('focus');
                    });
                </script>
            @elseif($errors->has('dasarSemasa'))
                <script>
                    // document.getElementById("dasarSemasa").focus();
                    $(document).ready(function() {
                        $('#dasarSemasa').summernote('focus');
                    });
                </script>
            @elseif($errors->has('justifikasiPermohonan'))
                <script>
                    // document.getElementById("justifikasiPermohonan").focus();
                    $(document).ready(function() {
                        $('#justifikasiPermohonan').summernote('focus');
                    });
                </script>
            @elseif($errors->has('ulasanBahagian'))
                <script>
                    // document.getElementById("ulasanBahagian").focus();
                    $(document).ready(function() {
                        $('#ulasanBahagian').summernote('focus');
                    });
                </script>
            @elseif($errors->has('tkh_mula'))
                <script>
                    document.getElementById("tkh_mula").focus();
                </script>
            @elseif($errors->has('tkh_tamat'))
                <script>
                    document.getElementById("tkh_tamat").focus();
                </script>
            @elseif($errors->has('ruj_fail'))
                <script>
                    document.getElementById("ruj_fail").focus();
                </script>
            @elseif($errors->has('kos_mohon'))
                <script>
                    document.getElementById("kos_mohon").focus();
                </script>
            @elseif($errors->has('pengesah'))
                <script>
                    document.getElementById("pengesah").focus();
                    $(document).ready(function() {
                        // Conditionally add 'error' class based on server-side validation
                        @if ($errors->has('pengesah'))
                            $('#pengesah').next('.select2-container').find('.select2-selection--single').addClass('error');
                        @endif
                    });
                </script>
            @elseif($errors->has('syor'))
                <script>
                    document.getElementById("syor").focus();
                </script>
            @elseif($errors->has('dokumen'))
                <script>
                    document.getElementById("dokumen").focus();
                </script>
            @endif
        {{-- FOCUS ON INPUT BILA USER ERROR --}}

        {{-- AUTOSAVE --}}
            <script type="text/javascript">

                // Function to update the button text with the current timestamp
                function updateButtonTime() {
                    var currentTime = new Date();
                    var formattedTime = currentTime.toLocaleString('en-GB', { timeZone: 'Asia/Kuala_Lumpur', hour12: true, hour: 'numeric', minute: 'numeric', day: 'numeric', month: 'numeric', year: 'numeric' });
                    $('#updateTimeButton').text('Dikemaskini: ' + formattedTime);
                }

                // Auto-save function
                function autoSave() {

                    // Get the value of the selected radio button for 'perancangan'
                    var perancanganValue = $('input[name="perancangan"]:checked').val();

                    // Gather form data
                    var formData = {
                        nama_program: $('#nama_program').val(),
                        ruj_fail: $('#ruj_fail').val(),
                        // tujuan: $('#tujuan').val(),
                        // latarBelakang: $('#latarBelakang').val(),
                        // objektif1: $('#objektif1').val(),
                        // objektif2: $('#objektif2').val(),
                        // objektif3: $('#objektif3').val(),
                        // objektif4: $('#objektif4').val(),
                        // objektif5: $('#objektif5').val(),
                        tkh_mula: $('#tkh_mula').val(),
                        tkh_tamat: $('#tkh_tamat').val(),
                        perancangan: perancanganValue,
                        // syor: $('#syor').val(),
                        // pengesah: $('#pengesah').val(),
                        kos_mohon: $('#kos_mohon').val(),
                        // dokumen: $('#dokumen').val(),
                        // Add other form fields as needed
                        autosave_enabled: true, // Example condition for auto-save
                        maklumat_id: <?php echo $maklumats->idMaklumatPermohonan; ?> // Pass the ID here
                    };

                    // console.log(formData);

                    // Add CSRF token to form data
                    formData._token = '{{ csrf_token() }}';

                    // Send AJAX request to the server
                    $.ajax({
                        type: 'POST',
                        // url: '/pemohon/autoSave',
                        url: `${baseUrl}/pemohon/autoSave`,
                        // url: '/ePantas/pemohon/autoSave', //for Dev
                        data: formData,
                        success: function (response) {
                            console.log(response.message);
                            // Update button time on successful autosave
                                updateButtonTime();
                        },
                        error: function (xhr, status, error) {
                            // Handle validation errors
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                // Display validation errors to the user
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        console.error(errors[key][0]); // Log error to console
                                        // You can display errors to the user here
                                    }
                                }
                            } else {
                                console.error(error);
                            }
                        }
                    });
                }
                // Set interval for auto-save
                // setInterval(autoSave, 30000); //30 sec
                setInterval(autoSave, 5000); // 5sec

            </script>
        {{-- AUTOSAVE --}}

        <script>
            $(document).ready(function() {
                // WARNING SURUH SAVE SEBELUM TEKAN BUTTON KEMASKINI VOT
                // Show warning message when mouse hovers over the "Kemaskini" button
                $('#votButton').hover(function() {
                    $('#warningMessage').show();
                }, function() {
                    $('#warningMessage').hide();
                });

                function isNonMobile() {
                    return window.innerWidth > 768; // Adjust the width as necessary for your requirements
                }
                // Optionally, you can add a resize event listener to re-check when the window is resized
                $(window).resize(function() {
                    if (isNonMobile()) {
                        $('#votButton').hover(function() {
                            $('#warningMessage').show();
                        }, function() {
                            $('#warningMessage').hide();
                        });
                    } else {
                        // Remove hover event if it's a mobile device
                        $('#votButton').off('mouseenter mouseleave');
                        $('#warningMessage').hide();
                    }
                });
                
            });
        </script>
            
@endsection
