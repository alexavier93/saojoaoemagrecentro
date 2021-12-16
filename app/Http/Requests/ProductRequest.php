<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'treatment_id'          => 'required',
            'category_id'           => 'required',
            'title'                 => 'required',
            'short_description'     => 'required',
            'description'           => 'required',
            'price'                 => 'required',
            'image'                 => 'required',
            'banner'                => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'  => 'Este campo é obrigatório',
        ];
    }

}
