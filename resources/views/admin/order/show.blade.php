@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.order.title') }} {{ trans('global.details') }}
        </div>
        <div class="card-body">
            <div class="form-group">
                <a class="btn btn-default" href="{{ URL::previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>{{ trans('global.fields.order_no') }} :</th>
                                <td>{{ $orderData->stock_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('global.fields.customer') }} :</th>
                                <td>{{ $orderData->customer->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Type :</th>
                                <td>{{ $orderData->pay_type ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method :</th>
                                <td>{{ $orderData->paymentMethod->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('global.fields.date') }} :</th>
                                <td>{{ $orderData->order_date ?? '' }}</td>
                            </tr>
                            @if ($orderData->pay_type === 'Cash')
                                
                                <tr>
                                    <th>Total Change :</th>
                                    <td>{{ numberFormat($orderData->total_change ?? '') }}</td>
                                </tr>

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Warehouse</th>
                            <th>{{ trans('global.fields.product') }}</th>
                            <th>{{ trans('global.fields.quantity') }}</th>
                            <th>{{ trans('global.fields.unit_type') }}</th>
                            <th>Selling Quantity</th>
                            <th>Price</th>
                            <th>{{ trans('global.fields.total') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderData->orderLogs as $key => $order)
                            <tr>
                                <td>{{ $order->warehouse->abbreviation ?? '' }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td class="text-right">{{ $order->quantity }}</td>
                                <td>{{ $order->unitType->abbreviation }}</td>
                                <td class="text-right">{{ $order->unit_qty }}</td>
                                <td class="text-right">{{ numberFormat($order->price) }}</td>
                                <td class="text-right">{{ numberFormat($order->total) }}</td>
                            </tr>
                        @endforeach
                        <tr class="text-right">
                            <td colspan="6">
                                <strong>{{ trans('global.fields.total_bill') }}</strong>
                            </td>
                            <td>{{ numberFormat($orderData->total_bill) }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
