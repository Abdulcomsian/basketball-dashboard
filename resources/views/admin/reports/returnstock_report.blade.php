@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6 text-left">
                    PO Return Report
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-6">
                            <label>{{ trans('global.from') }}</label>
                            <input type="date" value="" name="fromDate" id="fromDate" class="form-control">
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label>{{ trans('global.to') }}</label>
                            <input type="date" value="" name="toDate" id="toDate" class="form-control">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <button type="button" class="btn btn-primary form-control" style="margin-top: 31px;"
                                id="filterBtn" name="filterBtn">
                                <span><i class="fas fa-search"></i></span> {{ trans('global.search') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Stock No</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Unit Type</th>
                            <th>Return Quantity</th>
                            <th>Cause of Return</th>
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
    <script>
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.reports.return_stock_report') }}",
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
                    data: '',
                    name: 'id',
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            return meta.row + 1;
                        }
                        return data || '';
                    }
                },
                {
                    data: 'stock_number',
                    name: 'addStockLog.addStock.stock_number',
                    render: function(data, type, row, meta) {
                        return data || '';
                    }
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'supplier',
                    name: 'addStockLog.addStock.supplier.name',
                    render: function(data, type, row, meta) {
                        return data || '';
                    }
                },
                {
                    data: 'product.name',
                    name: 'product.name'
                },
                {
                    data: 'product.category.name',
                    name: 'product.category.name'
                },
                {
                    data: 'product_unit_type',
                    name: 'product_unit_type',
                    render: function(data, type, row, meta) {
                        return data || '';
                    }
                },
                {
                    data: 'return_qty',
                    name: 'return_qty'
                },
                {
                    data: 'cause_of_return',
                    name: 'cause_of_return'
                },
                {
                    data: 'created_by',
                    name: 'created_by',
                    render: function(data, type, row, meta) {
                        return data || '';
                    }
                },
            ],

            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel File',
                    className: 'btn-export'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF File',
                    className: 'btn-export'
                }
            ],

            columnDefs: [{
                targets: 0,
                className: 'text-center'
            }],
            createdRow: function(row, data, dataIndex) {
                $(row).find('td:eq(7)').addClass('text-center');
            }
        });

        $('#filterBtn').on('click', function() {
            $('#dataTable').DataTable().ajax.reload();
        });
    </script>
@endsection
