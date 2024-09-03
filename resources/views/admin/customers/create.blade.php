@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }}
        </div>

        <div class="card-body">
            <form method="POST" id="add-customer-form" action="{{ route('admin.customers.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.customer.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                </div>
                {{-- <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.customer.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email') }}">
                </div> --}}
                <div class="form-group">
                    <label class="required" for="contact">{{ trans('cruds.customer.fields.contact') }}</label>
                    <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text"
                        name="contact" id="contact" value="{{ old('contact', '') }}">
                </div>
                {{-- <div class="form-group">
                    <label class="required" for="address">{{ trans('cruds.customer.fields.address') }}</label>
                    <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="5"
                        value="{{ old('contact', '') }}"></textarea>
                </div> --}}
                <div class="form-group">
                    <button id="submitForm" class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            let shippingAddressCounter = 1;

            $('#addShippingAddress').click(function() {
                const shippingAddressesContainer = $('#shippingAddresses');
                const newShippingAddress = `
                    <div class="shipping-address">
                        <div class="input-group mb-2">
                            <input type="text" name="shippingAddress[]" class="form-control"
                                placeholder="{{ trans('cruds.customer.fields.shipping_address') }}${shippingAddressCounter + 1}" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger btn-remove-address">{{ trans('global.remove') }}</button>
                            </div>
                        </div>
                    </div>
                `;
                shippingAddressesContainer.append(newShippingAddress);
                shippingAddressCounter++;
                updateShippingAddressPlaceholders();
            });

            $(document).on('click', '.btn-remove-address', function() {
                $(this).closest('.shipping-address').remove();
                shippingAddressCounter--;
                updateShippingAddressPlaceholders();
            });

            function updateShippingAddressPlaceholders() {
                $('.shipping-address input[type="text"]').each(function(index) {
                    $(this).attr('placeholder',
                        `{{ trans('cruds.customer.fields.shipping_address') }}${index + 1}`);
                });
            }
        });
    </script>
@endsection
