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
                        <h4 class="card-title">Pendaftaran Perancangan Perolehan Tahunan</h4>
                    </div>
                    {{-- <div class="card-body">
                        <div class="basic-form">
                            
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="basic-form">
                            {{-- <form> --}}
                            <form method="POST" action="{{ route('pemohon.pilih_ppt' , $personel->nokp) }}">
                                {{ csrf_field() }}
                                <div class="form-row">

                                    <div class="input-group mb-4">
                                        <label for="nama" class="col-sm-2 col-form-label" style="text-align:left">
                                            Nama Pendaftar:  
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
                                        </div>                                           
                                    </div>

                                    <div class="input-group mb-4">
                                        <label for="tahun" class="col-sm-2 col-form-label" style="text-align:left">
                                            Tahun 
                                            <font color="red">*</font>
                                        </label>
                                        <div class="col-sm-4">
                                            {{-- <input class="form-control" name="tahun" type="number" min="2000" max="2099" maxlength="4" step="1" value="{{ date('Y') }}" />      --}}
                                            <input class="form-control" name="tahun" type="number" min="2000" max="2099" pattern="\d{4}" maxlength="4" step="1" value="" />     
                                        </div>
                                    </div>
                                        
                                </div>

                                <button type="submit" name="pilih_PPT" class="btn btn-primary float-right btn-sm"><i class="fa fa-arrow-right" aria-hidden="true"></i> | Seterusnya</button>

                                <a href="{{ url('/pemohon/menu_ppt/' . $personel->nokp) }}" class="btn btn-secondary float-left btn-sm" >
                                    <i class="fas fa-redo-alt"></i> | Kembali
                                </a>
                                
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
