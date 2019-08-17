<nav class="top-nav navbar navbar-expand static-top">

    <button class="btn btn-link btn-sm order-0 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <a class="navbar-brand ml-1" href="{{ route('admin.dashboard') }}">{{ config('app.name') }}</a>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto my-md-0">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.change-password') }}">Change Password</a>
                {{-- <a class="dropdown-item" href="#">Activity Log</a> --}}
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>

</nav>