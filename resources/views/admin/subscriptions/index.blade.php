@extends('layouts.admin')
@section('title', 'Subscriptions')
@section('header', 'Subscriptions')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-fluid">

        </div>
        <div class="container-fluid">
            <div class="mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Role cell-border">
                        <thead>
                            <tr class="text-start text-black-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px text-center">#</th>
                                <th class="min-w-125px text-center">Name</th>
                                <th class="min-w-125px text-center">Email</th>
                                <th class="min-w-125px text-center">Subscription #</th>
                                <th class="min-w-125px text-center">Status</th>
                                <th class="min-w-125px text-center">Amount</th>
                                <th class="min-w-125px text-center">Start Date</th>
                                <th class="min-w-125px text-center">End Date</th>
                                <th class="text-end min-w-100px text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $key => $subscription)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $subscription->user->name }}</td>
                                    <td class="text-center">{{ $subscription->user->email }}</td>
                                    <td class="text-center">{{ $subscription->stripe_subscription_id }}</td>
                                    <td class="text-center">{{ ucfirst($subscription->stripe_status) }}</td>
                                    <td class="text-center">{{ number_format($subscription->amount, 2) }}
                                        {{ strtoupper($subscription->currency) }}</td>
                                    <td class="text-center">{{ $subscription->start_date->format('Y-m-d') }}</td>
                                    <td class="text-center">{{ $subscription->end_date->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <a onclick="event.preventDefault(); 
                                           if(confirm('Are you sure?')) { 
                                           document.getElementById('delete-form-{{ $subscription->id }}').submit(); 
                                            }"
                                            class="menu-link px-3" data-kt-users-table-filter="delete_row">
                                            <button class="btn btn-sm delete-btn">Delete</button>
                                        </a>

                                        <form id="delete-form-{{ $subscription->id }}"
                                            action="{{ route('admin.subscriptions.destroy', $subscription->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('role_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.roles.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id');
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}');
                            return;
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload();
                                });
                        }
                    }
                };
                dtButtons.push(deleteButton);
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                autoWidth: false,
                orderCellsTop: true,
                order: [
                    [0, 'asc']
                ],
                pageLength: 10,
                responsive: true,
                scrollX: true,
                scrollCollapse: true,
                columnDefs: [{
                        width: '10%',
                        targets: 0
                    },
                    {
                        orderable: false,
                        targets: '_all'
                    }
                ],
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                }
            });

            let table = $('.datatable-Role:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            $('#geographicZoneSelect').select2();
            $('#salesPersonSelect').select2();
        });
    </script>
@endsection
@endsection
