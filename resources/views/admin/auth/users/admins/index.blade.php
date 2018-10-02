@extends('admin/layout/master')

@section('page-title', 'Admins List')

@section('content-title', 'Admins List')

@section('breadcrumb')
    <li class="breadcrumb-item active">Users Management -> Admins</li>
@endsection

@section('contents')

<div class="card">
    @component('admin/components/card/header')
        @slot('title', 'Admins List')

        @slot('buttons')
            <a href="{{ route('admin.users.admins.create') }}" class="btn btn-primary">Create</a>
        @endslot
    @endcomponent
    <div class="card-body">

        <p>Total Records: {{ $total }}</p>

        @component('admin/components/table')
            @slot('headers')
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Active</th>
                    <th scope="col"></th>
                </tr>
            @endslot

            @foreach ($admins as $admin)
            <tr>
                <th scope="row">{{ $admin->id }}</th>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>
                    @if ($admin->active == '1')
                        <span class="badge badge-success">Yes</span>
                    @else
                        <span class="badge badge-danger">No</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.users.admins.edit', [$admin->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="#" data-href="{{ route('admin.users.admins.destroy', [$admin->id]) }}" class="btn btn-sm btn-danger js-entity-delete" data-toggle="modal" data-target="#deleteModal">Delete</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endcomponent

        {{ $admins->links() }}
    </div>
</div>

@include('admin/partials/delete-modal')

@endsection
