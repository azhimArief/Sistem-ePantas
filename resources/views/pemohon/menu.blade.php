@extends('layouts.master')
@section('content')
    <!--**********************************
                            Content body start
                    ***********************************-->
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light text-white">
                        <h3 class="font-w600 title mb-0">
                            <i class="fa fa-home mr-2" aria-hidden="true"></i>Menu Utama
                        </h3>
                    </div>
                    {{-- <div class="card-body d-flex justify-content-center"> --}}
                    <div class="card-body justify-content-center">
                        <center>
                            <div class="table-responsive">
                                <table class="table table-borderless table-sm text-center mb-0" style="width: 60%;"> 
                                    <tbody>
                                        <tr  class="bg-light">
                                            <th class="w-25 text-right align-middle">Nama Pegawai</th>
                                            <td class="w-5 text-center align-middle">:</td>
                                            <td class="align-middle">{{ $user->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="w-25 text-right align-middle">Bahagian</th>
                                            <td class="w-5 text-center align-middle">:</td>
                                            <td class="align-middle">{{ $user->bahagian ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="w-25 text-right align-middle">Agensi</th>
                                            <td class="w-5 text-center align-middle">:</td>
                                            <td class="align-middle">{{ $user->agensi ?? '-' }}</td>
                                        </tr>
                                        <tr  class="bg-light"> 
                                            <th class="w-25 text-right align-middle">Jawatan</th>
                                            <td class="w-5 text-center align-middle">:</td>
                                            <td class="align-middle">{{ $user->jawatan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="w-25 text-right align-middle">E-mel</th>
                                            <td class="w-5 text-center align-middle">:</td>
                                            <td class="align-middle">{{ $user->email ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                        </center>
                    </div>
                    <div class="card">
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    {{-- <a class="nav-link active" data-toggle="tab" href="#home"><i class="la la-home mr-2"></i> Home</a> --}}
                                    <a class="nav-link @if ( !session('tapis') ){ active } @endif " data-toggle="tab" href="#home"><i
                                            class="fa fa-plus mr-2"></i> Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if ( session('tapis') ){ active } @endif " data-toggle="tab" href="#profile"><i
                                            class="flaticon-381-list"></i>&nbsp;&nbsp; Semak Status</a>
                                </li>
                                {{-- <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#profile"><i class="la la-user mr-2"></i> Semak Status</a>
                                            </li> --}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade @if( !session('tapis') ){ show active } @endif " id="home" role="tabpanel">
                                    <center>
                                        <div class="pt-4">
                                            <a href="{{ route('pemohon.tambah', $user->id) }}"
                                            {{-- <a href="{{ route('pemohon.tambah', $personel->nokp) }}" --}}
                                                class="button-30 btn-primary" role="button">
                                                Permohonan Peruntukan&nbsp;
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            &nbsp;
                                            {{-- <a href="{{ route('pemohon.menu_ppt', $personel->nokp) }}" class="button-30 btn-warning" role="button"> 
                                                            Permohonan Perancangan Perolehan Tahunan&nbsp; 
                                                            <i class="fa fa-plus"></i>
                                                        </a> --}}
                                            {{-- <a href="{{ route('pemohon.tambah_PPT') }}" class="btn-sm btn-primary">
                                                            <i class="glyphicon glyphicon-ok"></i>
                                                            <i class="fa fa-plus"></i>
                                                            Permohonan Peruntukan (PPT)
                                                        </a> --}}
                                        </div>
                                    </center>

                                </div>
                                <div class="tab-pane fade @if( session('tapis') ){ show active }@endif" id="profile">
                                    {{-- Table View List --}}
                                    {{-- <div class="card-body table-responsive"> --}}
                                    <div class="card-body table-responsive">

                                        <a class="btn btn-sm float-right btn-info" data-toggle="modal" data-target="#modal-tapis" style="cursor: pointer;"><i class="fa fa-filter"></i> | Tapis</a>
                                        @if( session('tapis') ) 
                                            <a href="{{ url('pemohon/menu/' . $user->id) }}" class="btn btn-sm btn-light float-right" name="tapis">Reset Senarai</a>
                                        @endif
                                        <br>
                                        <br>

                                        {{-- Nak Ubah Properties Dekat jquery.dataTables.min.js Eg; Tiada Rekod Ditemui  --}}
                                        {{-- <table id="example" class="table table-bordered table-hover table-responsive-sm"> --}}
                                        {{-- <table id="example" class="table table-bordered table-responsive-sm"> --}}
                                        <table id="example" class="table table-bordered">
                                            {{-- <thead bgcolor="#AED6F1" style="color:black;"> --}}
                                            <thead class="thead-primary" style="color:black;">
                                                <tr>
                                                    <th><center>Bil.</center></th>
                                                    <th><center>Kod Permohonan</center></th>
                                                    <th><center>Nama Program</center></th>
                                                    {{-- <th><center>Nama Pemohon</center></th> --}}
                                                    {{-- <th><center>Jenis Peruntukan</center></th> --}}
                                                    <th><center>Tarikh Mula</center></th>
                                                    <th><center>Tarikh Akhir</center></th>
                                                    <th><center>Status</center></th>
                                                    <th width="10%">&nbsp;</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $count = 0; ?>
                                                {{-- @foreach ($pemohon as $pemohons) --}}
                                                    @foreach ($maklumats as $maklumat)
                                                        {{-- @if ($maklumat->idPemohonPeruntukan == $pemohons->idPemohonPeruntukan) --}}
                                                            <?php $count = $count + 1; ?>
                                                            <tr>
                                                                {{-- <td>{{ $loop->iteration }} </td> --}}
                                                                <td><center>{{ $count }} </center></td>
                                                                <td>
                                                                    <u>
                                                                        <a href="{{ url('pemohon/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                                            title="Butiran">{{ $maklumat->kod_permohonan }}
                                                                        </a><br />
                                                                    </u>
                                                                </td>
                                                                <td>{{ $maklumat->namaProgram }}<br /></td>
                                                                {{-- <td>{{ $maklumat->idPemohonPeruntukan != '' ? \App\PPemohonPeruntukan::find($maklumat->idPemohonPeruntukan)->namaPemohon : '' }}</td> --}}
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
                                                                    {{-- <div class="d-flex justify-content-center"> --}}
                                                                    <center>
                                                                        <div class="btn-group">
                                                                            <a href="{{ url('pemohon/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                                                title="Lihat Butiran"
                                                                                class="btn btn-sm btn-info">
                                                                                    <i class="fas fa-eye"></i>
                                                                            </a>
    
                                                                            @if( $maklumat->id_status == 1 || $maklumat->id_status == 11 || $maklumat->id_status == 22)
                                                                                <a href="{{ url('pemohon/kemaskini/' . $maklumat->idMaklumatPermohonan) }}"
                                                                                    title="Kemaskini"
                                                                                    class="btn btn-sm btn-success">
                                                                                        <i class="fas fa-edit"></i>
                                                                                </a>
                                                                                <a href="{{ url('pemohon/batal/' . $maklumat->idMaklumatPermohonan) }}"
                                                                                                title="Batal" class="btn btn-sm btn-danger"><i
                                                                                                    class="fas fa-trash"></i>
                                                                                </a>
                                                                            @elseif ( $maklumat->id_status == 12 )
                                                                                <a href="{{ url('pemohon/kemaskini/' . $maklumat->idMaklumatPermohonan) }}"
                                                                                    title="Kemaskini"
                                                                                    class="btn btn-sm btn-success">
                                                                                        <i class="fas fa-edit"></i>
                                                                                </a>
                                                                                <a href="{{ url('pemohon/batal/' . $maklumat->idMaklumatPermohonan) }}"
                                                                                                title="Hapus" class="btn btn-sm btn-danger"><i
                                                                                                    class="fas fa-times"></i>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                {{-- @endforeach --}}

                                            </tbody>
                                        </table>
                                        <!-- /.card-body -->

                                        <!-- modal  -->
                                            <div class="modal fade" id="modal-tapis">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-purple">
                                                        <h4 class="modal-title">Tapis Senarai</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <form class="form-horizontal" method="POST" action="{{ url('pemohon/menu/' . $user->id) }}" enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">

                                                            {{-- <div class="form-group row">
                                                                <label for="kod" class="col-sm-4 col-form-label">Kod Permohonan</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" name="kod" id="kod" value="{{ $search['kod'] }}" placeholder="Kod Permohonan">
                                                                </div>
                                                            </div> --}}

                                                            <div class="form-group row">
                                                                <label for="status" class="col-sm-4 col-form-label">Status Permohonan</label>
                                                                <div class="col-sm-8">
                                                                <select class="select2" id="status" name="status" style="width: 100%;">
                                                                    <option value="" @if($search['status']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                                                    @foreach ($optStatus as $optStatus)
                                                                    <option value="{{ $optStatus->id_status }}" @if($search['status']==$optStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optStatus->status }}</option>
                                                                    @endforeach
                                                                </select>   
                                                                </div>
                                                            </div>

                                                            {{-- <div class="form-group row">
                                                                <label for="tkh_mula" class="col-sm-4 col-form-label">Tarikh Permohonan Dari</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="date" class="form-control" id="tkhMula" name="tkhMula" value="{{ $search['tkhMula'] }}">
                                                                    </div>
                                                            </div> --}}

                                                            {{-- <div class="form-group row">
                                                                <label for="tkh_hingga" class="col-sm-4 col-form-label">Tarikh Permohonan Hingga</label>
                                                                <div class="col-sm-8">
                                                                    <input type="date" class="form-control" id="tkhTamat" name="tkhTamat" value="{{ $search['tkhTamat'] }}">
                                                                </div>
                                                            </div>  --}}

                                                            {{-- <div class="form-group row">
                                                                <label for="tkh_mula" class="col-sm-4 col-form-label">Tarikh Mula Program</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="date" class="form-control" id="tkhMulaProg" name="tkhMulaProg" value="{{ $search['tkhMulaProg'] }}">
                                                                    </div>
                                                            </div> --}}

                                                            {{-- <div class="form-group row">
                                                                <label for="tkh_hingga" class="col-sm-4 col-form-label">Tarikh Tamat Program</label>
                                                                <div class="col-sm-8">
                                                                    <input type="date" class="form-control" id="tkhTamatProg" name="tkhTamatProg" value="{{ $search['tkhTamatProg'] }}">
                                                                </div>
                                                            </div>  --}}
                                                        
                                                            
                                                        </div>

                                                        <div class="modal-footer float-right">
                                                            <span class="float-right">
                                                                <a href="{{ url('pemohon/menu/' . $user->id) }}" class="btn btn-default" name="tapis">Reset</a>
                                                                <button type="submit" class="btn btn-primary bg-purple" name="tapis"><i class="fa fa-filter"></i> | Tapis</button>
                                                            </span>
                                                        </div>
                                                        </form>
                                                    </div> <!-- /.modal-content -->
                                                </div> <!-- /.modal-dialog -->
                                            </div> 
                                        <!--modal -->

                                    </div>

                                </div>

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
@endsection

@section('script')
    @if (session('buang'))
        <script type="text/javascript">
            window.onload = function() {
                swal("Permohonan Berjaya Dihapuskan.", "", "success");
                // swal("Permohonan Berjaya Dibuang.", "", "success");
            };
        </script>
    @elseif (session('batal'))
        <script type="text/javascript">
            window.onload = function() {
                swal("Permohonan Berjaya Dibatalkan.", "", "wrong");
            };
        </script>
    @endif

    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection
