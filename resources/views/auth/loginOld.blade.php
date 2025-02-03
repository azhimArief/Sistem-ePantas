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
    <title>Sistem Peruntukan Kewangan </title>
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
                                    <h4 class="text-center mb-4">Sistem Peruntukan Kewangan</h4>
                                    {{-- <button type="button" class="btn btn-dark mb-2  me-2" name="noti" id="toastr-success-top-center">Top Center</button> --}}

                                    {{-- <form action="{{ route('pemohon.search') }}"> --}}
                                    <form  action="{{ route('pemohon.search') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            {{-- <label class="mb-1"><strong>No. Mykad</strong></label> --}}
                                            <input type="text" class="form-control" name="nokp" placeholder="Masukkan No. Mykad" maxlength="12">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" value="Password">
                                        </div> --}}
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            {{-- <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label" for="basic_checkbox_1">Remember my preference</label>
												</div>
                                            </div>
                                            <div class="form-group">
                                                <a href="page-forgot-password.html">Forgot Password?</a>
                                            </div> --}}
                                        </div>
                                        <div class="text-center">
                                            {{-- <button type="submit" class="btn btn-primary btn-block">Sign Me In</button> --}}
                                            {{-- <a href="/pemohon/tambah" class="btn btn-primary btn-block btn-rounded"> <font size='4px'>Login</font></a> --}}
                                            <button type="submit" name="login" class="btn btn-primary btn-block btn-rounded">Login</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        {{-- <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p> --}}
                                        <p> <a class="text-primary" href="admin/login">Login Pentadbir</a></p>
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
    <script src="./vendor/global/global.min.js"></script>
	<script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./js/custom.min.js"></script>
	<script src="./js/deznav-init.js"></script>

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