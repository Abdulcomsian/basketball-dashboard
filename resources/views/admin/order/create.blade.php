@extends('layouts.admin')
@section('content')
    <div class="card">
        <form id="formData" method="POST" action="{{ route('admin.order.store') }}">
            @csrf
            <div class="card-header">
                <h4>Create Order</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="date" class="required">Order No:</label>
                        <input type="text" name="stock_number" class="form-control" value="{{ $stock_number }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="date" class="required">{{ trans('global.fields.date') }}:</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="customers" class="required">Customer</label>
                        <select class="form-control" name="customer_id" required>
                            <option value="">Select</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div>
                            <label class="required" for="payment_method">Type of Payment:</label>
                        </div>
                        <div class="btn-group" role="group" aria-label="payment_type">
                            <input type="hidden" name="pay_type">
                            <button type="button" class="btn btn-primary mr-2" id="cash"
                                style="border-radius: 5px;">Cash</button>
                            <button type="button" class="btn btn-secondary" id="credit"
                                style="border-radius: 5px;">Credit</button>
                        </div>

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="priceToggle"></label>
                        <div class="d-flex">
                            <label for="priceToggle">General Price</label>
                            <div class="custom-control custom-switch ml-4">
                                <input type="checkbox" class="custom-control-input" id="priceToggle">
                                <label class="custom-control-label" for="priceToggle">Special Price</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
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
                            <th style="width: 10%;">{{ trans('global.fields.quantity') }}</th>
                            <th style="width: 15%;">Unit Type</th>
                            <th style="width: 10%;">Total Units</th>
                            <th style="width: 10%;">Price</th>
                            <th style="width: 15%;">Total</th>
                            <th style="width: 15%;">Warehouse</th>
                            <th style="width: 5%;">{{ trans('global.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="row">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right">
                                <div class="row justify-content-end">
                                    <div class="col-md-3">
                                        <label>Total Bill</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input type="hidden" value="0" class="form-control total_bill" readonly
                                            name="total_bill" style="text-align: right;">

                                        <input type="text" value="0" class="form-control total_bill_val" readonly style="text-align: right;" />
                                    </div>
                            </td>
                            <td colspan="2">
                                <button type="button"
                                    class="btn btn-info btn-sm add-row">{{ trans('global.add_row') }}</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right">
                                <div class="row justify-content-end">
                                    <div class="col-md-3">
                                        <label for="payment_method" class="text-right">Payment Method</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="payment_method_id" required>
                                            @foreach ($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}">{{ $payment_method->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <label for="payment_method" class="text-right">Total Paid</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" value="0" class="form-control total_paid"
                                            name="total_paid" style="text-align: right;">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="total-change-row">
                            <td colspan="6" class="text-right">
                                <div class="row justify-content-end">
                                    <div class="col-md-3 text-right">
                                        <label for="payment_method" class="text-right">Change</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" value="0" class="form-control total-change-val"
                                            name="total_change" style="text-align: right;" readonly />
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right">
                                <div class="row justify-content-end">
                                    <div class="col-md-3">
                                        <label for="date" class="text-right">Due Date</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="due_date" class="form-control" value="">
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>
                <button type="button" class="btn btn-success mt-2"
                    id="submit-form">{{ trans('global.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    {{-- big number cdn --}}
    <script src='https://cdn.jsdelivr.net/npm/bignumber.js@9.1.2/bignumber.min.js'></script>

    <script type="text/javascript">
        let productDetailsArray = {!! json_encode($products->keyBy('id')->toArray()) !!};
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
                    <td class="quantity_col">
                        <input type="number" name="quantity[]" class="form-control quantity text-right" min="1" value="1" required>
                    </td>
                    <td class="unit_type">
                        <select name="unit_type_id[]" class="form-control unitType" required></select>
                    </td>
                    <td class="unit_qty">
                        <input type="text" name="unit_qty[]" class="form-control unitQty text-right" readonly>
                    </td>
                    <td class="price">
                        <input type="text" name="price[]" class="form-control sellPrice text-right" readonly>
                    </td>
                    <td class="total">
                        <input type="hidden" name="total[]" class="form-control total_amount text-right" readonly>
                        <input type="text" class="form-control total_amount_val text-right" readonly>
                    </td>
                    <td>
                        <select class="form-control warehouse" name="warehouse_id[]" required>
                            @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->abbreviation }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row" title="Delete"><i class="fas fa-trash-alt"></i></button>
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

            $("#submit-form").click(function(e) {

                let totalPaid = parseFloat($('.total_paid').val());
                let totalBill = parseFloat($('.total_bill').val());

                if (isNaN(totalPaid) || isNaN(totalBill) || totalPaid < 0 || totalBill < 0) {
                    toastr.error('Invalid total paid or total bill amount.');
                    return false;
                }

                $(this).prop('disabled', true);
                if(totalPaid == 0)
                {
                    toastr.error('Paid amount should not be 0');
                    $(this).prop('disabled', false);
                    return;
                }

                let paymentType = $("input[name='pay_type']").val();

                if(paymentType === 'Credit')
                {
                    
                    if (totalPaid > totalBill) {
                        toastr.error('Paid amount should be less than or equal to the Total Bill.');
                        $(this).prop('disabled', false);
                        return;
                    }

                }
                else
                {
                    
                    if (totalPaid < totalBill) {
                        toastr.error('Paid amount should be greater than or equal to the Total Bill.');
                        $(this).prop('disabled', false);
                        return;
                    }

                }

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
                                let paymentType = $("input[name='pay_type']").val();
                                window.location.href =
                                    paymentType === 'Credit' ?
                                    "{{ route('admin.order.index', ['pay_type' => 'Credit']) }}" :
                                    "{{ route('admin.order.index', ['pay_type' => 'Cash']) }}";
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


            $(".btn-group button").click(function() {
                const $buttons = $(".btn-group button");
                $buttons.removeClass("btn-primary").addClass("btn-secondary");
                $(this).removeClass("btn-secondary").addClass("btn-primary");

                const paymentType = $(this).attr('id') === 'credit' ? 'Credit' : 'Cash';
                $("input[name='pay_type']").val(paymentType);

                const totalBill = parseFloat($('.total_bill').val());
                const totalPaid = paymentType === "Credit" ? 0.00 : totalBill;
                $('.total_paid').val(totalPaid.toFixed(2));

                // if (paymentType == 'Credit') {
                //     $('.total_paid').prop('readonly', false);
                // } else {
                //     $('.total_paid').prop('readonly', true);
                // }

                if (paymentType == 'Credit') {
                    $('.total-change-row').hide()
                } else {

                    calculateTotalChange()

                    $('.total-change-row').show()
                }
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

            $(document).on("change", "select.product_val", function() {
                let productId = $(this).val();
                let unitTypeDropdown = $(this).closest("tr").find(".unitType");
                let warehouseId = $(this).closest("tr").find(".warehouse").val();
                fetchUnitTypes(productId, warehouseId, unitTypeDropdown);
            });

            $(document).on("change", "select.warehouse", function() {
                let productId = $(this).closest("tr").find(".product_val").val();
                let unitTypeDropdown = $(this).closest("tr").find(".unitType");
                let warehouseId = $(this).val();
                fetchUnitTypes(productId, warehouseId, unitTypeDropdown);
            });

            $(document).on("change", "select.unitType", function() {
                updatePricesBasedOnToggle();
                calculation();
            });


            $('#priceToggle').change(function() {
                updatePricesBasedOnToggle();
            });

            function updatePricesBasedOnToggle() {
                let toggleChecked = $('#priceToggle').prop('checked');

                $("table tbody tr").each(function() {
                    let productId = $(this).find(".product_val").val();
                    let unitTypeID = $(this).find(".unitType").val();
                    let priceCol = $(this).find(".sellPrice");

                    if (productId && productDetailsArray[productId]) {
                        let unitTypes = productDetailsArray[productId].product_details;
                        let price = 0;

                        if (unitTypes && unitTypes.length > 0) {
                            let selectedUnitType = unitTypes.find(function(unitType) {
                                return unitType.unit_type_id == unitTypeID;
                            });

                            if (selectedUnitType) {
                                price = toggleChecked ? selectedUnitType.special_selling_price :
                                    selectedUnitType.general_selling_price;
                            } else {
                                price = 0;
                            }

                        }

                        priceCol.val(price);
                        calculation();
                    }
                });
            }

            function calculateTotalChange()
            {

                let totalPaid = new BigNumber($('.total_paid').val())

                let totalBill = new BigNumber($('.total_bill').val())

                let totalChange = totalPaid.minus(totalBill)

                $('.total-change-val').val(totalChange.toFixed(2))


            }

            // when payment type is cash 
            $('.total_paid').keyup(function (){

               
                calculateTotalChange()

            })

            function calculation() {
                let totalBill = 0;
                var subTotal = new BigNumber(0)
                let paymentType = $("input[name='pay_type']").val();

                $("table tbody tr").each(function() {
                    let qty = new BigNumber($(this).find(".quantity").val())
                    let unitTypeQty = new BigNumber($(this).find(".unitType option:selected").data("quantity"));
                    
                    var unitQty;
                    if(isNaN(parseFloat(qty)) || isNaN(parseFloat(unitTypeQty)))
                    {
                        unitQty = '0.00'
                    }
                    else
                    {
                        unitQty = qty.multipliedBy(unitTypeQty)
                        unitQty = unitQty.toFixed(2)
                    }

                    $(this).find(".unitQty").val(unitQty);

                    let price = new BigNumber($(this).find(".sellPrice").val());
                    var total;
                    if(isNaN(parseFloat(qty)) || isNaN(parseFloat(price)))
                    {
                        total = '0.00'
                    }
                    else
                    {
                        total = price.multipliedBy(qty)
                        total = total.toFixed(2)
                    }

                    $(this).find(".total_amount").val(total);
                    $(this).find(".total_amount_val").val(formatNumberWithCommas(total.toString()))

                    subTotal = subTotal.plus(total)

                });

                let subTotalToFixed = subTotal.toFixed(2)

                $(".total_bill").val(subTotalToFixed);
                $(".total_bill_val").val(formatNumberWithCommas(subTotal.toString()));

                let totalPaid = paymentType === 'Credit' ? 0.00 : subTotalToFixed;
                $('.total_paid').val(totalPaid);


                calculateTotalChange()

            }


            $(document).on("input", ".quantity, .sellPrice", function() {
                $(this).closest("tr").find(".unitType").trigger('change');
                calculation();
            });

        });
    </script>
@endsection
