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
    <div class="container h-100">
        <br>
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-12">
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
                                    {{-- url('/daftar/daftarGov/{id}') --}}
                                    <form action="{{ url('daftar/daftarGov/' . $usertoken->token) }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <center><h3 class="badge badge-primary" style="color:white;"> Pendaftaran Kementerian</h3></center>
                                            <label class="mb-1"><strong>No. Mykad</strong></label>
                                            <input type="text" name="mykad" id='mykad' class="form-control" value="{{ $personel->nokp }}" maxlength="12">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Nama</strong></label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ $personel->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="text" name="emel" id="emel" class="form-control" value="{{ $personel->email }}">
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="bahagian" class="mb-1" style="text-align:left" ><strong>Bahagian</strong> </label>
                                                <input type="text" class="form-control" id="bahagian" name="bahagian"  
                                                value="{{ $personel->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : '' }}" 
                                                {{-- value="Bahagian Kesepaduan Sosial dan Integrasi Nasional" --}}
                                                 >
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="jawatan" class="mb-1" style="text-align:left" ><strong>Jawatan</strong> </label>
                                                <input type="text" class="form-control" id="jawatan" name="jawatan"  value="{{ $personel->jawatan }}" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Gred</strong></label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ $personel->gred }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            {{-- <label class="mb-1" style="color: red;"><strong>*Jika maklumat anda betul sila masukkan kata laluan untuk mendaftar.</strong></label> --}}
                                            <label class="mb-1" style="color: red;"><strong>*Pastikan maklumat anda betul. Kemudian, masukkan kata laluan untuk melengkapkan pendaftaran.</strong></label>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="mb-1"><strong>Kata Laluan</strong> <small><font color="red">(min 8 aksara)</font></small> </label>
                                                <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" oninput="toggleLabelVisibility()" required>
                                                {{-- <small style="color: red;">*Kata laluan harus mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, dan satu nombor.</small> --}}

                                                <div class="checkboxPassword" id="checkboxPassword">
                                                    <input type="checkbox" id="" onclick="togglePassword()">
                                                    <label style="color: grey; font-size: 12px;">&nbsp;Lihat Kata Laluan</label>
                                                </div>

                                                <div id="passwordRequirements">
                                                    {{-- <p>Password must meet the following requirements:</p> --}}
                                                    <ul>
                                                        <li id="length"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Minimum 8 aksara</small> </li>
                                                        <li id="uppercase"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu huruf besar (A-Z)</small> </li>
                                                        <li id="lowercase"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu huruf kecil (a-z)</small> </li>
                                                        <li id="number"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu nombor (0-9)</small> </li>
                                                        <li id="special"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu karakter khas (!,@,#,$)</small> </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            {{-- <div class="col-sm-6">
                                                <label class="mb-1"><strong>Sahkan Kata Laluan</strong></label>
                                                <input type="password" name="Cpassword" id="Cpassword" class="form-control" value="{{ old('Cpassword') }}">
                                            </div> --}}
                                        </div>

                                        {{-- <div class="text-center"> --}}
                                        <div class="justify-content-center">
                                            <button type="submit" name="hantar" id="hantar" class="btn btn-info float-right btn-rounded btn-sm"> 
                                                <i class="fa fa-paper-plane" aria-hidden="true"></i> | Cipta Akaun
                                            </button>                                                
                                            {{-- <button type="submit" class="btn btn-info btn-block btn-rounded"> <font size='4px'>Login</font></button>                                                 --}}
                                        </div>
                                        <br>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <br>
    </div>
    {{-- </div> --}}


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
                toastr.error(" {{ session('fail') }} ", "Pendaftaran Gagal", { positionClass: "toast-top-center" })
            });
            
        </script>
    @endif

    {{-- FOCUS ON PASSWORD BILA USER FIRST LOAD --}}
    @if ( !$errors->any() )
    <script>
        document.getElementById("password").focus();
    </script>
    @endif
    {{-- FOCUS ON PASSWORD BILA USER FIRST LOAD --}}

    {{-- PASSWORD CHECKBOX --}}
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
    {{-- PASSWORD CHECKBOX --}}

    {{-- PASSWORD LIVE UPDATE REQUIREMENT --}}
    <script>
        // Function to validate password requirements
        function validatePassword(password) {
            var requirementsMet = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };
            return requirementsMet;
        }

        // Function to update password requirements display
        function updatePasswordRequirementsDisplay(requirementsMet) {
            for (var requirement in requirementsMet) {
                var element = document.getElementById(requirement);
                // console.log(requirement);
                if (element) {
                    if (requirementsMet[requirement]) {
                        element.classList.add('met');
                        document.getElementById(requirement).style.display = 'none';
                    } else {
                        element.classList.remove('met');
                        document.getElementById(requirement).style.display = 'block';
                    }
                }
            }
        }
        
        // Listen for input events on the password field
        document.getElementById('password').addEventListener('input', function() {
            var password = this.value;
            var requirementsMet = validatePassword(password);
            updatePasswordRequirementsDisplay(requirementsMet);

            //if input show requirement password
            var passwordRequirementsDiv = document.getElementById('passwordRequirements');
            if (password.length > 0) {
                passwordRequirementsDiv.style.display = 'block';
            } else {
                passwordRequirementsDiv.style.display = 'none';
            }
        }); 
    </script>
    {{-- PASSWORD LIVE UPDATE REQUIREMENT --}}
    
</body>
</html>