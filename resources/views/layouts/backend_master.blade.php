@include('partials.backend.header')

<body>

    <body>

        @include('partials.backend.preloader')

        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">



                @include('partials.backend.top_nav')


                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">


                        @include('partials.backend.side_nav')


                        @yield('backend_content')



                    </div>
                </div>
            </div>

            @include('partials.backend.footer')
