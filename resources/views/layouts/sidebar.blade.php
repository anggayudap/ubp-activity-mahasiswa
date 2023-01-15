<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('dashboard') }}"><span class="brand-logo">
                        <img class="img-responsive img-fluid" src="{{ asset('logo-ubp.png') }}">
                    </span>
                    <h2 class="brand-text">SIMKATMAWA</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ request()->is('dashboard*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('dashboard') }}"><i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboard">{{ __('Dashboard') }}</span>
                </a>
            </li>

            @hasanyrole('mahasiswa|kemahasiswaan|dpm')
            <li class=" navigation-header"><span data-i18n="Kegiatan">{{ __('Kegiatan Mahasiswa') }}</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @endhasanyrole
            @hasanyrole('mahasiswa|kemahasiswaan')
                <li class="{{ request()->is('kegiatan/create*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kegiatan.create') }}"><i
                            data-feather="file-plus"></i>
                        <span class="menu-title text-truncate" data-i18n="Input Kegiatan">{{ __('Input Kegiatan') }}</span>
                    </a>
                </li>
            @endhasrole
            @hasanyrole('mahasiswa')
                <li class="{{ request()->is('kegiatan/history*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kegiatan.history') }}"><i
                            data-feather="clock"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="History Kegiatan">{{ __('History Kegiatan') }}</span>
                    </a>
                </li>
            @endhasrole

            @hasanyrole('dpm|kemahasiswaan')
                <li class="{{ request()->is('kegiatan/list*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kegiatan.list') }}"><i data-feather="list"></i>
                        <span class="menu-title text-truncate" data-i18n="List Kegiatan">{{ __('List Kegiatan') }}</span>
                    </a>
                </li>
            @endhasanyrole

            @hasanyrole('mahasiswa|kemahasiswaan|dpm')
            <li class=" navigation-header"><span data-i18n="Proposal">{{ __('Proposal Kegiatan') }}</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @endhasanyrole
            @hasrole('mahasiswa')
                <li class="{{ request()->is('proposal/create*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('proposal.create') }}"><i
                            data-feather="file-plus"></i>
                        <span class="menu-title text-truncate" data-i18n="Input Proposal">{{ __('Input Proposal') }}</span>
                    </a>
                </li>
                <li class="{{ request()->is('proposal/history*') ? 'active' : '' }} nav-item"><a
                        class="d-flex align-items-center" href="{{ route('proposal.history') }}">
                        <i data-feather="clock"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="History Proposal">{{ __('History Proposal') }}</span></a>
                </li>
            @endhasrole('mahasiswa')

            @hasanyrole('dpm|kemahasiswaan')
                <li class="{{ request()->is('proposal/list*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('proposal.list') }}"><i data-feather="list"></i>
                        <span class="menu-title text-truncate" data-i18n="List Proposal">{{ __('List Proposal') }}</span>
                    </a>
                </li>
            @endhasanyrole

            @hasanyrole('dpm|kemahasiswaan')
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="check"></i><span
                            class="menu-title text-truncate" data-i18n="Approval">Approval</span></a>
                    <ul class="menu-content">
                        @role('dpm')
                            <li class="{{ request()->is('proposal/approval_fakultas*') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('proposal.approval_fakultas') }}"><i
                                        data-feather="circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="Fakultas">Fakultas</span>
                                </a>
                            </li>
                        @endrole
                        @role('kemahasiswaan')
                            <li class="{{ request()->is('proposal/approval_kemahasiswaan*') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('proposal.approval_kemahasiswaan') }}">
                                    <i data-feather="circle"></i><span class="menu-item text-truncate"
                                        data-i18n="Kemahasiswaan">Kemahasiswaan</span>
                                    {{-- <span class="badge badge-light-danger badge-pill ml-auto mr-2">2</span> --}}
                                </a>
                            </li>
                            <li class="{{ request()->is('proposal/approval_laporan*') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ route('proposal.approval_laporan') }}">
                                    <i data-feather="circle"></i><span class="menu-item text-truncate"
                                        data-i18n="Laporan">Laporan</span>
                                    {{-- <span class="badge badge-light-danger badge-pill ml-auto mr-2">2</span> --}}
                                </a>
                            </li>
                        @endrole
                    </ul>
                </li>
            @endhasanyrole

            <li class=" navigation-header"><span data-i18n="Kompetisi">{{ __('Kompetisi') }}</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @hasrole('kemahasiswaan')
                <li class="{{ request()->is('kompetisi/create*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kompetisi.create') }}"><i
                            data-feather="file-plus"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="Buat Kompetisi">{{ __('Buat Kompetisi') }}</span>
                    </a>
                </li>
            @endhasrole

            @hasanyrole('kemahasiswaan')
                <li class="{{ request()->is('kompetisi/list*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kompetisi.list') }}"><i
                            data-feather="list"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="List Kompetisi">{{ __('List Kompetisi') }}</span>
                    </a>
                </li>
            @endhasanyrole


            @hasanyrole('dosen|dpm|kemahasiswaan')
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            data-feather="check"></i><span class="menu-title text-truncate"
                            data-i18n="Approval & Review">Approval & Review</span></a>
                    <ul class="menu-content">
                        @role('kemahasiswaan')
                            <li class="{{ request()->is('kompetisi/approval/list*') ? 'active' : '' }} nav-item">
                                <a class="d-flex align-items-center" href="{{ route('kompetisi.approval.list') }}"><i
                                        data-feather="circle"></i>
                                    <span class="menu-title text-truncate"
                                        data-i18n="Approval Kompetisi">{{ __('Approval Kompetisi') }}</span>
                                    {{-- <span class="badge badge-light-danger badge-pill ml-auto mr-2">2</span> --}}
                                </a>
                            </li>
                        @endrole
                        @role('dosen|dpm')
                            <li class="{{ request()->is('kompetisi/review*') ? 'active' : '' }} nav-item">
                                <a class="d-flex align-items-center" href="{{ route('kompetisi.review.list') }}"><i
                                        data-feather="circle"></i>
                                    <span class="menu-title text-truncate"
                                        data-i18n="Review Kompetisi">{{ __('Review Kompetisi') }}</span>
                                </a>
                            </li>
                        @endrole
                        @role('kemahasiswaan')
                            <li class="{{ request()->is('kompetisi/result*') ? 'active' : '' }} nav-item">
                                <a class="d-flex align-items-center" href="{{ route('kompetisi.result.list') }}"><i
                                        data-feather="circle"></i>
                                    <span class="menu-title text-truncate"
                                        data-i18n="Penilaian Akhir">{{ __('Penilaian Akhir') }}</span>
                                </a>
                            </li>
                        @endrole
                    </ul>
                </li>
            @endhasrole

            @hasanyrole('mahasiswa|kemahasiswaan')
                <li class="{{ request()->is('kompetisi/register*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kompetisi.register') }}"><i
                            data-feather="award"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="Registrasi Kompetisi">{{ __('Registrasi Kompetisi') }}</span>
                    </a>
                </li>
                <li class="{{ request()->is('kompetisi/history*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kompetisi.history') }}"><i
                            data-feather="clock"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="History Kompetisi">{{ __('History Kompetisi') }}</span>
                    </a>
                </li>
            @endhasanyrole


            @hasanyrole('kemahasiswaan')
                <li class=" navigation-header"><span data-i18n="Report">{{ __('Report') }}</span><i
                        data-feather="more-horizontal"></i>
                </li>
                <li class="{{ request()->is('report/kegiatan*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('report.kegiatan') }}"><i
                            data-feather="file-text"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="Kegiatan Mahasiswa">{{ __('Kegiatan Mahasiswa') }}</span>
                    </a>
                </li>
                <li class="{{ request()->is('report/proposal*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('report.proposal') }}"><i
                            data-feather="file-text"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="Proposal Kegiatan">{{ __('Proposal Kegiatan') }}</span>
                    </a>
                </li>

                <li class=" navigation-header"><span data-i18n="Master">{{ __('Master Data') }}</span><i
                        data-feather="more-horizontal"></i>
                </li>
                {{-- MASTER DATA KEGIATAN --}}
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="database"></i><span
                    class="menu-title text-truncate" data-i18n="Master Kegiatan">Kegiatan</span></a>
                    <ul class="menu-content">
                            <li class="{{ request()->is('master/klasifikasi*') ? 'active' : '' }} nav-item">
                                <a class="d-flex align-items-center" href="{{ route('master.klasifikasi.index') }}"><i
                                        data-feather="circle"></i>
                                    <span class="menu-title text-truncate"
                                        data-i18n="Klasifikasi Kegiatan">{{ __('Klasifikasi Kegiatan') }}</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('master/periode*') ? 'active' : '' }} nav-item">
                                <a class="d-flex align-items-center" href="{{ route('master.periode.index') }}"><i
                                        data-feather="circle"></i>
                                    <span class="menu-title text-truncate" data-i18n="Periode">{{ __('Periode') }}</span>
                                </a>
                            </li>
                    </ul>
                </li>
                {{-- END MASTER DATA KEGIATAN --}}


                {{-- MASTER DATA KOMPETISI --}}
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="database"></i><span
                    class="menu-title text-truncate" data-i18n="Master Kompetisi">Kompetisi</span></a>
                    <ul class="menu-content">
                        <li class="{{ request()->is('master/skema*') ? 'active' : '' }} nav-item">
                            <a class="d-flex align-items-center" href="{{ route('master.skema.index') }}"><i
                                    data-feather="circle"></i>
                                <span class="menu-title text-truncate"
                                    data-i18n="Skema">{{ __('Skema') }}</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('master/review*') ? 'active' : '' }} nav-item">
                            <a class="d-flex align-items-center" href="{{ route('master.review.index') }}"><i
                                    data-feather="circle"></i>
                                <span class="menu-title text-truncate"
                                    data-i18n="Review">{{ __('Review') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- END MASTER DATA KOMPETISI --}}
                
                <li class="{{ request()->is('master/mahasiswa*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.mahasiswa.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate" data-i18n="Mahasiswa">{{ __('Mahasiswa') }}</span>
                    </a>
                </li>
                
                <li class="{{ request()->is('master/dosen*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.dosen.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate" data-i18n="Dosen">{{ __('Dosen') }}</span>
                    </a>
                </li>
                
                <li class="{{ request()->is('master/prodi*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.prodi.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate" data-i18n="Prodi">{{ __('Prodi') }}</span>
                    </a>
                </li>

                <li class="{{ request()->is('master/user*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.user.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate" data-i18n="User">{{ __('User') }}</span>
                    </a>
                </li>

                <li class="{{ request()->is('master/role*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.role.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate" data-i18n="Role">{{ __('Role') }}</span>
                    </a>
                </li>
            @endhasanyrole
        </ul>
    </div>
</div>
