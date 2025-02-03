<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
    <meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
	{{-- <meta name="description" content="Zenix - Crypto Admin Dashboard" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<meta property="og:title" content="Sistem ePantas" />
	<meta property="og:description" content="Sistem ePantas (Sistem Peruntukan Kewangan Kementerian Perpaduan Negara)" />
	{{-- <meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png" /> --}}
	<meta name="format-detection" content="telephone=no">
    <title>ePantas </title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('icons/font-awesome-5/css/all.min.css')}}">
    <!-- Title icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/JataNegara.png') }}">
	{{-- <link rel="stylesheet" href="./vendor/chartist/css/chartist.min.css"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/chartist/css/chartist.min.css')}}">

    {{-- <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">

	{{-- <link href="./vendor/owl-carousel/owl.carousel.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/owl-carousel/owl.carousel.css')}}">

    {{-- <link href="{{ asset('/css/style.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/css/styleAdmin.css')}}">

    <!-- Daterange picker -->
    {{-- <link href="./vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/bootstrap-daterangepicker/daterangepicker.css')}}">
  
    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <link rel="stylesheet" href="{{ asset('../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">  --}}
    <link rel="stylesheet" href="{{ asset('../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"> 

    <!-- Pick date -->
    {{-- <link rel="stylesheet" href="./vendor/pickadate/themes/default.css"> --}}
    {{-- <link rel="stylesheet" href="{{asset('/vendor/pickadate/themes/default.css')}}"> --}}

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/css/toastr.min.css') }}">

    <!-- Datatable -->
    <link rel="stylesheet" href="{{ asset('/vendor/datatables/css/jquery.dataTables.min.css') }}" >

    {{-- Select --}}
    <link rel="stylesheet" href="{{ asset('/vendor/select2/css/select2.min.css') }}" >
	<link rel="stylesheet" href="{{ asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" >

     {{-- Form Step --}}
     <link rel="stylesheet" href="{{ asset('/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css') }}" >

     {{-- Sweet Alert --}}
     <link rel="stylesheet" href="{{ asset('/vendor/sweetalert2/dist/sweetalert2.min.css') }}" >

    <link rel="stylesheet" href="{{asset('/vendor/pickadate/themes/default.date.css')}}">
    {{-- <link rel="stylesheet" href="./vendor/pickadate/themes/default.date.css"> --}}

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .header, .nav-header{
            background-color: rgb(255, 255, 255);
        }
        .deznav{
            /* background-color: #22223d;
            color: white; */
        }
        .nav-text, h5, .nav-label{
            color: rgb(255, 255, 255);
        }
        .form-control{
            border:1px solid #c0bcbc;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #f2f2f2;
            color: #333;
            /* background-color: #f5faff; */
            opacity: 1;
            border: 1px solid #ccc; /* Example border */
        }
        body{
            /* background-color:rgb(172, 172, 172); */
            background-image:url({{url('images/loginBG2.jpg')}});
            background-size: cover; 
            /* background-position: center center; */
            /* height: 100%; */
        }
        .content-wrapper {
            width: 100%;
            margin: auto; center
        } 
        .select2 {
            /* border:1px solid black; */
            border-radius:4px;
            /* height: 40px; */
        }
        .datepicker {
            width: 10px; /* Adjust the width to your desired value */
            overflow: visible;
        }
         input[type="date"] {
            /* Change the color to red */
            /* color: red; */

            /* You can also customize other styles such as border, padding, etc. */
            /* border: 1px solid #000000; */
            padding: 5px;
            border-radius: 4px;
        }
        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            /* background-color: rgba(0, 0, 0, 0.03); */
            /* border-bottom: 1px solid rgba(0, 0, 0, 0.125);  */
        }
        .table thead th {
            border-bottom-width: 1px;
            text-transform: capitalize;
            /* text-transform: uppercase; */
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-color: #EEEEEE;
            color: black;
        }
        @media (max-width: 768px) {
            .footer {
                display: none;
            }
        }
    </style>
	
</head>
<body class="d-flex flex-column min-vh-100">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"> <img src="{{ asset('/images/JataNegara.png') }}" alt="" width="110px" height="100px"> </div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ url("peruntukan/senarai") }}" class="brand-logo">
                {{-- <svg class="logo-abbr" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect class="svg-logo-rect" width="50" height="50" rx="6" fill="#EB8153"/>
					<path class="svg-logo-path"  d="M17.5158 25.8619L19.8088 25.2475L14.8746 11.1774C14.5189 9.84988 15.8701 9.0998 16.8205 9.75055L33.0924 22.2055C33.7045 22.5589 33.8512 24.0717 32.6444 24.3951L30.3514 25.0095L35.2856 39.0796C35.6973 40.1334 34.4431 41.2455 33.3397 40.5064L17.0678 28.0515C16.2057 27.2477 16.5504 26.1205 17.5158 25.8619ZM18.685 14.2955L22.2224 24.6007L29.4633 22.6605L18.685 14.2955ZM31.4751 35.9615L27.8171 25.6886L20.5762 27.6288L31.4751 35.9615Z" fill="white"/>
				</svg> --}}
                <img src="{{ asset('images/JataNegara.png') }}" alt="" width="55" height="50">
                {{-- <p class="brand-title" style="font-size:14px;color:black;margin-left:15px;margin-top:20px;">ePantas</p> --}}
                <p class="brand-title" style="font-size:20px;color:black;">ePantas</p>
                {{-- <svg class="brand-title" width="74" height="22" viewBox="0 0 74 22" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path class="svg-logo-path"  d="M0.784 17.556L10.92 5.152H1.176V1.12H16.436V4.564L6.776 16.968H16.548V21H0.784V17.556ZM25.7399 21.28C24.0785 21.28 22.6599 20.9347 21.4839 20.244C20.3079 19.5533 19.4025 18.6387 18.7679 17.5C18.1519 16.3613 17.8439 15.1293 17.8439 13.804C17.8439 12.3853 18.1519 11.088 18.7679 9.912C19.3839 8.736 20.2799 7.79333 21.4559 7.084C22.6319 6.37467 24.0599 6.02 25.7399 6.02C27.4012 6.02 28.8199 6.37467 29.9959 7.084C31.1719 7.79333 32.0585 8.72667 32.6559 9.884C33.2719 11.0413 33.5799 12.2827 33.5799 13.608C33.5799 14.1493 33.5425 14.6253 33.4679 15.036H22.6039C22.6785 16.0253 23.0332 16.7813 23.6679 17.304C24.3212 17.808 25.0585 18.06 25.8799 18.06C26.5332 18.06 27.1585 17.9013 27.7559 17.584C28.3532 17.2667 28.7639 16.8373 28.9879 16.296L32.7959 17.36C32.2172 18.5173 31.3119 19.46 30.0799 20.188C28.8665 20.916 27.4199 21.28 25.7399 21.28ZM22.4919 12.292H28.8759C28.7825 11.3587 28.4372 10.6213 27.8399 10.08C27.2612 9.52 26.5425 9.24 25.6839 9.24C24.8252 9.24 24.0972 9.52 23.4999 10.08C22.9212 10.64 22.5852 11.3773 22.4919 12.292ZM49.7783 21H45.2983V12.74C45.2983 11.7693 45.1116 11.0693 44.7383 10.64C44.3836 10.192 43.9076 9.968 43.3103 9.968C42.6943 9.968 42.069 10.2107 41.4343 10.696C40.7996 11.1813 40.3516 11.8067 40.0903 12.572V21H35.6103V6.3H39.6423V8.764C40.1836 7.90533 40.949 7.23333 41.9383 6.748C42.9276 6.26267 44.0663 6.02 45.3543 6.02C46.3063 6.02 47.0716 6.19733 47.6503 6.552C48.2476 6.888 48.6956 7.336 48.9943 7.896C49.3116 8.43733 49.517 9.03467 49.6103 9.688C49.7223 10.3413 49.7783 10.976 49.7783 11.592V21ZM52.7548 4.62V0.559999H57.2348V4.62H52.7548ZM52.7548 21V6.3H57.2348V21H52.7548ZM63.4657 6.3L66.0697 10.444L66.3497 10.976L66.6297 10.444L69.2337 6.3H73.8537L68.9257 13.608L73.9657 21H69.3457L66.6017 16.884L66.3497 16.352L66.0977 16.884L63.3537 21H58.7337L63.7737 13.692L58.8457 6.3H63.4657Z" fill="black"/>
				</svg> --}}
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
				
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
							{{-- <div class="input-group search-area right d-lg-inline-flex d-none">
								<input type="text" class="form-control" placeholder="Find something here...">
								<div class="input-group-append">
									<span class="input-group-text">
										<a href="javascript:void(0)">
											<i class="flaticon-381-search-2"></i>
										</a>
									</span>
								</div>
							</div> --}}
                        </div>
                        <ul class="navbar-nav header-right main-notification">
							{{-- <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dz-theme-mode" href="#">
									<i id="icon-light" class="fa fa-sun-o"></i>
                                    <i id="icon-dark" class="fa fa-moon-o"></i>
                                </a>
							</li> --}}
                            <li class="nav-item dropdown header-profile">
                                <div class="dropdown custom-dropdown" style="cursor: pointer;">
                                    <div data-toggle="dropdown">
                                        {{ Auth::user()->id_access }}
                                        <i class="fa fa-angle-down ml-3"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ url('pengguna/butiran/' . Auth::user()->id) }}">
                                            <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            Profil
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                            Log Keluar
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </a>
                                    </div>
                                </div>
                                {{-- <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <!-- <img src="images/profile/pic1.jpg" width="20" alt=""/> -->
									<div class="header-info">
										<p> {{ Auth::user()->id_access }} </p>
										<small>{{ Auth::user()->id_access }}</small>
                                        <div class="dropdown custom-dropdown">
                                            <div data-toggle="dropdown">
                                                <small>{{ Auth::user()->id_access }}</small>
                                                <i class="fa fa-angle-down ml-3"></i>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ url('pengguna/butiran/' . Auth::user()->id) }}">
                                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                    Profil
                                                </a>
                                                <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                                    Log Keluar
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </a>
                                            </div>
                                        </div>
									</div>
                                </a> --}}
                                {{-- <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./app-profile.html" class="dropdown-item ai-icon">
                                    <a href="{{ route('peruntukan.profil') }}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profil </span>
                                    </a>
                                    <a class="dropdown-item ai-icon" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        {{ __('Log Keluar') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div> --}}
                            </li>
                        </ul>
                    </div>
                </nav>
			</div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <div class="sidebar">
            @include('layouts.sidebar')
        </div>
		
		<!--**********************************
            Content body start
        ***********************************-->
        
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                   @yield('content') 
                </div>  
            </section>
            <!-- /.content -->
        </div>

        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->

        {{-- <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://dexignzone.com/" target="_blank">DexignZone</a> 2021</p>
            </div>
        </div> --}}
        {{-- <footer class="footer" style="margin-top:auto;"> --}}
        <footer class="footer">
            <div class="copyright">
                <center><strong>Copyright &copy; 2025 - Kementerian Perpaduan Negara (KPN)</strong>
                <br>
                <!--  All rights reserved.-->
                <font style="font-size:13px; text-align:right">Paparan terbaik menggunakan pelayar internet Google Chrome atau Mozilla Firefox terkini dengan resolusi 1024 x 768 pixels.</font>
                </center>
            </div> 
        </footer>

        <!--**********************************
            Footer end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
 
    <!-- Required vendors -->
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script> 
	{{-- <script src="{{ asset('/vendor/chart.js/Chart.bundle.min.js') }}"></script > --}}

    {{-- JQuery --}}
	{{-- <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script> --}}
	<script src="{{ asset('vendor/jquery/jquery.js')}}"></script>
	
    <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="{{ asset('/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Daterangepicker -->
    <script src="{{ asset('/js/plugins-init/bs-daterange-picker-init.js') }}"></script>

    <!-- pickdate -->
    <script src="{{ asset('/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('/vendor/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('/vendor/pickadate/picker.date.js') }}"></script>

    <!-- Pickdate -->
    <script src="{{ asset('/js/plugins-init/pickadate-init.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('/vendor/toastr/js/toastr.min.js') }}"></script>

    <!-- Datatable -->
    <script src="{{ asset('/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset('/js/plugins-init/datatables.init.js') }}"></script> --}}  
    <script src="{{asset('vendor/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/js/vfs_fonts.js')}}"></script>

    {{-- Select --}}
	<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/js/plugins-init/select2-init.js') }}"></script>

    {{-- Sweet Alert --}}
    <script src="{{ asset('/vendor/sweetalert2/dist/sweetalert2.min.js') }}" defer></script>
    <script src="{{ asset('/js/plugins-init/sweetalert.init.js') }}" defer></script>

    <!-- All init script -->
    <script src="{{ asset('/js/plugins-init/toastr-init.js') }}"></script>

    {{-- <script src="{{ asset('js/custom.min.js') }}"></script> --}}
    <script src="{{asset('js/custom.js')}}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>

    {{-- TESTING SUMMERNOTE --}}

        <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.js"></script>

        {{-- <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script> --}}
        {{-- <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet"> --}}

    {{-- TESTING SUMMERNOTE --}}

    {{-- KEMASKINI URL SET --}}
        <script>
            const baseUrl = '{{ url('/') }}';
        </script>
    {{-- KEMASKINI URL SET --}}

    @yield('script')

    
</body>
</html>