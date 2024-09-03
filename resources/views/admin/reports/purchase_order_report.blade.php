@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-4 text-left">
                    {{ trans('cruds.purchase_orders.title') }} {{ trans('cruds.report.title_singular') }}
                </div>
                <div class="col-md-8 col-sm-12">
                    <form id="filterForm" action="{{ route('admin.reports.purchase_order_report_pdf') }}" method="POST"
                        target="_blank">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-6">
                                <label>{{ trans('global.supplier') }}</label>
                                <select class="form-control" id="supplier" name="supplier">
                                    <option value="all">{{ trans('cruds.product.all_suppliers') }}</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                <label>{{ trans('global.from') }}</label>
                                <input type="date" value="" name="fromDate" id="fromDate" class="form-control">
                            </div>
                            <div class="form-group col-md-3 col-sm-6">
                                <label>{{ trans('global.to') }}</label>
                                <input type="date" value="" name="toDate" id="toDate" class="form-control">
                            </div>
                            <div class="form-group col-md-3 col-sm-6 d-flex">
                                <button type="button" class="btn btn-primary flex-grow-1 mr-1" style="margin-top: 31px;"
                                    id="filterBtn" name="filterBtn">
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
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Stock Number</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit Type</th>
                            <th>Total Units</th>
                            <th>Price</th>
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
                    url: "{{ route('admin.reports.purchase_order_report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                        d.supplier = $('#supplier').val();
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
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'stock_number',
                        name: 'addStock.stock_number',
                        render: function(data, type, row, meta) {
                            return data || '';
                        }
                    },
                    {
                        data: 'supplier',
                        name: 'addStock.supplier.name',
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
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'product_unit_type',
                        name: 'product_unit_type',
                        render: function(data, type, row, meta) {
                            return data || '';
                        }
                    },
                    {
                        data: 'unit_qty',
                        name: 'unit_qty'
                    },
                    {
                        data: 'formatted_price',
                        name: 'price'
                    },
                    {
                        data: 'created_by',
                        name: 'addStock.created_by',
                        render: function(data, type, row, meta) {
                            return data || '';
                        }
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
