<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class storeBookRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(){
        return $this->merge(['title' => ucwords($this->title),
                                    'author' => ucwords($this->author),
                                    'published_at' =>date('Y-m-d',strtotime($this->published_at)),
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
            'title' => 'required|string|max:30|unique:books,title',
            'author' => 'required|string|max:30',
            'published_at' => 'required|date|date_format:Y-m-d|before_or_equal:now',
            'is_active' => 'sometimes|boolean',
            'category_id' => 'sometimes|integer|exists:categories,id', // somtimes becouse if delete this catigory
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
            'title.required' => 'Title book is required',
            'title.unique' => 'Title book should be unique, your choosing title is already taken',
            'author.required' => 'Author name is required',
            'category_id.exists' => 'Category Id should be exists in Catigories of books table',
            'is_active.boolean' => 'Status Book should be 0 or 1, 0 refers to disactive and 1 refers to active',
        ];
    }
}
