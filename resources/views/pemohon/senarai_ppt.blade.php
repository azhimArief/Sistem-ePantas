@extends('layouts.master')
@section('content')
    <!--**********************************
                Content body start
        ***********************************-->

    <div class="content-body">

        <div class="container-fluid">

            <div class="col-xl-13 col-lg-12">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('status') }}
                </div>
                @elseif(session('failed'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ session('failed') }}
                </div>
                @endif
            </div>
    


            <div class="col-xl-13 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Senarai Perancangan Perolehan Tahunan</h4>
                    </div>
                    <div class="card-body table-responsive">
                        {{-- <div class="table-responsive"> --}}
                            <table id="example" class="table table-bordered table-hover table-responsive-sm">

                                <thead class="thead-primary">
                                    {{-- <thead style="background-color: #22223d;"> --}}
                                    <tr>
                                        <th>
                                            <center>Bil.</center>
                                        </th>
                                        <th>
                                            <center>Bahagian</center>
                                        </th>
                                        {{-- <th>
                                            <center>Pemohon</center>
                                        </th> --}}
                                        <th>
                                            <center>Tahun</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th width="5%">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perancangans as $perancangan)
                                        <tr>
                                            <td><center>{{ $loop->iteration }}</center>  </td>
                                            <td><center>{{ $perancangan->bahagian!='' ? \App\PLkpBahagian::find($perancangan->bahagian)->bahagian: '' }}</center>  </td>
                                            {{-- <td> <center>{{ $pemohon->name }}</center></td> --}}
                                            <td><center>{{ $perancangan->tahunPPT }}</center></td>
                                            <?php
                                            $status = $perancangan->id_status;
                                            $color = '';
                                            switch ($status) {
                                                //permohonan baru
                                                case '1':
                                                    $color = '#2C87F0';
                                                    $status = 'Permohonan Baru';
                                                    /*$badge="badge badge-secondary light";*/ $badge = 'fa fa-circle text-primary mr-1';
                                                    break; //biru
                                                //lulus
                                                case '9':
                                                    $color = '#32CD32';
                                                    $status = 'Lulus';
                                                    /*$badge="badge badge-success light";*/ $badge = 'fa fa-circle text-success mr-1';
                                                    break; //hijau
                                                //Tidak Diluluskan
                                                case '10':
                                                    $color = '#FF0000';
                                                    $status = 'Tidak Diluluskan';
                                                    /*$badge="badge badge-danger light";*/ $badge = 'fa fa-circle text-danger mr-1';
                                                    break; //merah
                                                //semak semula
                                                case '11':
                                                    $color = '#FFB300';
                                                    $status = 'Semak Semula';
                                                    /*$badge="badge badge-warning light";*/ $badge = 'fa fa-circle text-warning mr-1';
                                                    break; //biru
                                                case '12':
                                                    $color = '#FFB300';
                                                    $status = 'Draft';
                                                    /*$badge="badge badge-warning light";*/ $badge = 'fa fa-circle text-warning mr-1';
                                                    break; //biru
                                                //batal
                                                case '8':
                                                    $color = '#CC3300';
                                                    $status = 'Batal';
                                                    /*$badge="badge badge-danger light";*/ $badge = 'fa fa-circle text-danger mr-1';
                                                    break; //merah pekat
                                                //sah
                                                case '':
                                                    $color = '#006400';
                                                    $status = 'Disahkan';
                                                    break; //hijau pekat
                                                default:
                                                    $color = '#000000';
                                            }
                                            ?>
                                            <td style="color:{{ $color }};">
                                                <div class="d-flex align-items-center"><i class="{{ $badge }}"></i>
                                                    {{ $status }}</div>
                                                {{-- <span class="{{ $badge }}"> <center>{{ $status }}</center> </span>   --}}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">

                                                    <a href="{{ url('pemohon/pengesahan_ppt/' . $perancangan->idPerancanganPerolehan . '/' . $personel->nokp) }}"
                                                        title="Kemaskini" class="btn btn-sm btn-rounded btn-info"><i
                                                            class="fas fa-pen"></i></a>
                                                    <a href=""
                                                        title="Batal" class="btn btn-sm btn-rounded btn-danger"><i
                                                            class="fas fa-trash"></i></a>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        {{-- </div> --}}
                    </div>
                    <div class="card-footer">
                        {{-- <button type="button" class="btn btn-secondary float-left btn-sm"
                            onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button> --}}
                        <a href="{{ url('pemohon/menu_ppt/'. $personel->nokp ) }}" class="btn btn-secondary float-left btn-sm"
                            onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--**********************************
                Content body end
            ***********************************-->
@endsection
