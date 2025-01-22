<header>
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route("home")}}">Versenykezelő alkalmazás</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Versenykezelő</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        {{--Homepage--}}
                        <li class="nav-item">
                            <a class="nav-link {{Request::path() == '/' ? 'active' : '' }}" aria-current="page"
                                href="{{route("home")}}">Kezdőoldal</a>
                        </li>

                        {{-- Pages related to guests--}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link {{Request::path() == '/login' ? 'active' : '' }}" aria-current="page"
                                    href="{{route("login")}}">Bejelentkezés</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{Request::path() == '/register' ? 'active' : '' }}" aria-current="page"
                                    href="{{route("register")}}">Regisztráció</a>
                            </li>
                        @endguest

                         {{-- Pages related to logged in users--}}
                         @auth
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page"
                                    href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Kijelentkezés</a>
                                    <form id="logout-form" action="{{ route('logout.post') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>