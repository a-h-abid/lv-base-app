@extends('admin/layout/master')

@php
    $page_title = ucfirst($form_mode) . ' Role';
    $method = $form_mode == 'create' ? 'post' : 'put';
    $route = $form_mode == 'create' ? 'admin.users.roles.store' : 'admin.users.roles.update';
    $route_params = $form_mode == 'create' ? [] : [$role->id];
@endphp

@section('page-title', $page_title)

@section('content-title', $page_title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.roles.index') }}">Users Management -> Roles</a></li>
    <li class="breadcrumb-item active">{{ ucfirst($form_mode) }}</li>
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
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" placeholder="Name" value="{{ old('name') ?? $role->name }}">
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="guard_name" class="col-sm-3 col-form-label">Guard</label>
                <div class="col-sm-6">
                    <select id="guard_name" name="guard_name" class="form-control js-select2 {{ $errors->has('guard_name') ? 'is-invalid' : '' }}" data-placeholder="Guard">
                        <option value="web" {{ (old('guard_name') ?? $role->guard_name) == 'web' ? 'selected' : '' }} >web (Frontend)</option>
                        <option value="admin" {{ (old('guard_name') ?? $role->guard_name) == 'admin' ? 'selected' : '' }} >admin (Backend)</option>
                        <option value="api" {{ (old('guard_name') ?? $role->guard_name) == 'api' ? 'selected' : '' }} >api (API only)</option>
                    </select>
                    <small class="form-text text-muted">Select where the role is permitted to use.</small>
                    @if ($errors->has('guard_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('guard_name') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-sm-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </form>


    </div>
</div>
@endsection
