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

                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="font-weight-bold mb-0">Butiran Pengguna</h3>
                        <?php
                            $status = $pengguna->status;
                            $badge = ($status == 'Aktif') ? 'badge-success' : 'badge-danger';
                            $statusText = ($status == 'Aktif') ? 'Status: Aktif' : 'Status: Tidak Aktif';
                        ?>
                        <span class="badge badge-pill {{ $badge }} px-3 py-2">{{ $statusText }}</span>
                    </div>
                
                    <!-- User Details -->
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-md-4">No. Mykad</dt>
                            <dd class="col-md-8">{{ $pengguna->mykad ?? '-' }}</dd>
                
                            <dt class="col-md-4">Nama</dt>
                            <dd class="col-md-8">{{ $pengguna->nama ?? '-' }}</dd>
                
                            <dt class="col-md-4">Agensi</dt>
                            <dd class="col-md-8">{{ $pengguna->agensi ?? '-' }}</dd>
                
                            <dt class="col-md-4">Bahagian</dt>
                            <dd class="col-md-8">{{ $pengguna->bahagian ?? '-' }}</dd>
                
                            <dt class="col-md-4">Jawatan</dt>
                            <dd class="col-md-8">{{ $pengguna->jawatan ?? '-' }}</dd>
                
                            <dt class="col-md-4">Gred</dt>
                            <dd class="col-md-8">{{ $pengguna->gred ?? '-' }}</dd>
                
                            <dt class="col-md-4">Emel</dt>
                            <dd class="col-md-8">{{ $pengguna->email ?? '-' }}</dd>
                
                            <dt class="col-md-4">Peranan</dt>
                            <dd class="col-md-8">{{ $pengguna->id_access ?? '-' }}</dd>
                        </dl>
                    </div>
                
                    <!-- Login Details -->
                    <div class="card-header bg-light">
                        <h4 class="font-weight-bold mb-0">Maklumat Login</h4>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-md-4">ID Pengguna</dt>
                            <dd class="col-md-8">{{ $pengguna->mykad }}</dd>
                
                            <dt class="col-md-4">Kata Laluan</dt>
                            <dd class="col-md-8">************</dd>
                        </dl>
                    </div>
                
                    <!-- Action Buttons -->
                    <div class="card-footer bg-white d-flex justify-content-end">
                        @if (Auth::user()->id == $pengguna->id || in_array(Auth::user()->id_access, ['Pentadbir Sistem', 'Pentadbir Teknikal Sistem']))
                            <a href="{{ url('pengguna/kemaskini/'.$pengguna->id) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-edit"></i> Kemaskini
                            </a>
                        @endif
                    </div>
                </div>
                

        </div>

    </div>
    <!--**********************************
                Content body end
            ***********************************-->

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Select the alert element
            var alertElement = document.querySelector('.alert');
    
            // Hide the alert after 5 seconds (5000 milliseconds)
            setTimeout(function() {
                alertElement.parentNode.removeChild(alertElement);
            }, 5000);
        });
    </script>
    
@endsection
