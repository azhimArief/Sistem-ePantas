@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                Content body start
            ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="col-xl-13 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Perbelanjaan Peruntukan</h4>
                    </div>
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                    <div class="card-body">
                        <div class="basic-form">
                            <form role="form" method="POST" action="{{ url('/pemohon/tempahankenderaan/simpan') }}" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <textarea class="form-control" style="display:none;" id="maklumat_peruntukan" name="maklumat_peruntukan">{{ old('maklumat_peruntukan') }}</textarea>
                                    <table id="example1" class="table table-sm table-responsive-sm table-bordered table-striped" style="width:100%; ">
                                        <thead class="thead-primary" >
                                            <tr>
                                                <th><center>Bil.</center> </th>
                                                <th><center>Bahagian</center></th>
                                                <th><center>Butiran</center></th>
                                                {{-- <th>Program</th> --}}
                                                <th><center>Peruntukan (RM)</center></th>
                                                <th><center>Tanggungan (RM)</center></th>
                                                <th><center>Belanja (RM)</center></th>
                                                <th width="10%">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="senP"></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" align="center"><a class="btn btn-sm btn-primary" style='color:white;' data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td>
                                            {{-- <td colspan="7" align="center"><a class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Maklumat Peruntukan</a></td> --}}
                                        </tr>
                                    <!-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah </a> -->
                                    </tfoot>
                                    </table>
                                </div>

                                {{-- MODAL --}}
                                <div class="modal fade" id="modal-default">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header bg-purple">
                                            <h4 class="modal-title">TAMBAH PERBELANJAAN PERUNTUKAN</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="myForm">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label for="agensi" class="col-sm-3 col-form-label" style="text-align:left">Agensi <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-3">

                                                        <select class="form-control" id="agensi" name="agensi"
                                                            style="width: 100%; text-align:left">
                                                            <option value=""
                                                                @if (old('agensi') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                            </option>
                                                            @foreach ($agensis as $agensi)
                                                                <option value="{{ $agensi->id }}"
                                                                    @if (old('agensi') == $agensi->id) {{ 'selected="selected"' }} @endif>
                                                                    {{ $agensi->agensi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="tkh_mula" class="col-sm-3 col-form-label" style="text-align:left">Vot
                                                        <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" id="vot" name="vot"
                                                            style="width: 100%; text-align:left">
                                                            <option value=""
                                                                @if (old('vot') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                            </option>
                                                            @foreach ($vots as $Vot)
                                                                <option value="{{ $Vot->idVot }}"
                                                                    @if (old('vot') == $Vot->idVot) {{ 'selected="selected"' }} @endif>
                                                                    {{ $Vot->noVot }}, {{ $Vot->namaVot }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="peruntukan" class="col-sm-3 col-form-label" style="text-align:left">Peruntukan (RM)
                                                        <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="number" name="peruntukan" id="peruntukan" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="tanggungan" class="col-sm-3 col-form-label" style="text-align:left">Tanggungan (RM)
                                                        <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="number" name="tanggungan" id="tanggungan" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="belanja" class="col-sm-3 col-form-label" style="text-align:left">Belanja (RM)
                                                        <font color="red">*</font>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input type="number" name="belanja" id="belanja" class="form-control">
                                                    </div>
                                                </div>
                                
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                {{-- <button type="button" class="btn btn-light bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button> --}}
                                                <button type="button" class="btn btn-light bg-purple" id="addData" onclick="tambahAhli()" data-dismiss="modal">Tambah</button>
                                            </div>
                                        </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                {{-- MODAL --}}

                                <div class=" justify-content-center">
                                    {{-- <button type="submit" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                            class="fa fa-paper-plane"></i> |
                                            Hantar
                                    </button> --}}
                                    {{-- <a href="{{ url('/peruntukan/pengesahan') }}" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                            class="fa fa-paper-plane"></i> |
                                            Hantar
                                    </a> --}}
                                    <button type="button" class="btn btn-primary" id="addData">Hantar</button>
                                    <button type="button" class="btn btn-secondary float-right btn-sm"
                                        onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button>
                                </div>

                                {{-- <button type="submit" class="btn btn-primary">Hantar</button> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--**********************************
                Content body end
            ***********************************-->


    <!--**********************************
                Javascript section end
            ***********************************-->
    <script>
        $(function() {
            updateAhli();
        });
        function tambahAhli() {
            var maklumat_peruntukan = btoa('x|x' + $('#agensi').val() + 'x|x' + $('#vot').val() + 'x|x' + $('#peruntukan').val()
            + 'x|x' + $('#tanggungan').val() + 'x|x' + $('#belanja').val()) + '|x|x|';

            $('#maklumat_peruntukan').val($('#maklumat_peruntukan').val() + maklumat_peruntukan);

            updateAhli();
            $('#agensi').val('');
            $('#vot').val('');
            $('#peruntukan').val('');
            $('#tanggungan').val('');
            $('#belanja').val('');
        }

        function updateAhli() {
            var newSenP = '';
            var splitP = $('#maklumat_peruntukan').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                var bil = p + 1;
                var column = atob(splitP[p]).split('x|x');
                var agensi = column[1];
                var vot = column[2];
                var peruntukan = column[3];
                var tanggungan = column[4];
                var belanja = column[5];
                newSenP = newSenP + '<tr style="border: 1px solid #EEEEEE;"><td style="border: 1px solid #EEEEEE;text-align:center;">' + bil +'.</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + agensi + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + vot + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + peruntukan + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + tanggungan + '</td>' + '</td><td style="border: 1px solid #EEEEEE;text-align:center;">' 
                        + belanja + '</td>'
                    + '<td style="border: 1px solid #EEEEEE;text-align:center;"> <button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli' + p +
                    '" onclick="removeAhli(' + p + ');" title="' + splitP[p] +
                    '"><i class="fa fa-trash"></i></button></td></tr>';
            }
            $('#senP').html(newSenP);
        }

        function removeAhli(p1) {
            var maklumat_peruntukan = '';
            var splitP = $('#maklumat_peruntukan').val().split('|x|x|');
            for (var p = 0; p < splitP.length - 1; p++) {
                if (p1 != p) {
                    maklumat_peruntukan += splitP[p] + '|x|x|';
                }
            }
            $('#maklumat_peruntukan').val(maklumat_peruntukan);
            updateAhli();
        }
    </script>
        
@endsection

