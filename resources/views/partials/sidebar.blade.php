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

        <li class="nav-item ">
            <a class="nav-link collapsed {{ request()->is('factures') ? 'actif_menu' : '' }}" data-bs-target="#facturation-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-card-list"></i><span>Facturation</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="facturation-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('ventes.index') }}" class="nav-link">
                        <i class="bi bi-circle"></i><span>Factures </span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</aside><!-- End Sidebar-->

<script src="{{ asset('assets/js/jquery3.6.min.js') }}"></script>


<script>
    // $(document).ready(function() {
    //     var sidebarLinks = $('.sidebar-nav a');

    //     sidebarLinks.click(function(e) {
    //         sidebarLinks.removeClass('active');
    //         $(this).addClass('active');
    //         if ($(this).hasClass('collapsed')) {
    //             var parent = $(this).closest('.nav-item');
    //             parent.addClass('active');

    //             if (!parent.find('.collapse').hasClass('show')) {
    //                 parent.find('.collapse').addClass('show');
    //             }
    //         }
    //         $('.nav-item.active .collapse.show').not(parent.find('.collapse')).removeClass('show');
    //     });
    // });
</script>