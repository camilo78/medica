<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="d-md-none">
        <input type="text" class="form-control" id="search-users1" placeholder="{{ __('Buscar Paciente') }}"
               aria-label="search required" aria-describedby="search">
        <div class="bg-light pl-4 p-3 shadow" id="dynamic1"
             style="position: absolute; margin-left: -11px;display: none;z-index: 999999">
            <div id='loader1'>Procesando
                <img
                    src='https://mir-s3-cdn-cf.behance.net/project_modules/disp/35771931234507.564a1d2403b3a.gif'
                    width='32px' id="loader"
                >
            </div>
        </div>
    </div>
    <ul class="nav">
        @if(Auth::user()->getRoleNames()->first() == 'Admin' or Auth::user()->getRoleNames()->first() == 'Médico')
        <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Estadísticas</span>
            </a>
        </li>
        @endif
        @can('user-list')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">{{__('Modulo de Usuarios')}}</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="auth">
                    <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"> {{__('Admin. Usuarios')}} </a>
                            </li>
                        @can('role-list')
                            <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}"> {{__('Admin. Roles')}} </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
        @if(Auth::user()->getRoleNames()->first() == 'Médico')
            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.index')}}">
                    <i class="mdi mdi-hospital-building menu-icon"></i>
                    <span class="menu-title">Clínica</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
