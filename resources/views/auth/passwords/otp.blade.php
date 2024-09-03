@extends('layouts.app')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <div class="login-logo">
            <a href="{{ route('admin.home') }}">
                {{ trans('panel.site_title') }}
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">
                {{ trans('global.otp_verification') }}
            </p>

            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.otp.verification') }}">
                @csrf
                
                <div class="form-group">
                    <label for="username">{{ trans('cruds.user.fields.username') }}</label>
                    <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text"
                        name="username" id="username" required value="{{ $username }}" readonly>
                    @if ($errors->has('username'))
                        <span class="text-danger">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="username">{{ trans('global.otp') }}</label>
                    <input id="otp" type="numebr" class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}" name="otp" required autocomplete="otp" autofocus placeholder="{{ trans('global.otp') }}" value="{{ old('otp') }}">

                    @if($errors->has('otp'))
                        <span class="text-danger">
                            {{ $errors->first('otp') }}
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-primary btn-flat btn-block">
                            {{ trans('global.submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection