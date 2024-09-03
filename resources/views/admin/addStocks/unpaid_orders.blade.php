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

    <!-- Modal for adding payment -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Add Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentForm">
                        <div class="form-group">
                            <label for="paymentAmount">Amount:</label>
                            <input type="number" class="form-control" id="paymentAmount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="paymentType">Payment Type:</label>
                            <select class="form-control" id="paymentType" name="payment_type">
                                @if (isset($payment_methods))
                                    @foreach ($payment_methods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addPayment()">Save Payment</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Un Paid Purchase Orders List
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
                        <th>Status</th>
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
                                    <td class="text-right" id="total-bill{{ $add_stock->id }}">
                                        {{ numberFormat($add_stock->total_bill ?? '') }}</td>
                                    <td class="text-right" id="total-paid{{ $add_stock->id }}">
                                        {{ numberFormat($add_stock->total_paid ?? '') }}</td>
                                    <td>{{ $add_stock->createdBy->name ?? '' }}</td>
                                    <td class="status-cell">
                                        @if ($add_stock->status === 'Pending')
                                            <span class="badge badge-info">{{ $add_stock->status }}</span>
                                        @elseif ($add_stock->status === 'Partially Paid')
                                            <span class="badge badge-warning">{{ $add_stock->status }}</span>
                                        @elseif ($add_stock->status === 'Paid')
                                            <span class="badge badge-success">{{ $add_stock->status }}</span>
                                        @endif
                                    </td>
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
                                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm
                                                            Deletion</h5>
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

                                        <button class="btn btn-xs btn-primary"
                                            onclick="openAddPaymentModal({{ $add_stock->id }})"><span
                                                class="fas fa-plus-circle"> Add Payment</span></button>
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
        document.addEventListener("DOMContentLoaded", function() {
            let stockId;

            const paymentAmountInput = document.getElementById("paymentAmount");
            paymentAmountInput.addEventListener("click", function() {
                stockId = this.getAttribute("data-stock-id");
            });

            const paymentAmountInputs = document.querySelectorAll("[name='amount']");
            paymentAmountInputs.forEach(paymentAmountInput => {
                paymentAmountInput.addEventListener("input", function() {
                    validatePaymentAmount(paymentAmountInput,
                        stockId);
                });
            });

            function validatePaymentAmount(paymentAmountInput, stockId) {
                const enteredAmount = parseInt(paymentAmountInput.value) || 0;

                const totalBillElement = document.getElementById("total-bill" + stockId);
                const totalPaidElement = document.getElementById("total-paid" + stockId);

                if (!totalBillElement || !totalPaidElement) {
                    console.error('Total bill or total paid element not found!');
                    return;
                }

                const totalBill = parseFloat(totalBillElement.textContent);
                const totalPaid = parseFloat(totalPaidElement.textContent);
                const availableAmount = totalBill - totalPaid;

                if (enteredAmount > availableAmount) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning...',
                        text: 'The entered amount exceeds the available bill. Please enter a valid Amount.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                        customClass: {
                            container: 'my-swal',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            paymentAmountInput.value = availableAmount;
                        }
                    });
                }
            }
        });



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
            $('#paymentAmount').attr('data-stock-id', stockId);
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
                    if (response.status === false) {
                        toastr.error(response.error);
                    } else {
                        $('#addPaymentModal').modal('hide');
                        toastr.success(response.message);
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    toastr.error(errorMessage);
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
