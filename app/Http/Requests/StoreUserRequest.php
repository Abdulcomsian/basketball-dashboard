<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use App\Rules\UniqueWithoutSoftDelete;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'max:255',
                new UniqueWithoutSoftDelete('users', 'name'),
            ],
            'username' => [
                'string',
                'required',
                'max:255',
                'unique:users,username',
                new UniqueWithoutSoftDelete('users', 'username'),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
            // 'role' => [
            //     'required',
            //     'string',
            //     'in:user,admin',  // Ensures that the role is either 'user' or 'admin'
            // ],
        ];
    }
}
