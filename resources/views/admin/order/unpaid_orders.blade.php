@extends('layouts.admin')
@section('content')
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
                            <label for="paymentType">Payment Method:</label>
                            <select class="form-control" id="paymentType" name="payment_method_id">
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
                    <button type="button" class="btn btn-primary" id="savePaymentBtn">Add Payment</button>
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
                        <th>Sr No</th>
                        <th>Stock Number</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Due Date</th>
                        <th>Total Bill</th>
                        <th>Total Paid</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @if ($orders)
                            @foreach ($orders as $key => $order)
                                <tr data-entry-id="{{ $order->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $order->stock_number }}</td>
                                    <td>{{ $order->order_date ?? '' }}</td>
                                    <td>{{ $order->customer->name ?? '' }}</td>
                                    <td>{{ $order->due_date ?? '' }}</td>
                                    <td class="text-right">{{ numberFormat($order->total_bill ?? '') }}</td>
                                    <td class="text-right">{{ numberFormat($order->total_paid ?? '') }}</td>
                                    <td>{{ $order->createdBy->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('admin.order.show', [$order->id ?? '']) }}"
                                            class="btn btn-xs btn-success"> View</a>
                                        @can('order_delete')
                                            <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST"
                                                class="delete-form" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-xs btn-danger delete-btn">{{ trans('global.delete') }}</button>
                                            </form>
                                        @endcan
                                        <button class="btn btn-xs btn-primary add-payment-btn"
                                            data-id="{{ $order->id }}">Add Payment</button>
                                        <a href="{{ route('admin.order.paymentLogs', [$order->id ?? '']) }}"
                                            class="btn btn-xs btn-info">Payment Logs</a>
                                        <a href="{{ route('admin.order.invoice', [$order->id ?? '']) }}"
                                            class="btn btn-xs btn-danger" target="_blank">
                                            <i class="fas fa-file-pdf"></i> Show Invoice
                                        </a>
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
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
            });

            $(document).on('click', '.add-payment-btn', function() {
                orderID = $(this).data('id');
                $('#addPaymentModal').modal('show');
                $('#addPaymentForm').attr('data-order-id', orderID);
            });

            // Save payment
            $('#savePaymentBtn').click(function() {
                var orderID = $('#addPaymentForm').attr('data-order-id');
                var amount = $('#paymentAmount').val();
                var paymentType = $('#paymentType').val();

                $.ajax({
                    url: '{{ route('admin.order.addPayment') }}',
                    method: 'POST',
                    data: {
                        order_id: orderID,
                        amount: amount,
                        payment_method_id: paymentType,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success(response.message);
                            $('#addPaymentModal').modal('hide');
                            location.reload();
                        } else {
                            toastr.error(response.message);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                const deleteBtn = form.querySelector('.delete-btn');

                deleteBtn.addEventListener('click', function() {
                    const form = this.closest('.delete-form');

                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!", {
                                icon: "info",
                            });
                        }
                    });
                });
            });

        });
    </script>
@endsection
