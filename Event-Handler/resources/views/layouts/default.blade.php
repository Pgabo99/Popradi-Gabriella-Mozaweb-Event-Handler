<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{--Token for the CRUD methods --}}
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @yield("header")
  <title>@yield("title", "Versenykezelő")</title>
  {{-- Bootstrap--}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  {{-- DataTables--}}
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
  {{-- jQuery--}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  {{-- SweetAlert--}}
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  {{--Style for the clickable class--}}
  <style>
    .clickable {
      cursor: pointer;
    }
  </style>
</head>

<body>
  @include('layouts.menu')

  {{--Main concent--}}
  <main class="mt-5">
    <div class="container">
      @yield("content")
    </div>
  </main>
  {{-- Bootstrap--}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  {{-- DataTables--}}
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
</body>

{{-- csrf setup--}}
<script type="text/javascript">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });
</script>

</html>