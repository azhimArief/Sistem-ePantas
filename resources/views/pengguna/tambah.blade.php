@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
        Content body start
    ***********************************-->
    <style>
        .card-body {
            margin-left: 10px;
        }
        #checkboxPassword{
            display: none;
        }
    </style>

    <div class="content-body">

        <div class="col-12">
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
                    {{-- <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Ruangan bertanda * wajib diisi. --}}
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    Sila pastikan borang telah dilengkapkan dengan teliti dan lengkap.
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

        <div class="container-fluid">
            <div class="col-xl-13 col-lg-12">
                <form class="form-horizontal" method="POST" action="{{ url('pengguna/tambah/simpan') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card shadow-sm">

                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h3 class="font-weight-bold mb-0">Daftar Pengguna</h3>
                            {{-- <h4 class="card-title">Daftar Pengguna</h4> --}}
                        </div>
                        {{-- <div class="card-header bg-purple" style="background-color:">
                            <h3 class="card-title">Tempahan Makanan</h3>
                        </div> --}}
                        <div class="card-body">
                            {{-- <div class="basic-form"> --}}
                            <br>
                            <div class="form-group row">
                                <label for="mykad" class="col-sm-3 col-form-label">Carian Nama Pegawai KPN 
                                    {{-- <font color="red"> * </font> --}}
                                </label>
                                <div class="input-group col-sm-6">
                                    <select class="select2" id="cariNama" name="cariNama"
                                        style="width: 100%; text-align:left; height:41px;">
                                        <option value=""
                                            @if (old('cariNama') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                        </option>
                                        @foreach ($personels as $personel)
                                            <option value="{{ $personel->id }}"
                                                @if (old('cariNama') == $personel->id) {{ 'selected="selected"' }} @endif>
                                                {{ $personel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama 
                                        <font color="red"> * </font> 
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama" value="{{ old('nama') }}" required>
                                        @error('nama') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                    </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="bahagian" class="col-sm-3 col-form-label">Bahagian 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="bahagian" name="bahagian"
                                        placeholder="Bahagian" value="{{ old('bahagian') }}" required>
                                    @error('bahagian') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="agensi" class="col-sm-3 col-form-label">Agensi 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6 d-flex">
                                    <div class="dropdown mr-2">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" style="height:100%; "> 
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="hover:">
                                            @foreach ($agensis as $agensi)
                                                <button type="button" class="dropdown-item agensi-option" style="color: black;">{{ $agensi->agensi }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="agensi" name="agensi" placeholder="Agensi" value="{{ old('agensi') }}" required>
                                    @error('agensi') 
                                        <div class="text-danger text-strong">{{ $message }}</div> 
                                    @enderror
                                </div>
                            </div>

                            {{-- TEST DROPDOWN BAHAGIAN --}}
                            <div class="form-group row">
                                <label for="agensi" class="col-sm-3 col-form-label">Bahagian 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6 d-flex">
                                    <div class="dropdown mr-2" id="bahagianDiv" style="display:none;">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" style="height:100%; "> 
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="hover:">
                                            @foreach ($bahagians as $bahagian)
                                                <button type="button" class="dropdown-item bahagian-option" style="color: black;">{{ $bahagian->bahagian }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="bahagian" name="bahagian" placeholder="Bahagian" value="{{ old('bahagian') }}" required oninput="capitalizeFirstLetter(this)">
                                    @error('bahagian') 
                                        <div class="text-danger text-strong">{{ $message }}</div> 
                                    @enderror
                                </div>
                            </div>
                            {{-- TEST DROPDOWN BAHAGIAN --}}

                            {{-- <div class="form-group row">
                                <label for="agensi" class="col-sm-3 col-form-label">Agensi 
                                    <font color="red"> * </font></label>
                                <div class="col-sm-6">
                                    <select class="select2-agensi" id="agensi" name="agensi" style="width: 100%;" required>
                                        <option value="" @if ( old('agensi') == '') {{ 'selected="selected"' }} @endif>&nbsp; </option>
                                        @foreach ($agensis as $agensi)
                                            <option value="{{ $agensi->agensi }}" @if ( old('agensi') == $agensi->agensi ) {{ 'selected="selected"' }} @endif>{{ $agensi->agensi }}</option>
                                        @endforeach
                                    </select>
                                    @error('agensi') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label for="jawatan" class="col-sm-3 col-form-label">Jawatan
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="jawatan" name="jawatan"
                                        placeholder="Jawatan" value="{{ old('jawatan') }}" required>
                                    @error('jawatan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gred" class="col-sm-3 col-form-label">Gred
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="gred" name="gred"
                                        placeholder="Gred" value="{{ old('gred') }}" required>
                                    @error('gred') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Emel 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Emel" value="{{ old('email') }}" required>
                                    @error('email') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefon" class="col-sm-3 col-form-label">No. Telefon Pejabat 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="tel_pejabat" name="tel_pejabat"
                                        placeholder="No. Telefon Pejabat" value="{{ old('tel_pejabat') }}" required>
                                    @error('tel_pejabat') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefon" class="col-sm-3 col-form-label">No. Telefon 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="telefon" name="telefon"
                                        placeholder="No. Telefon" value="{{ old('telefon') }}" required>
                                    @error('telefon') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Status 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6" style="margin-top:7px;">
                                    @foreach ($optStatusUsers as $optStatusUser)
                                        <input type="radio" name="status" id="{{ $optStatusUser->status }}"
                                            value="{{ $optStatusUser->status }}" {{ old('status') == $optStatusUser->status ? 'checked' : '' }}> 
                                            <label class="form-check-label"
                                                for="{{ $optStatusUser->status }}">{{ $optStatusUser->status }}
                                            </label>
                                        &nbsp;&nbsp;&nbsp;
                                    @endforeach
                                    @error('status') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="peranan" class="col-sm-3 col-form-label">Peranan 
                                    <font color="red"> * </font></label>
                                <div class="col-sm-6">
                                    {{-- <select class="select2-peranan" name="peranan" style="width: 100%;" required>
                                        <option value=""></option>
                                        <option value="Pentadbir Kementerian">Pentadbir Kementerian</option>
                                        <option value="Pegawai PTJ">Pegawai PTJ</option>
                                    </select> --}}
                                    <select class="select2-peranan" id="peranan" name="peranan" style="width: 100%;" required>
                                        <option value="" @if ( old('peranan') == '') {{ 'selected="selected"' }} @endif>&nbsp; </option>
                                        @foreach ($optAccesss as $optAccess)
                                            <option value="{{ $optAccess->access_type }}" @if( old('peranan') == $optAccess->access_type ) {{ 'selected="selected"' }} @endif> {{ $optAccess->access_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('peranan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <br>
                            <h3 class="font-weight-bold mb-0">Maklumat Login</h3>
                            <hr>

                            <div class="form-group row">
                                <label for="id_pengguna" class="col-sm-3 col-form-label">ID Pengguna 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="id_pengguna" name="id_pengguna"
                                        placeholder="No Kad Pengenalan" value="{{ old('id_pengguna') }}" maxlength="12" required>
                                    @error('id_pengguna') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kata_laluan" class="col-sm-3 col-form-label">Kata Laluan 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="kata_laluan" name="kata_laluan" oninput="toggleLabelVisibility()"
                                        placeholder="Kata Laluan" value="{{ old('kata_laluan') }}" >
                                    <div class="checkboxPassword" id="checkboxPassword">
                                        <input type="checkbox" id="" onclick="togglePassword()">
                                        <label style="color: grey; font-size: 12px;">&nbsp;Lihat Kata Laluan</label>
                                    </div>
                                    @error('kata_laluan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="btn-group float-right">
                                <button type="submit" name="hantarEmel"
                                    class="btn btn-info btn-sm float-right" title="Simpan & hantar emel maklumat login ke pengguna.">
                                    {{-- <i class="fa fa-floppy-o"aria-hidden="true"></i>  --}}
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    | Simpan & Emel
                                </button>
                                <button type="submit" name="submit_pengguna"
                                    class="btn btn-success btn-sm float-right" title="Simpan maklumat sahaja."><i class="fa fa-floppy-o"
                                        aria-hidden="true"></i> | Simpan Sahaja
                                </button>
                                {{-- <button type="button" class="btn btn-secondary btn-sm float-left"
                                    onclick="history.back();">Kembali</button> --}}
                            </div>
                        </div>

                    </div>
                </form>

            </div>

        </div>

    </div>
    <!--**********************************
            Content body end
        ***********************************-->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
            $('.select2-peranan').select2({
                minimumResultsForSearch: Infinity
            });
            $('.select2-agensi').select2({
                minimumResultsForSearch: Infinity
            });
        });

        // PASSWORD CHECKBOX
        function togglePassword() { //Lihat Password
            var passwordField = document.getElementById("kata_laluan");
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
        function toggleLabelVisibility() {  //if tak type password tak muncul lihat password
            var password = document.getElementById("kata_laluan");

            var passwordItem = document.getElementById("checkboxPassword");
            
            // Check if the password field has any value
            if (password.value.length > 0) {
                passwordItem.style.display = "inline"; // Show the label
            } else {
                passwordItem.style.display = "none"; // Hide the label
            }
        }
        // PASSWORD CHECKBOX


        // UNTUK SELECT AGENSI
        // Get all dropdown items with the class 'agensi-option'
        var dropdownItems = document.querySelectorAll('.agensi-option');

        // Attach click event listeners to each dropdown item
        dropdownItems.forEach(function(item) {
            item.addEventListener('click', function() {
                // Get the text content of the clicked dropdown item
                var agensiValue = item.textContent.trim();

                // Set the value of the input field with id 'agensi' to the selected value
                document.getElementById('agensi').value = agensiValue;
            });
        });

        // Get all dropdown items with the class 'bahagian-option'
        var dropdownItems = document.querySelectorAll('.bahagian-option');
        // Attach click event listeners to each dropdown item
        dropdownItems.forEach(function(item) {
            item.addEventListener('click', function() {
                // Get the text content of the clicked dropdown item
                var bahagianValue = item.textContent.trim();

                // Set the value of the input field with id 'bahagian' to the selected value
                document.getElementById('bahagian').value = bahagianValue;
            });
        });

        //IF KPN SHOW DROPDOWN ELSE HIDE
        // var inputAgensi = $('#agensi').val();

        function checkAgensi() {
            var inputAgensi = $('#agensi').val();

            if (inputAgensi === 'Kementerian Perpaduan Negara (KPN)') {
                $('#bahagianDiv').show();
            } else {
                $('#bahagianDiv').hide();
            }
        }

        $(document).ready(function() {
            // Initial check based on PHP variable
            checkAgensi();

            // Attach a click event listener to the agensi options
            $('.dropdown-menu').on('click', '.agensi-option', function() {
                // Get the text of the clicked option
                var selectedAgensi = $(this).text().trim();
                
                // Check if the selected agensi is "Kementerian Perpaduan Negara"
                if (selectedAgensi === 'Kementerian Perpaduan Negara (KPN)') {
                    // Show the target div
                    $('#bahagianDiv').show();
                } else {
                    // Hide the target div
                    $('#bahagianDiv').hide();
                }
                
            });         

        });

        //Cari Nam Jquery
        $(document).ready(function() {

            $(document).on('change', '#cariNama', function() {
                var cariNama = $(this).val();
                var div = $(this).parent().parent().parent();
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('searchNamaPersonel') !!}',
                    data: {
                        'id': cariNama
                    },
                    // success: function(data) {
                    success: function(response) {
                        var data = response.data;
                        var data2 = response.data2;

                        var data3 = response.data3;
                        // console.log(div);
                        // op+='<option value="" @if (old('objekSeb') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
                        // for(var i=0;i<data.length;i++){
                        // op+='<option value="'+data[i].idObjek+'">'+ data[i].idObjek + ', ' + data[i].jenisPerbelanjaan+'</option>';
                        // }
                        nama = data.name;
                        nokp = data.nokp;
                        jawatan = data.jawatan;
                        gred = data.gred;
                        // bahagian = data.bahagian_id;
                        agensiNama = data3.agensi;

                        bahagian = data2.bahagian;
                        email = data.email;
                        tel = data.tel;
                        tel_bimbit = data.tel_bimbit;

                        div.find('#id_pengguna').html(" ");
                        div.find('#nama').html(" ");
                        div.find('#nokp').html(" ");
                        div.find('#jawatan').html(" ");
                        div.find('#gred').html(" ");
                        div.find('#bahagian').html(" ");
                        div.find('#agensi').html(" ");
                        div.find('#email').html(" ");
                        div.find('#tel_pejabat').html(" ");
                        div.find('#telefon').html(" ");

                        div.find('#id_pengguna').val(nokp);
                        div.find('#nama').val(nama);
                        div.find('#nokp').val(nokp);
                        div.find('#jawatan').val(jawatan);
                        div.find('#agensi').val(agensiNama);
                        div.find('#gred').val(gred);
                        div.find('#bahagian').val(bahagian);
                        div.find('#email').val(email);
                        div.find('#tel_pejabat').val(tel);
                        div.find('#telefon').val(tel_bimbit);

                        checkAgensi();

                        // Automatically select option with value of 1 or the text "Kementerian Perpaduan Negara" if it exists
                        // div.find('#agensi option').filter(function() {
                        //     return $(this).text() == agensiNama || $(this).val() == agensi;
                        // }).prop('selected', true);

                    },
                    error: function() {}
                });
            });

        });
    </script>

    {{-- MESSAGE UNTUK FIELD REQUIRED --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all required inputs
                const requiredInputs = document.querySelectorAll('input[required]');

                requiredInputs.forEach(function(input) {
                    input.addEventListener('invalid', function() {
                        // Customize the validation message
                        input.setCustomValidity('Ruangan ini diperlukan. Sila isi.');
                    });

                    input.addEventListener('input', function() {
                        // Clear the custom validation message
                        input.setCustomValidity('');
                    });
                });
            });
        </script>
    {{-- MESSAGE UNTUK FIELD REQUIRED --}}

    {{-- INPUT BAHAGIAN AUTO CAPS FIRST LETTER --}}
        <script>
            function capitalizeFirstLetter(input) {
                input.value = input.value
                    .toLowerCase()
                    .replace(/\b\w/g, function(char) { return char.toUpperCase(); });
            }
        </script>
    {{-- INPUT BAHAGIAN AUTO CAPS FIRST LETTER --}}
        
@endsection
