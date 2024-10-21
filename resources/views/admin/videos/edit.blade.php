@extends('layouts.admin')
@section('title', 'Video')
@section('header', 'Update Video')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12 mt-5">
            <div class="card mt-5">
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('admin.videos.update', $video->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Workout Length:</label>
                                    <select class="form-control" id="workoutlength" name="workout" required>
                                        <option value="">Select Workout Length</option>
                                        @foreach ($workouts as $workout)
                                            <option value="{{ $workout->id }}"
                                                @if ($video->workout_length_id == $workout->id) selected @endif>{{ $workout->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Difficulty Level:</label>
                                    <select class="form-control select2" id="diffLevel" name="levels[]" multiple required>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}"
                                                @if (in_array($level->id, json_decode($video->difficulty_level_ids))) selected @endif>{{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Skill:</label>
                                    <select class="form-control select3" id="skills" name="skills[]" multiple required>
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}"
                                                @if (in_array($skill->id, json_decode($video->skill_ids))) selected @endif>{{ $skill->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Upload New Video (optional):</label>
                                    <input type="file" class="form-control" name="video" accept="video/*" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Current Video:</label>
                                    @if ($video->path)
                                        <video class="form-control" width="320" height="240" controls>
                                            <source src="{{ asset($video->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <p>No video uploaded</p>
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
