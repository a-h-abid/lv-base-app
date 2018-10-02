@extends('admin/layout/guest')

@section('page-title', 'Login')

@section('contents')

<div class="card card-login mx-auto mt-5">
    <div class="card-header">Login</div>
    <div class="card-body">
        <form action="{{ route('admin.login') }}" method="post">
            @csrf

            <div class="form-group">
                <div class="form-label-group">
                    <input type="email" name="email" id="inputEmail" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email address" required="required" autofocus="autofocus">
                    <label for="inputEmail">Email address</label>
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="form-label-group">
                    <input type="password" name="password" id="inputPassword" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password" required="required">
                    <label for="inputPassword">Password</label>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        Remember Password
                    </label>
                </div>
            </div>

            <button class="btn btn-primary btn-block" type="submit">Login</button>
        </form>
    </div>
</div>
@endsection