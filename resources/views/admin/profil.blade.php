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
                        <h4 class="card-title">Profil</h4>
                    </div>
                    {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                        <div class="card-body">
                            <div class="basic-form">
                                <form>
                                    {{-- <span class="badge badge-primary badge-lg" style="color:white;"> Maklumat Pemohon</span> --}}
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-3 col-form-label" style="text-align:left">Nama
                                            Pegawai </label>
                                        <div class="input-group col-sm-9 ">
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ $personel->name }}" readonly placeholder="Nama Pegawai">
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="jawatan" class="col-sm-3 col-form-label" style="text-align:left">Jawatan
                                        </label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="jawatan" name="jawatan"
                                                placeholder="Jawatan" value="{{ $personel->jawatan }}" readonly="readonly">
                                        </div>
    
                                        <label for="gred" class="col-sm-1 col-form-label" style="">Gred </label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="gred" name="gred"
                                                placeholder="Gred" value="{{ $personel->gred }}" readonly="readonly">
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="bahagian" class="col-sm-3 col-form-label" style="text-align:left">Bahagian
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="bahagian" name="bahagian"
                                                placeholder="Bahagian" 
                                                value="{{ $personel->bahagian_id != '' ? \App\Models\PLkpBahagian::find($personel->bahagian_id)->bahagian : old('bahagian') }}" readonly>
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="emel" class="col-sm-3 col-form-label" style="text-align:left">E-mel
                                            <font color="red">*</font> </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="emel" name="emel"
                                                placeholder="E-mel" 
                                                value="{{ $personel->email }}">
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="telefon" class="col-sm-3 col-form-label" style="text-align:left">No.
                                            Telefon Pejabat <font color="red">*</font> </label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="telefon" name="telefon"
                                                placeholder="No. Tel. Pejabat" value="{{ $personel->tel }}">
                                        </div>
    
                                        <label for="tel_bimbit" class="col-sm-3 col-form-label" style="text-align:left">No.
                                            Telefon Bimbit <font color="red">*</font> </label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="tel_bimbit" name="tel_bimbit"
                                                placeholder="No. Tel Bimbit" value="{{ $personel->tel_bimbit }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="telefon" class="col-sm-3 col-form-label" style="text-align:left">Kata Laluan <font color="red">*</font> </label>
                                        <div class="col-sm-3">
                                            <input type="password" class="form-control" id="telefon" name="telefon"
                                                placeholder="" value="{{ $personel->password }}">
                                        </div>
                                    </div>
    
    
                                    <div class=" justify-content-center">
                                        {{-- <a href="/peruntukan/tindakan" id="hantar" class="btn btn-primary float-left btn-sm"><i
                                                    class="fa fa-paper-plane"></i> |
                                                     Hantar
                                            </a> --}}
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary float-left btn-sm" data-toggle="modal"
                                            data-target="#exampleModalCenter"><i class="fa fa-paper-plane"></i> | Hantar
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalCenter">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        {{-- <h5 class="modal-title">Modal title</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span>&times;</span>
                                                        </button> --}}
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- <p>Anda pasti ingin menghantar permohonan?</p> --}}
                                                        <color="red">
                                                            <h4 style="color:red;"><i class="fa fa-exclamation-circle fa-lg"
                                                                    aria-hidden="true"></i> Anda pasti ingin menghantar
                                                                permohonan?</h4>
                                                            </color>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light"
                                                            data-dismiss="modal">Tutup</button>
                                                        {{-- <button type="button" class="btn btn-primary">Hantar</button> --}}
                                                        <a href="{{ url('/pemohon/dummy') }}" id="hantar"
                                                            class="btn btn-primary">Hantar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary float-right btn-sm" style="color: black;"
                                            onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali
                                        </button>
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
@endsection
