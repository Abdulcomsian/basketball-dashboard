@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Return Stock {{ trans('global.details') }}
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
                                <th>Return Stock #:</th>
                                <td>{{ $returnStock->stock_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('global.fields.supplier') }} :</th>
                                <td>{{ $returnStock->supplier->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('global.fields.date') }} :</th>
                                <td>{{ $returnStock->formatted_return_stock_date ?? '' }}</td>
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
                            <th>Warehouse</th>
                            <th>{{ trans('global.fields.product') }}</th>
                            <th>{{ trans('global.fields.quantity') }}</th>
                            <th>{{ trans('global.fields.unit_type') }}</th>
                            <th>Total Return Units</th>
                            <th>Price</th>
                            <th>{{ trans('global.fields.total') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($returnStock->returnStockDetails as $key => $retunStockDetail)
                            <tr>
                                <td>{{ $retunStockDetail->warehouse->abbreviation ?? '' }}</td>
                                <td>{{ $retunStockDetail->product->name }}</td>
                                <td class="text-right">{{ $retunStockDetail->quantity }}</td>
                                <td>{{ $retunStockDetail->unitType->abbreviation }}</td>
                                <td class="text-right">{{ $retunStockDetail->unit_qty }}</td>
                                <td class="text-right">{{ numberFormat($retunStockDetail->price) }}</td>
                                <td class="text-right">{{ numberFormat($retunStockDetail->total) }}</td>
                            </tr>
                        @endforeach
                        <tr class="text-right">
                            <td colspan="6">
                                <strong>{{ trans('global.fields.total_bill') }}</strong>
                            </td>
                            <td>{{ numberFormat($returnStock->total_bill) }}</td>

                        </tr>
                        <tr class="text-right">
                            <td colspan="6">
                                <strong>Total Paid</strong>
                            </td>
                            <td>{{ numberFormat($returnStock->total_paid) }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
