@extends('layouts.admin')
@section('content')
    <div class="card">
        <form id="formData" method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Create Product</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="required">Product Name</label>
                            <input class="form-control" id="name" name="name" placeholder="Product Name"
                                type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="category" class="required">Category</label>
                            <select class="form-control" name="product_category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="barcode" class="required">Barcode</label>
                            <input class="form-control" id="barcode" name="barcode" placeholder="Barcode" type="text"
                                required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered text-center add-stock-table">
                            <thead>
                                <tr>
                                    <th width="20%">Unit Type</th>
                                    <th width="15%">Quantity</th>
                                    <th width="20%">Purchase Price</th>
                                    <th width="20%">General Selling Price</th>
                                    <th width="20%">Special Selling Price</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control unit-type-select" name="unit_type_id[]" required>
                                            <option value="">Select Unit Type</option>
                                            @foreach ($unitTypes as $unitType)
                                                <option value="{{ $unitType->id }}">{{ $unitType->abbreviation }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="quantity[]" class="form-control" min="1"
                                            value="1" required style="text-align:right;">
                                    </td>
                                    <td>
                                        <input type="number" name="purchase_price[]" class="form-control" min="1" style="text-align:right;">
                                    </td>
                                    <td>
                                        <input type="number" name="general_selling_price[]" class="form-control"
                                            style="text-align:right;">
                                    </td>
                                    <td>
                                        <input type="number" name="special_selling_price[]" class="form-control"
                                            style="text-align:right;">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">
                                    </th>
                                    <td>
                                        <button type="button"
                                            class="btn btn-info btn-sm add-row">{{ trans('global.add_row') }}</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success" id="submit-form">{{ trans('global.save') }}</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('select').select2({
                width: '100%'
            });

            $(".add-row").click(function() {
                let row = `
            <tr>
                <td>
                    <select class="form-control unit-type-select" name="unit_type_id[]" required>
                        <option value="">Select Unit Type</option>
                        @foreach ($unitTypes as $unitType)
                            <option value="{{ $unitType->id }}">{{ $unitType->abbreviation }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]" class="form-control" min="1" value="1" required style="text-align:right;">
                </td>
                <td>
                    <input type="number" name="purchase_price[]" class="form-control" min="1" style="text-align:right;">
                </td>
                <td>
                    <input type="number" name="general_selling_price[]" class="form-control" style="text-align:right;">
                </td>
                <td>
                    <input type="number" name="special_selling_price[]" class="form-control" style="text-align:right;">
                </td>
                <td> <div class="btn btn-danger btn-sm delete-row" title="Delete"><i class="fas fa-trash-alt"></i>
                    </div>
                </td>
            </tr>
        `;
                $("table tbody").append(row);
                $('select').select2({
                    width: '100%'
                });

            });

            $(document).on("click", ".delete-row", function() {
                $(this).closest("tr").remove();
            });

            $("#submit-form").click(function() {
                $(this).prop('disabled', true);

                let formData = $("#formData").serializeArray();

                $.ajax({
                    url: $("#formData").attr('action'),
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $("#submit-form").prop('disabled', false);

                        if (response.status == true) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.products.index') }}";
                            }, 1000);
                        } else {
                            if (response.errors) {
                                for (const error in response.errors) {
                                    toastr.error(response.errors[error][0]);
                                }
                            } else {
                                toastr.error(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        $("#submit-form").prop('disabled', false);

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            for (const error in xhr.responseJSON.errors) {
                                toastr.error(xhr.responseJSON.errors[error][0]);
                            }
                        } else {
                            toastr.error("Error submitting the form.");
                        }
                    }
                });
            });
        });
    </script>
@endsection
