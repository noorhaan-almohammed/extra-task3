<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation()
    {
        return $this->merge([
            'name' => $this->filled('name')
                ? ucwords($this->name)
                : $this->name,
            'description' => $this->filled('description')
                ? ucfirst($this->description)
                : $this->description,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:30|unique:categories,name',
            'description' => 'nullable|string|max:225',
        ];
    }
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
    public function messages(): array
    {
        return [
         'name.unique' => 'Category name should be unique, your choosing Category name is already taken',
        ];
    }
}
