@extends('layouts.master')
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
                    <div class="card-header">
                        <h4 class="card-title"> Senarai Perancangan Perolehan Tahunan</h4>
                    </div>
                    {{-- <div class="card-body">
                        <div class="basic-form">
                            
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="basic-form">
                            {{-- <form> --}}
                            <form method="POST" action="{{ route('pemohon.pilih_lihatSenarai' , $personel->nokp) }}">
                                {{ csrf_field() }}
                                <div class="form-row">
                                    
                                    {{-- <div class="input-group mb-4">
                                        <label for="jenis_belanja" class="col-sm-2 col-form-label" style="text-align:left">
                                            Jenis Belanja <font color="red">*</font>
                                        </label>
                                        <div class="col-sm-4">
                                            <select class="default-select" id="jenis_belanja" name="jenis_belanja"
                                            <select class="select2-with-label-single js-states d-block" name="jenis_belanja" id="jenis_belanja"
                                                style="width:100%; text-align:left;">
                                                <option value=""
                                                    @if (old('jenis_belanja') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                </option>
                                                @foreach ($OptjBelanje as $opt)
                                                    <option value="{{ $opt->idJenisBelanja }}"
                                                        @if (old('jenis_belanja') == $opt->idJenisBelanja) {{ 'selected="selected"' }} @endif>
                                                        {{ $opt->jenisBelanja }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>     
                                    </div> --}}

                                    <div class="input-group mb-4">
                                        <label for="nama" class="col-sm-2 col-form-label" style="text-align:left">
                                            Nama:  
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" readonly value="{{ $personel->name }}">
                                        </div>
                                        <label for="nama" class="col-sm-2 col-form-label" style="text-align:left">
                                            Gred:  
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" readonly value="{{ $personel->gred }}">
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
                                            <input type="text" class="form-control" readonly 
                                                value="{{ $personel->bahagian_id != '' ? \App\PLkpBahagian::find($personel->bahagian_id)->bahagian : '' }}">
                                            <input type="hidden" name="bahagian" value="{{ $personel->bahagian_id }}">
                                            {{-- <input type="hidden" name="bahagian" value="1"> --}}
                                        </div>                                           
                                    </div>

                                    <div class="input-group mb-4">
                                        <label for="tahun" class="col-sm-2 col-form-label" style="text-align:left">
                                            Tahun 
                                            <font color="red">*</font>
                                        </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" maxlength="4" name="tahun" type="number" min="2000" max="2099" step="1" placeholder="Masukkan Tahun Pilihan Anda"  required/>
                                        </div>
                                    </div>
                                        
                                </div>

                                <button type="submit" name="cariSenarai" class="btn btn-primary float-right btn-sm"><i class="fa fa-search" aria-hidden="true"></i> | Cari</button>
                                {{-- <button type="button" href="" class="btn btn-secondary float-right btn-sm" onclick="history.back();">
                                    <i class="fas fa-redo-alt"></i> | Kembali
                                </button> --}}
                                <a href="{{ url('/pemohon/menu_ppt/' . $personel->nokp) }}" class="btn btn-secondary float-left btn-sm" >
                                    <i class="fas fa-redo-alt"></i> | Kembali
                                </a>
           
                                
                                {{-- <a href="{{ url('/peruntukan/pilih_ppt') }}" name="pilih_PPT" id="pilih_PPT" class="btn btn-primary">Seterusnya</a> --}}
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
