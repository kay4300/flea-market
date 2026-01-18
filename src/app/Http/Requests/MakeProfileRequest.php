<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'postcode' => 'required|integer|digits:7',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',

            //
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
