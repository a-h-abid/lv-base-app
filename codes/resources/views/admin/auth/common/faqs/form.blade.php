@extends('admin/layout/master')

@php
    $page_title = ucfirst($form_mode) . ' Faq';
    $method = $form_mode == 'create' ? 'post' : 'put';
    $route = $form_mode == 'create' ? 'admin.common.faqs.store' : 'admin.common.faqs.update';
    $route_params = $form_mode == 'create' ? [] : [$faq->id];
@endphp

@section('page-title', $page_title)

@section('content-title', $page_title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.common.faqs.index') }}">Faqs</a></li>
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
                <label for="question" class="col-sm-3 col-form-label">Question</label>
                <div class="col-sm-6">
                    <input type="text" name="question" class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" id="question" placeholder="Question" value="{{ old('question') ?? $faq->question }}">
                    @if ($errors->has('question'))
                    <div class="invalid-feedback">
                        {{ $errors->first('question') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="answer" class="col-sm-3 col-form-label">Answer</label>
                <div class="col-sm-6">
                    <textarea rows="10" name="answer" class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}" id="answer" placeholder="Answer">{{ old('answer') ?? $faq->answer }}</textarea>
                    @if ($errors->has('answer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('answer') }}
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
