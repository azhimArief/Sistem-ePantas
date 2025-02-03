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
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Ruangan bertanda * wajib diisi. --}}
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
            <div class="col-xl-23 col-lg-12">
                <div class="card">
                    <div class="card-header" >
                            <h3 class="font-w600 title mb-2 mr-auto ">Senarai Pengguna</h3>
                            {{-- <h4 class="card-title">Senarai Pengguna</h4> --}}
                        <div class="bar">
                            <a class="btn btn-sm btn-light" href="{{ url('/pengguna/tambah') }}" style="color: black;"> <i class="fa fa-plus"></i> | Tambah</a>
                            <a class="btn btn-sm float-right btn-light" data-toggle="modal" data-target="#modal-default" style="cursor: pointer;"><i class="fa fa-filter"></i> | Tapis</a>
                        </div>
                    </div>
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
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
                                        <center>MyKad</center>
                                    </th>
                                    <th>
                                        <center>Nama</center>
                                    </th>
                                    <th>
                                        <center>Agensi</center>
                                    </th>
                                    <th>
                                        <center>Bahagian</center>
                                    </th>
                                    <th>
                                        <center>Peranan</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th width="7%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penggunas as $pengguna)
                                    <tr>
                                        <td>{{ $loop->iteration }}. </td>
                                        <td>
                                            <a href="{{ url('pengguna/butiran/' . $pengguna->id) }}"
                                                title="Butiran">{{ $pengguna->mykad }}</a><br />
                                        </td>
                                        <td>{{ $pengguna->nama }}</td>
                                        <td>{{ $pengguna->agensi }}</td>
                                        <td>{{ $pengguna->bahagian }}</td>
                                        <td>{{ $pengguna->id_access }}</td>
 
                                          <?php
                                            $status = $pengguna->status;
                                            $color = "";
                                            switch($status){
                                              //Aktif
                                              case "Aktif":  $color="#32CD32"; $badge="badge badge-success"; break; //hijau
                                              //Tidak Aktif
                                              case "Tidak Aktif": $color="#FF0000"; $badge="badge badge-danger"; break; //merah
                                              default : $color="#000000";
                                            }
                                          ?>
                                        {{-- <td style ="color:{{$color}};"> 
                                            <div class="d-flex align-items-center"><i class="{{ $badge }}"></i> {{ $status }}</div>
                                            <span class="{{ $badge }}"> <center>{{ $status }}</center> </span>  
                                        </td> --}}
                                        <td style="align-content: center">
                                          <center><span class="{{ $badge }}">{{ $pengguna->status }}</span></center> 
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">

                                                <a href="{{ url('pengguna/butiran/' . $pengguna->id) }}"
                                                    title="Kemaskini/Butiran Pengguna" class="btn btn-sm btn-rounded btn-info"><i
                                                        class="fas fa-pen"></i></a>

                                                {{-- @if ( Auth::user()->id_access == 'Pentadbir Sistem' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem')
                                                    <a href="{{ url('pengguna/hapus/' . $pengguna->id) }}" title="Hapus Pengguna" class="btn btn-sm btn-rounded btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif --}}
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        {{-- </div> --}}
                    </div>
                </div>


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
                            <form class="form-horizontal" method="POST" action="{{ url('pengguna/senarai') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-body">

                                <div class="form-group row">
                                    <label for="kod" class="col-sm-4 col-form-label">Agensi</label>
                                    <div class="col-sm-8">
                                        <select class="select2-peranan" id="agensi" name="agensi" style="width: 100%;">
                                            <option value="" @if ( $search['agensi'] == '') {{ 'selected="selected"' }} @endif>&nbsp; </option>
                                            @foreach ($optAgensis as $optAgensi)
                                                <option value="{{ $optAgensi->agensi }}"
                                                    @if ( $search['agensi'] == $optAgensi->agensi ) {{ 'selected="selected"' }} @endif>
                                                    {{ $optAgensi->agensi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="kod" class="col-sm-4 col-form-label">Peranan</label>
                                    <div class="col-sm-8">
                                        <select class="select2-peranan" id="peranan" name="peranan" style="width: 100%;">
                                            <option value="" @if ( $search['peranan'] == '') {{ 'selected="selected"' }} @endif>&nbsp; </option>
                                            @foreach ($optAccesss as $optAccess)
                                                <option value="{{ $optAccess->access_type }}"
                                                    @if ( $search['peranan'] == $optAccess->access_type ) {{ 'selected="selected"' }} @endif>
                                                    {{ $optAccess->access_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                    <select class="select2-status" id="status" name="status" style="width: 100%;">
                                        <option value="" @if($search['status']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                        @foreach ($optStatusUsers as $optStatusUser)
                                        <option value="{{ $optStatusUser->status }}" @if($search['status']==$optStatusUser->status) {{ 'selected="selected"' }} @endif>
                                            {{ $optStatusUser->status }}
                                        </option>
                                        @endforeach
                                    </select>   
                                    </div>
                                </div>
                            
                            </div>

                            <div class="modal-footer float-right">
                                <span class="float-right">
                                    <a href="{{ url('pengguna/senarai') }}" class="btn btn-default" name="tapis">Reset</a>
                                    <button type="submit" class="btn btn-primary bg-purple" name="tapis">Tapis</button>
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
    <!--**********************************
                Content body end
            ***********************************-->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
            $('.select2-peranan').select2({
                minimumResultsForSearch: Infinity
            });
            $('.select2-status').select2({
                minimumResultsForSearch: Infinity
            });
        });

        $(document).ready(function() {
            $('#example').DataTable({
                // "pageLength": 10,
                searching: true,
                // dom: 'lrtip', // Customize the DataTables elements (l - length menu, r - processing, t - table, i - information, p - pagination)
                language: {
                    search: 'Cari :',
                    paginate: {
                        next: '>', // Set the 'Next' button text to '>'
                        previous: '<' // Set the 'Next' button text to '>'
                    }
                },
            });
        });
    </script>
@endsection