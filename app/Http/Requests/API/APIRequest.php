<?php

namespace App\Http\Requests\API;

use APIException;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class APIRequest extends Request
{
    /**
     * Custom validation messages for API errors status
     *
     * @return array
     */
    public function messages() {

        return [
            'required' => 'required',
            'email'    => 'invalid',
            'min'      => 'tooShort',
            'max'      => 'tooLong',
            'numeric'  => 'notNumeric',
            'unique'   => 'duplicated',
        ];
    } 


    /**
     * Custom error messages format
     * 
     * @param  Validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {   
       return $validator->errors()->messages();
    }

    /**
     * Custom behaviour if APIRequest validation failed
     * 
     * @param  Validator
     * @return void
     */
    protected function failedValidation(Validator $validator) {
        throw new APIException(
            $this->formatErrors($validator),
            HttpResponse::HTTP_BAD_REQUEST
        );
    }
}
