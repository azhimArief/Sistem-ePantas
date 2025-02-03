@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                    Content body start
                ***********************************-->
    <div class="content-body">

        <div class="col-12">
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

        <div class="row">
            
            <div class="col-12">
                <div class="card">

                    <div class="card-header" style="background-color: rgb(175, 175, 252)">
                        <h4 class="card-title">Senarai Perancangan Perolehan Tahunan</h4>
                        <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i>
                            Tapis</a>
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
                                        <td>
                                            <center>{{ $loop->iteration }}</center>
                                        </td>
                                        <td>
                                            <center>
                                                {{ $perancangan->bahagian != '' ? \App\PlkpBahagian::find($perancangan->bahagian)->bahagian : '' }}
                                            </center>
                                        </td>
                                        <td>
                                            <center>{{ $perancangan->tahunPPT }}</center>
                                        </td>
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

                                                {{-- <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                                title="Kemaskini" class="btn btn-sm btn-rounded btn-info"><i
                                                                    class="fas fa-pen"></i></a> --}}
                                                <a href="{{ url('peruntukan/pengesahan_ppt/' . $perancangan->idPerancanganPerolehan) }}"
                                                    title="Kemaskini" class="btn btn-sm btn-rounded btn-info"><i
                                                        class="fas fa-pen"></i></a>
                                                {{-- <a href=""
                                                                title="Batal" class="btn btn-sm btn-rounded btn-danger"><i
                                                                    class="fas fa-trash"></i></a> --}}
                                                <a href="{{ url('peruntukan/tindakanPPT/' . $perancangan->idPerancanganPerolehan) }}"
                                                    title="Tindakan" class="btn btn-sm btn-rounded btn-success"><i
                                                        class="fas fa-user-edit"></i></a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div> <!-- card-body -->

                    <!-- modal  -->
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">Tapis Senarai</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <form class="form-horizontal" method="POST" action="{{ url('peruntukan/senarai_ppt') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-body">

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

                                    <div class="form-group row">
                                        <label for="tkh_mula" class="col-sm-4 col-form-label">Bahagian</label>
                                            <div class="col-sm-8">
                                                <select class="select2" id="bahagian" name="bahagian" style="width: 100%;">
                                                    <option value="" @if($search['bahagian']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                                    @foreach ($optBahagians as $optBahagian)
                                                    <option value="{{ $optBahagian->id }}" @if($search['bahagian']==$optBahagian->id) {{ 'selected="selected"' }} @endif>{{ $optBahagian->bahagian }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tkh_hingga" class="col-sm-4 col-form-label">Tahun</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="tahun" name="tahun" value="{{ $search['tahun'] }}">
                                        </div>
                                    </div> 
                                
                                    
                                </div>

                                <div class="modal-footer float-right">
                                    <span class="float-right">
                                        <a href="{{ url('peruntukan/senarai_ppt') }}" class="btn btn-default" name="tapis">Reset</a>
                                        <button type="submit" class="btn btn-primary bg-purple" name="tapis">Tapis</button>
                                    </span>
                                </div>
                                </form>
                            </div> <!-- /.modal-content -->
                        </div> <!-- /.modal-dialog -->
                    </div> 
                    <!--modal -->

                </div> <!-- card -->
            </div> <!--col-12 -->
        </div> <!-- row -->

    </div> <!-- content body -->
    <!--**********************************
                    Content body end
                ***********************************-->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection