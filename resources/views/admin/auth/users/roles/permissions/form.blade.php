@extends('admin/layout/master')

@php
    $page_title = 'Manage Role Permissions';
    $method = 'put';
    $route = 'admin.users.roles-permissions.update';
    $route_params = [$role->id];
@endphp

@section('page-title', $page_title)

@section('content-title', $page_title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.roles.index') }}">Users Management -> Roles</a></li>
    <li class="breadcrumb-item active">Permissions</li>
@endsection

@section('contents')

<div class="card">
    @component('admin/components/card/header')
        @slot('title', $page_title.' Form')
    @endcomponent
    <div class="card-body">

        <form action="{{ route($route, $route_params) }}" method="post">
            @csrf
            @method($method)

            <div class="form-group row">
                @foreach ($permissions as $permissionKey => $permissionData)
                <div class="offset-sm-1 col-sm-11">
                    @php
                    $isChecked = false;
                    if (in_array($permissionKey, $rolePermissions)) {
                        $isChecked = true;
                    }
                    @endphp
                    <label>
                        <input type="checkbox" name="permission[]" value="{{ $permissionKey }}" {{ $isChecked ? 'checked' : '' }} >
                        <span>{{ $permissionData['name'] }}</span>
                        <small>- {{ $permissionData['description'] }}</small>
                    </label>
                </div>
                @endforeach
            </div>

            <div class="form-group row">
                <div class="offset-sm-1 col-sm-11">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
