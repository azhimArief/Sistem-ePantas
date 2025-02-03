{{-- @extends('layouts.masterLogin') --}}

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
        .form-control{
            border:1px solid #c0bcbc;
        } 
        #passwordRequirements, #checkboxPassword{
            display: none;
        }
        /* #checkboxPassword {
            display: none;
        } */

         /* TOOLTIP */
         .tooltip-text {
            visibility: hidden;
            position: absolute;
            z-index: 1;
            width: 180px;
            color: rgb(0, 0, 0);
            font-size: 13px;
            background-color: #51aeff;
            border-radius: 10px;
            padding: 10px 15px 10px 15px;
            }

            .hover-text:hover .tooltip-text {
            visibility: visible;
            }
            .hover-text-latarBelakang:hover .tooltip-text {
            visibility: visible;
            }

            #right {
            top: -8px;
            left: 120%;
            }

            .hover-text {
            color: #2993f0;
            position: relative;
            display: inline-block;
            /* margin: 40px; */
            text-align: left;
            }
        /* TOOLTIP */
    </style>
    @if($errors->has('mykad'))
        <style>
            #mykad {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('name'))
        <style>
            #name {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('emel'))
        <style>
            #emel {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('agensi'))
        <style>
            #agensi {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('bahagian'))
        <style>
            #bahagian {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('jawatan'))
        <style>
            #jawatan {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('gred'))
        <style>
            #gred {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('tel'))
        <style>
            #tel {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('tel_pejabat'))
        <style>
            #tel_pejabat {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('password'))
        <style>
            #password {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   
    @if($errors->has('captcha'))
        <style>
            #captcha {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif   

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
                <div class="col-md-9">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                                            {{ session('status') }}
                                            {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ session('status') }} --}}
                                        </div>
                                    @elseif(session('failed'))
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                            {{ session('failed') }}
                                            {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ session('failed') }} --}}
                                        </div>
                                    @endif

                                    {{-- @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>
                                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                        {{ $error }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif --}}
                                    
									<div class="text-center mb-3">
										{{-- <img src="images/logo-full.png" alt=""> --}}
										{{-- <img src="images/JataNegara.png" width="80" height="70" alt=""> --}}
                                        <center><img src="{{asset('/images/JataNegara0.png')}}" class="img-circle elevation-2" width="170" height="170" alt="User Image"></center>
									</div>
                                    {{-- <h4 class="text-center mb-4">Log Masuk</h4> --}}
                                    <h1 class="text-center mb-4">ePantas</h1>
                                    {{-- <button type="button" class="btn btn-dark mb-2  me-2" name="noti" id="toastr-success-top-center">Top Center</button> --}}
                                    <form action="{{ url('daftar/daftarAgensi') }}" method="POST">
                                        {{ csrf_field() }}
                                        
                                        
                                        <center><h3 class="badge badge-primary" style="color:white;"> Pendaftaran Agensi</h3></center>
                                        <br>
                                        
                                        {{-- <div class="form-group">
                                            <center><h3 class="badge badge-primary" style="color:white;"> Pendaftaran Agensi</h3></center>
                                            <label class="mb-1"><strong>No. Mykad <font color="red">*</font></strong></label>
                                            <input type="text" name="mykad" id='mykad' class="form-control" value="{{ old('mykad') }}" title="eg. 000000000000" maxlength="12" required>
                                        </div> --}}
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-3 col-form-label" style="text-align:left">
                                                <strong>
                                                    No. Mykad
                                                    <div class="hover-text">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">Tanpa (-) Eg: 000011112222</span>
                                                    </div> 
                                                </strong> 
                                                {{-- <font color="red">*</font> --}}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="mykad" name="mykad" 
                                                    value="{{ old('mykad') }}" placeholder="" maxlength="12">
                                                @error('mykad')<div class="text-danger text-strong">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        {{-- <div class="form-group">
                                            <label class="mb-1"><strong>Nama <font color="red">*</font></strong></label>
                                            <input type="text" name="name" id="name" class="form-control capitalize" value="{{ old('name') }}" required>
                                        </div> --}}
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-3 col-form-label" style="text-align:left"><strong>Nama</strong> 
                                                {{-- <font color="red">*</font> --}}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control capitalize" id="name" name="name"
                                                    value="{{ old('name') }}" placeholder="" oninput="formatInput(this)">
                                                @error('name')<div class="text-danger text-strong">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        {{-- <div class="form-group">
                                            <label class="mb-1"><strong>Emel <font color="red">*</font></strong></label>
                                            <input type="email" name="emel" id="emel" class="form-control" value="{{ old('emel') }}" required alt="Sila gunakan emel sahih yang dibawah Kementerian Perpaduan Negara.">
                                        </div> --}}
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-3 col-form-label" style="text-align:left">
                                                <strong>
                                                    Emel
                                                    <div class="hover-text">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">Pastikan anda menggunakan emel kerajaan yang sah.</span>
                                                    </div>
                                                </strong> 
                                                {{-- <font color="red">*</font> --}}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="emel" name="emel" 
                                                    value="{{ old('emel') }}" placeholder=""  alt="Sila gunakan emel sahih yang dibawah Kementerian Perpaduan Negara.">
                                                @error('emel')<div class="text-danger text-strong">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        {{-- <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for="agensi" class="mb-1" style="text-align:left" ><strong>Agensi <font color="red">*</font></strong> </label>
                                                <input type="text" class="form-control" id="agensi" name="agensi"  value="{{ old('agensi')}}" required >
                                            </div>
                                        </div> --}}
                                        <div class="form-group row">
                                            <label for="agensi" class="col-sm-3 col-form-label"> <strong>Agensi</strong> 
                                                {{-- <font color="red"> * </font> --}}
                                            </label>
                                            <div class="col-sm-9 d-flex">
                                                <div class="dropdown mr-2">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" style="height:100%; "> 
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="hover:">
                                                        @foreach ($agensis as $agensi)
                                                            <button type="button" class="dropdown-item agensi-option" style="color: black;">{{ $agensi->agensi }}</button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" id="agensi" name="agensi" placeholder="" value="{{ old('agensi') }}">
                                                @error('agensi')<div class="text-danger text-strong">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-3 col-form-label" style="text-align:left">
                                                <strong>
                                                    Bahagian
                                                    <div class="hover-text">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                        <span class="tooltip-text" id="right">Pastikan anda memasukkan nama penuh dan betul bahagian anda.</span>
                                                    </div>
                                                </strong> 
                                                {{-- <font color="red">*</font> --}}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control capitalize" id="bahagian" name="bahagian" 
                                                    value="{{ old('bahagian') }}" placeholder="" oninput="formatInput(this)">
                                                    {{-- <small class="text-danger">* Pastikan anda memasukkan nama penuh dan betul bahagian anda.</small> --}}
                                                @error('bahagian')<div class="text-danger text-strong">{{ $message }}</div>@enderror

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="jawatan" class="mb-1" style="text-align:left" ><strong>Jawatan </strong> 
                                                    {{-- <font color="red">*</font> --}}
                                                </label>
                                                <input type="text" class="form-control capitalize" id="jawatan" name="jawatan"  value="{{ old('jawatan') }}"  oninput="formatInput(this)">
                                                @error('jawatan')<div class="text-danger text-strong">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="gred" class="mb-1" style="text-align:left" >
                                                    <strong>
                                                        Gred 
                                                        <div class="hover-text">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                            <span class="tooltip-text" id="right">Hanya Gred 41 keatas boleh mendaftar.</span>
                                                        </div> 
                                                    {{-- <font color="red">*</font> --}}
                                                    </strong> 
                                                </label>
                                                <input type="text" class="form-control" id="gred" name="gred"  value="{{ old('gred')}}"  >
                                                @error('gred')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="tel" class="mb-1" style="text-align:left" ><strong>No. Telefon 
                                                    {{-- <font color="red">*</font></strong>  --}}
                                                </label>
                                                <input type="number" class="form-control" id="tel" name="tel"  value="{{ old('tel')}}"  >
                                                @error('tel')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="tel_pejabat" class="mb-1" style="text-align:left" > <strong>No. Telefon Pejabat</strong> </strong>
                                                     <small> <font color="red">(Optional)</font> </small>
                                                </label>
                                                <input type="number" class="form-control" id="tel_pejabat" name="tel_pejabat"  value="{{ old('tel_pejabat')}}" >
                                                @error('tel_pejabat')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label class="mb-1"><strong>Kata Laluan</strong> <small><font color="red">(min 8 aksara)</font></small> </label>
                                                <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" oninput="toggleLabelVisibility()" required>
                                                @error('password')<div class="text-danger">{{ $message }}</div>@enderror

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
                                                <label class="mb-1"><strong>Sahkan Kata Laluan </strong><font color="red">*</font></label>
                                                <input type="password" name="Cpassword" id="Cpassword" class="form-control" value="" required>
                                            </div> --}}
                                            <div class="col-sm-12">
                                                {{-- <br> --}}
                                                {{-- <small style="color: red;">*Kata laluan harus mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, dan satu nombor.</small> <br>    --}}
                                                <small style="color: red;">*Sila pastikan semua kecuali ruangan <i>optional</i> telah diisi.</small> <br>
                                                <small style="color: red;">*Untuk tujuan pengesahan, sila gunakan alamat e-mel yang sah.</small>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center form-group mt-2 mb-2">
                                            <div class="captcha">
                                                <span>{!! captcha_img('flat') !!}</span>
                                                <button type="button" class="btn btn-danger reload" id="reload" name="reload">
                                                    &#x21bb;
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2 mb-2">
                                            <input type="text" class="form-control" placeholder="Refresh semula captcha jika anda mengalami masalah dengan pengisian captcha." name="captcha" id="captcha"> 
                                            @error('captcha')<div class="text-danger text-strong">{{ $message }}</div>@enderror
                                        </div>

                                        

                                        <br>
                                        {{-- <div class="text-center"> --}}
                                        <div class=" justify-content-center">
                                            <button type="submit" name="hantar" id="hantar" class=" btn-info float-right btn-rounded btn-sm"> 
                                                <i class="fa fa-paper-plane" aria-hidden="true"></i> | Cipta Akaun
                                            </button>                  
                                            <a type="button" href="{{ route('login') }}" class="btn-sm btn-secondary btn-rounded"><i class="fas fa-redo-alt"></i> | Kembali</a>
                                            {{-- <button type="submit" class="btn btn-info btn-block btn-rounded"> <font size='4px'>Login</font></button>                                                 --}}
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
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/js/custom.min.js') }}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>

    {{-- JQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    
    {{-- @if(session('fail'))
        <script>

            $( document ).ready(function() {
                toastr.error(" {{ session('fail') }} ", "Pendaftaran Gagal", { positionClass: "toast-top-center" })
            });
            
        </script>
    @endif --}}

    {{-- FOCUS ON MYKAD BILA USER FIRST LOAD --}}
        @if( !session('failed') && !$errors->any() )
            <script>
                document.getElementById("mykad").focus();
            </script>
        @endif
    {{-- FOCUS ON MYKAD BILA USER FIRST LOAD --}}

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

    {{-- CAPTCHA --}}
        <script>
            const baseUrl = '{{ url('/') }}';
            $('#reload').click(function(){
                console.log('hello');
                $.ajax({
                    type: 'GET',
                    url: `${baseUrl}/reload_captcha`,
                    // url: '/epantas/reload_captcha', //for Dev
                    success: function (data) {
                    $(".captcha span").html (data.captcha)
                    }
                });
            });
        </script>
    {{-- CAPTCHA --}}

    {{-- CANNOT CAPS LOCK AUTO UPPER CASE --}}
        <script>
            function formatInput(input) {
                input.value = input.value
                    .toLowerCase()
                    .replace(/(^\w|\s\w)/g, match => match.toUpperCase());
            }
        </script>
    {{-- CANNOT CAPS LOCK AUTO UPPER CASE --}}

    <script>
        //Untuk Input Name Auto Caps Each Word
        $(document).ready(function() {
            $('#name, #bahagian, #jawatan').on('input', function() {
                var value = $(this).val();
                $(this).val(value.replace(/\b\w/g, function(l) {
                    return l.toUpperCase();
                }));
            });
        });
        // $(document).ready(function() {
        //     $('#name.capitalize').on('input', function() {
        //         var value = $(this).val();
        //         $(this).val(value.replace(/\b\w/g, function(l) {
        //             return l.toUpperCase();
        //         }));
        //     });
        // });
    </script>

    <script>
        //Prevent From User Tekan ENTER Key
        document.addEventListener('DOMContentLoaded', function () {
                document.addEventListener('keydown', function (e) {
                    // Disable form submission on Enter key press
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            });
    </script>

    <script>
        // UNTUK SELECT AGENSI
        // Get all dropdown items with the class 'agensi-option'
        var dropdownItems = document.querySelectorAll('.agensi-option');

        // Attach click event listeners to each dropdown item
        dropdownItems.forEach(function(item) {
            item.addEventListener('click', function() {
                // Get the text content of the clicked dropdown item
                var agensiValue = item.textContent.trim();

                // Set the value of the input field with id 'agensi' to the selected value
                document.getElementById('agensi').value = agensiValue;
            });
        });
    </script>
    
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

    {{-- FOCUS ON INPUT BILA USER ERROR --}}
    @if($errors->has('mykad'))
        <script>
            document.getElementById("mykad").focus();
        </script>
    @elseif($errors->has('name'))
        <script>
            document.getElementById("name").focus();
        </script>
    @elseif($errors->has('emel'))
        <script>
            document.getElementById("emel").focus();
        </script>
    @elseif($errors->has('agensi'))
        <script>
            document.getElementById("agensi").focus();
        </script>
    @elseif($errors->has('bahagian'))
        <script>
            document.getElementById("bahagian").focus();
        </script>
    @elseif($errors->has('jawatan'))
        <script>
            document.getElementById("jawatan").focus();
        </script>
    @elseif($errors->has('gred'))
        <script>
            document.getElementById("gred").focus();
        </script>
    @elseif($errors->has('tel'))
        <script>
            document.getElementById("tel").focus();
        </script>
    @elseif($errors->has('tel_pejabat'))
        <script>
            document.getElementById("tel_pejabat").focus();
        </script>
    @elseif($errors->has('password'))
        <script>
            document.getElementById("password").focus();
        </script>
    @elseif($errors->has('captcha'))
        <script>
            document.getElementById("captcha").focus();
        </script>
    @endif
    {{-- FOCUS ON INPUT BILA USER USER ERROR --}}

    
</body>
</html>