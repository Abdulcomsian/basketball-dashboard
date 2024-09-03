@extends('layouts.admin')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @can('categories_create')
                <button type="button" class="btn btn-success" id="addWarehouseModalBtn">
                    Create Warehouse
                </button>
            @endcan
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Warehouses List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Abbreviation</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding new warehouse -->
    <div class="modal fade" id="addWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="addWarehouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWarehouseModalLabel">Add Warehouse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding new warehouse -->
                    <form id="addWarehouseForm">
                        @csrf
                        <div class="form-group">
                            <label class="required">Name</label>
                            <input type="text" class="form-control" id="add_name" name="name" required autofocus>
                            <label class="required">Abbreviation</label>
                            <input type="text" class="form-control" id="addAbbreviation" name="abbreviation" required />
                            <label class="required">Address</label>
                            <input type="text" class="form-control" id="add_address" name="address" required>
                        </div>
                        <button type="button" onclick="add()" class="btn btn-primary">Add Warehouse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing warehouse -->
    <div class="modal fade" id="editWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="editWarehouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editWarehouseModalLabel">Edit Warehouse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing warehouse -->
                    <form id="editWarehouseForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" id="id" name="id">
                            <label class="required">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                            <label class="required">Abbreviation</label>
                            <input type="text" class="form-control" id="editAbbreviation" name="abbreviation" required />
                            <label class="required">Address</label>
                            <input type="text" class="form-control" id="edit_address" name="address" required>
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
                ajax: "{{ route('admin.ware-houses.index') }}",
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
                        data: 'abbreviation',
                        name: 'abbreviation',
                        render : function (data) {
                            return data || ''
                        }
                    },
                    {
                        data: 'address',
                        name: 'address'
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
        // Event handler for edit button click
        $('#dataTable').on('click', '.edit-btn', function() {
            var id = $(this).data('warehouse-id');
            var name = $(this).data('warehouse-name');
            var abbreviation = $(this).data('warehouse-abbr');
            var address = $(this).data('address');
            $('#edit_name').val(name);
            $('#id').val(id);
            $('#editAbbreviation').val(abbreviation);
            $('#edit_address').val(address);
            $('#editWarehouseModal').modal('show');

        });

        $('#dataTable').on('click', '.delete-btn', function() {
            var id = $(this).data('warehouse-id');
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
                        url: "{{ url('admin/ware-houses') }}/" + id,
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

        $(document).on('click', '#addWarehouseModalBtn', function() {
            // Reset the form fields
            $('#addWarehouseForm')[0].reset();

            // Open the modal
            $('#addWarehouseModal').modal('show');
        });

        function add() {
            var name = $('#add_name').val();
            var abbreviation = $('#addAbbreviation').val();
            var address = $('#add_address').val();

            if (!name || !abbreviation || !address) {
                toastr.error('Please fill in all required fields.');
                return;
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.ware-houses.store') }}",
                data: $('#addWarehouseForm').serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        $('#addWarehouseModal').modal('hide');
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
            var abbreviation = $('#editAbbreviation').val();
            var address = $('#edit_address').val();

            if (!name || !abbreviation || !address) {
                toastr.error('Please fill in all required fields.');
                return;
            }
            $.ajax({
                type: 'PUT',
                url: "{{ route('admin.ware-houses.update', ['ware_house' => ':id']) }}".replace(':id', id),
                data: $('#editWarehouseForm').serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        $('#editWarehouseModal').modal('hide');
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
