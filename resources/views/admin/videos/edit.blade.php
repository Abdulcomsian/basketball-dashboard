@extends('layouts.admin')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-place="true" data-kt-place-mode="prepend"
                    data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                    <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Videos List</h1>
                    <span class="h-20px border-gray-200 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Videos</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Update Video</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                        </li>
                        <!-- <li class="breadcrumb-item text-dark">Add User</li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <a href="{{ route('admin.videos.index') }}">
                                <button type="button" class="btn btn-primary">
                                    <span class="svg-icon svg-icon-2">
                                    </span>
                                    View Videos</button>
                                </a>
                            </div>
                            <div class="d-flex justify-content-end align-items-center d-none"
                                data-kt-user-table-toolbar="selected">
                                <div class="fw-bolder me-5">
                                    <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                                </div>
                                <button type="button" class="btn btn-danger"
                                    data-kt-user-table-select="delete_selected">Delete Selected</button>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <form class="form" method="POST" action="{{ route('admin.videos.update', $video->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <label class="form-label">Workout Length:</label>
                                        <select class="form-control" name="workout" required>
                                            <option value="">Select Workout Length</option>
                                            @foreach($workouts as $workout)
                                            <option value="{{$workout->id}}" @if($video->workout_length_id == $workout->id) selected @endif>{{$workout->name}}</option>
                                            @endforeach
                                        </select>
                                        <!-- <span class="form-text text-muted">Please select the workout length</span> -->
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-label">Difficulty Level:</label>
                                        <select class="form-control select2" name="levels[]" multiple required>
                                            @foreach($levels as $level)
                                            <option value="{{$level->id}}" @if(in_array($level->id, json_decode($video->difficulty_level_ids))) selected @endif>{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                        <!-- <span class="form-text text-muted">Please select the difficulty level</span> -->
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-label">Skill:</label>
                                        <select class="form-control select3" name="skills[]" multiple required>
                                            @foreach($skills as $skill)
                                            <option value="{{$skill->id}}" @if(in_array($skill->id, json_decode($video->skill_ids))) selected @endif>{{$skill->name}}</option>
                                            @endforeach
                                        </select>
                                        <!-- <span class="form-text text-muted">Please select the skill</span> -->
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-label">Current Video:</label>
                                        @if($video->path)
                                            <video class="form-control" width="320" height="240" controls>
                                                <source src="{{ asset($video->path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <p>No video uploaded</p>
                                        @endif
                                    </div><br>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-label">Upload New Video (optional):</label>
                                        <input type="file" class="form-control" name="video" accept="video/*" />
                                        <!-- <span class="form-text text-muted">Upload a new video if you want to replace the current one</span> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6 form-group">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <a href="{{ route('admin.videos.index') }}" type="button" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-multi-select />

@endsection
