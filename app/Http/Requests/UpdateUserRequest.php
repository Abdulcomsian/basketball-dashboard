<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Rules\UniqueWithoutSoftDelete;
use Illuminate\Foundation\Http\FormRequest;


class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8', // Ensure password is at least 8 characters long
            ],
            // 'role' => [
            //     'required',
            //     'string',
            //     'exists:roles,title',
            // ],
        ];
    }
}
