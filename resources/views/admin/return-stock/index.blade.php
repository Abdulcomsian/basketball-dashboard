@extends('layouts.admin')
@section('content')

<style>
    .warning-text {
        background-color: #FFEB3B;
        padding: 10px;
    }
</style>
    <div class="card">
        <div class="card-header">
            Return Stock {{ trans('global.list') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable" id="returnStockDataTable">
                    <thead>
                        <th>Sr No</th>
                        <th>Return Stock #</th>
                        <th>{{ trans('global.fields.date') }}</th>
                        <th>{{ trans('global.fields.supplier') }}</th>
                        <th>{{ trans('global.fields.total_bill') }}</th>
                        <th>{{ trans('global.fields.paid_amount') }}</th>
                        <th>{{ trans('global.fields.status') }}</th>
                        <th>{{ trans('global.actions') }}</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">{{ trans('global.add') }}
                        {{ trans('global.payments.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentForm">
                        @csrf
                        <input type="hidden" name="return_stock_id" id="return_stock_id">
                        <div class="form-group">
                            <label for="paymentMethod">Payment Method</label>
                            <select class="form-control form-control-sm select2" name="payment_method_id" required style="width:100%">
                                
                                @forelse ($paymentMethods as $paymentMethod)
                                    
                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}
                                    </option>

                                @empty

                                @endforelse

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">{{ trans('global.fields.paid_amount') }}</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="0"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('global.add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- delete modal --}}

    <div class="modal fade" id="deleteReturnStockConfirmation" tabindex="-1" role="dialog"
        aria-labelledby="deleteReturnStockConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReturnStockConfirmationLabel">Are you
                        sure?</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="POST" id="deleteReturnStockConfirmationForm" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="warning-text"><strong>Warning:</strong> Once deleted, you
                            will not be able to recover this data!</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- change status --}}

    <div class="modal fade" id="changeReturnStockStatusModal" tabindex="-1" role="dialog"
    aria-labelledby="changeReturnStockStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeReturnStockStatusModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="POST" id="changeReturnStockStatusModalForm" style="display: inline-block;">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="ChangeStatus">Status</label>
                            <select name="status" id="returnStockStatus" class="form-control form-control-sm select2" required style="width:100%">
                                <option value="">select</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
@endsection
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.return-stock.get-all') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'stock_number',
                        name: 'stock_number'
                    },
                    {
                        data: 'formatted_return_stock_date',
                        name: 'return_stock_date'
                    },
                    {
                        data: 'supplier.name',
                        name: 'supplier.name',
                        render : function(data)
                        {
                            return data || ''
                        }
                    },
                    {
                        data: 'total_bill',
                        name: 'total_bill'
                    },
                    {
                        data: 'total_paid',
                        name: 'total_paid'
                    },
                    {
                        data: 'status_html',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable : false,
                        searchable : false
                    }
                ],
                order: [[0, "DESC"]], //column indexes is zero based
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }],
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(7)').addClass('text-center');
                }
            });

            let totalPayment = 0;
            let paid = 0;
            let paymentAmount;

            $('#addPaymentModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let returnStockId = button.data('return-stock-id');
                $('#return_stock_id').val(returnStockId);
                totalPayment = button.data('total-payment');
                paid = button.data('paid');
            });

            $('#addPaymentForm').submit(function(e) {
                e.preventDefault();

                $('#addPaymentForm button[type="submit"]').prop('disabled', true);

                let paymentMethodId = $('#payment_method_id option:selected').val()
                paymentAmount = parseFloat($('#amount').val());

                if (isNaN(paymentAmount) || paymentAmount < 0 || paymentAmount > (totalPayment - paid)) {
                    
                    toastr.error('Invalid payment amount. Please enter a valid amount.')
                    $('#addPaymentForm button[type="submit"]').prop('disabled', false)

                    return;

                }
                
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.return-stock.add-payment') }}",
                    data: formData,
                    success: function(response) {
                        console.log(response)
                        if (response.status == true) {
                            
                            $('#addPaymentModal').modal('hide');
                            
                            toastr.success(response.msg);

                            setTimeout(() => {
                                
                                location.reload();

                            }, 1000);

                        }
                        else
                        {

                            toastr.error(response.msg);

                        }

                    },
                    error: function(error) {
                        toastr.error('Failed to make payment', 'Error');
                    },
                    complete: function() {
                        $('#addPaymentForm button[type="submit"]').prop('disabled', false);
                    }
                });
            });

            
        });

        // delete 
        $(document).on('click','.delete-return-stock',function () {
            
            let deleteUrl = $(this).attr('data-delete-url')
            $('#deleteReturnStockConfirmationForm').prop('action', deleteUrl);
            $('#deleteReturnStockConfirmation').modal('show')

        })

        // change status
        $(document).on('click','.change-return-stock-status',function () {
            
            let url = $(this).attr('data-url')
            $('#changeReturnStockStatusModalForm').prop('action', url);
            $('#changeReturnStockStatusModal').modal('show')
            
        })

    </script>
@endsection
