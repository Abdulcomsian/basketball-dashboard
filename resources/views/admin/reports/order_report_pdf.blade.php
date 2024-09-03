<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Report</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        .main-table , .table2 , .table3 , .table4
        {
            width : 100%;
        }
        .main-table thead tr th
        {
            text-align: left;
        }
        .my-font-family
        {
            font-family: sans-serif;
            font-size: 0.8rem;
        }
        .text-align-center
        {
            text-align: center!important;
        }

        .text-align-right
        {
            text-align: right!important;
        }

        .hr-style
        {
            border: 0.04rem solid black;
        }

        .table2 thead tr th
        {
            text-align: left;
            
        }

        .table2 thead tr:nth-child(1) td
        {
            padding-top: 1rem; 
        }


        .table3
        {
            margin-top : 1rem;
            border-collapse: collapse;
        }        
        .table3 thead th {
            text-align: left;
            border-bottom: 0.1rem solid black;
            padding: 0.6rem 0.1rem;
        }

        /* .table3 tbody tr:nth-child(1) td
        {
            padding : 0.6rem 0 0 0 ;
        }
 */
        .table3 tbody tr td
        {
            padding : 0.6rem 0 0 0.2rem ;
            word-wrap: break-word!important
        }

        .table3 tbody tr:last-child td
        {
            padding-bottom : 1rem ;
        }

        .table3 tfoot th:last-child {
            border-top: 0.1rem solid black;
            padding: 0.6rem 0.1rem;
        }
        
        .rp-text
        {
            float : left
        }

        .table4 tfoot th:last-child {
            border-top: 0.1rem solid black;
            padding: 0.6rem 0.1rem;
        }

        .end-of-page {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center; /* Align content to the center */
        }

    </style>
</head>

<body>
    @if (empty($data))
        <p>No data available</p>
    @else
        
        <div class="text-align-center my-font-family">
            <h1 style="margin : 0;">{{ $setting->store_name ?? '' }}</h1>
            <div class="info-line">
                <strong>Address:</strong> <span>{{ $setting->address ?? '' }}</span>
            </div>
            <div class="info-line">
                <strong>Contact Info:</strong> <span>{{ $setting->phone_no ?? '' }}</span>
            </div>
        </div>

        <br />

        <hr class="hr-style" />

        <table class="main-table" width="100%">
            <thead>
                <tr>
                    <th width="19%" class="my-font-family">No of invoice</th>
                    <th width="17%" class="my-font-family">Date</th>
                    <th width="20%" class="my-font-family">Customer</th>
                    <th class="my-font-family">Type of payment</th>
                </tr>
            </thead>
        </table>

        <hr class="hr-style" />
        @php
            
            $grandTotal = 0;

        @endphp
        @forelse ($data as $order)
            
            @php
                
                $grandTotal += $order['total_bill'] ?? 0;

            @endphp
       
            <table class="table2" width="100%">
                <thead>
                    <tr>
                        <td width="19%" class="my-font-family">{{ $order['stock_number'] ?? '' }}</td>
                        <td width="17%" class="my-font-family">{{ date('d/m/Y', strtotime($order['order_date'] ?? '')) }}</td>
                        <td width="20%" class="my-font-family">{{ $order['customer']['name'] ?? '' }}</td>
                        <td class="my-font-family">{{ $order['pay_type'] ?? '' }}</td>
                    </tr>
                </thead>
            </table>

            <table class="table3" width="100%">
                <thead>
                    <tr>
                        <th width="14%" class="my-font-family">Code</th>
                        <th width="15%" class="my-font-family">Warehouse</th>
                        <th width="22%" class="my-font-family">Name Of Goods</th>
                        <th width="7%" class="my-font-family text-align-center">Unit</th>
                        <th width="8%" class="my-font-family text-align-center">Qty</th>
                        <th width="15%" class="my-font-family text-align-center">Price</th>
                        <th class="my-font-family text-align-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse ($order['order_logs'] as $orderLog)
                        
                   
                        <tr>
                            <td width="14%" class="my-font-family">{{ $orderLog['product']['barcode'] ?? '' }}</td>
                            <td width="15%" class="my-font-family">{{ $orderLog['warehouse']['abbreviation'] ?? '' }}</td>
                            <td width="22%" class="my-font-family">{{ $orderLog['product']['name'] ?? '' }}</td>
                            <td width="7%" class="my-font-family text-align-center">{{ $orderLog['unit_type']['abbreviation'] ?? '' }}</td>
                            <td width="8%" class="my-font-family text-align-center">{{ $orderLog['unit_qty'] ?? '' }}</td>
                            <td width="15%" class="my-font-family text-align-center">{{ numberFormat($orderLog['price'] ?? '') }}</td>
                            <td class="my-font-family text-align-right">{{ numberFormat($orderLog['total'] ?? '') }}</td>
                        </tr>

                    @empty
                        
                    @endforelse

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6"></th>
                        <th class="my-font-family text-align-right">
                            <span class="rp-text">
                                Rp.
                            </span>
                            <span>

                                {{ numberFormat($order['total_bill'] ?? '') }}

                            </span>
                        </th>
                    </tr>
                </tfoot>
            </table>

        @empty
            
        @endforelse
        
        <table class="table4" width="100%">
            <tfoot>
                <tr>
                    <th width="81%"></th>
                    <th class="my-font-family text-align-right">
                        <span class="rp-text">
                            Rp.
                        </span>
                        <span>

                            {{ numberFormat($grandTotal) }}

                        </span>
                    </th>
                </tr>
            </tfoot>
        </table>

        <div class="end-of-page">

            <div class="text-align-center my-font-family">
                <p>Thank you for your business!</p>
                <p><a href="{{ config('app.url') }}">{{ config('app.name') }}</p></a>
            </div>
        </div>

    @endif

</body>

</html>
