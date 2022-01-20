<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if(Auth::user()->getRoleNames()->first() == 'Admin' or Auth::user()->getRoleNames()->first() == 'Médico')
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">
                    <i class="mdi mdi-chart-bar menu-icon"></i>
                    <span class="menu-title">{{ __("Statistics") }}</span>
                </a>
            </li>

        @endif
        @can('user-list')
            <li class="nav-item">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">{{ __("Users") }}</span>
                </a>
            </li>
        @endcan
        @can('role-list')
            <li class="nav-item">
                <a class="nav-link" href="{{route('roles.index')}}">
                    <i class="mdi mdi-tag menu-icon"></i>
                    <span class="menu-title">{{ __("Roles") }}</span>
                </a>
            </li>
        @endcan
        @role('Médico')
        <li class="nav-item">
            <a class="nav-link" href="{{route('settings.index')}}">
                <i class="mdi mdi-hospital-building menu-icon"></i>
                <span class="menu-title">{{ __("Clinic") }}</span>
                @if(Auth::User()->setting_id == null)
                    <span class="badge bg-Warning">Completar</span>
                @endif
            </a>
        </li>
        @endrole
    </ul>
</nav>
