@extends('admin/layout/master')

@section('page-title', 'Faqs')

@section('content-title', 'Faqs')

@section('breadcrumb')
    <li class="breadcrumb-item active">Faqs</li>
@endsection

@section('contents')

<div class="card">
    @component('admin/components/card/header')
        @slot('title', 'Faqs List')

        @slot('buttons')
            <a href="{{ route('admin.common.faqs.create') }}" class="btn btn-primary">Create</a>
        @endslot
    @endcomponent
    <div class="card-body">

        <p>Total Records: {{ $total }}</p>

        @component('admin/components/table')
            @slot('headers')
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Question</th>
                    <th scope="col"></th>
                </tr>
            @endslot

            @foreach ($faqs as $faq)
            <tr>
                <th scope="row">{{ $faq->id }}</th>
                <td>{{ $faq->question }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('admin.common.faqs.edit', [$faq->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="#" data-href="{{ route('admin.common.faqs.destroy', [$faq->id]) }}" class="btn btn-sm btn-danger js-entity-delete" data-toggle="modal" data-target="#deleteModal">Delete</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endcomponent

        {{ $faqs->links() }}
    </div>
</div>

@include('admin/partials/delete-modal')

@endsection