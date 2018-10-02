@extends('admin/layout/master')

@section('page-title', 'Change Password')

@section('content-title', 'Change Password')

@section('breadcrumb')
    <li class="breadcrumb-item active">Change Password</li>
@endsection

@section('contents')

<div class="card">
    <div class="card-header">
        Change Password
    </div>
    <div class="card-body">
        <form action="{{ route('admin.change-password') }}" method="post">
            @csrf
            <div class="form-group row">
                <label for="current_password" class="col-sm-3 col-form-label">Current Password</label>
                <div class="col-sm-6">
                    <input type="password" name="current_password" class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}" id="current_password" placeholder="Current Password">
                    @if ($errors->has('current_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_password') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                <div class="col-sm-6">
                    <input type="password" name="new_password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" id="new_password" placeholder="New Password">
                    @if ($errors->has('new_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('new_password') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="new_password_confirmation" class="col-sm-3 col-form-label">New Password Confirmation</label>
                <div class="col-sm-6">
                    <input type="password" name="new_password_confirmation" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" id="new_password_confirmation" placeholder="New Password Confirmation">
                    @if ($errors->has('new_password_confirmation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('new_password_confirmation') }}
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