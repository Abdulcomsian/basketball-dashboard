@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.order.title') }} {{ trans('global.list') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable">
                    <thead>
                        <th>{{ trans('global.fields.order_number') }}</th>
                        <th>{{ trans('global.fields.date') }}</th>
                        <th>{{ trans('global.fields.tracking_order_no') }}</th>
                        <th>{{ trans('global.fields.customer') }}</th>
                        <th>{{ trans('global.fields.total_bill') }}</th>
                        <th>{{ trans('global.fields.paid_amount') }}</th>
                        <th>{{ trans('global.fields.status') }}</th>
                        <th>{{ trans('global.actions') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr data-entry-id="{{ $order->id }}">
                                <td>
                                    {{ $order->order_id }}
                                </td>
                                <td>
                                    {{ $order->order_date ?? '' }}
                                </td>
                                <td>
                                    {{ $order->tracking_order_no ?? '' }}
                                </td>
                                <td>
                                    {{ $order->customer->name ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ $order->total_payment ?? '0' }}
                                </td>
                                <td class="text-right">
                                    {{ $order->paid ?? '0' }}
                                </td>
                                <td>
                                    <span
                                        class="badge badge-{{ $order->status == 'Pending' ? 'danger' : ($order->status == 'Paid' ? 'success' : 'secondary') }}">
                                        {{ $order->status ?? '0' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.order.show', [$order->order_id ?? '']) }}"
                                        class="btn btn-xs btn-success fa fa-eye" title="{{ trans('global.view') }}"></a>
                                    @if ($order->total_payment != $order->paid)
                                        <button class="btn btn-xs btn-primary add-payment" data-toggle="modal"
                                            data-target="#addPaymentModal" data-order-id="{{ $order->id }}"
                                            data-total-payment="{{ $order->total_payment }}"
                                            data-paid="{{ $order->paid }}"
                                            title="{{ trans('global.add') }} {{ trans('global.payments.title') }}"><i
                                                class="fas fa-money-check-alt"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-xs btn-info shipment-button" data-toggle="modal"
                                        data-target="#shipmentModal" data-customer-id="{{ $order->customer->id }}"
                                        data-order-id="{{ $order->order_id }}"
                                        title="{{ trans('global.shipment_label_creation') }}">
                                        <i class="fas fa-shipping-fast"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">{{ trans('global.add') }}
                        {{ trans('global.payments.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentForm">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <label for="amount">{{ trans('global.fields.paid_amount') }}</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="0"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('global.add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Shipment Modal -->
    <div class="modal fade" id="shipmentModal" tabindex="-1" role="dialog" aria-labelledby="shipmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shipmentModalLabel">{{ trans('global.shipment_label_creation') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="shipmentForm" action="{{ route('admin.order.pdf') }}" method="POST" target="_blank">
                        @csrf
                        <input type="hidden" name="order_no" id="order_no">
                        <div class="form-group">
                            <label for="handle_shipment">{{ trans('global.handle_shipment') }}</label>
                            <select class="form-control" name="handle_shipment" id="handle_shipment" required>
                                <option value="company">{{ trans('global.handle_by_company') }}</option>
                                <option value="customer">{{ trans('global.handle_by_customer') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="manager">{{ trans('global.manager') }}</label>
                            <input type="text" class="form-control" id="manager" name="manager" required>
                        </div>
                        <div class="form-group">
                            <label for="order_manager">{{ trans('global.order_manager') }}</label>
                            <input type="text" class="form-control" id="order_manager" name="order_manager" required>
                        </div>
                        <div class="form-group">
                            <label
                                for="customer_shipping_address">{{ trans('cruds.customer.fields.shipping_address') }}</label>
                            <select class="form-control" name="customer_shipping_address"
                                id="customer_shipping_address"></select>
                        </div>
                        <div class="form-group">
                            <label for="pdf_type">{{ trans('global.select') }} PDF</label>
                            <select class="form-control" name="pdf_type" id="pdf_type" required>
                                <option value="letter_box">{{ trans('global.letter_box') }}</option>
                                <option value="internal_order">{{ trans('global.internal_order') }}</option>
                                <option value="delivery_note">{{ trans('global.delivery_note') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('global.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable({
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
            });

            let totalPayment = 0;
            let paid = 0;
            let paymentAmount;

            $('#addPaymentModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let orderId = button.data('order-id');
                $('#order_id').val(orderId);
                totalPayment = button.data('total-payment');
                paid = button.data('paid');
            });

            $('#addPaymentForm').submit(function(e) {
                e.preventDefault();

                paymentAmount = parseFloat($('#amount').val());

                if (isNaN(paymentAmount) || paymentAmount < 0 || paymentAmount > (totalPayment - paid)) {
                    alert('Invalid payment amount. Please enter a valid amount.');
                    return;
                }
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.payments.store') }}',
                    data: formData,
                    success: function(response) {
                        $('#addPaymentModal').modal('hide');
                        location.reload();
                        if (response.status == true) {
                            toastr.success(response.msg, 'Success');
                        }
                    },
                    error: function(error) {
                        toastr.error('Failed to make payment', 'Error');
                    },
                    complete: function() {
                        $('#addPaymentForm button[type="submit"]').prop('disabled', false);
                    }
                });
            });

            // Show shipment modal on shipment button click
            $('.shipment-button').click(function() {
                let orderNo = $(this).data('order-id');
                $('#shipmentModal input[name="order_no"]').val(orderNo);
                let customerId = $(this).data('customer-id')
                $('#shipmentModal select[name="customer_shipping_address"]').empty();
                $.ajax({
                    type: 'GET',
                    url: '/admin/customers/' + customerId + '/shipping-addresses',
                    success: function(response) {
                        $.each(response.shipping_addresses, function(key, value) {

                            $('#shipmentModal select[name="customer_shipping_address"]')
                                .append($('<option>', {
                                    value: value.address,
                                    text: value.address
                                }));
                        });
                    },
                    error: function(error) {
                        toastr.error('Failed to fetch shipping addresses', 'Error');
                    }
                });
            });
        });
    </script>
@endsection
