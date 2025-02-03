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
	<meta name="description" content="Zenix - Crypto Admin Dashboard" />
	<meta property="og:title" content="Zenix - Crypto Admin Dashboard" />
	<meta property="og:description" content="Zenix - Crypto Admin Dashboard" />
	<meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">
    <title>ePantas </title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('icons/font-awesome-5/css/all.css')}}">
    <!-- Title icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/JataNegara.png') }}">
	{{-- <link rel="stylesheet" href="./vendor/chartist/css/chartist.min.css"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/chartist/css/chartist.min.css')}}">

    {{-- <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">

	{{-- <link href="./vendor/owl-carousel/owl.carousel.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/owl-carousel/owl.carousel.css')}}">

    {{-- <link href="./css/style.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">

    <!-- Daterange picker -->
    {{-- <link href="./vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/bootstrap-daterangepicker/daterangepicker.css')}}">

    <!-- Pick date -->
    {{-- <link rel="stylesheet" href="./vendor/pickadate/themes/default.css"> --}}
    <link rel="stylesheet" href="{{asset('/vendor/pickadate/themes/default.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/pickadate/themes/default.date.css')}}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/css/toastr.min.css') }}">

    <!-- Datatable -->
    <link rel="stylesheet" href="{{ asset('/vendor/datatables/css/jquery.dataTables.min.css') }}" >

    {{-- Select --}}
    <link rel="stylesheet" href="{{ asset('/vendor/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" >

    {{-- <link href="{{ asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet"> --}}
    
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .header, .nav-header{
            background-color: rgb(255, 255, 255);
        }
        .deznav{
            background-color: #22223d;
            color: white;
        }
        .nav-text, h5, .nav-label{
            color: white;
        }
        .form-control{
            border:1px solid #000000;
        }
        body{
            font-size:0.875rem;
            background-image:url({{url('images/loginBG2.jpg')}});
            background-size: cover; /* or contain, or a specific size value */
            
            
            /* background-position: center center; */
            /* height: 100%; */
        }
        .content-wrapper {
            width: 70%;
            margin: auto; /* center*/
        }
    </style>
	
</head>
<body>

<div class="content-wrapper">
    <div class="content-body">
        <div class="container-fluid d-flex justify-content-center">
            {{-- <div class="row"> --}}
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="authincation h-100">
                                <div class="container h-100">
                                    {{-- <div class="row justify-content-center h-100 align-items-center"> --}}
                                        {{-- <div class="col-md-8"> --}}
                                            <div class="form-input-content text-center error-page">
                                                {{-- <h1 class="error-text font-weight-bold">404</h1> --}}
                                                <h4><i class="fa fa-exclamation-triangle text-warning"></i> Session Expired.</h4>
                                                <p>Sila login semula.</p>
                                                <div>
                                                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        {{ __('Log In') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
        </div>       
    </div>
</div>
    
        
             

    

    

    <!--**********************************
        Scripts
    ***********************************-->
    <script>
 
    </script>
    <!-- Required vendors -->
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script> 
	<script src="{{ asset('/vendor/chart.js/Chart.bundle.min.js') }}"></script>
	
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

    <!-- All init script -->
    <script src="{{ asset('/js/plugins-init/toastr-init.js') }}"></script>

    <!-- Datatable -->
    <script src="{{ asset('/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/plugins-init/datatables.init.js') }}"></script>
    
    {{-- Select --}}
	<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/js/plugins-init/select2-init.js') }}"></script>

    <script src="{{ asset('/js/custom.min.js') }}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>
    
</body>
</html>