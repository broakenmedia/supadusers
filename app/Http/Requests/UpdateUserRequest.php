<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'id' => 'required|exists:users,id|integer',
            'firstName' => 'max:255',
            'lastName' => 'max:255',
            'email' => 'max:255|unique:users,email',
            'password' => 'min:8',
            'password_confirm' => 'required_unless:password,null|same:password'
        ];
    }

    public function messages()
    {
        return [
            'password_confirm.required_unless' => 'The `password_confirm` field is required if `password` has been specified.',
            'password_confirm.same' => 'The `password` field and the `password_confirm` fields must match.',
            'id.exists' => 'The specified id does not exist.'
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param  array|mixed|null  $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['id'] = $this->route('userId');
        return $data;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->failure('Received invalid data', $validator->errors(), 422));
    }
}
