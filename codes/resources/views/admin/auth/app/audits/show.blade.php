@extends('admin/layout/master')

@php
    $page_title = 'View Audit #'.$audit->id;
@endphp

@section('page-title', $page_title)

@section('content-title', $page_title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.app.audits.index') }}">App Management -> Audits</a></li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
@endsection

@section('contents')
<div class="card">
    @component('admin/components/card/header')
        @slot('title', $page_title)
    @endcomponent
    <div class="card-body">

        <form>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Date Time</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ $audit->created_at }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">User ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ $audit->user_id }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">User Type</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ str_replace('App\Eloquents\\', '', $audit->user_type) }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">User Full Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ optional($audit->user)->name }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">User Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ optional($audit->user)->username }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">User Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ optional($audit->user)->email }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">URL</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ $audit->url }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Event</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ $audit->event }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">IP Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ $audit->ip_address }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">User Agent</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ $audit->user_agent }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tags</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control-plaintext" value="{{ $audit->tags }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Old Values</label>
                <div class="col-sm-6">
                    <pre>@json($audit->old_values, JSON_PRETTY_PRINT)</pre>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">New Values</label>
                <div class="col-sm-6">
                    <pre>@json($audit->new_values, JSON_PRETTY_PRINT)</pre>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
