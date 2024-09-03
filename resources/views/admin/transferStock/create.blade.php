@extends('layouts.admin')
@section('content')
    <div class="card">
        <form id="formData" method="POST" action="{{ route('admin.transfer-stocks.store') }}">
            @csrf
            <div class="card-header">
                <h4>{{ trans('cruds.transferStock.title_singular') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="date" class="required">{{ trans('global.fields.stock_number') }}:</label>
                        <input type="text" name="stock_number" class="form-control" value="{{ $stock_number }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="date" class="required">{{ trans('global.fields.date') }}:</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="from_warehouse_id" class="required">From Warehouse</label>
                        <select class="form-control select2 warehouse" name="from_warehouse_id" required>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->abbreviation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mr-8">
                        <label for=" " class="required">To Warehouse</label>
                        <select class="form-control select2" name="to_warehouse_id" required>
                            <option value="">Select</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->abbreviation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 ">
                    </div>
                    <div class="col-md-4 mb-3 ">
                        <label for="barcode">Barcode Search</label>
                        <div class="input-group">
                            <input class="form-control" id="barcode_scanner" name="barcode" placeholder="Scan Barcode"
                                type="text" value="" autofocus>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success search">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="width: 100%; overflow-x: auto">
                <table class="table table-bordered text-center add-stock-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 20%;">{{ trans('global.fields.product') }}</th>
                            <th style="width: 20%;">Unit Type</th>
                            <th style="width: 20%;">Quantity</th>
                            <th style="width: 20%;">Total Units</th>
                            <th style="width: 20%;">{{ trans('global.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="row">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td>
                                <button type="button"
                                    class="btn btn-info btn-sm add-row">{{ trans('global.add_row') }}</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <button type="button" class="btn btn-success mt-2" id="submit-form">{{ trans('global.submit') }}</button>
            </div>
        </form>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        let productDetailsArray = {!! json_encode($products->keyBy('id')->toArray()) !!};
        console.log(productDetailsArray);
        $(document).ready(function() {
            $('select.product_val').select2({
                width: '100%',
            });

            addRow();

            $(".add-row").click(addRow);

            function addRow() {
                let row = `
                <tr class="rows">
                    <td class="product_col">
                        @if ($products)
                        <select class="form-control product product_val" name="product[]" id="products" required>
                            <option value="">{{ trans('global.fields.select_product') }}</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name ?? '' }}</option>
                            @endforeach
                        </select>
                        @endif
                    </td>
                    
                    <td class="unit_type">
                        <select name="unit_type_id[]" class="form-control unitType" required></select>
                    </td>
                    <td class="unit_qty">
                        <input type="number" name="unit_qty[]" class="form-control unitQty text-right" value="1">
                    </td>
                    <td class="quantity_col">
                        <input type="number" name="quantity[]" class="form-control quantity text-right" min="1" value="1" required readonly >
                    </td>
                    
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row" title="Delete">Remove</button>
                    </td>
                </tr>
            `;
                $("table tbody").append(row);
                $('select.product_val').select2({
                    width: '100%',
                });
                // Hide delete button for the first row
                if ($("table tbody tr").length > 0) {
                    $("table tbody tr:first .delete-row").hide();
                }
            }

            $(document).on("click", ".delete-row", function() {
                $(this).closest("tr").remove();
            });

            $("#submit-form").click(function() {

                let fromWarehouseId = $("select[name='from_warehouse_id']").val();
                let toWarehouseId = $("select[name='to_warehouse_id']").val();

                if (fromWarehouseId === toWarehouseId) {
                    toastr.error("From Warehouse and To Warehouse cannot be the same.");
                    return;
                }
                $(this).prop('disabled', true);

                let formData = $("#formData").serializeArray();

                $.ajax({
                    url: $("#formData").attr('action'),
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Re-enable the submit button
                        $("#submit-form").prop('disabled', false);

                        if (response.status == true) {
                            toastr.success(response.message);
                            setTimeout(function() {

                                window.location.href =
                                    "{{ route('admin.stocks.transfer.showlist') }}"

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
                        // Re-enable the submit button
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

            // Search by barcode
            $(document).on("input", "#barcode_scanner", function() {
                searchBarcode(productDetailsArray, "#barcode_scanner", ".product_val", ".add-row");
            });
            $(document).on("click", "#search", function() {
                searchBarcode(productDetailsArray, "#barcode_scanner", ".product_val", ".add-row");
            });

            // Function to search by barcode
            function searchBarcode(productDetailsArray, barcodeInputID, productValSelector, addRowSelector) {
                let newBarcode = $(barcodeInputID).val().trim();
                let product = null;
                if (newBarcode !== "") {
                    $.each(productDetailsArray, function(index, value) {
                        if (value.barcode.trim() === newBarcode) {
                            product = value;
                            return false;
                        }
                    });
                    if (product) {
                        const currentRow = $("table tbody tr:last");
                        if (currentRow.find(productValSelector).val() != '') {
                            $(addRowSelector).trigger('click');
                        }
                        const lastRow = $("table tbody tr:last");
                        lastRow.find(productValSelector).val(product.id).trigger("change");
                        $(barcodeInputID).val('');
                    }
                }
            }

            $(document).on("change", "select.product_val", function() {
                let productId = $(this).val();
                let unitTypeDropdown = $(this).closest("tr").find(".unitType");
                let warehouseId = $(".warehouse").val();
                fetchUnitTypes(productId, warehouseId, unitTypeDropdown);
            });

            $(document).on("change", "select.unitType", function() {
                let unitTypeID = $(this).val();
                let unitQty = $(this).closest("tr").find(".unitQty");
                let qty = $(this).closest("tr").find(".quantity");
                let productId = $(this).closest("tr").find(".product_val").val();
                unitQty.val(1);
                if (productId && productDetailsArray[productId]) {
                    let unitTypes = productDetailsArray[productId].product_details;
                    let qtyPerUnit = 0;
                    if (unitTypes && unitTypes.length > 0) {
                        let selectedUnitType = unitTypes.find(function(unitType) {
                            return unitType.unit_type_id == unitTypeID;
                        });

                        if (selectedUnitType) {
                            qtyPerUnit = selectedUnitType.quantity;
                        }
                    }
                }
                calculation();
            });

            $(document).on("change", "select.warehouse", function() {
                let warehouseId = $(this).val();
                $("table tbody tr").each(function(index) {
                    let productId = $(this).find(".product_val").val();
                    let unitTypeDropdown = $(this).find(".unitType");
                    fetchUnitTypes(productId, warehouseId, unitTypeDropdown);
                    calculation();
                });
            });

            function fetchUnitTypes(productId, warehouseId, unitTypeDropdown) {
                unitTypeDropdown.empty();

                if (productId && warehouseId) {
                    let url =
                        "{{ route('admin.available-unit-type', ['productId' => ':productId', 'warehouseId' => ':warehouseId']) }}"
                        .replace(':productId', productId)
                        .replace(':warehouseId', warehouseId);

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(response) {
                            if (response) {
                                response.forEach(function(unitType) {
                                    unitTypeDropdown.append($('<option>', {
                                        value: unitType.id,
                                        text: unitType.abbreviation,
                                        data: {
                                            availableQuantity: unitType
                                                .availableQuantity,
                                            quantity: unitType.quantity
                                        }
                                    }));
                                });
                                unitTypeDropdown.trigger('change');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            }
            $(document).on("input", ".unitQty", function() {
                calculation();
            });

            function calculation() {
                $("table tbody tr").each(function() {
                    let quantity = parseFloat($(this).find(".unitQty").val());
                    let unitTypeQty = parseFloat($(this).find(".unitType option:selected").data(
                        "quantity"));
                    let unitQty = quantity * unitTypeQty;
                    $(this).find(".quantity").val(unitQty);
                });
            }
        });
    </script>
@endsection
