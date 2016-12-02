<?php

namespace App\Http\Requests\API;

use App\Http\Requests\Request;

class RegisterRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required|max:255',
            'lastName'  => 'required|max:255',
            'email'     => 'required|email|unique:users,email|max:255',
            'password'  => 'required|max:255'
        ];
    }
}
