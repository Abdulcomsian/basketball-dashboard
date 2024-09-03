@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/progress-hd.png)">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <a href="index.html" class="mb-12">
                <img alt="Logo" src="assets/media/logos/logo-2-dark.svg" class="h-45px" />
            </a>
            <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">Sign In to Metronic</h1>
                        <!-- <div class="text-gray-400 fw-bold fs-4">New Here?
                        <a href="{{ route('register') }}" class="link-primary fw-bolder">Create an Account</a></div> -->
                    </div>
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                        <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />
                    </div>
                    <div class="fv-row mb-10">
                        <div class="d-flex flex-stack mb-2">
                            <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                            <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                        </div>
                        <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                    </div>
                    <div class="text-center">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                            <span class="indicator-label">Continue</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!-- <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
                        <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                        <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3" />Continue with Google</a>
                        <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                        <img alt="Logo" src="assets/media/svg/brand-logos/facebook-4.svg" class="h-20px me-3" />Continue with Facebook</a>
                        <a href="#" class="btn btn-flex flex-center btn-light btn-lg w-100">
                        <img alt="Logo" src="assets/media/svg/brand-logos/apple-black.svg" class="h-20px me-3" />Continue with Apple</a> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
