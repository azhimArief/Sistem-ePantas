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
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/JataNegara.png') }} defer">
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

    {{-- <link href="{{ asset('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet"> --}}
    
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .form-control{
            border:1px solid #c0bcbc;
        }   
    </style>
	
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        {{-- <div class="sidebar">
            @include('layouts.sidebar')
        </div> --}}
		
		<!--**********************************
            Content body start
        ***********************************-->
        
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                @yield('content')
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
        {{-- <footer class="footer">
            <div class="copyright">
                <center><strong>Copyright &copy; 2023 - Kementerian Perpaduan Negara (KPN)</strong>
                <br>
                <!--  All rights reserved.-->
                <font style="font-size:13px; text-align:right">Paparan terbaik menggunakan pelayar internet Google Chrome atau Mozilla Firefox terkini dengan resolusi 1024 x 768 pixels.</font>
                </center>
            </div> 
        </footer> --}}

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
    <script>
 
    </script>
    <!-- Required vendors -->
    <script src="{{ asset('/vendor/global/global.min.js') }}"></script> 
	<script src="{{ asset('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('/vendor/chart.js/Chart.bundle.min.js') }}"></script>

    <script src="{{ asset('/js/custom.js') }}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>

    {{-- JQuery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
	
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

    <script src="{{ asset('/js/custom.min.js') }}"></script>
	<script src="{{ asset('/js/deznav-init.js') }}"></script>
    
</body>
</html>