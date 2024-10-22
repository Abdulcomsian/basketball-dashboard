@extends('layouts.admin')
@section('title', 'Skill')
@section('header', 'Skills')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-fluid">

        </div>
        <div class="container-fluid">
            <div class="mt-3">
                <div class="d-flex mb-3">
                    <a href="{{ route('admin.skills.create') }}">
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
                                <th class="min-w-125px text-center">Title</th>
                                <th class="min-w-125px text-center">Image</th>
                                <th class="text-end min-w-100px text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($skills as $key => $skill)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-center">
                                        {{ $skill->name }}
                                    </td>
                                    <td class="text-center">
                                        @if ($skill->file)
                                        <a class="link" href="{{ asset('storage/' . $skill->file) }}" target="_blank" title="View {{ $skill->name }}">
                                            View Image
                                        </a>
                                        @else
                                            No Media Available
                                        @endif
                                    </td>                                                                      
                                    <td class="text-center">
                                        <a href="{{ route('admin.skills.edit', $skill->id) }}">
                                            <button class="btn btn-sm save-btn">Edit</button>
                                        </a>
                                        <a href="{{ route('admin.skills.destroy', $skill->id) }}" onclick="event.preventDefault(); if(confirm('Are you sure?')) { document.getElementById('delete-form-{{ $skill->id }}').submit(); }" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                            <button class="btn btn-sm delete-btn">Delete</button>
                                        </a>  

                                        <form id="delete-form-{{ $skill->id }}" action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" style="display: none;">
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
