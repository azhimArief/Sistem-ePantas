@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                    Content body start
                ***********************************-->
    <style>
        .dataTables_wrapper .dataTables_filter input {
            width: 200px; /* Adjust the width as needed */
            height: 30px; /* Adjust the height as needed */
            /* margin-right: 10px; */
        }
        /* Custom styles for DataTables page buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px; /* Adjust padding as needed */
            margin: 0 2px; /* Adjust margin as needed */
            border: 1px solid #ccc; /* Add border if desired */
            background-color: #f5f5f5; /* Background color */
            color: #333; /* Text color */
            cursor: pointer;
            user-select: none;
        }

        /* Custom styles for the active page button */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007bff; /* Active button background color */
            color: #fff; /* Active button text color */
            border: 1px solid #007bff; /* Active button border color */
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
        </div>

        <div class="row">

            <div class="col-12">

                <div class="card">

                    {{-- <div class="card-header" style="background-color: rgb(175, 175, 252)"> --}}
                    <div class="card-header">
                        {{-- <h4 class="card-title">Senarai Permohonan</h4> --}}
                        <h3 class="font-w600 title mb-2 mr-auto ">Senarai Permohonan</h3>
                        {{-- <a class="btn btn-sm float-right" href="{{ url('/peruntukan/tambah') }}" style="color: black;"> <i class="fa fa-plus-square"></i> | Tambah</a> --}}
                        <a class="btn float-right btn-light" data-toggle="modal" data-target="#modal-default" style="cursor: pointer;"><i class="fa fa-filter"></i> | Tapis</a>
                    </div>

                    <div class="card-body table-responsive">
                    {{-- <div class="table-responsive"> --}}
                        <table id="example" class="table table-bordered table-hover">
                            {{-- <table id="example" class="table table-bordered table-hover table-responsive-sm"> --}}
                            <thead class="thead-primary">
                                {{-- <thead style="background-color: #22223d;"> --}}
                                <tr>
                                    <th>
                                        <center>Bil.</center>
                                    </th>
                                    <th>
                                        <center>Kod Permohonan</center>
                                    </th>
                                    <th>
                                        <center>Nama Program</center>
                                    </th>
                                    <th>
                                        <center>Pemohon</center>
                                    </th>
                                    {{-- <th>
                                                    <center>Jenis Peruntukan</center>
                                                </th> --}}
                                    <th>
                                        <center>Tarikh Mula</center>
                                    </th>
                                    <th>
                                        <center>Tarikh Tamat</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th width="5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maklumats as $maklumat)
                                    {{-- @if (Auth::user()->id_access == 'Pentadbir-SUB Kewangan dan Pembangunan' && $maklumat->id_status == 1 && $maklumat->namaBahagian != 'Bahagian Khidmat Pengurusan')
                                        @continue
                                    @endif --}}
                                    <tr>
                                        <td>{{ $loop->iteration }}. </td>
                                        <td>
                                            <u>
                                                <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                    title="Butiran">{{ $maklumat->kod_permohonan }}
                                                </a><br />
                                            </u>        
                                        </td>
                                        <td>{{ $maklumat->namaProgram }}<br /></td>
                                        <td>
                                            {{ $maklumat->idPemohonPeruntukan != '' ? \App\PPemohonPeruntukan::find($maklumat->idPemohonPeruntukan)->namaPemohon : '' }}
                                            ({{ $namaBahagian = $maklumat->idPemohonPeruntukan != '' ? \App\PPemohonPeruntukan::find($maklumat->idPemohonPeruntukan)->namaBahagian : '' }}, 
                                            {{ \App\Agensi::where('agensi', $maklumat->agensi)->first()->akronim ?? '-' }})
                                        </td>
                                        {{-- <td>{{ $maklumat->id_jenis_peruntukan != '' ? \App\LkpJenisPeruntukan::find($maklumat->id_jenis_peruntukan)->jenis_perbelanjaan : '' }}
                                                    </td> --}}
                                        <td>
                                            <center>
                                                {{ Carbon\Carbon::parse($maklumat->tkhCadangMula)->format('d.m.Y') }}
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                {{ Carbon\Carbon::parse($maklumat->tkhCadangAkhir)->format('d.m.Y') }}
                                            </center>
                                        </td>

                                        <?php
                                        $status = $maklumat->id_status;
                                        $color = '';
                                        switch ($status) {
                                            //permohonan baru
                                            case '1':
                                                $color = '#2C87F0';
                                                $status = 'Permohonan Baru';
                                                $badge="badge badge-secondary";
                                                // $badge = 'fa fa-circle text-secondary mr-1';
                                                break; //biru
                                            //telah dikemaskini
                                            case '2':
                                                $color = '#FFB300';
                                                $status = 'Dalam Proses';
                                                break; //kuning
                                            //lulus
                                            case '9':
                                                $color = '#32CD32';
                                                $status = 'Lulus';
                                                $badge="badge badge-success";
                                                // $badge = 'fa fa-circle text-success mr-1';
                                                break; //hijau
                                            //Tidak Diluluskan
                                            case '10':  
                                                $color = '#FF0000';
                                                $status = 'Tidak Diluluskan';
                                                $badge="badge badge-danger"; 
                                                // $badge = 'fa fa-circle text-danger mr-1';
                                                break; //merah
                                            //semak semula
                                            case '12';
                                                $color = '#6418C3';
                                                $status = 'Draf';
                                                $badge = 'badge badge-secondary';
                                                break; //hijau pekat
                                            case '11':
                                                $color = '#FFB300';
                                                $status = 'Semak Semula';
                                                $badge="badge badge-warning"; 
                                                // $badge = 'fa fa-circle text-warning mr-1';
                                                break; //biru
                                            case '22':
                                                $color = '#FFB300';
                                                $status = 'Semak Semula';
                                                $badge="badge badge-warning"; 
                                                // $badge = 'fa fa-circle text-warning mr-1';
                                                break; //biru
                                            //batal
                                            case '8':
                                                $color = '#CC3300';
                                                $status = 'Batal';
                                                $badge="badge badge-danger"; 
                                                // $badge = 'fa fa-circle text-danger mr-1';
                                                break; //merah pekat
                                                
                                            case "13": $color="#51A6F5"; $status="Ada Peruntukan"; $badge="badge badge-info text-white"; /*$badge="fa fa-circle text-info mr-1";*/  break; //purple
                                            case "14": $color="#CC3300"; $status="Tiada Peruntukan"; $badge="badge badge-danger"; /*$badge="fa fa-circle text-danger mr-1";*/  break; //merah 
                                            case "15": $color="#51A6F5"; $status="Disokong"; $badge="badge badge-info text-white"; /*$badge="fa fa-circle text-info mr-1";*/  break; //purple
                                            case "16": $color="#CC3300"; $status="Tidak Disokong"; $badge="badge badge-danger"; /*$badge="fa fa-circle text-danger mr-1";*/  break; //merah 
                                            case "17": $color="#51A6F5"; $status="Disyorkan"; $badge="badge badge-info text-white"; /*$badge="fa fa-circle text-info mr-1";*/  break; //purple disyorkan SUBK
                                            case "18": $color="#CC3300"; $status="Tidak Disyorkan"; $badge="badge badge-danger"; /*$badge="fa fa-circle text-danger mr-1";*/  break; //merah  tidak disyorkan SUBK
                                            case "19": $color="#51A6F5"; $status="Disyorkan"; $badge="badge badge-info text-white"; /*$badge="fa fa-circle text-danger mr-1";*/  break;
                                            case "20": $color="#51A6F5"; $status="Dikemaskini"; $badge="badge badge-secondary text-white"; /*$badge="fa fa-circle text-danger mr-1";*/  break;
                                            case "21": $color="#51A6F5"; $status="Dikemaskini"; $badge="badge badge-secondary text-white"; /*$badge="fa fa-circle text-danger mr-1";*/  break;
                                            //Banyak Banyakinfo
                                            case '':
                                                $color = '#006400';
                                                $status = 'Disahkan';
                                                break; //hijau pekat
                                            default:
                                                $color = '#000000';
                                        }
                                        ?>
                                        <td style="color:{{ $color }};">
                                            {{-- <div class="d-flex align-items-center"><i class="{{ $badge }}"></i>
                                                {{ $status }} 
                                            </div> --}}
                                            <center>
                                                <span class="{{ $badge }}"> {{ $status }} </span>  
                                            </center>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if ( ($maklumat->id_status == 19 || $maklumat->id_status == 1 || $maklumat->id_status == 21) && (Auth::user()->id_access == 'Pentadbir Sistem' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem') )
                                                    <div class="btn-group">
                                                        {{-- Baru, Semak Semula, Dikemaskini --}}
                                                        <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                            title="Butiran" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> 
                                                        </a>
                                                        <a href="{{ url('peruntukan/tindakan/' . $maklumat->idMaklumatPermohonan) }}"
                                                            title="Tindakan" 
                                                            class="btn btn-sm btn-success">
                                                            <i class="fas fa-user-edit"></i>
                                                        </a>
                                                        <a href="{{ url('peruntukan/batal/' . $maklumat->idMaklumatPermohonan) }}"
                                                            title="Batal" class="btn btn-sm btn-danger"><i
                                                                class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                @elseif ( ($maklumat->id_status == 13 || $maklumat->id_status == 1 || $maklumat->id_status == 14 || $maklumat->id_status == 19) && ( Auth::user()->id_access == 'Pentadbir-SUB Kewangan dan Pembangunan' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem') )
                                                    {{-- Untuk Sokongkan --}}
                                                    <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                        title="Tindakan" 
                                                        class="btn btn-sm btn-success">
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                @elseif ( ($maklumat->id_status == 15 || $maklumat->id_status == 16) && $maklumat->kosSebenar > 50000 && ( Auth::user()->id_access == 'Pentadbir-SUB Kanan Pengurusan' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem') )
                                                    {{-- Untuk Peraku --}}
                                                    <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                        title="Tindakan" 
                                                        class="btn btn-sm btn-success">
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                @elseif ( ( ($maklumat->id_status == 17 || $maklumat->id_status == 18) && (Auth::user()->id_access == 'Pentadbir-KSU' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem') ) || 
                                                        ( (Auth::user()->id_access == 'Pentadbir-SUB Kanan Pengurusan' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem' ) && ($maklumat->kosSebenar <= 50000 && ($maklumat->id_status == 15 || $maklumat->id_status == 16) ) ) 
                                                        )
                                                    {{-- Untuk Lulus --}}
                                                    <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                        title="Tindakan" 
                                                        class="btn btn-sm btn-success">
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                @elseif ( Auth::user()->id_access == 'Pengesah' && ($maklumat->id_status == 1 || $maklumat->id_status == 20) ) {{-- Baru & Dikemaskini ke Pengesah --}}
                                                    <div class="btn-group">
                                                        <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                            title="Butiran" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> 
                                                        </a> 
                                                        <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                            title="Tindakan" 
                                                            class="btn btn-sm btn-success">
                                                            <i class="fas fa-user-edit"></i>
                                                        </a>
                                                    </div>
                                                    {{-- @elseif ( $maklumats->id_status == 13 ) --}}
                                                @else
                                                    <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                        title="Butiran" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> 
                                                    </a>    
                                                @endif
                                                
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div> <!-- card body -->

                    <!-- modal  -->
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-purple">
                                <h4 class="modal-title">Tapis Senarai</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <form class="form-horizontal" method="POST" action="{{ url('peruntukan/senarai') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-body">

                                    <div class="form-group row">
                                        <label for="kod" class="col-sm-5 col-form-label">Kod Permohonan</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="kod" id="kod" value="{{ $search['kod'] }}" placeholder="Kod Permohonan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status" class="col-sm-5 col-form-label">Agensi</label>
                                        <div class="col-sm-7">
                                        <select class="select2-status" id="agensi" name="agensi" style="width: 100%;">
                                            <option value="" @if($search['agensi']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                            @foreach ($optAgensis as $optAgensi)
                                            <option value="{{ $optAgensi->id }}" @if($search['agensi']==$optAgensi->id) {{ 'selected="selected"' }} @endif>{{ $optAgensi->agensi }}</option>
                                            @endforeach
                                        </select>   
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status" class="col-sm-5 col-form-label">Status Permohonan</label>
                                        <div class="col-sm-7">
                                        <select class="select2-status" id="status" name="status" style="width: 100%;">
                                            <option value="" @if($search['status']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                            @foreach ($optStatus as $optStatus)
                                            <option value="{{ $optStatus->id_status }}" @if($search['status']==$optStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optStatus->status }}</option>
                                            @endforeach
                                        </select>   
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tkh_mula" class="col-sm-5 col-form-label">Tarikh Permohonan Dari</label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" id="tkhMula" name="tkhMula" value="{{ $search['tkhMula'] }}">
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tkh_hingga" class="col-sm-5 col-form-label">Tarikh Permohonan Hingga</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="tkhTamat" name="tkhTamat" value="{{ $search['tkhTamat'] }}">
                                        </div>
                                    </div> 

                                    <div class="form-group row">
                                        <label for="tkh_mula" class="col-sm-5 col-form-label">Tarikh Mula Perolehan/Program</label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" id="tkhMulaProg" name="tkhMulaProg" value="{{ $search['tkhMulaProg'] }}">
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tkh_hingga" class="col-sm-5 col-form-label">Tarikh Tamat Perolehan/Program</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="tkhTamatProg" name="tkhTamatProg" value="{{ $search['tkhTamatProg'] }}">
                                        </div>
                                    </div> 
                                
                                    
                                </div>

                                <div class="modal-footer float-right">
                                    <span class="float-right">
                                        <a href="{{ url('peruntukan/senarai') }}" class="btn btn-default" name="tapis">Reset</a>
                                        <button type="submit" class="btn btn-primary bg-purple" name="tapis">Tapis</button>
                                    </span>
                                </div>
                                </form>
                            </div> <!-- /.modal-content -->
                        </div> <!-- /.modal-dialog -->
                    </div> 
                    <!--modal -->

                </div> <!-- card -->
            </div> <!-- col -->
        </div> <!-- row -->

    </div> <!-- Content Body -->
    <!--**********************************
                    Content body end
                ***********************************-->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
            $('.select2-status').select2({
                 minimumResultsForSearch: Infinity
            });
        });

        $(document).ready(function() {
            $('#example').DataTable({
                // "pageLength": 10,
                // dom: 'lrtip', // Customize the DataTables elements (l - length menu, r - processing, t - table, i - information, p - pagination)
                searching: true,
                language: {
                    search: 'Cari :',
                    paginate: {
                        next: '>', // Set the 'Next' button text to '>'
                        previous: '<' // Set the 'Next' button text to '>'
                    }
                },
            });
        });
        // KALO NAK EDIT PERKATAAN TIADA REKOD SENARAI -> datatables.min.js ->CTRL+F + Tiada data
    </script>
@endsection