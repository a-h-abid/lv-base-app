<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ config('app.name') }} Adminstrator</title>

    <link href="{{ mix('assets/admin/css/admin.css') }}" rel="stylesheet">

    @stack('css')

    <!-- Bootstrap core CSS-->
    {{-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- Custom fonts for this template-->
    {{-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> --}}

    <!-- Custom styles for this template-->
    {{-- <link href="css/sb-admin.css" rel="stylesheet"> --}}
  </head>
  <body class="guest-layout">

    <header class="app-name-admin text-center pt-4 pb-2">
        <h1>{{ config('app.name') }} Adminstrator</h1>
    </header>

    <div class="container">
        @include('admin/partials/flash')

        @yield('contents')
    </div>

    <script src="{{ mix('assets/admin/js/admin.js') }}"></script>

    @stack('scripts')
  </body>
</html>