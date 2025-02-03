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
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/JataNegara.png') }}"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/JataNegara.png') }}">
	<link href="{{ asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    <style>
        body{
            background-image:url({{url('images/loginBG2.jpg')}});
            background-size: cover; /* or contain, or a specific size value */
            /* background-position: center center; */
            /* height: 100%; */
        }
        .form-control{
            border:1px solid #000000;
        }
    </style>

</head>

<body class="vh-100">
    {{-- @if(session('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
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

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>
                                                            {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> --}}
                                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                            {{ $error }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <center><img src="{{asset('/images/JataNegara0.png')}}" class="img-circle elevation-2" width="170" height="170" alt="User Image"></center>

									</div>
                                    {{-- <h4 class="text-center mb-4">Log Masuk</h4> --}}
                                    <h1 class="text-center mb-4">ePantas</h1>
                                    {{-- <center><h3 class="badge badge-primary" style="color:white;"> Pendaftaran Kementerian</h3></center> --}}

                                    {{-- <button type="button" class="btn btn-dark mb-2  me-2" name="noti" id="toastr-success-top-center">Top Center</button> --}}

                                    {{-- <form action="index.html"> --}}
                                    <form action="{{ url('daftar/verify_email') }}" method="POST">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label class="mb-1"><strong>Sahkan Emel Anda</strong></label>
                                            <input type="email" name="emel" id='emel' class="form-control" value="" placeholder="e.g verifyemel@perpaduan.gov.com.my" required>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="hantar_emel" class="btn btn-primary btn-block btn-rounded">Hantar</button>
                                        </div>

                                        <div class="text-center">
                                            <br>
                                            <a href="{{ route('login') }}"><i class="fas fa-redo-alt"></i> | Kembali</a>
                                        </div>
                                    </form>
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
    <script src="./vendor/global/global.min.js"></script>
	<script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./js/custom.min.js"></script>
	<script src="./js/deznav-init.js"></script>
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/js/custom.min.js') }}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>

    {{-- JQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    
    @if(session('fail'))
        <script>
            $( document ).ready(function() {
                toastr.error("{{ session('fail') }}", "Akaun Sudah Dicipta.", { positionClass: "toast-top-center" })
            });
        </script>
    @endif

    @if(session('failNull'))
        <script>
           $( document ).ready(function() {
                toastr.error("{{ session('failNull') }}", "Pengesahan Emel Gagal.", { positionClass: "toast-top-center" })
            });
        </script>
    @endif

    {{-- FOCUS ON INPUT BILA USER FIRST LOAD --}}
    <script>
        document.getElementById("emel").focus();
    </script>
    {{-- FOCUS ON INPUT BILA USER FIRST LOAD --}}

    {{-- MESSAGE UNTUK FIELD REQUIRED --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all required inputs
                const requiredInputs = document.querySelectorAll('input[required]');

                requiredInputs.forEach(function(input) {
                    input.addEventListener('invalid', function() {
                        // Customize the validation message
                        input.setCustomValidity('Ruangan ini diperlukan. Sila isi.');
                    });

                    input.addEventListener('input', function() {
                        // Clear the custom validation message
                        input.setCustomValidity('');
                    });
                });
            });
        </script>
    {{-- MESSAGE UNTUK FIELD REQUIRED --}}
    
</body>
</html>