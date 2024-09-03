@extends('layouts.admin')
@section('content')
    @can('product_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                    {{ trans('global.create') }} {{ trans('cruds.product.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.product.title_singular') }} {{ trans('global.list') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>
                                Sr No
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Barcode
                            </th>
                            <th>
                                {{ trans('global.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr data-entry-id="{{ $product->id }}">
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $product->name ?? '' }}
                                </td>
                                <td>
                                    {{ $product->category->name ?? '' }}
                                </td>
                                <td>
                                    {{ $product->barcode ?? '' }}
                                </td>
                                <td>
                                    @can('product_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.products.show', $product->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('product_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.products.edit', $product->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('product_delete')
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-xs btn-danger delete-btn">
                                                {{ trans('global.delete') }}</button>
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
