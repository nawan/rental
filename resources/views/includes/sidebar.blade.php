@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- core menu --}}
                <div class="sb-sidenav-menu-heading">Beranda</div>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Dashboard
                </a>
                {{-- data menu --}}
                <div class="sb-sidenav-menu-heading">Data</div>
                {{-- menu data rental --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTransaksi" aria-expanded="false" aria-controls="collapseTransaksi">
                    <div class="sb-nav-link-icon"><i class="fas fa-business-time"></i></div>
                    Rental
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTransaksi" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('transaction.index') }}">
                            Booking
                        </a>
                        <a class="nav-link collapsed" href="{{ route('transaction.record') }}">
                            Riwayat Booking
                        </a>
                        <a class="nav-link" href="{{ route('usedcar.index') }}">
                            Mobil Terpakai
                        </a>
                        <a class="nav-link" href="{{ route('availablecar.index') }}">
                            Mobil Tersedia
                        </a>
                    </nav>
                </div>
                {{-- menu data mobil --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMobil" aria-expanded="false" aria-controls="collapseMobil">
                    <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                    Mobil
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMobil" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('car.create') }}">Tambah Data</a>
                        <a class="nav-link" href="{{ route('car.index') }}">Data Mobil</a>
                        {{-- <a class="nav-link" href="{{ route('usedcar.index') }}">Data Mobil Terpakai</a>
                        <a class="nav-link" href="{{ route('availablecar.index') }}">Data Mobil Tersedia</a> --}}
                    </nav>
                </div>
                {{-- menu data pelanggan --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePelanggan" aria-expanded="false" aria-controls="collapsePelanggan">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Pelanggan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePelanggan" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('user.create') }}">
                            Tambah Data
                        </a>
                        <a class="nav-link collapsed" href="{{ route('user.index') }}">
                            Data Pelanggan
                        </a>
                    </nav>
                </div>
                {{-- menu data pembayaran --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKeuangan" aria-expanded="false" aria-controls="collapseKeuangan">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-check-alt"></i></div>
                    Keuangan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseKeuangan" aria-labelledby="headingFour" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('payment.index') }}">
                            Pembayaran
                        </a>
                        <a class="nav-link collapsed" href="{{ route('payment.history') }}">
                            Riwayat Pembayaran
                        </a>
                    </nav>
                </div>
                {{-- menu data cetak --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCetak" aria-expanded="false" aria-controls="collapseCetak">
                    <div class="sb-nav-link-icon"><i class="fas fa-print"></i></div>
                    Cetak
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCetak" aria-labelledby="headingFive" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('suratjalan') }}">
                            Surat Jalan
                        </a>
                        <a class="nav-link collapsed" href="{{ route('buktibayar') }}">
                            Bukti Bayar
                        </a>
                    </nav>
                </div>
                {{-- menu data laporan --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                    Laporan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLaporan" aria-labelledby="headingFive" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('laporan-mobil') }}">
                            Data Mobil
                        </a>
                        <a class="nav-link collapsed" href="{{ route('laporan-pelanggan') }}">
                            Data Pelanggan
                        </a>
                        <a class="nav-link collapsed" href="{{ route('laporan-pembayaran') }}">
                            Data Pembayaran
                        </a>
                    </nav>
                </div>
                {{-- Menu kelola admin --}}
                @if (auth()->user()->name == 'nawan')
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
                        <div class="sb-nav-link-icon"><i class="fa fa-user-check"></i></div>
                        Admin
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAdmin" aria-labelledby="headingSix" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="{{ route('admin.create') }}">
                                Tambah Admin
                            </a>
                            <a class="nav-link collapsed" href="{{ route('admin.index') }}">
                                Data Admin
                            </a>
                        </nav>
                    </div>
                @else
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
                        <div class="sb-nav-link-icon"><i class="fa fa-user-check"></i></div>
                        Admin
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAdmin" aria-labelledby="headingSix" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="{{ route('admin.index') }}">
                                Data Admin
                            </a>
                        </nav>
                    </div>
                @endif
                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
                    <div class="sb-nav-link-icon"><i class="fa fa-user-check"></i></div>
                    Data Admin
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAdmin" aria-labelledby="headingSix" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#">
                            Tambah Admin
                        </a>
                        <a class="nav-link collapsed" href="#">
                            Daftar Admin
                        </a>
                    </nav>
                </div> --}}
                <div class="sb-sidenav-menu-heading">Profil</div>
                {{-- menu profil --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProfil" aria-expanded="false" aria-controls="collapseProfil">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Profil Saya
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProfil" aria-labelledby="headingSeven" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{ route('profile') }}">
                            Edit Profil
                        </a>
                    </nav>
                </div>

                {{-- <div class="sb-sidenav-menu-heading">Profile</div>
                <a class="nav-link" href="{{ route('profile') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Profile
                </a>
                <a class="nav-link" href="{{ route('change-password') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                    Ganti Password
                </a> --}}
                {{-- <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form> --}}
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Username Anda:</div>
            <span class="text-lg" style="text-transform:capitalize">
                {{ auth()->user()->name; }}
            </span>
        </div>
    </nav>
</div>