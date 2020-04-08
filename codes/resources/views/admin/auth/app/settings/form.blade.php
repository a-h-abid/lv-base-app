@extends('admin/layout/master')

@php
    $page_title = 'Settings';
    $method = 'post';
    $route = 'admin.app.settings.save';
    $route_params = [];
@endphp

@section('page-title', $page_title)

@section('content-title', $page_title)

@section('breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
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
                <label for="help-url" class="col-sm-3 col-form-label">Help URL</label>
                <div class="col-sm-6">
                    <input type="text" name="settings[help-url]" class="form-control {{ $errors->has('settings.help-url') ? 'is-invalid' : '' }}" id="help-url" placeholder="Help URL" value="{{ old('settings.help-url') ?? $settings->settings['help-url'] ?? null }}">
                    @if ($errors->has('settings.help-url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('settings.help-url') }}
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
