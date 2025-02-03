@extends('layouts.master')
@section('content')
    <!--**********************************
                Content body start
            ***********************************-->
    <style>
        dt, dd {
            font-size: 15px;
        }
        .card-body {
            margin-left: 30px;
        }
    </style>

    <div class="content-body">
        <div class="container-fluid">

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

            <div class="col-xl-12 col-lg-12">
                <div class="card card-info">
                    <!-- Maklumat Pengguna -->
                    <div class="card-header bg-light text-white">
                        <h3 class="font-w600 mb-0">Maklumat Pengguna</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-4">
                            <dt class="col-sm-3 font-weight-bold">No. Mykad</dt>
                            <dd class="col-sm-9">{{ $user->mykad }}</dd>
                            <dt class="col-sm-3 font-weight-bold">Nama</dt>
                            <dd class="col-sm-9">{{ $user->nama }}</dd>
                            <dt class="col-sm-3 font-weight-bold">Agensi</dt>
                            <dd class="col-sm-9">{{ $user->agensi }}</dd>
                            <dt class="col-sm-3 font-weight-bold">Bahagian</dt>
                            <dd class="col-sm-9">{{ $user->bahagian }}</dd>
                            <dt class="col-sm-3 font-weight-bold">Jawatan</dt>
                            <dd class="col-sm-9">{{ $user->jawatan }}</dd>
                            <dt class="col-sm-3 font-weight-bold">Status</dt>
                            <dd class="col-sm-9">
                                <span class="badge badge-pill 
                                    {{ $user->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->status }}
                                </span>
                            </dd>
                        </dl>
                    </div>
            
                    <!-- Maklumat Login -->
                    <div class="card-header bg-light text-white">
                        <h3 class="font-w600 mb-0">Maklumat Login</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-4">
                            <dt class="col-sm-3 font-weight-bold">ID Pengguna</dt>
                            <dd class="col-sm-9">{{ $user->mykad }}</dd>
                            <dt class="col-sm-3 font-weight-bold">Kata Laluan</dt>
                            <dd class="col-sm-9">************</dd>
                        </dl>
                    </div>
            
                    <!-- Footer Buttons -->
                    <div class="card-footer">
                        <div class="btn-group float-right">
                            <a href="{{ url('pemohon/menu/' . $user->id) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ url('pemohon/profil/kemaskini/'.$user->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-edit"></i> Kemaskini
                            </a>
                        </div>
                    </div>
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


