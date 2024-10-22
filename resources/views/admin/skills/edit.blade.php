@extends('layouts.admin')
@section('title', 'Skill')
@section('header', 'Update Skill')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12 mt-5">
            <div class="card mt-5">
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('admin.skills.update', $skill->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group mb-3">
                                    <label class="form-label">Name:</label>
                                    <input type="text" class="form-control" placeholder="name here..."
                                        value="{{ old('name', $skill->name) }}" name="name" required />
                                </div>
                            </div>
                        
                            <div class="col-md-5">
                                <div class="form-group mb-3">
                                    <label class="form-label">Upload Image:</label>
                                    <input type="file" class="form-control" placeholder="file here..." name="file" />
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    @if ($skill->file)
                                        <a href="{{ asset('storage/' . $skill->file) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $skill->file) }}" alt="{{ $skill->name }}" width="100" height="100" style="object-fit: cover;">
                                        </a>
                                    @else
                                        <p class="text-danger" style="font-weight: bold;">No Image Available</p>
                                    @endif
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
