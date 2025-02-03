@extends('layouts.master')
@section('content')

    <style>
        .select2-K {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            height: 40px; 
            color: #444;
            border-radius:4px;
            border: 1px solid #c0bcbc;
        }
        .select2 {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            height: 40px; 
            color: #444;
            border-radius:4px;
            border: 1px solid #c0bcbc;
        }
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
    </style>
    <!--**********************************
            Content body start
        ***********************************-->

    <div class="content-body">

        <div class="col-xl-13 col-lg-13">
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
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> --}}
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h4>Kemaskini Vot</h4> --}}
                        <h3 class="font-w600 title mb-2 mr-auto">Perincian Perbelanjaan</h3>
                        <font color="red" name="arahan" id="arahan"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; Sila tekan 'Kembali' selepas mengisi vot untuk kembali ke paparan borang permohonan.</font> &nbsp;
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pemohon.kemaskini_simpanvot', $maklumats->idMaklumatPermohonan) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="nama_pengerusi" class="col-sm-3 col-form-label"
                                    style="text-align:left"> Anggaran Implikasi Kewangan
                                    {{-- style="text-align:left">No Vot. --}}
                                    <font color="red">*</font>
                                </label>
                                {{-- <textarea class="form-control" style="display:none;" id="form_VOT" name="form_VOT">{{ old('form_VOT') }}</textarea> --}}
                                <div class="table-responsive">
                                    <table id="example1" class="table table-sm table-bordered" style="width:100%; ">
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
                                                <th width="10%"></th>
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
                                                    {{-- <td><center>{{ $vot->perkara }}</center></td> --}}
                                                    <td>    
                                                        <center>
                                                            {{-- OA{{ ($vot->objekAm!='') ? \App\LkpVot::find($vot->objekAm)->noVot : '' }}@if ($vot->objekSebagai)/OS{{ $vot->objekSebagai }}     @endif --}}
                                                            {{ ($vot->objekAm!='') ? \App\LkpOA::find($vot->objekAm)->oa : '' }} / {{ ($vot->objekSebagai!='') ? \App\LkpOS::find($vot->objekSebagai)->os : '' }}
                                                        </center>
                                                    </td>
                                                    {{-- <td>{{ $vot->objekAm }}</td> --}}
                                                    {{-- <td>{{ $vot->objekSebagai }}</td> --}}
                                                    {{-- <td><center> {{ $vot->keterangan ?: '-' }} </center></td>  --}}
                                                    <td><center>@if( $vot->unit != 0 ) {{ $vot->unit }} @else - @endif</center> </td>
                                                    <td><center>{{ number_format($vot->kos, 2) }}</center> </td> <?php $kosAll = $kosAll + $vot->kos ?>
                                                    <td width="10%">
                                                        <center>
                                                            <div class="btn-group">
                                                                    {{-- <a
                                                                        class="btn btn-sm btn-success" style='color:white;'
                                                                        data-toggle="modal" data-target="#modal-kemaskini-vot-{{ $vot->idVotByAdmin }}">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a> --}}
                                                                    <a
                                                                        href="{{ route('pemohon.kemaskiniVotForm', $vot->idVotByAdmin) }}"
                                                                        class="btn btn-sm btn-success" style='color:white;'>
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a
                                                                        href="{{ route('pemohon.buang_vot', $vot->idVotByAdmin) }}"
                                                                        class="btn btn-sm btn-danger" style='color:white;'>
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                            </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                                @if ($loop->last) <!-- Check if it's the last iteration -->
                                                    <tr>
                                                        <td colspan="4" style="font-weight: bold; text-align: right;">JUMLAH KESELURUHAN</td>
                                                        <td colspan="1" style="font-weight: bold; text-align: center;">RM {{ number_format($kosAll, 2) }}</td>
                                                        <td colspan="1" style="font-weight: bold; text-align: center;">
                                                            <a
                                                                class="btn btn-sm btn-primary" style='color:white;'
                                                                data-toggle="modal" data-target="#modal-vot"><i
                                                                    class="fa fa-plus"></i> Tambah
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
    
                                                {{-- MODAL KEMASKINI VOT --}}
                                                <!--
                                                    <div class="modal fade" id="modal-kemaskini-vot-{{ $vot->idVotByAdmin }}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-purple">
                                                                    <h4 class="modal-title">KEMASKINI VOT</h4>
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
                                                                                <input type="text" class="form-control" name="perkaraK" id="perkaraK" maxlength="50" value="{{ old('perkaraK') ?? $vot->perkara }}">
                                                                            </div>
                                                                        </div>
                        
                                                                        <div class="form-group row">
                                                                            <label for="objekAm" class="col-sm-3 col-form-label"
                                                                                style="text-align:left">
                                                                                Objek Am <font color="red">*</font>
                                                                            </label>
                                                                            <div class="col-sm-9">
                                                                                {{-- <textarea class="form-control" name="objekAm" id="objekAm" cols="" rows="2"></textarea> --}}
                                                                                <select class="select2-K" id="objekAmK" name="objekAmK"
                                                                                    style="width: 100%; text-align:left;">
                                                                                    @php old('objekAmK') == NULL ? $votAm = $vot->objekAm : $votAm=old('objekAmK') @endphp
                                                                                    <option value=""
                                                                                        {{-- @if (old('objekAmK') == '') {{ 'selected="selected"' }} @endif>&nbsp; --}}
                                                                                        @if ($vot->objekAm == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                                                    </option>
                                                                                    @foreach ($objekAms as $objekAm)
                                                                                        {{-- <option value="{{ $objekAm->idVot }}" --}}
                                                                                        {{-- <option value="{{ $objekAm->noVot }}" title="{{ $objekAm->namaVot }}" --}}
                                                                                        <option value="{{ $objekAm->idVot }}" title="{{ $objekAm->noVot }}"
                                                                                            {{-- title="{{ $objekAm->namaVot }}" --}}
                                                                                            {{-- @if (old('objekAmK') == $objekAm->idVot) {{ 'selected="selected"' }} @endif> --}}
                                                                                            @if ($votAm == $objekAm->idVot) {{ 'selected="selected"' }} @endif>
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
                                                                                <input type="hidden" name="objekSebValue" id="objekSebValue" value="{{ $vot->objekSebagai }}">
                                                                                <select class="select2-K" id="objekSebK" name="objekSebK"
                                                                                    style="width: 100%;">
                                                                                    <option value=""
                                                                                        @if (old('objekSebK') == '') {{ 'selected="selected"' }} @endif>
                                                                                        &nbsp;</option>
                                                                                    <option value="" selected disabled> -- Sila Pilih Objek Am -- </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                        
                                                                        <div class="form-group row">
                                                                            <label for="unit" class="col-sm-3 col-form-label"
                                                                                style="text-align:left"> Unit
                                                                                <font color="red">*</font>
                                                                            </label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" class="form-control" name="unitK" id="unitK" value="{{ old('unitK') ?? $vot->unit }}">
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
                                                                                    <input type="number" class="form-control" name="kosK" id="kosK" value="{{ old('kosK') ?? $vot->kos}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                        
                                                                    </div>
                        
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                                        <button type="submit" class="btn btn-success btn-sm" name="kemaskini_vot" id="kemaskini_vot">
                                                                            <i class="fa fa-edit"></i>
                                                                            Kemaskini
                                                                        </button>
                                                                        {{-- <button type="button" class="btn btn-primary btn-sm" id="addData"
                                                                            onclick="tambahVot()" data-dismiss="modal"><i class="fa fa-plus"></i>
                                                                            Tambah
                                                                        </button> --}}
                                                                    </div>
                                                            </div>
                                                            /.modal-content
                                                        </div>
                                                        /.modal-dialog
                                                    </div>
                                                -->
                                                {{-- MODAL KEMASKINI VOT --}}
    
                                            @endforeach
                                        </tbody>
                                        {{-- <tbody id="senP1"></tbody> --}}
                                        @if( empty($vot) )
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7" align="right">
                                                        <a
                                                            class="btn btn-sm btn-primary" style='color:white;'
                                                            data-toggle="modal" data-target="#modal-vot"><i
                                                                class="fa fa-plus"></i> Tambah
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>

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
                                            {{-- <form class="form-horizontal" method="POST" action=""
                                                enctype="multipart/form-data" id="myForm1">
                                                {{ csrf_field() }} --}}

                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>
                                                                    {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> --}}
                                                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                                    {{ $error }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                
                                                <div class="modal-body">
                                                    
                                                    {{-- <div class="form-group row">
                                                        <label for="" class="col-sm-3 col-form-label" style="text-align:left">
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <font color="red"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; Sila pastikan semua yang bertanda * diisi.</font> &nbsp;
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
                                                                    <option value="{{ $lkpPerkara->id_lkp_perkara }}"
                                                                        @if (old('perkara') == $lkpPerkara->id_lkp_perkara) {{ 'selected="selected"' }} @endif>
                                                                        {{ $lkpPerkara->perkara }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
    
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
                                                                    <option value="{{ $objekAm->id_lkp_oa }}"
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
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <textarea class="form-control" name="objekSeb" id="objekSeb" cols="" rows="2"></textarea> --}}
                                                            <select class="select2" id="objekSeb" name="objekSeb" style="width: 100%; text-align:left;">
                                                                <option value=""
                                                                    @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                                </option>
                                                                @foreach ($objekSebs as $objekSeb)
                                                                    <option value="{{ $objekSeb->id_lkp_os }}"
                                                                        @if (old('objekSeb') == $objekSeb->id_lkp_os) {{ 'selected="selected"' }} @endif>
                                                                        {{ $objekSeb->os }}
                                                                        {{-- {{ $objekSeb->idObjek }}, {{ $objekSeb->jenisPerbelanjaan }} --}}
                                                                    </option>
                                                                    {{-- <option value="{{ $objekSeb->idObjek }}"
                                                                        @if (old('objekSeb') == $objekSeb->idObjek) {{ 'selected="selected"' }} @endif>
                                                                        OS{{ $objekSeb->idObjek }}
                                                                            {{ $objekSeb->idObjek }}, {{ $objekSeb->jenisPerbelanjaan }}
                                                                    </option> --}}
                                                                @endforeach
                                                            </select>
                                                            {{-- <select class="select2" id="objekSeb" name="objekSeb"
                                                                style="width: 100%;">
                                                                <option value="" @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif> &nbsp;</option>
                                                                <option value="" selected disabled> -- Sila Pilih Objek
                                                                    Am -- 
                                                                </option>
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
                                                            {{-- <font color="red">*</font> --}}
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control" name="unit" id="unit" value="{{ old('unit') }}">
                                                            <small> <font color="red"> (Nota: Ruangan ini tidak wajib diisi) </font> </small>
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
                                                                <input type="number" class="form-control" step="0.01" name="kos" id="kos" value="{{ old('kos') }}" placeholder="Eg: 10000, 230.50">
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                </div>
    
                                                <div class="modal-footer float-right">
                                                    {{-- <button type="button" class="btn btn-danger btn-sm"
                                                        data-dismiss="modal">Tutup</button> --}}
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="submit" class="btn btn-success btn-sm" name="tambah_vot" id="tambah_vot"><i class="fa fa-save"></i>
                                                        Simpan
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

                                {{-- @foreach ($vots as $vot) --}}
                                    
                                {{-- @endforeach --}}
                                

                            </div>
                        </form>

                        <div class=" justify-content-center">
                            <a href="{{ url('pemohon/kemaskini/' . $maklumats->idMaklumatPermohonan) }}"
                                class="btn btn-secondary float-left btn-sm" style="color: black;">
                                <i class="fas fa-redo-alt"></i> | Kembali
                            </a>
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
           $(function () {
                //Initialize Select2 Elements
                // $('.select2-vot').select2();
                // $('.select2-prgn').select2({
                //     minimumResultsForSearch: Infinity
                // // });
                $('.select2').select2({
                    minimumResultsForSearch: Infinity
                });
                $('.select2.perkara').select2();
                // $('.select2-K').select2({
                //     minimumResultsForSearch: Infinity
                // });
            });

        </script>

        <script type="text/javascript">
            $(document).ready(function() {  //MODAL TAMBAH VOT

                 // Trigger the change event for #objekAm   
                // $('#objekAm').trigger('change');

                // $(document).on('change', '#objekAm', function() {
                //     var objekAm = $(this).val();
                //     var div = $(this).parent().parent().parent();
                //     var op = " ";
                //     $.ajax({
                //         type: 'get',
                //         url: '{!! URL::to('cariObjek') !!}',
                //         data: {
                //             'id': objekAm
                //         },
                //         success: function(data) {
                //             console.log(div);
                //             op += '<option value="" @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
                //             for (var i = 0; i < data.length; i++) {
                //                 op += '<option value="' + data[i].idObjek + '">' + data[i].idObjek +
                //                     ', ' + data[i].jenisPerbelanjaan + '</option>';
                //             }
                //             div.find('#objekSeb').html(" ");
                //             div.find('#objekSeb').append(op);
                //         },
                //         error: function() {}
                //     });
                // });

            });

            // $(document).ready(function() {  //MODAL KEMASKINI VOT

            //      // Trigger the change event for #objekAm
            //     // $('#objekAm').trigger('change');

            //     $(document).on('change', '#objekAmK', function() {
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
            //                 op += '<option value="" @if (old('objekSebK') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
            //                 for (var i = 0; i < data.length; i++) {
            //                     op += '<option value="' + data[i].idObjek + '">' + data[i].idObjek +
            //                         ', ' + data[i].jenisPerbelanjaan + '</option>';
            //                 }
            //                 div.find('#objekSebK').html(" ");
            //                 div.find('#objekSebK').append(op);
            //             },
            //             error: function() {}
            //         });
            //     });

            // });

            // Function to fetch data and populate objekSebK select element
            function populateObjekSebK() {
                var objekAm = $('#objekAm').val();
                var objekSeb = $('#objekSeb').val();
                // var objekSeb = $('#objekSebValue').val();
                var div = $('#objekAm').closest('.modal-body'); // Assuming the closest parent is modal-body
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('cariObjek') !!}',
                    data: {
                        'id': objekAm
                    },
                    success: function(data) {
                        op += '<option value="" @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
                        for (var i = 0; i < data.length; i++) {

                            if ( objekSeb == data[i].idObjek ) {
                                op += '<option value="' + data[i].idObjek + '" {{ 'selected="selected"' }}>' + data[i].idObjek +
                                ', ' + data[i].jenisPerbelanjaan + '</option>';
                            }
                            else {
                                op += '<option value="' + data[i].idObjek + '">' + data[i].idObjek +
                                ', ' + data[i].jenisPerbelanjaan + '</option>';
                            }

                            
                        }
                        div.find('#objekSeb').html(" ");
                        div.find('#objekSeb').append(op);
                    },
                    error: function() {}
                });
            }

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


            // Call the function when the value of objekAmK changes
            // $(document).on('change', '#objekAm', function() {
            //     populateObjekSebK();
            // });

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
            
            <!-- Script to show modal if there are errors -->
            @if( $errors->has('perkara') || $errors->has('objekAm') || $errors->has('lain') || $errors->has('unit') || $errors->has('kos') )
                <script type="text/javascript">
                    $(document).ready(function(){
                        console.log('hello');
                        $('#modal-vot').modal('show');
                    })
                </script>
            @endif

@endsection
