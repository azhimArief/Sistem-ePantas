
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
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/JataNegara.png') }}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-8">
                    <div class="form-input-content text-center error-page">
                        <h1 class="error-text font-weight-bold">404</h1>
                        <h4><i class="fa fa-exclamation-triangle text-warning"></i> Halaman tidak dijumpai!</h4>
                        <p>Sila segar semula laman ataupun tekan butang 'Kembali' di bawah dan cuba lagi.</p>
						<div>
                            <a class="btn btn-primary" href="{{ url('/') }}">Kembali</a>
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
</body>
</html>