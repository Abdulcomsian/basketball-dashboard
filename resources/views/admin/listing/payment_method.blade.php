@extends('layouts.admin')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @can('payment_method_create')
                <button type="button" class="btn btn-success" id="addPaymentMethodModalBtn">
                    Create Payment Method
                </button>
            @endcan
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Payment Methods List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding new payment method -->
    <div class="modal fade" id="addPaymentMethodModal" tabindex="-1" role="dialog"
        aria-labelledby="addPaymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentMethodModalLabel">Add Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding new payment method -->
                    <form id="addPaymentMethodForm">
                        @csrf
                        <div class="form-group">
                            <label class="required">Name</label>
                            <input type="text" class="form-control" id="add_name" name="name" required autofocus>
                        </div>
                        <button type="button" onclick="add()" class="btn btn-primary">Add Payment Method</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing payment method -->
    <div class="modal fade" id="editPaymentMethodModal" tabindex="-1" role="dialog"
        aria-labelledby="editPaymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentMethodModalLabel">Edit Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing payment method -->
                    <form id="editPaymentMethodForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" id="id" name="id">
                            <label class="required">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <button type="button" onclick="edit()" class="btn btn-primary">Update</button>
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
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.payment-methods.index') }}",
                columns: [{
                        data: 'counter',
                        name: 'counter',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        $('#dataTable').on('click', '.edit-btn', function() {
            var id = $(this).data('payment-method-id');
            var name = $(this).data('payment-method-name');
            $('#edit_name').val(name);
            $('#id').val(id);
            $('#editPaymentMethodModal').modal('show');
        });

        $('#dataTable').on('click', '.delete-btn', function() {
            var id = $(this).data('payment-method-id');
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
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('admin/payment-methods') }}/" + id,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.success(response.message);
                                $('#dataTable').DataTable().ajax.reload();
                            } else {
                                toastr.error('An error occurred while deleting the warehouse.');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                toastr.error(errors.message[0]);
                            } else {
                                toastr.error('An error occurred while processing the request.');
                            }
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your data is safe!", "info");
                }
            });
        });

        $(document).on('click', '#addPaymentMethodModalBtn', function() {
            $('#addPaymentMethodForm')[0].reset();
            $('#addPaymentMethodModal').modal('show');
        });

        function add() {
            var name = $('#add_name').val();
            if (!name) {
                toastr.error('Please fill in all required fields.');
                return;
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.payment-methods.store') }}",
                data: $('#addPaymentMethodForm').serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        $('#addPaymentMethodModal').modal('hide');
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success(response.message);
                    } else if (response.status === 'error') {
                        toastr.error(response.message);
                    } else if (response.status === 'validation_error') {
                        // Handle validation errors individually
                        if (response.errors.name) {
                            toastr.error(response.errors.name[0]);
                        }
                        // Add similar blocks for other fields if needed
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        toastr.error(errors.name[0]);
                        // Add similar blocks for other fields if needed
                    } else {
                        toastr.error('An error occurred while processing the request.');
                    }
                }
            });
        }

        function edit() {
            var id = $('#id').val();
            var name = $('#edit_name').val();
            if (!name) {
                toastr.error('Please fill in all required fields.');
                return;
            }
            $.ajax({
                type: 'PUT',
                url: "{{ route('admin.payment-methods.update', ['payment_method' => ':id']) }}".replace(':id', id),
                data: $('#editPaymentMethodForm').serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        $('#editPaymentMethodModal').modal('hide');
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success(response.message);
                    } else if (response.status === 'error') {
                        toastr.error(response.message);
                    } else if (response.status === 'validation_error') {
                        // Handle validation errors individually
                        if (response.errors.name) {
                            toastr.error(response.errors.name[0]);
                        }
                        // Add similar blocks for other fields if needed
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        toastr.error(errors.name[0]);
                        // Add similar blocks for other fields if needed
                    } else {
                        toastr.error('An error occurred while processing the request.');
                    }
                }
            });
        }
    </script>
@endsection
