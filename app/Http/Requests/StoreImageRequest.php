<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @todo CONTROL BY GATE OR POLICY
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'favourite' => 'sometimes|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'image.required' => 'An image is required.',
            'image.image' => 'The uploaded file must be a valid image.',
            'image.mimes' => 'The image must be a type of: PNG, JPEG, JPG, GIF, SVG, OR WEBP.',
            'title.string' => 'The title must be a string.',
            'description.string' => 'The description must be a string.',
            'favourite.boolean' => 'Favourite status must be true or false.',
        ];
    }
}
