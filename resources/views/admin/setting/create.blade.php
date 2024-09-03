@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Site Configuration Settings
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.store') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-6">
                        <label class="required"
                            for="store_name">{{ trans('cruds.setting.warehouse') }}/{{ trans('cruds.setting.store_name') }}</label>
                        <input class="form-control {{ $errors->has('store_name') ? 'is-invalid' : '' }}" type="text"
                            name="store_name" id="store_name" value="{{ old('store_name', $setting->store_name ?? '') }}">
                    </div>
                    <div class="form-group col-6">
                        <label for="contact" for="whatsapp_no">{{ trans('cruds.setting.whatsapp_no') }} <small
                                class="text-muted">(Optional)</small></label>
                        <input class="form-control {{ $errors->has('whatsapp_no') ? 'is-invalid' : '' }}" type="number"
                            name="whatsapp_no" id="contact" value="{{ old('whatsapp_no', $setting->whatsapp_no ?? '') }}">
                    </div>
                    <div class="form-group col-6">
                        <label class="required" for="phone_no">{{ trans('cruds.setting.phone_no') }}</label>
                        <input class="form-control {{ $errors->has('phone_no') ? 'is-invalid' : '' }}" type="number"
                            name="phone_no" id="phone_no" value="{{ old('phone_no', $setting->phone_no ?? '') }}">
                    </div>
                    <div class="form-group col-6">
                        <label class="required" for="email">{{ trans('cruds.setting.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                            name="email" id="email" value="{{ old('email', $setting->email ?? '') }}">
                    </div>
                    <div class="form-group col-6">
                        <label class="required" for="address">{{ trans('cruds.setting.address') }}</label>
                        <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text"
                            name="address" id="address" value="{{ old('address', $setting->address ?? '') }}">
                    </div>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button class="submit btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
