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
                        <li class="breadcrumb-item text-muted">All Videos</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                        </li>
                        <!-- <li class="breadcrumb-item text-dark">Roles List</li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">
                                        <div class="modal-header" id="kt_modal_add_user_header">
                                            <h2 class="fw-bolder">Add User</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                data-kt-users-modal-action="close">
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                            fill="#000000">
                                                            <rect fill="#000000" x="0" y="7" width="16"
                                                                height="2" rx="1" />
                                                            <rect fill="#000000" opacity="0.5"
                                                                transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                                x="0" y="7" width="16" height="2"
                                                                rx="1" />
                                                        </g>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                            <form id="kt_modal_add_user_form" class="form" action="#">
                                                <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                    id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                                    data-kt-scroll-activate="{default: false, lg: true}"
                                                    data-kt-scroll-max-height="auto"
                                                    data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                                    data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                                    data-kt-scroll-offset="300px">
                                                    <div class="fv-row mb-7">
                                                        <label class="d-block fw-bold fs-6 mb-5">Avatar</label>
                                                        <div class="image-input image-input-outline"
                                                            data-kt-image-input="true"
                                                            style="background-image: url(assets/media/avatars/blank.png)">
                                                            <div class="image-input-wrapper w-125px h-125px"
                                                                style="background-image: url(assets/media/avatars/150-1.jpg);">
                                                            </div>
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" title="Change avatar">
                                                                <i class="bi bi-pencil-fill fs-7"></i>
                                                                <input type="file" name="avatar"
                                                                    accept=".png, .jpg, .jpeg" />
                                                                <input type="hidden" name="avatar_remove" />
                                                            </label>
                                                            <span
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                                data-kt-image-input-action="cancel"
                                                                data-bs-toggle="tooltip" title="Cancel avatar">
                                                                <i class="bi bi-x fs-2"></i>
                                                            </span>
                                                            <span
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                                data-kt-image-input-action="remove"
                                                                data-bs-toggle="tooltip" title="Remove avatar">
                                                                <i class="bi bi-x fs-2"></i>
                                                            </span>
                                                        </div>
                                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                    </div>
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Full Name</label>
                                                        <input type="text" name="user_name"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="Full name" value="Emma Smith" />
                                                    </div>
                                                    <div class="fv-row mb-7">
                                                        <label class="required fw-bold fs-6 mb-2">Email</label>
                                                        <input type="email" name="user_email"
                                                            class="form-control form-control-solid mb-3 mb-lg-0"
                                                            placeholder="example@domain.com"
                                                            value="e.smith@kpmg.com.au" />
                                                    </div>
                                                    <div class="mb-7">
                                                        <label class="required fw-bold fs-6 mb-5">Role</label>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="0"
                                                                    id="kt_modal_update_role_option_0"
                                                                    checked='checked' />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_0">
                                                                    <div class="fw-bolder text-gray-800">Administrator
                                                                    </div>
                                                                    <div class="text-gray-600">Best for business owners and
                                                                        company administrators</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='separator separator-dashed my-5'></div>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="1"
                                                                    id="kt_modal_update_role_option_1" />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_1">
                                                                    <div class="fw-bolder text-gray-800">Developer</div>
                                                                    <div class="text-gray-600">Best for developers or
                                                                        people primarily using the API</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='separator separator-dashed my-5'></div>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="2"
                                                                    id="kt_modal_update_role_option_2" />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_2">
                                                                    <div class="fw-bolder text-gray-800">Analyst</div>
                                                                    <div class="text-gray-600">Best for people who need
                                                                        full access to analytics data, but don't need to
                                                                        update business settings</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='separator separator-dashed my-5'></div>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="3"
                                                                    id="kt_modal_update_role_option_3" />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_3">
                                                                    <div class="fw-bolder text-gray-800">Support</div>
                                                                    <div class="text-gray-600">Best for employees who
                                                                        regularly refund payments and respond to disputes
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class='separator separator-dashed my-5'></div>
                                                        <div class="d-flex fv-row">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input me-3" name="user_role"
                                                                    type="radio" value="4"
                                                                    id="kt_modal_update_role_option_4" />
                                                                <label class="form-check-label"
                                                                    for="kt_modal_update_role_option_4">
                                                                    <div class="fw-bolder text-gray-800">Trial</div>
                                                                    <div class="text-gray-600">Best for people who need to
                                                                        preview content data, but don't need to make any
                                                                        updates</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center pt-15">
                                                    <button type="reset" class="btn btn-white me-3"
                                                        data-kt-users-modal-action="cancel">Discard</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        data-kt-users-modal-action="submit">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover datatable datatable-Role">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">#</th>
                                        <th class="min-w-125px">Video</th>
                                        <th class="min-w-125px">Workout Length</th>
                                        <th class="min-w-125px">Difficulty Levels</th>
                                        <th class="min-w-125px">Skills</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $key => $video)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a href="{{ url('/') . $video->path }}" target="_blank">View Video</a>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $video->workout->name }}</span>
                                            </td>
                                            <td>
                                                @foreach(json_decode($video->difficulty_level_ids) as $level_id)
                                                @php
                                                    $level = \App\Models\DifficultyLevel::find($level_id);
                                                @endphp
                                                    <span class="badge badge-info">{{$level->name}}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach(json_decode($video->skill_ids) as $skill_id)
                                                @php
                                                    $skill = \App\Models\Skill::find($skill_id);
                                                @endphp
                                                    <span class="badge badge-info">{{$skill->name}}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-end">
                                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                                    Actions
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <!-- SVG icon code here -->
                                                    </span>
                                                </a>
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.videos.edit', $video->id) }}" class="menu-link px-3">Edit</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.videos.destroy', $video->id) }}" onclick="event.preventDefault(); if(confirm('Are you sure?')) { document.getElementById('delete-form-{{ $video->id }}').submit(); }" class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                                            Delete
                                                        </a>
                    
                                                        <form id="delete-form-{{ $video->id }}" action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('role_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.roles.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
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
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Role:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
