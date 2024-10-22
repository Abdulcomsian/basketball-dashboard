@extends('layouts.admin')
@section('title', 'Video')
@section('header', 'Add Video')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12 mt-5">
            <div class="card mt-5">
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('admin.videos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Workout Length:</label>
                                    <select id="workoutlength" class="form-control" name="workout" required>
                                        <option value="">Select Workout Length</option>
                                        @foreach ($workouts as $workout)
                                            <option value="{{ $workout->id }}">{{ $workout->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Difficulty Level:</label>
                                    <select id="diffLevel" class="form-control" name="levels[]" multiple required>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Skill:</label>
                                    <select id="skills" class="form-control" name="skills[]" multiple required>
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Upload Video:</label>
                                    <input type="file" class="form-control" name="video" accept="video/*" required />
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
    @section('scripts')
    @parent
    <script>
        $("#workoutlength").select2({
            width: '100%',
            height: '100%',
        });

        $("#diffLevel").select2({
            width: '100%',
            height: '100%',
        });

        $("#skills").select2({
            width: '100%',
            height: '100%',
        });
    </script>
@endsection
@endsection
