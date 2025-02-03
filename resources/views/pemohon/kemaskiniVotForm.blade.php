@extends('layouts.master')
@section('content')

    <!--**********************************
            Content body start
        ***********************************-->

    <style>
        @media (max-width: 768px) {
            #arahan {
                display: none;
            }
        }
    </style>

    <div class="content-body">

        <div class="col-xl-13 col-lg-13">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>	
                {{-- <i class="fa fa-check" aria-hidden="true"></i> --}}
                {{ session('status') }}
            </div>
            @elseif(session('failed'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> --}}
                {{ session('failed') }}
            </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> --}}
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h4>Kemaskini Vot</h4> --}}
                        <h3 class="font-w600 title mb-2 mr-auto">Perincian Perbelanjaan</h3>
                        <font color="red" name="arahan" id="arahan"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp; Sila pastikan semua yang bertanda * diisi.</font> &nbsp;

                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pemohon.kemaskiniVotFormS', $vot->idVotByAdmin) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="perkara" class="col-sm-3 col-form-label"
                                        style="text-align:left">
                                            Perkara
                                        <font color="red">*</font>
                                    </label>
                                    <div class="col-sm-9">
                                        {{-- <input type="text" class="form-control" name="perkaraK" id="perkaraK" maxlength="50" value="{{ old('perkaraK') ?? ($vot->perkara!='') ? \App\LkpPerkara::find($vot->objekAm)->perkara : '' }}"> --}}
                                        <select class="select2 perkara" id="perkaraK" name="perkaraK"
                                            style="width: 100%; text-align:left; height:41px;">
                                            @php old('perkaraK') == NULL ? $votPerkara = $vot->perkara : $votPerkara=old('perkaraK') @endphp
                                            <option value=""
                                                @if (old('perkaraK') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                            </option>
                                            @foreach ($lkpPerkaras as $lkpPerkara)
                                                <option value="{{ $lkpPerkara->id_lkp_perkara }}"
                                                    {{-- @if ( ($votPerkara == $lkpPerkara->id_lkp_perkara) == $lkpPerkara->id_lkp_perkara) {{ 'selected="selected"' }} @endif> --}}
                                                    @if ( $votPerkara == $lkpPerkara->id_lkp_perkara) {{ 'selected="selected"' }} @endif>
                                                    {{ $lkpPerkara->perkara }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="objekAm" class="col-sm-3 col-form-label"
                                        style="text-align:left">
                                        Objek Am <font color="red">*</font>
                                    </label>
                                    <div class="col-sm-9">
                                        <select class="select2-K" id="objekAmK" name="objekAmK"
                                            style="width: 100%; text-align:left;">
                                            @php old('objekAmK') == NULL ? $votAm = $vot->objekAm : $votAm=old('objekAmK') @endphp
                                            <option value=""
                                                {{-- @if (old('objekAmK') == '') {{ 'selected="selected"' }} @endif>&nbsp; --}}
                                                @if ($vot->objekAm == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                            </option>
                                            @foreach ($objekAms as $objekAm)
                                                {{-- <option value="{{ $objekAm->idVot }}" --}}
                                                {{-- <option value="{{ $objekAm->noVot }}" title="{{ $objekAm->namaVot }}" --}}
                                                <option value="{{ $objekAm->id_lkp_oa }}"
                                                    @if ($votAm == $objekAm->id_lkp_oa) {{ 'selected="selected"' }} @endif>
                                                    {{ $objekAm->oa }} 
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- <select class="select2-K" id="objekAmK" name="objekAmK"
                                            style="width: 100%; text-align:left;">
                                            @php old('objekAmK') == NULL ? $votAm = $vot->objekAm : $votAm=old('objekAmK') @endphp
                                            <option value=""
                                                @if ($vot->objekAm == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                            </option>
                                            @foreach ($objekAms as $objekAm)
                                                <option value="{{ $objekAm->idVot }}" title="{{ $objekAm->noVot }}"
                                                    @if ($votAm == $objekAm->idVot) {{ 'selected="selected"' }} @endif>
                                                    {{ $objekAm->noVot }}, {{ $objekAm->namaVot }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="objekSeb" class="col-sm-3 col-form-label"
                                        style="text-align:left">
                                        Objek Sebagai 
                                        {{-- <font color="red">*</font> --}}
                                    </label>
                                    <div class="col-sm-9">
                                        {{-- <input type="hidden" name="objekSebValue" id="objekSebValue" value="{{ $vot->objekSebagai }}"> --}}
                                        <select class="select2-K" id="objekSebK" name="objekSebK"
                                            style="width: 100%; text-align:left;">
                                            @php old('objekSebK') == NULL ? $votSeb = $vot->objekSebagai : $votSeb=old('objekSebK') @endphp
                                            <option value=""
                                                @if ($vot->objekSebagai == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                            </option>
                                            @foreach ($objekSebs as $objekSeb)
                                                <option value="{{ $objekSeb->id_lkp_os }}"
                                                    @if ($votSeb == $objekSeb->id_lkp_os) {{ 'selected="selected"' }} @endif>
                                                    {{ $objekSeb->os }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="hidden" name="objekSebValue" id="objekSebValue" value="{{ $vot->objekSebagai }}">
                                        <select class="select2-K" id="objekSebK" name="objekSebK"
                                            style="width: 100%;">
                                            <option value=""
                                                @if (old('objekSebK') == '') {{ 'selected="selected"' }} @endif>
                                                &nbsp;</option>
                                            <option value="" selected disabled> -- Sila Pilih Objek Am -- </option>
                                        </select> --}}
                                        {{-- <br><small> <font color="red"> (Nota: Isi ruangan ini jika Objek Am mempunyai Objek Sebagai.) </font> </small> --}}

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lain" class="col-sm-3 col-form-label"
                                        style="text-align:left"> Nyatakan jika lain-lain
                                        {{-- <font color="red">*</font> --}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="lainK" id="lainK" value="{{ old('lainK') ?? $vot->keterangan }}">
                                        <small> <font color="red"> (Nota: Isi ruangan ini hanya jika perkara tidak terdapat di pilihan.) </font> </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="unit" class="col-sm-3 col-form-label"
                                        style="text-align:left"> Unit/Bilangan
                                        {{-- <font color="red">*</font> --}}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" name="unitK" id="unitK" value="{{ old('unitK') ?? $vot->unit }}">
                                        <small> <font color="red"> (Nota: Ruangan ini tidak wajib diisi.) </font> </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="kos" class="col-sm-3 col-form-label"
                                        style="text-align:left"> Anggaran Kos
                                        <font color="red">*</font>
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group input-secondary">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="number" class="form-control" step="0.01" name="kosK" id="kosK" value="{{ old('kosK') ?? $vot->kos}}">
                                        </div>
                                    </div>
                                </div>

                                <div class=" justify-content-center">
                                    <br>
                                    <br>

                                    <a href="{{ url('pemohon/kemaskini/vot/' . $vot->idMaklumatPermohonan) }}"
                                        class="btn btn-secondary float-left btn-sm" style="color: black;">
                                        <i class="fas fa-redo-alt"></i> | Kembali
                                    </a>
                                    <button type="submit" class="btn btn-success btn-sm float-right" name="simpan_vot" id="simpan_vot">
                                        <i class="fa fa-save"></i>
                                        Simpan
                                    </button>
                                </div>
                                
                        </form>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
                            Content body end
                        ***********************************-->
@endsection

@section('script')

        <script type="text/javascript">
           $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();
                // $('.select2-vot').select2();
                // $('.select2-prgn').select2({
                //     minimumResultsForSearch: Infinity
                // // });
                // $('.select2').select2({
                //     minimumResultsForSearch: Infinity
                // });
                $('.select2-K').select2({
                    minimumResultsForSearch: Infinity
                });
            });

        </script>

        <script type="text/javascript">

            // $(document).ready(function() {  //MODAL KEMASKINI VOT

            //      // Trigger the change event for #objekAm
            //     // $('#objekAm').trigger('change');

            //     $(document).on('change', '#objekAmK', function() {
            //         var objekAm = $(this).val();
            //         var div = $(this).parent().parent().parent();
            //         var op = " ";
            //         $.ajax({
            //             type: 'get',
            //             url: '{!! URL::to('cariObjek') !!}',
            //             data: {
            //                 'id': objekAm
            //             },
            //             success: function(data) {
            //                 console.log(div);
            //                 op += '<option value="" @if (old('objekSebK') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
            //                 for (var i = 0; i < data.length; i++) {
            //                     op += '<option value="' + data[i].idObjek + '">' + data[i].idObjek +
            //                         ', ' + data[i].jenisPerbelanjaan + '</option>';
            //                 }
            //                 div.find('#objekSebK').html(" ");
            //                 div.find('#objekSebK').append(op);
            //             },
            //             error: function() {}
            //         });
            //     });

            // });


            //IF ADE VALUE PERKARA DIM INPUT #LAIN, ELSE TAKDE VALUE X YAH DIM INPUT #LAIN
            function InputLainLain() {
                var perkara = $('#perkaraK').val();
                // Assuming the closest parent is modal-body
                // var div = $('#perkaraK').closest('.modal-body');

                if (perkara === null || perkara === '') {
                    console.log('true'); // true if the dropdown is empty
                    $('#lainK').prop('readonly', false); // Enable the input if the dropdown is empty
                        // Clear the selected value of #objekAm and trigger change event
                        $('#objekAmK').val('').trigger('change');
                        // Clear the selected value of #objekSeb and trigger change event
                        $('#objekSebK').val('').trigger('change');
                } else {
                    console.log('false'); // false if the dropdown is not empty
                    $('#lainK').prop('readonly', true); // Disable the input if the dropdown is not empty
                }
            }
            //IF ADE VALUE PERKARA DIM INPUT #LAIN, ELSE TAKDE VALUE X YAH DIM INPUT #LAIN

            // Function to fetch data and populate Objek Am & Objek Sebagai based on Perkara yang dipilih
            function populatePerkaraObjek() {
                    var perkara = $('#perkaraK').val();
                    // var objekAm = $('#objekAm').val();
                    // var objekSeb = $('#objekSeb').val();
                    // var objekSeb = $('#objekSebValue').val();
                    var op = " ";
                    $.ajax({
                        type: 'get',
                        url: '{!! URL::to('cariPerkara') !!}',
                        data: {
                            'id': perkara
                        },
                        success: function(data) {
                            // console.log(data.oa);
                            // console.log(data.os);

                            var op1 = '<option value="' + data.oa.id_lkp_oa + '" selected>' + data.oa.oa + '</option>';
                            var op2 = '<option value="' + data.os.id_lkp_os + '" selected>' + data.os.os + '</option>';

                            // div.find('#objekAm').html(" ");
                            // div.find('#objekSeb').html(" ");
                            $('#objekAmK').html(op1);
                            $('#objekSebK').html(op2);
                            // div.find('#objekAmK').append(op1);
                            // div.find('#objekSebK').append(op2);
                        },
                        error: function() {}
                    });
                }

                // Call the function when the value of Perkara changes
                $(document).on('change', '#perkaraK', function() {
                    populatePerkaraObjek();
                    InputLainLain();
                });
            // Function to fetch data and populate Objek Am & Objek Sebagai based on Perkara yang dipilih

            // Function to fetch data and populate objekSebK select element
            function populateObjekSebK() {
                var objekAm = $('#objekAmK').val();
                var objekSeb = $('#objekSebValue').val();
                var div = $('#objekAmK').parent().parent().parent();
                // var div = $(this).parent().parent().parent();
                // var div = $('#objekAmK').closest('.modal-body'); // Assuming the closest parent is modal-body
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('cariObjek') !!}',
                    data: {
                        'id': objekAm
                    },
                    success: function(data) {
                        op += '<option value="" @if (old('objekSebK') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
                        for (var i = 0; i < data.length; i++) {

                            if ( objekSeb == data[i].idObjek ) {
                                op += '<option value="' + data[i].idObjek + '" {{ 'selected="selected"' }}>' + data[i].idObjek +
                                ', ' + data[i].jenisPerbelanjaan + '</option>';
                            }
                            else {
                                op += '<option value="' + data[i].idObjek + '">' + data[i].idObjek +
                                ', ' + data[i].jenisPerbelanjaan + '</option>';
                            }

                            
                        }
                        div.find('#objekSebK').html(" ");
                        div.find('#objekSebK').append(op);
                    },
                    error: function() {}
                });
            }

            // Call the function when the page loads
            $(document).ready(function() {
                var perkara = $('#perkaraK').val();
                var objekAm = $('#objekAmK').val();
                var objekSeb = $('#objekSebK').val();

                if( perkara != '' ) {
                    // InputLainLain();
                    $('#lainK').prop('readonly', true); // Disable the input if the dropdown is not empty
                }
                // populateObjekSebK();
            });

            // Call the function when the value of objekAmK changes
            $(document).on('change', '#objekAmK', function() {
                // populateObjekSebK();
            });

            //Prevent From User Tekan ENTER Key
            document.addEventListener('DOMContentLoaded', function() {
                document.addEventListener('keydown', function(e) {
                    // Disable form submission on Enter key press
                    if (e.key === 'Enter') {
                        e.preventDefault();
                    }
                });
            });
        </script>

@endsection
