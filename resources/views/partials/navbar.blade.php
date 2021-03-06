<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="{{route('home')}}"><img src="{{asset('images/logo.svg')}}" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="{{route('home')}}"><img
                    src="{{asset('images/logo-mini.svg')}}" alt="logo"/></a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-sort-variant"></span>
            </button>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-4 w-100">
            @if(Auth::user()->getRoleNames()->first() == 'Admin' or Auth::user()->getRoleNames()->first() == 'Médico' or Auth::user()->getRoleNames()->first() == 'Asistente')
            <li class="nav-item nav-search d-none d-md-block w-100">
                <div class="input-group">
                    <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="mdi mdi-magnify"></i>
                </span>
                    </div>
                    <input type="search required" class="form-control" id="search-users" placeholder="{{ __('Buscar Paciente') }}"
                           aria-label="search" aria-describedby="search">
                    <div class="pl-4 py-2 bg-light w-100 shadow" id="dynamic"
                         style="position: absolute;margin-top:40px; margin-left: -11px;display: none">
                        <div id='loader'>Procesando
                            <img
                                src='https://mir-s3-cdn-cf.behance.net/project_modules/disp/35771931234507.564a1d2403b3a.gif'
                                width='32px' id="loader"
                            >
                        </div>
                    </div>
                </div>
            </li>
            @else
                <li class="nav-item h4 text-primary">
                    <span class="h3"> {{ Auth::user()->gender == 'M' ? '👨‍⚕ ' : '👩‍⚕️ ' }} </span> ¡Bienvenid{{$user->gender == 'M' ? 'o' : 'a'}} a tu perfil en línea de {{ Auth::user()->setting->name }}!
                </li>
            @endif
        </ul>

        <ul class="navbar-nav navbar-nav-right">
            @if(session('impersonate_by'))
            <li class="nav-item">
                <a href="{{ route('impersonate.stop') }}" class="btn btn-sm btn-inverse-primary">Administrador</a>
            </li>
            @endif
            <li class="nav-item dropdown mr-1">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                   id="messageDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-message-text mx-0"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                    <a class="dropdown-item">
                        <div class="item-thumbnail">
                            <img src="{{asset('images/faces/face4.jpg')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="item-content flex-grow">
                            <h6 class="ellipsis font-weight-normal">David Grey
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                The meeting is cancelled
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item">
                        <div class="item-thumbnail">
                            <img src="{{asset('images/faces/face2.jpg')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="item-content flex-grow">
                            <h6 class="ellipsis font-weight-normal">Tim Cook
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                New product launch
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item">
                        <div class="item-thumbnail">
                            <img src="{{asset('images/faces/face3.jpg')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="item-content flex-grow">
                            <h6 class="ellipsis font-weight-normal"> Johnson
                            </h6>
                            <p class="font-weight-light small-text text-muted mb-0">
                                Upcoming board meeting
                            </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown mr-4">
                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown"
                   id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell mx-0"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                    <a class="dropdown-item">
                        <div class="item-thumbnail">
                            <div class="item-icon bg-success">
                                <i class="mdi mdi-information mx-0"></i>
                            </div>
                        </div>
                        <div class="item-content">
                            <h6 class="font-weight-normal">Application Error</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                Just now
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item">
                        <div class="item-thumbnail">
                            <div class="item-icon bg-warning">
                                <i class="mdi mdi-settings mx-0"></i>
                            </div>
                        </div>
                        <div class="item-content">
                            <h6 class="font-weight-normal">Settings</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                Private message
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item">
                        <div class="item-thumbnail">
                            <div class="item-icon bg-info">
                                <i class="mdi mdi-account-box mx-0"></i>
                            </div>
                        </div>
                        <div class="item-content">
                            <h6 class="font-weight-normal">New user registration</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">
                                2 days ago
                            </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="@if(Auth::user()->avatar == null)
                       {{asset('images/sin_imagen.jpg')}}
                                @else
                       {{asset('storage/'.Auth::user()->avatar)}}
                                @endif" alt="profile"/>
                    <span class="nav-profile-name">{{ Auth::user()->name1 .' '.Auth::user()->surname1 }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('users.edit',Auth::user()->id ) }}">
                        <i class="mdi mdi-account-edit text-primary"></i>
                        {{ __('Profile') }}
                    </a>
                    @role('Médico')
                    <a class="dropdown-item" href="{{route('settings.create')}}">
                        <i class="mdi mdi-settings text-primary"></i>
                        {{ __('Settings') }}
                    </a>
                    @endrole
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout text-primary"></i>
                        {{ __('Logout') }}
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>


            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
