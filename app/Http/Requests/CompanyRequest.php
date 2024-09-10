<?php
namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'phone' => 'required|string',
            'description' => 'required|string',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'phone.required' => 'Phone is required',
            'description.required' => 'Phone is required',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}

