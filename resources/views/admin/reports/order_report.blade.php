@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-4 text-left">
                    {{ trans('cruds.order.title') }} {{ trans('cruds.report.title_singular') }}
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="d-flex justify-content-end">
                        <form id="filterForm" action="{{ route('admin.reports.order_report_pdf') }}" method="POST"
                            target="_blank">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-3 col-sm-6">
                                    <label>{{ trans('global.customer') }}</label>
                                    <select class="form-control" name="customer_id" id="customerId">
                                        <option value="all">All Customers</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-6">
                                    <label>{{ trans('global.from') }}</label>
                                    <input type="date" value="" name="fromDate" id="fromDate"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-3 col-sm-6">
                                    <label>{{ trans('global.to') }}</label>
                                    <input type="date" value="" name="toDate" id="toDate" class="form-control">
                                </div>
                                <div class="form-group col-md-3 col-sm-6 d-flex">
                                    <button type="button" class="btn btn-primary flex-grow-1 mr-1"
                                        style="margin-top: 31px;" id="filterBtn" name="filterBtn">
                                        <span><i class="fas fa-search"></i></span> {{ trans('global.search') }}
                                    </button>
                                    <button type="submit" class="btn btn-danger flex-grow-1" style="margin-top: 31px;">
                                        <span><i class="fas fa-file-pdf"></i></span> PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>{{ trans('global.fields.date') }}</th>
                            <th>{{ trans('global.fields.order_no') }}</th>
                            <th>{{ trans('global.fields.customer') }}</th>
                            <th>{{ trans('global.fields.product') }}</th>
                            <th>{{ trans('global.fields.category') }}</th>
                            <th>Selling Qty</th>
                            <th>Unit Type</th>
                            <th>Product Qty</th>
                            <th>Selling Price </th>
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
        $(document).on('click', '#pdfBtn', function() {
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var customerId = $('#customerId').val();

            $.ajax({
                url: '{{ route('admin.reports.order_report_pdf') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    from_date: fromDate,
                    to_date: toDate,
                    customer_id: customerId
                },
                success: function(response) {
                    // Handle success (optional)
                    console.log('PDF generated successfully');
                },
                error: function(xhr, status, error) {
                    // Handle error (optional)
                    console.error('Error generating PDF:', error);
                }
            });
        });
        $(document).ready(function() {
            var dataTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.reports.order_report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                        d.customer = $('#customerId').val();
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        searchable: true,
                        orderable: true,
                    },
                    {
                        data: 'order.order_date',
                        name: 'order.order_date',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'stock_number',
                        name: 'order.stock_number',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            // Check if the data is null or undefined
                            if (data == null || data == undefined) {
                                return '';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'customer',
                        name: 'order.customer.name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row, meta) {
                            // Check if the data is null or undefined
                            if (data == null || data == undefined) {
                                return '';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'product.name',
                        name: 'product.name',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'product.category.name',
                        name: 'product.category.name',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'product_unit_type',
                        name: 'product_unit_type',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'unit_qty',
                        name: 'unit_qty',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'formatted_price',
                        name: 'price',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        searchable: false,
                        orderable: false,
                    },
                ],
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(6),td:eq(8), td:eq(9)').addClass('text-right');
                }
            });

            $('#filterBtn').on('click', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endsection
