<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <h2 href="#" class="pt-3 mb-0 brand-logo fw-bold text-center">
            E-SCHOOL<small></small>
        </h2>
    </div>
    <ul class="nav">
        <li class="nav-item nav-category mb-0">
            <span class="nav-link">MAIN</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- @if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin') --}}
            <li class="nav-item nav-category mt-3">
                <span class="nav-link">ADMINISTRATION</span>
            </li>
        {{-- @endif --}}

        {{-- @if (Auth::user()->role == 'super_admin') --}}
            <li class="nav-item menu-items">
                <a class="nav-link" href="">
                    <span class="menu-icon">
                        <i class="mdi mdi-school"></i>
                    </span>
                    <span class="menu-title">Logs</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('classes.index')}}">
                    <span class="menu-icon">
                        <i class="mdi mdi-school"></i>
                    </span>
                    <span class="menu-title">Manage Classes</span>
                </a>
            </li>
            {{-- <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('subjects.index')}}">
                    <span class="menu-icon">
                        <i class="mdi mdi-account-multiple"></i>
                    </span>
                    <span class="menu-title">Manage Subjects</span>
                </a>
            </li> --}}
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('students.index')}}">
                    <span class="menu-icon">
                        <i class="mdi mdi-account"></i>
                    </span>
                    <span class="menu-title">Manage Students</span>
                </a>
            </li>

            <li class="nav-item menu-items">
                <a class="nav-link" href="{{ route('marks.index')}}">
                    <span class="menu-icon">
                        <i class="mdi mdi-file-document-box"></i>
                    </span>
                    <span class="menu-title">Manage Marks</span>
                </a>
            </li>

        <li class="nav-item nav-category mt-3">
            <span class="nav-link">DOCUMENTATION</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('reports.create')}}">
                <span class="menu-icon">
                    <i class="mdi mdi-security"></i>
                </span>
                <span class="menu-title"># Report Cards</span>
            </a>
        </li>
    </ul>
</nav>
