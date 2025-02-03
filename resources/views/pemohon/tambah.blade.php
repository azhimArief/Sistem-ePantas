@extends('layouts.master')
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
    </style>

    <div class="content-body">
        <div class="container-fluid">

            <div class="col-xl-13 col-lg-12">
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
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i>  --}}
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        Sila pastikan borang telah dilengkapkan dengan teliti dan lengkap.
                        {{-- <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul> --}}
                    </div>
                @endif
            </div>

            <div class="col-xl-13 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h4 class="card-title">Borang Permohonan Peruntukan</h4> --}}
                        <h3 class="font-w600 title mb-2 mr-auto ">Borang Permohonan Peruntukan</h3>
                        <font color="red"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; Sila pastikan semua yang bertanda * diisi.</font> 
                    </div>
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                    <div class="card-body">
                        <div class="basic-form">

                            <form method="POST" name="tambahForm" id="tambahForm" action="{{ route('pemohon.simpanT', $user->id) }}"
                                enctype="multipart/form-data" spellcheck="false">
                                {{-- <form method="POST" action="{{ route('pemohon.simpanT', $personel->nokp) }}" enctype="multipart/form-data"> --}}
                                {{ csrf_field() }}


                                <div class="default-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link @if ( !$errors->any() && !session('failed') ){ active } @endif" data-toggle="tab" href="#pemohon"><i
                                            {{-- <a class="nav-link active" data-toggle="tab" href="#pemohon"><i --}}
                                                    class="fa fa-user-o nr-2"></i>&nbsp; Maklumat Pemohon</a>
                                            {{-- class="fa fa-plus mr-2"></i> Maklumat Pemohon</a> --}}
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if ( $errors->any() || session('failed') ){ active } @endif " data-toggle="tab" href="#maklumat"><i
                                                    class="flaticon-381-list"></i>&nbsp;&nbsp; Maklumat Permohonan</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        {{-- MAKLUMAT PEMOHON --}}
                                        <div class="tab-pane fade @if( !$errors->any() && !session('failed') ){ show active } @endif" id="pemohon" role="tabpanel">
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
                                                <label for="telefon" class="col-sm-3 col-form-label"
                                                    style="text-align:left">No.
                                                    Telefon Pejabat
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="tel_pejabat"
                                                        name="tel_pejabat" placeholder=" - "
                                                        value="{{ $user->tel_pejabat ?? '-' }}">
                                                    {{-- placeholder=" - " value="{{ $personel->tel }}"> --}}
                                                </div>

                                                <label for="tel_bimbit" class="col-sm-3 col-form-label"
                                                    style="text-align:left">No.
                                                    Telefon Bimbit <font color="red">*</font> </label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="telefon"
                                                        name="telefon" placeholder=" - " value="{{ $user->telefon ?? '-' }}">
                                                    {{-- placeholder=" - " value="{{ $personel->tel_bimbit }}"> --}}
                                                </div>
                                            </div>

                                            <div class=" justify-content-center">
                                                <a href="{{ url('pemohon/menu/' . $user->id) }}"
                                                    class="btn btn-secondary float-left btn-sm">
                                                    {{-- <a href="{{ url('pemohon/menu/' . $personel->nokp) }}" class="btn btn-secondary float-left btn-sm"> --}}
                                                    <i class="fas fa-redo-alt"></i> | Kembali
                                                </a>
                                            </div>

                                        </div>

                                        {{-- MAKLUMAT PERMOHONAN --}}
                                        <div class="tab-pane fade @if( $errors->any() || session('failed') ){ show active }@endif" id="maklumat">
                                            <br>
                                            <br>

                                            <div class="form-group row">
                                                <label for="id_tujuan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Tajuk Permohonan 
                                                        <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    {{-- <input type="text" class="form-control"> --}}
                                                    <textarea class="form-control" name="nama_program" id="nama_program" cols="" rows="2"
                                                        value="{{ old('nama_program') }}">{{ old('nama_program') }}</textarea>
                                                    @error('nama_program') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tujuan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Tujuan
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    {{-- <input type="text" class="form-control"> --}}
                                                    <textarea class="form-control" name="tujuan" id="tujuan" cols="" rows="2"
                                                        value="{{ old('tujuan') }}">{{ old('tujuan') }}</textarea>
                                                    @error('tujuan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="latarBelakang" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Latar Belakang
                                                    <font color="red">*</font>
                                                    &nbsp;
                                                    <div class="hover-text-latarBelakang">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">
                                                            <b>Cara masukkan latar belakang:</b> <br> 
                                                            (Nombor Roman) <br>
                                                            i. latar belakang. <br>
                                                            ii. latar belakang. <br>
                                                            iii. latar belakang. <br>
                                                            <br>
                                                            atau <br>
                                                            <br>
                                                            (Dalam bentuk perenggan)
                                                            <p style="text-align: left">
                                                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ex ducimus eveniet iure possimus aperiam, soluta mollitia voluptatibus dolorum maxime qui?
                                                            </p>
                                                        </span>
                                                    </div>
                                                </label>
                                                <div class="col-sm-9">
                                                    {{-- <input type="text" class="form-control"> --}}
                                                    <textarea class="form-control" name="latarBelakang" id="latarBelakang" cols="" rows="2"
                                                        value="{{ old('latarBelakang') }}">{{ old('latarBelakang') }}</textarea>
                                                    @error('latarBelakang') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nama_pengerusi" class="col-sm-3 col-form-label"
                                                    style="text-align:left"> Objektif
                                                    <font color="red">*</font>
                                                </label>
                                                <textarea class="form-control" style="display:none;" id="form_OBJ" name="form_OBJ">{{ old('form_OBJ') }}</textarea>
                                                <div class="table-responsive">
                                                    <table id="example1" name="objektifTable"
                                                        class="table table-sm table-responsive-sm table-bordered"
                                                        style="width:100%; ">
                                                        {{-- <thead class="thead-light"> --}}
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">
                                                                    <center>Bil.</center>
                                                                </th>
                                                                <th>
                                                                    <center>Objektif</center>
                                                                </th>
                                                                {{-- <th><center>Status</center></th> --}}
                                                                <th width="10%">&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="senOBJ"> 
                                                            {{-- @error('objektif1') <div class="text-danger">{{ $message }}</div> @enderror --}}
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="7" align="right">
                                                                    @if($errors->has('objektif1'))
                                                                        <div class="text-danger text-strong">Sila pastikan anda telah memasukkan sekurang-kurangnya 1 objektif.</div>
                                                                    @endif
                                                                    <input type="hidden" id="errorObjektif">
                                                                    <br>
                                                                    <a
                                                                        class="btn btn-sm btn-primary" style='color:white;'
                                                                        data-toggle="modal" data-target="#modal-obj" name="objektifButton" id="objektifButton">
                                                                        <i class="fa fa-plus"></i> 
                                                                        Tambah
                                                                    </a>
                                                                </td>
                                                                {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                            </tr>
                                                            <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                {{-- @error('objektif1' || 'objektif2' || 'objektif3') 
                                                    <div class="text-danger"> Sila pastikan anda telah memasukkan 3 Objektif.
                                                        {{ $message }}
                                                    </div> 
                                                @enderror --}}
                                            </div>

                                            <div class="form-group row">
                                                <label for="perancangan" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Status Program
                                                    <font color="red">*</font>
                                                </label>
                                                {{-- <div class="col-sm-6" style="@if ($errors->has('perancangan')) border: 2px solid red; @endif"> --}}
                                                <div class="col-sm-6">
                                                    <label class="radio-inline mr-3">
                                                        <input type="radio" name="perancangan" id="perancangan" value="1"
                                                            {{ old('perancangan') == '1' ? 'checked' : '' }}>
                                                        Dalam Perancangan Perolehan Tahunan
                                                    </label>
                                                    <br>
                                                    <label class="radio-inline mr-3">
                                                        <input type="radio" name="perancangan" id="perancangan" value="2"
                                                            {{ old('perancangan') == '2' ? 'checked' : '' }}>
                                                        Tiada Dalam Perancangan Perolehan Tahunan
                                                    </label>
                                                    @error('perancangan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
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
                                                <label for="tkh_mula" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Tarikh Mula 
                                                    <font color= "red">*</font> 
                                                    &nbsp;   
                                                    <div class="hover-text">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">Tarikh mula program/perolehan</span>
                                                    </div>
                                                </label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                        <input type="date" class="form-control" id="tkh_mula"
                                                            name="tkh_mula" value="{{ old('tkh_mula') }}" title="Tarikh Mula Program">
                                                    </div>
                                                    @error('tkh_mula') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    {{-- <div class="input-group date" id="tkh_mula" data-target-input="nearest" placeholder="Tarikh Pergi">
                                                    <input type="text" id="tkh_mula" name="tkh_mula" class="form-control datetimepicker-input" data-target="#tkh_mula" value="{{ old('tkh_mula') }}"/>
                                                    <div class="input-group-append" data-target="#tkh_mula" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div> --}}
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tkh_tamat" class="col-sm-3 col-form-label"
                                                    style="text-align:left"> Tarikh Tamat
                                                    &nbsp;   
                                                    <div class="hover-text">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">Tarikh tamat program/perolehan</span>
                                                    </div>
                                                    {{-- <font color= "red">*</font>  --}}
                                                </label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" id="tkh_tamat"
                                                            name="tkh_tamat" value="{{ old('tkh_tamat') }}" title="Tarikh Tamat Program">
                                                    </div>
                                                    
                                                    @error('tkh_tamat') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    {{-- <div class="input-group date" id="tkh_tamat" data-target-input="nearest" placeholder="Tarikh Pergi">
                                                    <input type="text" id="tkh_tamat" name="tkh_tamat" class="form-control datetimepicker-input" data-target="#tkh_tamat" value="{{ old('tkh_tamat') }}"/>
                                                    <div class="input-group-append" data-target="#tkh_tamat" data-toggle="datetimepicker">
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
                                                        <input type="text" class="form-control" id="ruj_fail" name="ruj_fail" value="{{ old('ruj_fail') }}">
                                                    </div>
                                                    @error('ruj_fail') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div>

                                            @if ( $user->agensi != 'Kementerian Perpaduan Negara (KPN)' && $user->agensi != 'Kementerian Perpaduan Negara')
                                                <br>
                                                <hr style=" border-top: 2px solid #000000">
                                                {{-- <br> --}}

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-3 col-form-label" style="text-align:left"> Pengesah Permohonan
                                                        {{-- &nbsp;   
                                                        <div class="hover-text">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                            <span class="tooltip-text" id="right">Tarikh tamat program/perolehan</span>
                                                        </div> --}}
                                                        {{-- <font color= "red">*</font>  --}}
                                                    </label>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="nama_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Nama </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="nama_pengesah" name="nama_pengesah" value="{{ old('nama_pengesah') }}">
                                                        </div>
                                                        @error('nama_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="jawatan_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Jawatan </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="jawatan_pengesah" name="jawatan_pengesah" value="{{ old('jawatan_pengesah') }}">
                                                        </div>
                                                        @error('jawatan_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="bahagian_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Bahagian </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="bahagian_pengesah" name="bahagian_pengesah" value="{{ old('bahagian_pengesah') }}">
                                                        </div>
                                                        @error('bahagian_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="agensi_pengesah" class="col-sm-3 col-form-label" style="text-align:left"> Kementerian
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="agensi_pengesah" name="agensi_pengesah" value="{{ $user->agensi  ?? old('agensi_pengesah') }}">
                                                        </div>
                                                        @error('agensi_pengesah') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    </div>
                                                </div>

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
                                                        <option value=""
                                                            @if (old('pengesah') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                        </option>
                                                        @foreach ($pengesahs as $pengesah)
                                                            <option value="{{ $pengesah->id }}"
                                                                @if (old('pengesah') == $pengesah->id) {{ 'selected="selected"' }} @endif>
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
                                                        class="table table-sm table-responsive-sm table-bordered"
                                                        style="width:100%; ">
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
                                                                {{-- <th><center>Status</center></th> --}}
                                                                <th width="10%">&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="senP1"></tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="7" align="right">
                                                                    @error('kos_mohon') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                                    <br>
                                                                    <a
                                                                        class="btn btn-sm btn-primary" style='color:white;'
                                                                        data-toggle="modal" data-target="#modal-vot" id="votButton">
                                                                        <i class="fa fa-plus"></i> Tambah
                                                                    </a>
                                                                </td>
                                                                {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                            </tr>
                                                            <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                {{-- @error('kos_mohon') <div class="text-danger text-strong">{{ $message }}</div> @enderror --}}
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
                                                        <input type="number" class="form-control" name="kos_mohon"
                                                            id="kos_mohon" value="{{ old('kos_mohon') }}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row">
                                                <label for="syor" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Syor
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="syor" id="syor" cols="" rows="2"
                                                        value="{{ old('syor') }}">{{ old('syor') }}</textarea>
                                                    @error('syor') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                </div>
                                            </div> --}}

                                            <div class="form-group row">
                                                <label for="dokumen" class="col-sm-3 col-form-label"
                                                    style="text-align:left">Dokumen Tambahan
                                                    <br>
                                                    <small> <font color="red">(format PDF sahaja - Maksimun 1 MB.)</font> </small>
                                                </label>
                                                <div class="col-sm-9">
                                                    {{-- <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Lampiran</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" name="kertas_cadangan" id="kertas_cadangan" class="custom-file-input" value="{{ old('kertas_cadangan') }}">
                                                        <label class="custom-file-label">Pilih fail...</label>
                                                    </div>
                                                </div> --}}
                                                    <input type="file" class="form-control" id="dokumen"
                                                        name="dokumen" value="{{ old('dokumen') }}" />
                                                    @error('dokumen') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                                    {{-- <div class="input-group">
                                                    <div class="custom-file">
                                                    <input type="file" id="kertas_cadangan" name="kertas_cadangan" class="custom-file-input" >
                                                    <label for="kertas_cadangan" class="custom-file-label" ><i>Sila kepilkan lampiran (Jika ada).</i></label>
                                                    </div><!-- /.input group -->
                                                </div> --}}
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

                                            <div class="justify-content-center">
                                                {{-- <a href="/peruntukan/tindakan" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                                        class="fa fa-paper-plane"></i> |
                                                         Hantar
                                                </a> --}}
                                                <!-- Button trigger modal -->
                                                    {{-- <button type="button" class="btn btn-primary float-left btn-sm" data-toggle="modal"
                                                    data-target="#exampleModalCenter"><i class="fa fa-paper-plane"></i> | Hantar
                                                </button> --}}
            
                                                <br>
                                                <button type="button" name="hantar" id="hantar" class="btn btn-info float-right btn-sm" >
                                                    <i class="fa fa-paper-plane"></i> | Hantar
                                                </button>
            
                                                <button type="submit" id="simpan" name="simpan" class="btn btn-success float-right btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> |
                                                    Simpan
                                                </button>

                                                <a href="{{ url('pemohon/menu/' . $user->id) }}"
                                                    class="btn btn-secondary float-left btn-sm">
                                                    {{-- <a href="{{ url('pemohon/menu/' . $personel->nokp) }}" class="btn btn-secondary float-left btn-sm"> --}}
                                                    <i class="fas fa-redo-alt"></i> | Kembali
                                                </a>
                                                
                                            </div>

                                        </div>
                                        
                                    </div>
                                </div>

                                {{-- MODAL OBJEKTIF --}}
                                <div class="modal fade" id="modal-obj">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">TAMBAH OBJEKTIF</h4>
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
                                                            <textarea class='form-control' name="objektif1" id="objektif1" cols="" rows="2">{{ old('objektif1') }}</textarea>
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
                                                            <textarea class='form-control' name="objektif2" id="objektif2" cols="" rows="2">{{ old('objektif2') }}</textarea>
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
                                                            <textarea class='form-control' name="objektif3" id="objektif3" cols="" rows="2">{{ old('objektif3') }}</textarea>
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
                                                            <textarea class='form-control' name="objektif4" id="objektif4" cols="" rows="2">{{ old('objektif4') }}</textarea>
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
                                                            <textarea class='form-control' name="objektif5" id="objektif5" cols="" rows="2">{{ old('objektif5') }}</textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- <div class="modal-footer justify-content-between float-right"> --}}
                                                <div class="modal-footer float-right">
                                                    {{-- <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                        Batal
                                                    </button> --}}
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="submit" class="btn btn-success btn-sm float-right" name="submit_obj" id="submit_obj">
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

                            </form>

                            {{-- MODAL VOT --}}
                            <div class="modal fade" id="modal-vot"> 
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-purple">
                                            <h4 class="modal-title">TAMBAH VOT</h4>
                                            <font color="red"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; Sila pastikan semua yang bertanda * diisi.</font> &nbsp;

                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="form-horizontal" method="POST" action=""
                                            enctype="multipart/form-data" id="myForm1">
                                            {{ csrf_field() }}
                                            <div class="modal-body">

                                                {{-- <div class="form-group row">
                                                    <label for="perkara" class="col-sm-3 col-form-label"
                                                        style="text-align:left">
                                                            Perkara
                                                        <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="perkara" id="perkara" maxlength="50">
                                                    </div>
                                                </div> --}}
                                                <div class="form-group row">
                                                    <label for="perkara" class="col-sm-3 col-form-label"
                                                        style="text-align:left">
                                                            Perkara
                                                        <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        {{-- <input type="text" class="form-control" name="perkara" id="perkara" maxlength="50" value="{{ old('perkara') }}"> --}}
                                                        <select class="select2 perkara" id="perkara" name="perkara"
                                                            style="width: 100%; text-align:left; height:41px;">
                                                            <option value=""
                                                                @if (old('perkara') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                            </option>
                                                            @foreach ($lkpPerkaras as $lkpPerkara)
                                                                <option value="{{ $lkpPerkara->id_lkp_perkara }}" title="{{ $lkpPerkara->perkara }}"
                                                                    @if (old('perkara') == $lkpPerkara->id_lkp_perkara) {{ 'selected="selected"' }} @endif>
                                                                    {{ $lkpPerkara->perkara }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- <div class="form-group row">
                                                    <label for="objekAm" class="col-sm-3 col-form-label"
                                                        style="text-align:left">
                                                        Objek Am <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <select class="select2-objekAm" id="objekAm" name="objekAm"
                                                            style="width: 100%; text-align:left;">
                                                            <option value=""
                                                                @if (old('objekAm') == '') {{ 'selected="selected"' }} @endif>
                                                                &nbsp;
                                                            </option>
                                                            @foreach ($objekAms as $objekAm)
                                                                <option value="{{ $objekAm->idVot }}"
                                                                    title="{{ $objekAm->noVot }}"
                                                                    @if (old('objekAm') == $objekAm->idVot) {{ 'selected="selected"' }} @endif>
                                                                    {{ $objekAm->noVot }}, {{ $objekAm->namaVot }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                <div class="form-group row">
                                                    <label for="objekAm" class="col-sm-3 col-form-label"
                                                        style="text-align:left">
                                                        Objek Am <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <select class="select2" id="objekAm" name="objekAm"
                                                            style="width: 100%; text-align:left;">
                                                            <option value=""
                                                                @if (old('objekAm') == '') {{ 'selected="selected"' }} @endif>
                                                                &nbsp;
                                                            </option>
                                                            @foreach ($objekAms as $objekAm)
                                                                {{-- <option value="{{ $objekAm->idVot }}" title="{{ $objekAm->noVot }}" --}}
                                                                <option value="{{ $objekAm->id_lkp_oa }}" title="{{ $objekAm->oa }}"
                                                                    @if (old('objekAm') == $objekAm->id_lkp_oa) {{ 'selected="selected"' }} @endif>
                                                                    {{-- @if (old('objekAm') == $objekAm->idVot) {{ 'selected="selected"' }} @endif> --}}
                                                                    {{-- @if (old('objekAm') == $objekAm->noVot) {{ 'selected="selected"' }} @endif> --}}
                                                                    {{ $objekAm->oa }}
                                                                    {{-- OA{{ $objekAm->noVot }} --}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>  
                                                </div>

                                                <div class="form-group row">
                                                    <label for="objekSeb" class="col-sm-3 col-form-label"
                                                        style="text-align:left">
                                                        Objek Sebagai 
                                                        <font color="red">*</font>
                                                        {{-- <br><small> <font color="red"> (Nota: Isi ruangan ini jika Objek Am mempunyai Objek Sebagai.) </font> </small> --}}
                                                    </label>

                                                    <div class="col-sm-9">
                                                        {{-- <textarea class="form-control" name="objekSeb" id="objekSeb" cols="" rows="2"></textarea> --}}
                                                        <select class="select2" id="objekSeb" name="objekSeb" style="width: 100%; text-align:left;">
                                                        <option value=""
                                                            @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                        </option>
                                                        @foreach ($objekSebs as $objekSeb)
                                                            <option value="{{ $objekSeb->id_lkp_os }}" title="{{ $objekSeb->os }}"
                                                                @if (old('objekSeb') == $objekSeb->id_lkp_os) {{ 'selected="selected"' }} @endif>
                                                                {{ $objekSeb->os }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                        {{-- <select class="select2-objekSeb" id="objekSeb" name="objekSeb"
                                                            style="width: 100%;">
                                                            <option value=""
                                                                @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>
                                                                &nbsp;</option>
                                                            <option value="" selected disabled> -- Sila Pilih Objek
                                                                Am -- </option>
                                                        </select> --}}
                                                        {{-- <br><small> <font color="red"> (Nota: Isi ruangan ini jika Objek Am mempunyai Objek Sebagai.) </font> </small> --}}

                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="lain" class="col-sm-3 col-form-label"
                                                        style="text-align:left"> Nyatakan jika lain-lain
                                                        {{-- <font color="red">*</font> --}}
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="lain" id="lain" value="{{ old('lain') }}">
                                                        <small> <font color="red"> (Nota: Isi ruangan ini hanya jika perkara tidak terdapat di pilihan.) </font> </small>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="unit" class="col-sm-3 col-form-label"
                                                        style="text-align:left"> Unit/Bilangan
                                                        {{-- <br><small> <font color="red"> (Nota: Ruangan ini tidak wajib diisi) </font> </small> --}}
                                                        {{-- <font color="red">*</font> --}}
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="unit" id="unit">
                                                        <small> <font color="red"> (Nota: Ruangan ini tidak wajib diisi.) </font> </small>
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
                                                            <input type="number" class="form-control" name="kos"
                                                                id="kos">
                                                        </div>
                                                    </div>
                                                </div>


                                                {{-- <div class="form-group row">
                                                <label for="statusVot" class="col-sm-3 col-form-label" style="text-align:left">
                                                    Status <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <select class="select2" id="statusVot" name="statusVot"
                                                        style="width: 100%; text-align:left;">
                                                        <option value=""
                                                            @if (old('statusVot') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                        </option>
                                                        <option value="Ada Peruntukan" 
                                                            @if (old('perancangan') == 'Ada Peruntukan') {{ 'selected="selected"' }} @endif>
                                                            Ada Peruntukan
                                                        </option>
                                                        <option value="Tiada Peruntukan" 
                                                            @if (old('perancangan') == 'Tiada Peruntukan') {{ 'selected="selected"' }} @endif>
                                                            Tiada Peruntukan
                                                        </option>
                                                        @foreach ($optStatus as $opt_status)
                                                            @if ($opt_status->id_status != 11)
                                                                <option value="{{ $opt_status->id_status }}" title="{{ $opt_status->status }}"
                                                                    @if (old('statusVot') == $opt_status->id_status) {{ 'selected="selected"' }} @endif>
                                                                    {{ $opt_status->status }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}

                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    data-dismiss="modal">Tutup</button>
                                                {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                <button type="button" class="btn btn-primary btn-sm" id="addData"
                                                    onclick="tambahVot()" data-dismiss="modal"><i class="fa fa-plus"></i>
                                                    Tambah</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            {{-- MODAL VOT --}}

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
    <script type="text/javascript">
        // $(function() {
        //     //Initialize Select2 Elements
        //     $('.select2').select2();
        // });
        
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
                    $("#tambahForm").submit();
                }
            });
        }); 
        //Popup Pengesahan Bile HANTAR


        //UNTUK BAGI TEXT INPUT & TEXTAREA BOLEH TEKAN ENTER NEXT LINE
            // Get the form element
            var form = document.getElementById('tambahForm');
        
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

         //IF ADE VALUE PERKARA DIM INPUT #LAIN, ELSE TAKDE VALUE X YAH DIM INPUT #LAIN
         function InputLainLain() {
            var perkara = $('#perkara').val();
            // Assuming the closest parent is modal-body
            var div = $('#perkara').closest('.modal-body');

            if (perkara === null || perkara === '') {
                console.log('true'); // true if the dropdown is empty
                div.find('#lain').prop('readonly', false); // Enable the input if the dropdown is empty
                    // Clear the selected value of #objekAm and trigger change event
                    $('#objekAm').val('').trigger('change');
                    // Clear the selected value of #objekSeb and trigger change event
                    $('#objekSeb').val('').trigger('change');
            } else {
                console.log('false'); // false if the dropdown is not empty
                div.find('#lain').prop('readonly', true); // Disable the input if the dropdown is not empty
            }
        }
        //IF ADE VALUE PERKARA DIM INPUT #LAIN, ELSE TAKDE VALUE X YAH DIM INPUT #LAIN

        // Function to fetch data and populate Objek Am & Objek Sebagai based on Perkara yang dipilih
        function populatePerkaraObjek() {
                var perkara = $('#perkara').val();
                // var objekAm = $('#objekAm').val();
                // var objekSeb = $('#objekSeb').val();
                // var objekSeb = $('#objekSebValue').val();
                var div = $('#perkara').closest('.modal-body'); // Assuming the closest parent is modal-body
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('cariPerkara') !!}',
                    data: {
                        'id': perkara
                    },
                    success: function(data) {
                        // console.log(data.oa);
                        // console.log(data.os);

                        var op1 = '<option value="' + data.oa.id_lkp_oa + '" selected>' + data.oa.oa + '</option>';
                        var op2 = '<option value="' + data.os.id_lkp_os + '" selected>' + data.os.os + '</option>';

                        // div.find('#objekAm').html(" ");
                        // div.find('#objekSeb').html(" ");
                        div.find('#objekAm').append(op1);
                        div.find('#objekSeb').append(op2);
                    },
                    error: function() {}
                });
            }

            // Call the function when the value of Perkara changes
            $(document).on('change', '#perkara', function() {
                populatePerkaraObjek();
                InputLainLain();
            });
            // Call the function when the page loads
            $(document).ready(function() {
                // populateObjekSebK();
                InputLainLain();
            });
        // Function to fetch data and populate Objek Am & Objek Sebagai based on Perkara yang dipilih

    </script>

    <script type="text/javascript">
        // $(document).ready(function() {
            
        //     $(document).on('change', '#objekAm', function() {
        //         var objekAm = $(this).val();
        //         var div = $(this).parent().parent().parent();
        //         var op = " ";
        //         $.ajax({
        //             type: 'get',
        //             url: '{!! URL::to('cariObjek') !!}',
        //             data: {
        //                 'id': objekAm
        //             },
        //             success: function(data) {
        //                 console.log(div);
        //                 op +=
        //                     '<option value="" @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
        //                 for (var i = 0; i < data.length; i++) {
        //                     op += '<option value="' + data[i].idObjek + '">' + data[i].idObjek +
        //                         ', ' + data[i].jenisPerbelanjaan + '</option>';
        //                 }
        //                 div.find('#objekSeb').html(" ");
        //                 div.find('#objekSeb').append(op);
        //             },
        //             error: function() {}
        //         });
        //     });

        // });


        $(function() {
            $('.select2').select2();
            $('.select2 vot').select2();
            $('.select2-objekAm').select2({
                minimumResultsForSearch: Infinity
            });
            $('.select2-objekSeb').select2({
                minimumResultsForSearch: Infinity
            });

            updateVot();
        });

        function tambahVot() {
            // var form_VOT = btoa('x|x' + $('#perkara').val() +

            var form_VOT = btoa('x|x' +  $('#perkara').select2('data')[0].id +
                                'x|x' + $('#perkara').select2('data')[0].title +
                'x|x' + $('#objekAm').select2('data')[0].id +
                'x|x' + $('#objekAm').select2('data')[0].text + //NO VOT AM
                // 'x|x' + $('#objekAm').select2('data')[0].text +
                'x|x' + $('#objekSeb').select2('data')[0].id +
                'x|x' + $('#objekSeb').select2('data')[0].text +
                // 'x|x' + $('#objekSeb').select2('data')[0].text +
                'x|x' + $('#lain').val() + 
                'x|x' + $('#unit').val() + 
                'x|x' + $('#kos').val()) + '|x|x|';

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

            $('#form_VOT').val($('#form_VOT').val() + form_VOT);

            updateVot();
            $('#perkara').val('');
            $('#perkara').trigger('change');
            $('#objekAm').val('');
            $('#objekAm').trigger('change');
            $('#objekSeb').val('');
            $('#objekSeb').trigger('change');
            $('#lain').val('');
            $('#unit').val('');
            $('#kos').val('');
            // $('#statusVot').val('');
            // $('#statusVot').trigger('change');
        }

        function updateVot() {
            var newSenP = '';
            var splitP = $('#form_VOT').val().split('|x|x|');
            var kosProg = parseFloat(0); //initialize 
            for (var p = 0; p < splitP.length - 1; p++) {
                var bil = p + 1;
                var column = atob(splitP[p]).split('x|x');
                console.log(column);

                var perkaraId = column[1];
                // var perkara = column[2];
                if ( column[2] === null || column[2] === "" ) { var perkara = column[7]; }
                else { var perkara = column[2]; }
                var objekAmId = column[3]; //NO ID OA
                var objekAmTitle = column[4]; //Title OA
                var objekSebId = column[5]; //NO ID OS
                var objekSebTitle = column[6]; //NO Title OS
                // var objekAmtitle = column[3]; //NO VOT AM
                // var objekAmNama = column[4];

                // if( column[3] != "" ) { 
                //     var objekAmtitle = 'OA' + column[3]; //NO VOT OA
                // }
                // else {
                //     var objekAmtitle = ''; //NO VOT OA
                // }

                // if( column[5] != "" ) { 
                //     var objekSebId = '/ OS' + column[5]; //KOD OS 
                // }
                // else {
                //     var objekSebId = ''; //KOD OS 
                // }
                
                // var objekSebNama = column[6];
                var lain = column[7];
                var unit = column[8];
                var kos = column[9];

                kosProg = kosProg + parseFloat(kos);

                newSenP = newSenP +
                    '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' +
                    bil + '.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' +
                    perkara + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' +
                    objekAmTitle + '/' + objekSebTitle + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' +
                    // objekAmtitle + objekSebId + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' +
                    // objekSebId + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' +
                    // lain + '</td><td style="border: 1px solid #EEEEEE;text-align:center;"> RM' +
                    unit + '</td><td style="border: 1px solid #EEEEEE;text-align:center;"> RM' +
                    kos + '</td>' +
                    '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' +
                    p +
                    '" onclick="removeVot(' + p + ');" title="' + splitP[p] +
                    '"><i class="fa fa-trash"></i></button></td></tr>';
            }
            $('#senP1').html(newSenP);

            $('#kos_mohon').val(kosProg);
        }

        function removeVot(p1) {
            var form_VOT = '';
            var splitP = $('#form_VOT').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                if (p1 != p) {
                    form_VOT += splitP[p] + '|x|x|';
                }
            }
            $('#form_VOT').val(form_VOT);
            updateVot();
        }


        //Prevent From User Tekan ENTER Key
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('keydown', function(e) {
                // Disable form submission on Enter key press
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    </script>

    {{-- FOCUS ON INPUT BILA USER ERROR --}}
    @if($errors->has('nama_program'))
        <script>
            document.getElementById("nama_program").focus();
        </script>
    @elseif($errors->has('tujuan'))
        <script>
            document.getElementById("tujuan").focus();
        </script>
    @elseif($errors->has('latarBelakang'))
        <script>
            document.getElementById("latarBelakang").focus();
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
    {{-- FOCUS ON INPUT BILA USER USER ERROR --}}

@endsection
