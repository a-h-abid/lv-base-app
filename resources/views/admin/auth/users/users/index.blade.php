@extends('admin/layout/master')

@section('page-title', 'Users List')

@section('content-title', 'Users List')

@section('breadcrumb')
    <li class="breadcrumb-item active">Users Management -> Users</li>
@endsection

@section('contents')

<div class="card">
    @component('admin/components/card/header')
        @slot('title', 'Users List')

        @slot('buttons')
            <a href="{{ route('admin.users.users.create') }}" class="btn btn-primary">Create</a>
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

            @foreach ($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->active == '1')
                        <span class="badge badge-success">Yes</span>
                    @else
                        <span class="badge badge-danger">No</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.users.users.edit', [$user->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="#" data-href="{{ route('admin.users.users.destroy', [$user->id]) }}" class="btn btn-sm btn-danger js-entity-delete" data-toggle="modal" data-target="#deleteModal">Delete</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endcomponent

        {{ $users->links() }}
    </div>
</div>

@include('admin/partials/delete-modal')

@endsection
