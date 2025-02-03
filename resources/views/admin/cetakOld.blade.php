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
        @page {
            margin-top: 19.1mm;
            margin-bottom: 12.1mm;
            line-height: 1.5;
        }
    
        @media print {
            /* Hide footer on the first page */
            #footer {
                display: none;
            }
            
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
            bottom: 0;
            text-align: center; /* Align the text to the center */
            font-family: "Arial", sans-serif;   
            display: none; /* Hidden by default */
        }
    
        /* Page counter for the footer */
        #footer .page:after {
            content: counter(page);
        }
    
        /* Header styling */
        .header {
            position: absolute;
            top: 0;
            right: 0;
            font-family: "Arial", sans-serif;   
            font-size: 12pt;
        }
    </style>
    
</head>
<body style="background: white;font-family:'poppins', sans-serif;">
    
    {{-- <div class="header">
        <strong class="rujukan_fail">{{ $maklumats->rujukan_fail }}</strong>
    </div> --}}

    <div id="footer" class="footer">
        {{-- PAGE NUMBERING --}}
        {{-- <strong>{{ $maklumats->rujukan_fail }}</strong> --}}
        <p class="page"></p>
    </div> 

    <div class="content-body" style="margin-left: 14.1mm; margin-right: 6.1mm; margin-bottom: 14.1mm;" >
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
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($image))) }}" width="120" height="100" />
                                    <br>
                                    <h4>KERTAS CADANGAN {{ strtoupper($maklumats->namaProgram)  }}</h4>
                                    {{-- <h4>KERTAS CADANGAN PEROLEHAN {{ strtoupper($maklumats->namaProgram)  }}</h4> --}}
                                    {{-- <h4>BAHAGIAN KHIDMAT PENGURUSAN </h4> --}}
                                    <hr style="height:0px; width:95% ; background-color: #000; ">
                                </center>
                            </div>

                            <div class="col-12" style="margin-left: 4.1mm; margin-right: 4.1mm;">

                                {{-- {{ $maklumats->rujukan_fail }} --}}
                                
                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase" style="text-align: justify; font-weight: bold;">1. &nbsp;&nbsp;&nbsp;&nbsp;TUJUAN </dt>
                                </dl>
                                <dl class="row mb-4">
                                    {{-- <dt class="col-sm-11" style="text-align: justify;">{{$maklumats->tujuanProgram}}</dt> --}}
                                    <dd class="col-sm-11" style="text-align: justify;">{{$maklumats->tujuanProgram}}</dd>
                                    <br>
                                    {{-- <dd class="col-sm-9" style="text-transform:uppercase">{{$maklumats->latarBelakang}}</dd> --}}
                                </dl>

                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase"  style="text-align: justify;font-weight: bold;">2. &nbsp;&nbsp;&nbsp;&nbsp;LATAR BELAKANG </dt>
                                </dl>
                                <dl class="row mb-4">
                                    <dd class="col-sm-11" style="text-align: justify;">
                                        @php
                                            // The input text with numeral points
                                            $text = $maklumats->latarBelakang;
    
                                            // Split the text based on Roman numeral points
                                            // $points = preg_split('/(?<=\.)\s+(?=[ivxlcdm]+\.)/i', $text);
                                            // Check if the text contains Roman numerals using regex
                                            $hasRomanNumerals = preg_match('/^[ivxlcdm]+\./im', $text);
                                        @endphp
                                        @if ($hasRomanNumerals)
                                            @php
                                                // Split the text based on Roman numeral points
                                                $points = preg_split('/(?<=\.)\s+(?=[ivxlcdm]+\.)/i', $text);
                                            @endphp
                                            <table style="border: 0px solid;">
                                                @foreach ($points as $point)
                                                    @php
                                                        // Extract the Roman numeral and description using regex
                                                        preg_match('/^([ivxlcdm]+)\.\s*(.*)$/i', trim($point), $matches);
                                                        $romanNumeral = $matches[1]; // The Roman numeral (e.g., i, ii, iii)
                                                        $description = $matches[2]; // The point description
                                                    @endphp
                                                    <tr>
                                                        <td style=" vertical-align: top; text-align: left; width: 30px;">{{ $romanNumeral }}.</td> <!-- Display the Roman numeral -->
                                                        <td style="text-align: justify;">{{ $description }}</td> <!-- Display the point description -->
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @else
                                            {{ $maklumats->latarBelakang }}
                                        @endif
                                    </dd>
                                    <br>
                                    {{-- <dd class="col-sm-9" style="text-transform:uppercase">{{$maklumats->latarBelakang}}</dd> --}}
                                </dl>

                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase"  style="text-align: justify; font-weight: bold;">3. &nbsp;&nbsp;&nbsp;&nbsp;OBJEKTIF </dt>
                                </dl>
                                <dl class="row mb-4">
                                    <dd class="col-sm-11" style="text-align: justify;">Objektif perolehan adalah seperti berikut: <br><br></dd>

                                    <table>
                                        @if ( $objektif->obj1 )
                                            {{-- <tr>
                                                <td>
                                                    <dd class="col-sm-8" style="text-align: justify; margin-left: 12.1mm;">i.</dd>
                                                </td>
                                                <td style="position: relative;">
                                                    <dd class="col-sm-8" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm;">i.</dd>
                                                </td>
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm;"> &nbsp;&nbsp;&nbsp;{{$objektif->obj1}}</dd>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <!-- Position "i." absolutely within the <tr> -->
                                                <td style="position: relative;">
                                                    <dd class="col-sm-8" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm;">i.</dd>
                                                </td>
                                                <!-- Ensure the adjacent <td> has enough padding to prevent collision -->
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm; padding-left: 35px;">{{$objektif->obj1}}</dd>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ( $objektif->obj2 )
                                            {{-- <tr>
                                                <td>
                                                    <dd class="col-sm-8" style="text-align: justify; margin-left: 12.1mm;">ii.</dd>
                                                </td>
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm;">{{$objektif->obj2}}</dd>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <!-- Position "ii." absolutely within the <tr> -->
                                                <td style="position: relative;">
                                                    <dd class="col-sm-8" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm;">ii.</dd>
                                                </td>
                                                <!-- Ensure the adjacent <td> has enough padding to prevent collision -->
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm; padding-left: 35px;">{{$objektif->obj2}}</dd>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ( $objektif->obj3 )
                                            {{-- <tr>
                                                <td>
                                                    <dd class="col-sm-8" style="text-align: justify; margin-left: 12.1mm;">iii.</dd>
                                                </td>
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm;">{{$objektif->obj3}}</dd>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <!-- Position "iii." absolutely within the <tr> -->
                                                <td style="position: relative;">
                                                    <dd class="col-sm-8" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm;">iii.</dd>
                                                </td>
                                                <!-- Ensure the adjacent <td> has enough padding to prevent collision -->
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm; padding-left: 35px;">{{$objektif->obj3}}</dd>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ( $objektif->obj4 )
                                            {{-- <tr>
                                                <td>
                                                    <dd class="col-sm-8" style="text-align: justify; margin-left: 12.1mm;">iv.</dd>
                                                </td>
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm;">{{$objektif->obj4}}</dd>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <!-- Position "iv." absolutely within the <tr> -->
                                                <td style="position: relative;">
                                                    <dd class="col-sm-8" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm;">iv.</dd>
                                                </td>
                                                <!-- Ensure the adjacent <td> has enough padding to prevent collision -->
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm; padding-left: 35px;">{{$objektif->obj4}}</dd>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ( $objektif->obj5 )
                                            {{-- <tr>
                                                <td>
                                                    <dd class="col-sm-8" style="text-align: justify; margin-left: 12.1mm;">v.</dd>
                                                </td>
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm;">{{$objektif->obj5}}</dd>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <!-- Position "v." absolutely within the <tr> -->
                                                <td style="position: relative;">
                                                    <dd class="col-sm-8" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm;">v.</dd>
                                                </td>
                                                <!-- Ensure the adjacent <td> has enough padding to prevent collision -->
                                                <td>
                                                    <dd class="col-sm-10" style="text-align: justify; margin-right: 1.1mm; padding-left: 35px;">{{$objektif->obj5}}</dd>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </dl>

                            </div>

                            <div class="col-12 nextPage"  style="margin-left: 4.1mm; margin-right: 4.1mm;">
                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase"  style="text-align: justify; font-weight: bold;">4. &nbsp;&nbsp;&nbsp;&nbsp;CADANGAN PELAKSANAAN</dt>
                                </dl>
                                <dl class="row mb-4" >
                                    {{-- <dd class="col-sm-11" style="margin-left: 31px; text-align: justify;">Objektif perolehan adalah seperti berikut: <br></dd> --}}

                                    <table >
                                        <tr>
                                            <td style="position: relative;">
                                                <dd class="col-sm-11" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm; font-weight: bold;">Tajuk</dd>
                                            </td>
                                            <td style="position: relative;">
                                                <dd class="col-sm-11" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm; font-weight: bold; padding-left: 110px;"> :</dd>
                                            </td>
                                            <td>
                                                <dd class="col-sm-11" style="text-align: justify; margin-right: 1.1mm; padding-left: 140px;">{{$maklumats->namaProgram}}</dd>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="position: relative;">
                                                <dd class="col-sm-11" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm; font-weight: bold;">Tempoh Pelaksanaan</dd>
                                            </td>
                                            <td style="position: relative;">
                                                <dd class="col-sm-11" style="position: absolute; top: 0; left: 0; margin-left: 12.1mm; font-weight: bold; padding-left: 110px;"> :</dd>
                                            </td>
                                            <td>
                                                <dd class="col-sm-11" style="text-align: justify; margin-right: 1.1mm; padding-left: 140px;">
                                                    {{-- {{ \Carbon\Carbon::parse($maklumats->tkhCadangMula)->format('d/m/Y') }} - 
                                                    {{ \Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->format('d/m/Y') }} --}}
                                                    @if (\Carbon\Carbon::parse($maklumats->tkhCadangMula)->eq(\Carbon\Carbon::parse($maklumats->tkhCadangAkhir)))
                                                        {{ \Carbon\Carbon::parse($maklumats->tkhCadangMula)->format('d/m/Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($maklumats->tkhCadangMula)->format('d/m/Y') }} - 
                                                        {{ \Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->format('d/m/Y') }}
                                                    @endif
                                                </dd>
                                            </td>
                                        </tr>
                                    </table>
                                </dl>
                            </div>

                            <br>

                            <div class="col-12 nextPage" style="margin-left: 4.1mm; margin-right: 4.1mm;">
                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase"  style="text-align: justify; font-weight: bold;">5. &nbsp;&nbsp;&nbsp;&nbsp;ANGGARAN IMPLIKASI KEWANGAN</dt>
                                </dl>
                                <dl class="row mb-4">
                                    {{-- <dd class="col-sm-11" style="margin-left: 31px; text-align: justify;">Objektif perolehan adalah seperti berikut: <br></dd> --}}

                                    <table style="width: 96%; margin-left: 9.1mm; margin-right: 12.1mm;">
                                    {{-- <table style="width: 80%; margin-left: 53px; border: 1px solid black;"> --}}
                                        <tr>
                                            <th style="border: 1px solid black; padding: 10px;">BIL</th>
                                            <th style="border: 1px solid black; padding: 10px;">PERKARA</th>
                                            <th style="border: 1px solid black; padding: 10px;">OA/OS</th>
                                            <th style="border: 1px solid black; padding: 10px;">UNIT</th>
                                            <th style="border: 1px solid black; padding: 10px;">ANGGARAN KOS</th>
                                        </tr>
                                        <?php
                                            $total = 0;
                                        ?>
                                        @foreach ($votByAdmins as $vot)
                                            <tr>
                                                <td style="border: 1px solid black; padding: 10px;">{{ $loop->iteration }}</td>
                                                <td style="border: 1px solid black; padding: 10px;">
                                                    @if ( $vot->perkara === null || $vot->perkara === "" )
                                                        {{ $vot->keterangan }}
                                                    @else
                                                        {{ ($vot->perkara!='') ? \App\LkpPerkara::find($vot->perkara)->perkara : '' }}
                                                    @endif 
                                                    {{-- {{ ($vot->perkara!='') ? \App\LkpPerkara::find($vot->perkara)->perkara : '' }} --}}
                                                </td>
                                                <td style="border: 1px solid black; padding: 10px;">
                                                    {{-- OA{{ ($vot->objekAm!='') ? \App\LkpVot::find($vot->objekAm)->noVot : '' }}@if ($vot->objekSebagai)/OS{{ $vot->objekSebagai }}     @endif --}}
                                                    {{ ($vot->objekAm!='') ? \App\LkpOA::find($vot->objekAm)->oa : '' }} / {{ ($vot->objekSebagai!='') ? \App\LkpOS::find($vot->objekSebagai)->os : '' }}
                                                </td>
                                                <td style="border: 1px solid black; padding: 10px;"><center> @if( $vot->unit != 0 ) {{ $vot->unit }} @else - @endif </center></td>
                                                <td style="border: 1px solid black; padding: 10px;">RM {{ number_format($vot->kos, 2) }}</td>
                                                <?php
                                                    $total = $total + $vot->kos;
                                                ?>
                                            </tr>
                                            @if ($loop->last) <!-- Check if it's the last iteration -->
                                                <tr>
                                                    <td colspan="4" style="border: 1px solid black; padding: 10px; font-weight: bold;">JUMLAH KESELURUHAN</td>
                                                    <td colspan="1" style="border: 1px solid black; padding: 10px;">RM {{ number_format($total, 2) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </dl>
                            </div>

                            <br> 
                            <div class="col-12 nextPage" style="margin-left: 4.1mm; margin-right: 4.1mm; page-break-after: always; ">
                                <dl class="row mb-4">
                                    <dt class="col-sm-6 uppercase"  style="text-align: justify; font-weight: bold;">6. &nbsp;&nbsp;&nbsp;&nbsp;SYOR</dt>
                                </dl>
                                <dl class="row mb-4">
                                    <dd class="col-sm-11" style="text-align: justify;">
                                         {{-- {{ $maklumats->syor }} --}}
                                         @if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)')
                                            {{ $pemohon->namaBahagian }}, {{ $pemohon->agensi }} 
                                         @else
                                            {{ $pemohon->namaBahagian }}
                                         @endif
                                          mengesyorkan permohonan ini untuk pertimbangan seterusnya.
                                         {{-- {{ $pemohon->namaBahagian }} mengesyorkan permohonan ini untuk pertimbangan seterusnya. --}}
                                        {{-- <br> --}}
                                    </dd>
                                    <dd class="col-sm-11" style="text-align: justify;">
                                        <br>
                                         Sekian, terima kasih.
                                    </dd>
                                </dl>
                                @if ( $pengesah )
                                    @if ( $pemohon->agensi != 'Kementerian Perpaduan Negara (KPN)')
                                        <dl class="row mb-4">
                                            <br><br><br><br><br>
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pengesah->namaPengesah) }})</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->jawatanPengesah }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->bahagianPengesah }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->agensiPengesah }}</dd>
                                        </dl>
                                    @else
                                        <dl class="row mb-4">
                                            <br><br><br><br><br>
                                            <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($pengesah->name) }})</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ $pengesah->jawatan }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ ($pengesah->bahagian_id!='') ? \App\PLkpBahagian::find($pengesah->bahagian_id)->bahagian : '' }}</dd>
                                            <dd class="col-sm-11"  style="text-align: justify;">{{ ($pengesah->agensi_id!='') ? \App\Agensi::find($pengesah->agensi_id)->agensi : '' }}</dd>
                                        </dl>
                                    @endif
                                @else
                                    <br><br><br><br><br>
                                @endif

                                {{-- @if ( $setiausahaB )
                                    <dl class="row mb-4">
                                        <br><br><br><br><br>
                                        <dd class="col-sm-11 uppercase"  style="text-align: justify; font-weight: bold;">({{ strtoupper($setiausahaB->name) }})</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ $setiausahaB->jawatan }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->namaBahagian }}</dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">{{ $pemohon->agensi }}</dd>
                                    </dl>
                                @else
                                    <br><br><br><br><br>
                                @endif --}}
                            </div>

                            {{-- KEPUTUSAN SUB BKP DISOKONG --}}
                            {{-- <br> --}}
                            <div class="col-12 pageBreak" style="margin-left: 4.1mm; margin-right: 4.1mm;">

                                @foreach ($tindakans as $tindakan)
                                    @if ($tindakan->id_status == 13)
                                        <?php 
                                            $peruntukan = 1;
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
                                        @if (isset($peruntukan) && $peruntukan == 1) Ada @elseif (!isset($peruntukan) || $peruntukan != 1) Tiada @endif
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
                                    <hr>

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
                                        @if (isset($sokong) && $sokong == 1) Disokong @elseif (!isset($sokong) || $sokong != 1) Tidak Disokong @endif
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
                                        @break
                                    @endforeach

                                    <br>
                                    <dd class="col-sm-11"  style="text-align: justify;">Tarikh: </dd>
                                    <dd class="col-sm-11"  style="text-align: justify;">Rujukan: {{ $maklumats->kod_permohonan }}</dd>
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
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh: </dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Rujukan: {{ $maklumats->kod_permohonan }}</dd>
                                    </dl>
                                </div>
                            @else
                            @endif

                            {{-- KEPUTUSAN SUBK P LULUS OR KSU LULUS--}}
                            {{-- <br> --}}
                            @if ( isset($lulus) )
                                <div class="col-12 pageBreak" style="margin-left: 4.1mm; margin-right: 4.1mm;">
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
                                        <dd class="col-sm-11"  style="text-align: justify;">Tarikh: </dd>
                                        <dd class="col-sm-11"  style="text-align: justify;">Rujukan: {{ $maklumats->kod_permohonan }}</dd>
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
