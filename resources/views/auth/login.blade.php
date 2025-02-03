@extends('layouts.masterLogin')

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Sistem ePantas (Sistem Peruntukan Kewangan Kementerian Perpaduan Negara)" />
	<meta property="og:title" content="Sistem ePantas" />
	<meta property="og:description" content="Sistem ePantas (Sistem Peruntukan Kewangan Kementerian Perpaduan Negara)" />
	{{-- <meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png" /> --}}
	<meta name="format-detection" content="telephone=no">
    <title>ePantas </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/JataNegara.png">
	<link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">

    <style>
        body{
            background-image:url({{url('images/loginBG2.jpg')}});
            background-size: cover; /* or contain, or a specific size value */  
            /* background-position: center center; */
            /* height: 100%; */
        }
        h4 {
            /* font-family: "Arial Rounded MT Bold", sans-serif; */
            /* font-family: 'Quicksand', sans-serif; */
        }
        .checkboxPassword {
            display: none;
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
                                    {{-- <h4 class="text-center mb-4">Log Masuk</h4> --}}
                                    <h1 class="text-center mb-4">ePantas</h1>
                                    {{-- <button type="button" class="btn btn-dark mb-2  me-2" name="noti" id="toastr-success-top-center">Top Center</button> --}}

                                    {{-- <form action="{{ route('pemohon.search') }}"> --}}
                                    {{-- <form  action="{{ route('pemohon.search') }}" method="POST"> --}}
                                    <form action="{{ route('login') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            {{-- <label class="mb-1"><strong>No. Mykad</strong></label> --}}
                                            <input type="text" class="form-control" name="mykad" id="mykad" placeholder="No. Mykad" maxlength="12">
                                        </div>
                                        <div class="form-group">
                                            {{-- <label class="mb-1"><strong>Password</strong></label> --}}
                                            <input type="password" class="form-control" name="password" id="password" value="" oninput="toggleLabelVisibility()" placeholder="Kata Laluan">
                                        </div>

                                        <div class="checkboxPassword" id="checkboxPassword">
                                            <input type="checkbox" id="" onclick="togglePassword()">
                                            <label style="color: grey; font-size: 12px;">&nbsp;Lihat Kata Laluan</label>
                                        </div>
                                        

                                        {{-- <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Kata Laluan">
                                            <div class="input-group-append" >
                                                <button class="btn btn-info btn-sm text-black" type="button" onclick="togglePassword()"> <i class="fa fa-eye"></i> </button>
                                            </div>
                                        </div> --}}
                                        
                                        {{-- <div class="form-row d-flex justify-content-between mt-4 mb-2"> --}}
                                            <div class="new-account mt-3">
                                                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                                    <div class="form-group">
                                                        <small>
                                                            <a href="{{ url('/password/email/') }}">Lupa Kata Laluan?</a>
                                                        </small>
                                                    </div>
                                                    <div class="form-group">
                                                        <small>
                                                            <a href="{{ asset('/daftar/pilih') }}">Daftar Masuk</a>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="text-center">
                                            {{-- <button type="submit" class="btn btn-primary btn-block">Sign Me In</button> --}}
                                            {{-- <a href="/pemohon/tambah" class="btn btn-primary btn-block btn-rounded"> <font size='4px'>Login</font></a> --}}
                                            <button type="submit" name="login" class="btn btn-info btn-block btn-rounded">Log Masuk</button>
                                            <br>
                                            {{-- <small>
                                                <a href="{{ asset('storage/MANUAL_PENGGUNA_ePantas-PERMOHONAN.pdf') }}" target="_blank">Manual Pengguna</a>
                                            </small> --}}
                                            <div class="text-center mt-3">
                                                <a href="{{ asset('storage/MANUAL_PENGGUNA_ePantas-PERMOHONAN.pdf') }}" target="_blank"><i class="fa fa-book"></i> Manual Pengguna</a>
                                            </div>
                                        </div>
                                    </form>
                                    {{-- <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p>
                                        <p> <a class="text-primary" href="admin/login"><i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                             Login Pentadbir</a></p>
                                    </div> --}}
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

    {{-- JQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>

    <script>
        function togglePassword() { //Lihat Password
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
        function toggleLabelVisibility() {  //if tak type password tak muncul lihat password
            var password = document.getElementById("password");
            var passwordItem = document.getElementById("checkboxPassword");

            // Check if the password field has any value
            if (password.value.length > 0) {
                passwordItem.style.display = "inline"; // Show the label
            } else {
                passwordItem.style.display = "none"; // Hide the label
            }
        }
    </script>

    {{-- FOCUS ON INPUT BILA USER FIRST LOAD --}}
    <script>
        document.getElementById("mykad").focus();
    </script>
    {{-- FOCUS ON INPUT BILA USER FIRST LOAD --}}
    
    @if(session('fail'))
        <script>

            $( document ).ready(function() {
                toastr.error(" {{ session('fail') }} ", "Login Gagal", { positionClass: "toast-top-center" })
            });
            
        </script>
    @elseif (session('emel'))
        <script>

            $( document ).ready(function() {
                toastr.success(" {{ session('emel') }} ", "Periksa Emel Anda", { positionClass: "toast-top-center" })
            });
            
        </script>
    @elseif (session('status'))
        <script>

            $( document ).ready(function() {
                toastr.success(" {{ session('status') }} ", "", { positionClass: "toast-top-center" })
            });
            
        </script>
    @endif
    
</body>
</html>