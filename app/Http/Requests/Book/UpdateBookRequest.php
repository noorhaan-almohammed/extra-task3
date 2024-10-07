<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookRequest extends FormRequest
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
            'title' => $this->filled('title')
                ? ucwords($this->title)
                : $this->title,

            'author' => $this->filled('author')
                ? ucwords($this->author)
                : $this->author,

            'published_at' => $this->filled('published_at')
                ? date('Y-m-d', strtotime($this->published_at))
                : $this->published_at,
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
            'title' => 'nullable|string|max:30|unique:books,title',
            'author' => 'nullable|string|max:30',
            'published_at' => 'nullable|date|date_format:Y-m-d|before_or_equal:now',
            'is_active' => 'nullable|boolean',
            'category_id' => 'nullable|integer|exists:categories,id'
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
            'title.unique' => 'Title book should be unique, your choosing title is already taken',
            'category_id.exists' => 'Category Id should be exists in Catigories of books table',
            'is_active.boolean' => 'Status Book should be 0 or 1, 0 refers to disactive and 1 refers to active',
        ];
    }
}
