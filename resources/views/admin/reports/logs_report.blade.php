@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-5 text-left">
                    {{ trans('global.log_history') }} {{ trans('cruds.report.title_singular') }}
                </div>
                <div class="col-7 text-right">
                    <form id="filterForm">
                        <div class="row">
                            <div class="form-group col-5">
                                <div class="row">
                                    <div class="col-4"><label class="pt-2">{{ trans('global.from') }}</label></div>
                                    <div class="col-8">
                                        <input type="date" value="" name="fromDate" id="fromDate"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-5">
                                <div class="row p-0">
                                    <div class="col-4"><label class="pt-2">{{ trans('global.to') }}</label></div>
                                    <div class="col-8">
                                        <input type="date" value="" name="toDate" id="toDate"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <div class="row">
                                    <button type="button" class="btn btn-primary" id="filterBtn"
                                        name="filterBtn">{{ trans('global.search') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>{{ trans('global.fields.id') }}</th>
                            <th>{{ trans('global.fields.date') }}</th>
                            <th>{{ trans('global.action') }}</th>
                            <th>{{ trans('global.page') }}</th>
                            <th>{{ trans('global.fields.description') }}</th>
                            <th>{{ trans('global.fields.user') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            var dataTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.reports.logs_report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        render: function(data, type, row) {
                            var badgeClass = '';
                            switch (data) {
                                case 'created':
                                    badgeClass = 'badge-success';
                                    break;
                                case 'deleted':
                                    badgeClass = 'badge-danger';
                                    break;
                                case 'updated':
                                    badgeClass = 'badge-info';
                                    break;
                                default:
                                    badgeClass = 'badge-secondary';
                            }
                            return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                ],
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
            });

            $('#filterBtn').on('click', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endsection
