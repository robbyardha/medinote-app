<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}" data-template="vertical-menu-template-free">

@include('partials.header')

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('partials.menu')

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                @include('partials.navbar')
                <!-- / Navbar -->

                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->


                    <!-- Footer -->
                    @include('partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>

            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        @include('partials.overlay')

    </div>
    <!-- / Layout wrapper -->


    @include('partials.script')
</body>

</html>
