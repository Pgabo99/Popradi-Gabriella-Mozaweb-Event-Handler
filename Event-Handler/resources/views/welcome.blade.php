@extends("layouts.default")
@section("title", "Kezdőoldal")
@section("content")

<p class="d-inline-flex gap-1">
    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
        aria-controls="collapseExample">
        Szűrés
    </a>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <form method="GET" action="{{ route('home') }}" class="searchForm">

            <div class="mb-3">
                <label for="searchName" class="form-label">Név</label>
                <input type="text" class="form-control" id="searchName" name="searchName"
                    value="{{ request()->get('searchName', '') }}">

                <label for="searchLocation" class="form-label">Helyszín</label>
                <input type="text" class="form-control" id="searchLocation" name="searchLocation"
                    value="{{ request()->get('searchLocation', '') }}">

                <label for="searchDescription" class="form-label">Leírás</label>
                <input type="text" class="form-control" id="searchDescription" name="searchDescription"
                    value="{{ request()->get('searchDescription', '') }}">

                <label for="searchType" class="form-label">Típus</label>
                <select class="form-control" id="searchType" name="searchType"
                    value="{{ request()->get('searchName', '') }}">
                    <option></option>
                    <option value="public">Nyílt</option>
                    <option value="private">Zártkörű</option>
                </select>

                <label for="searchFromDate" class="form-label">Mettől</label>
                <input type="date" min="2025-01-01" value="2025-01-01" class="form-control" id="searchFromDate" name="searchFromDate"
                    value="{{ request()->get('searchFromDate', '') }}">

                <label for="searchToDate" class="form-label">Meddig</label>
                <input type="date" min="2025-01-01" value="2025-12-31" class="form-control" id="searchToDate" name="searchToDate"
                    value="{{ request()->get('searchToDate', '') }}">
            </div>
            <button type="submit" class="btn btn-primary">Keresés</button>
        </form>
    </div>
</div>

@include('events.preview')

@include('events.show')

@endsection