<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                            data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                    id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">Halo, {{ session('user.nama') }}</span>
                        <span class="user-status">{{ session('user.email') }}</span>
                    </div>

                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    @php
                        $user = Auth::user();
                    @endphp
                    @foreach ($user->getRoleNames() as $role)
                        <span class="dropdown-item"><i class="mr-50" data-feather="check-circle"></i>
                            {{ Str::ucfirst($role) }}</span>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="page-profile.html"><i class="mr-50" data-feather="user"></i>
                        Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="mr-50" data-feather="power"></i>
                        Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
