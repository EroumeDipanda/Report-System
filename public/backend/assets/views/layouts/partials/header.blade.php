<nav class="navbar p-0 fixed-top d-flex flex-row">
    {{-- <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
        </a>
    </div> --}}
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav w-100">
            <li class="nav-item w-100">
                <div class="row gx-2">
                    <!-- Search Form -->
                    {{-- <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                            <input type="text" class="form-control" placeholder="{{ __('messages.navbar.search_placeholder') }}">
                        </form>
                    </div> --}}

                    <!-- School Name or Admin Label -->
                    <div class="col-12 col-md-6 text-center text-md-start">
                        <span class="fw-bold d-block d-md-inline" style="color: orange">
                            @if (Auth::user()->school)
                                {{ Auth::user()->school->name }}
                            @elseif (Auth::user()->role == 'super_admin')
                                SUPER ADMIN GENS
                            @elseif (Auth::user()->role == 'admin')
                                ADMIN GENS
                            @endif
                        </span>
                    </div>
                </div>
            </li>
        </ul>




        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-bell"></i>
                    @if ($notifications->count() > 0)
                        <span class="position-relative">
                            <span class="badge rounded-pill bg-danger text-white position-absolute p-1 translate-middle"
                                style="font-size: 0.60rem;">
                                {{ $notifications->count() }}
                            </span>
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <h6 class="dropdown-header px-3 py-2 mb-0">{{ __('messages.navbar.notifications') }}</h6>
                    <div class="dropdown-divider"></div>
                    @forelse ($notifications->take(5) as $notification)
                        <a class="dropdown-item preview-item d-flex align-items-center" href="#">
                            <div class="preview-thumbnail me-3">
                                <div class="preview-icon bg-light rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    @if (isset($notification->data['user_name']))
                                        <i class="mdi mdi-file-upload text-success" style="font-size: 20px;"></i>
                                    @else
                                        <i class="mdi mdi-alert text-danger" style="font-size: 20px;"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="preview-item-content flex-grow-1">
                                <div class="d-flex justify-content-between mb-1">
                                    <p class="preview-subject mb-0">{{ $notification->data['message'] }}</p>
                                    <small
                                        class="text-muted mb-0">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                </div>
                                @if (isset($notification->data['file_type']) && isset($notification->data['user_name']))
                                    <p class="text-muted mb-0">
                                        <small>Type de Ficher: {{ $notification->data['file_type'] }} | Charge par:
                                            {{ $notification->data['user_name'] }}</small>
                                    </p>
                                @endif
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    @empty
                        <p class="px-3 py-2 mb-0 text-center text-muted">{{ __('messages.navbar.no_notifications') }}
                        </p>
                    @endforelse

                    @if ($notifications->count() > 5)
                        <a class="dropdown-item text-center small text-primary"
                            href="{{ route('notifications.index') }}">
                            Voir toutes les notifications
                        </a>
                    @endif

                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                    <div class="navbar-profile">
                        <img class="img-xs rounded-circle"
                            src="{{ !empty(Auth::user()->photo) ? url('upload/profiles/' . Auth::user()->photo) : url('upload/no_image.jpg') }}"
                            alt="profile">
                        <p class="mb-0 d-none d-sm-block m-1">{{ Auth::user()->name }}</p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="profileDropdown">
                    <h6 class="p-3 mb-0">{{ __('messages.navbar.profile') }}</h6>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item" href="{{ route('profile.edit') }}">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-account text-success"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject mb-1">{{ __('messages.navbar.profile') }}</p>
                            </div>
                        </a>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item" href="{{ route('password.edit') }}">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-onepassword text-warning"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject mb-1">{{ __('messages.navbar.change_password') }}</p>
                            </div>
                        </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="{{ route('logout') }}">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">{{ __('messages.navbar.logout') }}</p>
                        </div>
                    </a>
                </div>
            </li>

            <!-- Language Switcher -->
            <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="languageDropdown" href="#"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('messages.navbar.language') }}
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown" aria-labelledby="languageDropdown">
                    <a class="dropdown-item"
                        href="{{ route('lang.switch', ['locale' => 'en']) }}">{{ __('English') }}</a>
                    <a class="dropdown-item"
                        href="{{ route('lang.switch', ['locale' => 'fr']) }}">{{ __('French') }}</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>
