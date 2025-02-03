@extends('layouts.master')
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
                            <h4 class="card-title">Tambah Perancangan Perolehan Tahunan</h4>
                        </div>
    
                        <div class="card-body">
                            <div class="basic-form">
                                <form method="POST" action="{{ url('/pemohon/simpan_ppt', $personel->nokp) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
    
                                    <div class="form-row">

                                        {{-- <div class="input-group mb-4">
                                            <label for="jenis_belanja_disable" class="col-sm-2 col-form-label" style="text-align:left">
                                                Jenis Belanja <font color="red">*</font>
                                            </label>
                                            <div class="col-sm-4">
                                                <select class="select2-with-label-single js-states d-block" name="jenis_belanja_disable" id="jenis_belanja_disable"
                                                    style="width:100%; text-align:left;" disabled>
                                                    <option value=""
                                                        @if (old('jenis_belanja') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($OptjBelanje as $opt)
                                                        <option value="{{ $opt->idJenisBelanja }}"
                                                            @if (old('jenis_belanja') == $opt->idJenisBelanja) {{ 'selected="selected"' }} @endif>
                                                            {{ $opt->jenisBelanja }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="jenis_belanja" id="jenis_belanja" value="{{ old('jenis_belanja') }}">
                                            </div>     
                                        </div> --}}
    
                                        <div class="input-group mb-4">
                                            <label for="bahagian" class="col-sm-2 col-form-label" style="text-align:left">
                                                Bahagian <font color="red">*</font>
                                            </label>
                                            <div class="col-sm-4">
                                                 {{-- <select class="select2-with-label-single js-states d-block" id="bahagian" name="bahagian"
                                                    style="width:100%; text-align:left;" required>
                                                    <option value=""
                                                        @if (old('bahagian') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($OptBahagian as $optB)
                                                        <option value="{{ $optB->id }}"
                                                            @if (old('bahagian') == $optB->id) {{ 'selected="selected"' }} @endif>
                                                            {{ $optB->bahagian }}
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                                <input type="text" class="form-control" readonly 
                                                    value="{{ $personel->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : '' }}">
                                                <input type="hidden" name="bahagian" value="{{ $personel->bahagian_id }}">
                                            </div>
                                        </div>

                                        <div class="input-group mb-4">
                                            <label for="tahun" class="col-sm-2 col-form-label" style="text-align:left">
                                                Tahun <font color="red">*</font>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="tahun" type="number" min="2000" max="2099"  pattern="\d{4}" step="1" value="{{ old('tahun') }}" required/>
                                            </div>
                                        </div>
                                    </div>
    
                                    {{-- Table For Different Jenis Belanja Table --}}
                                        <div class="form-1">
                                            <div class="form-group row">
                                                <h4 >Program / Perolehan Yang Dirancang</h4>
                                                <textarea class="form-control" style="display:none;" id="form_PPT1" name="form_PPT1">{{ old('form_PPT1') }}</textarea>
                                                <table id="example1" class="table table-sm table-responsive-sm table-bordered table-striped" style="width:100%; ">
                                                    <thead class="thead-light" >
                                                        <tr>
                                                            <th><center>Bil.</center> </th>
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Tarikh Mula</center></th>
                                                            <th><center>Tarikh Tamat</center></th>
                                                            <th><center>Anggaran Kos(RM)</center></th>
                                                            <th><center>Catatan/Justifikasi</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="senP1"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="7" align="right"><a class="btn btn-sm btn-primary" style='color:white;' data-toggle="modal" data-target="#modal-default1"><i class="fa fa-plus"></i> Tambah</a></td>
                                                        {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                    </tr>
                                                <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-2">
                                            <div class="form-group row">
                                                <h4>Sewaan/Kontrak</h4>
                                                <textarea class="form-control" style="display:none;" id="form_PPT2" name="form_PPT2">{{ old('form_PPT2') }}</textarea>
                                                <table id="example1" class="table table-sm table-responsive-sm table-bordered table-striped" style="width:100%; ">
                                                    <thead class="thead-light" >
                                                        <tr>
                                                            <th><center>Bil.</center> </th>
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Pembekal</center></th>
                                                            <th><center>Tarikh Mula</center></th>
                                                            <th><center>Tarikh Tamat</center></th>
                                                            <th><center>Kadar Sebulan (RM)</center></th>
                                                            <th><center>Jumlah Setahun (RM)</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="senP2"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="8" align="right"><a class="btn btn-sm btn-primary" style='color:white;' data-toggle="modal" data-target="#modal-default2"><i class="fa fa-plus"></i> Tambah</a></td>
                                                        {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                    </tr>
                                                <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-3">
                                            <div class="form-group row">
                                                <h4>Penyelenggaraan</h4>
                                                <textarea class="form-control" style="display:none;" id="form_PPT3" name="form_PPT3">{{ old('form_PPT3') }}</textarea>
                                                <table id="example1" class="table table-sm table-responsive-sm table-bordered table-striped" style="width:100%; ">
                                                    <thead class="thead-light" >
                                                        <tr>
                                                            <th><center>Bil.</center> </th>
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Pembekal</center></th>
                                                            <th><center>Tarikh Mula</center></th>
                                                            <th><center>Tarikh Tamat</center></th>
                                                            <th><center>Kadar Sebulan (RM)</center></th>
                                                            <th><center>Jumlah Setahun (RM)</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="senP3"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="8" align="right"><a class="btn btn-sm btn-primary" style='color:white;' data-toggle="modal" data-target="#modal-default3"><i class="fa fa-plus"></i> Tambah</a></td>
                                                        {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                    </tr>
                                                <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-4">
                                            <div class="form-group row">
                                                <h4>Utiliti</h4>
                                                <textarea class="form-control" style="display:none;" id="form_PPT4" name="form_PPT4">{{ old('form_PPT4') }}</textarea>
                                                <table id="example1" class="table table-sm table-responsive-sm table-bordered table-striped" style="width:100%; ">
                                                    <thead class="thead-light" >
                                                        <tr>
                                                            <th><center>Bil.</center> </th>
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Pembekal</center></th>
                                                            <th><center>Tarikh Mula</center></th>
                                                            <th><center>Tarikh Tamat</center></th>
                                                            <th><center>Kadar Sebulan (RM)</center></th>
                                                            <th><center>Jumlah Setahun (RM)</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="senP4"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="8" align="right"><a class="btn btn-sm btn-primary" style='color:white;' data-toggle="modal" data-target="#modal-default4"><i class="fa fa-plus"></i> Tambah</a></td>
                                                        {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                    </tr>
                                                <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-5">
                                            <div class="form-group row">
                                                <h4>Keperluan Harta Modal Di Bawah One-Off Harta Modal</h4>
                                                <textarea class="form-control" style="display:none;" id="form_PPT5" name="form_PPT5">{{ old('form_PPT5') }}</textarea>
                                                <table id="example1" class="table table-sm table-responsive-sm table-bordered table-striped" style="width:100%; ">
                                                    <thead class="thead-light" >
                                                        <tr>
                                                            <th><center>Bil.</center> </th>
                                                            <th><center>Tajuk Perbelanjaan/Program</center></th>
                                                            <th><center>Jenis Perkara One-Off</center></th>
                                                            <th><center>Kuantiti</center></th>
                                                            <th><center>Harga Seunit (RM)</center></th>
                                                            <th><center>Jumlah Kos (RM)</center></th>
                                                            <th><center>Justifikasi Pembelian</center></th>
                                                            <th width="10%">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="senP5"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="8" align="right"><a class="btn btn-sm btn-primary" style='color:white;' data-toggle="modal" data-target="#modal-default5"><i class="fa fa-plus"></i> Tambah</a></td>
                                                        {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                                    </tr>
                                                <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                                </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    {{-- End Table 5 Form --}}
    
                                    <div class=" justify-content-center">
                                        {{-- <a href="{{ url('/peruntukan/pengesahan') }}" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                                class="fa fa-paper-plane"></i> |
                                                Hantar
                                        </a> --}}
                                        {{-- <button type="button" class="btn btn-primary" id="getDatetimeButton">Hantarss</button> --}}
                                        <button type="submit" class="btn btn-primary float-right btn-sm">
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i> | Seterusnya
                                        </button>
                                        <button type="button" class="btn btn-secondary float-left btn-sm" onclick="history.back();">
                                            <i class="fas fa-redo-alt"></i> | Kembali
                                        </button>
                                    </div>
                                </form>
    
                                {{-- Modal For Different Jenis Belanja Modal--}}
                                    {{-- MODAL1 --}}
                                    <div class="modal fade" id="modal-default1">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm1">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group row">
                                                        <label for="tujuanProgram1" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <textarea class="form-control" name="tujuanProgram1" id="tujuanProgram1" cols="" rows="2"></textarea>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="tkhMula1" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Mula <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhMula1" name="tkhMula1"  value="{{ old('tkhMula1') }}" required >
                                                            </div>
                                                        </div>
    
                                                        <label for="tkhTamat1" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Tamat <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhTamat1" name="tkhTamat1"  value="{{ old('tkhTamat1') }}" required >
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
                                                                <input type="number" class="form-control" name="kosProgram1" id="kosProgram1">
                                                            </div>
                                                        </div>   
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="justifikasi1" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Catatan/Justifikasi <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <textarea class="form-control" name="justifikasi1" id="justifikasi1" cols="" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                    
                                                </div>
    
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="button" class="btn btn-primary btn-sm" id="addData" onclick="tambahAhli1()" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{-- MODAL1 --}}
                                    
                                    {{-- MODAL2 --}}
                                    <div class="modal fade" id="modal-default2">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm2">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group row">
                                                        <label for="tujuanProgram2" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <textarea class="form-control" name="tujuanProgram2" id="tujuanProgram2" cols="" rows="2"></textarea>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="pembekal2" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Pembekal <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <input type="text" class="form-control" name="pembekal2" id="pembekal2">
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="tkhMula2" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Mula <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhMula2" name="tkhMula2"  value="{{ old('tkhMula2') }}" required >
                                                            </div>
                                                        </div>
    
                                                        <label for="tkhTamat2" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Tamat <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhTamat2" name="tkhTamat2"  value="{{ old('tkhTamat2') }}" required >
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
                                                                <input type="number" class="form-control" name="kosProgram2" id="kosProgram2">
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
                                                                <input type="number" class="form-control" name="kosSetahun2" id="kosSetahun2">
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                </div>
    
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="button" class="btn btn-primary btn-sm" id="addData" onclick="tambahAhli2()" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{-- MODAL2 --}}

                                    {{-- MODAL3 --}}
                                    <div class="modal fade" id="modal-default3">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm3">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group row">
                                                        <label for="tujuanProgram3" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <textarea class="form-control" name="tujuanProgram3" id="tujuanProgram3" cols="" rows="2"></textarea>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="pembekal3" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Pembekal <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <input type="text" class="form-control" name="pembekal3" id="pembekal3">
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="tkhMula3" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Mula <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhMula3" name="tkhMula3"  value="{{ old('tkhMula3') }}" required >
                                                            </div>
                                                        </div>
    
                                                        <label for="tkhTamat3" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Tamat <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhTamat3" name="tkhTamat3"  value="{{ old('tkhTamat3') }}" required >
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
                                                                <input type="number" class="form-control" name="kosProgram3" id="kosProgram3">
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
                                                                <input type="number" class="form-control" name="kosSetahun3" id="kosSetahun3">
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                </div>
    
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="button" class="btn btn-primary btn-sm" id="addData" onclick="tambahAhli3()" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{-- MODAL3 --}}

                                    {{-- MODAL4 --}}
                                    <div class="modal fade" id="modal-default4">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm4">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group row">
                                                        <label for="tujuanProgram4" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <textarea class="form-control" name="tujuanProgram4" id="tujuanProgram4" cols="" rows="2"></textarea>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="pembekal4" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Pembekal <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <input type="text" class="form-control" name="pembekal4" id="pembekal4">
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="tkhMula4" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Mula <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhMula4" name="tkhMula4"  value="{{ old('tkhMula4') }}" required >
                                                            </div>
                                                        </div>
    
                                                        <label for="tkhTamat4" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tarikh Tamat <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group">
                                                                {{-- <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"  value="{{ old('tkh_mula' , date('Y-m-d')) }}" required > --}}
                                                                <input type="date" class="form-control" id="tkhTamat4" name="tkhTamat4"  value="{{ old('tkhTamat4') }}" required >
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
                                                                <input type="number" class="form-control" name="kosProgram4" id="kosProgram4">
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
                                                                <input type="number" class="form-control" name="kosSetahun4" id="kosSetahun4">
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                </div>
    
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="button" class="btn btn-primary btn-sm" id="addData" onclick="tambahAhli4()" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{-- MODAL4 --}}

                                    {{-- MODAL5 --}}
                                    <div class="modal fade" id="modal-default5">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                            <div class="modal-header bg-purple">
                                                <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm5">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group row">
                                                        <label for="tujuanProgram5" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Tajuk Perbelanjaan/Program <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            {{-- <input type="text" class="form-control"> --}}
                                                            <textarea class="form-control" name="tujuanProgram5" id="tujuanProgram5" cols="" rows="2"></textarea>
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
                                                            {{-- <select id="single-select" name="bahagian" --}}
                                                                style="width:100%; text-align:left;">
                                                                <option value="0" selected>&nbsp;</option>
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
                                                            <input type="number" class="form-control" name="kuantiti5" id="kuantiti5">
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
                                                                <input type="number" class="form-control" name="kosProgram5" id="kosProgram5">
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                    <div class="form-group row">
                                                        <label for="justifikasi5" class="col-sm-3 col-form-label" style="text-align:left">
                                                            Justifikasi Pembelian/(Spesifikasi Khusus) <font color="red">*</font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <textarea class="form-control" name="justifikasi5" id="justifikasi5" cols="" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                    
                                                </div>
    
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
                                                    {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                    <button type="button" class="btn btn-primary btn-sm" id="addData" onclick="tambahAhli5()" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{-- MODAL5 --}}
                                {{-- End 5 Modal --}}
    
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
    <script>
        $(function() {
            updateAhli1();
            updateAhli2();
            updateAhli3();
            updateAhli4();
            updateAhli5();
        });

        function tambahAhli1() {

            var form_PPT = btoa('x|x' + $('#tujuanProgram1').val() + 'x|x' + $('#tkhMula1').val() + 'x|x' + $('#tkhTamat1').val() 
            + 'x|x' + $('#kosProgram1').val() + 'x|x' + $('#justifikasi1').val()) + '|x|x|';

            $('#form_PPT1').val($('#form_PPT1').val() + form_PPT);

            updateAhli1();
            $('#tujuanProgram1').val('');
            $('#tkhMula1').val('');
            $('#tkhTamat1').val('');
            $('#kosProgram1').val('');
            $('#justifikasi1').val('');
        }
        function tambahAhli2() {

            var form_PPT = btoa('x|x' + $('#tujuanProgram2').val() + 'x|x' + $('#pembekal2').val() + 'x|x' 
            + $('#tkhMula2').val() + 'x|x' + $('#tkhTamat2').val() 
            + 'x|x' + $('#kosProgram2').val() + 'x|x' + $('#kosSetahun2').val()) + '|x|x|';

            $('#form_PPT2').val($('#form_PPT2').val() + form_PPT);

            updateAhli2();
            $('#tujuanProgram2').val('');
            $('#pembekal2').val('');
            $('#tkhMula2').val('');
            $('#tkhTamat2').val('');
            $('#kosProgram2').val('');
            $('#kosSetahun2').val('');
        }
        function tambahAhli3() {

            var form_PPT = btoa('x|x' + $('#tujuanProgram3').val() + 'x|x' + $('#pembekal3').val() + 'x|x' 
            + $('#tkhMula3').val() + 'x|x' + $('#tkhTamat3').val() 
            + 'x|x' + $('#kosProgram3').val() + 'x|x' + $('#kosSetahun3').val()) + '|x|x|';

            $('#form_PPT3').val($('#form_PPT3').val() + form_PPT);

            updateAhli3();
            $('#tujuanProgram3').val('');
            $('#pembekal3').val('');
            $('#tkhMula3').val('');
            $('#tkhTamat3').val('');
            $('#kosProgram3').val('');
            $('#kosSetahun3').val('');
        }
        function tambahAhli4() {

            var form_PPT = btoa('x|x' + $('#tujuanProgram4').val() + 'x|x' + $('#pembekal4').val() + 'x|x' 
            + $('#tkhMula4').val() + 'x|x' + $('#tkhTamat4').val() 
            + 'x|x' + $('#kosProgram4').val() + 'x|x' + $('#kosSetahun4').val()) + '|x|x|';

            $('#form_PPT4').val($('#form_PPT4').val() + form_PPT);

            updateAhli4();
            $('#tujuanProgram4').val('');
            $('#pembekal4').val('');
            $('#tkhMula4').val('');
            $('#tkhTamat4').val('');
            $('#kosProgram4').val('');
            $('#kosSetahun4').val('');
        }
        function tambahAhli5() {

            var jumlahKos = $('#kuantiti5').val() * $('#kosProgram5').val();

            var form_PPT = btoa('x|x' + $('#tujuanProgram5').val() 
            + 'x|x' + $('#jenis_OneOff5').val() 
            + 'x|x' + $('#kuantiti5').val() 
            + 'x|x' + $('#kosProgram5').val() 
            + 'x|x' + jumlahKos 
            + 'x|x' + $('#justifikasi5').val()) + '|x|x|';

            $('#form_PPT5').val($('#form_PPT5').val() + form_PPT);

            updateAhli5();
            $('#tujuanProgram5').val('');
            $('#jenis_OneOff5').val("");
            $('#jenis_OneOff5').trigger('change'); //try
            $('#kuantiti5').val('');
            $('#kosProgram5').val('');
            $('#justifikasi5').val('');

        }


        function updateAhli1() {
            var newSenP = '';
            var splitP = $('#form_PPT1').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                var bil = p + 1;
                var column = atob(splitP[p]).split('x|x');
                var tujuanProgram = column[1];
                var tkhMula = column[2];
                var tkhTamat = column[3];
                var kosProgram = column[4];
                var justifikasi = column[5];
                newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tujuanProgram + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhMula + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhTamat + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosProgram + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + justifikasi + '</td>'
                    + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                    '" onclick="removeAhli1(' + p + ');" title="' + splitP[p] +
                    '"><i class="fa fa-trash"></i></button></td></tr>';
            }
            $('#senP1').html(newSenP);
        }
        function updateAhli2() {
            var newSenP = '';
            var splitP = $('#form_PPT2').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                var bil = p + 1;
                var column = atob(splitP[p]).split('x|x');
                var tujuanProgram = column[1];
                var pembekal = column[2];
                var tkhMula = column[3];
                var tkhTamat = column[4];
                var kosProgram = column[5];
                var kosSetahun = column[6];
                newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tujuanProgram + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + pembekal + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhMula + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhTamat + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosProgram + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosSetahun + '</td>'
                    + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                    '" onclick="removeAhli2(' + p + ');" title="' + splitP[p] +
                    '"><i class="fa fa-trash"></i></button></td></tr>';
            }
            $('#senP2').html(newSenP);
        }
        function updateAhli3() {
            var newSenP = '';
            var splitP = $('#form_PPT3').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                var bil = p + 1;
                var column = atob(splitP[p]).split('x|x');
                var tujuanProgram = column[1];
                var pembekal = column[2];
                var tkhMula = column[3];
                var tkhTamat = column[4];
                var kosProgram = column[5];
                var kosSetahun = column[6];
                newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tujuanProgram + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + pembekal + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhMula + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhTamat + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosProgram + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosSetahun + '</td>'
                    + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                    '" onclick="removeAhli3(' + p + ');" title="' + splitP[p] +
                    '"><i class="fa fa-trash"></i></button></td></tr>';
            }
            $('#senP3').html(newSenP);
        }
        function updateAhli4() {
            var newSenP = '';
            var splitP = $('#form_PPT4').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                var bil = p + 1;
                var column = atob(splitP[p]).split('x|x');
                var tujuanProgram = column[1];
                var pembekal = column[2];
                var tkhMula = column[3];
                var tkhTamat = column[4];
                var kosProgram = column[5];
                var kosSetahun = column[6];
                newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tujuanProgram + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + pembekal + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhMula + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tkhTamat + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosProgram + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosSetahun + '</td>'
                    + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                    '" onclick="removeAhli4(' + p + ');" title="' + splitP[p] +
                    '"><i class="fa fa-trash"></i></button></td></tr>';
            }
            $('#senP4').html(newSenP);
        }
        function updateAhli5() {            
            var newSenP = '';
            var splitP = $('#form_PPT5').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                var bil = p + 1;
                var column = atob(splitP[p]).split('x|x');
                var tujuanProgram = column[1];
                    if(column[2] == 1){ var nameOneOff = 'Baru'} else if(column[2] == 2){ var nameOneOff = 'Tambahan'} else if(column[2] == 3){ var nameOneOff = 'Ganti'}
                var jenis_OneOff = nameOneOff;
                // var jenis_OneOff = column[2];
                var kuantiti = column[3];
                var kosProgram = column[4];
                var jumlahKos = column[5];
                var justifikasi = column[6];
                newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tujuanProgram + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + jenis_OneOff + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kuantiti + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + kosProgram + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + jumlahKos + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + justifikasi + '</td>'
                    + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                    '" onclick="removeAhli5(' + p + ');" title="' + splitP[p] +
                    '"><i class="fa fa-trash"></i></button></td></tr>';
            }
            $('#senP5').html(newSenP);
        }

        function removeAhli1(p1) {
            var form_PPT = '';
            var splitP = $('#form_PPT1').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                if (p1 != p) {
                    form_PPT += splitP[p] + '|x|x|';
                }
            }
            $('#form_PPT1').val(form_PPT);
            updateAhli1();
            updateAhli2();
            updateAhli3();
            updateAhli4();
            updateAhli5();
        }
        function removeAhli2(p1) {
            var form_PPT = '';
            var splitP = $('#form_PPT2').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                if (p1 != p) {
                    form_PPT += splitP[p] + '|x|x|';
                }
            }
            $('#form_PPT2').val(form_PPT);
            updateAhli1();
            updateAhli2();
            updateAhli3();
            updateAhli4();
            updateAhli5();
        }
        function removeAhli3(p1) {
            var form_PPT = '';
            var splitP = $('#form_PPT3').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                if (p1 != p) {
                    form_PPT += splitP[p] + '|x|x|';
                }
            }
            $('#form_PPT3').val(form_PPT);
            updateAhli1();
            updateAhli2();
            updateAhli3();
            updateAhli4();
            updateAhli5();
        }
        function removeAhli4(p1) {
            var form_PPT = '';
            var splitP = $('#form_PPT4').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                if (p1 != p) {
                    form_PPT += splitP[p] + '|x|x|';
                }
            }
            $('#form_PPT4').val(form_PPT);
            updateAhli1();
            updateAhli2();
            updateAhli3();
            updateAhli4();
            updateAhli5();
        }
        function removeAhli5(p1) {
            var form_PPT = '';
            var splitP = $('#form_PPT5').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                if (p1 != p) {
                    form_PPT += splitP[p] + '|x|x|';
                }
            }
            $('#form_PPT5').val(form_PPT);
            updateAhli1();
            updateAhli2();
            updateAhli3();
            updateAhli4();
            updateAhli5();
        }
    </script>
    
@endsection
