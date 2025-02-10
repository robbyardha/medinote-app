<header id="header" class="header d-flex align-items-center fixed-top">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="#" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename">CMS-APP</h1>
        </a>

        @auth
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#">Hello, {{ Auth::user()->name }}</a></li>
                    <li><a href="{{ url('/dashboard') }}" class="active">Dashboard</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
            </form>

            <a class="btn-getstarted" href="javascript:void(0);"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
        @else
            <a class="btn-getstarted" href="{{ route('login') }}">Log In</a>
        @endauth



    </div>
</header>
