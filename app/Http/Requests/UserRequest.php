<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

final class UserRequest extends FormRequest
{
    /** @return bool */
    public function authorize()
    {
        return true;
    }

    /** @return array */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id)
            ],
            'password' => 'sometimes|required|confirmed|min:6',
        ];
    }
}
