@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                Content body start
            ***********************************-->
    <div class="content-body">
        <div class="container-fluid">

            <div class="col-xl-13 col-lg-12">
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
            </div>
    


            <div class="col-xl-13 col-lg-12">
                <div class="card">
                    {{-- <div class="card-header"> --}}
                    <div class="card-header" style="background-color: rgb(175, 175, 252)">
                    
                        <h4 class="card-title">Pendaftaran Perancangan Perolehan Tahunan</h4>
                    </div>
                    {{-- <div class="card-body">
                        <div class="basic-form">
                            
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="basic-form">
                            {{-- <form> --}}
                                <form method="POST" action="{{ route('peruntukan.pilih_ppt') }}">
                                    {{ csrf_field() }}
                                    <div class="form-row">
    
                                        <div class="input-group mb-4">
                                            <label for="nama" class="col-sm-2 col-form-label" style="text-align:left">
                                                Cari Nama Pendaftar:  
                                            </label>
                                            <div class="col-sm-4">
                                                <select class="select2" id="nama_pendaftar" name="nama_pendaftar" style="width: 100%; text-align:left">
                                                    <option value=""
                                                        @if (old('nama_pendaftar') == '') {{ 'selected="selected"' }} @else {{ old('nama_pendaftar') }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($personels as $personel)
                                                        {{-- <option value="{{ $personel->id }}"> --}}
                                                        <option value="{{ $personel->nokp }}">
                                                            {{ $personel->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" name="cari_nama" id="cari_nama" class="btn btn-primary float-right btn-sm">
                                                <i class="fa fa-search" aria-hidden="true"></i> | Cari
                                            </button>
                                        </div>
    
                                        <div class="input-group mb-4">
                                            <label for="nama" class="col-sm-2 col-form-label" style="text-align:left">
                                                Nama:  
                                            </label>
                                            <div class="col-sm-4">
                                                {{-- <input type="text" class="form-control" readonly value="{{ $personel->gred }}"> --}}
                                                <input type="text" class="form-control" name="nama" id="nama" readonly value="{{ old('nama') }}">
                                                <input type="hidden" class="form-control" name="nokp" id="nokp" readonly value="{{ old('nokp') }}">
                                            </div>                                           
                                        </div>

                                        <div class="input-group mb-4">
                                            <label for="nama" class="col-sm-2 col-form-label" style="text-align:left">
                                                Gred:  
                                            </label>
                                            <div class="col-sm-4">
                                                {{-- <input type="text" class="form-control" readonly value="{{ $personel->gred }}"> --}}
                                                <input type="text" class="form-control" name="gred" id="gred" readonly value="{{ old('gred') }}">
                                            </div>                                           
                                        </div>

                                        <div class="input-group mb-4">
                                            <label for="bahagian" class="col-sm-2 col-form-label" style="text-align:left">
                                                Bahagian 
                                                <font color="red">*</font>
                                            </label>
                                            <div class="col-sm-4">
                                                 {{-- <select class="select2-with-label-single js-states d-block" id="bahagian" name="bahagian"
                                                    style="width:100%; text-align:left;" required>
                                                    <option value=""
                                                        @if (old('bahagian') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($OptBahagian as $optB)
                                                        <option value="{{ $optB->id }}"
                                                            @if (old('bahagian') == $optB->id) {{ 'selected="selected"' }} @endif>
                                                            {{ $optB->bahagian }}
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                                {{-- <input type="text" class="form-control" readonly 
                                                    value="{{ $personel->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : '' }}">
                                                <input type="hidden" name="bahagian" value="{{ $personel->bahagian_id }}"> --}}
                                                <input type="text" class="form-control" name="bahagian" id="bahagian" readonly value="{{ old('bahagian') }}">
                                                <input type="hidden" class="form-control" name="bahagian_id" id="bahagian_id" readonly value="{{ old('bahagian_id') }}">
                                                {{-- <input type="hidden" name="bahagian" value=""> --}}
                                            </div>
                                        </div>
    
                                        <div class="input-group mb-4">
                                            <label for="tahun" class="col-sm-2 col-form-label" style="text-align:left">
                                                Tahun 
                                                <font color="red">*</font>
                                            </label>
                                            <div class="col-sm-4">
                                                {{-- <input class="form-control" name="tahun" type="number" min="2000" max="2099" maxlength="4" step="1" value="{{ date('Y') }}" /> --}}
                                                <input class="form-control" id="tahun" name="tahun" type="number" min="2000" max="2099" maxlength="4" step="1" value="" />
                                            </div>
                                        </div>
                                            
                                    </div>
    
                                    <button type="submit" name="pilih_PPT" class="btn btn-primary float-right btn-sm"><i class="fa fa-arrow-right" aria-hidden="true"></i> | Seterusnya</button>
                                    
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
@endsection

@section('script')

        <script type="text/javascript">
           $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();

                $('#tkh_mula').datetimepicker({
                    format: 'DD.MM.YYYY'
                });

                $('#tkh_tamat').datetimepicker({
                    format: 'DD.MM.YYYY'
                });
            });
        </script>

@endsection
