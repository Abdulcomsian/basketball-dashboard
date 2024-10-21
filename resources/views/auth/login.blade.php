@extends('layouts.app')
@section('title', 'Sign in')
<style>
    body,
    html {
        overflow: hidden;
    }

    .logo {
        width: 100px !important;
        height: auto;
    }

    @media (min-width: 768px) {
        .logo {
            width: 200px;
        }
    }
</style>
@section('content')
    <div class="d-flex flex-column flex-root">
        <div
            class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <div class="bg-dark text-center p-3 mb-5 rounded-top">
                    <a href="#" class="mb-12">
                        <img alt="Logo" src="{{ asset('assets/src/media/logos/logo.png') }}" class="logo" />
                    </a>
                </div>
                <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        {{-- <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">Sign In to Basket Ball</h1>
                        <div class="text-gray-400 fw-bold fs-4">New Here?
                        <a href="{{ route('register') }}" class="fw-bolder light-orange">Create an Account</a></div>
                    </div> --}}
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="email"
                                placeholder="email here.." autocomplete="off" />
                        </div>
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                <a href="{{ route('password.request') }}" class="fs-6 fw-bolder light-orange">Forgot
                                    Password ?</a>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password"
                                placeholder="********" autocomplete="off" />
                        </div>
                        <div class="text-center">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg w-100 mb-5 orange-btn">
                                <span class="indicator-label">Continue</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
