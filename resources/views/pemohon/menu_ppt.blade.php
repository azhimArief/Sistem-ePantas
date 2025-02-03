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
                        <h4 class="card-title"> Perancangan Perolehan Tahunan</h4>
                    </div>
                    {{-- <div class="card-body">
                        <div class="basic-form">
                            
                        </div>
                    </div> --}}
                    <div class="card-body">

                        <div class="input-group mb-4" style="display: flex;justify-content: center;align-items: center;">
                            <a href="{{ route('pemohon.pilih_ppt', $nokp) }}" class="ag-courses-item_link"
                                style="width:260px;height:60px;border-radius:30px;">
                                <div class="ag-courses-item_bg" style="background-color: var(--primary)"></div>

                                <div class="ag-courses-item_title">
                                    <center>
                                        Pendaftaran PPT <i class="fas fa-plus"></i>
                                    </center>
                                </div>
                            </a>
                            {{-- <a href="{{ route('pemohon.pengesahan_ppt', ['id' => $idPPT , 'nokp' => $personel->nokp] ) }}" class="ag-courses-item_link"   --}}
                            <a href="{{ route('pemohon.senarai_ppt', $nokp) }}" class="ag-courses-item_link"
                                style="width:260px;height:60px;border-radius:30px;">
                                <div class="ag-courses-item_bg" style="background-color: var(--success)"></div>

                                <div class="ag-courses-item_title">
                                    <center>
                                        Senarai PPT <i class="fas fa-pen"></i>
                                    </center>
                                </div>
                            </a>
                        </div>

                        <a href="{{ url('/pemohon/menu/' . $nokp) }}" class="btn btn-secondary float-left btn-sm">
                            <i class="fas fa-redo-alt"></i> | Kembali
                        </a>

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
@endsection
