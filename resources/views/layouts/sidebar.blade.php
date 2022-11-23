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


            <li class=" navigation-header"><span data-i18n="Kegiatan">{{ __('Kegiatan Mahasiswa') }}</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @hasanyrole('mahasiswa|kemahasiswaan|dosen')
                <li class="{{ request()->is('kegiatan/create*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kegiatan.create') }}"><i
                            data-feather="file-plus"></i>
                        <span class="menu-title text-truncate" data-i18n="Input Kegiatan">{{ __('Input Kegiatan') }}</span>
                    </a>
                </li>
            @endhasrole
            @hasanyrole('mahasiswa')
                <li class="{{ request()->is('kegiatan/history*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kegiatan.history') }}"><i data-feather="clock"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="History Kegiatan">{{ __('History Kegiatan') }}</span>
                    </a>
                </li>
            @endhasrole

            @hasanyrole('dosen|kemahasiswaan')
                <li class="{{ request()->is('kegiatan/list*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('kegiatan.list') }}"><i data-feather="list"></i>
                        <span class="menu-title text-truncate" data-i18n="List Kegiatan">{{ __('List Kegiatan') }}</span>
                    </a>
                </li>
            @endhasanyrole


            <li class=" navigation-header"><span data-i18n="Proposal">{{ __('Proposal Kegiatan') }}</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @hasrole('mahasiswa')
                <li class="{{ request()->is('proposal/create*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('proposal.create') }}"><i
                            data-feather="file-plus"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="Input Proposal">{{ __('Input Proposal') }}</span>
                    </a>
                </li>
                <li class="{{ request()->is('proposal/history*') ? 'active' : '' }} nav-item"><a
                        class="d-flex align-items-center" href="{{ route('proposal.history') }}">
                        <i data-feather="clock"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="History Proposal">{{ __('History Proposal') }}</span></a>
                </li>
            @endhasrole('mahasiswa')

            @hasanyrole('dosen|kemahasiswaan')
                <li class="{{ request()->is('proposal/list*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('proposal.list') }}"><i data-feather="list"></i>
                        <span class="menu-title text-truncate" data-i18n="List Proposal">{{ __('List Proposal') }}</span>
                    </a>
                </li>
            @endhasanyrole

            @hasanyrole('dosen|kemahasiswaan')
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            data-feather="check"></i><span class="menu-title text-truncate"
                            data-i18n="Approval">Approval</span></a>
                    <ul class="menu-content">
                        @role('dosen')
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
                        @endrole
                    </ul>
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
                <li class="{{ request()->is('master/klasifikasi*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.klasifikasi.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate"
                            data-i18n="Klasifikasi Kegiatan">{{ __('Klasifikasi Kegiatan') }}</span>
                    </a>
                </li>
                <li class="{{ request()->is('master/mahasiswa*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.mahasiswa.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate" data-i18n="Mahasiswa">{{ __('Mahasiswa') }}</span>
                    </a>
                </li>
                <li class="{{ request()->is('master/periode*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('master.periode.index') }}"><i
                            data-feather="database"></i>
                        <span class="menu-title text-truncate" data-i18n="Periode">{{ __('Periode') }}</span>
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
