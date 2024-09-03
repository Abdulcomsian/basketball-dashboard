@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Paid Orders List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Order">
                    <thead>
                        <th>Sr No</th>
                        <th>Order No</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Total Bill</th>
                        <th>Total Paid</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @if ($orders)
                            @foreach ($orders as $key => $order)
                                <tr data-entry-id="{{ $order->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $order->stock_number }}</td>
                                    <td>{{ $order->order_date ?? '' }}</td>
                                    <td>{{ $order->customer->name ?? '' }}</td>
                                    <td class="text-right">{{ numberFormat($order->total_bill ?? '') }}</td>
                                    <td class="text-right">{{ numberFormat($order->total_paid ?? '') }}</td>
                                    <td>{{ $order->createdBy->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('admin.order.show', [$order->id ?? '']) }}"
                                            class="btn btn-xs btn-success fa fa-eye"></a>
                                        @can('order_delete')
                                            <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST"
                                                class="delete-form" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-xs btn-danger delete-btn">{{ trans('global.delete') }}</button>
                                                <a href="{{ route('admin.order.paymentLogs', [$order->id ?? '']) }}"
                                                    class="btn btn-xs btn-info">Payment Logs</a>
                                            </form>
                                        @endcan
                                        <a href="{{ route('admin.order.invoice', [$order->id ?? '']) }}"
                                            class="btn btn-xs btn-danger" target="_blank">
                                            <i class="fas fa-file-pdf"></i> Show Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.datatable-Order').DataTable({
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
            });

            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                const deleteBtn = form.querySelector('.delete-btn');

                deleteBtn.addEventListener('click', function() {
                    const form = this.closest('.delete-form');

                    swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this data!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                form.submit();
                            } else {
                                swal("Your data is safe!", {
                                    icon: "info",
                                });
                            }
                        });
                });
            });
        });
    </script>
@endsection
