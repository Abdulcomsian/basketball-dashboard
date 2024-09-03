@extends('layouts.admin')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @can('categories_create')
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCategoryModal">
                    Create Category
                </button>
            @endcan
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Categories List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Product" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>{{ trans('cruds.product_category.fields.name') }}</th>
                            <th>{{ trans('global.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td> @can('categories_edit')
                                        <button type="button" class="btn btn-xs btn-info" data-toggle="modal"
                                            data-target="#editCategoryModal{{ $category->id }}">{{ trans('global.edit') }}</button>
                                    @endcan
                                    @can('categories_delete')
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                            class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-xs btn-danger delete-btn">{{ trans('global.delete') }}</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>

                            <!-- Modal for editing category -->
                            <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                                                {{ trans('cruds.product_category.edit_category') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form for editing category -->
                                            <form action="{{ route('admin.categories.update', $category->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label
                                                        for="editCategoryName">{{ trans('cruds.product_category.fields.name') }}</label>
                                                    <input type="text" class="form-control" id="editCategoryName"
                                                        name="name" value="{{ $category->name }}" required autofocus>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary">{{ trans('cruds.product_category.update_category') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding new category -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">{{ trans('cruds.product_category.add_category') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding new category -->
                    <form action="{{ route('admin.categories.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="addCategoryName">{{ trans('cruds.product_category.fields.name') }}</label>
                            <input type="text" class="form-control" id="addCategoryName" name="name" required
                                autofocus>
                        </div>
                        <button type="submit"
                            class="btn btn-primary">{{ trans('cruds.product_category.add_category') }}</button>
                    </form>
                </div>
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

                    Swal.fire({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        } else {
                            Swal.fire("Cancelled", "Your data is safe!", "info");
                        }
                    });
                });
            });
        });
    </script>
@endsection
