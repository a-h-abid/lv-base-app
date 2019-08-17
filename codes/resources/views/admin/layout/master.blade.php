<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ config('app.name') }} Adminstrator</title>

    <base href="{{ url('/') }}">

    <link href="{{ mix('assets/admin/css/admin.css') }}" rel="stylesheet">

    @stack('css')

    <!-- Page level plugin CSS-->
    {{-- <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet"> --}}
</head>
<body id="page-top" class="master-layout">

    @include('admin/partials/navbar')

    <div id="wrapper">

        @include('admin/partials/sidebar')

        <div id="content-wrapper">

            <div class="container-fluid mb-3">

                @include('admin/partials/flash')

                @include('admin/partials/breadcrumb')

                <!-- Page Content -->
                <h1>@yield('content-title', 'Content Title')</h1>
                <hr>

                @yield('contents')

            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © {{ config('app.name') }} {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('admin/partials/logout-modal')

    <script src="{{ mix('assets/admin/js/admin.js') }}"></script>

    @stack('scripts')
</body>
</html>