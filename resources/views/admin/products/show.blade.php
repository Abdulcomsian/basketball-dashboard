@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input class="form-control" id="name" name="name" placeholder="Product Name" type="text"
                            value="{{ $product->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input class="form-control" id="category" name="category" placeholder="Category" type="text"
                            value="{{ $product->category->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="barcode">Barcode</label>
                        <input class="form-control" id="barcode" name="barcode" placeholder="Barcode" type="text"
                            value="{{ $product->barcode }}" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered text-center add-stock-table">
                        <thead>
                            <tr>
                                <th width="17%">Unit Type</th>
                                <th width="20%">Quantity</th>
                                <th width="21%">Purchase Price</th>
                                <th width="21%">General Selling Price</th>
                                <th width="21%">Special Selling Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->productDetails as $productDetail)
                                <tr>
                                    <td>{{ $productDetail->unitType->abbreviation }}</td>
                                    <td>{{ $productDetail->quantity }}</td>
                                    <td>{{ numberFormat($productDetail->purchase_price) }}</td>
                                    <td>{{ numberFormat($productDetail->general_selling_price) }}</td>
                                    <td>{{ numberFormat($productDetail->special_selling_price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
