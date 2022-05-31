<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $slug = request()->isMethod('put') ? 'required|unique:articles,slug,'.$this->id : 'required|unique:articles';
        $image = request()->isMethod('put') ? 'nullable|mimes:jpeg,jpg,png,gif,svg|max:8000' : 'required|image';

        return [
            'title' => 'required|min:5|max:255',
            'slug' => $slug,
            'introduction' => 'required|min:10|max:255',
            'body' => 'required',
            'image' => $image,
            'status' => 'required|boolean',
            'category_id' => 'required|integer',
        ];
    }
}
