<aside id="sidebar" class="sidebar">

    <img src="{{asset('assets/img/kadjiv.png')}}" class="img-fluid" alt="BootstrapBrain Logo" width="200" height="80">
    <hr>

    <ul class="sidebar-nav" id="sidebar-nav">
        @can('rapports.acces-dashboard')
        <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'actif_menu' : '' }}" href="{{route('dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Tableau de bord</span>
            </a>
        </li>
        @endcan

        <li class="nav-item ">
            <a class="nav-link collapsed {{ request()->is('ventes') ? 'actif_menu' : '' }}" data-bs-target="#ventes-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cart-check d-block"></i><span>Ventes éffectuées</span><i class="bi bi-chevron-down ms-auto d-block"></i>
            </a>

            <ul id="ventes-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ventes.index') }}" class="nav-link">
                        <i class="bi bi-circle"></i><span>Ventes </span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside><!-- End Sidebar-->

<script src="{{ asset('assets/js/jquery3.6.min.js') }}"></script>
