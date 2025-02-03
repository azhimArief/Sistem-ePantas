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
	<meta name="description" content="Sistem eNaziran@KPN" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta property="og:title" content="Sistem eNaziran@KPN" />
	<meta property="og:description" content="Sistem eNaziran@KPN" />
	<meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">
    <title>Cetak-</title>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    
</head>
<body style="background: white;font-family:'poppins', sans-serif;">
    <div class="content-body" style="margin-left: 0rem;">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card" style="box-shadow: 0rem 0rem 0rem 0rem rgba(82, 63, 105, 0.05);margin-bottom:0rem">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            
                            <div class="col-12">
                                <center>
                                    <br>
                                    {{-- <img src="{{ public_path('images/JataNegara.png') }}" alt="User Image"> --}}
                                    <img src="{{asset('/images/JataNegara.png')}}" class="img-circle elevation-2" width="160" height="130" alt="User Image">
                                    <br><br>
                                    {{-- <h3 style="width: 97%;">KERTAS CADANGAN PEROLEHAN {{ strtoupper($maklumats->namaProgram)  }}</h3> --}}
                                    {{-- <h4>KERTAS CADANGAN PEROLEHAN {{ strtoupper($maklumats->namaProgram)  }}</h4> --}}
                                    {{-- <h4>BAHAGIAN KHIDMAT PENGURUSAN </h4> --}}
                                    <hr style="height:1px; width:95% ; background-color: #000; margin: 20px 0;">
                                </center>
                            </div>

                            <div class="col-12">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum suscipit ullam fugit adipisci libero dignissimos harum tempora? Possimus cupiditate ab velit laborum dolores repellendus eaque laudantium, hic fugiat quos nulla facilis temporibus est! Quisquam voluptatibus expedita facere iure consectetur voluptate.

                            </div>

                            <div class="col-12 hide">
                                <dl class="row mb-4">
                                    <dd class="col-sm-11" style="margin-left: 31px; text-align: justify;">
                                        <font color="red">
                                            *Untuk format yang lebih tersusun, klik Cetak, kemudian tukar destinasi ke Save as PDF. Selepas itu, anda boleh mencetak PDF tersebut.
                                        </font>
                                    </dd>
                            </div>
                            

                        </div>

                        <br>

                        <div class="justify-content-center">
                            {{-- <a href="=" id="cetak" class="btn btn-warning float-left btn-sm"><i
                                    class="fa fa-print"></i> |
                                    Cetak
                            </a> --}}
                            {{-- <a href="{{ url('pdf/'.$maklumats->idMaklumatPermohonan) }}" id="" class="btn btn-warning float-right btn-sm"  style="background-color: green;"> --}}
                            <a href="{{ url('pdf/') }}" id="" class="btn btn-warning float-right btn-sm"  style="background-color: green;">
                                <i class="fa fa-print"></i> | Download PDF
                            </a>

                            <button type="button" id="printPageButton" class="btn btn-warning float-right btn-sm" onclick="window.print();" style="background-color: green;">
                                <i class="fa fa-print"></i> | Cetak</button>
                            <button type="button" id="kembaliPageButton"  class="btn btn-secondary float-left btn-sm"
                                onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            // window.print();
        });
    </script>
</body>
</html>
