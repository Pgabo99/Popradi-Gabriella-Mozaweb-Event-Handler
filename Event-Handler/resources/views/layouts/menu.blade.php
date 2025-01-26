<header>
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route("home")}}">Eseménykezelő alkalmazás</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Eseménykezelő</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

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

                            {{--Homepage--}}
                            <li class="nav-item">
                                <a class="nav-link {{Request::path() == '/' ? 'active' : '' }}" aria-current="page"
                                    href="{{route("home")}}">Kezdőoldal</a>
                            </li>

                            {{--The dropdown --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Profil
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">

                                    {{-- Logged in users data--}}
                                    <li><a class="dropdown-item" href="{{route("user.show", Auth::id())}}">Adataim</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    {{-- Events created by the logged in user--}}
                                    <li><a class="dropdown-item" href="{{route("events.create")}}">Létrehezott
                                            eseményeim</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    {{-- Events that the user is going or invited--}}
                                    <li><a class="dropdown-item" href="{{route("user.events")}}">Jelenlegi eseményeim</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    {{-- Logout--}}
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Kijelentkezés</a>
                                        <form id="logout-form" action="{{ route('logout.post') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth

                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>