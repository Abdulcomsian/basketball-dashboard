@extends('layouts.admin')
@section('content')
    <style>
        .badge {
            display: inline-block;
            width: 120px;
            text-align: center;
            padding: 5px;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .badge-success {
            background-color: #28a745;
        }

        .warning-text {
            background-color: #FFEB3B;
            padding: 10px;
        }
    </style>
    <div class="card">
        <div class="card-header">
            Paid Purchase Orders List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-AddStock">
                    <thead>
                        <th>Sr no</th>
                        <th>Stock Number</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Total Bill</th>
                        <th>Total Paid</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @if ($add_stocks)
                            @foreach ($add_stocks as $key => $add_stock)
                                <tr data-entry-id="{{ $add_stock->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $add_stock->stock_number }}</td>
                                    <td>{{ $add_stock->date ?? '' }}</td>
                                    <td>{{ $add_stock->supplier->name ?? '' }}</td>
                                    <td class="text-right">{{ numberFormat($add_stock->total_bill ?? '') }}</td>
                                    <td class="text-right">{{ numberFormat($add_stock->total_paid ?? '') }}</td>
                                    <td>{{ $add_stock->createdBy->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('admin.stocks.show', [$add_stock->id ?? '']) }}"
                                            class="btn btn-xs btn-success fa fa-eye"> View</a>
                                        <a href="#" class="btn btn-xs btn-danger fa fa-trash"
                                            onclick="confirmDelete('{{ route('admin.stocks.destroy', $add_stock->id) }}')">
                                            Delete</a>

                                        <!-- Confirmation modal -->
                                        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
                                            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Are you
                                                            sure?</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="warning-text"><strong>Warning:</strong> Once deleted, you
                                                            will not be able to recover this data!</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-danger"
                                                            id="confirmDeleteBtn">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.stocks.show.payment.logs', [$add_stock->id ?? '']) }}"
                                            class="btn btn-xs btn-dark fas fa-money-bill-alt"> Payment Logs</a>
                                        <a href="{{ route('admin.stocks.show.invoice', [$add_stock->id ?? '']) }}"
                                            class="btn btn-xs btn-info fa fa-eye" target="_blank"> Show Invoice</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.datatable-AddStock').DataTable({
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
            });
        });

        function openAddPaymentModal(stockId) {
            $('#addPaymentModal').modal('show');
            $('#addPaymentForm').attr('data-stock-id', stockId);
        }

        function addPayment() {
            var stockId = $('#addPaymentForm').attr('data-stock-id');
            var amount = $('#paymentAmount').val();
            var paymentType = $('#paymentType').val();

            $.ajax({
                url: '{{ route('admin.stocks.addPayment') }}',
                method: 'POST',
                data: {
                    stock_id: stockId,
                    amount: amount,
                    payment_type: paymentType,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#addPaymentModal').modal('hide');
                    toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            $('#confirmDeleteBtn').on('click', function() {
                var deleteUrl = $(this).attr('data-delete-url');

                $.ajax({
                    url: deleteUrl,
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'delete'
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error deleting payment');
                        console.error(xhr.responseText);
                    }
                });

                $('#deleteConfirmationModal').modal('hide');
            });
        });

        function confirmDelete(deleteUrl) {
            $('#confirmDeleteBtn').attr('data-delete-url', deleteUrl);
            $('#deleteConfirmationModal').modal('show');
        }
    </script>
@endsection
