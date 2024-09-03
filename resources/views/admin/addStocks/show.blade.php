@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.purchase_orders.title') }} {{ trans('global.details') }}
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
                                <th>Supplier:</th>
                                <td>{{ $addStock->supplier->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ $addStock->date ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Stock No:</th>
                                <td>{{ $addStock->stock_number ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Type:</th>
                                <td>{{ $addStock->pay_type ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td>{{ $addStock->paymentMethod->name ?? '' }}</td>
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
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Type</th>
                            <th>Purchased Qty</th>
                            <th>Purchase Price</th>
                            <th>Total</th>
                            <th>Warehouse</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addStock->addStockLogs as $stocklog)
                            <tr>
                                <td>{{ $stocklog->product->name ?? '' }}</td>
                                <td>{{ $stocklog->quantity ?? '' }}</td>
                                <td>{{ $stocklog->unitType->abbreviation ?? '' }}</td>
                                <td>{{ $stocklog->unit_qty ?? '' }}</td>
                                <td>{{ numberFormat($stocklog->price ?? '') }}</td>
                                <td>{{ numberFormat($stocklog->total) }}</td>
                                <td>{{ $stocklog->warehouse->abbreviation ?? '' }}</td>
                                {{-- <td>
                                    <button type="button" class="btn btn-xs btn-warning" data-toggle="modal"
                                        data-target="#returnStockModal{{ $stocklog->id }}">
                                        <span class="fas fa-plus-circle"></span> Return Stock
                                    </button>
                                </td> --}}
                            </tr>
                            <!-- Modal -->
                            {{-- <div class="modal fade" id="returnStockModal{{ $stocklog->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="returnStockModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="returnStockModalLabel">Return Stock</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="returnStockForm">
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Quantity:</label>
                                                    <input type="number" class="form-control"
                                                        id="quantity{{ $stocklog->id }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="col-form-label">Reason:</label>
                                                    <textarea class="form-control" id="reason{{ $stocklog->id }}"></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="submitForm({{ $stocklog->id }})">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        function submitForm(stocklogId) {
            var quantity = $('#quantity' + stocklogId).val();
            var reason = $('#reason' + stocklogId).val();

            $.ajax({
                url: '{{ route('admin.stocks.return.reason') }}',
                method: 'POST',
                data: {
                    stocklog_id: stocklogId,
                    quantity: quantity,
                    reason: reason,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#returnStockModal' + stocklogId).modal('hide');
                    toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error :
                        'An error occurred while processing your request.';
                    $('#returnStockModal' + stocklogId).modal('hide');
                    toastr.error(errorMessage);
                }
            });
        }
    </script> --}}
@endsection
