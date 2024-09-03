@extends('layouts.admin')

@section('content')
    @can('customer_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12 float-right">
                <a class="btn btn-success" href="{{ route('admin.customers.create') }}">
                    {{ trans('global.create') }} Customer
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            Customers {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered border-striped" id="dataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>{{ trans('cruds.customer.fields.name') }}</th>
                            {{-- <th>{{ trans('cruds.customer.fields.email') }}</th> --}}
                            <th>{{ trans('cruds.customer.fields.contact') }}</th>
                            {{-- <th>{{ trans('cruds.customer.fields.address') }}</th> --}}
                            <th>{{ trans('global.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $customer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $customer->name ?? '' }}</td>
                                {{-- <td>{{ $customer->email ?? '' }}</td> --}}
                                <td>{{ $customer->contact ?? '' }}</td>
                                {{-- <td>{{ $customer->address ?? '' }}</td> --}}
                                <td>
                                    @can('customer_edit')
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.customers.edit', $customer->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('customer_delete')
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                            class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-xs btn-danger delete-btn">{{ trans('global.delete') }}</button>
                                        </form>
                                    @endcan
                                </td>
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

        document.addEventListener('DOMContentLoaded', function() {
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
