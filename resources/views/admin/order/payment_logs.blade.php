@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Payment Logs for Order: {{ $order->stock_number }}
            </h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <a class="btn btn-default" href="{{ URL::previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Recieved By</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentLogs as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                                <td>{{ $payment->description }}</td>
                                <td>{{ $payment->user->name }}</td>
                                <td>{{ $payment->paymentMethod->name }}</td>
                                <td class="text-right">{{ numberFormat($payment->amount) }}</td>
                                <td>{{ $payment->createdBy->name ?? '' }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Bill:
                                    {{ numberFormat($order->total_bill ?? '') }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Paid:
                                    {{ numberFormat($order->total_paid ?? '') }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Remaining Bill:
                                    @php
                                        $remainingBill = $order->total_bill - $order->total_paid;
                                    @endphp
                                    {{ numberFormat($remainingBill) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
