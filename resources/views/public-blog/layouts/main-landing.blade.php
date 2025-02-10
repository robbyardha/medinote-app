@include('public-blog.partials-landing.header')

<body class="index-page">

    @include('public-blog.partials-landing.nav')


    <main class="main">

        @yield('content')

    </main>



    @include('public-blog.partials-landing.footer')
    @include('public-blog.partials-landing.script')
