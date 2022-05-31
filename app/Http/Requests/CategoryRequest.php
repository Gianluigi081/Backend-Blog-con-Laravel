<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $slug = request()->isMethod('put') ? 'required|unique:categories,slug,'.$this->id : 'required|unique:categories';
        $image = request()->isMethod('put') ? 'nullable|image' : 'required|image';

        return [
            'name' => 'required|max:40',
            'slug' => $slug,
            'image' => $image,
            'is_featured' => 'required|boolean',
            'status' => 'required|boolean',
        ];
    }
}
