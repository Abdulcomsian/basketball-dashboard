@extends('layouts.admin')
@section('title', 'Video')
@section('header', 'Videos')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-fluid">

        </div>
        <div class="container-fluid">
            <div class="mt-3">
                <div class="d-flex mb-3">
                    <a href="{{ route('admin.videos.create') }}">
                        <button type="button" class="btn btn-sm me-3 add-section"><i class="fas fa-plus icon"></i>
                            Add New
                        </button>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Role cell-border">
                        <thead>
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">#</th>
                                <th class="min-w-125px">Video</th>
                                <th class="min-w-125px">Workout Length</th>
                                <th class="min-w-125px">Difficulty Levels</th>
                                <th class="min-w-125px">Skills</th>
                                <th class="text-center min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($videos as $key => $video)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a class="link" href="{{ url('/') . $video->path }}" target="_blank">View Video</a>
                                    </td>
                                    <td>
                                        <span class="badge badge-orange">{{ $video->workout->name }}</span>
                                    </td>
                                    <td>
                                        @foreach(json_decode($video->difficulty_level_ids) as $level_id)
                                        @php
                                            $level = \App\Models\DifficultyLevel::find($level_id);
                                        @endphp
                                            <span class="badge badge-orange">{{$level->name}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach(json_decode($video->skill_ids) as $skill_id)
                                        @php
                                            $skill = \App\Models\Skill::find($skill_id);
                                        @endphp
                                            <span class="badge badge-orange">{{$skill->name}}</span>
                                        @endforeach
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.videos.edit', $video->id) }}">
                                            <button class="btn btn-sm save-btn">Edit</button>
                                        </a>
                                        <a href="{{ route('admin.videos.destroy', $video->id) }}" onclick="event.preventDefault(); if(confirm('Are you sure?')) { document.getElementById('delete-form-{{ $video->id }}').submit(); }" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                            <button class="btn btn-sm delete-btn">Delete</button>
                                        </a>  

                                        <form id="delete-form-{{ $video->id }}" action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('role_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.roles.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id');
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}');
                            return;
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload();
                                });
                        }
                    }
                };
                dtButtons.push(deleteButton);
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                autoWidth: false,
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
                responsive: true,
                scrollX: true,
                scrollCollapse: true,
                columnDefs: [{
                        width: '10%',
                        targets: 0
                    },
                    {
                        orderable: false,
                        targets: '_all'
                    }
                ],
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                }
            });

            let table = $('.datatable-Role:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('#geographicZoneSelect').select2();
            $('#salesPersonSelect').select2();
        });
    </script>
@endsection
@endsection
