@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Stock Transfer {{ trans('global.details') }}
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
                                <th>Transfer No :</th>
                                <td>{{ $transferData->stock_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('global.fields.date') }} :</th>
                                <td>{{ $transferData->date ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>From Warehouse :</th>
                                <td>{{ $transferData->from_warehouse->abbreviation ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>To Warehouse :</th>
                                <td>{{ $transferData->to_warehouse->abbreviation ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Created By :</th>
                                <td>{{ $transferData->user->name ?? '' }}</td>
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
                            <th>{{ trans('global.fields.product') }}</th>
                            <th>{{ trans('global.fields.quantity') }}</th>
                            <th>{{ trans('global.fields.unit_type') }}</th>
                            <th>Total Units</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transferData->stockTransferLogs as $key => $transferLog)
                            <tr>
                                <td>{{ $transferLog->product->name }}</td>
                                <td class="text-right">{{ $transferLog->quantity }}</td>
                                <td>{{ $transferLog->unitType->abbreviation }}</td>
                                <td class="text-right">{{ $transferLog->transfer_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
