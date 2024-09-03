<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trasnfer Stock PDF</title>
    <style>

        *{
            margin : 0;
        }

        @page{
            margin-top: 100px!important;
            /* margin-bottom: 115px!important; */
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            height: auto;
            /* background-color: purple */
        }

        /* header start */

        header{
            position: fixed;
            left: 0px;
            right: 0px;
            height: 100px;
            margin-top: -100px;
        }

        table.header{

            background-color: pink
            width : 100%;
            border-collapse: collapse;

        }

        table.header tr th img.company-logo {
            width: 80%;
            object-fit: cover;
        }

        table.header tr th:nth-child(2)
        {
            padding-top: 1.7rem; 
        }

        table.header tr th:nth-child(3)
        {
            
            padding-top: 1.9rem; 
            text-align: left;

        }
        .stock-number , .date , .warehouse-name
        {

            font-size : 0.8rem ;

        }

        .stock-number , .warehouse-name
        {

            padding-top : 0.3rem ;

        }

        /* header end */

        /* content start */

        table.content
        {
            width : 100%;
            border-collapse : collapse;
            font-size : 0.85rem;
            border-bottom: none!important;
        }

        table.content , table.content tr td , table.content tr th
        {
            border: 0.05rem solid black;
        }

        table.content , table.content tr th:first-child
        {
            border-left : none;
        }

        table.content , table.content tr th:last-child
        {
            border-right : none;
        }

        table.content tbody tr , table.content tbody tr th
        {
            
            border-bottom : none;
            border-top : none;

        }
        .content-row-height
        {
            
            line-height: 18.25px;

        }

        .content-row-border-bottom
        {
            border-bottom: 0.05rem solid black !important;
        }

        .word-inline
        {
            white-space: nowrap; /* Prevent wrapping */
            overflow: hidden; /* Hide overflow if content is too wide */
            text-overflow: ellipsis; /* Add ellipsis (...) if content overflows */
        }

        .text-white
        {
            color: white;
        }


        /* content end */

        /* footer start */
        footer {
            position: fixed;
            left: 0px;
            right: 0px;
            height: 115px;
            bottom: 0px;
            margin-bottom: -110px;
        }

        table.footer , table.footer tr th
        {
            border: none
            
        }

        table.footer tr th
        {
            /* text-align: left; */
            padding-bottom: 40px;
        }

        table.footer tr th:nth-child(2)
        {
            vertical-align:top;
            text-align: center;
            border: 1px solid black;

        }

        .page-no-tr
        {
            
            border-left : none;
            border-right : none;
            border-bottom : none;

        }

        .page-no-th
        {
            padding-top: 20px !important;
            padding-bottom: 20px !important;
        }

        .page-number { 
            font-size : 1rem;
            font-weight: 700
        }

        .page-number-count:before {
            content: counter(page);
            font-size : 2rem;
        }

        .receiver
        {
            vertical-align: top;
            border-bottom : 1px solid black!important;
        }

        .receiver div
        {
            margin-left : 110px;
            margin-top:10px
        }
       

        /* footer end */

    </style>
</head>

<body>

    <header>

        <table width="100%" class="header">
            <tr>
                <th>
                    <img src="{{ public_path('logo/company-logo.png') }}" class="company-logo" alt="company-logo">
                </th>
                <th width="40%" align="center">
                    <div class="product-list-heading">
                        Product List
                    </div>
                    <div class="stock-number">
                        No. {{ $data['stock_number'] ?? '' }}
                    </div>

                </th>
                <th>
                    <div class="date">
                        Date : {{ $data['formatted_date'] ?? '' }} 
                    </div>
                    <div class="warehouse-name">
                        {{ $data['from_warehouse']['abbreviation'] ?? '' }} to {{ $data['to_warehouse']['abbreviation'] ?? '' }}
                    </div>
                </th>
            </tr>
        </table>

    </header>

    {{-- <footer>
        <table width="100%" border="1" class="footer">
            <thead>
                <tr>
                    <th width="34.79%">
                        <div class="page-number">Page No</div>
                        <div class="page-number-count"></div>
                    </th>
                    <th width="40%" class="receiver">
                        Receiver:
                    </th>
                    <th></th>
                </tr>
            </thead>
        </table>

   </footer> --}}

    <main>

    
        <div class="container">
            

            <table width="100%" border="1" class="content">
                <thead>
                    <tr>
                        <th width="6%">No.</th>
                        <th width="22%">
                            Product Name
                        </th>
                        <th width="7%">
                            Qty
                        </th>
                        <th colspan="2">
                            
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $sno = 1;
                        $mainLoopLastIndex = false;
                    @endphp
                    @forelse ($transferLogs as $key => $logs)

                        @if ($loop->last)
                            @php
                                $mainLoopLastIndex = true;
                            @endphp
                        @endif
                        @forelse ($logs as $log)

                        
                            <tr class="content-row-height {{ $loop->last ? 'content-row-border-bottom' : '' }}">
                                    
                                @if (!is_null($log))

                                    <th>{{ $sno++ }}</th>
                                    <th class="word-inline">{{ $log['product']['name'] ?? '' }}</th>
                                    <th></th>
                                    <th colspan="2"></th>
                                    
                                    @else

                                        <th class="text-white">.</th>
                                        <th class="word-inline"></th>
                                        <th></th>
                                        <th colspan="2"></th>
        
                                @endif

                            </tr>

                                

                            @if ($loop->last)

                                <tr style="page-no-tr" style="boder-bottom: none!important">
                                    <th colspan="2" class="page-no-th" style="boder-bottom: none!important">
                                        <div class="page-number">Page No</div>
                                        
                                            
                                        <div class="page-number-count"></div>
                                        
                                    </th>
                                    <th colspan="2" class="receiver" align="left">
                                        
                                        <div>

                                            Receiver:

                                        </div>
                                    </th>
                                    <th></th>
                                </tr>

                            @endif

                        @empty
                            
                        @endforelse
                    @empty
                        
                    @endforelse

                </tbody>
            </table>

        </div>
    </main>
</body>

</html>
