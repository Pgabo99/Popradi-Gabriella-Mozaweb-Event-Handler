@extends("layouts.default")
@section("title", "Bejelentkezés")
@section("content")
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

        {{-- Login card --}}
        <div class="card">
            <h3 class="card-header text-center">Bejelentkezés</h3>
            <div class="card-body">
                <form method="POST" action="{{route("login.post")}}">
                    @csrf

                    {{--Email--}}
                    <div class="form-group mb-3">
                        <input type="text" placeholder="Email" id="email" class="form-control" name="email" required
                            autofocus>
                        @if($errors->has('email'))
                            <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>

                    {{--Password--}}
                    <div class="form-group mb-3">
                        <input type="password" placeholder="Jelszó" id="password" class="form-control" name="password"
                            required>
                        @if($errors->has('password'))
                            <span class="text-danger">{{$errors->first('password')}}</span>
                        @endif
                    </div>

                    {{--Submit login button--}}
                    <div class="d-grid mx-auto">
                        <button type="submit" class="btn btn-dark btnk-block">Bejelentkezés</button>
                    </div>

                    {{--Link for redirecting to the Register page--}}
                    <div class="d-grid mx-auto justify-content-center">
                        <p>Még nincs felhasználód?<a href="{{route("register")}}" class="link-primary">Regisztráció</a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection