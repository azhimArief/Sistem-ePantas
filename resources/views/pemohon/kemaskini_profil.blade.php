@extends('layouts.master')
@section('content')
    <!--**********************************
            Content body start
        ***********************************-->

    <style>
        dt, dd {
            font-size: 16px;
        }
        #passwordRequirements, #checkboxPassword{
            display: none;
        }
    </style>
    @if($errors->has('kata_laluan'))
        <style>
            #kata_laluan {
                border-color: red;
                border-width: 1px;
            }
        </style>
    @endif

    <div class="content-body">
        <div class="container-fluid">
            <div class="col-xl-23 col-lg-12">

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

                <form class="form-horizontal" method="POST" action="{{ url('pemohon/profil/kemaskini/simpan/' . $user->id) }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card card shadow-sm rounded">
                        <div class="card-header bg-light text-white">
                            <h3 class="font-w600 title mb-2 mr-auto">Kemaskini Pengguna</h3>
                        </div>
                        {{-- <div class="card-body">
                            <br>
                            <dl class="row">
                                <dt class="col-sm-3">No. Mykad</dt>
                                <dd class="col-sm-9">{{ $user->mykad }}</dd>
                                <dt class="col-sm-3">Nama</dt>
                                <dd class="col-sm-9">{{ $user->nama }}</dd>
                                <dt class="col-sm-3">Bahagian</dt>
                                <dd class="col-sm-9">{{ $user->bahagian }}</dd>
                                <dt class="col-sm-3">Jawatan</dt>
                                <dd class="col-sm-9">{{ $user->jawatan }}</dd>
                                <dt class="col-sm-3">Gred</dt>
                                <dd class="col-sm-9">{{ $user->gred }}</dd>
                                <dt class="col-sm-3">Emel</dt>
                                <dd class="col-sm-9">
                                    <input type="email" class="form-control" id="emel" name="emel" placeholder="Emel" value="{{ $user->email }}">
                                </dd>
                                <dd class="col-sm-9">{{ $user->email }}</dd>
                                <dt class="col-sm-3">Status</dt>
                                <dd class="col-sm-9">{{ $user->status }}</dd>
                                <dt class="col-sm-3">Peranan</dt>
                                <dd class="col-sm-9">{{ $user->id_access }}</dd>
                            </dl>
                        </div> --}}
                        <div class="card-body">
                            <br>

                              <!-- Nama -->
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label font-weight-bold">Nama 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama" value="{{ $user->nama ?? old('nama') }}" required>
                                        @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                            {{-- <div class="form-group row">
                                <label for="bahagian" class="col-sm-3 col-form-label">Bahagian 
                                    <font color="red"> * </font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="bahagian" name="bahagian"
                                        placeholder="Bahagian" value="{{ $user->bahagian ?? old('bahagian') }}" required>
                                    @error('bahagian') <div class="text-danger text-strong">{{ $message }}</div> @enderror
                                </div>
                            </div> --}}
                            
                            <!-- Bahagian -->
                            <div class="form-group row">
                                <label for="bahagian" class="col-sm-3 col-form-label font-weight-bold">Bahagian 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6 d-flex">
                                    <div class="dropdown mr-2" id="bahagianDiv" style="display:none;">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"> 
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach ($bahagians as $bahagian)
                                                <button type="button" class="dropdown-item bahagian-option">{{ $bahagian->bahagian }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="bahagian" name="bahagian" 
                                        placeholder="Bahagian" value="{{ $user->bahagian ?? old('bahagian') }}" required>
                                    @error('bahagian') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                             <!-- Agensi -->
                            <div class="form-group row">
                                <label for="agensi" class="col-sm-3 col-form-label font-weight-bold">Agensi 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6 d-flex">
                                    <div class="dropdown mr-2">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"> 
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach ($agensis as $agensi)
                                                <button type="button" class="dropdown-item agensi-option">{{ $agensi->agensi }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="agensi" name="agensi"
                                        placeholder="Agensi" value="{{ $user->agensi ?? old('agensi') }}" required>
                                    @error('agensi') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                             <!-- Jawatan -->
                            <div class="form-group row">
                                <label for="jawatan" class="col-sm-3 col-form-label font-weight-bold">Jawatan 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="jawatan" name="jawatan"
                                        placeholder="Jawatan" value="{{ $user->jawatan ?? old('jawatan') }}" required>
                                    @error('jawatan') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Gred -->
                            <div class="form-group row">
                                <label for="gred" class="col-sm-3 col-form-label font-weight-bold">Gred 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="gred" name="gred"
                                        placeholder="Gred" value="{{ $user->gred ?? old('gred') }}" required>
                                    @error('gred') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label font-weight-bold">Emel 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Emel" value="{{ $user->email ?? old('email') }}" required>
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- No. Telefon Pejabat -->
                            <div class="form-group row">
                                <label for="tel_pejabat" class="col-sm-3 col-form-label font-weight-bold">No. Telefon Pejabat 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="tel_pejabat" name="tel_pejabat"
                                        placeholder="No. Telefon Pejabat" value="{{ $user->tel_pejabat ?? old('tel_pejabat') }}" required>
                                    @error('tel_pejabat') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- No. Telefon -->
                            <div class="form-group row">
                                <label for="telefon" class="col-sm-3 col-form-label font-weight-bold">No. Telefon 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="telefon" name="telefon"
                                        placeholder="No. Telefon" value="{{ $user->telefon ?? old('telefon') }}" required>
                                    @error('telefon') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label font-weight-bold">Status</label>
                                <div class="col-sm-6" style="margin-top:7px;">
                                    <input type="text" class="form-control" name="status" id="status" value="{{ $user->status }} " readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="peranan" class="col-sm-3 col-form-label font-weight-bold">Peranan</label>
                                <div class="col-sm-6" style="margin-top:7px;">
                                    <input type="text" class="form-control" name="peranan" id="peranan" value="{{ $user->id_access }} " readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="idPengguna" class="col-sm-3 col-form-label font-weight-bold">ID Pengguna</label>
                                <div class="col-sm-6" style="margin-top:7px;">
                                    <input type="text" class="form-control" value="{{ $user->mykad }} " readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kata_laluan" class="col-sm-3 col-form-label font-weight-bold">Kata Laluan 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="kata_laluan" name="kata_laluan" oninput="toggleLabelVisibility()"
                                        placeholder="Kata Laluan" value="{{ old('kata_laluan') }}">
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

                                    @error('kata_laluan')<div class="text-danger text-strong">{{ $message }}</div>@enderror
                                </div>
                            </div>

                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="btn-group float-right">
                                <button type="button" class="btn btn-secondary float-left btn-sm" onclick="history.back();"><i
                                        class="fas fa-arrow-left"></i> Kembali
                                </button>
                                <button type="submit" name="kemaskini_profil" class="btn btn-success btn-sm float-right"><i
                                        class="fa fa-floppy-o" aria-hidden="true"></i> | Simpan
                                </button>
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
        var agensi = "<?php echo $user->agensi; ?>";
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

@endsection
