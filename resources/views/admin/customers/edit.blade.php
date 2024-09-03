@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.customer.edit') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.customers.update', [$customer->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.customer.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $customer->name) }}" required>
                </div>
                {{-- <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.customer.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email', $customer->email) }}" required>
                </div> --}}
                <div class="form-group">
                    <label class="required" for="contact">{{ trans('cruds.customer.fields.contact') }}</label>
                    <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text"
                        name="contact" id="contact" value="{{ old('contact', $customer->contact) }}" required>
                </div>
                {{-- <div class="form-group">
                    <label class="required" for="address">{{ trans('cruds.customer.fields.address') }}</label>
                    <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="5"
                        required>{{ old('address', $customer->address) }}</textarea>
                </div> --}}
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
