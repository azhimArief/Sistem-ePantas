@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                Content body start
            ***********************************-->
    
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
        
        <div class="container-fluid">
            <div class="col-xl-13 col-lg-12">
                <div class="card">
                    {{-- <div class="card-header"> --}}
                    {{-- <div class="card-header" style="background-color: rgb(175, 175, 252)">     --}}
                    <div class="card-header">    
                        {{-- <h4 class="card-title">Tindakan Kewangan</h4> --}}
                        <h3 class="font-w600 title mb-2 mr-auto">Kemaskini Tindakan</h3>
                        {{-- <a class="btn btn-light float-right" data-toggle="modal" data-target="#modal-butiran" style="cursor: pointer;" title="Tekan untuk lihat butiran peruntukan">
                            <i class="fa fa-eye"></i> | Lihat Butiran
                        </a> --}}
                    </div>
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form-horizontal" method="POST" action="{{ url('/peruntukan/kemaskini/tindakan/simpan/' . $maklumats->idMaklumatPermohonan) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                {{-- KEMASKINI KEWANGAN --}}
                                @if ( $maklumats->id_status == 13 || $maklumats->id_status == 14 )
                                    <div class="form-group row">
                                        <label for="vot" class="col-sm-3 col-form-label"
                                            style="text-align:left"> Anggaran Implikasi Kewangan
                                            {{-- style="text-align:left">No Vot. --}}
                                            <font color="red">*</font>
                                        </label>
                                        {{-- <textarea class="form-control" style="display:none;" id="form_VOT" name="form_VOT">{{ old('form_VOT') }}</textarea> --}}
                                        <div class="table-responsive">
                                            <table id="example1"
                                                class="table table-sm table-bordered"
                                                style="width:98%; margin-left:10px;">
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
                                                            <td><center>@if( $vot->unit != 0 ) {{ $vot->unit }} @else - @endif</center></td>
                                                            <td><center>RM{{ number_format($vot->kos, 2) }}</center></td> <?php $kosAll = $kosAll + $vot->kos ?>
                                                        </tr>
                                                        @if ($loop->last) <!-- Check if it's the last iteration -->
                                                            <tr>
                                                                <td colspan="4" style="font-weight: bold; text-align: right;">JUMLAH KESELURUHAN</td>
                                                                <td colspan="1" style="font-weight: bold; text-align: center;">RM {{ number_format($kosAll, 2) }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                                {{-- <tbody id="senP1"></tbody> --}}
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7" align="right">
                                                            <a
                                                                href="{{ route('peruntukan.tindakan_votK', $maklumats->idMaklumatPermohonan) }}"
                                                                class="btn btn-sm btn-success" style='color:white;'>
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
                                        <label for="id_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Status
                                            Peruntukan <font color="red">*</font>
                                        </label>
                                        <div class="col-sm-4">
                                            {{-- <select class="select2" id="status" name="status"
                                                style="width: 100%; text-align:left;" required>
                                                <option value=""
                                                    @if (old('status') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                </option>
                                                @foreach ($optStatus as $opt_status)
                                                    <option value="{{ $opt_status->id_status }}"
                                                        @if (old('status') == $opt_status->id_status) {{ 'selected="selected"' }} @endif>
                                                        {{ $opt_status->status }}
                                                    </option>
                                                @endforeach
                                            </select> --}}
                                            <div class="form-group mb-0">
                                                <label class="radio-inline mr-3"><input type="radio" name="status" value="13"  {{ $maklumats->id_status == '13' ? 'checked' : '' }} required> 
                                                    Ada
                                                </label>
                                                <label class="radio-inline mr-3"><input type="radio" name="status" value="14" {{ $maklumats->id_status == '14' ? 'checked' : '' }}> 
                                                    Tiada
                                                </label>
                                                @error('status') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="nama_pengerusi" class="col-sm-3 col-form-label"
                                            style="text-align:left">Punca Peruntukan
                                            {{-- <font color="red">*</font> --}}
                                        </label>
                                        <div class="col-sm-4">
                                            <select class="select2" id="punca" name="punca" style="width: 100%; text-align:left">
                                                @php old('punca') == NULL ? $puncaOpt = $maklumats->id_jenis_perbelanjaan : $puncaOpt = old('punca') @endphp
                                                <option value=""@if ($puncaOpt == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                                <option value="B14" {{ $puncaOpt == 'B14' ? 'selected' : '' }}>B14 - Kementerian Perpaduan Negara </option>
                                                <option value="B11" {{ $puncaOpt == 'B11' ? 'selected' : '' }}>B11 - Kementerian Kewangan</option>
                                            </select>
                                            @error('punca') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ulasan" class="col-sm-3 col-form-label" style="text-align:left">Ulasan
                                            {{-- <font color="red">*</font> --}}
                                        </label>
                                        <div class="col-sm-7">
                                            <textarea id="ulasan" name="ulasan" type="text" class="form-control" rows="4" value="{{ old('ulasan') }}"
                                                placeholder="">{{ $tindakan->Ulasan }}</textarea>
                                        </div>
                                    </div>
                                @endif
                                {{-- KEMASKINI KEWANGAN --}}

                                {{-- KEMASKINI SUBKP --}}
                                @if ( $maklumats->id_status == 15 || $maklumats->id_status == 16 )

                                    <div class="col-sm-12">
                                        <br> 
                                        <label class="radio-inline mr-3"><input type="radio" name="optSokong" value="15" {{ $maklumats->id_status == '15' ? 'checked' : '' }} required> Sokong</label>
                                        <label class="radio-inline mr-3"><input type="radio" name="optSokong" value="16" {{ $maklumats->id_status == '16' ? 'checked' : '' }}> Tidak Disokong</label>
                                        <br> 
                                    </div>

                                    <div class="col-sm-12">
                                        <br>
                                        <div class="input-group input-info">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Jumlah Dimohon (RM)</span>
                                            </div>
                                            {{-- <input type="number" class="form-control" name="" id="" step="0.5" value="{{ $maklumats->kosMohon }}"> --}}
                                            <?php 
                                                $kosmohon = number_format($maklumats->kosMohon, 2);
                                                // $kosmohon = number_format($maklumats->kosMohon, 2);
                                            ?>
                                            <input type="number" class="form-control" name="kosMohon" id="kosMohon" placeholder="{{ $kosmohon }}" readonly>
                                        </div>
                                        {{-- <br> --}}
                                    </div>

                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="input-group input-success">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Jumlah Disokong (RM)</span>
                                            </div>
                                            <?php 
                                                // $kosSokong = number_format($maklumats->kosSebenar, 2);
                                            ?>
                                            <input type="number" class="form-control" name="kosSokong" id="kosSokong" step="0.5" placeholder="" value="{{ $maklumats->kosSebenar }}">
                                            {{-- @foreach ($tindakanLists->where('id_status', 15) as $tindakan) --}}
                                            {{-- @foreach ($tindakanLists->filter(function ($tindakan) { return $tindakan->id_status == 15 || $tindakan->id_status == 16; }) as $tindakan)
                                                <input type="number" class="form-control" name="kosSokong" id="kosSokong" step="0.5" placeholder="" value="{{ $tindakan->Kos }}">
                                            @break
                                            @endforeach --}}
                                        </div>
                                        {{-- <br> --}}
                                    </div>

                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>

                                    <div class="col-sm-12">
                                        {{-- <input type="text" class="form-control" name="kod" id="kod" value="" placeholder="Sila masukkan ulasan anda."> --}}
                                        <textarea class="form-control" name="ulasan_sokong" id="ulasan_sokong" cols="50" rows="3" value=""
                                            placeholder="Sila masukkan ulasan anda.">{{ $tindakan->Ulasan }}</textarea>
                                    </div>

                                @endif
                                {{-- KEMASKINI SUBKP --}}

                                {{-- KEMASKINI SUBK (P) --}}
                                @if ( $maklumats->id_status == 17 || $maklumats->id_status == 18 )

                                    <div class="col-sm-12">
                                        <label class="radio-inline mr-3"><input type="radio" name="optPeraku" value="17" {{ $maklumats->id_status == '17' ? 'checked' : '' }} required> Perakui</label>
                                        <label class="radio-inline mr-3"><input type="radio" name="optPeraku" value="18" {{ $maklumats->id_status == '18' ? 'checked' : '' }}> Tidak Perakui</label>
                                    </div>

                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="input-group input-info">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Jumlah Dimohon (RM)</span>
                                            </div>
                                            <?php 
                                                $kosmohon = number_format($maklumats->kosMohon, 2);
                                            ?>
                                            <input type="number" class="form-control" name="kosMohon" id="kosMohon" placeholder="{{ $kosmohon }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="input-group input-primary">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Jumlah Disokong (RM)</span>
                                            </div>
                                            <?php 
                                                $kosSokong = number_format($maklumats->kosSebenar, 2);
                                            ?>
                                            <input type="number" class="form-control" name="kosMohon" id="kosMohon" placeholder="{{ $kosSokong }}" readonly>
                                            {{-- @foreach ($tindakanLists->filter(function ($tindakan) { return $tindakan->id_status == 15 || $tindakan->id_status == 16; }) as $tindakan)
                                                <?php 
                                                    $kossokong = number_format($tindakan->Kos, 2);
                                                ?>
                                                <input type="number" class="form-control" name="kosMohon" id="kosMohon" placeholder="{{ $kossokong }}" readonly>
                                            @break
                                            @endforeach --}}
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>

                                    {{-- <div class="col-sm-12">
                                        <div class="input-group input-success">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Jumlah Diperakui (RM)</span>
                                            </div>
                                            @foreach ($tindakanLists->filter(function ($tindakan) { return $tindakan->id_status == 17 || $tindakan->id_status == 18; }) as $tindakan)
                                                <input type="number" class="form-control" name="kosPeraku" id="kosPeraku" step="0.5" placeholder="Sila masukkan Jumlah jika Diperakui." value="{{ $tindakan->Kos }}">
                                            @break
                                            @endforeach
                                        </div>
                                    </div> --}}

                                    <div class="col-sm-12">
                                        &nbsp;
                                    </div>

                                    <div class="col-sm-12">
                                        {{-- <input type="text" class="form-control" name="kod" id="kod" value="" placeholder="Sila masukkan ulasan anda."> --}}
                                        <textarea class="form-control" name="ulasan_peraku" id="ulasan_peraku" cols="50" rows="3" value=""
                                            placeholder="Sila masukkan ulasan anda.">{{ $tindakan->Ulasan }}</textarea>
                                    </div>

                                @endif
                                {{-- KEMASKINI SUBK (P) --}}

                                {{-- <div class="form-group row">
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
                                                value="{{ old('kos_mohon') }}" readonly>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="form-group row">
                                    <label for="kos_lulus" class="col-sm-3 col-form-label" style="text-align:left">Jumlah Yang Diperuntukkan
                                        <font color="red">*</font>
                                    </label>
                                    <div class="col-sm-4">
                                        <div class="input-group input-secondary">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="number" class="form-control" name="kos_lulus" id="kos_lulus" step="0.5" value="{{ $maklumats->kosSebenar }}">
                                        </div>
                                        @error('kos_lulus') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                    </div>   
                                </div> --}}


                                <br>
                                <hr style=" border-top: 2px solid #000000">
                                <br>

                                <h3 class="font-w600 title mb-2 mr-auto">Tindakan Oleh</h3><br>
                                {{-- <h4>Tindakan Oleh</h4><br> --}}

                                <div class="form-group row">
                                    <label for="nama_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Nama 
                                        {{-- <font color="red">*</font> --}}
                                    </label>
                                    <div class="col-sm-4">
                                        <?php
                                            // Untuk display value name n pass id personel bila submit
                                            $id = '';
                                            $nama = '';
                                            foreach( $personel as $person){
                                                if( $person->name == Auth::user()->nama ){
                                                    $id = $person->id;
                                                    $nama = $person->name;
                                                }
                                            }
                                        ?>
                                        <input type="text" class="form-control" name="DisplayNama" id="DisplayNama" value="{{ Auth::user()->nama }}" readonly>
                                        {{-- <input type="text" class="form-control" name="DisplayNama" id="DisplayNama" value="{{ $nama }}" readonly> --}}
                                        <input type="hidden" class="form-control" name="nama" id="nama" value="{{ $id }}" readonly>
                                    </div>
                                </div>

                                {{-- <div class="form-group row">

                                    <label for="nama_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Jawatan
                                        <font color="red">*</font>
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" readonly placeholder="">
                                    </div>

                                </div> --}}

                                <div class="form-group row">
                                    <label for="nama_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Tarikh
                                        {{-- <font color="red">*</font> --}}
                                    </label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            {{-- <p>Formatted Date: {{ now()->format('Y-m-d') }}</p>
                                            <p>Formatted Time: {{ now()->format('H:i:s') }}</p> --}}
                                            <input type="text" class="form-control" name="tarikh_display" id="tarikh_display" value="{{ now()->format('d/m/Y') }}" readonly>
                                            <input type="hidden" class="form-control" name="tarikh_tindakan" id="tarikh_tindakan" value="{{ now()->format('Y-m-d') }}" readonly>
                                            {{-- <input type="date" class="form-control" id="tarikh_tindakan" name="tarikh_tindakan"  value="{{ old('tarikh_tindakan') }}" required > --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nama_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Masa
                                    </label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            {{-- <p>Formatted Date: {{ now()->format('Y-m-d') }}</p> --}}
                                            {{-- <p>Formatted Time: {{ now()->format('H:i:s') }}</p> --}}
                                            {{-- <input type="text" class="form-control" name="masa_tindakan" id="masa_tindakan" value="{{ now()->format('H:i') }}" readonly> --}}
                                            <input type="text" class="form-control" name="masa_display" id="masa_display" value="" readonly>
                                            {{-- <input type="hidden" class="form-control" name="masa_tindakan" id="masa_tindakan" value="" readonly> --}}
                                            {{-- <input type="date" class="form-control" id="tarikh_tindakan" name="tarikh_tindakan"  value="{{ old('tarikh_tindakan') }}" required > --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group float-right">
                                    {{-- <button type="submit" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                            class="fa fa-paper-plane"></i> |
                                            Hantar
                                    </button> --}}
                                    <a href="{{ url('peruntukan/butiran/' . $maklumats->idMaklumatPermohonan) }}" class="btn btn-secondary float-left btn-sm" style="color: black;">
                                        <i class="fas fa-redo-alt"></i> | Kembali
                                    </a>
                                    <button type="submit" name="hantar" class="btn btn-success btn-sm float-right">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> | Simpan
                                    </button>
                                    {{-- <a href="{{ url('/peruntukan/pengesahan') }}" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                            class="fa fa-paper-plane"></i> |
                                            Hantar
                                    </a> --}}
                                    {{-- <button type="button" class="btn btn-secondary float-left btn-sm"
                                        onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button> --}}
                                    
                                </div>

                                {{-- <button type="submit" class="btn btn-primary">Hantar</button> --}}
                            </form>

                            {{-- MODAL1 --}}
                            <div class="modal fade" id="modal-default1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header bg-purple">
                                        <h4 class="modal-title">TAMBAH VOT</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm1">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            
                                            <div class="form-group row">
                                                <label for="objekAm" class="col-sm-3 col-form-label" style="text-align:left">
                                                    Objek Am <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    {{-- <textarea class="form-control" name="objekAm" id="objekAm" cols="" rows="2"></textarea> --}}
                                                    <select class="select2" id="objekAm" name="objekAm"
                                                        style="width: 100%; text-align:left;">
                                                        <option value=""
                                                            @if (old('objekAm') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                        </option>
                                                        @foreach ($objekAms as $objekAm)
                                                            {{-- <option value="{{ $objekAm->idVot }}" --}}
                                                            {{-- <option value="{{ $objekAm->noVot }}" title="{{ $objekAm->namaVot }}" --}}
                                                            <option value="{{ $objekAm->idVot }}" title="{{ $objekAm->namaVot }}"
                                                                @if (old('objekAm') == $objekAm->idVot) {{ 'selected="selected"' }} @endif>
                                                                {{-- @if (old('objekAm') == $objekAm->noVot) {{ 'selected="selected"' }} @endif> --}}
                                                                {{ $objekAm->noVot }}, {{ $objekAm->namaVot }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="objekSeb" class="col-sm-3 col-form-label" style="text-align:left">
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
                                                    <select class="select2" id="objekSeb" name="objekSeb" style="width: 100%;">
                                                        <option value="" @if(old('objekSeb')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                                        <option value="" selected disabled > -- Sila Pilih Objek Am -- </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="kos" class="col-sm-3 col-form-label" style="text-align:left"> Anggaran Kos
                                                    <font color="red">*</font>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group input-secondary">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">RM</span>
                                                        </div>
                                                        <input type="number" class="form-control" name="kos" id="kos">
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
                                                            @if (old('perancangan') == "Ada Peruntukan") {{ 'selected="selected"' }} @endif>
                                                            Ada Peruntukan
                                                        </option>
                                                        <option value="Tiada Peruntukan" 
                                                            @if (old('perancangan') == "Tiada Peruntukan") {{ 'selected="selected"' }} @endif>
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
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                            {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                            <button type="button" class="btn btn-primary btn-sm" id="addData" onclick="tambahVot()" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
                                        </div>
                                    </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            {{-- MODAL1 --}}

                            <!-- modal butiran -->
                            <div class="modal fade" id="modal-butiran">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-purple">
                                            {{-- <h4 class="modal-title">Tindakan Peruntukan</h4> --}}
                                            <h4 class="modal-title">Butiran Peruntukan - {{ $maklumats->kod_permohonan }}</h4> <br>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <dl class="row">
                                                <dt class="col-sm-3">Nama Pemohon</dt>
                                                <dd class="col-sm-8"> {{ $pemohon->namaPemohon }} </dd>
                                                <dt class="col-sm-3">Bahagian</dt>
                                                <dd class="col-sm-8"> {{ $pemohon->namaBahagian }} </dd>
                                                <dt class="col-sm-3">Jawatan</dt>
                                                <dd class="col-sm-8"> {{ $pemohon->jawatanPemohon }} </dd>
                                                <dt class="col-sm-3">Gred</dt>
                                                <dd class="col-sm-8"> {{ $pemohon->gredPemohon }} </dd>
                                                <br><br>

                                                <dt class="col-sm-3">Nama Program</dt>
                                                <dd class="col-sm-9"> {{ $maklumats->namaProgram }} </dd>

                                                <dt class="col-sm-3">Tujuan</dt>
                                                <dd class="col-sm-9" style="text-align: justify;"> {{ $maklumats->tujuanProgram }}</dd>
                                                
                                                <dt class="col-sm-3">Latar Belakang</dt>
                                                <dd class="col-sm-9" style="text-align: justify;"> {{ $maklumats->latarBelakang }} </dd>

                                                <dt class="col-sm-3">Objektif</dt>
                                                @if ($objektifs)
                                                    @if( $objektifs->obj1 ) <dd class="col-sm-9" style="text-align: justify;"> 1. {{ $objektifs->obj1 }} </dd> @else <dd class="col-sm-9"> - </dd> @endif
                                                    @if( $objektifs->obj2 ) <dt class="col-sm-3"></dt><dd class="col-sm-9" style="text-align: justify;"> 2. {{ $objektifs->obj2 }} </dd> @else  @endif
                                                    @if( $objektifs->obj3 ) <dt class="col-sm-3"></dt><dd class="col-sm-9" style="text-align: justify;"> 3. {{ $objektifs->obj3 }} </dd> @else  @endif
                                                    @if( $objektifs->obj4 ) <dt class="col-sm-3"></dt><dd class="col-sm-9" style="text-align: justify;"> 4. {{ $objektifs->obj4 }} </dd> @else  @endif
                                                    @if( $objektifs->obj5 ) <dt class="col-sm-3"></dt><dd class="col-sm-9" style="text-align: justify;"> 5. {{ $objektifs->obj5 }} </dd> @else  @endif
                                                @else
                                                    <dd class="col-sm-9"> - </dd>
                                                @endif

                                                <dt class="col-sm-3">Tarikh Mula</dt>
                                                <dd class="col-sm-3"> 
                                                    {{ Carbon\Carbon::parse($maklumats->tkhCadangMula)->format('d.m.Y') }}
                                                    <?php
                                                    \Carbon\Carbon::setLocale('ms');
                                                    echo '(' . \Carbon\Carbon::parse($maklumats->tkhCadangMula)->dayName . ')';
                                                    ?>
                                                </dd>
                                                <dt class="col-sm-3">Tarikh Tamat</dt>
                                                <dd class="col-sm-3"> 
                                                    {{ Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->format('d.m.Y') }}
                                                    <?php
                                                    \Carbon\Carbon::setLocale('ms');
                                                    echo '(' . \Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->dayName . ')';
                                                    ?>
                                                </dd>

                                                <dt class="col-sm-3">Status Perancangan</dt>
                                                @if ( $maklumats->perancangan == 1 )
                                                    <dd class="col-sm-9">Dalam Perancangan Perolehan Tahunan</dd>
                                                @else 
                                                    <dd class="col-sm-9">Tiada Dalam Perancangan Perolehan Tahunan</dd>
                                                @endif
                                                {{-- <dd class="col-sm-8"> {{ $maklumats->perancangan }} </dd> --}}

                                                <dt class="col-sm-3">Kos Perolehan/Projek/ Program</dt>
                                                <dd class="col-sm-8"> RM {{ $maklumats->kosMohon }} </dd>

                                                {{-- <dt class="col-sm-3"><br>Syor</dt>
                                                <dd class="col-sm-9" style="text-align: justify;"> <br>{{ $maklumats->syor }} </dd> --}}
                                                
                                            </dl>

                                            {{-- <div class="">
                                                <span class="float-right">
                                                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Tutup</button>
                                                </span>
                                            </div> --}}

                                        </div>  <!-- /.modal-body -->
                                    </div> <!-- /.modal-content -->
                                </div> <!-- /.modal-dialog -->
                            </div> <!-- /.modal -->
                            <!--modal -->

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

        {{-- <script type="text/javascript">
           $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();
                $('.select2 vot').select2();
                $('.select2').select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script> --}}
        {{-- @if(session('failed'))
            <script>
                // Execute the JavaScript function
                updateVot();
            </script>
        @endif --}}

        <script type="text/javascript">

            $(document).ready(function(){

                $(document).on('change','#objekAm',function(){
                    var objekAm=$(this).val();
                    var div=$(this).parent().parent().parent();
                    var op=" ";
                    $.ajax({
                    type:'get',
                    url:'{!!URL::to('cariObjek')!!}',
                    data:{'id':objekAm},
                    success:function(data){
                        console.log(div);
                        op+='<option value="" @if(old('objekSeb')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
                        for(var i=0;i<data.length;i++){
                        op+='<option value="'+data[i].idObjek+'">'+ data[i].idObjek + ', ' + data[i].jenisPerbelanjaan+'</option>';
                        }
                        div.find('#objekSeb').html(" ");
                        div.find('#objekSeb').append(op);
                    },
                    error:function(){
                    }
                    });
                });
                
            });


            $(function() {
                $('.select2').select2();
                $('.select2 vot').select2();
                $('.select2').select2({
                    minimumResultsForSearch: Infinity
                });

                // updateVot();
            });

            function tambahVot() {

                // var form_VOT = btoa('x|x' + $('#objekAm').val() + 'x|x' + $('#objekSeb').val() + 'x|x' + $('#kos').val()) + '|x|x|';
                // var form_VOT = btoa('x|x' + $('#objekAm').select2('data')[0].id + 
                //                     'x|x'+$('#objekAm').select2('data')[0].text + 
                //                     'x|x'+$('#objekSeb').select2('data')[0].id + 
                //                     'x|x'+$('#objekSeb').select2('data')[0].text + 
                //                     'x|x' + $('#kos').val() + 
                //                     'x|x'+$('#statusVot').select2('data')[0].id + 
                //                     'x|x'+$('#statusVot').select2('data')[0].text )+ 
                //                     '|x|x|';
                var form_VOT = btoa('x|x' + $('#objekAm').select2('data')[0].id + 
                                    'x|x'+$('#objekAm').select2('data')[0].text + 
                                    'x|x'+$('#objekSeb').select2('data')[0].id + 
                                    'x|x'+$('#objekSeb').select2('data')[0].text + 
                                    'x|x' + $('#kos').val()) + '|x|x|';

                $('#form_VOT').val($('#form_VOT').val() + form_VOT);

                updateVot();
                $('#objekAm').val('');
                $('#objekAm').trigger('change');
                $('#objekSeb').val('');
                $('#objekSeb').trigger('change');
                $('#kos').val('');
                // $('#statusVot').val('');
                // $('#statusVot').trigger('change');
            }

            function updateVot() {
                var newSenP = '';
                var splitP = $('#form_VOT').val().split('|x|x|');
                var kosLulus = parseFloat(0); //initialize 
                for (var p = 0; p < splitP.length - 1; p++) {
                    var bil = p + 1;
                    var column = atob(splitP[p]).split('x|x');
                    console.log(column);

                    var objekAmId = column[1];
                    var objekAmNama = column[2];
                    var objekSebId = column[3];
                    var objekSebNama = column[4];
                    var kos = column[5];
                    // var statusId = column[6];
                    // var statusNama = column[7];

                    //tambah kos if lulu n display kat input
                    // if (statusId == 9){

                        kosLulus = kosLulus + parseFloat(kos);
                    // }
                    // console.log(kosLulus);

                    // newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                    //         + objekAmNama + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                    //         + objekSebNama + '</td><td style="border: 1px solid #EEEEEE;text-align:center;"> RM' 
                    //         + kos + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                    //         + statusNama + '</td>'
                    //     + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                    //     '" onclick="removeVot(' + p + ');" title="' + splitP[p] +
                    //     '"><i class="fa fa-trash"></i></button></td></tr>';
                    newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                            + objekAmNama + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                            + objekSebNama + '</td><td style="border: 1px solid #EEEEEE;text-align:center;"> RM' 
                            + kos + '</td>'
                        + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                        '" onclick="removeVot(' + p + ');" title="' + splitP[p] +
                        '"><i class="fa fa-trash"></i></button></td></tr>';
                }
                $('#senP1').html(newSenP);

                $('#kos_lulus').val(kosLulus);
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

            //for live time input
            function updateCurrentTime() {
                var currentTime = new Date();
                var hours = currentTime.getHours();
                var minutes = currentTime.getMinutes();
                var seconds = currentTime.getSeconds();

                // Add leading zero if needed
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                // Format the time as HH:MM:SS
                var formattedTime = hours + ':' + minutes + ':' + seconds;

                // Update the content of the element with id="current-time"
                // document.getElementById('masa').innerText = formattedTime;
                document.getElementById('masa_display').value = formattedTime;
                document.getElementById('masa_tindakan').value = formattedTime;
            }

            // Update the current time every second
            setInterval(updateCurrentTime, 1000);

            // Initial update
            updateCurrentTime();


            //Prevent From User Tekan ENTER Key
            document.addEventListener('DOMContentLoaded', function () {
                document.addEventListener('keydown', function (e) {
                    // Disable form submission on Enter key press
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            });
        </script>

@endsection