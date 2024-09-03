@extends('layouts.admin')
@section('content')
    <style>
        .pagination-container-right {
            display: flex;
            justify-content: flex-end;
        }
    </style>
    <div class="card">
        <div class="card-header">
            Payment Logs Details
        </div>
        <div class="card-body">
            <div class="form-group">
                <a class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Total Bill:</th>
                                <td>{{ numberFormat($totalBill) }}</td>
                            </tr>
                            <tr>
                                <th>Total Paid:</th>
                                <td>{{ numberFormat($totalPaid) }}</td>
                            </tr>
                            <tr>
                                <th>Remaining Bill:</th>
                                <td>{{ numberFormat($remainingBill) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment Type</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentLogs as $paymentLog)
                            <tr>
                                <td>{{ $paymentLog->created_at->format('d, M Y H:i:s') }}</td>
                                <td>{{ numberFormat($paymentLog->amount) }}</td>
                                <td>{{ $paymentLog->paymentMethod->name }}</td>
                                <td>{{ $paymentLog->createdBy->name ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-container-right">
                    {{ $paymentLogs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
