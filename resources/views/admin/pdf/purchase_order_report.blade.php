<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Report</title>
    <style>
        /* Define your custom styles for the PDF here */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Purchase Order Report</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Stock Number</th>
                    <th>Supplier</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Unit Type</th>
                    <th>Product Qty</th>
                    <th>Purchase Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_date)) }}</td>
                        <td>{{ $item->stock_number }}</td>
                        <td>{{ $item->supplier_name }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->category->name }}</td>
                        <td>{{ $item->abbreviation }}</td>
                        <td>{{ $item->unit_qty }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                    </tr>
                @endforeach
                <tr class="total">
                    <td colspan="9">Total:</td>
                    <td>{{ $totalPrice }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
