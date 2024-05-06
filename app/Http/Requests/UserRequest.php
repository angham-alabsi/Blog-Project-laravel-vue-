<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class UserRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'fullname'=>'required|max:100',
            'email'=>'bail|required|max:50|email|unique:users,id,'.$id  ,
            'password'=>'bail|required|min:6',
            'role_id'=>'required'
        ];
    }
}
