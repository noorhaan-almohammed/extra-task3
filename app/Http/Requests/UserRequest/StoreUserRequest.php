<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{

    // stop validation in the first failure
    protected $stopOnFirstFailure = true;


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
            'name' => 'required|string|max:55',
            'email' => 'required|string|email|max:30',
            'password' => 'required|string|min:8|max:30',
            'role_id' => 'nullable|integer|exists:roles,id',
        ];
    }

    /**
     *  method handles failure of Validation and return message
     * @param \Illuminate\Contracts\Validation\Validator $Validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => 'error',
                'message' => "error validation",
                'errors' => $validator->errors()
            ],
            422
        ));
    }
}
