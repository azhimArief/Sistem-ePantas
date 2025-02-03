@extends('layouts.masterAdmin')
@section('content')
    <!--**********************************
                            Content body start
                        ***********************************-->
    <style>
        #passwordRequirements, #checkboxPassword {
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
            <div class="col-xl-23 col-lg-12">
                <form class="form-horizontal" method="POST" action="{{ url('pengguna/kemaskini/simpan/' . $pengguna->id) }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            {{-- <h4 class="card-title">Kemaskini Pengguna</h4> --}}
                            <h3 class="font-weight-bold mb-0">Kemaskini Pengguna</h3>
                        </div>
                        <div class="card-body">
                            <br>
                             {{-- KALO TAK PERLU UPDATE --}}
                            {{-- <dl class="row">
                                <dt class="col-sm-3">No. Mykad</dt>
                                <dd class="col-sm-9">{{ $pengguna->mykad }}</dd>
                                <dt class="col-sm-3">Nama</dt>
                                <dd class="col-sm-9">{{ $pengguna->nama }}</dd>
                                <dt class="col-sm-3">Bahagian</dt>
                                <dd class="col-sm-9">{{ $pengguna->bahagian }}</dd>
                                <dt class="col-sm-3">Jawatan</dt>
                                <dd class="col-sm-9">{{ $pengguna->jawatan }}</dd>
                                <dt class="col-sm-3">Gred</dt>
                                <dd class="col-sm-9">{{ $pengguna->gred }}</dd>
                                <dt class="col-sm-3">Emel</dt>
                                <dd class="col-sm-9">{{ $pengguna->email }}</dd>
                                <dt class="col-sm-3">Status</dt> <dd class="col-sm-9">{{ $pengguna->status }}</dd>
                            </dl> --}}
                             {{-- KALO TAK PERLU UPDATE --}}

                             <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama 
                                        <font color="red"> * </font> 
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama" value="{{ $pengguna->nama ?? old('nama') }}" required>
                                        @error('nama') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                    </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label for="bahagian" class="col-sm-3 col-form-label">Bahagian 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="bahagian" name="bahagian"
                                        placeholder="Bahagian" value="{{ $pengguna->bahagian ?? old('bahagian') }}" required>
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
                                    <input type="text" class="form-control" id="agensi" name="agensi" placeholder="Agensi" value="{{ $pengguna->agensi ?? old('agensi') }}" required>
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
                                    <input type="text" class="form-control" id="bahagian" name="bahagian" placeholder="Bahagian" value="{{ $pengguna->bahagian ?? old('bahagian') }}" required oninput="capitalizeFirstLetter(this)">
                                    @error('bahagian') 
                                        <div class="text-danger text-strong">{{ $message }}</div> 
                                    @enderror
                                </div>
                            </div>
                            {{-- TEST DROPDOWN BAHAGIAN --}}

                            <div class="form-group row">
                                <label for="jawatan" class="col-sm-3 col-form-label">Jawatan
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="jawatan" name="jawatan"
                                        placeholder="Jawatan" value="{{ $pengguna->jawatan ?? old('jawatan') }}" required>
                                    @error('jawatan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gred" class="col-sm-3 col-form-label">Gred
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="gred" name="gred"
                                        placeholder="Gred" value="{{ $pengguna->gred ?? old('gred') }}" required>
                                    @error('gred') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Emel 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Emel" value="{{ $pengguna->email ?? old('email') }}" required>
                                    @error('email') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefon" class="col-sm-3 col-form-label">No. Telefon Pejabat 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="tel_pejabat" name="tel_pejabat"
                                        placeholder="No. Telefon Pejabat" value="{{ $pengguna->tel_pejabat ?? old('tel_pejabat') }}" required>
                                    @error('tel_pejabat') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefon" class="col-sm-3 col-form-label">No. Telefon 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="telefon" name="telefon"
                                        placeholder="No. Telefon" value="{{ $pengguna->telefon ?? old('telefon') }}" required>
                                    @error('telefon') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            @if ( Auth::user()->id_access == 'Pentadbir Sistem' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem')
                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9" style="margin-top:7px;">
                                        {{-- {{ $pengguna->status }} --}}
                                        @php old('status') == NULL ? $status1=$pengguna->status : $status1=old('status') @endphp
                                        @foreach ($optStatusUsers as $optStatusUser)
                                            <input type="radio" name="status" id="{{ $optStatusUser->status }}"
                                                value="{{ $optStatusUser->status }}"
                                                @if ($status1 == $optStatusUser->status) {{ 'checked="checked"' }} @endif> <label
                                                class="form-check-label"
                                                for="{{ $optStatusUser->status }}">{{ $optStatusUser->status }}</label>
                                            &nbsp;&nbsp;
                                        @endforeach
                                        @error('status') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="peranan" class="col-sm-3 col-form-label">Peranan</label>
                                    <div class="col-sm-6">
                                        {{-- {{ $pengguna->id_access }} --}}
                                        <select class="select2-peranan" id="peranan" name="peranan" style="width:100%;">
                                            @php old('peranan') == NULL ? $perananOpt = $pengguna->id_access : $perananOpt = old('peranan') @endphp
                                            <option value="" @if ($perananOpt == '') {{ 'selected="selected"' }} @endif>&nbsp; </option>
                                            @foreach ($optAccesss as $optAccess)
                                                <option value="{{ $optAccess->access_type }}"
                                                    @if ( $perananOpt == $optAccess->access_type) {{ 'selected="selected"' }} @endif>
                                                    {{ $optAccess->access_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('peranan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                            @else
                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-6" style="margin-top:7px;">
                                        <input type="text" class="form-control" name="status" id="status" value="{{ $pengguna->status }} " readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="peranan" class="col-sm-3 col-form-label">Peranan</label>
                                    <div class="col-sm-6" style="margin-top:7px;">
                                        <input type="text" class="form-control" name="peranan" id="peranan" value="{{ $pengguna->id_access }} " readonly>
                                    </div>
                                </div>

                            @endif

                            

                        </div>

                        <div class="card-header bg-light">
                            <h3 class="font-weight-bold mb-0">Maklumat Login</h3>
                        </div>
                        <div class="card-body">
                            {{-- <dl class="row">
                                <dt class="col-sm-3">ID Pengguna</dt>
                                <dd class="col-sm-9">{{ $pengguna->mykad }}</dd>
                            </dl> --}}
                            <div class="form-group row">
                                <label for="id_pengguna" class="col-sm-3 col-form-label">ID Pengguna 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="id_pengguna" name="id_pengguna"
                                        placeholder="No Kad Pengenalan" value="{{ $pengguna->mykad ?? old('id_pengguna') }}" maxlength="12" required>
                                    @error('id_pengguna') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kata_laluan" class="col-sm-3 col-form-label">Kata Laluan</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="kata_laluan" name="kata_laluan" oninput="toggleLabelVisibility()"
                                        placeholder="Tukar Kata Laluan" value="">
                                    <small class="text-muted" id="notePassword">Biarkan kosong jika tidak ingin mengubah kata laluan. <br></small>

                                    <div class="checkboxPassword" id="checkboxPassword">
                                        <input type="checkbox" id="" onclick="togglePassword()">
                                        <label style="color: grey; font-size: 12px;">&nbsp;Lihat Kata Laluan</label>
                                    </div>

                                    <div id="passwordRequirements">
                                        {{-- <p>Password must meet the following requirements:</p> --}}
                                        <ul>
                                            <li id="length"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Minimum 8 aksara</small> </li>
                                            <li id="uppercase"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu huruf besar (A-Z)</small> </li>
                                            <li id="lowercase"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu huruf kecil (a-z)</small> </li>
                                            <li id="number"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu nombor (0-9)</small> </li>
                                            <li id="special"> <small style="color: red;"> <i class="fa fa-times" aria-hidden="true"></i> Sekurang-kurangnya satu karakter khas (!,@,#,$)</small> </li>
                                        </ul>
                                    </div>

                                    @error('kata_laluan') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="btn-group float-right">
                                <button type="button" class="btn btn-secondary float-left btn-sm" onclick="history.back();"><i
                                        class="fas fa-redo-alt"></i> Kembali</button>
                                <button type="submit" name="submit_pengguna" class="btn btn-success btn-sm float-right"><i
                                        class="fa fa-floppy-o" aria-hidden="true"></i> | Simpan</button>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </form>
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

        @if ( Auth::user()->id_access != 'Pentadbir Sistem' && Auth::user()->id_access != 'Pentadbir Teknikal Sistem') 
            // PASSWORD LIVE UPDATE REQUIREMENT
                // Function to validate password requirements
                function validatePassword(password) {
                    var requirementsMet = {
                        length: password.length >= 8,
                        uppercase: /[A-Z]/.test(password),
                        lowercase: /[a-z]/.test(password),
                        number: /[0-9]/.test(password),
                        special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
                    };
                    return requirementsMet;
                }

                // Function to update password requirements display
                function updatePasswordRequirementsDisplay(requirementsMet) {
                    for (var requirement in requirementsMet) {
                        var element = document.getElementById(requirement);
                        // console.log(requirement);
                        if (element) {
                            if (requirementsMet[requirement]) {
                                element.classList.add('met');
                                document.getElementById(requirement).style.display = 'none';
                            } else {
                                element.classList.remove('met');
                                document.getElementById(requirement).style.display = 'block';
                            }
                        }
                    }
                }
                
                // Listen for input events on the password field
                document.getElementById('kata_laluan').addEventListener('input', function() {
                    var password = this.value;
                    var requirementsMet = validatePassword(password);
                    updatePasswordRequirementsDisplay(requirementsMet);

                    //if input show requirement password
                    var passwordRequirementsDiv = document.getElementById('passwordRequirements');
                    if (password.length > 0) {
                        passwordRequirementsDiv.style.display = 'block';
                    } else {
                        passwordRequirementsDiv.style.display = 'none';
                    }
                }); 
            // PASSWORD LIVE UPDATE REQUIREMENT
        @endif   

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
            var note = document.getElementById("notePassword");
            
            // Check if the password field has any value
            if (password.value.length > 0) {
                passwordItem.style.display = "inline"; // Show the label
                note.style.display = "none"; // hide the note
            } else {
                passwordItem.style.display = "none"; // Hide the label
                note.style.display = "block"; // show the note
            }
        }
        // PASSWORD CHECKBOX


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
        var agensi = "<?php echo $pengguna->agensi; ?>";
        var inputAgensi = $('#agensi').val();
        $(document).ready(function() {
            // Initial check based on PHP variable
            if ( agensi === 'Kementerian Perpaduan Negara (KPN)' || inputAgensi === 'Kementerian Perpaduan Negara (KPN)' ) {
                $('#bahagianDiv').show();
            }
            else {
                $('#bahagianDiv').hide(); // Optional: hide if the condition is not met
            }

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

    </script>

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
