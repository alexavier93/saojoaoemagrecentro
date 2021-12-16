<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'firstname'     => 'required',
            'lastname'      => 'required',
            'birthdate'     => 'required',
            'cpf'           => 'required',
            'phone'         => 'required',
            'email'         => 'required|email:rfc',
            'password'      => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation'     => 'required|min:6',
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
            'required'  => 'O campo é obrigatório.',
            'email'     => 'Esse e-mail não é válido.',
            'min'       => 'O campo deve ter no mínimo :min caracteres.',
            'same'       => 'A senha não é igual.',
        ];
    }
}
