@extends("layouts.default")
@section("title", "Regisztráció")
@section("content")
<main class="mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                {{-- Alert if everything was successfull --}}
                @if(session()->has("success"))
                    <div class="alert alert-success">
                        {{session()->get("success")}}
                    </div>
                @endif

                {{-- Alert if there was an error --}}
                @if(session()->has("error"))
                    <div class="alert alert-danger">
                        {{session()->get("error")}}
                    </div>
                @endif

                {{-- Registration card --}}
                <div class="card">
                    <h3 class="card-header text-center">Regisztráció</h3>
                    <div class="card-body">
                        <form method="POST" action="{{route("register.post")}}">
                            @csrf

                            {{-- Name --}}
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Vezetéknév Keresztnév" id="name" class="form-control"
                                    name="name" required autofocus>
                                @if($errors->has('name'))
                                    <span class="text-danger">{{$errors->first('name')}}</span>
                                @endif
                            </div>

                           {{-- Email --}}
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                                    required>
                                @if($errors->has('email'))
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Jelszó" id="password" class="form-control"
                                    name="password" required>
                                @if($errors->has('password'))
                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                @endif
                            </div>

                            {{-- Password Again --}}
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Jelszó mégegyszer" id="password_again"
                                    class="form-control" name="password_again" required>
                                @if($errors->has('password_again'))
                                    <span class="text-danger">{{$errors->first('password_again')}}</span>
                                @endif
                            </div>

                            {{--Registration submit button--}}
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btnk-block">Regisztráció</button>
                            </div>

                            {{--Link for redirecting to the Login page--}}
                            <div class="d-grid mx-auto justify-content-center">
                                <p>Van már felhasználód?<a href="{{route("login")}}"
                                        class="link-primary">Bejelentkezés</a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection