@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                Content body start
            ***********************************-->
    <style>
        .card-body {
            margin-left: 10px;
        }
    </style>

    <div class="content-body">
        <div class="container-fluid">
            <div class="col-xl-23 col-lg-12">
                <form class="form-horizontal" method="POST" action="{{ url('pengguna/hapus/simpan/'.$pengguna->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                   <!-- Horizontal Form -->
                   <div class="card card-info">
                     <div class="card-header bg-purple">
                       {{-- <h3 class="card-title">Maklumat Pengguna</h3> --}}
                        <h3 class="font-w600 title mb-2 mr-auto">Butiran Pengguna</h3>
                     </div>
                     <!-- /.card-header -->
                     <!-- form start -->
                     <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">No. Mykad</dt>
                            <dd class="col-sm-9">{{ $pengguna->mykad }}</dd>
                            <dt class="col-sm-3">Nama</dt>
                            <dd class="col-sm-9">{{ $pengguna->nama }}</dd>
                            <dt class="col-sm-3">Agensi</dt>
                            <dd class="col-sm-9">{{ $pengguna->agensi }}</dd>
                            <dt class="col-sm-3">Bahagian</dt>
                            <dd class="col-sm-9">{{ $pengguna->bahagian }}</dd>
                            <dt class="col-sm-3">Jawatan</dt>
                            <dd class="col-sm-9">{{ $pengguna->jawatan }}</dd>
                            <dt class="col-sm-3">Gred</dt>
                            <dd class="col-sm-9">{{ $pengguna->gred }}</dd>
                            <dt class="col-sm-3">Emel</dt>
                            <dd class="col-sm-9">{{ $pengguna->email }}</dd>
                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-9">{{ $pengguna->status }}</dd>
                            <dt class="col-sm-3">Peranan</dt>
                            <dd class="col-sm-9">{{ $pengguna->id_access }}</dd>
                        </dl>
                    </div>
                       
                    <div class="card-header">
                        {{-- <h3 class="card-title">Maklumat Login</h3> --}}
                        <h3 class="font-w600 title mb-2 mr-auto">Butiran Pengguna</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">ID Pengguna</dt>
                            <dd class="col-sm-9">{{ $pengguna->mykad }}</dd>
                            <dt class="col-sm-3">Kata Laluan</dt>
                            <dd class="col-sm-3">************</dd>
                        </dl>
                    </div>		
                       
                   <!-- /.card-body -->
                   {{-- <div class="card-footer">
                        <span class="text-danger">Anda pasti ingin hapuskan Pengguna ini?</span> &nbsp;
                        <button type="submit" name="hapus_pengguna" class="btn btn-danger float-right">Ya, Hapus</button>
                        <button type="button" class="btn btn-default float-right" onclick="history.back();">Tidak</button>
                   </div> --}}
                   <div class="card-footer">
                        <button type="submit" name="hapus_pengguna" class="btn btn-danger float-right"><i class="fa fa-trash"></i>
                            Hapus Akaun Pengguna Ini?
                        </button>

                        <button type="button" class="btn btn-default float-right" style="color: black;"
                            onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali
                        </button>
                        {{-- <a href="{" class="btn btn-default float-right">
                            <i class="fas fa-redo-alt"></i> | Kembali
                        </a> --}}
                
                        <br><br>
                    </div>
                       <!-- /.card-footer -->
                   <!-- /.card -->
                 </div>
                 </form>
            </div>

        </div>

    </div>
    <!--**********************************
                Content body end
            ***********************************-->
@endsection
