@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-5 text-left">
                    {{ trans('global.payments.title') }} {{ trans('cruds.report.title_singular') }}
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
                            <th>Sr No</th>
                            <th>{{ trans('global.fields.date') }}</th>
                            <th>{{ trans('global.fields.order_number') }}</th>
                            <th>{{ trans('global.fields.customer') }}</th>
                            <th>Payment Method</th>
                            <th>{{ trans('global.payments.amount') }}</th>
                            <th>Created By</th>
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
                    url: "{{ route('admin.reports.payment_report') }}",
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
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'stock_number',
                        name: 'stock_number'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'payment_method.name',
                        name: 'payment_method.name'
                    },
                    {
                        data: 'formatted_amount',
                        name: 'amount',
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        render: function(data, type, row, meta) {
                            return data || '';
                        }
                    },

                ],
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(5)').addClass('text-right');
                }
            });

            $('#filterBtn').on('click', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endsection
