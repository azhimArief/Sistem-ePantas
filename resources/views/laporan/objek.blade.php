@extends('layouts.masterAdmin')
@section('content')
    <style>
        /* table {
                                        width: 40%;
                                        margin: auto;
                                    } */
        td,
        /* th {
                    border: 1px solid #000000;
                    text-align: center;
                    padding: 10px;
                } */

        /* span {
                    text-align: right;
                } */

        /* Custom styles for DataTables page buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px; /* Adjust padding as needed */
            margin: 0 2px; /* Adjust margin as needed */
            border: 1px solid #ccc; /* Add border if desired */
            background-color: #f5f5f5; /* Background color */
            color: #333; /* Text color */
            cursor: pointer;
            user-select: none;
        }

        /* Custom styles for the active page button */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007bff; /* Active button background color */
            color: #fff; /* Active button text color */
            border: 1px solid #007bff; /* Active button border color */
        }
    </style>
    <!--**********************************
                                                Content body start
                                            ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session('status') }}
                        </div>
                    @elseif(session('failed'))
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session('failed') }}
                        </div>
                    @endif
                    <!-- Horizontal Form -->
                    <form class="form-horizontal" method="POST" action="{{ route('laporan.perbelanjaan_objek') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="font-w600 title mb-2 mr-auto ">Laporan Perbelanjaan Objek</h3>
                                {{-- <h2 class="card-title">Laporan Perbelanjaan Objek</h2> --}}
                            </div>

                            <div class="card-body">
                                {{-- <div class="form-group row">

                                    <div class="col-sm-4">
                                        <label for="status" class="col-form-label">Status Permohonan : </label>
                                        <select class="select2" id="status" name="status">
                                            <option value=""
                                                @if ($search['status'] == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                            </option>
                                            @foreach ($optStatus as $optStatuss)
                                                <option value="{{ $optStatuss->id_status }}"
                                                    @if ($search['status'] == $optStatuss->id_status) {{ 'selected="selected"' }} @endif>
                                                    {{ $optStatuss->status }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="bahagian" class="col-form-label">Bahagian : </label>
                                        <select class="select2" id="bahagian" name="bahagian">
                                            <option value=""
                                                @if ($search['bahagian'] == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                            </option>
                                            @foreach ($optBahagians as $optBahagian)
                                                <option value="{{ $optBahagian->bahagian }}"
                                                    @if ($search['bahagian'] == $optBahagian->bahagian) {{ 'selected="selected"' }} @endif>
                                                    {{ $optBahagian->bahagian }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="bahagian" class="col-form-label">Punca Peruntukan : </label>
                                        <select class="select2-punca" id="punca" name="punca" style="width: 100%; text-align:left">
                                            <option value=""@if  ( $search['punca'] == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                            <option value="B14" {{ $search['punca'] == 'B14' ? 'selected' : '' }}>B14 - Kementerian Perpaduan Negara </option>
                                            <option value="B11" {{ $search['punca'] == 'B11' ? 'selected' : '' }}>B11 - Kementerian Kewangan</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="vot" class="col-form-label">Vot : </label>
                                        <select class="select2" id="vot" name="vot">
                                            <option value=""
                                                @if ($search['vot'] == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                            </option>
                                            @foreach ($optObjekAms as $optObjekAm)
                                                <option value="{{ $optObjekAm->id_lkp_oa }}"
                                                    @if ($search['vot'] == $optObjekAm->id_lkp_oa) {{ 'selected="selected"' }} @endif>
                                                    {{ $optObjekAm->oa }}
                                                </option>
                                            @endforeach
                                            {{-- @foreach ($optObjekAms as $optObjekAm)
                                                <option value="{{ $optObjekAm->idVot }}"
                                                    @if ($search['vot'] == $optObjekAm->idVot) {{ 'selected="selected"' }} @endif>
                                                    {{ $optObjekAm->noVot }} {{ $optObjekAm->namaVot }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="tkhMula" class="col-form-label">Tarikh Mula : </label>
                                        <input type="date" class="form-control" id="tkhMula" name="tkhMula" value="{{ $search['tkhMula'] }}" title="Tarikh Mula Program">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="tkhTamat" class="col-form-label">Tarikh Tamat :</label>
                                        <input type="date" class="form-control" id="tkhTamat" name="tkhTamat" value="{{ $search['tkhTamat'] }}" title="Tarikh Tamat Program">
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <P></P>
                                    <span class="float-right">
                                        <button type="submit" class="btn btn-info btn-sm" name="search_laporan"> 
                                            <i class="fa fa-search" aria-hidden="true"></i> | Carian
                                        </button>
                                        <a href="{{ url('/laporan/perbelanjaan_objek') }}" class="btn btn-default"
                                            name="search_laporan">Reset</a>
                                    </span>
                                </div>
                                
                                @if (isset($_POST['search_laporan']))
                                {{-- <div class="card"> --}}
    
                                    <div class="project-nav">
                                        <div class="col-sm-3" id="outside"> </div>
                                        {{-- <label class="col-sm-3 col-form-label">
                                            Tapis
                                            <select style="padding: 2px 10px; border-radius:0.35rem;" id="length_change">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>5</option>
                                                <option>100</option>
                                            </select> rekod.
                                        </label> --}}
                                        {{-- <div>
                                            <label class="col-form-label">
                                                Cari:
                                            </label>
                                            <div class="input-group search-area right d-lg-inline-flex">
                                                <input type="search" id="myInputTextField" class="form-control" placeholder="Cari rekod di sini...">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                            <i class="flaticon-381-search-2"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
    
                                    <div class="card-body table-responsive">
                                        {{-- <table id="example" class="table table-bordered table-striped"> --}}
                                        <table id="example" class="table table-bordered table-hover table-responsive-sm">
                                            {{-- <thead bgcolor ="#CF9FFF"> --}}
                                            <thead class="thead-primary">
                                                <tr>
                                                    {{-- <th>Bil.</th> --}}
                                                    <th>Vot / Objek Am</th>
                                                    {{-- <th>ID</th> --}}
                                                    <th>Objek Sebagai</th>
                                                    {{-- <th> Tarikh </th> --}}
                                                    <th>Kos Lulus</th>
                                                    <th>Kod Permohonan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($objekAmValues as $objekAmValue) --}}
                                                <?php
                                                    // $countMaklumats = count($maklumats);
                                                    // echo $countMaklumats;
                                                ?>
                                                @foreach ($objekAmValues as $objekAmValue)
                                                    <tr>
                                                        {{-- <td>{{ $loop->iteration }} .</td> --}}
                                                        @foreach ( $maklumats as $maklumat)
                                                            @if ( $maklumat->objekAm == $objekAmValue )
                                                                <td>
                                                                    {{-- {{ $objekAmValue }} -  --}}
                                                                    {{-- {{ $objekAmValue != '' ? \App\LkpVot::find($objekAmValue)->noVot : '-' }} --}}
                                                                    {{-- ({{ $objekAmValue != '' ? \App\LkpVot::find($objekAmValue)->namaVot : '-' }}) --}}
                                                                    {{ $objekAmValue != '' ? \App\LkpOA::find($objekAmValue)->oa : '-' }}
                                                                </td>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        <td>
                                                            {{-- @foreach ( $maklumats as $maklumat )
                                                                @if ( $maklumat->objekAm == $objekAmValue )
                                                                    @if ( $maklumat->objekSebagai )
                                                                        {{ $maklumat->objekSebagai }} 
                                                                        ({{ $maklumat->objekSebagai != '' ? \App\LkpObjek::find($maklumat->objekSebagai)->jenisPerbelanjaan : '-' }})
                                                                        <br>
                                                                    @else
                                                                        - <br>
                                                                    @endif
                                                                @endif
                                                            @endforeach --}}
                                                            @foreach ($maklumats as $maklumat)
                                                                @if ($maklumat->objekAm == $objekAmValue)
                                                                    @if ($maklumat->objekSebagai)
                                                                        <div style="display: block;">
                                                                            {{-- {{ $maklumat->objekSebagai }} --}}
                                                                            {{ $maklumat->objekSebagai != '' ? \App\LkpOS::find($maklumat->objekSebagai)->os : '-' }}
                                                                            {{-- ({{ $maklumat->objekSebagai != '' ? \App\LkpObjek::find($maklumat->objekSebagai)->jenisPerbelanjaan : '-' }}) --}}
                                                                        </div>
                                                                    @else
                                                                        <div style="display: block;">-</div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        {{-- TEST Tngok Tarikh
                                                        <td>
                                                            @foreach ( $maklumats as $maklumat )
                                                                @if ( $maklumat->objekAm == $objekAmValue)
                                                                    {{ $maklumat->tkhCadangMula }}->{{ $maklumat->tkhCadangAkhir }} <br>
                                                                @endif
                                                            @endforeach
                                                        </td> --}}
                                                        <td>
                                                            @foreach ( $maklumats as $maklumat )
                                                                @if ( $maklumat->objekAm == $objekAmValue)
                                                                    <div style="display: block;">
                                                                        RM {{ number_format($maklumat->kos, 2) }} <br>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ( $maklumats as $maklumat )
                                                                @if ( $maklumat->objekAm == $objekAmValue)
                                                                    <div style="display: block;">
                                                                        <a href="{{ url('peruntukan/butiran/' . $maklumat->idMaklumatPermohonan) }}"
                                                                            title="Butiran">{{ $maklumat->kod_permohonan }}
                                                                        </a> <br>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <!-- </form> -->
                                        </table>
                                    </div>
                                {{-- </div><!-- /.card --> --}}
                            @endif
                            </div>
                        </div>


                       
                    </form>
                </div><!--/.col (right) -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> {{-- content body --}}
    <!--**********************************
                                                Content body end
                                            ***********************************-->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
            $('.select2-punca').select2({
                 minimumResultsForSearch: Infinity
            });

            // $('#tkh_mula').datetimepicker({
            //     format: 'DD.MM.YYYY'
            // });

            // $('#tkh_tamat').datetimepicker({
            //     format: 'DD.MM.YYYY'
            // });
        });

        // $(document).ready(function() {
        //     $('#example').DataTable({
        //         "columnDefs": [
        //             { "type": "num", "targets": 0 }, // Assuming you want numeric sorting for the first column
        //         ],
        //         dom: 'Bfrtip',
        //         buttons: ['excel', 'pdf', 'print'],
        //         // searching: false,
        //         // "order": [[0, 'asc']], // Ordering by the first column in ascending order
        //         // "pageLength": 5,
        //         // "language": {
        //         //     // "lengthMenu": "Papar _MENU_ rekod per halaman",
        //         //     "zeroRecords": "Tiada Rekod Ditemui.",
        //         //     // "info": "Halaman _PAGE_ daripada _PAGES_",
        //         //     // "infoEmpty": "Tiada Rekod Ditemui",
        //         //     // "infoFiltered": "(ditapis daripada _MAX_ jumlah rekod)",
        //         //     "paginate": {
        //         //         "previous": "<",
        //         //         "next": ">",
        //         //         "first": "Awal",
        //         //         "last": "Akhir"
        //         //     }
        //         // }
        //     });
        // });

        $(document).ready(function(){

            var table = $('#example').DataTable({
                // "destroy": true, // Destroy existing DataTable instance

                "dom": 'tip',
                "columnDefs": [
                    { "type": "num", "targets": 0 }, // Assuming you want numeric sorting for the first column
                ],
                
                // "responsive": true,
                // "lengthChange": true,
                // "pagingType": "full_numbers",
                // "pageLength": 10,
                // "order": [[0, 'asc']], // Ordering by the first column in ascending order
                // "paging": true,
                // "order": [[0, 'asc']],
                "language": {
                    // "lengthMenu": "Papar _MENU_ rekod per halaman",
                    "zeroRecords": "Tiada Rekod Ditemui.",
                    // "info": "Halaman _PAGE_ daripada _PAGES_",
                    // "infoEmpty": "Tiada Rekod Ditemui",
                    // "infoFiltered": "(ditapis daripada _MAX_ jumlah rekod)",
                    "paginate": {
                        "previous": "<",
                        "next": ">",
                        "first": "Awal",
                        "last": "Akhir"
                    }
                },
                // "sPaginationType": "full_numbers",
                buttons:[
                    {
                        extend:    'excel',
                        text:      '<i class="fa fa-file-excel"></i><br>Excel',
                        titleAttr: 'Excel',
                        className: 'btn-success btn-sm'
                    },
                    {
                        extend:    'pdf',
                        text:      '<i class="fa fa-file-pdf"></i><br>PDF',
                        titleAttr: 'PDF',
                        className: 'btn-danger btn-sm'
                    },
                    {
                        extend:    'print',
                        text:      '<i class="fa fa-print"></i><br>Print',
                        titleAttr: 'Print',
                        className: 'btn-sm'
                    },
                ]

            });

            // $('#myInputTextField').keyup(function(){
            //     table.search($(this).val()).draw() ;
            // });
            // $('#length_change').val(table.page.len());
            // $('#length_change').change( function() {
            //     table.page.len( $(this).val() ).draw();
            // });
            table.buttons().container().appendTo("#outside");
            // let paginate = document.querySelector("#example_paginate");
            // paginate.classList.remove("dataTables_paginate");
        });

    </script>
@endsection
