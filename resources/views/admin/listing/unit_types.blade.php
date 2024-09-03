@extends('layouts.admin')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @can('categories_create')
                <button type="button" class="btn btn-success" id="addWarehouseModalBtn">
                    Create Unit Type
                </button>
            @endcan
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Unit Types List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            {{-- <th>Name</th> --}}
                            <th>Abbreviation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding new  -->
    <div class="modal fade" id="addWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="addWarehouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWarehouseModalLabel">Add Unit Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding new  -->
                    <form id="addWarehouseForm">
                        @csrf
                        <div class="form-group">
                            {{-- <label for="addWarehouseName">Name</label>
                            <input type="text" class="form-control" id="addWarehouseName" name="name" required
                                autofocus> --}}
                            <label for="addWarehouseName">Abbreviation</label>
                            <input type="text" class="form-control" id="abbreviation" name="abbreviation" required
                                autofocus>
                        </div>
                        <button type="button" onclick="addWarehouse()" class="btn btn-primary">Add Unit Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing  -->
    <div class="modal fade" id="editWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="editWarehouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editWarehouseModalLabel">Edit Unit Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing  -->
                    <form id="editWarehouseForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" id="id" name="id">
                            {{-- <label>Name</label>
                            <input type="text" class="form-control" id="editWarehouseName" name="name" required> --}}
                            <label>Abbreviation</label>
                            <input type="text" class="form-control" id="editabbreviation" name="abbreviation" required
                                autofocus>
                        </div>
                        <button type="button" onclick="editWarehouse()" class="btn btn-primary">Update Unit Type</button>
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
                ajax: "{{ route('admin.unit-types.index') }}",
                columns: [{
                        data: 'counter',
                        name: 'counter',
                        className: 'text-center' // Center align the content of this column
                    },
                    //{
                      //  data: 'name',
                        //name: 'name'
                    //},
                    {
                        data: 'abbreviation',
                        name: 'abbreviation'
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
            var id = $(this).data('unit_type-id');
            // var name = $(this).data('unit_type-name');
            var abbreviation = $(this).data('unit_type-abbreviation');
            // $('#editWarehouseName').val(name);
            $('#id').val(id);
            $('#editabbreviation').val(abbreviation);
            $('#editWarehouseModal').modal('show');

        });

        $('#dataTable').on('click', '.delete-btn', function() {
            var id = $(this).data('unit_type-id');
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
                        url: "{{ url('admin/unit-types') }}/" + id,
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

        function addWarehouse() {
            // Validate form fields
            // var name = $('#addWarehouseName').val();
            var abbreviation = $('#abbreviation').val();

            // if (!name || !abbreviation) {
            if (!abbreviation) {
                toastr.error('Please fill in all required fields.');
                return;
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.unit-types.store') }}",
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

        function editWarehouse() {
            var id = $('#id').val();
            // Validate form fields
            // var name = $('#editWarehouseName').val();
            var abbreviation = $('#editabbreviation').val();

            // if (!name || !abbreviation) {
            if (!abbreviation) {
                toastr.error('Please fill in all required fields.');
                return;
            }
            $.ajax({
                type: 'PUT',
                url: "{{ route('admin.unit-types.update', ['unit_type' => ':id']) }}".replace(':id', id),
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
