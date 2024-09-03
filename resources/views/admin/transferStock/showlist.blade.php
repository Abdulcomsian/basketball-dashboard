@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Stock Transfer {{ trans('global.list') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered border-striped" id="dataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Date</th>
                            <th>Transfer No</th>
                            <th>From Warehouse</th>
                            <th>To Warehouse</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Stock as $key => $s)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $s->date ?? '' }}</td>
                                <td>{{ $s->stock_number ?? '' }}</td>
                                <td>{{ $s->from_warehouse->abbreviation ?? '' }}</td>
                                <td>{{ $s->to_warehouse->abbreviation ?? '' }}</td>
                                <td>
                                    @php
                                        $status = $s->status ?? '';
                                        $badgeClass = '';
                                        switch ($status) {
                                            case 'Transfered':
                                                $badgeClass = 'badge badge-success';
                                                break;
                                            case 'In Transmit':
                                                $badgeClass = 'badge badge-warning';
                                                break;
                                            case 'Cancelled':
                                                $badgeClass = 'badge badge-danger';
                                                break;
                                            default:
                                                $badgeClass = 'badge badge-secondary';
                                                break;
                                        }
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.transfer-stocks.show', [$s->id ?? '']) }}"
                                        class="btn btn-xs btn-info fa fa-eye" title="{{ trans('global.view') }}"></a>
                                    @if ($s->status == 'In Transmit')
                                        <button type="button" value="{{ $s->id ?? '' }}" class="btn btn-xs btn-danger"
                                            onclick="confirmAction('Cancel', {{ $s->id }})">
                                            Cancel
                                        </button>
                                        <button type="button" value="{{ $s->id ?? '' }}" class="btn btn-xs btn-success"
                                            onclick="confirmAction('Transfered', {{ $s->id }})">
                                            Approve Transfer
                                        </button>
                                    @endif
                                    @can('transfer_stock_pdf')
                                        
                                        <a href="{{ route('admin.transfer-stocks.pdf', $s->id) }}"
                                        class="btn btn-xs btn-primary" title="{{ trans('global.datatables.pdf') }}" >
                                            {{ trans('global.datatables.pdf') }}
                                        </a>

                                    @endcan
                            </tr>
                        @endforeach
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
            $('#dataTable').DataTable({
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
            });
        });

        function confirmAction(status, id) {
            var actionText = status === 'Cancel' ? 'cancel this transfer' : 'approve this transfer';
            if (confirm('Are you sure you want to ' + actionText + '?')) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.stocks.transfer.update_status') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status === 'Cancel' ? 'Cancelled' : 'Transfered',
                        id: id
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            location.reload();
                        } else if (response.status === 'error') {
                            toastr.error(response.message);
                        } else if (response.status === 'validation_error') {
                            if (response.errors.name) {
                                toastr.error(response.errors.name[0]);
                            }
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            toastr.error(errors.name[0]);
                        } else {
                            toastr.error('An error occurred while processing the request.');
                        }
                    }
                });
            }
        }
    </script>
@endsection
