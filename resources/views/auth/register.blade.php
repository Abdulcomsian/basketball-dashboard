@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-up -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
            style="background-image: url(assets/media/illustrations/progress-hd.png)">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="{{ route('login') }}" class="mb-12">
                    <img alt="Logo" src="assets/media/logos/logo-2-dark.svg" class="h-45px" />
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-600px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-10 text-center">
                            <h1 class="text-dark mb-3">Create an Account</h1>
                            <div class="text-gray-400 fw-bold fs-4">Already have an account?
                                <a href="{{ route('login') }}" class="link-primary fw-bolder">Sign in here</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-light-primary fw-bolder w-100 mb-10">
                            <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg" class="h-20px me-3" />
                            Sign in with Google
                        </button>
                        <div class="d-flex align-items-center mb-10">
                            <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                            <span class="fw-bold text-gray-400 fs-7 mx-2">OR</span>
                            <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bolder text-dark fs-6">Name</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="name" autocomplete="off" required />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bolder text-dark fs-6">UserName</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="username" autocomplete="off" required />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bolder text-dark fs-6">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="email" name="email" autocomplete="off" required />
                        </div>
                        <div class="fv-row mb-7">
                            <label>Role:</label>
                            <select class="form-control" name="role" required>
                                <option value="">Select Role</option>
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-10 fv-row">
                            <label class="form-label fw-bolder text-dark fs-6">Password</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password" required />
                        </div>
                        <div class="fv-row mb-5">
                            <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation" required />
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-check form-check-custom form-check-solid form-check-inline">
                                <input class="form-check-input" type="checkbox" name="toc" value="1" required />
                                <span class="form-check-label fw-bold text-gray-700 fs-6">I Agree
                                    <a href="#" class="ms-1 link-primary">Terms and conditions</a>.
                                </span>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Sign-up-->
    </div>
@endsection
