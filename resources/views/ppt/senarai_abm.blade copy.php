@extends('layouts.masterAdmin')
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
                        <h4 class="card-title">Senarai PPT</h4>
                    </div>
                    {{-- <div class="card-body">
                        <div class="basic-form">
                            
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="basic-form">
                            {{-- <form> --}}
                            <form class="form-horizontal" method="POST" action="{{ route('peruntukan.senarai_abm') }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="card-body">
                                    <div class="form-group row">
                                        <!-- pentadbir sistem -->
                                        <div class="col-sm-4">
                                            <label for="jenis_belanja" class="col-form-label">Jenis Belanja : </label>
                                            <select class="select2-with-label-single js-states d-block" name="jenis_belanja"
                                                style="width:100%; text-align:left;">
                                                <option value=""
                                                    @if ($search['jenis_belanja'] == '') {{ 'selected="selected"' }} @endif>
                                                </option>
                                                @foreach ($OptjBelanje as $opt)
                                                    <option value="{{ $opt->idJenisBelanja }}"
                                                        @if ($search['jenis_belanja'] == $opt->idJenisBelanja) {{ 'selected="selected"' }} @endif>
                                                        {{ $opt->jenisBelanja }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="bahagian" class="col-form-label">Bahagian : </label>
                                            <select class="select2-with-label-single js-states d-block" id="bahagian"
                                                name="bahagian" {{-- <select id="single-select" name="bahagian" --}} style="width:100%; text-align:left;">
                                                <option value=""
                                                    @if ($search['bahagian'] == '') {{ 'selected="selected"' }} @endif>
                                                    &nbsp;
                                                </option>
                                                @foreach ($OptBahagian as $optB)
                                                    <option value="{{ $optB->id }}"
                                                        @if ($search['bahagian'] == $optB->id) {{ 'selected="selected"' }} @endif>
                                                        {{ $optB->bahagian }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4">

                                        </div>

                                        <div class="col-sm-4">
                                            <label for="tkh_mula" class="col-form-label">Tarikh Dari : </label>
                                            <input type="date" class="form-control" id="tkh_mula" name="tkh_mula"
                                                value="{{ $search['tkh_mula'] }}">
                                            {{-- value=""> --}}
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="tkh_hingga" class="col-form-label">Tarikh Hingga :</label>
                                            <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga"
                                                value="{{ $search['tkh_hingga'] }}">
                                            {{-- value=""> --}}
                                        </div>

                                    </div>



                                    <div class="modal-footer justify-content-between">
                                        <P></P>
                                        <span class="float-right">
                                            <button type="submit" class="btn btn-primary" name="search_abm">Carian</button>
                                            <a href="{{ url('/peruntukan/senarai_abm') }}" class="btn btn-default"
                                                name="search_abm">Reset</a>
                                        </span>
                                    </div>
                                </div>
                            </form>


                            @if (isset($_POST['search_abm']))
                                <div class="card card-info">
                                    <div class="card-body table-responsive">

                                        <table id="example1" class="table table-bordered table-hover table-responsive-sm">
                                            <thead class="thead-primary">
                                                <tr>
                                                    <th>
                                                        <center>Bil.</center>
                                                    </th>
                                                    <th>
                                                        <center>Tajuk Perbelanjaan/Program</center>
                                                    </th>
                                                    <th>
                                                        <center>Tarikh Mula</center>
                                                    </th>
                                                    <th>
                                                        <center>Tarikh Tamat</center>
                                                    </th>
                                                    <th>
                                                        <center>Anggaran Kos(RM)</center>
                                                    </th>
                                                    <th>
                                                        <center>Catatan/Justifikasi</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($progDirancangs as $progDirancang)
                                                    <tr>
                                                        <td scope="row">
                                                            <center>{{ $bil++ }}</center>
                                                        </td>
                                                        <td>
                                                            <center>{{ $progDirancang->tujuanProgram }}</center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                {{ Carbon\Carbon::parse($progDirancang->tkhMula)->format('d.m.Y') }}
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                {{ Carbon\Carbon::parse($progDirancang->tkhTamat)->format('d.m.Y') }}
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>RM {{ $progDirancang->kosProgram }}</center>
                                                        </td>
                                                        <td>
                                                            <center>{{ $progDirancang->justifikasi }}</center>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <!-- </form> -->
                                        </table><!-- /.card-body -->
                            @endif

                        </div>
                    </div>
                </div> <!-- Card -->
            </div> <!--col-xl -->

        </div> <!--container fluid -->
    </div> <!--Content Body -->
    <!--**********************************
                                    Content body end
                                ***********************************-->
@endsection
