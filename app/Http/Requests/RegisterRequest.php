<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:25',
            'phone' => 'required|min:9|max:14',
        ];
    }

        /**
     * Get the validation errors messages that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return[
            'name.required'=> 'please enter your name',
            'name.min'=> 'Name must be at least 5 chars long',
            'name.max'=> 'Name must not be more than 150 chars long',

            'email.required'=> 'please enter your email',
            'email.email'=> 'Email must be valid',
            'email.unique'=> 'Email Already registered',

            'password.required'=> 'please enter your password',
            'password.min'=> 'Password must be at least 6 chars long',
            'password.max'=> 'Password must not be more than 25 chars long',

            'phone.required'=> 'please enter your phone number',
            'phone.min'=> 'Phone must be at least 9 digits long',
            'phone.max'=> 'Phone must not be more than 13 digits long',
        ];
    }
}
