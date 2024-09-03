@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-4 text-left">
                    {{ trans('cruds.product.title') }} {{ trans('cruds.report.title_singular') }}
                </div>
                <div class="col-8">
                    <form id="filterForm">
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-6">
                                <label>{{ trans('global.category') }}</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="all">{{ trans('cruds.product.all_categories') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                            <div class="form-group col-md-2 col-sm-12 d-flex">
                                <button type="button" class="btn btn-primary flex-grow-1 mr-1" style="margin-top: 31px;"
                                    id="filterBtn" name="filterBtn">
                                    <span><i class="fas fa-search"></i></span> {{ trans('global.search') }}
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
                            <th>{{ trans('global.fields.date') }}</th>
                            <th>{{ trans('global.product_name') }}</th>
                            <th>{{ trans('global.fields.product_category') }}</th>
                            <th>{{ trans('global.fields.unit_type') }}</th>
                            <th>{{ trans('global.fields.quantity') }}</th>
                            <th>{{ trans('global.fields.general_selling_price') }}</th>
                            <th>{{ trans('global.fields.special_selling_price') }}</th>
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
        $(document).ready(function() {
            var dataTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.reports.product_report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                        d.category = $('#category').val();
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
                        data: 'product.name',
                        name: 'product.name'
                    },
                    {
                        data: 'product.category.name',
                        name: 'product.category.name'
                    },
                    {
                        data: 'product_unit_type',
                        name: 'product_unit_type'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'formatted_general_selling_price',
                        name: 'general_selling_price'
                    },
                    {
                        data: 'formatted_special_selling_price',
                        name: 'special_selling_price'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel File',
                    className: 'btn-export'
                }],
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(5),td:eq(6),td:eq(7)').addClass('text-right');
                }
            });

            $('.btn-export').css({
                'background-color': '#4CAF50',
                'color': 'green',
                'padding': '10px 24px',
                'text-align': 'center',
                'text-decoration': 'none',
                'display': 'inline-block',
                'font-size': '12px',
                'cursor': 'pointer',
                'border-radius': '7px'
            });

            $('.btn-export').hover(function() {
                $(this).css('background-color', '#45a049');
            }, function() {
                $(this).css('background-color', '#4CAF50');
            });

            $('#filterBtn').on('click', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endsection
