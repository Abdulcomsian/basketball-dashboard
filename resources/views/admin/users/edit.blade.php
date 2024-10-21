@extends('layouts.admin')
@section('title', 'User')
@section('header', 'Update User')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12 mt-5">
            <div class="card mt-5">
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" placeholder="name here..." name="name" value="{{ old('name', $user->name) }}"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>UserName:</label>
                                    <input type="text" class="form-control" placeholder="username here..." value="{{ old('username', $user->username) }}"
                                        name="username" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Email:</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="email here..." name="email" required value="{{ old('email', $user->email) }}" readonly/>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Password:</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="password here..." name="password" required />
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Save and Cancel Buttons -->
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-sm save-btn">
                                <i class="far fa-save icon"></i> Save
                            </button>
                            <button type="button" class="btn btn-sm delete-btn">
                                <i class="fa fa-ban icon"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
