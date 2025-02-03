@extends('layouts.masterAdmin')
@section('content')
<style>
    .content-body {
        font-family: Arial, sans-serif;
        /* font-size: 20px; */
    }
    table {
        width: 90%;
        margin: auto;
        color: black;
    }
    td, th {
      border: 1px solid #000000;
      text-align: left;
      padding: 18px;
    }
    span{
        text-align: right;
    }
</style>

<style type="text/css" media="print">
    @page {
        size: portrait;
        /* auto is the initial value */
        margin: 0px 0px 0px 0px;
        /* this affects the margin in the printer settings  atas, kanan, bawah, kiri */
    }

    /* @page {
        size: A4;
        margin: 0;
    } */

    @page lcp {
        size: landscape;
        /* auto is the initial value */
        margin: 20px 20px 20px 20px;
        /* this affects the margin in the printer settings  atas, kanan, bawah, kiri*/
    }

    @media print {
        .nextPage {
            page-break-after: always;
        }
    }

    div.landscape-content {
        page: lcp;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 20px;
    }
    
    .content-body {
        text-align: left;
        margin-left: 59px;
        margin-right: auto;
        /* margin-top: auto; */
        /* margin-bottom: auto; */
        width: 89%;
    }	

    table {
        /* margin-left: 1in; */
        /* margin-right: 12in; */

        border-collapse: collapse;
        width:100%;
        border: 1px solid black;
        /* border-top: 1px solid black;
        border-bottom: 1px solid black; */
        /* border-collapse: collapse; */
    }

    th, tr {
        padding: 10px;
        /* border-left: 1px solid black;
        border-right: 1px solid black; */

    }

    td {  
        /* text normal */
        font-family: "Arial", sans-serif;
        font-size: 12pt;
        padding: 10px;
        border-top: 1px solid black;
        border-left: 1px solid black;
        border-right: 1px solid black;
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
        /* color: blue !important; */
    }

    h4 {
        /* header */
        font-family: "Arial", sans-serif;
        font-size: 14pt;
        /* font-size: 18px; */
        font-weight: bold;
    }

    .slip {
        font-size: 20px;
        font-weight: bold;
    }

    .title {
        font-size: 12px;
        font-weight: bold;
        font-color: blue;
    }

    .capitalize {
        text-transform: capitalize;
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
    
</style>

    <!--**********************************
                Content body start
            ***********************************-->
    <div class="content-body">  
        <div class="container-fluid">
            <div class="col-xl-13 col-lg-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <h4 class="card-title">Pengesahan</h4>
                    </div> --}}
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <center>
                                <br>
                                <img src="{{asset('/images/JataNegara.png')}}" class="img-circle elevation-2" width="160" height="130" alt="User Image">
                                <br>
                                <br>
                                <h4>SEKSYEN KEWANGAN DAN PEROLEHAN </h4>
                                <h4>BAHAGIAN KHIDMAT PENGURUSAN </h4>
                                
                                <br>
                                <u> <h4>PENGESAHAN PERUNTUKAN KEWANGAN</h4> </u>
                                <br>
                            </center>
                        </div>
                        <table>
                            <tr>
                                <td>Nama Program/Perolehan <span> :</span> </td>
                                <td>{{ $maklumats->namaProgram }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Peruntukan yang Dimohon (RM) <span> :</span> </td>
                                <td>RM{{ number_format($maklumats->kosSebenar, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Punca Peruntukan/Pembiayaan <span> :</span> </td>
                                <td>
                                    @foreach ( $votByAdmins as $votByAdmin)
                                        {{-- OS{{ ($votByAdmin->objekSebagai!='') ? \App\LkpObjek::find($votByAdmin->objekSebagai)->noVot : '' }} --}}
                                        ( OA{{ $votByAdmin->objekAm ? \App\LkpVot::find($votByAdmin->objekAm)->noVot : '' }} 
                                            @if ($votByAdmin->objekSebagai != null || $votByAdmin->objekSebagai != '')
                                                - OS{{ $votByAdmin->objekSebagai }} 
                                            @else
                                                
                                             @endif
                                        )
                                        
                                        @unless ($loop->last), @endunless

                                    @endforeach
                                    / {{ $maklumats->id_jenis_perbelanjaan }} 
                                    @if ($maklumats->id_jenis_peruntukan == 1) Mengurus @else  Pembangunan  @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Tarikh & Tempoh Pelaksanaan <span> :</span> </td>
                                <td>
                                    <?php
                                        // echo '('.\Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->dayName.')';
                                        use Carbon\Carbon;
                                        echo Carbon::parse($maklumats->tkhCadangMula)->isoFormat('D MMMM YYYY')  . ' - ' . Carbon::parse($maklumats->tkhCadangAkhir)->isoFormat('D MMMM YYYY');
                                    ?>                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Ulasan daripada Seksyen Kewangan <span> :</span> </td>
                                @empty ( $tindakans->Ulasan )
                                    <td> - </td>
                                @else
                                    <td>{{ $tindakans->Ulasan }}</td>
                                @endempty
                            </tr>
                            <tr>
                                <td>Disediakan oleh <span> :</span> </td>
                                <td> 
                                    <div style="height: 100px;"></div>
                                    Name: {{ $user->nama ?? '-' }} <br>
                                    Jawatan: {{ $user->jawatan ?? '-' }} <br>
                                    {{-- Bahagian: {{ $user->bahagian_id ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : '' }} <br> --}}
                                    Bahagian: {{ $user->bahagian ?? '-' }} <br>
                                    Tarikh: {{ Carbon::parse($tindakans->UpdatedAt)->isoFormat('D MMMM YYYY') }}
                                    {{-- Tarikh: {{ Carbon::parse($maklumats->updatedAt)->isoFormat('D MMMM YYYY') }} --}}
                                </td>
                            </tr>
                        </table>
                        
                        <br>

                        <div class=" justify-content-center">
                            {{-- <a href="=" id="cetak" class="btn btn-warning float-left btn-sm"><i
                                    class="fa fa-print"></i> |
                                    Cetak
                            </a> --}}
                            <button type="button" id="printPageButton" class="btn btn-warning float-right btn-sm" onclick="window.print();" style="background-color: green;">
                                <i class="fa fa-print"></i> | Cetak</button>
                            <button type="button" id="kembaliPageButton"  class="btn btn-secondary float-left btn-sm"
                                onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button>
                        </div>

                    </div>

                    
                    <br>
                </div>
            </div>

        </div>

    </div>
    <!--**********************************
                Content body end
            ***********************************-->
@endsection
