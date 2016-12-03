<?php

namespace App\Http\Requests\API;

use App\Http\Requests\Request;
use App\Models\Scope;

class EditScopeRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Scope::authorizeEdit($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:30',
        ];
    }
}
