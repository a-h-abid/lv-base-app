@extends('admin/layout/master')

@php
    $page_title = ucfirst($form_mode) . ' User';
    $method = $form_mode == 'create' ? 'post' : 'put';
    $route = $form_mode == 'create' ? 'admin.users.users.store' : 'admin.users.users.update';
    $route_params = $form_mode == 'create' ? [] : [$user->id];
@endphp

@section('page-title', $page_title)

@section('content-title', $page_title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.users.index') }}">Users Management -> User</a></li>
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
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" placeholder="Name" value="{{ old('name') ?? $user->name }}">
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">E-mail</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" placeholder="E-mail" value="{{ old('email') ?? $user->email }}">
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" placeholder="Password">
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password_confirmation" class="col-sm-3 col-form-label">Password Confirmation</label>
                <div class="col-sm-6">
                    <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" id="password_confirmation" placeholder="Password Confirmation">
                    @if ($errors->has('password_confirmation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-sm-3 col-sm-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="1" id="active" name="active" {{ (old('active') ?? $user->active) == 1 ? 'checked' : '' }} > Active
                        </label>
                    </div>
                    @if ($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="roles" class="col-sm-3 col-form-label">Roles</label>
                <div class="col-sm-6">
                    <select class="form-control {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple>
                        @foreach ($roles as $roleId => $roleName)
                        <option value="{{ $roleId }}" {{ (in_array($roleId, old('roles') ?? $user->roles->pluck('id')->toArray())) ? 'selected' : '' }} >{{ $roleName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" placeholder="Phone" value="{{ old('phone') ?? $user->phone }}">
                    @if ($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
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
