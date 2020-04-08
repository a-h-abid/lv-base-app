<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @canany(['admin','admin.users'])
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-fw fa-user"></i>
        <span>Users Management</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        @canany(['admin','admin.users','admin.users.admins'])
        <a class="dropdown-item" href="{{ route('admin.users.admins.index') }}">Admins</a>
        @endcanany
        @canany(['admin','admin.users','admin.users.users'])
        <a class="dropdown-item" href="{{ route('admin.users.users.index') }}">Users</a>
        @endcanany
        <div class="dropdown-divider"></div>
        @canany(['admin','admin.users','admin.users.roles'])
        <a class="dropdown-item" href="{{ route('admin.users.roles.index') }}">Roles</a>
        @endcanany
      </div>
    </li>
    @endcanany

    @canany(['admin','admin.common', 'admin.common.faqs'])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.common.faqs.index') }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Faqs</span>
        </a>
    </li>
    @endcanany

    @canany(['admin','admin.common', 'admin.common.contact-messages'])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.common.contact-messages.index') }}">
            <i class="fas fa-fw fa-phone-square"></i>
            <span>Contact Messages</span>
        </a>
    </li>
    @endcanany

    @canany(['admin','admin.app','admin.app.settings'])
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.app.settings.form') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </a>
    </li>
    @endcanany

</ul>