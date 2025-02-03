
<!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<div class="main-profile">
					<h5 class="name" style="font-size:14px"><span class="font-w100">Selamat Datang,</span><br>
                        {{ Auth::user()->nama }} 
                    </h5>
				</div>
				<ul class="metismenu" id="menu">
                    {{-- <i class="flaticon-381-settings-2"></i> --}}
                    @if ( Auth::user()->id_access === 'Pentadbir Teknikal Sistem' )
                        <li>
                            <a href="{{ url('home') }}" class="ai-icon" aria-expanded="false">
                                <i class="fa fa-tachometer" aria-hidden="true"></i>
                                <span class="nav-text">Dashboard (In Progress)</span>
                            </a>
                        </li>
                    @endif


					<li class="nav-label first">Permohonan</li>
                    <li>
                        {{-- <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-092-money"></i>
							<span class="nav-text">Peruntukan</span>
						</a> --}}
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-092-money"></i>
							<span class="nav-text">Peruntukan</span>
						</a>
                        <ul aria-expanded="false">
                            @if ( Auth::user()->id_access == 'Pentadbir Sistem' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem')
    							<li><a href="{{ url('/peruntukan/tambah') }}" class="{{ Route::is('peruntukan.tambah') ? 'mm-active' : '' }}">Tambah</a></li>							
                            @endif
							<li><a href="{{ url('/peruntukan/senarai') }}" class="{{ Route::is('peruntukan.senarai') ? 'mm-active' : '' }}">Senarai</a></li>							
						</ul>
                    </li>

                    {{-- PPT TIDAK PERLU LAGI --}}
                    {{-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-notebook-5"></i>
							<span class="nav-text">Perancangan Perolehan</span>
						</a>
                        <ul aria-expanded="false">
							<li><a href="{{ url('/peruntukan/pilih_ppt') }}" class="{{ Route::is('peruntukan.pilih_ppt') ? 'mm-active' : '' }}">Pendaftaran</a></li>							
							<li><a href="{{ url('/peruntukan/senarai_ppt') }}" class="{{ Route::is('peruntukan.senarai_ppt') ? 'mm-active' : '' }}">Senarai</a></li>							
						</ul>
                    </li> --}}

                    @if ( Auth::user()->id_access == 'Pentadbir Sistem' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem')
                        <li class="nav-label">Pentadbir Sistem</li>
                        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-028-user-1"></i>
                                <span class="nav-text"> Pengguna</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ url('/pengguna/tambah') }}" class="{{ Route::is('pengguna.tambah') ? 'mm-active' : '' }}">Tambah</a></li>
                                <li><a href="{{ url('/pengguna/senarai') }}" class="{{ Route::is('/pengguna.senarai') ? 'mm-active' : '' }}">Senarai </a></li>
                            </ul>
                        </li>
                    @endif

                    @if ( Auth::user()->id_access !== 'Pengesah' )
                        <li class="nav-label">Laporan </li>
                        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-044-file"></i>
                                <span class="nav-text">Laporan</span>
                            </a>
                            <ul aria-expanded="false">
                                {{-- <li><a href="{{ url('/laporan/tambah_ppp') }}">Tambah</a></li> --}}
                                <li><a href="{{ url('/laporan/peruntukan') }}">Laporan Peruntukan</a></li>
                                <li><a href="{{ url('/laporan/perbelanjaan_objek') }}">Laporan Perbelanjaan Objek</a></li>
                            </ul>
                        </li>
                    @endif

                    <li class="nav-label">Panduan</li>
                    @if ( Auth::user()->id_access == 'Pentadbir Sistem' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem')
                        <li>
                            <a href="{{ asset('storage/MANUAL_PENGGUNA_ePantas-PENTADBIR SISTEM.pdf') }}" class="ai-icon" aria-expanded="false" target="_blank">
                                {{-- <i class="flaticon-144-layout"></i> --}}
                                {{-- <i class="fa fa-tachometer" aria-hidden="true"></i> --}}
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                <span class="nav-text">Manual Pengguna</span>
                            </a>
                        </li>
                    @endif
                    @if ( Auth::user()->id_access == 'Pentadbir-SUB Kewangan dan Pembangunan' || Auth::user()->id_access == 'Pentadbir-SUB Kanan Pengurusan' 
                            || Auth::user()->id_access == 'Pentadbir-KSU' || Auth::user()->id_access == 'Pengesah' || Auth::user()->id_access == 'Pentadbir Teknikal Sistem' )
                        <li>
                            <a href="{{ asset('storage/MANUAL_PENGGUNA_ePantas-PENGURUSAN.pdf') }}" class="ai-icon" aria-expanded="false" target="_blank"> 
                                {{-- <i class="flaticon-144-layout"></i> --}}
                                {{-- <i class="fa fa-tachometer" aria-hidden="true"></i> --}}
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                <span class="nav-text">Manual Pengguna</span>
                            </a>
                        </li>
                    @endif

					{{-- <li class="nav-label">Laporan</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-044-file"></i>
							<span class="nav-text">Pengurusan Belanjawan</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('/laporan/tambah_ppp') }}">Tambah</a></li>
                            <li><a href="{{ url('/laporan/keseluruhan') }}">Laporan Keseluruhan</a></li>
                        </ul>
                    </li> --}}

                    <li class="nav-label"></li>     

                    {{-- <li class="nav-label">Sistem</li>     
                    <li class="nav-item has-treeview">
                        <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link" >
                        <i class="nav-icon fas fa-sign-out-alt "></i>
                        <i class="flaticon-059-log-out"></i>
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span class="nav-text"> Log Keluar</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        </a>
                    </li> --}}
					
                </ul>
				{{-- <div class="copyright">
					<p><strong>Zenix Crypto Admin Dashboard</strong> © 2021 All Rights Reserved</p>
					<p class="fs-12">Made with <span class="heart"></span> by DexignZone</p>
				</div> --}}
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->