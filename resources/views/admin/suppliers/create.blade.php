@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.supplier.add') }}
        </div>

        <div class="card-body">
            <form method="POST" id="add-supplier-form" action="{{ route('admin.suppliers.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name"> {{ trans('cruds.supplier.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                </div>
                {{-- <div class="form-group">
                    <label class="required" for="email"> {{ trans('cruds.supplier.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email') }}">
                </div> --}}
                <div class="form-group">
                    <label class="required" for="contact"> {{ trans('cruds.supplier.fields.contact') }}</label>
                    <input class="form-control {{ $errors->has('contact') ? 'is-invalid' : '' }}" type="text"
                        name="contact" id="contact" value="{{ old('contact', '') }}">
                </div>
                {{-- <div class="form-group">
                    <label class="required" for="address"> {{ trans('cruds.supplier.fields.address') }}</label>
                    <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="5"
                        value="{{ old('address', '') }}"></textarea>
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
