<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <h2 href="#" class="pt-3 mb-0 brand-logo fw-bold text-center">
            MOBISCHO<small></small>
        </h2>
    </div>
    <ul class="nav">
        <li class="nav-item nav-category mb-0">
            <span class="nav-link">{{ __('messages.sidebar.main') }}</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">{{ __('messages.sidebar.dashboard') }}</span>
            </a>
        </li>

        @if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin')
            <li class="nav-item nav-category mt-3">
                <span class="nav-link">{{ __('messages.sidebar.admin') }}</span>
            </li>
        @endif

        @if (Auth::user()->role == 'super_admin')
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('activity.logs') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-school"></i>
                    </span>
                    <span class="menu-title">Activity Logs</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('schools.all') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-school"></i>
                    </span>
                    <span class="menu-title">{{ __('messages.sidebar.schools') }}</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('admins.index')}}">
                    <span class="menu-icon">
                        <i class="mdi mdi-account-multiple"></i>
                    </span>
                    <span class="menu-title">Admins</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-account"></i>
                    </span>
                    <span class="menu-title">{{ __('messages.sidebar.staff') }}</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin')

            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('abonnes') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-file-document-box"></i>
                    </span>
                    <span class="menu-title">Abonnes</span>
                </a>
            </li>
        @endif


        <li class="nav-item nav-category mt-3">
            <span class="nav-link">{{ __('messages.sidebar.data') }}</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('classes.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-school"></i>
                </span>
                <span class="menu-title">{{ __('messages.sidebar.classes') }}</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('subjects.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">{{ __('messages.sidebar.subjects') }}</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('teachers.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple"></i>
                </span>
                <span class="menu-title">{{ __('messages.sidebar.teachers') }}</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('students.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple"></i>
                </span>
                <span class="menu-title">{{ __('messages.sidebar.students') }}</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('marks.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-file-document-box"></i>
                </span>
                <span class="menu-title">{{ __('messages.sidebar.marks') }}</span>
            </a>
        </li>

        @if (Auth::user()->role == 'user')
            <li class="nav-item nav-category mt-3">
                <span class="nav-link">{{ __('messages.sidebar.download') }}</span>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('downloads.attendance') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-file-document-box"></i>
                    </span>
                    <span class="menu-title">{{ __('messages.sidebar.delays') }}</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('downloads.marks') }}">
                    <span class="menu-icon">
                        <i class="mdi mdi-file-document-box"></i>
                    </span>
                    <span class="menu-title">{{ __('messages.sidebar.notes') }}</span>
                </a>
            </li>
        @endif

        <li class="nav-item nav-category mt-3">
            <span class="nav-link">{{ __('messages.sidebar.templates') }}</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('template.index') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-security"></i>
                </span>
                <span class="menu-title">{{ __('messages.sidebar.templates') }}</span>
            </a>
        </li>
    </ul>
</nav>
