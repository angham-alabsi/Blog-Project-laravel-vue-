<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        return [
            'title'=>'required|max:100|min:4',
            'post'=>'required',
            'post_excerpt'=>'required',
            'category_id'=>'required',
            'tag_id'=>'required',
            'metaDescription'=>'required',
            'jsonData'=>'required',
        ];
    }
}
