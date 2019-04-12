<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $user_id = (auth()->user()) ? auth()->user()->id : null;
        $rules = [
            'name' => 'required',
        ];
        if ($user_id == null) {
            $rules['password'] = 'required';
            $rules['email'] = 'required|email|unique:users,email';
        }
        return $rules;
    }
}
