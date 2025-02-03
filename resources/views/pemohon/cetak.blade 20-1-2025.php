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
	<meta name="description" content="ePantas" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
	<meta property="og:title" content="ePantas" />
	<meta property="og:description" content="Sistem eNaziran@KPN" />
	<meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png" />
	<meta name="format-detection" content="telephone=no">
    <title>Cetak-{{ $maklumats->namaProgram }}</title>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    {{-- <style type="text/css" media="print">
        @page {
            size: portrait;
            /* auto is the initial value */
            /* margin: 0px 0px 0px 0px; */
            /* this affects the margin in the printer settings  atas, kanan, bawah, kiri*/
        }

        @page lcp {
            size: landscape;
            /* auto is the initial value */
            /* margin: 20px 20px 20px 20px; */
            /* this affects the margin in the printer settings  atas, kanan, bawah, kiri*/
        }
        @page {
            margin-top: 14.1mm; 
            /* //Adjust the margin-top value as needed */
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
        /* @page {
            margin-top: 19.1mm;
            margin-bottom: 12.1mm;
            line-height: 1.5;
            margin: 120px 50px 80px 50px;
        }
        @page :first {
            margin-top: 10mm; 
        } */

        #footer {
            position: fixed;
            left: 0;
            right: 0; /* Center the footer horizontally */
            bottom: -30px;
            text-align: center; /* Align the text to the center */
            font-family: "Arial", sans-serif;   
        }
        #footer .page:after {
            content: counter(page);
        }
        
        /* TEST */
            /* @page {
                margin: 100px 50px; 
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
            /* table {
                page-break-inside: auto;
            } */

            /* tr {
                page-break-inside: avoid;
                page-break-after: auto;
            } */

            /* footer {
                position: fixed;
                bottom: -50px;
                left: 55px;
                right: 0;
                height: 30px;
                font-size: 9pt;
                text-align: left;
                display: block;
            }  */
              
        /* TEST */

        /* td p { */
            /* display: inline; Forces <p> tags to behave inline */
            /* margin: 0;       Removes default margin of <p> tags */
        /* } */
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

    <div id="footer">
        {{-- PAGE NUMBERING --}}
        <p class="page"></p>
    </div> 

    <footer>
        Ruj. Fail: {{ $maklumats->rujukan_fail }} 
    </footer>

    <header>
        {{ $maklumats->namaProgram }}
    </header>
    {{-- <footer>
        Ruj. Fail: {{ $maklumats->rujukan_fail }} 
    </footer> --}}

    {{-- <div class="content-body" style="margin-left: 14.1mm; margin-right: 6.1mm; margin-bottom: 14.1mm; " > --}}
    <div class="content-body" style="margin-left: 10.1mm; margin-right: 10.1mm; margin-bottom: 0.1mm; " >
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
                                    {{-- <br> --}}
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
                                            <td>: {{ $maklumats->rujukan_fail }}</td>
                                            {{-- <td>: {{ $ruj_fail->rujukan_fail ?? '' }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td>Tarikh</td>
                                            {{-- <td>: {{ \Carbon\Carbon::parse($maklumats->tkhCadangMula)->translatedFormat('d F Y') }}</td> --}}
                                            <td>: {{ \Carbon\Carbon::parse($maklumats->createdAt)->translatedFormat('d F Y') }}</td>
                                            {{-- <td>: {{ $maklumats->tkhCadangMula }}</td> --}}
                                        </tr>
                                    </table>
                                    <div style="clear: both;"></div> <!-- Ensures no floating issues -->
                                </div>

                                <div style="text-align: justify; font-weight: bold;">
                                    {{ strtoupper($maklumats->namaProgram) }}
                                    <br><br>
                                </div>
                            </div>

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
                            {{-- <div class="col-12 nextPage" style="margin-left: 4.1mm; margin-right: 4.1mm; page-break-after: always; "> --}}
                            <div class="col-12 nextPage" style="margin-left: 4.1mm; margin-right: 4.1mm; page-break-inside: avoid;">
                                {{-- page-break-inside: avoid; Prevents splitting across pages --}}

                                <p>Sekian, terima kasih.</p>

                                <center>
                                    <h4>
                                        "MALAYSIA MADANI"
                                        <br>
                                        "BERKHIDMAT UNTUK NEGARA"
                                    </h4>
                                </center>

                                {{-- <dl class="row mb-4" style="text-align: left; width: auto; position: absolute; right: 0;"> --}}
                                <dl class="row mb-4" style="text-align: left; width: auto; float: right;">
                                    <br>
                                    <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pemohon->namaPemohon) }})</dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->jawatanPemohon }}</dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->namaBahagian }}</dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->agensi }}</dd>
                                </dl>

                                {{-- @if ($pengesah)
                                    <dl class="row mb-4" style="float: right; text-align: left; width: auto;">
                                        <dd class="col-sm-11 uppercase" style="font-weight: bold;">({{ strtoupper($pengesah->name) }})</dd>
                                        <dd class="col-sm-11">{{ $pengesah->jawatan }}</dd>
                                        <dd class="col-sm-11">{{ ($pengesah->bahagian_id != '') ? \App\PLkpBahagian::find($pengesah->bahagian_id)->bahagian : '' }}</dd>
                                        <dd class="col-sm-11">{{ ($pengesah->agensi_id != '') ? \App\Agensi::find($pengesah->agensi_id)->agensi : '' }}</dd>
                                    </dl>
                                @else
                                    <br><br><br><br><br>
                                @endif --}}

                                {{-- <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase"  style="text-align: justify; font-weight: bold;">6. &nbsp;&nbsp;&nbsp;&nbsp;SYOR</dt>
                                </dl>
                                <dl class="row mb-4">
                                    <dd class="col-sm-11" style="text-align: justify;">
                                            @if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)')
                                            {{ $pemohon->namaBahagian }}, {{ $pemohon->agensi }} 
                                            @else
                                            {{ $pemohon->namaBahagian }}
                                            @endif
                                            mengesyorkan permohonan ini untuk pertimbangan seterusnya.
                                    </dd>
                                    <dd class="col-sm-11" style="text-align: justify;">
                                        <br>
                                         Sekian, terima kasih.
                                    </dd>
                                </dl> --}}
                                {{-- @if ( $pengesah )
                                    <dl class="row mb-4">
                                        <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pengesah->name) }})</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->jawatan }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ ($pengesah->bahagian_id!='') ? \App\PLkpBahagian::find($pengesah->bahagian_id)->bahagian : '' }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ ($pengesah->agensi_id!='') ? \App\Agensi::find($pengesah->agensi_id)->agensi : '' }}</dd>
                                    </dl>
                                @else
                                    <br><br><br><br><br>
                                @endif --}}

                            </div>
                            
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- <script type="text/javascript">
        $(document).ready(function () {
            // window.print();
        });
    </script> --}}
    
</body>
</html>
