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
    <title>Cetak-{{ $maklumats->namaProgram }}</title>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- <style type="text/css" media="print">
        @page {
            size: portrait;
            /* auto is the initial value */
            margin: 0px 0px 0px 0px;
            /* this affects the margin in the printer settings  atas, kanan, bawah, kiri*/
        }

        @page lcp {
            size: landscape;
            /* auto is the initial value */
            margin: 20px 20px 20px 20px;
            /* this affects the margin in the printer settings  atas, kanan, bawah, kiri*/
        }
        @page {
            margin-top: 14.1mm; 
            /* Adjust the margin-top value as needed */
            /* margin: 120px 50px 80px 50px; */
        }

        /* @media print { */
            .nextPage {
                /* margin-top: 200px; */
                top: 10mm;
                /* page-break-after: always; */
                page-break-inside: avoid;
            }

            .pageBreak {
                page-break-before: always; 
                page-break-after: always;
            }

            body {
                font-family: "Arial", sans-serif;
                font-size: 12pt;
                page-break-inside: avoid;
            }
            .content-body {
                margin-bottom: 20mm;
                /* page-break-inside: avoid; */
            }
            .hide {
                display: none;
            }
        /* } */

        @media print {
            body {-webkit-print-color-adjust: exact;}
        }

        div.landscape-content {
            page: lcp;
        }
        body {
            font-family: "Arial", sans-serif;
            font-size: 12pt;
            /* font-size: 14px; */
            page-break-inside: avoid;
            margin-left: 25.4mm;
            margin-right: 25.4mm;
            margin-top: 25.4mm;
            margin-bottom: 25.4mm;

        }
        .content-body {
            margin-left: 25.4mm;
            margin-right: 25.4mm;
            margin-top: 25.4mm;
            margin-bottom: 25.4mm;
            page-break-inside: avoid;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            /* border: 1px solid black; */
            /* border-top: 1px solid black; */
            /* border-bottom: 1px solid black; */
            /* border-collapse: collapse; */
        }
        th,
        tr {
            padding: 10px;
            /* border: 0px transparent; */
            /* border-left: 1px solid black; */
            /* border-right: 1px solid black; */
            /* border-bottom: 1px solid black;
      border-top: 1px solid black; */

        }

        th {
            padding: 10px;
            /* border-top: 1px solid black; */
            /* border-left: 1px solid black; */
            /* border-right: 1px solid black; */
            border-bottom: 1px transparent;
            border-collapse: collapse;

        }

        .bottom-line {
            border-bottom: 1px solid;
        }

        .right-line {
            border-right: 1px solid;
        }


        .top-line {
            border-top: 1px solid;
        }

        .left-col {
            width: 40%;
        }

        .right-col {
            width: 60%;
        }

        .sign-row {
            height: 300px;
        }

        h3 {
            font-size: 14pt;
            /* color: blue !important; */
        }

        .slip {
            font-size: 20px;
            font-weight: bold;
        }

        .title, dt {
            font-family: "Arial", sans-serif;
            font-size: 12pt;
            /* font-size: 18px; */
            font-weight: bold;
            /* font-color: blue; */
        }

        dd {
            font-family: "Arial", sans-serif;
            font-size: 12pt;
            /* font-size: 14px; */
            /* font-weight: bold; */
            /* font-color: blue; */
        }

        .capitalize {
            text-transform: capitalize;
        }
        .uppercase {
            text-transform: uppercase;
        }

        .center {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        #printPageButton, #kembaliPageButton {
            display: none;
        }

        .footer, .header, .sidebar, .nav-header {
            display: none;
        }

        .upn {
          background-image:url("{{ asset('images/JataNegara.png') }}");
          background-repeat:no-repeat;
          width:700px;
          height:342px;
          position:absolute;
       }
    </style> --}}
    <style>
        /* General print settings */
        /* @page {
            margin-top: 19.1mm;
            margin-bottom: 12.1mm;
            line-height: 1.5;
        } */
    
        @media print {
            /* Hide footer on the first page */
            /* #footer {
                display: none;
            } */
            
            /* Show footer from the second page onward */
            body {
                counter-reset: page;
            }
    
            .footer-visible {
                display: block !important;
            }
        }
    
        /* Footer styling */
        #footer {
            position: fixed;
            left: 0;
            right: 0; /* Center the footer horizontally */
            bottom: -30px;
            text-align: center; /* Align the text to the center */
            font-family: "Arial", sans-serif;   
            display: block; /* Hidden by default */
        }
    
        /* Page counter for the footer */
        #footer .page:after {
            content: counter(page);
        }
    
        /* Header styling */
        /* .header {
            position: absolute;
            top: 0;
            right: 0;
            font-family: "Arial", sans-serif;   
            font-size: 12pt;
        } */
        header {
                position: fixed;
                top: -30px;
                left: 40px;
                right: 0;
                height: 20px;
                width: 93.3%;
                text-align: left;
                font-size: 9pt;
                font-weight: bold;
                display: block;
        }
        body {
                margin-top: 20px; /* Push content below the header */
            }
        td p {
            margin-top: 0;  
            /* margin-bottom: 0;  */
        }

        footer {
                position: fixed;
                bottom: -50px;
                left: 55px;
                right: 0;
                height: 30px;
                font-size: 9pt;
                text-align: left;
                display: block;
            }
            
    </style>

