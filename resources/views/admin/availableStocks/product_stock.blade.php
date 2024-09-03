@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <form id="filterForm">
                <div class="row">
                    <div class="col-md-8 text-left mt-2">
                        Available Stock
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <label for="Warehouse">Warehouse</label>
                        <div class="form-group">
                            <select class="form-control" name="warehouse_id" id = "warehouse" required>
                                <option value="All">All</option>
                                @if (isset($warehouses) & !empty($warehouses))
                                    @foreach ($warehouses as $key => $warehouse)
                                        <option value="{{ $warehouse->id }}">
                                            {{ $warehouse->abbreviation ?? '' }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>{{ trans('global.fields.product') }}</th>
                            <th>{{ trans('global.fields.category') }}</th>
                            <th>Warehouse</th>
                            <th>{{ trans('global.fields.quantity') }}</th>

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
                    url: "{{ route('admin.available.stocks') }}",
                    type: 'POST',
                    data: function(d) {
                        d.warehouse_id = $('#warehouse').val();
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: 'counter',
                        name: 'counter',
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'warehouse_name',
                        name: 'warehouse_name'
                    },
                    {
                        data: 'total_quantity',
                        name: 'total_quantity'
                    },
                ],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(4)').addClass('text-right');
                },
            });

            $('#warehouse').on('change', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endsection
