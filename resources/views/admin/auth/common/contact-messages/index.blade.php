@extends('admin/layout/master')

@section('page-title', 'Contact Messages')

@section('content-title', 'Contact Messages')

@section('breadcrumb')
    <li class="breadcrumb-item active">Contact Messages</li>
@endsection

@section('contents')

<div class="card">
    @component('admin/components/card/header')
        @slot('title', 'Contact Messages List')
    @endcomponent
    <div class="card-body">

        <p>Total Records: {{ $total }}</p>

        @component('admin/components/table')
            @slot('headers')
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col"></th>
                </tr>
            @endslot

            @foreach ($contactMessages as $contactMessage)
            <tr>
                <th scope="row">{{ $contactMessage->id }}</th>
                <td>{{ $contactMessage->name }}</td>
                <td>{{ $contactMessage->email }}</td>
                <td>{{ $contactMessage->phone }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.common.contact-messages.show', [$contactMessage->id]) }}" class="btn btn-sm btn-info">View</a>
                        <a href="#" data-href="{{ route('admin.common.contact-messages.destroy', [$contactMessage->id]) }}" class="btn btn-sm btn-danger js-entity-delete" data-toggle="modal" data-target="#deleteModal">Delete</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endcomponent

        {{ $contactMessages->links() }}
    </div>
</div>

@include('admin/partials/delete-modal')

@endsection