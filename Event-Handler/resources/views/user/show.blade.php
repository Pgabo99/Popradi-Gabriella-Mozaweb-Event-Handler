@extends("layouts.default")
@section("title", "Profilom")
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

                {{-- Alert if there weren't any changes --}}
                @if(session()->has("warning"))
                    <div class="alert alert-warning">
                        {{session()->get("warning")}}
                    </div>
                @endif

                {{-- Profile card --}}
                <div class="card">
                    <h3 class="card-header text-center">Profilom</h3>
                    <div class="card-body">

                        {{-- Form based on the action () --}}
                        @if($editing)
                            <form method="POST" action="{{route("user.update", $user)}}">
                                @csrf
                                @method('put')
                        @else
                            <form method="GET" action="{{route("user.edit", $user)}}">
                                @csrf
                        @endif

                                {{-- Name --}}
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Vezetéknév" id="name" class="form-control"
                                        name="name" value="{{$user->name}}" {{$editing ? 'required autofocus' : 'disabled'}}>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{$errors->first('name')}}</span>
                                    @endif
                                </div>

                                {{-- Email --}}
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                                        value="{{$user->email}}" {{$editing ? 'required' : 'disabled'}}>
                                    @if($errors->has('email'))
                                        <span class="text-danger">{{$errors->first('email')}}</span>
                                    @endif
                                </div>

                                {{-- Submit button --}}
                                <div class="d-grid mx-auto">
                                    <button type="submit"
                                        class="btn btn-dark btnk-block">{{$editing ? 'Mentés' : 'Szerkesztés'}}</button>
                                </div>
                            </form>

                            <br>

                            {{-- Delete button --}}
                            <div class="d-grid mx-auto">
                                <a class="btn btn-danger" href="#"
                                    onclick="return confirmDelete('delete-form');">Törlés</a>
                                <form id="delete-form" action="{{ route('user.destroy', $user) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('delete')
                                </form>
                            </div>

                            {{-- Back button, only avalaible during editing --}}
                            @if($editing)
                                <br>
                                <div class="d-grid mx-auto">
                                    <a class="btn btn-dark" href="{{ url()->previous()}}">Mégse</a>
                                </div>

                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    
    //Confirmation before deleting the data
    function confirmDelete(formId) {
        if (confirm("Biztos, hogy törölni akarod?"))
            document.getElementById(formId).submit();
    }

</script>
@endsection