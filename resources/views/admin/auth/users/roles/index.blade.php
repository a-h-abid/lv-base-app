@extends('admin/layout/master')

@section('page-title', 'Roles List')

@section('content-title', 'Roles List')

@section('breadcrumb')
    <li class="breadcrumb-item active">Users Management -> Roles</li>
@endsection

@section('contents')

<div class="card">
    @component('admin/components/card/header')
        @slot('title', 'Roles List')

        @slot('buttons')
            <a href="{{ route('admin.users.roles.create') }}" class="btn btn-primary">Create</a>
        @endslot
    @endcomponent
    <div class="card-body">

        <p>Total Records: {{ $total }}</p>

        @component('admin/components/table')
            @slot('headers')
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Guard</th>
                    <th scope="col"></th>
                </tr>
            @endslot

            @foreach ($roles as $role)
            <tr>
                <th scope="row">{{ $role->id }}</th>
                <td>{{ $role->name }}</td>
                <td>{{ $role->guard_name }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.users.roles.edit', [$role->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{ route('admin.users.roles-permissions.edit', [$role->id]) }}" class="btn btn-sm btn-info">Permissions</a>
                        <a href="#" data-href="{{ route('admin.users.roles.destroy', [$role->id]) }}" class="btn btn-sm btn-danger js-entity-delete" data-toggle="modal" data-target="#deleteModal">Delete</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endcomponent

        {{ $roles->links() }}
    </div>
</div>

@include('admin/partials/delete-modal')

@endsection
