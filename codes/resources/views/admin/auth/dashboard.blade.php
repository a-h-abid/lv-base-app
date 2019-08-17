@extends('admin/layout/master')

@section('page-title', 'Dashboard')

@section('content-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Overview</li>
@endsection

@section('contents')

    <div class="row">
        @canany(['admin','admin.dashboard.widgets.total-admins'])
        @component('admin/components/widget-cards')
            @slot('faIcon', 'fa-user-tie')
            @slot('viewText', 'Show Admins')
            @slot('link', route('admin.users.admins.index'))
            <strong>{{ $adminsCount }}</strong> Total Admins!
        @endcomponent
        @endcanany

        @canany(['admin','admin.dashboard.widgets.total-users'])
        @component('admin/components/widget-cards')
            @slot('faIcon', 'fa-user')
            @slot('bgColor', 'bg-secondary')
            @slot('viewText', 'Show Users')
            @slot('link', route('admin.users.users.index'))
            <strong>{{ $usersCount }}</strong> Total Users!
        @endcomponent
        @endcanany
    </div>

@endsection