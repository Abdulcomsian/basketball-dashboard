@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                Payment Logs for Return Stock: {{ $returnStock->stock_number }}
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
                            <th>Recieved By</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($returnStock->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ $payment->user->name ?? '' }}</td>
                                <td>{{ $payment->paymentMethod->name ?? '' }}</td>
                                <td class="text-right">{{ numberFormat($payment->amount) }}</td>

                            </tr>
                        @empty
                        <tr>
                            <td colspan="4">No payments found</td>
                        </tr>

                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Bill: {{ numberFormat($returnStock->total_bill ?? '') }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total Paid:
                                    {{ numberFormat($returnStock->total_paid ?? '') }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Remaining Bill:
                                @php
                                    $remainingBill = $returnStock->total_bill - $returnStock->total_paid;
                                @endphp
                                    {{ numberFormat($remainingBill) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
