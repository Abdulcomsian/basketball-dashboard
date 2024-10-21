@extends('layouts.app')
@section('title', 'Software')
<style>
    .logo {
        width: 100px !important;
        /* Set a custom width */
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
                <a href="#" class="mb-12">
                    <img alt="Logo" src="{{ asset('assets/src/media/logos/logo.png') }}" class="logo" />
                </a>
                <div class="w-lg-600px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST"
                        action="{{ route('register') }}">
                        @csrf
                        {{-- <div class="mb-10 text-center">
                            <h1 class="text-dark mb-3">Create an Account</h1>
                            <div class="text-gray-400 fw-bold fs-4">Already have an account?
                                <a href="{{ route('login') }}" class="fw-bolder light-orange">Sign in here</a>
                            </div>
                        </div> --}}
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bolder text-dark fs-6">Name</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="name"
                                placeholder="name here..." autocomplete="off" required />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bolder text-dark fs-6">UserName</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="username"
                                placeholder="username here..." autocomplete="off" required />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bolder text-dark fs-6">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="email" name="email"
                                placeholder="email here..." autocomplete="off" required />
                        </div>
                        <div class="mb-10 fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">Password</label>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                placeholder="********" name="password" required />
                        </div>
                        <div class="fv-row mb-5">
                            <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                placeholder="********" name="password_confirmation" required />
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-check form-check-custom form-check-solid form-check-inline">
                                <input class="form-check-input" type="checkbox" name="toc" value="1" required />
                                <span class="form-check-label fw-bold text-gray-700 fs-6">I Agree
                                    <a href="#" class="ms-1 light-orange">Terms and conditions</a>.
                                </span>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="kt_sign_up_submit" class="btn btn-lg orange-btn">
                                <span class="indicator-label">Submit</span>
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
