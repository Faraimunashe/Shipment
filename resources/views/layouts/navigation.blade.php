<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @if (Auth::user()->hasRole('admin'))
            <li class="nav-item">
                <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin-categories') }}">
                    <i class="bi bi-bookmark-dash"></i>
                    <span>Categories</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin-products') }}">
                <i class="bi bi-cart4"></i>
                <span>Products</span>
                </a>
            </li><!-- End F.A.Q Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin-orders') }}">
                <i class="bi bi-card-list"></i>
                <span>Orders</span>
                </a>
            </li><!-- End Contact Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-register.html">
                <i class="bi bi-tsunami"></i>
                <span>Shipments</span>
                </a>
            </li><!-- End Register Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin-checkpoints')}}">
                <i class="bi bi-geo"></i>
                <span>Check points</span>
                </a>
            </li><!-- End Login Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin-transporters')}}">
                <i class="bi bi-truck"></i>
                <span>Transporter</span>
                </a>
            </li><!-- End Error 404 Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin-users')}}">
                <i class="bi bi-person"></i>
                <span>Users</span>
                </a>
            </li><!-- End Error 404 Page Nav -->

        @elseif (Auth::user()->hasRole('transporter'))
            <li class="nav-item">
                <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('transporter-shipments') }}">
                    <i class="bi bi-truck"></i>
                    <span>Shipments</span>
                </a>
            </li><!-- End Profile Page Nav -->
        @elseif (Auth::user()->hasRole('checkpoint'))

        @else

        @endif

        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
            <a class="nav-link collapsed" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="bi bi-lock"></i>
            <span>Logout</span>
            </a>
        </li><!-- End Blank Page Nav -->

    </ul>

  </aside>
