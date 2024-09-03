<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
        }

        .header {
            text-align: center;
            font-size: 12px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
        }

        .item-table th,
        .item-table td {
            text-align: right;
        }

        .body {
            margin-top: 20px;
            font-size: 12px;
        }

        .body .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .body .bold {
            font-weight: bold;


        }

        .bold {
            font-weight: bold;

        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer p {
            font-size: 12px;
            /* Adjusted font size */
            margin: 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .label {
            margin-right: 10px !important;
            width: 100%;
        }

        .value {
            text-align: center;
            width: 40%;
        }

        .currency {
            text-align: right;
            width: 100%;
        }

        .text-left {
            text-align: left !important;
            /* Set text alignment to left */
        }

        .info-line {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $businessInfo->store_name ?? '' }}</h1>
            <div class="info-line">
                <span class="bold">Address:</span> <span>{{ $businessInfo->address ?? '' }}</span>
            </div>
            <div class="info-line">
                <span class="bold">Contact Info:</span> <span>{{ $businessInfo->phone_no ?? '' }}</span>
            </div>
        </div>
        <hr>

        <div class="body">
            <div class="row">
                <div class="col-6">
                    <span class="bold">Date:</span>
                    <span>{{ $order->order_date ?? '' }}</span>
                </div>
                <div class="col-6">
                    <span class="bold">Customer:</span>
                    <span>{{ $order->customer->name ?? '' }} </span>
                </div>
                <div class="col-6">
                    <span class="bold">Stock Number:</span>
                    <span>{{ $order->stock_number ?? '' }}</span>
                </div>
                <div class="col-6">
                    <span class="bold">Pay Type:</span>
                    <span>{{ $order->pay_type ?? '' }}</span>
                </div>
            </div>
            <hr>

            <table class="item-table" style="width: 100%;">
                <tr>
                    <th>Sr</th>
                    <th>Product</th>
                    <th>Product Category</th>
                    <th>QTY</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                @foreach ($order->orderLogs as $key => $stockLogs)
                    <tr>

                        <td>{{ $key + 1 }}</td>
                        <td>{{ $stockLogs->product->name ?? '' }}</td>
                        <td>{{ $stockLogs->product->category->name ?? '' }}</td>
                        <td>{{ $stockLogs->unit_qty ?? '' }}</td>
                        <td>{{ numberFormat($stockLogs->price ?? '') }}</td>
                        <td>{{ numberFormat($stockLogs->total ?? '') }}</td>
                    </tr>
                @endforeach
            </table>
            <hr>

            <table class="" style="width: 100%;font-size:12px">
                <tr>
                    <td class="text-left" style="width: 35%;">Grand Total:</td>
                    <td style="width: 15%;">Rp.</td>
                    <td class="currency" style="width: 50%;">{{ numberFormat($order->total_bill) }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 35%;">Total Paid:</td>
                    <td style="width: 15%;">Rp.</td>
                    <td class="currency" style="width: 50%;">{{ numberFormat($order->total_paid) }}</td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 35%;">Remaining:</td>
                    <td style="width: 15%;">Rp.</td>
                    <td class="currency" style="width: 50%;">{{ numberFormat($order->total_bill - $order->total_paid) }}
                    </td>
                </tr>
            </table>

            <hr>

            <div class="footer">
                <p>Thank you for your business!</p>
                <p><a href="{{ config('app.url') }}">{{ config('app.name') }}</p></a>
            </div>
        </div>
    </div>
</body>

</html>
