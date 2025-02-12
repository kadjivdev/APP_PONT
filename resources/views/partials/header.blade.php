<header id="header" class="header fixed-top d-flex align-items-center " style="background-color: #000;">

    <div class="d-flex flex-row align-items-center justify-content-between global_container_left">
        <button type="button" class="btn btn-warning toggle-sidebar-btn">
            <i class="bi bi-list "></i>
        </button> &nbsp;
        <div class="mx-3 d-flex flex-column justify-content-center align-items-center ">
            <span class="d-flex align-items-center app_title" style="font-size: 1.5rem;">QUINCA-KADJIV</span>
        </div>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                    data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2 text-white">{{ Auth::user()->name }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span><small>{{ Auth::user()->roles->pluck('name')->first() }}</small></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Déconnexion</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->