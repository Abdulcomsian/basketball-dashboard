@extends('layouts.admin')
@section('title', 'Workout Lenght')
@section('header', 'Add Workout Lenght')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12 mt-5">
            <div class="card mt-5">
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('admin.workouts.store') }}">
                        @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label">Name:</label>
                                        <input type="text" class="form-control" placeholder="name here..." name="name" required />
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