</head>
<body style="background: white;font-family:'poppins', sans-serif;">
    
    {{-- <div class="header">
        <strong class="rujukan_fail">{{ $maklumats->rujukan_fail }}</strong>
    </div> --}}
    <header>
        {{ $maklumats->namaProgram }}
    </header>

    <div id="footer" class="footer">
        {{-- PAGE NUMBERING --}}
        <p class="page"></p>
    </div> 

    <footer>
        Ruj. Fail: {{ $maklumats->rujukan_fail }} 
    </footer>

    {{-- <div class="content-body" style="margin-left: 14.1mm; margin-right: 6.1mm; margin-bottom: 14.1mm;" > --}}
    <div class="content-body" style="margin-left: 10.1mm; margin-right: 10.1mm; margin-bottom: 0mm; " >
        <div class="container-fluid">
            <div class="col-12">
                <div class="card" style="box-shadow: 0rem 0rem 0rem 0rem rgba(82, 63, 105, 0.05);margin-bottom:0rem">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            
                            <div class="col-12">
                                <center>
                                    <br>
                                    {{-- <img src="{{ public_path('images/JataNegara.png') }}" alt="User Image"> --}}
                                    {{-- <img src="{{ asset('/images/JataNegara.png')}}" width="160" height="130" alt="User Image"> --}}
                                    {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($image))) }}" width="160" height="130" /> --}}
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($image))) }}" width="90" height="80" />
                                    <br>
                                    @if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)' )
                                        <h4>
                                            MINIT BEBAS
                                            <br>
                                            {{ strtoupper($maklumats->id_bahagian ?? '') }}
                                            <br>
                                            {{ strtoupper(\App\Agensi::find($maklumats->id_agensi)->agensi ?? '') }}
                                        </h4>
                                    @else
                                        <h4>
                                            MINIT BEBAS
                                            <br>
                                            {{ strtoupper(\App\PLkpBahagian::find($maklumats->id_bahagian)->bahagian ?? '') }}
                                            <br>
                                            KEMENTERIAN PERPADUAN NEGARA
                                        </h4>
                                    @endif
                                </center>

                                <div style="text-align: right; margin-top: 20px; margin-bottom: 20px;">
                                    <table style="float: right; text-align: left;">
                                        <tr>
                                            <td>Ruj. Fail</td>
                                            <td>: {{ $maklumats->rujukan_fail }} &nbsp;&nbsp;&nbsp;</td>
                                            {{-- <td>: {{ $ruj_fail->rujukan_fail ?? '' }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td>Tarikh</td>
                                            {{-- <td>: {{ \Carbon\Carbon::parse($maklumats->tkhCadangMula)->translatedFormat('d F Y') }}</td> --}}
                                            {{-- <td>: {{ \Carbon\Carbon::parse($maklumats->createdAt)->translatedFormat('d F Y') }}</td> --}}
                                            @if($tindakans->where('id_status', 1)->isNotEmpty())
                                                <!-- Display the first tindakan with id_status = 1 -->
                                                @php
                                                    $tindakanWithStatus1 = $tindakans->where('id_status', 1)->first();
                                                @endphp
                                                <td>: {{ \Carbon\Carbon::parse($tindakanWithStatus1->CreatedAt)->translatedFormat('d F Y') }}</td> <!-- Bila di hantar -->
                                            @else
                                                <!-- Display null if no tindakan with id_status = 1 -->
                                                {{-- <td>: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td> --}}
                                                <td>: {{ \Carbon\Carbon::parse($maklumats->createdAt)->translatedFormat('d F Y') }}</td>
                                            @endif
                                        </tr>
                                    </table>
                                    <div style="clear: both;"></div> <!-- Ensures no floating issues -->
                                </div>

                                <div style="text-align: justify; font-weight: bold;">
                                    {{ strtoupper($maklumats->namaProgram) }}
                                    <br><br>
                                </div>
                            </div>

                            {{-- <div class="col-12" style="margin-left: 4.1mm; margin-right: 4.1mm;"> --}}
                            {{-- <div class="col-12" style="page-break-after: always;"> --}}
                            <div class="col-12">
                            
                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">1. &nbsp;&nbsp;&nbsp;&nbsp;TUJUAN </dt>
                                </dl>
                                <dl class="row mb-4">
                                    {{-- <dd class="col-sm-11" style="text-align: justify;">{!! $maklumats->tujuanProgram !!}</dd> --}}
                                    @foreach ($tujuans as $tujuan)
                                        <table style="border-collapse: collapse; width: 96%; margin-left: 31px;">
                                            <tr>
                                                <td style="padding: 8px; text-align: left; vertical-align: top; font-family: Arial, sans-serif; font-size: 12pt; ">1.{{ $loop->iteration }}</td>
                                                {{-- <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt;">{{ strip_tags($tujuan->tujuan) }}</td> --}}
                                                <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt; ">
                                                    {{-- {!! $tujuan->tujuan !!} --}}
                                                    <div style="display: inline;">
                                                        {{-- {!! str_replace(['<p>', '</p>'], '', $tujuan->tujuan) !!} --}}
                                                        {!! $tujuan->tujuan !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </dl>

                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">2. &nbsp;&nbsp;&nbsp;&nbsp;LATAR BELAKANG </dt>
                                </dl>
                                <dl class="row mb-4">
                                    {{-- <dd class="col-sm-11" style="text-align: justify;">{!! $maklumats->tujuanProgram !!}</dd> --}}
                                    @foreach ($latars as $latar)
                                        <table style="border-collapse: collapse; width: 96%; margin-left: 31px;">
                                            <tr>
                                                <td style="padding: 8px; text-align: left; vertical-align: top; font-family: Arial, sans-serif; font-size: 12pt; ">2.{{ $loop->iteration }}</td>
                                                {{-- <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt;">{{ strip_tags($tujuan->tujuan) }}</td> --}}
                                                <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt; ">
                                                    {{-- {!! $tujuan->tujuan !!} --}}
                                                    <div style="display: inline;">
                                                        {{-- {!! str_replace(['<p>', '</p>'], '', $tujuan->tujuan) !!} --}}
                                                        {!! $latar->latarBelakang !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </dl>

                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">3. &nbsp;&nbsp;&nbsp;&nbsp;DASAR SEMASA </dt>
                                </dl>
                                <dl class="row mb-4">
                                    {{-- <dd class="col-sm-11" style="text-align: justify;">{!! $maklumats->tujuanProgram !!}</dd> --}}
                                    @foreach ($dasars as $dasar)
                                        <table style="border-collapse: collapse; width: 96%; margin-left: 31px;">
                                            <tr>
                                                <td style="padding: 8px; text-align: left; vertical-align: top; font-family: Arial, sans-serif; font-size: 12pt; ">3.{{ $loop->iteration }}</td>
                                                {{-- <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt;">{{ strip_tags($tujuan->tujuan) }}</td> --}}
                                                <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt; ">
                                                    {{-- {!! $tujuan->tujuan !!} --}}
                                                    <div style="display: inline;">
                                                        {{-- {!! str_replace(['<p>', '</p>'], '', $tujuan->tujuan) !!} --}}
                                                        {!! $dasar->dasarSemasa !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </dl>

                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">4. &nbsp;&nbsp;&nbsp;&nbsp;JUSTIFIKASI PERMOHONAN </dt>
                                </dl>
                                <dl class="row mb-4">
                                    {{-- <dd class="col-sm-11" style="text-align: justify;">{!! $maklumats->tujuanProgram !!}</dd> --}}
                                    @foreach ($justifikasis as $justifikasi)
                                        <table style="border-collapse: collapse; width: 96%; margin-left: 31px;">
                                            <tr>
                                                <td style="padding: 8px; text-align: left; vertical-align: top; font-family: Arial, sans-serif; font-size: 12pt; ">4.{{ $loop->iteration }}</td>
                                                {{-- <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt;">{{ strip_tags($tujuan->tujuan) }}</td> --}}
                                                <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt; ">
                                                    {{-- {!! $tujuan->tujuan !!} --}}
                                                    <div style="display: inline;">
                                                        {{-- {!! str_replace(['<p>', '</p>'], '', $tujuan->tujuan) !!} --}}
                                                        {!! $justifikasi->justifikasiPermohonan !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </dl>

                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">5. &nbsp;&nbsp;&nbsp;&nbsp;ULASAN BAHAGIAN </dt>
                                </dl>
                                <dl class="row mb-4">
                                    {{-- <dd class="col-sm-11" style="text-align: justify;">{!! $maklumats->tujuanProgram !!}</dd> --}}
                                    @foreach ($ulasans as $ulasan)
                                        <table style="border-collapse: collapse; width: 96%; margin-left: 31px;">
                                            <tr>
                                                <td style="padding: 8px; text-align: left; vertical-align: top; font-family: Arial, sans-serif; font-size: 12pt; ">5.{{ $loop->iteration }}</td>
                                                {{-- <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt;">{{ strip_tags($tujuan->tujuan) }}</td> --}}
                                                <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt; ">
                                                    {{-- {!! $tujuan->tujuan !!} --}}
                                                    <div style="display: inline;">
                                                        {{-- {!! str_replace(['<p>', '</p>'], '', $tujuan->tujuan) !!} --}}
                                                        {!! $ulasan->ulasanBahagian !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </dl>

                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">6. &nbsp;&nbsp;&nbsp;&nbsp;IMPLIKASI KEWANGAN </dt>
                                </dl>
                                <dl class="row mb-4">
                                    <table style="width: 92%; margin-left: 9.1mm; margin-right: 12.1mm; border-collapse: collapse;">
                                        <tr>
                                            <th style="border: 1px solid black; padding: 10px;">BIL</th>
                                            <th style="border: 1px solid black; padding: 10px;">PERKARA</th>
                                            <th style="border: 1px solid black; padding: 10px;">OA/OS</th>
                                            <th style="border: 1px solid black; padding: 10px;">UNIT</th>
                                            <th style="border: 1px solid black; padding: 10px;">ANGGARAN KOS (RM)</th>
                                        </tr>
                                        <?php
                                            $total = 0;
                                        ?>
                                        @foreach ($votByAdmins as $vot)
                                        {{-- @foreach ($data['maklumats']->votByAdmins as $vot) --}}
                                            <tr>
                                                <td style="border: 1px solid black; padding: 10px;">{{ $loop->iteration }}</td>
                                                <td style="border: 1px solid black; padding: 10px;">
                                                    @if ( $vot->perkara === null || $vot->perkara === "" )
                                                        {{ $vot->keterangan }}
                                                    @else
                                                        {{ ($vot->perkara!='') ? \App\LkpPerkara::find($vot->perkara)->perkara : '' }}
                                                    @endif 
                                                </td>
                                                <td style="border: 1px solid black; padding: 10px;">
                                                    {{ ($vot->objekAm!='') ? \App\LkpOA::find($vot->objekAm)->oa : '' }} / {{ ($vot->objekSebagai!='') ? \App\LkpOS::find($vot->objekSebagai)->os : '' }}
                                                </td>
                                                <td style="border: 1px solid black; padding: 10px;"><center> @if( $vot->unit != 0 ) {{ $vot->unit }} @else - @endif </center></td>
                                                <td style="border: 1px solid black; padding: 10px;"> <center>{{ number_format($vot->kos, 2) }}</center> </td>
                                                <?php
                                                    $total = $total + $vot->kos;
                                                ?>
                                            </tr>
                                            @if ($loop->last) <!-- Check if it's the last iteration -->
                                                <tr>
                                                    <td colspan="4" style="border: 1px solid black; padding: 10px; font-weight: bold;">JUMLAH KESELURUHAN</td>
                                                    <td colspan="1" style="border: 1px solid black; padding: 10px; font-weight: bold;">RM {{ number_format($total, 2) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </dl>

                                <dl class="row mb-4">
                                    @if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)')
                                        <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">7. &nbsp;&nbsp;&nbsp;&nbsp;SYOR JABATAN </dt>
                                    @else
                                        <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">7. &nbsp;&nbsp;&nbsp;&nbsp;SYOR BAHAGIAN </dt>
                                    @endif
                                </dl>
                                <dl class="row mb-4">
                                    <table style="border-collapse: collapse; width: 96%; margin-left: 31px;">
                                        <tr>
                                            <td style="padding: 8px; text-align: justify; font-family: Arial, sans-serif; font-size: 12pt; ">
                                                <div style="display: inline;">
                                                    @if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)')
                                                        {{ $pemohon->namaBahagian }}, {{ $pemohon->agensi }} 
                                                    @else
                                                        {{ $pemohon->namaBahagian }}
                                                    @endif
                                                    mengesyorkan permohonan ini untuk pertimbangan seterusnya.
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </dl>
                                
                            </div>

                            <br>

                            {{-- <br>  --}}
                            {{-- <p>Sekian, terima kasih.</p> --}}

                            {{-- <center>
                                <h4>
                                    "MALAYSIA MADANI"
                                    <br>
                                    "BERKHIDMAT UNTUK NEGARA"
                                </h4>
                            </center> --}}
                            
                            <div class="col-12 nextPage" style=" margin-right: 4.1mm; page-break-after: always; page-break-inside: avoid;">
                                <p>Sekian, terima kasih.</p>

                                <center>
                                    <h4>
                                        "MALAYSIA MADANI"
                                        <br>
                                        "BERKHIDMAT UNTUK NEGARA"
                                    </h4>
                                </center>

                                <dl class="row mb-4" style="text-align: left; width: auto; position: absolute; right: 5;">                                    <br>
                                    <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pemohon->namaPemohon) }})</dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->jawatanPemohon }}</dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->namaBahagian }}</dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->agensi }}</dd>
                                    @if($tindakans->where('id_status', 1)->isNotEmpty())
                                        <!-- Display the first tindakan with id_status = 1 -->
                                        @php
                                            $tindakanWithStatus1 = $tindakans->where('id_status', 1)->first();
                                        @endphp
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh : {{ \Carbon\Carbon::parse($tindakanWithStatus1->CreatedAt)->translatedFormat('d F Y') }}</dd> <!-- Bila di hantar -->
                                    @else
                                        <!-- Display null if no tindakan with id_status = 1 -->
                                        {{-- <dd class="col-sm-11"  style="text-align: justify;">Tarikh : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</dd> --}}
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh : {{ Carbon\Carbon::parse($maklumats->createdAt)->format('d F Y') }}</dd>
                                    @endif
                                </dl>

                                {{-- @if ( $pengesah ) --}}
                                @if ( $tindakanPengesah )
                                    @if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)')
                                        <dl class="row mb-4" style="text-align: left; width: auto; ">
                                            <br>
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <br><br><br><br><br><br>
                                        </dl>

                                        <p >Syor di para 7 <b>DISOKONG</b></p>
                                        <p style="text-align: justify;">Ulasan: <b>{{ $tindakanPengesah->Ulasan }}</b></p>
                                        <dl class="row mb-4" style="text-align: left; width: auto; position: absolute; right: 0;">
                                            <br>
                                            {{-- <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pengesah->nama) }})</dd> --}}
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pengesah->nama) }})</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->jawatan }}</dd>
                                            {{-- <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->bahagianPengesah }}</dd> --}}
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->agensi }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">Tarikh : {{ Carbon\Carbon::parse($tindakanPengesah->CreatedAt)->format('d F Y') }}</dd>
                                        </dl>

                                        <dl class="row mb-4" style="text-align: left; width: auto; ">
                                            <br>
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <br><br><br><br><br><br>
                                        </dl>
                                    @else
                                        <dl class="row mb-4" style="text-align: left; width: auto; ">
                                            <br>
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <br><br><br><br><br><br>
                                        </dl>

                                        <p >Syor di para 7 <b>DISOKONG</b></p>
                                        <p style="text-align: justify;">Ulasan: <b>{{ $tindakanPengesah->Ulasan }}</b></p>
                                        <dl class="row mb-4" style="float: right; text-align: left; width: auto; position: absolute; right: 40;">
                                            <br>
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pengesah->name) }})</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->jawatan }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ ($pengesah->bahagian_id!='') ? \App\PLkpBahagian::find($pengesah->bahagian_id)->bahagian : '' }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ ($pengesah->agensi_id!='') ? \App\Agensi::find($pengesah->agensi_id)->agensi : '' }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">Tarikh : {{ Carbon\Carbon::parse($tindakanPengesah->CreatedAt)->format('d F Y') }}</dd>
                                        </dl>

                                        <dl class="row mb-4" style="text-align: left; width: auto; ">
                                            <br>
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <dd class="col-sm-11"  style="text-align: justify;"></dd>
                                            <br><br><br><br><br><br>
                                        </dl>
                                    @endif
                                @else
                                    <br><br><br><br><br>
                                @endif

                                @if ( $tindakanLulus )
                                    <p>
                                        Syor di para 7 
                                        @if ($tindakanLulus->id_status == 9)
                                            <b>DILULUSKAN</b>
                                        @else
                                            <b>TIDAK DILULUSKAN</b>
                                        @endif
                                        
                                    </p>
                                    <p style="text-align: justify;">Ulasan: <b>{{ $tindakanLulus->Ulasan }}</b></p>
                                    <dl class="row mb-4" style="text-align: left; width: auto; position: absolute; right: 0;">
                                        <br>
                                        @php
                                            $pelulus = optional(\App\User::where('id', $tindakanLulus->UpdatedBy)->first());
                                        @endphp
                                        <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pelulus->nama) }})</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ $pelulus->jawatan }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ $pelulus->bahagian }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ $pelulus->agensi }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh : {{ Carbon\Carbon::parse($tindakanLulus->CreatedAt)->format('d F Y') }}</dd>
                                    </dl>
                                @else
                                    <br><br><br><br><br>
                                @endif

                            </div>

                            {{-- KEPUTUSAN SUB BKP DISOKONG --}}
                            {{-- <br> --}}
                            <div class="col-12 pageBreak" style="margin-left: 4.1mm; margin-right: 4.1mm;">

                                @foreach ($tindakans as $tindakan)
                                    @if ($tindakan->id_status == 13)
                                        <?php 
                                            $peruntukan = 1;
                                        ?>
                                    @elseif ($tindakan->id_status == 14)
                                        <?php 
                                            $tiadaperuntukan = 1;
                                        ?>
                                    @elseif ($tindakan->id_status == 15)
                                        <?php 
                                            $sokong = 1;
                                        ?>
                                    @elseif ($tindakan->id_status == 17)
                                        <?php 
                                            $diperakui = 1; //disyorkan SUBK
                                        ?>
                                    @elseif ($tindakan->id_status == 18)
                                        <?php 
                                            $tidakDiperakui = 1; //tidak disyorkan SUBK
                                        ?>
                                    @elseif ($tindakan->id_status == 9)
                                        <?php 
                                            $lulus = 1;
                                            $user = \App\User::find($tindakan->UpdatedBy);
                                            $namaPelulus = $user ? $user->nama : '';
                                            $jawatan = $user ? $user->id_access : '';
                                            // $namaPelulus = $tindakan->UpdatedBy \App\User::find($tindakan->UpdatedBy)->nama : '';
                                            // $jawatan = $tindakan->UpdatedBy \App\User::find($tindakan->UpdatedBy)->id_access : '';
                                        ?>
                                    @else
                                    @endif
                                @endforeach

                                {{-- ULASAN KEWANGAN --}}
                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase"  style="text-align: center; font-weight: bold; font-size: 14pt;"> <u>ULASAN KEWANGAN</u></dt> <br>
                                    <dd class="col-sm-11" style="text-align: justify; font-weight: bold;">
                                        Peruntukan: 
                                        &nbsp;
                                        @if (isset($peruntukan) && $peruntukan == 1) 
                                            Ada 
                                        @elseif ( isset($peruntukan) && $tiadaperuntukan == 1) 
                                            Tiada 
                                        @elseif ( !isset($peruntukan) || $peruntukan != 1) 
                                            - 
                                        @endif
                                        {{-- <input type="checkbox" name="" id="" @if (isset($peruntukan) && $peruntukan == 1) checked @endif> Ada --}}
                                        {{-- <input type="checkbox" name="" id="" @if (!isset($peruntukan) || $peruntukan != 1) checked @endif> Tiada --}}
                                        {{-- <input type="checkbox" name="" id="" @if ($peruntukan != 1) checked @endif> Tiada  --}}
                                        
                                        <br><br>
                                        Ulasan: 
                                    </dd>
                                    <dd class="col-sm-11" style="text-align: justify;">
                                        @foreach ($tindakans->whereIn('id_status', [13, 14]) as $tindakan)
                                            {{ $tindakan->Ulasan }}
                                        @break
                                        @endforeach
                                        <br><br>
                                    </dd>
                                    {{-- <hr> --}}

                                </dl>
                                {{-- ULASAN KEWANGAN --}}

                                <dl class="row mb-4">
                                    {{-- <dt class="col-sm-6 uppercase"  style="text-align: justify; font-weight: bold;">PEROLEHAN {{ $maklumats->namaProgram }}</dt> --}}
                                    {{-- <dt class="col-sm-6 uppercase"  style="text-align: justify; font-weight: bold;">KEPUTUSAN PEROLEHAN</dt> --}}
                                    <dt class="col-sm-6 uppercase"  style="text-align: center; font-weight: bold; font-size: 14pt;"> <u>KEPUTUSAN PERMOHONAN</u></dt> <br>
                                    <dt class="col-sm-6 uppercase"  style="text-align: center; font-weight: bold;">{{ strtoupper($maklumats->namaProgram) }}</dt>
                                    <br>
                                    <hr>
                                </dl>
                               
                                <dl class="row mb-4">
                                    <dd class="col-sm-11" style="text-align: justify; font-weight: bold;">
                                        {{-- Keputusan SUB BKP:  --}}
                                        Keputusan SUB BKEP: 
                                        &nbsp;
                                        {{-- @if (isset($sokong) && $sokong == 1) Disokong @elseif (!isset($sokong) || $sokong != 1) Tidak Disokong @endif --}}
                                        @if ( isset($tindakanSokong) )
                                            @if ( $tindakanSokong->id_status == 15)
                                                Disokong
                                            @else
                                                Tidak Disokong
                                            @endif
                                        @else
                                            -
                                        @endif
                                        <br>
                                        Kos Disokong: 
                                        &nbsp;
                                        @if (isset($tindakanSokong->Kos)) RM{{ number_format($tindakanSokong->Kos, 2) }} @else - @endif
                                        {{-- <input type="checkbox" class="form-control" name="" id="" @if (isset($sokong) && $sokong == 1) checked @endif> Disokong </input> --}}
                                        {{-- <input type="checkbox" name="" id="" @if (!isset($sokong) || $sokong != 1) checked @endif> Tidak disokong </input> --}}
                                        
                                        <br><br>
                                        Ulasan SUB BKEP: 
                                    </dd>
                                    <dd class="col-sm-11" style="text-align: justify;">
                                        @foreach ($tindakans->whereIn('id_status', [15, 16]) as $tindakan)
                                            {{ $tindakan->Ulasan }}
                                        @break
                                        @endforeach
                                        {{-- <br><br><br> --}}
                                    </dd>
                                </dl>
                                <dl class="row mb-4">
                                    <br>
                                    @foreach ($tindakans->whereIn('id_status', [15, 16]) as $tindakan)
                                        <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ $tindakan->UpdatedBy ? \App\User::find($tindakan->UpdatedBy)->nama : '' }})</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Setiausaha Bahagian Kewangan dan Pembangunan</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Kementerian Perpaduan Negara</dd>
                                        <br>
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh: {{ Carbon\Carbon::parse($tindakan->UpdatedAt)->format('d.m.Y') }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Rujukan: {{ $maklumats->rujukan_fail }}</dd>
                                        @break
                                    @endforeach

                                    {{-- <br>
                                    <dd class="col-sm-11"  style="text-align: justify;">Tarikh: {{ Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->format('d.m.Y') }}</dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">Rujukan: {{ $maklumats->kod_permohonan }}</dd> --}}
                                </dl>
                            </div>

                            {{-- KEPUTUSAN SUBK P DIPERAKUI/DISYORKAN --}}
                            {{-- <br> --}}
                            @if ( isset($diperakui) || isset($tidakDiperakui))
                                <div class="col-12 pageBreak" style="margin-left: 4.1mm; margin-right: 4.1mm;">
                                    <dl class="row mb-4">
                                        <hr>
                                        {{-- <dt class="col-sm-6 uppercase"  style="text-align: center; font-weight: bold;">PEROLEHAN {{ $maklumats->namaProgram }}</dt> --}}
                                    </dl>
                                    <dl class="row mb-4">
                                        <dd class="col-sm-11" style="text-align: justify; font-weight: bold;">
                                            Keputusan SUBK (P):  
                                            &nbsp;
                                            @if (isset($diperakui) && $diperakui == 1) Disyorkan @elseif (!isset($diperakui) || $diperakui != 1) Tidak Disyorkan @endif
                                            <br>
                                            Kos Disyorkan: 
                                            &nbsp;
                                            @if (isset($tindakanPeraku->Kos)) RM{{ number_format($tindakanPeraku->Kos, 2) }} @else - @endif
                                            {{-- <input type="checkbox" name="" id="" @if (isset($diperakui) && $diperakui == 1) checked @endif> Disyorkan --}}
                                            {{-- <input type="checkbox" name="" id="" @if (!isset($diperakui) || $diperakui != 1) checked @endif> Tidak Disyorkan --}}
                                            
                                            <br><br>
                                            Ulasan SUBK (P): 
                                        </dd>
                                        <dd class="col-sm-11" style="text-align: justify;">
                                            @foreach ($tindakans->whereIn('id_status', [17, 18]) as $tindakan)
                                                {{ $tindakan->Ulasan }} 
                                            @break
                                            @endforeach
                                            {{-- <br><br><br> --}}
                                        </dd>
                                    </dl>
                                    <dl class="row mb-4">
                                        <br>
                                        @foreach ($tindakans->where('id_status', 17) as $tindakan)
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ $tindakan->UpdatedBy ? \App\User::find($tindakan->UpdatedBy)->nama : '' }})</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">Setiausaha Bahagian Kanan (Pengurusan)</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">Kementerian Perpaduan Negara</dd>
                                        @break
                                        @endforeach

                                        <br>
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh: {{ Carbon\Carbon::parse($tindakan->UpdatedAt)->format('d.m.Y') }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Rujukan: {{ $maklumats->rujukan_fail }}</dd>
                                    </dl>
                                </div>
                            @else
                            @endif

                            {{-- KEPUTUSAN SUBK P LULUS OR KSU LULUS--}}
                            {{-- <br> --}}
                            @if ( isset($lulus) )
                                <div class="col-12 pageBreak" style="margin-left: 4.1mm; margin-right: 4.1mm; page-break-before: always;">
                                    {{-- @if ( $jawatan == 'Pentadbir-SUB Kanan Pengurusan')
                                        <dl class="row mb-4">
                                            <hr>
                                            <dt class="col-sm-6 uppercase"  style="text-align: center; font-weight: bold;">PEROLEHAN {{ $maklumats->namaProgram }}</dt>
                                        </dl>
                                    @endif --}}

                                    <dl class="row mb-4">
                                        <hr>
                                        {{-- <dt class="col-sm-6 uppercase"  style="text-align: center; font-weight: bold;">PEROLEHAN {{ $maklumats->namaProgram }}</dt> --}}
                                    </dl>

                                    <dl class="row mb-4">
                                        <dd class="col-sm-11" style="text-align: justify; font-weight: bold;">
                                            @if ( $jawatan == 'Pentadbir-SUB Kanan Pengurusan')
                                                Keputusan SUBK (P):
                                            @elseif ( $jawatan == 'Pentadbir-KSU')
                                                Keputusan KSU:
                                            @endif
                                            &nbsp;
                                            @if (isset($lulus) && $lulus == 1) Lulus @elseif (!isset($lulus) || $lulus != 1) Tidak Diluluskan @endif
                                            <br>
                                            Kos Diluluskan: 
                                            &nbsp;
                                            @if (isset($tindakanLulus->Kos)) RM{{ number_format($tindakanLulus->Kos, 2) }} @else - @endif
                                            {{-- <input type="checkbox" name="" id="" @if (isset($lulus) && $lulus == 1) checked @endif> Lulus --}}
                                            {{-- <input type="checkbox" name="" id="" @if (!isset($lulus) || $lulus != 1) checked @endif> Tidak diluluskan --}}
                                            
                                            <br><br>
                                            @if ( $jawatan == 'Pentadbir-SUB Kanan Pengurusan')
                                                Ulasan SUBK (P):
                                            @elseif ( $jawatan == 'Pentadbir-KSU')
                                                Ulasan KSU:
                                            @endif
                                             
                                        </dd>
                                        <dd class="col-sm-11" style="text-align: justify;">
                                            {{-- <br> --}}
                                            @foreach ($tindakans->where('id_status', 9) as $tindakan)
                                                {{ $tindakan->Ulasan }} 
                                            @break
                                            @endforeach
                                            {{-- <br><br><br> --}}
                                        </dd>
                                    </dl>
                                    <dl class="row mb-4">
                                        <br>
                                        @foreach ($tindakans->where('id_status', 9) as $tindakan)
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ $tindakan->UpdatedBy ? \App\User::find($tindakan->UpdatedBy)->nama : '' }})</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">
                                                @if ( $jawatan == 'Pentadbir-SUB Kanan Pengurusan')
                                                    Setiausaha Bahagian Kanan (Pengurusan)
                                                @elseif ( $jawatan == 'Pentadbir-KSU')
                                                    Ketua Setiausaha
                                                @endif
                                            </dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">Kementerian Perpaduan Negara</dd>
                                        @break
                                        @endforeach

                                        <br>
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh: {{ Carbon\Carbon::parse($tindakan->UpdatedAt)->format('d.m.Y') }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Rujukan: {{ $maklumats->rujukan_fail }}</dd>
                                    </dl>
                                </div>
                            @else
                            @endif
                            
                        </div>

                        <br>

                        <div class="justify-content-center">
                            {{-- <a href="=" id="cetak" class="btn btn-warning float-left btn-sm"><i
                                    class="fa fa-print"></i> |
                                    Cetak
                            </a> --}}
                            {{-- <a href="{{ url('download_pdf/'.$maklumats->idMaklumatPermohonan) }}" id="" class="btn btn-warning float-right btn-sm"  style="background-color: green;">
                                <i class="fa fa-print"></i> | Download PDF
                            </a> --}}

                            {{-- <button type="button" id="printPageButton" class="btn btn-warning float-right btn-sm" onclick="window.print();" style="background-color: green;">
                                <i class="fa fa-print"></i> | Cetak
                            </button> --}}
                            {{-- <button type="button" id="kembaliPageButton"  class="btn btn-secondary float-left btn-sm"
                                onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali
                            </button> --}}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // window.print();
        });
    </script>
    
</body>
</html>
