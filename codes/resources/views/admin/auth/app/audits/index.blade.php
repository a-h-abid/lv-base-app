@extends('admin/layout/master')

@section('page-title', 'Audits List')

@section('content-title', 'Audits List')

@section('breadcrumb')
    <li class="breadcrumb-item active">App Management -> Audits</li>
@endsection

@section('contents')

<div class="card">
    @component('admin/components/card/header')
        @slot('title', 'Audits List')
    @endcomponent
    <div class="card-body">

        <p>Total Records: {{ $total }}</p>

        @component('admin/components/table')
            @slot('headers')
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">DateTime</th>
                    <th scope="col">User</th>
                    <th scope="col">URL</th>
                    <th scope="col">Event</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">User Agent</th>
                    <th scope="col">Tags</th>
                    <th scope="col"></th>
                </tr>
            @endslot

            @foreach ($audits as $audit)
            <tr>
                <th scope="row">{{ $audit->id }}</th>
                <th scope="row">{{ $audit->created_at }}</th>
                <td>
                    <ul class="list-unstyled">
                        <li><strong>ID: </strong> {{ $audit->user_id }}</li>
                        <li><strong>Type: </strong> {{ str_replace('App\Eloquents\\', '', $audit->user_type) }}</li>
                        <li><strong>Name: </strong> {{ optional($audit->user)->name }}</li>
                        <li><strong>Userame: </strong> {{ optional($audit->user)->username }}</li>
                        <li><strong>Email: </strong> {{ optional($audit->user)->email }}</li>
                    </ul>
                </td>
                <td>{{ $audit->url }}</td>
                <td>{{ $audit->event }}</td>
                <td>{{ $audit->ip_address }}</td>
                <td>{{ $audit->user_agent }}</td>
                <td>{{ $audit->tags }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.app.audits.show', [$audit->id]) }}" class="btn btn-sm btn-primary">View</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endcomponent

        {{ $audits->links() }}
    </div>
</div>

@endsection
