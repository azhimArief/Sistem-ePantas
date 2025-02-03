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
    @if(session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
@endif

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
										{{-- <img src="{{ asset('images/JataNegara.png') }}" width="80" height="70" alt=""> --}}
                                        <center><img src="{{asset('/images/JataNegara0.png')}}" class="img-circle elevation-2" width="170" height="170" alt="User Image"></center>

									</div>
                                    {{-- <h4 class="text-center mb-4">Log Masuk</h4> --}}
                                    <h3 class="text-center mb-4">ePantas</h3>
                                    {{-- <button type="button" class="btn btn-dark mb-2  me-2" name="noti" id="toastr-success-top-center">Top Center</button> --}}

                                    {{-- <form action="index.html"> --}}
                                    <form action="{{ route('login') }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            {{-- <center><h6> <span class="badge badge-primary">Login Pentadbir</span></h6></center> --}}
                                            <center><h3 class="badge badge-primary" style="color:white;"> Login Pentadbir</h3></center>
                                            <label class="mb-1"><strong>No. Mykad</strong></label>
                                            <input type="text" name="mykad" id='mykad' class="form-control" value="770425026152" maxlength="12" placeholder="Masukkan No. Mykad">
                                            {{-- @error('mykad')
                                                <font color="red">{{ $message }}</font>
                                            @enderror --}}
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Kata Laluan</strong></label>
                                            <input type="password" name="password" id="password" class="form-control" value="1234567890" placeholder="">
                                            {{-- @error('mykad')
                                                <font color="red">{{ $message }}</font>
                                            @enderror --}}
                                            {{-- <input type="password" class="form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required> --}}
                                        </div>
                                        {{-- <div class="form-group row">
                                            <div class="col-md-6 offset-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            {{-- <div class="form-group">
                                                <div id="message">
                                                    <h5>Password must contain the following:</h5>
                                                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                                    <p id="number" class="invalid">A <b>number</b></p>
                                                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                                  </div>
                                            </div> --}}
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
                                            {{-- <a href="/peruntukan/senarai" class="btn btn-primary btn-block btn-rounded"> <font size='4px'>Login</font></a> --}}
                                            <button type="submit" class="btn btn-primary btn-block btn-rounded"> <font size='4px'>Login</font></button>                                                
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        {{-- <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p> --}}
                                        {{-- <p> <a class="text-primary" href="admin/login">Login Pentadbir</a></p> --}}
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
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/js/custom.min.js') }}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>

    {{-- JQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    
    @if(session('fail'))
        <script>

            $( document ).ready(function() {
                toastr.error("{{ session('fail') }}", "Login Gagal ", { positionClass: "toast-top-center" })
            });
            
        </script>
    @endif
    
</body>
</html>