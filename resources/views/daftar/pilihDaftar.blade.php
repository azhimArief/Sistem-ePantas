@extends('layouts.masterLogin')

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Zenix - Crypto Admin Dashboard" />
	<meta property="og:title" content="Zenix - Crypto Admin Dashboard" />
	<meta property="og:description" content="Zenix - Crypto Admin Dashboard" />
	<meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">
    <title>ePantas </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/JataNegara.png') }}">
	{{-- <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet"> --}}
	<link href="{{ asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    {{-- <link href="./css/style.css" rel="stylesheet"> --}}
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    <style>
        body{
            background-image:url({{url('images/loginBG2.jpg')}});
            background-size: cover; /* or contain, or a specific size value */
            /* background-position: center center; */
            /* height: 100%; */
        }
    </style>

</head>

<body class="vh-100">
    {{-- @if (session('fail'))
        <div class="col-xl-3">
            <div class="alert alert-danger left-icon-big alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span></button>
                <div class="media">
                    <div class="alert-left-icon-big">
                        <span><i class="mdi mdi-alert"></i></span>
                    </div>
                    <div class="media-body">
                        <h5 class="mt-1 mb-1">Login Gagal!</h5>
                        <p class="mb-0">Pengguna tidak wujud</p>
                    </div>
                 </div>
            </div>
        </div>
    @endif --}}
    
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										{{-- <img src="images/logo-full.png" alt=""> --}}
										{{-- <img src="images/JataNegara.png" width="80" height="70" alt=""> --}}
                                        <center><img src="{{asset('/images/JataNegara0.png')}}" class="img-circle elevation-2" width="170" height="170" alt="User Image"></center>
									</div>
                                    <h1 class="text-center mb-4">ePantas</h1>

                                    <div class="text-center">
                                        {{-- <a href="{{ url('daftar/daftarAgensi') }}" name="" class="btn btn-info btn-block btn-rounded"> Daftar pengguna Agensi/Jabatan</a> --}}
                                        {{-- <a href="{{ url('daftar/email/') }}" name="" class="btn btn-info btn-block btn-rounded">Daftar pengguna Kementerian</a> --}}
                                        <a href="{{ url('daftar/daftarAgensi') }}" class="button-30 btn-warning btn-block" role="button"> 
                                            Daftar Pengguna Agensi/Jabatan&nbsp;
                                            {{-- <i class="fa fa-user"></i> --}}
                                        </a>
                                        <a href="{{ url('daftar/email/') }}" class="button-30 btn-info btn-block" role="button"> 
                                            Daftar Pengguna Kementerian&nbsp;
                                            {{-- <i class="fa fa-user-o"></i> --}}
                                        </a>
                                    </div>

                                    {{-- <div class="container mt-5">
                                        <a class="btn btn-info btn-block btn-rounded">
                                          <i class="fas fa-user fa-lg d-block mb-2"></i>
                                          Daftar pengguna Agensi/Jabatan
                                        </a>
                                        <a class="btn btn-info btn-block btn-rounded">
                                          <i class="fas fa-user fa-lg d-block mb-2"></i>
                                          Daftar pengguna Agensi/Jabatan
                                        </a>
                                    </div> --}}

                                    <div class="text-center">
                                        <br>
                                        <a href="{{ route('login') }}"><i class="fas fa-redo-alt"></i> | Kembali</a>
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
        Scripts
    ***********************************-->

    <!-- Required vendors -->
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/js/custom.min.js') }}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>

    {{-- JQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    
    @if(session('fail'))
        <script>

            $( document ).ready(function() {
                toastr.error(" {{ session('fail') }} ", "Login Gagal", { positionClass: "toast-top-center" })
            });
            
        </script>
    @endif
    
</body>
</html>