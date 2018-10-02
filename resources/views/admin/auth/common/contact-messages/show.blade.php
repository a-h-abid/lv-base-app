@extends('admin/layout/master')

@php
    $page_title = 'View Contact Message';
@endphp

@section('page-title', $page_title)

@section('content-title', $page_title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.common.contact-messages.index') }}">Contact Messages</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('contents')
<div class="card">
    @component('admin/components/card/header')
        @slot('title', $page_title)
    @endcomponent
    <div class="card-body">

        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <span class="form-control-plaintext">{{ $contact->name }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <span class="form-control-plaintext">{{ $contact->email }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-6">
                <span class="form-control-plaintext">{{ $contact->phone }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="message" class="col-sm-3 col-form-label">Message</label>
            <div class="col-sm-6">
                <span class="form-control-plaintext">{{ $contact->message }}</span>
            </div>
        </div>

    </div>
</div>
@endsection
