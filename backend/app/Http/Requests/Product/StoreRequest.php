<?php

namespace App\Http\Requests\Product;

use App\Rules\Base64Image;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'price' => 'required|between:0,99.99',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|min:10',
            // 'description' => 'required|min:50',
            'photos' => 'required',
            'photos.*' => [new Base64Image]
        ];
    }
}
