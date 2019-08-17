@extends(auth('admin')->check() ? 'admin/layout/master' : 'admin/layout/guest')

@section('page-title', 'Page not found')

@section('content-title', 'Page not found')

@section('breadcrumb')
    <li class="breadcrumb-item active">Page not found</li>
@endsection

@section('contents')

    @php
        $homeUrl = auth('admin')->check() ? route('admin.dashboard') : route('admin.login');
    @endphp

    <!-- Page Content -->
    <h1 class="display-1">404</h1>
    <p class="lead">Page not found. You can
        <a href="javascript:history.back()">go back</a>
        to the previous page, or
        <a href="{{ $homeUrl }}">return home</a>.
    </p>

@endsection
