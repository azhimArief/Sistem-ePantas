@extends('layouts.master')
@section('content')
    <!--**********************************
                        Content body start
                ***********************************-->

    <style>
        .card-body {
            margin-left: 10px;
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
            background-color: lightblue;
        }
        .justify-text {
            text-align: justify;
        }
        .line-spacing{
            line-height: 1.6;
        }
    </style>
    @if ( $errors->has('catatanBatal'))
        <style>
            #catatanBatal {
                border-color: red;
                border-width: 2px;
            }
        </style>
    @endif

    <div class="content-body">
            {{-- <div class="row"> --}}
                <div class="col-12">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                            {{ session('status') }}
                        </div>
                    @elseif(session('failed'))
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            {{ session('failed') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Sila berikan alasan pembatalan. --}}
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            Sila berikan alasan pembatalan.
                            {{-- <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul> --}}
                        </div>
                    @endif
                </div>
            {{-- </div> --}}

            {{-- <div style="width:110%;align:center;"> --}}
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="font-w600 title mb-2 mr-auto">Butiran Peruntukan - {{ $maklumats->kod_permohonan ?? 'M/Draft' }}</h3>

                        <?php
                            $status = $maklumats->id_status;
                            $color = ""; 
                            switch($status){
                            //permohonan baru
                            case "1": $color="#2C87F0"; $status="Status : Permohonan Baru"; /*$badge="badge badge-secondary light";*/ $badge="badge badge-rounded badge-secondary badge-lg"; break; //biru
                            //telah dikemaskini
                            case "2": $color="#FFB300"; $status="Status : Dalam Proses"; break; //kuning
                            //lulus
                            case "9":  $color="#32CD32"; $status="Status : Lulus"; /*$badge="badge badge-success light";*/ $badge="badge badge-rounded badge-success badge-lg"; break; //hijau
                            //Tidak Diluluskan
                            case "10": $color="#FF0000"; $status="Status : Tidak Diluluskan"; /*$badge="badge badge-danger light";*/ $badge="badge badge-rounded badge-danger badge-lg"; break; //merah
                            //semak semula
                            case "11": $color="#FFB300"; $status="Status : Semak Semula"; /*$badge="badge badge-warning light";*/ $badge="badge badge-rounded badge-warning badge-lg"; break; //biru
                            case "22": $color="#FFB300"; $status="Status : Semak Semula"; /*$badge="badge badge-warning light";*/ $badge="badge badge-rounded badge-warning badge-lg"; break; //biru
                            //Draft
                            case "12": $color="#FFB300"; $status="Status : Draf"; /*$badge="badge badge-warning light";*/ $badge="badge badge-rounded badge-primary badge-lg text-white"; break; //biru
                            //batal
                            case "8": $color="#CC3300"; $status="Status : Batal"; /*$badge="badge badge-danger light";*/ $badge="badge badge-rounded badge-danger badge-lg";  break; //merah pekat
                            //sah
                            case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                            case '13':
                                $color = '#FFFFFF';
                                $status = 'Status : Ada Peruntukan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '14':
                                $color = '#FFFFFF';
                                $status = 'Status : Tiada Peruntukan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-danger badge-lg';
                                break; //merah pekat
                            case '15':
                                $color = '#FFFFFF';
                                $status = 'Status : Disokong';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '16':
                                $color = '#FFFFFF';
                                $status = 'Status : Tidak Disokong';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-danger badge-lg';
                                break; //merah pekat
                            case '17':
                                $color = '#FFFFFF';
                                $status = 'Status : Disyorkan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat SUBK
                            case '18':
                                $color = '#FFFFFF';
                                $status = 'Status : Tidak Disyorkan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-danger badge-lg';
                                break; //merah pekat SUBK
                            case '19':
                                $color = '#FFFFFF';
                                $status = 'Status : Disyorkan';
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '20':
                                $color = '#FFFFFF';
                                $status = 'Status : Dikemaskini'; //to Pengesah
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-primary badge-lg text-white';
                                break; //merah pekat
                            case '21':
                                $color = '#FFFFFF';
                                $status = 'Status : Dikemaskini'; //to Pentadbir
                                /*$badge="badge badge-danger light";*/ $badge = 'badge badge-rounded badge-secondary badge-lg text-white';
                                break; //merah pekat
                            //Banyak Banyak
                            default : $color="#000000";
                            }
                        ?>
                        {{-- <span class="{{ $badge }}"> {{ $status }}</span> --}}
                        <span class="{{ $badge }}" style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                            {{ $status }}
                        </span>
                    </div>
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                    <form class="form-horizontal" method="POST" action="{{ url('/pemohon/batal/simpan/'.$maklumats->idMaklumatPermohonan) }}" enctype="multipart/form-data">        
                        {{ csrf_field() }}
                        <div class="card-body">

                            <div id="accordion-four" class="accordion accordion-header-shadow accordion-rounded">
                                <!-- Maklumat Pemohon Accordion -->
                                    <div class="accordion__item" style="margin-top: 10px;">
                                        <div class="accordion__header" data-toggle="collapse" data-target="#bordered_no-gutter_collapse1" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                            <h5 style="color: #333; margin: 0;">Maklumat Pemohon</h5>
                                            <span class="accordion__header--indicator style_two"></span>
                                        </div>
                                        <div id="bordered_no-gutter_collapse1" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                            <div class="accordion__body--text">
                                                <dl class="row">
                                                    <dt class="col-sm-2" style="font-weight: bold;">Nama Pemohon</dt>
                                                    <dd class="col-sm-10">{{ $user->nama ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">Jawatan</dt>
                                                    <dd class="col-sm-4">{{ $user->jawatan ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">Gred</dt>
                                                    <dd class="col-sm-4">{{ $user->gred ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">Bahagian</dt>
                                                    <dd class="col-sm-4">{{ $user->bahagian ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">Agensi</dt>
                                                    <dd class="col-sm-4">{{ $user->agensi ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">No. Tel. Pejabat</dt>
                                                    <dd class="col-sm-4">{{ $user->tel_pejabat ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">No. Tel. Bimbit</dt>
                                                    <dd class="col-sm-4">{{ $user->telefon ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">E-mel</dt>
                                                    <dd class="col-sm-4">{{ $user->email ?? '-' }}</dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                <!-- End of Maklumat Pemohon Accordion -->
    
                                <!-- Maklumat Pengesah Accordion -->
                                @if (!empty($pengesahAgensi))
                                    <div class="accordion__item" style="margin-top: 10px;">
                                        <div class="accordion__header" data-toggle="collapse" data-target="#bordered_no-gutter_collapse2" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                            <h5 style="color: #333; margin: 0;">Maklumat Pengesah</h5>
                                            <span class="accordion__header--indicator style_two"></span>
                                        </div>
                                        <div id="bordered_no-gutter_collapse2" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                            <div class="accordion__body--text">
                                                <dl class="row">
                                                    <dt class="col-sm-2" style="font-weight: bold;">Nama Pengesah</dt>
                                                    <dd class="col-sm-10">{{ $pengesahAgensi->namaPengesah ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">Jawatan</dt>
                                                    <dd class="col-sm-10">{{ $pengesahAgensi->jawatanPengesah ?? '-' }}</dd>
                                                    <dt class="col-sm-2" style="font-weight: bold;">Bahagian</dt>
                                                    <dd class="col-sm-4">{{ $pengesahAgensi->bahagianPengesah ?? '-' }}</dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- End of Maklumat Pengesah Accordion -->
    
                                {{-- <br> --}}
                                {{-- <hr> --}}
                                {{-- <br> --}}
    
                                <div class="accordion__item">
                                    <!-- Styled Maklumat Permohonan Header -->
                                    {{-- <div class="accordion__header" style="background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 5px; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center;">
                                        <u>
                                            <h5 style="color: #333; margin: 0;">Maklumat Permohonan</h5>
                                        </u>
                                    </div> --}}
                                    <div class="accordion__body show">
                                        <!-- Child Accordion for Nama Program -->
                                        <div class="accordion__item" style="margin-top: 10px;">
                                            <div class="accordion__header" data-toggle="collapse" data-target="#collapseChild1" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                                <h5 style="color: #333; margin: 0;">Nama Program</h5>
                                                <span class="accordion__header--indicator style_two"></span>
                                            </div>
                                            <!-- Content of Nama Program -->
                                            <div id="collapseChild1" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                                <div class="accordion__body--text">
                                                    <dd class="col-sm-10 justify-text line-spacing">
                                                        {{ $maklumats->namaProgram ?? '-' }}
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Child Accordion -->
                                
                                        <!-- Child Accordion for Tujuan -->
                                        <div class="accordion__item" style="margin-top: 10px;">
                                            <div class="accordion__header" data-toggle="collapse" data-target="#collapseChild2" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                                <h5 style="color: #333; margin: 0;">Tujuan</h5>
                                                <span class="accordion__header--indicator style_two"></span>
                                            </div>
                                            <!-- Content of Tujuan -->
                                            <div id="collapseChild2" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                                <div class="accordion__body--text">
                                                    <div class="table-responsive">
                                                        <table id="example1" class="table table-sm table-bordered" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%">
                                                                        <center>Bil.</center>
                                                                    </th>
                                                                    <th>
                                                                        <center>Tujuan</center>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($tujuans->isEmpty())
                                                                    <tr>
                                                                        <td><center>-</center></td>
                                                                        <td><center>-</center></td>
                                                                    </tr>
                                                                @endif
                                                                @foreach ($tujuans as $tujuan)
                                                                    <tr>
                                                                        <td style="text-align: center; vertical-align: top; font-weight: bold;">
                                                                            1.{{ $loop->iteration }}
                                                                        </td>
                                                                        <td style="text-align: justify;">
                                                                            {!! $tujuan->tujuan !!}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Child Accordion 2 -->
    
                                        <!-- Child Accordion for Latar Belakang -->
                                        <div class="accordion__item" style="margin-top: 10px;">
                                            <div class="accordion__header" data-toggle="collapse" data-target="#collapseChild3" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                                <h5 style="color: #333; margin: 0;">Latar Belakang</h5>
                                                <span class="accordion__header--indicator style_two"></span>
                                            </div>
                                            <!-- Content of Latar Belakang -->
                                            <div id="collapseChild3" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                                <div class="accordion__body--text">
                                                    <div class="table-responsive">
                                                        <table id="example1" class="table table-sm table-bordered" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%">
                                                                        <center>Bil.</center>
                                                                    </th>
                                                                    <th>
                                                                        <center>Latar Belakang</center>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($latars->isEmpty())
                                                                    <tr> 
                                                                        <td><center>-</center></td>
                                                                        <td><center>-</center></td> 
                                                                    </tr>
                                                                @endif
                                                                @foreach ($latars as $latar)
                                                                    <tr>
                                                                        <td style="text-align: center; vertical-align: top; font-weight: bold;">
                                                                            2.{{ $loop->iteration }}
                                                                        </td>
                                                                        <td style="text-align: justify;">
                                                                            {!! $latar->latarBelakang !!}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Child Accordion 3 -->
    
                                        <!-- Child Accordion for Dasar Semasa -->
                                        <div class="accordion__item" style="margin-top: 10px;">
                                            <div class="accordion__header" data-toggle="collapse" data-target="#collapseChild4" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                                <h5 style="color: #333; margin: 0;">Dasar Semasa</h5>
                                                <span class="accordion__header--indicator style_two"></span>
                                            </div>
                                            <div id="collapseChild4" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                                <div class="accordion__body--text">
                                                    <div class="table-responsive">
                                                        <table id="example1" class="table table-sm table-bordered" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"><center>Bil.</center></th>
                                                                    <th><center>Dasar Semasa</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($dasars->isEmpty())
                                                                    <tr> 
                                                                        <td><center>-</center></td>
                                                                        <td><center>-</center></td> 
                                                                    </tr>
                                                                @endif
                                                                @foreach ($dasars as $dasar)
                                                                    <tr>
                                                                        <td style="text-align: center; vertical-align: top; font-weight: bold;">3.{{ $loop->iteration }}</td>
                                                                        <td style="text-align: justify;">{!! $dasar->dasarSemasa !!}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Child Accordion 4 -->
    
                                        <!-- Child Accordion for Justifikasi Permohonan -->
                                        <div class="accordion__item" style="margin-top: 10px;">
                                            <div class="accordion__header" data-toggle="collapse" data-target="#collapseChild5" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                                <h5 style="color: #333; margin: 0;">Justifikasi Permohonan</h5>
                                                <span class="accordion__header--indicator style_two"></span>
                                            </div>
                                            <div id="collapseChild5" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                                <div class="accordion__body--text">
                                                    <div class="table-responsive">
                                                        <table id="example1" class="table table-sm table-bordered" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"><center>Bil.</center></th>
                                                                    <th><center>Justifikasi Permohonan</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($justifikasis->isEmpty())
                                                                    <tr> 
                                                                        <td><center>-</center></td>
                                                                        <td><center>-</center></td> 
                                                                    </tr>
                                                                @endif
                                                                @foreach ($justifikasis as $justifikasi)
                                                                    <tr>
                                                                        <td style="text-align: center; vertical-align: top; font-weight: bold;">4.{{ $loop->iteration }}</td>
                                                                        <td style="text-align: justify;">{!! $justifikasi->justifikasiPermohonan !!}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Child Accordion 5 -->
    
                                        <!-- Child Accordion for Ulasan Bahagian -->
                                        <div class="accordion__item" style="margin-top: 10px;">
                                            <div class="accordion__header" data-toggle="collapse" data-target="#collapseChild6" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                                <h5 style="color: #333; margin: 0;">Ulasan Bahagian</h5>
                                                <span class="accordion__header--indicator style_two"></span>
                                            </div>
                                            <div id="collapseChild6" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                                <div class="accordion__body--text">
                                                    <div class="table-responsive">
                                                        <table id="example1" class="table table-sm table-bordered" style="width:100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"><center>Bil.</center></th>
                                                                    <th><center>Ulasan Bahagian</center></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($ulasans->isEmpty())
                                                                    <tr> 
                                                                        <td><center>-</center></td>
                                                                        <td><center>-</center></td> 
                                                                    </tr>
                                                                @endif
                                                                @foreach ($ulasans as $ulasan)
                                                                    <tr>
                                                                        <td style="text-align: center; vertical-align: top; font-weight: bold;">5.{{ $loop->iteration }}</td>
                                                                        <td style="text-align: justify;">{!! $ulasan->ulasanBahagian !!}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Child Accordion 6 -->
    
                                        <!-- Child Accordion for Anggaran Implikasi Kewangan -->
                                        <div class="accordion__item" style="margin-top: 10px;">
                                            <div class="accordion__header" data-toggle="collapse" data-target="#collapseChild7" style="background-color: #f1f1f1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 3px;">
                                                <h5 style="color: #333; margin: 0;">Anggaran Implikasi Kewangan</h5>
                                                <span class="accordion__header--indicator style_two"></span>
                                            </div>
                                            <div id="collapseChild7" class="collapse accordion__body show" style="padding: 10px; background-color: #fff; border: 1px solid #ddd; border-top: none;">
                                                <div class="accordion__body--text">
                                                    <div class="table-responsive">
                                                        <table id="example1" class="table table-sm table-bordered" style="width:100%; ">
                                                        {{-- <table id="example1" class="table table-sm table-responsive-sm table-bordered" style="width:99%; "> --}}
                                                            {{-- <thead class="thead-light"> --}}
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <center>Bil.</center>
                                                                    </th>
                                                                    <th>
                                                                        Perkara
                                                                        {{-- <center>Perkara</center> --}}
                                                                    </th>
                                                                    <th>
                                                                        Objek Am/Objek Sebagai
                                                                        {{-- <center>Objek Am/Objek Sebagai</center> --}}
                                                                    </th>
                                                                    {{-- <th>
                                                                        Lain-Lain/Keterangan
                                                                    </th> --}}
                                                                    <th>
                                                                        Unit/Bilangan
                                                                    </th>
                                                                    <th>
                                                                        Kos(RM)
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($vots->isEmpty())
                                                                    {{-- If Empty --}}
                                                                    <tr> 
                                                                        <td><center>-</center></td> <td>-</td> <td>-</td> <td>-</td> <td>-</td> 
                                                                    </tr>
                                                                @endif
                                                                @foreach ($vots as $vot)
                                                                    <tr>
                                                                        <td><center>{{ $loop->iteration }}.</center></td>
                                                                        <td> 
                                                                              @if ( $vot->perkara === null || $vot->perkara === "" )
                                                                                  {{ $vot->keterangan }}
                                                                              @else
                                                                                  {{ ($vot->perkara!='') ? \App\LkpPerkara::find($vot->perkara)->perkara : '' }}
                                                                              @endif 
                                                                        </td>
                                                                        <td>    
                                                                            {{ ($vot->objekAm!='') ? \App\LkpOA::find($vot->objekAm)->oa : '' }} / {{ ($vot->objekSebagai!='') ? \App\LkpOS::find($vot->objekSebagai)->os : '' }}
                                                                        </td>
                                                                        {{-- <td>{{ $vot->objekAm }}</td> --}}
                                                                        {{-- <td>{{ $vot->objekSebagai }}</td> --}}
                                                                        {{-- <td><center> {{ $vot->keterangan ?: '-' }} </center></td>  --}}
                                                                        <td>@if( $vot->unit != 0 ) {{ $vot->unit }} @else - @endif</td>
                                                                        <td>RM{{ number_format($vot->kos, 2) }}</td>
                                                                        {{-- <td>RM{{ $vot->kos }}</td>  --}}
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            {{-- <tfoot>
                                                                <tr>
                                                                    <td colspan="7" align="right">
                                                                        
                                                                    </td>
                                                                </tr>
                                                            </tfoot> --}}
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End of Child Accordion 6 -->
    
                                    </div>
                                </div>
    
                            </div>
                            
                            <dl class="row">
        
                                    <dt class="col-sm-2">Kos Perolehan/Projek/ Program</dt>
                                    <dd class="col-sm-4">
                                        <span class="badge badge-primary text-white"> RM {{ number_format($maklumats->kosMohon, 2) }}</span>  
                                    </dd>
        
                                    @if ( $maklumats->kosSebenar && $maklumats->id_status == 9)
                                        <dt class="col-sm-2">Kos Lulus</dt>
                                        <dd class="col-sm-4">
                                            <span class="badge badge-success text-white"> RM {{ number_format($maklumats->kosSebenar, 2) }}</span>  
                                        </dd>
                                        {{-- <dd class="col-sm-4">RM {{ $maklumats->kosSebenar }}</dd> --}}
                                    @else
                                        <dt class="col-sm-2"></dt>
                                        <dd class="col-sm-4"></dd>
                                    @endif
        
                                    <dt class="col-sm-2"></dt>
                                    <dd class="col-sm-10"><br></dd>
        
                                <dt class="col-sm-2">Jenis Peruntukan</dt>
                                <dd class="col-sm-4">{{ ($maklumats->id_jenis_peruntukan!='') ? \App\LkpJenisPeruntukan::find($maklumats->id_jenis_peruntukan)->jenis_perbelanjaan : '' }}</dd>
        
                                <dt class="col-sm-2">Punca Peruntukan</dt>
                                    @if ( !empty($maklumats->id_jenis_perbelanjaan) )
                                        <dd class="col-sm-4">
                                            @if ( $maklumats->id_jenis_perbelanjaan == 'B14')
                                                {{ $maklumats->id_jenis_perbelanjaan }} (KPN)
                                            @else
                                                {{ $maklumats->id_jenis_perbelanjaan }} (Kementerian)
                                            @endif
                                            {{-- {{ ($maklumats->id_jenis_perbelanjaan!='') ? \App\LkpVot::find($maklumats->id_jenis_perbelanjaan)->noVot : '' }}  --}}
                                            {{-- ({{ ($maklumats->id_jenis_perbelanjaan!='') ? \App\LkpVot::find($maklumats->id_jenis_perbelanjaan)->namaVot : '' }}) --}}
                                        </dd>
                                    @else
                                        <dd class="col-sm-4"> - </dd>
                                    @endif
        
                                <dt class="col-sm-2">Tarikh Mula</dt>
                                <dd class="col-sm-4">
                                    {{ Carbon\Carbon::parse($maklumats->tkhCadangMula)->format('d.m.Y') }}
                                    <?php
                                        \Carbon\Carbon::setLocale('ms');
                                        echo '('.\Carbon\Carbon::parse($maklumats->tkhCadangMula)->dayName.')'; 
                                    ?>
                                </dd>
                                
                                <dt class="col-sm-2">Tarikh Tamat</dt>
                                <dd class="col-sm-4">
                                    {{ Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->format('d.m.Y') }}
                                    <?php
                                        \Carbon\Carbon::setLocale('ms');
                                        echo '('.\Carbon\Carbon::parse($maklumats->tkhCadangAkhir)->dayName.')'; 
                                    ?>
                                </dd>
                                                            
                                <dt class="col-sm-2">Status Perancangan</dt>
                                @if ( $maklumats->perancangan == 1 )
                                    <dd class="col-sm-4">Dalam Perancangan Perolehan Tahunan</dd>
                                @elseif ( $maklumats->perancangan == 2 ) 
                                    <dd class="col-sm-4">Tiada Dalam Perancangan Perolehan Tahunan</dd>
                                @else
                                    <dd class="col-sm-4"> - </dd>
                                @endif

                                <dt class="col-sm-2">No. Rujukan fail</dt>
                                <dd class="col-sm-4">{{ optional($maklumats)->rujukan_fail ?? '-' }}</dd>
        
                                {{-- <dt class="col-sm-2">Syor</dt>
                                <dd class="col-sm-10 justify-text line-spacing">{{ $maklumats->syor ?? '-'}}</dd>
                                <br> --}}
        
                                {{-- <dt class="col-sm-2"> &nbsp;</dt> --}}
                                {{-- <dd class="col-sm-10"> &nbsp;</dd> --}}
                                
                                @if ( !empty($maklumats->doc_Sokongan) )
                                    <dt class="col-sm-2">Dokumen Tambahan </dt>
                                    <dd class="col-sm-10"> 
                                        {{-- <a href="{{ asset( $maklumats->doc_Sokongan) }}" target="_blank"> <i class="fa fa-paperclip"></i>  Klik untuk lihat  </a>  --}}
                                        @if (App::environment('local'))
                                            <a href="{{ Storage::url($maklumats->doc_Sokongan) }}" target="_blank">
                                                <i class="fa fa-paperclip"></i> Klik untuk lihat
                                            </a>
                                        @else
                                            <a href="/ePantas{{ Storage::url($maklumats->doc_Sokongan) }}" target="_blank">
                                                <i class="fa fa-paperclip"></i> Klik untuk lihat
                                            </a>
                                        @endif
                                    </dd>	
                                @else
                                    <dd class="col-sm-10"> </dd>
                                @endif
                                
                            </dl>
    
                            {{-- @if ( $maklumats->id_status == 9 || $maklumats->id_status == 10 || $maklumats->id_status == 11 || $maklumats->id_status == 8) --}}
                            @if ( $maklumats->id_status != 1 && $maklumats->id_status != 12 )
    
                                {{-- <hr> --}}
    
                                {{-- <dl class="row">
                                    <dt class="col-sm-4" align="justify"><u><h5 style="color: black;">Status Permohonan </h5></u> </dt>
                                </dl> --}}
                                <dl class="row">
                                    {{-- <dt class="col-sm-2">Status</dt>
                                    <dd class="col-sm-10"> {{ ($maklumats->id_status!='') ? \App\LkpStatus::find($maklumats->id_status)->status : '' }}</dd> --}}
    
                                    {{-- @if ( $maklumats->id_status != 8 )
                                        <dt class="col-sm-2">Pegawai Pelulus</dt>
                                        <dd class="col-sm-10"> {{ ($tindakan->UpdatedBy!='') ? \App\PPersonel::find($tindakan->UpdatedBy)->name : '' }}</dd>
                                    @endif --}}
                                        
                                    {{-- JIKA BATAL --}}
                                    @if ($maklumats->id_status == 8)
                                        <dt class="col-sm-2">Alasan Pembatalan</dt>
                                        <dd class="col-sm-10"> {{ $tindakan->Ulasan }}</dd>
                                    @else
                                    @endif
                                    {{-- JIKA BATAL --}}
    
                                    {{-- TAK PERLU KOT --}}
                                    {{-- @if ( $votByAdmins->isNotEmpty() ) 
                                        <dt class="col-sm-12">No. Vot</dt>
                                        <dt class="col-sm-12">
                                            <table class="table table-bordered table-sm">
                                                <thead bgcolor ="#A7C7E7">
                                                    <tr>
                                                        <th>Bil. </th>
                                                        <th>Objek Am</th>
                                                        <th>Objek Sebagai</th>
                                                        <th>Kos(RM)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($votByAdmins as $votByAdmin)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td> {{ ($votByAdmin->objekAm!='') ? \App\LkpVot::find($votByAdmin->objekAm)->noVot : '' }}, 
                                                        {{ ($votByAdmin->objekAm!='') ? \App\LkpVot::find($votByAdmin->objekAm)->namaVot : '' }}
                                                    </td>
                                                    @if ($votByAdmin->objekSebagai)
                                                        <td> {{ $votByAdmin->objekSebagai }} , {{ ($votByAdmin->objekSebagai!='') ? \App\LkpObjek::find($votByAdmin->objekSebagai)->jenisPerbelanjaan : '' }}</td>
                                                    @else
                                                        <td>  </td>
                                                    @endif
                                                    <td>RM {{ $votByAdmin->kos }}<br/></td>
                                                    <?php
                                                        $status = $votByAdmin->id_Status;
                                                        $color = "";
                                                        switch($status){
                                                            //permohonan baru
                                                            case "1": $color="#FFB300"; $status="Permohonan Baru"; break; //kuning
                                                            //telah dikemaskini
                                                            case "2": $color="#FFB300"; $status="Dikemaskini"; break; //biru
                                                            //lulus
                                                            case "9":  $color="#32CD32"; $status="Lulus"; break; //hijau
                                                            //gagal
                                                            case "10": $color="#FF0000"; $status="Tidak Diluluskan"; break; //merah
                                                            //semak semula
                                                            case "11": $color="#2C87F0"; $status="Semak Semula"; break; //biru
                                                            //batal
                                                            case "8": $color="#CC3300"; $status="Batal"; break; //merah pekat
                                                            //sah
                                                            case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                                                            default : $color="#000000";
                                                        }
                                                    ?>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </dt>
                                        
                                    @else
                                    @endif --}}
                                    
                                    {{-- @if($maklumats->id_status == 9)
                                    <dt class="col-sm-2">Pengesahan</dt>
                                    <dd class="col-sm-10"> <a href="{{ url("/peruntukan/pengesahan/" . $maklumats->idMaklumatPermohonan) }}" class="badge badge-md badge-dark">Cetak Pengesahan</a> </dd> 
                                    @endif --}}
                                </dl>
                                
                                {{-- <hr style="border-top: 1px solid black;"> --}}
                                {{-- <hr> --}}
    
                                @if ( $tindakanLists->isNotEmpty() )
                                    <dl class="row">
                                        <dt class="col-sm-12" align="justify"><u><h5 style="color: black;">Log Tindakan </h5></u> </dt>
                                        <dt class="col-sm-12" align="justify"> 
                                            <table class="table table-bordered table-sm">
                                                <thead bgcolor ="#A7C7E7">
                                                    <tr>
                                                        <th>Bil.</th>
                                                        <th>Tindakan Oleh</th>
                                                        <th>Ulasan</th>
                                                        <th>Tarikh</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($tindakanLists as $tindakanList)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <?php
                                                        $status = $tindakanList->id_status;
                                                        $color = "";
                                                        switch($status){
                                                            //permohonan baru
                                                            case "1": $color="#FFB300"; $status="Permohonan Baru"; break; //kuning
                                                            //telah dikemaskini
                                                            case "2": $color="#FFB300"; $status="Dikemaskini"; break; //biru
                                                            //lulus
                                                            case "9":  $color="#32CD32"; $status="Lulus"; break; //hijau
                                                            //gagal
                                                            case "10": $color="#FF0000"; $status="Tidak Diluluskan"; break; //merah
                                                            //semak semula
                                                            case "11": $color="#FFB300"; $status="Semak Semula"; break; //SEMAK SEMULA PENGESAH
                                                            case "22": $color="#FFB300"; $status="Semak Semula"; break; //SEMAK SEMULA PENTADBIR
                                                            //batal
                                                            case "8": $color="#CC3300"; $status="Batal"; break; //merah pekat
                                                            //sah
                                                            case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                                                            case '13':
                                                                $color = '#51A6F5';
                                                                $status = 'Ada Peruntukan';
                                                                break; //biru cair
                                                            case '14':
                                                                $color = '#CC3300';
                                                                $status = 'Tiada Peruntukan';
                                                                break; //merah pekat
                                                            case '15':
                                                                $color = '#51A6F5';
                                                                $status = 'Disokong';
                                                                break; //biru cair
                                                            case '16':
                                                                $color = '#CC3300';
                                                                $status = 'Tidak Disokong';
                                                                break; //merah pekat
                                                            case '17':
                                                                $color = '#51A6F5';
                                                                $status = 'Disyorkan';
                                                                break; //biru cair SUBK
                                                            case '18':
                                                                $color = '#CC3300';
                                                                $status = 'Tidak Disyorkan';
                                                                break; //merah pekat SUBK
                                                            case '19':
                                                                $color = '#51A6F5';
                                                                $status = 'Disyorkan';
                                                                break; //merah pekat
                                                            case "20": $color="#5D78FF"; $status="Dikemaskini"; break; //Dikemaskini Pengesah
                                                            case "21": $color="#5D78FF"; $status="Dikemaskini"; break; //Dikemaskini Pentadbir
                                                            //Banyak Banyak
                                                            default : $color="#000000";
                                                        }
                                                    ?>
                                                    {{-- <td style="color: {{ $color }}">{{ $status }}<br/></td> --}}
                                                    {{-- @php
                                                        $name = null;
                                                        foreach ($personels as $personel) {
                                                            if($personel->nokp == $tindakan1->peg_penyelia) {
                                                                $name = $personel->name;
                                                            }
                                                        }
                                                    @endphp --}}
                                                    {{-- <td> {{ ($tindakanList->UpdatedBy!='') ? \App\PPersonel::find($tindakanList->UpdatedBy)->name : '' }}</td> --}}
                                                    <td style="text-align: left; font-weight: normal;"> 
                                                        {{-- {{ ($disyor->UpdatedBy!='') ? \App\User::find($disyor->UpdatedBy)->nama : '' }} 
                                                        ({{ ($disyor->UpdatedBy!='') ? \App\User::find($disyor->UpdatedBy)->id_access : '' }}) --}}
                                                        {{ ($tindakanList->UpdatedBy!='') ? \App\User::find($tindakanList->UpdatedBy)->nama : '' }} 
                                                        ({{ ($tindakanList->UpdatedBy!='') ? \App\User::find($tindakanList->UpdatedBy)->id_access : '' }})
                                                    </td>
                                                    <td style="font-weight: normal"> {{ $tindakanList->Ulasan ?? '-'}} </td>
                                                    <td style="font-weight: normal">{{ Carbon\Carbon::parse($tindakanList->CreatedAt)->format('d/m/Y, h:i a') }}</td>
                                                    <td style="color: {{ $color }}">{{ $status }}<br/>
                                                    
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </dt>
                                    </dl>
                                @endif
                            @else
                            @endif

                            @if ( $maklumats->id_status != 12 )
                                <dl class="row">
                                    <dt class="col-sm-10"><br> Alasan Pembatalan: <font color="red">*</font>
                                        <textarea class="form-control" 
                                            name="catatanBatal" id="catatanBatal" cols="2" rows="1" placeholder="" maxlength="100"></textarea>
                                        @error('catatanBatal') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                    </dt>
                                    <dd class="col-sm-10"></dd>
                                </dl> 
                            @endif
    
                            <hr>
                            <div class=" justify-content-center">
                                {{-- <a href="{{ url('/peruntukan/simpan/batal/'. $maklumats->idMaklumatPermohonan ) }}" id="batal" class="btn btn-danger float-left btn-sm"><i
                                        class="fa fa-trash"></i> |
                                        Anda Pasti Ingin Membatalkan Permohonan Ini?
                                </a> --}}
                                @if ( $maklumats->id_status != 12 )
                                    <button type="submit" name="batal_tempahan" class="btn btn-danger float-right"><i class="fa fa-trash"></i>
                                        Anda Pasti Ingin Membatalkan Permohonan Ini?
                                    </button>
                                @else
                                    <button type="submit" name="batal_tempahan" class="btn btn-danger float-right"><i class="fa fa-times"></i>
                                        Anda Pasti Ingin Menghapuskan Permohonan Ini?
                                    </button>
                                @endif

                                {{-- <button type="button" class="btn btn-default float-right"
                                    onclick="history.back();"><i class="fas fa-redo-alt"></i> | Tidak</button> --}}
                                <a href="{{ url('pemohon/menu/' . $user->id) }}" class="btn btn-default float-right" style="color: black;">
                                    <i class="fas fa-redo-alt"></i> | Kembali
                                </a>
                            
                                <br><br>
                            </div>

                        </div>
                    </form>
                </div> <!--card-body -->

            </div>

 

    </div>
    <!--**********************************
                        Content body end
                    ***********************************-->
    @if($errors->has('catatanBatal'))
        <script>
            document.getElementById("catatanBatal").focus();
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const catatanBatalElement = document.getElementById("catatanBatal");
            if (catatanBatalElement) {
                catatanBatalElement.focus();
            }
        });
    </script>
    

@endsection
